<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiAssistantTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_chat_and_gets_missing_key_message_when_unconfigured(): void
    {
        config(['ai.api_key' => null]);

        $response = $this->postJson('/ai/chat', [
            'message' => 'What is Brand Connect?',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['reply'])
            ->assertJsonPath('error', 'missing_key');
    }

    public function test_authenticated_user_gets_app_persona_reply(): void
    {
        $user = User::factory()->create(['role' => 'creator']);

        Http::fake([
            'api.groq.com/*' => Http::response([
                'choices' => [['message' => ['content' => 'You have no applications yet.']]],
            ], 200),
        ]);

        config(['ai.api_key' => 'test-key']);

        $response = $this->actingAs($user)->postJson('/ai/chat', [
            'message' => 'How many applications do I have?',
            'history' => [
                ['role' => 'user', 'content' => 'Hi'],
                ['role' => 'assistant', 'content' => 'Hello!'],
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('reply', 'You have no applications yet.')
            ->assertJsonPath('error', null);

        Http::assertSent(function ($request) {
            $payload = $request->data();
            $system = $payload['messages'][0]['content'] ?? '';

            return str_contains($system, 'personal assistant')
                && str_contains($system, 'User: ');
        });
    }

    public function test_validation_rejects_missing_message(): void
    {
        $response = $this->postJson('/ai/chat', []);

        $response->assertStatus(422);
    }

    public function test_groq_api_failure_returns_friendly_message(): void
    {
        config(['ai.api_key' => 'test-key']);

        Http::fake([
            'api.groq.com/*' => Http::response(['error' => 'boom'], 500),
        ]);

        $response = $this->postJson('/ai/chat', ['message' => 'Hello']);

        $response->assertOk()
            ->assertJsonPath('error', 'api_error');
    }
}
