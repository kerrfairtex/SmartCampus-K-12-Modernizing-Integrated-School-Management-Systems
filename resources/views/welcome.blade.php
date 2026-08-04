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

        <button type="button" class="sc-nav-toggle" id="scNavToggle" aria-label="Toggle menu">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <ul class="sc-nav-links" id="scNavLinks">
            <li><a href="#modules">Modules</a></li>
            <li><a href="#deped">DepEd Grading</a></li>
            <li><a href="#roles">Roles</a></li>
            @auth
                <li><a href="{{ url('/home') }}" class="sc-btn sc-btn-primary">Dashboard</a></li>
            @else
                <li><a href="{{ route('login') }}" class="sc-btn sc-btn-primary">Sign In</a></li>
            @endauth
        </ul>
    </div>
</nav>

<section class="sc-hero">
    <div class="sc-container sc-hero-grid">
        <div class="sc-hero-content">
            <div class="sc-hero-badge">
                <span class="sc-hero-badge-dot"></span>
                DepEd-aligned · Local-hosted · Built for Philippine K–12
            </div>
            <h1>Modern school management for Tawi-Tawi and beyond</h1>
            <p class="sc-hero-lead">
                SmartCampus K–12 unifies enrollment, attendance, quarterly DepEd grading, and role-based dashboards in one Laravel platform designed for low-bandwidth, on-premise deployment.
            </p>
            <div class="sc-hero-actions">
                @auth
                    <a href="{{ url('/home') }}" class="sc-btn sc-btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="sc-btn sc-btn-primary">Sign In to Portal</a>
                @endauth
                <a href="#modules" class="sc-btn sc-btn-ghost">Explore Modules</a>
            </div>
            <div class="sc-hero-stats">
                <div class="sc-hero-stat">
                    <strong>6</strong>
                    <span>Core modules</span>
                </div>
                <div class="sc-hero-stat">
                    <strong>Q1–Q4</strong>
                    <span>Quarterly grading</span>
                </div>
                <div class="sc-hero-stat">
                    <strong>6</strong>
                    <span>User roles</span>
                </div>
            </div>
        </div>

        <div class="sc-hero-visual">
            <div class="sc-dashboard-preview">
                <div class="sc-dashboard-header">
                    <span class="sc-dashboard-dot red"></span>
                    <span class="sc-dashboard-dot yellow"></span>
                    <span class="sc-dashboard-dot green"></span>
                    <span class="sc-dashboard-title">SmartCampus Dashboard — Grade 10 · Section A</span>
                </div>
                <div class="sc-dashboard-body">
                    <div class="sc-dash-cards">
                        <div class="sc-dash-card blue">
                            <strong>248</strong>
                            Students
                        </div>
                        <div class="sc-dash-card green">
                            <strong>94%</strong>
                            Attendance
                        </div>
                        <div class="sc-dash-card gold">
                            <strong>Q2</strong>
                            Active Quarter
                        </div>
                    </div>
                    <table class="sc-dash-table">
                        <thead>
                            <tr>
                                <th>Learner</th>
                                <th>Subject</th>
                                <th>Grade</th>
                                <th>Descriptor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>M. Hassan</td>
                                <td>Mathematics</td>
                                <td>88.6</td>
                                <td><span class="sc-grade-badge vs">VS</span></td>
                            </tr>
                            <tr>
                                <td>A. Sali</td>
                                <td>English</td>
                                <td>92.4</td>
                                <td><span class="sc-grade-badge o">O</span></td>
                            </tr>
                            <tr>
                                <td>F. Ibrahim</td>
                                <td>Science</td>
                                <td>85.2</td>
                                <td><span class="sc-grade-badge vs">VS</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sc-trust">
    <div class="sc-container sc-trust-grid">
        <div class="sc-trust-item">
            <div class="sc-trust-icon">✓</div>
            DepEd K–12 workflows
        </div>
        <div class="sc-trust-item">
            <div class="sc-trust-icon">◉</div>
            Local LAN deployment
        </div>
        <div class="sc-trust-item">
            <div class="sc-trust-icon">⚡</div>
            Low-bandwidth optimized
        </div>
        <div class="sc-trust-item">
            <div class="sc-trust-icon">🔒</div>
            Role-based access control
        </div>
    </div>
</section>

<section class="sc-section" id="modules">
    <div class="sc-container">
        <div class="sc-section-header">
            <span class="sc-section-label">Six-Module Architecture</span>
            <h2>Everything your school needs in one system</h2>
            <p>Structured around SmartCampus K–12 modules — from enrollment to DepEd-compliant reporting.</p>
        </div>

        <div class="sc-modules">
            <article class="sc-module-card">
                <div class="sc-module-icon m1">👤</div>
                <h3>Authentication & Users</h3>
                <p>Secure login, six role types, impersonation for admins, and password management across the school community.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m2">📋</div>
                <h3>Enrollment & SIS</h3>
                <p>Student records, section assignment, Excel import/export, and complete learner demographic tracking.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m3">✓</div>
                <h3>Attendance</h3>
                <p>Daily section attendance, course-level tracking, adjustments, and teacher-facing capture workflows.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m4">📊</div>
                <h3>Grading & Report Cards</h3>
                <p>Quarterly WW/PT/QA computation, DepEd transmutation, descriptors, and SF9 report card generation.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m5">💬</div>
                <h3>Notifications & Messaging</h3>
                <p>School notices, events, in-app notifications, and teacher–student messaging with rich text.</p>
            </article>
            <article class="sc-module-card">
                <div class="sc-module-icon m6">📁</div>
                <h3>Administration & Reports</h3>
                <p>School settings, class and section management, DepEd forms (SF1–SF10), and exportable reports.</p>
            </article>
        </div>
    </div>
</section>

<section class="sc-section sc-section-alt" id="deped">
    <div class="sc-container sc-deped-block">
        <div>
            <span class="sc-section-label">Phase 2 · DepEd Core</span>
            <h2 style="font-family: var(--sc-font-display); font-size: 1.75rem; margin: 12px 0 16px;">Philippine quarterly grading built in</h2>
            <p style="color: var(--sc-text-muted); margin: 0;">Written Work (40%), Performance Tasks (40%), and Quarterly Assessment (20%) — computed, transmuted, and mapped to DepEd descriptors automatically.</p>
            <ul class="sc-deped-list">
                <li>
                    <span class="sc-deped-check">✓</span>
                    Q1–Q4 school year quarters with weighted component scores
                </li>
                <li>
                    <span class="sc-deped-check">✓</span>
                    Configurable transmutation tables per school
                </li>
                <li>
                    <span class="sc-deped-check">✓</span>
                    Descriptors: O, VS, S, FS, D
                </li>
                <li>
                    <span class="sc-deped-check">✓</span>
                    Final grade averaging across all quarters
                </li>
            </ul>
        </div>
        <div class="sc-grading-demo">
            <h4>Sample Q2 Grade Computation</h4>
            <div class="sc-grading-row">
                <span>Written Work (WW)</span>
                <strong>90.0%</strong>
            </div>
            <div class="sc-grading-bar"><div class="sc-grading-bar-fill" style="width: 90%"></div></div>
            <div class="sc-grading-row">
                <span>Performance Task (PT)</span>
                <strong>85.0%</strong>
            </div>
            <div class="sc-grading-bar"><div class="sc-grading-bar-fill" style="width: 85%"></div></div>
            <div class="sc-grading-row">
                <span>Quarterly Assessment (QA)</span>
                <strong>88.0%</strong>
            </div>
            <div class="sc-grading-bar"><div class="sc-grading-bar-fill" style="width: 88%"></div></div>
            <div class="sc-grading-row">
                <span>Initial Grade</span>
                <strong>88.6</strong>
            </div>
            <div class="sc-grading-row">
                <span>Transmuted Grade · Descriptor</span>
                <strong>88.6 · VS</strong>
            </div>
        </div>
    </div>
</section>

<section class="sc-section" id="roles">
    <div class="sc-container">
        <div class="sc-section-header">
            <span class="sc-section-label">Role-Based Dashboards</span>
            <h2>Designed for every member of the school</h2>
            <p>Each role sees a tailored dashboard with permissions aligned to their responsibilities.</p>
        </div>
        <div class="sc-roles">
            <div class="sc-role-card">
                <div class="sc-role-avatar">M</div>
                <span>Master</span>
            </div>
            <div class="sc-role-card">
                <div class="sc-role-avatar">A</div>
                <span>Admin</span>
            </div>
            <div class="sc-role-card">
                <div class="sc-role-avatar">T</div>
                <span>Teacher</span>
            </div>
            <div class="sc-role-card">
                <div class="sc-role-avatar">S</div>
                <span>Student</span>
            </div>
            <div class="sc-role-card">
                <div class="sc-role-avatar">L</div>
                <span>Librarian</span>
            </div>
            <div class="sc-role-card">
                <div class="sc-role-avatar">$</div>
                <span>Accountant</span>
            </div>
        </div>
    </div>
</section>

<section class="sc-cta">
    <div class="sc-container">
        <h2>Ready to modernize your school?</h2>
        <p>Deploy SmartCampus K–12 on your local network for reliable access across Tawi-Tawi schools — even on limited bandwidth.</p>
        @auth
            <a href="{{ url('/home') }}" class="sc-btn sc-btn-primary">Open Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="sc-btn sc-btn-primary">Sign In Now</a>
        @endauth
    </div>
</section>

<footer class="sc-footer">
    <div class="sc-container">
        <div class="sc-footer-grid">
            <div>
                <a href="{{ url('/') }}" class="sc-logo" style="color: #fff; margin-bottom: 12px;">
                    <div class="sc-logo-mark">SC</div>
                    <div class="sc-logo-text" style="color: #fff;">
                        SmartCampus
                        <small style="color: rgba(255,255,255,0.6);">K–12 Management System</small>
                    </div>
                </a>
                <p style="margin: 16px 0 0; max-width: 320px; line-height: 1.6;">
                    Modernizing integrated school management systems for Philippine K–12 education.
                </p>
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
                <a href="https://github.com/kerrfairtex/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems" target="_blank" rel="noopener">Documentation</a>
            </div>
        </div>
        <div class="sc-footer-bottom">
            SmartCampus K–12 · GNU GPL v3.0 · Built on Laravel
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
(function () {
    var toggle = document.getElementById('scNavToggle');
    var links = document.getElementById('scNavLinks');
    if (toggle && links) {
        toggle.addEventListener('click', function () {
            links.classList.toggle('is-open');
        });
    }
})();
</script>
@endpush
