<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brand Connect — Where Brands Meet Creators</title>
    @fonts
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif; color: #161c18; background: #ffffff; -webkit-font-smoothing: antialiased; }
    </style>
</head>
<body>

<header class="landing-nav">
    <div class="nav-inner">
        <a href="/" class="nav-brand">
            <span class="nav-brand-icon">BC</span>
            Brand Connect
        </a>
        <nav class="nav-links">
            <a href="#how-it-works">How It Works</a>
            <a href="#features">Features</a>
            <a href="#testimonials">Testimonials</a>
        </nav>
        <div class="nav-actions">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-dark btn-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Log in</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Get Started</a>
            @endauth
        </div>
        <button class="nav-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open'); document.querySelector('.nav-actions').classList.toggle('open')" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<section class="hero">
    <div class="hero-bg">
        <div class="hero-orb hero-orb-lime"></div>
        <div class="hero-orb hero-orb-purple"></div>
        <div class="hero-noise"></div>
    </div>
    <div class="container hero-content">
        <div class="hero-badge reveal">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Influencer Marketing Platform
        </div>
        <h1 class="hero-title reveal reveal-delay-1">
            Where Brands Meet<br><span class="gradient-text">Creators</span>
        </h1>
        <p class="hero-subtitle reveal reveal-delay-2">
            Connect with top content creators, launch campaigns, and grow your brand through authentic partnerships.
        </p>
        <div class="hero-cta reveal reveal-delay-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started Free</a>
                <a href="{{ route('login') }}" class="btn btn-dark btn-lg">Browse Campaigns</a>
            @endauth
        </div>

        <div class="hero-mockup reveal reveal-delay-3">
            <div class="mockup-window">
                <div class="mockup-bar">
                    <span class="mockup-dot mockup-dot-red"></span>
                    <span class="mockup-dot mockup-dot-yellow"></span>
                    <span class="mockup-dot mockup-dot-green"></span>
                    <span class="mockup-bar-title">Brand Connect — Campaign Dashboard</span>
                </div>
                <div class="mockup-body">
                    <div class="mockup-sidebar">
                        <div class="mockup-sidebar-item active"></div>
                        <div class="mockup-sidebar-item"></div>
                        <div class="mockup-sidebar-item"></div>
                        <div class="mockup-sidebar-item"></div>
                        <div class="mockup-sidebar-item"></div>
                    </div>
                    <div class="mockup-main">
                        <div class="mockup-campaign-card">
                            <div class="mockup-campaign-header">
                                <span class="mockup-tag">Fashion</span>
                                <span class="mockup-budget">Rs. 25,000</span>
                            </div>
                            <div class="mockup-campaign-title">Summer Collection Launch</div>
                            <div class="mockup-campaign-desc"></div>
                            <div class="mockup-campaign-desc short"></div>
                            <div class="mockup-campaign-footer">
                                <div class="mockup-avatar-group">
                                    <div class="mockup-avatar"></div>
                                    <div class="mockup-avatar"></div>
                                    <div class="mockup-avatar"></div>
                                </div>
                                <span class="mockup-applicants">12 applicants</span>
                            </div>
                        </div>
                        <div class="mockup-campaign-card">
                            <div class="mockup-campaign-header">
                                <span class="mockup-tag tag-blue">Tech</span>
                                <span class="mockup-budget">Rs. 40,000</span>
                            </div>
                            <div class="mockup-campaign-title">Gadget Review Series</div>
                            <div class="mockup-campaign-desc"></div>
                            <div class="mockup-campaign-desc short"></div>
                            <div class="mockup-campaign-footer">
                                <div class="mockup-avatar-group">
                                    <div class="mockup-avatar"></div>
                                    <div class="mockup-avatar"></div>
                                </div>
                                <span class="mockup-applicants">8 applicants</span>
                            </div>
                        </div>
                    </div>
                    <div class="mockup-panel">
                        <div class="mockup-panel-title">Applications</div>
                        <div class="mockup-stat-card">
                            <div class="mockup-stat-num">24</div>
                            <div class="mockup-stat-label">Pending</div>
                        </div>
                        <div class="mockup-stat-card green">
                            <div class="mockup-stat-num">18</div>
                            <div class="mockup-stat-label">Accepted</div>
                        </div>
                        <div class="mockup-stat-card">
                            <div class="mockup-stat-num">5</div>
                            <div class="mockup-stat-label">Active</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mockup-chip chip-lime">AI Powered</div>
            <div class="mockup-chip chip-purple">Real-time</div>
        </div>
    </div>
</section>

<section class="logo-strip">
    <div class="container">
        <p class="logo-strip-label reveal">Trusted by brands across</p>
        <div class="logo-strip-pills reveal reveal-delay-1">
            <span class="pill">Fashion</span>
            <span class="pill">Technology</span>
            <span class="pill">Food & Beverage</span>
            <span class="pill">Travel</span>
            <span class="pill">Beauty</span>
            <span class="pill">Fitness</span>
        </div>
    </div>
</section>

<section class="how-it-works" id="how-it-works">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">How It Works</span>
            <h2 class="section-title light">Three steps to<br><span class="lime-text">authentic</span> marketing</h2>
        </div>
        <div class="steps-grid">
            <div class="step-card reveal reveal-delay-1">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/></svg>
                </div>
                <h3 class="step-title">Brand Posts Campaign</h3>
                <p class="step-desc">Create a campaign with your budget, requirements, and target audience. Set deadlines and let creators come to you.</p>
            </div>
            <div class="step-card reveal reveal-delay-2">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                </div>
                <h3 class="step-title">Creators Apply</h3>
                <p class="step-desc">Browse matching campaigns, review requirements, and apply with your portfolio. Stand out with your unique pitch.</p>
            </div>
            <div class="step-card reveal reveal-delay-3">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/></svg>
                </div>
                <h3 class="step-title">Collaborate & Grow</h3>
                <p class="step-desc">Work together, create authentic content, build your reputation with reviews, and grow your brand presence.</p>
            </div>
        </div>
    </div>
</section>

<section class="features" id="features">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Features</span>
            <h2 class="section-title">Everything you need to<br><span class="gradient-text-purple">scale</span></h2>
        </div>
        <div class="bento-grid">
            <div class="bento-card bento-large reveal reveal-delay-1">
                <div class="bento-card-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                </div>
                <h3 class="bento-title">Campaign Marketplace</h3>
                <p class="bento-desc">Browse hundreds of campaigns filtered by category, budget, and deadline. Find the perfect match for your brand or content style.</p>
                <div class="bento-visual">
                    <div class="filter-pills">
                        <span class="filter-pill active">All</span>
                        <span class="filter-pill">Fashion</span>
                        <span class="filter-pill">Tech</span>
                        <span class="filter-pill">Food</span>
                    </div>
                    <div class="mini-cards">
                        <div class="mini-card"><div class="mini-card-bar w80"></div><div class="mini-card-bar w60"></div><div class="mini-card-bar w40"></div></div>
                        <div class="mini-card"><div class="mini-card-bar w70"></div><div class="mini-card-bar w50"></div><div class="mini-card-bar w45"></div></div>
                        <div class="mini-card"><div class="mini-card-bar w90"></div><div class="mini-card-bar w40"></div><div class="mini-card-bar w55"></div></div>
                    </div>
                </div>
            </div>
            <div class="bento-card reveal reveal-delay-2">
                <div class="bento-card-icon purple">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                </div>
                <h3 class="bento-title">Smart Messaging</h3>
                <p class="bento-desc">Built-in conversation threads between brands and creators. Discuss campaign details, share feedback, and build relationships.</p>
            </div>
            <div class="bento-card reveal reveal-delay-3">
                <div class="bento-card-icon lime">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                </div>
                <h3 class="bento-title">Reviews & Ratings</h3>
                <p class="bento-desc">Trust-building review system with star ratings. Build your reputation and make informed collaboration decisions.</p>
            </div>
        </div>
    </div>
</section>

<section class="both-sides">
    <div class="container">
        <div class="section-header reveal">
            <h2 class="section-title">Built for <span class="gradient-text-purple">both</span> sides</h2>
        </div>
        <div class="sides-grid">
            <div class="side-card reveal reveal-delay-1">
                <div class="side-header">
                    <div class="side-icon purple-bg">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                    </div>
                    <h3 class="side-title">For Creators</h3>
                </div>
                <ul class="side-list">
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9ff55" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Find campaigns that match your niche
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9ff55" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Set your own rates and availability
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9ff55" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Build a stunning portfolio profile
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9ff55" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Earn reviews and grow your reputation
                    </li>
                </ul>
            </div>
            <div class="side-card reveal reveal-delay-2">
                <div class="side-header">
                    <div class="side-icon lime-bg">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                    </div>
                    <h3 class="side-title">For Brands</h3>
                </div>
                <ul class="side-list">
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9ff55" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Post campaigns with budget and requirements
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9ff55" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Review applications and select creators
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9ff55" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Track campaign performance in real-time
                    </li>
                    <li>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#c9ff55" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Build lasting creator relationships
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="testimonials" id="testimonials">
    <div class="container">
        <div class="section-header reveal">
            <span class="eyebrow">Testimonials</span>
            <h2 class="section-title">Loved by <span class="lime-text">creators</span> and brands</h2>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card reveal reveal-delay-1">
                <div class="testimonial-quote">&ldquo;</div>
                <p class="testimonial-text">Brand Connect completely changed how I find collaborations. I used to spend hours DMing brands — now they come to me. The campaign matching is incredible.</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar" style="background: #7c5cff;">S</div>
                    <div>
                        <div class="testimonial-name">Sita Sharma</div>
                        <div class="testimonial-role">Fashion Creator, 45K followers</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card reveal reveal-delay-2">
                <div class="testimonial-quote">&ldquo;</div>
                <p class="testimonial-text">We found 8 amazing creators for our summer campaign in just 3 days. The quality of applicants and the messaging system made everything seamless.</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar" style="background: #c9ff55; color: #161c18;">A</div>
                    <div>
                        <div class="testimonial-name">Anita Patel</div>
                        <div class="testimonial-role">Marketing Lead, FreshBite Foods</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card reveal reveal-delay-3">
                <div class="testimonial-quote">&ldquo;</div>
                <p class="testimonial-text">The review system gives me credibility. Brands can see my past work and trust me instantly. I have doubled my collaboration rate since joining.</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar" style="background: #161c18; color: #c9ff55;">R</div>
                    <div>
                        <div class="testimonial-name">Raj Thapa</div>
                        <div class="testimonial-role">Tech Creator, 120K subscribers</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="cta-bg">
        <div class="cta-orb cta-orb-lime"></div>
        <div class="cta-orb cta-orb-purple"></div>
    </div>
    <div class="container cta-content">
        <h2 class="cta-title reveal">Ready to <span class="gradient-text">connect</span>?</h2>
        <p class="cta-subtitle reveal reveal-delay-1">Join hundreds of brands and creators already growing together on Brand Connect.</p>
        <div class="cta-actions reveal reveal-delay-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started Free</a>
                <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">Log in</a>
            @endauth
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="/" class="nav-brand">
                    <span class="nav-brand-icon">BC</span>
                    Brand Connect
                </a>
                <p class="footer-tagline">Connecting brands with creators for authentic marketing partnerships.</p>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Product</h4>
                <a href="#features">Features</a>
                <a href="#how-it-works">How It Works</a>
                <a href="{{ route('register') }}">For Creators</a>
                <a href="{{ route('register') }}">For Brands</a>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Company</h4>
                <a href="#">About</a>
                <a href="#">Blog</a>
                <a href="#">Careers</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Legal</h4>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookie Policy</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Brand Connect. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(function(el) { observer.observe(el); });
});
</script>

<style>
/* === VARIABLES === */
:root {
    --lime: #c9ff55;
    --lime-strong: #a8ed2e;
    --purple: #7c5cff;
    --purple-deep: #5b3df5;
    --ink: #161c18;
    --muted: #667069;
    --soft: #f5f7f5;
    --paper: #ffffff;
    --dark: #101613;
    --dark-deep: #0e1310;
    --line: #e4e9e5;
}

/* === NAV === */
.landing-nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    height: 76px;
    background: rgba(255,255,255,0.86);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border-bottom: 1px solid rgba(228,233,229,0.6);
}
.nav-inner {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 max(20px, calc((100vw - 1180px) / 2));
    height: 100%;
    display: flex;
    align-items: center;
    gap: 40px;
}
.nav-brand {
    font-size: 18px;
    font-weight: 800;
    letter-spacing: -0.04em;
    color: var(--ink);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
}
.nav-brand-icon {
    width: 34px;
    height: 34px;
    background: var(--ink);
    color: var(--lime);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: -0.02em;
}
.nav-links {
    display: flex;
    gap: 32px;
    flex: 1;
}
.nav-links a {
    font-size: 14px;
    font-weight: 600;
    color: var(--muted);
    text-decoration: none;
    transition: color 0.2s;
}
.nav-links a:hover { color: var(--ink); }
.nav-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}
.nav-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
}
.nav-toggle span {
    width: 22px;
    height: 2px;
    background: var(--ink);
    border-radius: 2px;
    transition: 0.2s;
}

/* === BUTTONS === */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 650;
    font-size: 14px;
    border-radius: 12px;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.btn:hover { transform: translateY(-2px); }
.btn-sm { padding: 8px 18px; height: 40px; }
.btn-lg { padding: 14px 32px; height: 54px; font-size: 15px; }
.btn-primary {
    background: var(--lime);
    color: var(--ink);
    box-shadow: 0 2px 12px rgba(163,220,47,0.23);
}
.btn-primary:hover { background: var(--lime-strong); }
.btn-dark {
    background: var(--ink);
    color: #fff;
}
.btn-dark:hover { background: #1e2a22; }
.btn-ghost {
    background: rgba(255,255,255,0.12);
    color: var(--ink);
    border: 1px solid var(--line);
}
.btn-ghost:hover { background: rgba(255,255,255,0.25); }

/* === HERO === */
.hero {
    position: relative;
    padding: 160px 0 80px;
    min-height: 900px;
    overflow: hidden;
}
.hero-bg {
    position: absolute;
    inset: 0;
    overflow: hidden;
}
.hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
}
.hero-orb-lime {
    width: 600px;
    height: 600px;
    background: rgba(201,255,85,0.28);
    top: -150px;
    right: -100px;
}
.hero-orb-purple {
    width: 500px;
    height: 500px;
    background: rgba(124,92,255,0.10);
    top: 50px;
    left: -150px;
}
.hero-noise {
    position: absolute;
    inset: 0;
    opacity: 0.22;
    background-image: radial-gradient(rgba(36,50,41,0.12) 0.65px, transparent 0.65px);
    background-size: 8px 8px;
    mask-image: linear-gradient(to bottom, black 60%, transparent 100%);
    -webkit-mask-image: linear-gradient(to bottom, black 60%, transparent 100%);
}
.hero-content {
    position: relative;
    text-align: center;
}
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    border-radius: 999px;
    background: rgba(255,255,255,0.7);
    border: 1px solid var(--line);
    font-size: 13px;
    font-weight: 700;
    color: var(--muted);
    letter-spacing: 0.02em;
    margin-bottom: 32px;
    backdrop-filter: blur(8px);
}
.hero-title {
    font-size: clamp(48px, 6.5vw, 88px);
    font-weight: 850;
    letter-spacing: -0.073em;
    line-height: 1.05;
    color: var(--ink);
    margin-bottom: 24px;
}
.gradient-text {
    background: linear-gradient(105deg, #6241ee, #9d54f4, #6f4df8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.gradient-text-purple {
    background: linear-gradient(105deg, #7c5cff, #a78bfa, #7c5cff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.lime-text { color: var(--lime); }
.hero-subtitle {
    font-size: clamp(17px, 1.8vw, 20px);
    color: var(--muted);
    line-height: 1.65;
    max-width: 560px;
    margin: 0 auto 40px;
}
.hero-cta {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 60px;
}

/* === MOCKUP === */
.hero-mockup {
    max-width: 900px;
    margin: 0 auto -120px;
    position: relative;
}
.mockup-window {
    background: var(--ink);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 30px 80px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.06);
}
.mockup-bar {
    height: 40px;
    background: #1a231e;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 16px;
}
.mockup-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
.mockup-dot-red { background: #ff786d; }
.mockup-dot-yellow { background: #f9bd4c; }
.mockup-dot-green { background: #55ca78; }
.mockup-bar-title {
    margin-left: 12px;
    font-size: 12px;
    color: rgba(255,255,255,0.35);
    font-weight: 500;
}
.mockup-body {
    display: grid;
    grid-template-columns: 58px 1fr 240px;
    min-height: 320px;
}
.mockup-sidebar {
    background: #131a16;
    padding: 16px 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.mockup-sidebar-item {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,0.05);
}
.mockup-sidebar-item.active {
    background: rgba(201,255,85,0.15);
    box-shadow: inset 2px 0 0 var(--lime);
}
.mockup-main {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.mockup-campaign-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px;
    padding: 16px;
}
.mockup-campaign-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.mockup-tag {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 6px;
    background: rgba(201,255,85,0.15);
    color: var(--lime);
}
.tag-blue { background: rgba(124,92,255,0.15); color: var(--purple); }
.mockup-budget {
    font-size: 14px;
    font-weight: 700;
    color: var(--lime);
}
.mockup-campaign-title {
    font-size: 15px;
    font-weight: 700;
    color: rgba(255,255,255,0.9);
    margin-bottom: 8px;
}
.mockup-campaign-desc {
    height: 8px;
    background: rgba(255,255,255,0.06);
    border-radius: 4px;
    margin-bottom: 6px;
}
.mockup-campaign-desc.short { width: 60%; }
.mockup-campaign-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 12px;
}
.mockup-avatar-group {
    display: flex;
}
.mockup-avatar {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 2px solid var(--ink);
    margin-left: -8px;
}
.mockup-avatar:first-child { margin-left: 0; background: rgba(124,92,255,0.4); }
.mockup-avatar:nth-child(2) { background: rgba(201,255,85,0.3); }
.mockup-applicants {
    font-size: 12px;
    color: rgba(255,255,255,0.35);
}
.mockup-panel {
    background: #131a16;
    padding: 20px;
    border-left: 1px solid rgba(255,255,255,0.06);
}
.mockup-panel-title {
    font-size: 13px;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    margin-bottom: 16px;
}
.mockup-stat-card {
    background: rgba(255,255,255,0.04);
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 10px;
}
.mockup-stat-card.green { border: 1px solid rgba(201,255,85,0.2); }
.mockup-stat-num {
    font-size: 24px;
    font-weight: 800;
    color: rgba(255,255,255,0.9);
    letter-spacing: -0.03em;
}
.mockup-stat-label {
    font-size: 12px;
    color: rgba(255,255,255,0.35);
    margin-top: 2px;
}
.mockup-chip {
    position: absolute;
    padding: 8px 18px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.15);
    animation: chipFloat 4s ease-in-out infinite;
}
.chip-lime {
    background: rgba(201,255,85,0.2);
    color: var(--ink);
    top: 40%;
    left: -20px;
}
.chip-purple {
    background: rgba(124,92,255,0.2);
    color: var(--purple);
    bottom: 20%;
    right: -10px;
    animation-delay: 2s;
}
@keyframes chipFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

/* === LOGO STRIP === */
.logo-strip {
    padding: 160px 0 80px;
    text-align: center;
}
.logo-strip-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--muted);
    margin-bottom: 20px;
    letter-spacing: 0.02em;
}
.logo-strip-pills {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
}
.pill {
    padding: 10px 22px;
    border-radius: 999px;
    background: var(--soft);
    border: 1px solid var(--line);
    font-size: 14px;
    font-weight: 600;
    color: var(--ink);
}

/* === SECTION COMMON === */
.container {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 max(20px, calc((100vw - 1180px) / 2));
}
.section-header {
    text-align: center;
    margin-bottom: 60px;
}
.eyebrow {
    display: inline-block;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 16px;
}
.section-title {
    font-size: clamp(36px, 4.5vw, 56px);
    font-weight: 850;
    letter-spacing: -0.06em;
    line-height: 1.1;
    color: var(--ink);
}
.section-title.light { color: #fff; }

/* === HOW IT WORKS === */
.how-it-works {
    background: var(--dark);
    padding: 120px 0;
}
.steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px;
}
.step-card {
    background: rgba(255,255,255,0.03);
    padding: 48px 36px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.06);
    position: relative;
}
.step-card:not(:last-child)::after {
    content: '';
    position: absolute;
    right: -1px;
    top: 20%;
    bottom: 20%;
    width: 1px;
    background: rgba(255,255,255,0.08);
}
.step-number {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: var(--lime);
    color: var(--ink);
    font-size: 20px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
}
.step-icon {
    color: rgba(255,255,255,0.5);
    margin-bottom: 20px;
}
.step-title {
    font-size: 20px;
    font-weight: 750;
    color: #fff;
    letter-spacing: -0.03em;
    margin-bottom: 12px;
}
.step-desc {
    font-size: 15px;
    color: rgba(255,255,255,0.45);
    line-height: 1.6;
}

/* === FEATURES === */
.features {
    padding: 120px 0;
    background: var(--paper);
}
.bento-grid {
    display: grid;
    grid-template-columns: 1.25fr 0.75fr;
    grid-template-rows: auto auto;
    gap: 20px;
}
.bento-large {
    grid-row: 1 / 3;
}
.bento-card {
    background: var(--soft);
    border: 1px solid var(--line);
    border-radius: 24px;
    padding: 36px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.bento-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.06);
}
.bento-card-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: var(--paper);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--purple);
    margin-bottom: 24px;
}
.bento-card-icon.purple { color: var(--purple); }
.bento-card-icon.lime { color: var(--purple-deep); }
.bento-title {
    font-size: 22px;
    font-weight: 750;
    color: var(--ink);
    letter-spacing: -0.04em;
    margin-bottom: 10px;
}
.bento-desc {
    font-size: 15px;
    color: var(--muted);
    line-height: 1.6;
}
.bento-visual {
    margin-top: 28px;
}
.filter-pills {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
}
.filter-pill {
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
    background: var(--paper);
    border: 1px solid var(--line);
}
.filter-pill.active {
    background: var(--ink);
    color: #fff;
    border-color: var(--ink);
}
.mini-cards {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.mini-card {
    background: var(--paper);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.mini-card-bar {
    height: 8px;
    border-radius: 4px;
    background: rgba(0,0,0,0.06);
}
.mini-card-bar.w90 { width: 90%; }
.mini-card-bar.w80 { width: 80%; }
.mini-card-bar.w70 { width: 70%; }
.mini-card-bar.w60 { width: 60%; }
.mini-card-bar.w55 { width: 55%; }
.mini-card-bar.w50 { width: 50%; }
.mini-card-bar.w45 { width: 45%; }
.mini-card-bar.w40 { width: 40%; }

/* === BOTH SIDES === */
.both-sides {
    padding: 120px 0;
    background: var(--soft);
}
.sides-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
.side-card {
    background: var(--paper);
    border: 1px solid var(--line);
    border-radius: 24px;
    padding: 40px;
}
.side-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
}
.side-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.purple-bg { background: rgba(124,92,255,0.12); color: var(--purple); }
.lime-bg { background: rgba(201,255,85,0.2); color: var(--ink); }
.side-title {
    font-size: 22px;
    font-weight: 750;
    letter-spacing: -0.04em;
    color: var(--ink);
}
.side-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.side-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 15px;
    color: var(--ink);
    font-weight: 500;
}

/* === TESTIMONIALS === */
.testimonials {
    padding: 120px 0;
    background: var(--paper);
}
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.testimonial-card {
    background: var(--soft);
    border: 1px solid var(--line);
    border-radius: 24px;
    padding: 36px;
    transition: transform 0.2s ease;
}
.testimonial-card:hover { transform: translateY(-3px); }
.testimonial-quote {
    font-size: 60px;
    font-family: Georgia, 'Times New Roman', serif;
    color: var(--purple);
    line-height: 1;
    margin-bottom: 4px;
}
.testimonial-text {
    font-size: 15px;
    color: var(--ink);
    line-height: 1.65;
    margin-bottom: 24px;
}
.testimonial-author {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-top: 20px;
    border-top: 1px solid var(--line);
}
.testimonial-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 800;
    color: #fff;
    flex-shrink: 0;
}
.testimonial-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
}
.testimonial-role {
    font-size: 13px;
    color: var(--muted);
    margin-top: 2px;
}

/* === CTA === */
.cta-section {
    position: relative;
    background: var(--dark);
    padding: 120px 0;
    overflow: hidden;
    text-align: center;
}
.cta-bg {
    position: absolute;
    inset: 0;
}
.cta-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
}
.cta-orb-lime {
    width: 400px;
    height: 400px;
    background: rgba(201,255,85,0.12);
    top: -100px;
    left: 20%;
}
.cta-orb-purple {
    width: 350px;
    height: 350px;
    background: rgba(124,92,255,0.10);
    bottom: -80px;
    right: 20%;
}
.cta-content {
    position: relative;
}
.cta-title {
    font-size: clamp(36px, 4.5vw, 56px);
    font-weight: 850;
    letter-spacing: -0.06em;
    color: #fff;
    margin-bottom: 16px;
}
.cta-subtitle {
    font-size: 18px;
    color: rgba(255,255,255,0.45);
    max-width: 480px;
    margin: 0 auto 40px;
    line-height: 1.6;
}
.cta-actions {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-section .btn-ghost {
    background: transparent;
    color: rgba(255,255,255,0.8);
    border: 1px solid rgba(255,255,255,0.2);
}
.cta-section .btn-ghost:hover {
    background: rgba(255,255,255,0.08);
}

/* === FOOTER === */
.footer {
    background: var(--dark-deep);
    padding: 80px 0 40px;
}
.footer-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1fr;
    gap: 48px;
    margin-bottom: 48px;
}
.footer-tagline {
    font-size: 14px;
    color: rgba(255,255,255,0.35);
    line-height: 1.6;
    margin-top: 16px;
    max-width: 260px;
}
.footer-col {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.footer-heading {
    font-size: 14px;
    font-weight: 700;
    color: rgba(255,255,255,0.6);
    margin-bottom: 4px;
}
.footer-col a {
    font-size: 14px;
    color: rgba(255,255,255,0.35);
    text-decoration: none;
    transition: color 0.2s;
}
.footer-col a:hover { color: rgba(255,255,255,0.7); }
.footer-bottom {
    padding-top: 32px;
    border-top: 1px solid rgba(255,255,255,0.06);
    text-align: center;
}
.footer-bottom p {
    font-size: 13px;
    color: rgba(255,255,255,0.25);
}
.footer .nav-brand { color: #fff; }

/* === ANIMATIONS === */
.reveal {
    opacity: 0;
    transform: translateY(18px);
    transition: opacity 0.65s ease-out, transform 0.65s ease-out;
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}
.reveal-delay-1 { transition-delay: 0.08s; }
.reveal-delay-2 { transition-delay: 0.16s; }
.reveal-delay-3 { transition-delay: 0.24s; }

/* === RESPONSIVE === */
@media (max-width: 1050px) {
    .bento-grid { grid-template-columns: 1fr; }
    .bento-large { grid-row: auto; }
    .mockup-body { grid-template-columns: 1fr; }
    .mockup-sidebar, .mockup-panel { display: none; }
}
@media (max-width: 820px) {
    .nav-links, .nav-actions { display: none; }
    .nav-links.open, .nav-actions.open {
        display: flex;
        position: absolute;
        top: 76px;
        left: 0;
        right: 0;
        background: rgba(255,255,255,0.98);
        backdrop-filter: blur(18px);
        flex-direction: column;
        padding: 20px;
        border-bottom: 1px solid var(--line);
        gap: 12px;
    }
    .nav-toggle { display: flex; }
    .hero { min-height: auto; padding: 140px 0 60px; }
    .hero-mockup { margin-bottom: -40px; }
    .steps-grid { grid-template-columns: 1fr; }
    .step-card:not(:last-child)::after { display: none; }
    .sides-grid { grid-template-columns: 1fr; }
    .testimonials-grid { grid-template-columns: 1fr; }
    .footer-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 560px) {
    .hero-cta { flex-direction: column; align-items: center; }
    .hero-cta .btn { width: 100%; }
    .cta-actions { flex-direction: column; align-items: center; }
    .cta-actions .btn { width: 100%; }
    .footer-grid { grid-template-columns: 1fr; gap: 32px; }
    .hero-badge { font-size: 12px; }
}

@media (prefers-reduced-motion: reduce) {
    .reveal { opacity: 1; transform: none; transition: none; }
    .mockup-chip { animation: none; }
}
</style>
</body>
</html>
