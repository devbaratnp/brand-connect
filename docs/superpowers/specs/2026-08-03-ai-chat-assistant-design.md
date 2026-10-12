# Design: Dual AI Chat Assistant

Date: 2026-08-03

## Overview

Brand Connect gains an AI-powered chat assistant powered by Groq (an OpenAI-compatible
LLM API). Two personas serve two audiences:

1. **Public Assistant** — shown on the landing page for unauthenticated visitors. Answers
   general platform questions ("What is Brand Connect?", "How do I join as a creator?",
   "What does it cost?", "How do brand collaborations work?") using public platform
   information and public campaign data.
2. **App Assistant** — shown on every authenticated page via a floating widget. Answers
   questions about the logged-in user's real data: campaign statuses, application
   pipeline, stats, and suggested next steps.

## Scope

In scope:
- Groq-backed chat endpoint working for both authenticated and unauthenticated users.
- Context building from real data per persona.
- A reusable floating chat widget mounted on the landing page and the auth layout.
- Configuration via `.env` (`GROQ_API_KEY`) and `config/ai.php`.

Out of scope:
- SMS / push notifications.
- Persisting conversation history in the database (history is client-side only).
- Streaming responses (single completion per request is sufficient for the demo).

## Architecture

- `config/ai.php` — Groq endpoint, model, temperature, token limits, and the two system
  prompts (public / app persona).
- `app/Services/AiAssistantService.php` — single entry point:
  - `respond(string $message, array $history, ?User $user): array` — builds the system
    prompt, assembles context, calls the Groq Chat Completions API, returns the reply.
  - `buildContext(?User $user): string` — returns a compact JSON/text summary of either
    public platform/campaign data or the authenticated user's real data.
- `app/Http/Controllers/AiController.php` — `POST /ai/chat` route, auth-aware (no
  middleware group; checks `auth()->user()`). Validates input, delegates to the service,
  returns `{ reply: string }`. Friendly error response if the API key is missing or Groq
  fails.
- Widget UI:
  - `resources/views/partials/ai-assistant.blade.php` — floating chat button + panel.
  - `resources/js/ai-assistant.js` — widget behavior, history management, fetch calls,
    Vite-bundled.
  - Mounted on `landing.blade.php` (public) and the authenticated layout (app).
  - Styled to the Brand Connect design system (ink/lime/purple, flat surfaces, 16px radii).

## Data Flow

1. User clicks the floating button; the panel opens.
2. User sends a message; JS keeps a client-side history array.
3. JS POSTs `{ message, history }` to `/ai/chat`.
4. Server detects whether the user is authenticated:
   - Unauthenticated → public persona + public campaign/category context.
   - Authenticated → app persona + the user's campaigns, applications, and stats.
5. The service sends the assembled prompt to Groq (`llama-3.3-70b-versatile`).
6. The reply is returned as JSON and rendered into the panel.

## Error Handling

- Missing `GROQ_API_KEY` → `{ reply: "The AI assistant is not configured yet. Please add
  GROQ_API_KEY to .env." }` with a non-500 status.
- Groq API failure / timeout → friendly fallback message, no exception surfaced to the
  client.
- Empty or over-long messages rejected by validation.

## Security

- Route is CSRF-protected via the `web` middleware group.
- Input length limited (max ~2000 chars).
- No secrets are exposed to the client; the API key lives only server-side.
- Authenticated context is scoped strictly to the current user's own records.

## Testing

- Manual smoke test: public chat on the landing page; app chat on dashboard.
- Feature test: `/ai/chat` returns a structured reply shape; unauthenticated vs
  authenticated context selection; graceful failure when the key is absent.

## Config

```
GROQ_API_KEY=...
```

Add to `.env`. `config/ai.php` defaults are fine for the demo.
