<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Brand Connect') — Brand Connect</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #161c18; background: #f5f7f5; -webkit-font-smoothing: antialiased; line-height: 1.5; }
        :root { --lime:#c9ff55; --lime-strong:#a8ed2e; --purple:#7c5cff; --purple-deep:#5b3df5; --ink:#161c18; --muted:#667069; --soft:#f5f7f5; --paper:#ffffff; --dark:#101613; --dark-deep:#0e1310; --line:#e4e9e5; --sidebar-w:260px; }

        .bc-layout { display:flex; min-height:100vh; }

        .bc-sidebar { position:fixed; top:0; left:0; width:var(--sidebar-w); height:100vh; background:var(--paper); border-right:1px solid var(--line); display:flex; flex-direction:column; z-index:1000; transition:transform .25s; }
        .bc-sidebar-brand { padding:20px 20px 16px; border-bottom:1px solid var(--line); }
        .bc-sidebar-brand a { font-size:18px; font-weight:800; letter-spacing:-0.04em; color:var(--ink); text-decoration:none; display:flex; align-items:center; gap:10px; }
        .bc-sidebar-brand-icon { width:34px; height:34px; background:var(--ink); color:var(--lime); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; flex-shrink:0; }

        .bc-sidebar-nav { flex:1; overflow-y:auto; padding:12px 10px; display:flex; flex-direction:column; gap:2px; }
        .bc-sidebar-section { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--muted); padding:16px 12px 6px; }
        .bc-sidebar-link { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; font-size:14px; font-weight:600; color:var(--muted); text-decoration:none; transition:all .15s; }
        .bc-sidebar-link i { font-size:16px; width:20px; text-align:center; flex-shrink:0; }
        .bc-sidebar-link:hover { color:var(--ink); background:rgba(0,0,0,0.04); }
        .bc-sidebar-link.active { color:var(--ink); background:rgba(201,255,85,0.25); }
        .bc-sidebar-link.active i { color:var(--ink); }

        .bc-sidebar-user { padding:14px 12px; border-top:1px solid var(--line); }
        .bc-sidebar-user-info { display:flex; align-items:center; gap:10px; padding:8px 12px; border-radius:10px; text-decoration:none; color:var(--ink); transition:background .15s; }
        .bc-sidebar-user-info:hover { background:rgba(0,0,0,0.03); }
        .bc-sidebar-user-avatar { width:34px; height:34px; border-radius:10px; background:var(--ink); color:var(--lime); display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; flex-shrink:0; }
        .bc-sidebar-user-name { font-size:13px; font-weight:700; }
        .bc-sidebar-user-role { font-size:11px; color:var(--muted); }
        .bc-sidebar-logout { display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; font-size:13px; font-weight:600; color:#dc2626; background:none; border:none; width:100%; cursor:pointer; font-family:inherit; transition:background .15s; margin-top:4px; }
        .bc-sidebar-logout:hover { background:rgba(220,38,38,0.06); }

        .bc-sidebar-toggle { display:none; position:fixed; top:12px; left:12px; z-index:1100; background:var(--paper); border:1px solid var(--line); border-radius:10px; cursor:pointer; padding:10px; flex-direction:column; gap:4px; }
        .bc-sidebar-toggle:hover { box-shadow:0 2px 12px rgba(0,0,0,0.06); }
        .bc-sidebar-toggle span { width:18px; height:2px; background:var(--ink); border-radius:2px; display:block; }

        .bc-main { margin-left:var(--sidebar-w); flex:1; min-height:100vh; }
        .bc-page { padding:28px 32px 80px; min-height:100vh; }
        .bc-page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:12px; }
        .bc-page-title { font-size:clamp(24px,2.5vw,32px); font-weight:800; letter-spacing:-0.05em; color:var(--ink); }
        .bc-page-subtitle { font-size:15px; color:var(--muted); margin-top:4px; }

        .bc-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.3); z-index:999; }

        .bc-btn { display:inline-flex; align-items:center; justify-content:center; gap:6px; font-weight:650; font-size:14px; font-family:inherit; border-radius:10px; text-decoration:none; cursor:pointer; border:none; transition:all .2s; white-space:nowrap; padding:9px 18px; height:40px; }
        .bc-btn:hover { transform:translateY(-1px); }
        .bc-btn-primary { background:var(--lime); color:var(--ink); box-shadow:0 2px 12px rgba(163,220,47,0.2); }
        .bc-btn-primary:hover { background:var(--lime-strong); }
        .bc-btn-dark { background:var(--ink); color:#fff; }
        .bc-btn-dark:hover { background:#1e2a22; }
        .bc-btn-ghost { background:transparent; color:var(--ink); border:1px solid var(--line); }
        .bc-btn-ghost:hover { background:rgba(0,0,0,0.03); }
        .bc-btn-danger { background:#fee2e2; color:#dc2626; }
        .bc-btn-danger:hover { background:#fecaca; }
        .bc-btn-success { background:#dcfce7; color:#16a34a; }
        .bc-btn-success:hover { background:#bbf7d0; }
        .bc-btn-warning { background:#fef3c7; color:#d97706; }
        .bc-btn-warning:hover { background:#fde68a; }
        .bc-btn-sm { height:34px; padding:6px 14px; font-size:13px; border-radius:8px; }
        .bc-btn-lg { height:48px; padding:12px 28px; font-size:15px; border-radius:12px; }
        .bc-btn-xs { height:28px; padding:4px 10px; font-size:12px; border-radius:6px; }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible { outline:2px solid var(--purple); outline-offset:2px; }

        .bc-card { background:var(--paper); border:1px solid var(--line); border-radius:16px; padding:28px; transition:box-shadow .2s; }
        a:hover .bc-card { box-shadow:0 8px 30px rgba(0,0,0,0.04); }
        .bc-card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .bc-card-title { font-size:18px; font-weight:750; letter-spacing:-0.03em; color:var(--ink); }

        .bc-stat { background:var(--paper); border:1px solid var(--line); border-radius:14px; padding:20px; display:flex; align-items:flex-start; gap:16px; }
        .bc-stat-icon { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
        .bc-stat-icon-lime { background:#c9ff55; color:#161c18; }
        .bc-stat-icon-purple { background:#7c5cff; color:#fff; }
        .bc-stat-icon-ink { background:#161c18; color:#fff; }
        .bc-stat-value { font-size:28px; font-weight:800; letter-spacing:-0.04em; color:var(--ink); line-height:1; }
        .bc-stat-label { font-size:13px; font-weight:600; color:var(--muted); display:block; margin-top:4px; }
        .bc-stat-sub { font-size:12px; color:var(--muted); display:block; margin-top:2px; }

        .bc-table-wrap { background:var(--paper); border:1px solid var(--line); border-radius:16px; overflow-x:auto; }
        .bc-table { width:100%; min-width:640px; border-collapse:collapse; }
        .bc-table th { text-align:left; padding:14px 18px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--muted); background:var(--soft); border-bottom:1px solid var(--line); }
        .bc-table td { padding:14px 18px; font-size:14px; border-bottom:1px solid var(--line); color:var(--ink); vertical-align:middle; }
        .bc-table tr:last-child td { border-bottom:none; }
        .bc-table tr:hover td { background:rgba(0,0,0,0.015); }

        .bc-badge { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:700; }
        .bc-badge-open { background:#dcfce7; color:#16a34a; }
        .bc-badge-progress { background:#ede9fe; color:#7c3aed; }
        .bc-badge-closed { background:#f3f4f6; color:#6b7280; }
        .bc-badge-pending { background:#fef3c7; color:#d97706; }
        .bc-badge-in_progress { background:#ede9fe; color:#7c3aed; }
        .bc-badge-cancelled { background:#f3f4f6; color:#6b7280; }
        .bc-badge-accepted { background:#dcfce7; color:#16a34a; }
        .bc-badge-rejected { background:#fee2e2; color:#dc2626; }
        .bc-badge-admin { background:#fee2e2; color:#dc2626; }
        .bc-badge-brand { background:#ede9fe; color:#7c3aed; }
        .bc-badge-creator { background:#dcfce7; color:#16a34a; }
        .bc-badge-active { background:#dcfce7; color:#16a34a; }
        .bc-badge-inactive { background:#f3f4f6; color:#6b7280; }
        .bc-sr-only { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0 0 0 0); white-space:nowrap; border:0; }

        .bc-form-group { margin-bottom:20px; }
        .bc-label { display:block; font-size:13px; font-weight:700; color:var(--ink); margin-bottom:6px; letter-spacing:-0.01em; }
        .bc-input { width:100%; padding:10px 14px; font-size:14px; font-family:inherit; border:1px solid var(--line); border-radius:10px; background:var(--paper); color:var(--ink); transition:border-color .2s, box-shadow .2s; outline:none; }
        .bc-input:focus { border-color:var(--purple); box-shadow:0 0 0 3px rgba(124,92,255,0.12); }
        .bc-input-error { border-color:#f87171; }
        .bc-input-error:focus { box-shadow:0 0 0 3px rgba(248,113,113,0.15); }
        .bc-error { font-size:13px; color:#dc2626; margin-top:4px; }
        textarea.bc-input { min-height:80px; resize:vertical; }
        select.bc-input { appearance:none; background-image:url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23667069' stroke-width='1.5' fill='none'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:32px; }

        .bc-alert { padding:14px 18px; border-radius:12px; font-size:14px; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
        .bc-alert-success { background:#dcfce7; color:#16a34a; border:1px solid #bbf7d0; }
        .bc-alert-error { background:#fee2e2; color:#dc2626; border:1px solid #fecaca; }
        .bc-alert-warning { background:#fef3c7; color:#d97706; border:1px solid #fde68a; }
        .bc-alert a { font-weight:700; text-decoration:underline; }

        .bc-list { display:flex; flex-direction:column; }
        .bc-list-item { padding:16px 18px; border-bottom:1px solid var(--line); display:flex; justify-content:space-between; align-items:center; gap:12px; text-decoration:none; color:var(--ink); transition:background .15s; }
        .bc-list-item:last-child { border-bottom:none; }
        .bc-list-item:hover { background:rgba(0,0,0,0.02); }
        .bc-list-item-title { font-size:14px; font-weight:700; }
        .bc-list-item-sub { font-size:13px; color:var(--muted); margin-top:2px; }

        .bc-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .bc-grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
        .bc-grid-4 { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
        .bc-flex { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }

        .bc-campaign-card { display:flex; flex-direction:column; padding:20px; border:1px solid var(--line); border-radius:14px; text-decoration:none; color:inherit; transition:all .2s; }
        .bc-campaign-card:hover { border-color:var(--lime); box-shadow:0 4px 20px rgba(201,255,85,0.1); }
        .bc-campaign-card-body { flex:1; }
        .bc-campaign-card-title { font-size:16px; font-weight:750; letter-spacing:-0.03em; color:var(--ink); margin-bottom:8px; }
        .bc-campaign-card-meta { display:flex; flex-wrap:wrap; gap:12px; font-size:13px; color:var(--muted); margin-bottom:8px; align-items:center; }
        .bc-campaign-card-meta i { margin-right:3px; }
        .bc-campaign-card-desc { font-size:13px; color:var(--muted); line-height:1.5; }
        .bc-campaign-card-footer { display:flex; justify-content:space-between; align-items:center; margin-top:14px; padding-top:14px; border-top:1px solid var(--line); font-size:12px; color:var(--muted); }

        .bc-empty { text-align:center; padding:48px 20px; color:var(--muted); }
        .bc-empty-icon { font-size:40px; margin-bottom:12px; opacity:0.3; }
        .bc-empty-text { font-size:15px; font-weight:600; }
        .bc-empty-sub { font-size:13px; margin-top:4px; }
        .bc-empty a { color:var(--purple); font-weight:700; }

        .bc-divider { border:none; border-top:1px solid var(--line); margin:24px 0; }

        .bc-chat { display:flex; flex-direction:column; gap:12px; }
        .bc-chat-msg { max-width:70%; padding:12px 16px; border-radius:16px; font-size:14px; line-height:1.55; }
        .bc-chat-sent { align-self:flex-end; background:var(--ink); color:#fff; border-bottom-right-radius:4px; }
        .bc-chat-received { align-self:flex-start; background:var(--paper); border:1px solid var(--line); border-bottom-left-radius:4px; }
        .bc-chat-time { font-size:11px; color:var(--muted); margin-top:4px; }
        .bc-chat-sent .bc-chat-time { color:rgba(255,255,255,0.5); }
        .bc-chat-sender { font-size:12px; font-weight:700; margin-bottom:4px; }

        .bc-pagination { display:flex; gap:4px; margin-top:24px; justify-content:center; }
        .bc-pagination a, .bc-pagination span { padding:8px 14px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; color:var(--muted); background:var(--paper); border:1px solid var(--line); transition:all .15s; }
        .bc-pagination a:hover { background:var(--ink); color:#fff; border-color:var(--ink); }
        .bc-pagination .active { background:var(--ink); color:#fff; border-color:var(--ink); }

        .bc-role-cards { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .bc-role-card { border:2px solid var(--line); border-radius:14px; padding:24px; text-align:center; cursor:pointer; transition:all .2s; }
        .bc-role-card:hover { border-color:var(--purple); }
        .bc-role-card.selected { border-color:var(--purple); background:rgba(124,92,255,0.05); }
        .bc-role-card i { font-size:28px; color:var(--purple); display:block; margin-bottom:8px; }
        .bc-role-card span { font-size:14px; font-weight:700; }

        @media (max-width:820px) {
            .bc-sidebar { transform:translateX(-100%); }
            .bc-sidebar.open { transform:translateX(0); }
            .bc-sidebar-toggle { display:flex; }
            .bc-overlay.open { display:block; }
            .bc-main { margin-left:0; }
            .bc-page { padding:28px 20px 80px; padding-top:68px; }
            .bc-grid-2, .bc-grid-3, .bc-grid-4, .bc-role-cards { grid-template-columns:1fr; }
            .bc-page-header { flex-direction:column; align-items:flex-start; }
        }
        @media (prefers-reduced-motion:reduce) { * { transition:none !important; animation:none !important; } }
    </style>
</head>
<body>

<div class="bc-layout">
    <button class="bc-sidebar-toggle" id="bc-sidebar-toggle" onclick="toggleSidebar()" aria-label="Open navigation" aria-expanded="false" aria-controls="bc-sidebar">
        <span></span><span></span><span></span>
    </button>
    <div class="bc-overlay" id="bc-overlay" onclick="toggleSidebar()"></div>

    <aside class="bc-sidebar" id="bc-sidebar" aria-label="Primary">
        <div class="bc-sidebar-brand">
            <a href="{{ url('/') }}">
                <span class="bc-sidebar-brand-icon">BC</span>
                Brand Connect
            </a>
        </div>

        <nav class="bc-sidebar-nav">
            @auth
                @if (Auth::user()->isBrand())
                    <div class="bc-sidebar-section">Brand</div>
                    <a href="{{ route('dashboard') }}" class="bc-sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid" aria-hidden="true"></i> Overview
                    </a>
                    <a href="{{ route('brand.campaigns') }}" class="bc-sidebar-link {{ request()->routeIs('brand.campaigns') ? 'active' : '' }}">
                        <i class="bi bi-megaphone" aria-hidden="true"></i> My Campaigns
                    </a>
                    <a href="{{ route('campaigns.create') }}" class="bc-sidebar-link {{ request()->routeIs('campaigns.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle" aria-hidden="true"></i> Post Campaign
                    </a>
                    <a href="{{ route('messages.inbox') }}" class="bc-sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope" aria-hidden="true"></i> Messages
                    </a>
                    <a href="{{ route('deliverables.index') }}" class="bc-sidebar-link {{ request()->routeIs('deliverables.*') ? 'active' : '' }}">
                        <i class="bi bi-box" aria-hidden="true"></i> Deliverables
                    </a>
                    <a href="{{ route('brand.profile') }}" class="bc-sidebar-link {{ request()->routeIs('brand.profile') ? 'active' : '' }}">
                        <i class="bi bi-person" aria-hidden="true"></i> Profile
                    </a>
                @elseif (Auth::user()->isCreator())
                    <div class="bc-sidebar-section">Creator</div>
                    <a href="{{ route('dashboard') }}" class="bc-sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid" aria-hidden="true"></i> Overview
                    </a>
                    <a href="{{ route('campaigns.browse') }}" class="bc-sidebar-link {{ request()->routeIs('campaigns.browse') ? 'active' : '' }}">
                        <i class="bi bi-search" aria-hidden="true"></i> Opportunities
                    </a>
                    <a href="{{ route('creator.applications') }}" class="bc-sidebar-link {{ request()->routeIs('creator.applications') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text" aria-hidden="true"></i> My Applications
                    </a>
                    <a href="{{ route('messages.inbox') }}" class="bc-sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope" aria-hidden="true"></i> Messages
                    </a>
                    <a href="{{ route('deliverables.index') }}" class="bc-sidebar-link {{ request()->routeIs('deliverables.*') ? 'active' : '' }}">
                        <i class="bi bi-box" aria-hidden="true"></i> Deliverables
                    </a>
                    <a href="{{ route('reviews.show', Auth::id()) }}" class="bc-sidebar-link {{ request()->routeIs('reviews.show') ? 'active' : '' }}">
                        <i class="bi bi-star" aria-hidden="true"></i> Rating
                    </a>
                    <a href="{{ route('creator.profile') }}" class="bc-sidebar-link {{ request()->routeIs('creator.profile') ? 'active' : '' }}">
                        <i class="bi bi-person" aria-hidden="true"></i> Profile
                    </a>
                @elseif (Auth::user()->isAdmin())
                    <div class="bc-sidebar-section">Admin</div>
                    <a href="{{ route('admin.dashboard') }}" class="bc-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid" aria-hidden="true"></i> Overview
                    </a>
                    <a href="{{ route('admin.users') }}" class="bc-sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="bi bi-people" aria-hidden="true"></i> Users
                    </a>
                    <a href="{{ route('admin.campaigns') }}" class="bc-sidebar-link {{ request()->routeIs('admin.campaigns') ? 'active' : '' }}">
                        <i class="bi bi-megaphone" aria-hidden="true"></i> Campaigns
                    </a>
                    <a href="{{ route('admin.categories') }}" class="bc-sidebar-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                        <i class="bi bi-tags" aria-hidden="true"></i> Categories
                    </a>
                    <a href="{{ route('messages.inbox') }}" class="bc-sidebar-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope" aria-hidden="true"></i> Messages
                    </a>
                @endif
            @endauth
        </nav>

        @auth
        <div class="bc-sidebar-user">
            <a href="{{ Auth::user()->isCreator() ? route('creator.profile') : (Auth::user()->isBrand() ? route('brand.profile') : '#') }}" class="bc-sidebar-user-info">
                <div class="bc-sidebar-user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
                <div>
                    <div class="bc-sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="bc-sidebar-user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bc-sidebar-logout">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i> Logout
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <main class="bc-main">
        <div class="bc-page">
            @if (session('success'))
                <div class="bc-alert bc-alert-success">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bc-alert bc-alert-error">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>

<script>
function toggleSidebar(force) {
    var sidebar = document.getElementById('bc-sidebar');
    var overlay = document.getElementById('bc-overlay');
    var toggle = document.getElementById('bc-sidebar-toggle');
    var open = typeof force === 'boolean' ? force : !sidebar.classList.contains('open');
    sidebar.classList.toggle('open', open);
    overlay.classList.toggle('open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');
    if (!open) toggle.focus();
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') toggleSidebar(false);
});
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bc-role-card').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.bc-role-card').forEach(function(c) { c.classList.remove('selected'); });
            card.classList.add('selected');
            card.querySelector('input[type=radio]').checked = true;
        });
    });
    var sidebar = document.getElementById('bc-sidebar');
    sidebar.querySelectorAll('.bc-sidebar-link').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 820) {
                toggleSidebar(false);
            }
        });
    });
    document.querySelectorAll('form:not([data-ai-form])').forEach(function(form) {
        form.addEventListener('submit', function() {
            form.querySelectorAll('button[type=submit]').forEach(function(btn) { btn.disabled = true; });
        });
    });
});
</script>
@include('partials.ai-assistant')
</body>
</html>