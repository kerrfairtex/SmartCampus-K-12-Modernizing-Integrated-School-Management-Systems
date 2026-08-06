@extends('layouts.landing')

@section('title', 'Home')

@section('content')
<nav class="sc-nav">
    <div class="sc-container sc-nav-inner">
        <a href="{{ url('/') }}" class="sc-logo">
            <div class="sc-logo-mark">SC</div>
            <div class="sc-logo-text">
                SmartCampus
                <small>K–12 Management System</small>
            </div>
        </a>
        <button type="button" class="sc-nav-toggle" id="scNavToggle" aria-label="Menu">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <ul class="sc-nav-links" id="scNavLinks">
            <li><a href="#transition">Digital Transition</a></li>
            <li><a href="#modules">Modules</a></li>
            <li><a href="#deped">DepEd Grading</a></li>
            @auth
                <li><a href="{{ url('/home') }}" class="sc-btn sc-btn-primary">Dashboard</a></li>
            @else
                <li><a href="{{ route('login') }}" class="sc-btn sc-btn-primary">Sign In</a></li>
            @endauth
        </ul>
    </div>
</nav>

<section class="sc-hero sc-hero-pro">
    <div class="sc-container sc-hero-pro-grid">
        <div class="sc-hero-pro-content">
            <div class="sc-hero-badge">
                <span class="sc-hero-badge-dot"></span>
                Campus Management Portal · Proactive Decision-Making
            </div>
            <h1>SmartCampus K–12</h1>
            <p class="sc-hero-tagline">Digital transition from reactive paperwork to proactive school management</p>
            <p class="sc-hero-lead">
                A DepEd-aligned Student Information System for Philippine K–12 schools — enrollment, attendance, quarterly grading, and role-based dashboards. Built for local-hosted deployment in Tawi-Tawi and low-bandwidth communities.
            </p>
            <div class="sc-hero-actions">
                @auth
                    <a href="{{ url('/home') }}" class="sc-btn sc-btn-primary">Open Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="sc-btn sc-btn-primary">Sign In to Portal</a>
                @endauth
                <a href="#modules" class="sc-btn sc-btn-outline sc-btn-on-hero">Explore Platform</a>
            </div>
            <div class="sc-hero-location">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a5 5 0 0 0-5 5c0 3.5 5 9 5 9s5-5.5 5-9a5 5 0 0 0-5-5zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                Designed for schools in Tawi-Tawi · Turtle Islands · Nationwide K–12
            </div>
        </div>
        <div class="sc-hero-pro-visual">
            <div class="sc-hero-image-wrap">
                <img src="{{ asset('images/smartcampus-hero.png') }}" alt="SmartCampus K-12 dashboard preview — enrollment, attendance, and quarterly grades" class="sc-hero-image" loading="eager">
            </div>
        </div>
    </div>
</section>

<section class="sc-trust" id="transition">
    <div class="sc-container">
        <div class="sc-transition-banner">
            <div class="sc-transition-text">
                <h2>From reactive records to proactive decisions</h2>
                <p>Replace manual enrollment ledgers, paper grade books, and scattered archives with one normalized system — SF9 report cards, quarterly WW/PT/QA grading, and real-time attendance at your school LAN.</p>
            </div>
            <div class="sc-transition-pills">
                <span>DepEd K–12</span>
                <span>Local LAN hosting</span>
                <span>Low-bandwidth UI</span>
                <span>SF9 Reports</span>
            </div>
        </div>
    </div>
</section>

<section class="sc-section" id="modules">
    <div class="sc-container">
        <div class="sc-section-header">
            <span class="sc-section-label">Six-Module Architecture</span>
            <h2>Complete campus management in one portal</h2>
            <p>Every module maps to SmartCampus K–12 requirements — from authentication through DepEd-compliant reporting.</p>
        </div>
        <div class="sc-modules">
            <article class="sc-module-card">
                <div class="sc-module-icon m1">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <h3>Authentication & Users</h3>
                <p>Seven roles — admin, teacher, student, parent, librarian, accountant, master — with secure RBAC.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m2">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <h3>Enrollment & SIS</h3>
                <p>Learner records, section assignment, Excel import/export, and demographic tracking.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m3">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <h3>Attendance</h3>
                <p>Daily section attendance, course-level tracking, and parent-visible summaries.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m4">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                </div>
                <h3>Grading & SF9</h3>
                <p>Q1–Q4 DepEd grading, transmutation, descriptors, and printable SF9 progress reports.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m5">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3>Notifications</h3>
                <p>Notices, events, messaging, and in-app alerts for the school community.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m6">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M7 16l4-8 4 5 5-9"/></svg>
                </div>
                <h3>Administration</h3>
                <p>School years, quarters, class management, and DepEd form exports.</p>
            </article>
        </div>
    </div>
</section>

<section class="sc-section sc-section-alt" id="deped">
    <div class="sc-container sc-deped-block">
        <div>
            <span class="sc-section-label">DepEd Quarterly Grading</span>
            <h2 style="font-family: var(--sc-font-display); font-size: 1.75rem; margin: 12px 0 16px;">WW · PT · QA — computed and transmuted</h2>
            <p style="color: var(--sc-text-muted);">Written Work 40%, Performance Tasks 40%, Quarterly Assessment 20%. Automatic descriptor mapping (O, VS, S, FS, D) and SF9 report generation.</p>
            <ul class="sc-deped-list">
                <li><span class="sc-deped-check">✓</span> School years with Q1–Q4 quarters</li>
                <li><span class="sc-deped-check">✓</span> Teacher score entry portal</li>
                <li><span class="sc-deped-check">✓</span> Parent portal for grades & attendance</li>
                <li><span class="sc-deped-check">✓</span> Print-ready SF9 learner progress report</li>
            </ul>
        </div>
        <div class="sc-grading-demo">
            <h4>Sample Q2 Computation</h4>
            <div class="sc-grading-row"><span>Written Work</span><strong>90.0%</strong></div>
            <div class="sc-grading-bar"><div class="sc-grading-bar-fill" style="width:90%"></div></div>
            <div class="sc-grading-row"><span>Performance Task</span><strong>85.0%</strong></div>
            <div class="sc-grading-bar"><div class="sc-grading-bar-fill" style="width:85%"></div></div>
            <div class="sc-grading-row"><span>Quarterly Assessment</span><strong>88.0%</strong></div>
            <div class="sc-grading-bar"><div class="sc-grading-bar-fill" style="width:88%"></div></div>
            <div class="sc-grading-row"><span>Transmuted Grade</span><strong>88.6 · VS</strong></div>
        </div>
    </div>
</section>

<section class="sc-cta">
    <div class="sc-container">
        <h2>Start your digital transition today</h2>
        <p>Deploy SmartCampus K–12 on your school network. No cloud dependency required.</p>
        @auth
            <a href="{{ url('/home') }}" class="sc-btn sc-btn-primary">Go to Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="sc-btn sc-btn-primary">Sign In to Portal</a>
        @endauth
    </div>
</section>

<footer class="sc-footer">
    <div class="sc-container">
        <div class="sc-footer-grid">
            <div>
                <div class="sc-logo" style="margin-bottom:12px;">
                    <div class="sc-logo-mark">SC</div>
                    <div class="sc-logo-text" style="color:#fff;">SmartCampus <small style="color:rgba(255,255,255,0.6);">K–12</small></div>
                </div>
                <p style="max-width:320px;line-height:1.6;">Modernizing integrated school management for Philippine K–12 education.</p>
            </div>
            <div>
                <h4>Platform</h4>
                <a href="#modules">Modules</a>
                <a href="#deped">DepEd Grading</a>
                <a href="{{ route('login') }}">Sign In</a>
            </div>
            <div>
                <h4>Resources</h4>
                <a href="https://github.com/kerrfairtex/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems" target="_blank" rel="noopener">GitHub</a>
            </div>
        </div>
        <div class="sc-footer-bottom">SmartCampus K–12 · GNU GPL v3.0 · Laravel</div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
(function(){
    var t=document.getElementById('scNavToggle'),l=document.getElementById('scNavLinks');
    if(t&&l)t.addEventListener('click',function(){l.classList.toggle('is-open');});
})();
</script>
@endpush
