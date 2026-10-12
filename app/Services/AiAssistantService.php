<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class AiAssistantService
{
    public function respond(string $message, array $history = [], ?User $user = null): array
    {
        $context = $this->buildContext($user);
        $persona = $user ? 'app' : 'public';

        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt($persona, $context)],
        ];

        foreach (array_slice($history, -config('ai.max_history_turns', 10)) as $turn) {
            if (! is_array($turn)) {
                continue;
            }

            $role = $turn['role'] ?? null;
            if (! in_array($role, ['user', 'assistant'], true)) {
                continue;
            }

            $messages[] = [
                'role' => $role,
                'content' => substr((string) ($turn['content'] ?? ''), 0, 2000),
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $message];

        return $this->callGroq($messages);
    }

    private function systemPrompt(string $persona, string $context): string
    {
        $base = config('ai.system_prompts.'.$persona, config('ai.system_prompts.public'));

        return $base."\n\n## Current data\n".$context;
    }

    private function buildContext(?User $user): string
    {
        if (! $user) {
            $campaigns = Campaign::with('category')
                ->where('status', 'open')
                ->latest()
                ->take(10)
                ->get()
                ->map(fn (Campaign $c) => "- {$c->title} — budget \${$c->budget} — category: ".($c->category?->name ?? 'Uncategorized'))
                ->implode("\n");

            $categories = Category::pluck('name')->implode(', ');

            return "Open campaigns:\n".($campaigns ?: '- none currently')."\n\nPlatform categories: ".($categories ?: '- none');
        }

        $lines = ["User: {$user->name} (role: {$user->role})"];

        if ($user->isAdmin()) {
            $lines[] = 'Platform totals: users = '.User::count()
                .', campaigns = '.Campaign::count()
                .', applications = '.CampaignApplication::count();
        } elseif ($user->isBrand()) {
            $campaigns = Campaign::where('brand_id', $user->id)->get();
            $lines[] = 'Your campaigns (total '.$campaigns->count().'):';

            if ($campaigns->isEmpty()) {
                $lines[] = '- none yet';
            }

            foreach ($campaigns as $campaign) {
                $lines[] = "- {$campaign->title} [{$campaign->status}] budget \${$campaign->budget}, applications: {$campaign->applications()->count()}";
            }
        } elseif ($user->isCreator()) {
            $applications = CampaignApplication::where('creator_id', $user->id)
                ->with('campaign')
                ->latest()
                ->get();

            $lines[] = 'Your applications (total '.$applications->count().'):';

            if ($applications->isEmpty()) {
                $lines[] = '- none yet';
            }

            foreach ($applications as $application) {
                $lines[] = "- {$application->campaign?->title} [{$application->status}]";
            }
        }

        return implode("\n", $lines);
    }

    private function callGroq(array $messages): array
    {
        if (! config('ai.enabled') || ! config('ai.api_key')) {
            return [
                'reply' => 'The AI assistant is not configured yet. Please add GROQ_API_KEY to your .env file.',
                'error' => 'missing_key',
            ];
        }

        try {
            $response = Http::withToken(config('ai.api_key'))
                ->timeout(30)
                ->post(config('ai.endpoint'), [
                    'model' => config('ai.model'),
                    'messages' => $messages,
                    'temperature' => config('ai.temperature'),
                    'max_tokens' => config('ai.max_tokens'),
                ]);

            $data = $response->json();

            if ($response->failed()) {
                return [
                    'reply' => "I couldn't reach the AI service right now. Please try again in a moment.",
                    'error' => 'api_error',
                ];
            }

            return [
                'reply' => $data['choices'][0]['message']['content'] ?? "Sorry, I didn't catch that. Could you rephrase?",
                'error' => null,
            ];
        } catch (\Throwable) {
            return [
                'reply' => "I'm having trouble connecting right now. Please try again in a moment.",
                'error' => 'exception',
            ];
        }
    }
}
