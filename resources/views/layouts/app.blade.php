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
        :root { --lime:#c9ff55; --lime-strong:#a8ed2e; --purple:#7c5cff; --purple-deep:#5b3df5; --ink:#161c18; --muted:#667069; --soft:#f5f7f5; --paper:#ffffff; --dark:#101613; --dark-deep:#0e1310; --line:#e4e9e5; }

        .bc-nav { position:sticky; top:0; z-index:1000; height:72px; background:rgba(255,255,255,0.86); backdrop-filter:blur(18px); -webkit-backdrop-filter:blur(18px); border-bottom:1px solid rgba(228,233,229,0.6); }
        .bc-nav-inner { max-width:1180px; margin:0 auto; padding:0 max(20px,calc((100vw - 1180px)/2)); height:100%; display:flex; align-items:center; gap:32px; }
        .bc-brand { font-size:18px; font-weight:800; letter-spacing:-0.04em; color:var(--ink); text-decoration:none; display:flex; align-items:center; gap:10px; white-space:nowrap; }
        .bc-brand-icon { width:34px; height:34px; background:var(--ink); color:var(--lime); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:800; }
        .bc-nav-links { display:flex; gap:4px; flex:1; }
        .bc-nav-links a { font-size:14px; font-weight:600; color:var(--muted); text-decoration:none; padding:8px 14px; border-radius:10px; transition:all .15s; }
        .bc-nav-links a:hover, .bc-nav-links a.active { color:var(--ink); background:rgba(0,0,0,0.04); }
        .bc-nav-right { display:flex; gap:8px; align-items:center; }
        .bc-nav-toggle { display:none; background:none; border:none; cursor:pointer; padding:8px; flex-direction:column; gap:5px; }
        .bc-nav-toggle span { width:20px; height:2px; background:var(--ink); border-radius:2px; }

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

        .bc-container { max-width:1180px; margin:0 auto; padding:0 max(20px,calc((100vw - 1180px)/2)); }
        .bc-page { padding:32px 0 80px; min-height:calc(100vh - 72px); }
        .bc-page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:32px; flex-wrap:wrap; gap:12px; }
        .bc-page-title { font-size:clamp(28px,3vw,36px); font-weight:800; letter-spacing:-0.05em; color:var(--ink); }
        .bc-page-subtitle { font-size:15px; color:var(--muted); margin-top:4px; }

        .bc-card { background:var(--paper); border:1px solid var(--line); border-radius:16px; padding:28px; transition:box-shadow .2s; }
        .bc-card:hover { box-shadow:0 8px 30px rgba(0,0,0,0.04); }
        .bc-card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .bc-card-title { font-size:18px; font-weight:750; letter-spacing:-0.03em; color:var(--ink); }

        .bc-stat { background:var(--paper); border:1px solid var(--line); border-radius:14px; padding:22px; }
        .bc-stat-label { font-size:13px; font-weight:600; color:var(--muted); margin-bottom:8px; }
        .bc-stat-value { font-size:28px; font-weight:800; letter-spacing:-0.04em; color:var(--ink); }
        .bc-stat-sub { font-size:13px; color:var(--muted); margin-top:4px; }
        .bc-stat-lime { border-left:3px solid var(--lime); }
        .bc-stat-purple { border-left:3px solid var(--purple); }
        .bc-stat-dark { border-left:3px solid var(--ink); }

        .bc-table-wrap { background:var(--paper); border:1px solid var(--line); border-radius:16px; overflow:hidden; }
        .bc-table { width:100%; border-collapse:collapse; }
        .bc-table th { text-align:left; padding:14px 18px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--muted); background:var(--soft); border-bottom:1px solid var(--line); }
        .bc-table td { padding:14px 18px; font-size:14px; border-bottom:1px solid var(--line); color:var(--ink); vertical-align:middle; }
        .bc-table tr:last-child td { border-bottom:none; }
        .bc-table tr:hover td { background:rgba(0,0,0,0.015); }

        .bc-badge { display:inline-flex; align-items:center; gap:4px; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:700; }
        .bc-badge-open { background:#dcfce7; color:#16a34a; }
        .bc-badge-progress { background:#ede9fe; color:#7c3aed; }
        .bc-badge-closed { background:#f3f4f6; color:#6b7280; }
        .bc-badge-pending { background:#fef3c7; color:#d97706; }
        .bc-badge-accepted { background:#dcfce7; color:#16a34a; }
        .bc-badge-rejected { background:#fee2e2; color:#dc2626; }
        .bc-badge-admin { background:#fee2e2; color:#dc2626; }
        .bc-badge-brand { background:#ede9fe; color:#7c3aed; }
        .bc-badge-creator { background:#dcfce7; color:#16a34a; }
        .bc-badge-active { background:#dcfce7; color:#16a34a; }
        .bc-badge-inactive { background:#f3f4f6; color:#6b7280; }

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
            .bc-nav-links { display:none; position:absolute; top:72px; left:0; right:0; background:rgba(255,255,255,0.98); backdrop-filter:blur(18px); flex-direction:column; padding:16px 20px; border-bottom:1px solid var(--line); gap:4px; }
            .bc-nav-links.open { display:flex; }
            .bc-nav-toggle { display:flex; }
            .bc-grid-2, .bc-grid-3, .bc-grid-4, .bc-role-cards { grid-template-columns:1fr; }
            .bc-page-header { flex-direction:column; align-items:flex-start; }
        }
        @media (prefers-reduced-motion:reduce) { * { transition:none !important; animation:none !important; } }
    </style>
</head>
<body>

<nav class="bc-nav">
    <div class="bc-nav-inner">
        <a href="{{ url('/') }}" class="bc-brand">
            <span class="bc-brand-icon">BC</span>
            Brand Connect
        </a>
        <div class="bc-nav-links" id="bc-nav-links">
            @auth
                @if (Auth::user()->isBrand())
                    <a href="{{ route('brand.campaigns') }}" class="{{ request()->routeIs('brand.campaigns') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i> My Campaigns
                    </a>
                    <a href="{{ route('campaigns.create') }}" class="{{ request()->routeIs('campaigns.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i> Post Campaign
                    </a>
                @elseif (Auth::user()->isCreator())
                    <a href="{{ route('campaigns.browse') }}" class="{{ request()->routeIs('campaigns.browse') ? 'active' : '' }}">
                        <i class="bi bi-search"></i> Browse
                    </a>
                    <a href="{{ route('creator.applications') }}" class="{{ request()->routeIs('creator.applications') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text"></i> Applications
                    </a>
                @elseif (Auth::user()->isAdmin())
                    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Users
                    </a>
                    <a href="{{ route('admin.campaigns') }}" class="{{ request()->routeIs('admin.campaigns') ? 'active' : '' }}">
                        <i class="bi bi-megaphone"></i> Campaigns
                    </a>
                    <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Categories
                    </a>
                @endif
                <a href="{{ route('messages.inbox') }}" class="{{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="bi bi-envelope"></i> Messages
                </a>
            @endauth
        </div>
        <div class="bc-nav-right">
            @auth
                <div style="position:relative">
                    <button class="bc-btn bc-btn-ghost bc-btn-sm" onclick="this.nextElementSibling.classList.toggle('open')" style="gap:6px;">
                        <i class="bi bi-person-circle"></i> {{ Str::limit(Auth::user()->name, 15) }} <i class="bi bi-chevron-down" style="font-size:11px;"></i>
                    </button>
                    <div style="display:none; position:absolute; right:0; top:calc(100% + 6px); background:var(--paper); border:1px solid var(--line); border-radius:12px; padding:6px; min-width:180px; box-shadow:0 12px 40px rgba(0,0,0,0.1); z-index:100;" class="bc-dropdown">
                        <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; font-size:13px; font-weight:600; color:var(--ink); text-decoration:none;"><i class="bi bi-grid"></i> Dashboard</a>
                        @if (Auth::user()->isCreator())
                            <a href="{{ route('creator.profile') }}" style="display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; font-size:13px; font-weight:600; color:var(--ink); text-decoration:none;"><i class="bi bi-person"></i> My Profile</a>
                        @elseif (Auth::user()->isBrand())
                            <a href="{{ route('brand.profile') }}" style="display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; font-size:13px; font-weight:600; color:var(--ink); text-decoration:none;"><i class="bi bi-building"></i> Company Profile</a>
                        @endif
                        <hr style="border:none; border-top:1px solid var(--line); margin:4px 0;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="display:flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; font-size:13px; font-weight:600; color:#dc2626; background:none; border:none; width:100%; cursor:pointer; font-family:inherit;"><i class="bi bi-box-arrow-right"></i> Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="bc-btn bc-btn-ghost bc-btn-sm">Log in</a>
                <a href="{{ route('register') }}" class="bc-btn bc-btn-primary bc-btn-sm">Get Started</a>
            @endauth
            <button class="bc-nav-toggle" onclick="document.getElementById('bc-nav-links').classList.toggle('open')" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<div class="bc-page">
    <div class="bc-container">
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bc-dropdown').forEach(function(dd) {
        var btn = dd.previousElementSibling;
        document.addEventListener('click', function(e) {
            if (!btn.contains(e.target) && !dd.contains(e.target)) dd.classList.remove('open');
        });
    });
    document.querySelectorAll('.bc-role-card').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.bc-role-card').forEach(function(c) { c.classList.remove('selected'); });
            card.classList.add('selected');
            card.querySelector('input[type=radio]').checked = true;
        });
    });
});
</script>
</body>
</html>
