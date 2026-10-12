<?php

namespace App\Http\Controllers;

use App\Services\AiAssistantService;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function chat(Request $request, AiAssistantService $service)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'history' => ['sometimes', 'array'],
        ]);

        $history = collect($validated['history'] ?? [])
            ->filter(fn ($turn) => is_array($turn) && in_array($turn['role'] ?? null, ['user', 'assistant'], true))
            ->map(fn ($turn) => [
                'role' => $turn['role'],
                'content' => substr((string) ($turn['content'] ?? ''), 0, 2000),
            ])
            ->values()
            ->all();

        $result = $service->respond($validated['message'], $history, auth()->user());

        return response()->json($result);
    }
}
