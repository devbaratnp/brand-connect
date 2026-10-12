{{-- AI Chat Assistant widget — works on landing (public) and app (authenticated) layouts. --}}
<div class="ai-widget" data-ai-widget data-persona="{{ auth()->check() ? 'app' : 'public' }}">
    <button type="button" class="ai-widget-toggle" data-ai-toggle aria-label="Open AI assistant">
        <svg class="ai-widget-toggle-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3l1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9L12 3z"/>
            <path d="M19 15l.9 2.4L22 18.3l-2.1.9L19 21.6l-.9-2.4L16 18.3l2.1-.9L19 15z"/>
        </svg>
        <svg class="ai-widget-close-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M6 6l12 12M18 6L6 18"/>
        </svg>
    </button>

    <div class="ai-panel" data-ai-panel role="dialog" aria-label="AI assistant chat">
        <div class="ai-panel-header">
            <div class="ai-panel-heading">
                <span class="ai-panel-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3l1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9L12 3z"/>
                    </svg>
                </span>
                <div>
                    <div class="ai-panel-title">Brand Connect AI</div>
                    <div class="ai-panel-status"><span class="ai-dot"></span> @auth Ask about your campaigns &amp; stats @else Ask about Brand Connect @endauth</div>
                </div>
            </div>
            <button type="button" class="ai-panel-close" data-ai-toggle aria-label="Close AI assistant">&times;</button>
        </div>

        <div class="ai-panel-messages" data-ai-messages>
            <div class="ai-msg ai-msg-assistant">
                <span class="ai-msg-bubble">
                    @auth
                        Hi {{ auth()->user()->name }}! I can help you with your campaigns, applications, and stats. What would you like to know?
                    @else
                        Hi there! I'm the Brand Connect assistant. Ask me how the platform works, how to join, or what campaigns are open.
                    @endauth
                </span>
            </div>
        </div>

        <div class="ai-panel-input">
            <form data-ai-form>
                <input type="text" class="ai-input" data-ai-input placeholder="@auth Ask about your data... @else Ask about Brand Connect... @endauth" maxlength="2000" autocomplete="off">
                <button type="submit" class="ai-send" aria-label="Send message">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .ai-widget { position: fixed; bottom: 20px; right: 20px; z-index: 2000; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; }

    .ai-widget-toggle { width: 56px; height: 56px; border-radius: 16px; border: none; cursor: pointer; background: var(--lime, #c9ff55); color: var(--ink, #161c18); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 30px rgba(0,0,0,0.18); transition: all .2s; }
    .ai-widget-toggle:hover { background: var(--lime-strong, #a8ed2e); transform: translateY(-2px); }
    .ai-widget-close-icon { display: none; }
    .ai-widget.open .ai-widget-toggle-icon { display: none; }
    .ai-widget.open .ai-widget-close-icon { display: block; }

    .ai-panel { display: none; position: fixed; bottom: 92px; right: 20px; width: 380px; max-width: calc(100vw - 40px); height: 520px; max-height: calc(100vh - 120px); background: var(--paper, #ffffff); border: 1px solid var(--line, #e4e9e5); border-radius: 16px; box-shadow: 0 12px 40px rgba(0,0,0,0.1); flex-direction: column; overflow: hidden; }
    .ai-widget.open .ai-panel { display: flex; }

    .ai-panel-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: var(--ink, #161c18); color: #fff; }
    .ai-panel-heading { display: flex; align-items: center; gap: 10px; }
    .ai-panel-badge { width: 32px; height: 32px; border-radius: 10px; background: var(--lime, #c9ff55); color: var(--ink, #161c18); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ai-panel-title { font-size: 14px; font-weight: 750; letter-spacing: -0.02em; }
    .ai-panel-status { font-size: 11px; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 5px; margin-top: 1px; }
    .ai-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--lime, #c9ff55); display: inline-block; }
    .ai-panel-close { background: none; border: none; color: rgba(255,255,255,0.8); font-size: 22px; line-height: 1; cursor: pointer; padding: 0 2px; }
    .ai-panel-close:hover { color: #fff; }

    .ai-panel-messages { flex: 1; overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 10px; background: var(--soft, #f5f7f5); }
    .ai-msg { display: flex; }
    .ai-msg-user { justify-content: flex-end; }
    .ai-msg-bubble { max-width: 78%; padding: 10px 14px; border-radius: 14px; font-size: 13.5px; line-height: 1.5; white-space: pre-wrap; word-break: break-word; }
    .ai-msg-user .ai-msg-bubble { background: var(--ink, #161c18); color: #fff; border-bottom-right-radius: 4px; }
    .ai-msg-assistant .ai-msg-bubble { background: var(--paper, #ffffff); border: 1px solid var(--line, #e4e9e5); border-bottom-left-radius: 4px; color: var(--ink, #161c18); }
    .ai-msg-assistant .ai-msg-bubble a { color: var(--purple, #7c5cff); font-weight: 600; }
    .ai-typing .ai-msg-bubble { color: var(--muted, #667069); }

    .ai-panel-input { padding: 12px; border-top: 1px solid var(--line, #e4e9e5); background: var(--paper, #ffffff); }
    .ai-panel-input form { display: flex; gap: 8px; }
    .ai-input { flex: 1; padding: 10px 14px; font-size: 14px; font-family: inherit; border: 1px solid var(--line, #e4e9e5); border-radius: 10px; background: var(--paper, #ffffff); color: var(--ink, #161c18); outline: none; transition: border-color .2s, box-shadow .2s; }
    .ai-input:focus { border-color: var(--purple, #7c5cff); box-shadow: 0 0 0 3px rgba(124,92,255,0.12); }
    .ai-send { width: 42px; height: 42px; border-radius: 10px; border: none; cursor: pointer; background: var(--ink, #161c18); color: #fff; display: flex; align-items: center; justify-content: center; transition: background .2s; flex-shrink: 0; }
    .ai-send:hover { background: var(--purple, #7c5cff); }
    .ai-send:disabled { opacity: 0.5; cursor: not-allowed; }

    @media (max-width: 560px) {
        .ai-panel { right: 12px; left: 12px; width: auto; }
        .ai-widget-toggle { bottom: 12px; right: 12px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ai-widget-toggle, .ai-widget-toggle:hover { transform: none; }
    }
</style>

<script>
(function () {
    var widget = document.querySelector('[data-ai-widget]');
    if (!widget) return;

    var toggle = widget.querySelector('[data-ai-toggle]');
    var panel = widget.querySelector('[data-ai-panel]');
    var messagesEl = widget.querySelector('[data-ai-messages]');
    var form = widget.querySelector('[data-ai-form]');
    var input = widget.querySelector('[data-ai-input]');
    var history = [];
    var csrfToken = "{{ csrf_token() }}";

    function appendMessage(text, role) {
        var el = document.createElement('div');
        el.className = 'ai-msg ai-msg-' + role;
        var bubble = document.createElement('span');
        bubble.className = 'ai-msg-bubble';
        bubble.textContent = text;
        el.appendChild(bubble);
        messagesEl.appendChild(el);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return el;
    }

    toggle.addEventListener('click', function () {
        widget.classList.toggle('open');
        if (widget.classList.contains('open')) input.focus();
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var text = input.value.trim();
        if (!text) return;

        input.value = '';
        appendMessage(text, 'user');
        history.push({ role: 'user', content: text });

        var typing = appendMessage('Thinking…', 'assistant');
        typing.classList.add('ai-typing');

        var sendBtn = form.querySelector('.ai-send');
        sendBtn.disabled = true;

        fetch('{{ route('ai.chat') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: text, history: history })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            typing.remove();
            var reply = data.reply || "Sorry, I couldn't process that. Please try again.";
            appendMessage(reply, 'assistant');
            history.push({ role: 'assistant', content: reply });
        })
        .catch(function () {
            typing.remove();
            appendMessage("I'm having trouble connecting right now. Please try again in a moment.", 'assistant');
        })
        .finally(function () {
            sendBtn.disabled = false;
            input.focus();
        });
    });
})();
</script>
