<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartCampus K-12 — Batu-Batu National Integrated High School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Public+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0B3D5C;
            --teal: #2A9D8F;
            --sand: #E8DCC4;
            --coral: #E76F51;
            --ink: #142B3A;
            --shell: #FDFBF7;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Public Sans', sans-serif;
            color: var(--ink);
            background: var(--shell);
            line-height: 1.6;
        }
        h1, h2, .brand {
            font-family: 'Fraunces', serif;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: var(--navy);
        }
        .brand {
            color: var(--shell);
            font-size: 1.4rem;
            font-weight: 600;
            letter-spacing: -0.01em;
        }
        .brand small {
            display: block;
            font-family: 'Public Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--teal);
            margin-top: 0.15rem;
        }
        .nav-links a {
            color: var(--shell);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            margin-left: 1.75rem;
            opacity: 0.9;
            transition: opacity 0.15s ease;
        }
        .nav-links a:hover { opacity: 1; }
        .nav-links a.cta {
            background: var(--coral);
            padding: 0.6rem 1.3rem;
            border-radius: 4px;
            opacity: 1;
        }

        .hero {
            background: var(--navy);
            color: var(--shell);
            padding: 4.5rem 2rem 6rem;
            position: relative;
        }
        .hero-inner {
            max-width: 640px;
            margin: 0 auto;
            text-align: center;
        }
        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 1.25rem;
        }
        .hero h1 {
            font-size: 2.6rem;
            font-weight: 600;
            line-height: 1.15;
            margin-bottom: 1.1rem;
        }
        .hero p {
            font-size: 1.05rem;
            color: #C9D8E0;
            max-width: 480px;
            margin: 0 auto 2.25rem;
        }
        .hero-ctas a {
            display: inline-block;
            text-decoration: none;
            font-weight: 600;
            padding: 0.85rem 1.75rem;
            border-radius: 4px;
            margin: 0 0.4rem;
        }
        .hero-ctas .primary {
            background: var(--coral);
            color: var(--shell);
        }
        .hero-ctas .secondary {
            background: transparent;
            color: var(--shell);
            border: 1.5px solid rgba(253,251,247,0.35);
        }

        /* wave-horizon signature divider */
        .horizon {
            display: block;
            width: 100%;
            height: 48px;
            margin-top: -1px;
        }

        .body-section {
            background: var(--sand);
            padding: 3.5rem 2rem;
        }
        .body-inner {
            max-width: 900px;
            margin: 0 auto;
        }
        .body-inner h2 {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--navy);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .subhead {
            text-align: center;
            color: #5A6B72;
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: var(--shell);
            padding: 1.5rem;
            border-radius: 6px;
            border: 1px solid rgba(11,61,92,0.08);
        }
        .card .mark {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 0.75rem;
            color: var(--teal);
            margin-bottom: 0.5rem;
        }
        .card h3 {
            font-family: 'Public Sans', sans-serif;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.4rem;
        }
        .card p {
            font-size: 0.9rem;
            color: #5A6B72;
        }

        footer {
            text-align: center;
            padding: 2rem;
            font-size: 0.8rem;
            color: #5A6B72;
        }

        @media (max-width: 640px) {
            .hero h1 { font-size: 2rem; }
            .nav-links a { margin-left: 1rem; font-size: 0.85rem; }
        }
    </style>
</head>
<body>

    <nav class="nav">
        <div class="brand">SmartCampus<small>Batu-Batu National Integrated High School</small></div>
        <div class="nav-links">
            <a href="/login">Log in</a>
            <a href="https://github.com/kerrfairtex/SmartCampus-K-12-Modernizing-Integrated-School-Management-Systems" class="cta">GitHub</a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-inner">
            <div class="eyebrow">Turtle Islands · Tawi-Tawi · Region IX</div>
            <h1>One record, not a hundred folders.</h1>
            <p>SmartCampus replaces paper-based enrollment, attendance, and grading with a single source of truth — built for a school that can't afford lost records or slow connections.</p>
            <div class="hero-ctas">
                <a href="/login" class="primary">Log in to SmartCampus</a>
                <a href="#about" class="secondary">See what changed</a>
            </div>
        </div>
        <svg class="horizon" viewBox="0 0 1440 48" preserveAspectRatio="none">
            <path d="M0,24 C240,4 480,44 720,24 C960,4 1200,44 1440,24 L1440,48 L0,48 Z" fill="#E8DCC4"/>
        </svg>
    </header>

    <section class="body-section" id="about">
        <div class="body-inner">
            <h2>Built for how the school actually runs</h2>
            <p class="subhead">From reactive record-keeping to a system the whole school can trust.</p>
            <div class="grid">
                <div class="card">
                    <div class="mark">ENROLLMENT</div>
                    <h3>No more duplicate files</h3>
                    <p>Every student record lives in one place — no re-entering the same form at every office.</p>
                </div>
                <div class="card">
                    <div class="mark">GRADING</div>
                    <h3>DepEd-aligned by default</h3>
                    <p>Quarterly grades compute the way DepEd expects, without a manual spreadsheet per section.</p>
                </div>
                <div class="card">
                    <div class="mark">RECORDS</div>
                    <h3>Nothing left to a filing cabinet</h3>
                    <p>Attendance, library, and accounts are logged as they happen, not reconstructed later.</p>
                </div>
            </div>
        </div>
    </section>

    <footer>
        Batu-Batu National Integrated High School &middot; SmartCampus K-12
    </footer>

</body>
</html>
