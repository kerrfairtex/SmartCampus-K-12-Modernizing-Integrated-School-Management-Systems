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
            --navy-deep: #082C43;
            --teal: #2A9D8F;
            --sand: #E8DCC4;
            --coral: #E76F51;
            --ink: #142B3A;
            --shell: #FDFBF7;
            --line: rgba(11,61,92,0.10);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Public Sans', sans-serif;
            color: var(--ink);
            background: var(--shell);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, .brand { font-family: 'Fraunces', serif; }

        /* NAV */
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 2.5rem;
            background: var(--navy);
            border-bottom: 1px solid rgba(253,251,247,0.08);
        }
        .brand-block { display: flex; align-items: center; gap: 0.75rem; }
        .crest {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(160deg, var(--teal), var(--navy-deep));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Fraunces', serif; font-weight: 700; color: var(--shell);
            font-size: 1.05rem;
            border: 1.5px solid rgba(253,251,247,0.25);
        }
        .brand { color: var(--shell); font-size: 1.3rem; font-weight: 600; letter-spacing: -0.01em; }
        .brand small {
            display: block; font-family: 'Public Sans', sans-serif;
            font-size: 0.62rem; font-weight: 600; letter-spacing: 0.09em;
            text-transform: uppercase; color: var(--teal); margin-top: 0.15rem;
        }
        .nav-links a.cta {
            background: var(--coral); color: var(--shell); text-decoration: none;
            font-weight: 600; font-size: 0.9rem; padding: 0.65rem 1.4rem;
            border-radius: 4px; transition: opacity 0.15s ease;
        }
        .nav-links a.cta:hover { opacity: 0.88; }

        /* HERO */
        .hero {
            background: radial-gradient(ellipse at top left, var(--navy) 0%, var(--navy-deep) 100%);
            color: var(--shell); padding: 5rem 2.5rem 6.5rem; position: relative;
        }
        .hero-inner { max-width: 700px; margin: 0 auto; text-align: center; }
        .eyebrow {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.72rem;
            letter-spacing: 0.12em; text-transform: uppercase; color: var(--teal);
            margin-bottom: 1.4rem; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .eyebrow::before, .eyebrow::after { content: ''; width: 18px; height: 1px; background: var(--teal); opacity: 0.5; }
        .hero h1 { font-size: 2.75rem; font-weight: 600; line-height: 1.14; margin-bottom: 1.2rem; letter-spacing: -0.01em; }
        .hero p { font-size: 1.08rem; color: #C9D8E0; max-width: 500px; margin: 0 auto 2.5rem; }
        .hero-ctas a {
            display: inline-block; text-decoration: none; font-weight: 600;
            padding: 0.9rem 1.9rem; border-radius: 4px; margin: 0 0.4rem; font-size: 0.95rem;
        }
        .hero-ctas .primary { background: var(--coral); color: var(--shell); box-shadow: 0 8px 24px rgba(231,111,81,0.28); }
        .hero-ctas .secondary { background: transparent; color: var(--shell); border: 1.5px solid rgba(253,251,247,0.32); }

        /* STAT STRIP — overlaps hero/sand boundary like a raised institutional panel */
        .stat-strip {
            max-width: 920px; margin: -3.25rem auto 0; position: relative; z-index: 2;
            background: var(--shell); border-radius: 10px; box-shadow: 0 20px 50px rgba(11,61,92,0.18);
            display: grid; grid-template-columns: repeat(4, 1fr);
            border: 1px solid var(--line);
        }
        .stat { padding: 1.75rem 1rem; text-align: center; border-right: 1px solid var(--line); }
        .stat:last-child { border-right: none; }
        .stat .num { font-family: 'Fraunces', serif; font-size: 1.9rem; font-weight: 700; color: var(--navy); }
        .stat .label {
            font-size: 0.68rem; letter-spacing: 0.06em; text-transform: uppercase;
            color: #6B7A80; margin-top: 0.3rem; font-weight: 600;
        }

        .horizon { display: block; width: 100%; height: 44px; margin-top: -1px; }

        /* SECTIONS */
        .body-section { background: var(--sand); padding: 5.5rem 2.5rem 4.5rem; }
        .body-inner { max-width: 1000px; margin: 0 auto; }
        .section-head { text-align: center; margin-bottom: 3rem; }
        .section-head .eyebrow-dark {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.7rem; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--teal); margin-bottom: 0.6rem;
        }
        .section-head h2 { font-size: 1.85rem; font-weight: 600; color: var(--navy); margin-bottom: 0.6rem; }
        .section-head p { color: #5A6B72; font-size: 0.97rem; max-width: 480px; margin: 0 auto; }

        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1.5rem; }
        .card {
            background: var(--shell); padding: 1.85rem 1.6rem; border-radius: 8px;
            border: 1px solid var(--line); transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(11,61,92,0.10); }
        .card .icon {
            width: 42px; height: 42px; border-radius: 8px;
            background: rgba(42,157,143,0.12); display: flex; align-items: center; justify-content: center;
            margin-bottom: 1rem; font-size: 1.15rem;
        }
        .card .mark {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.7rem; color: var(--teal);
            letter-spacing: 0.06em; margin-bottom: 0.4rem;
        }
        .card h3 { font-family: 'Public Sans', sans-serif; font-size: 1.08rem; font-weight: 600; color: var(--navy); margin-bottom: 0.45rem; }
        .card p { font-size: 0.9rem; color: #5A6B72; }

        /* ABOUT / MISSION */
        .about-section { background: var(--shell); padding: 5.5rem 2.5rem; }
        .about-inner {
            max-width: 1000px; margin: 0 auto; display: grid;
            grid-template-columns: 1fr 1fr; gap: 3.5rem; align-items: center;
        }
        .about-copy .eyebrow-dark {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.7rem; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--teal); margin-bottom: 0.75rem; display: block;
        }
        .about-copy h2 { font-size: 1.65rem; font-weight: 600; color: var(--navy); margin-bottom: 1rem; line-height: 1.25; }
        .about-copy p { color: #4A5A61; font-size: 0.97rem; margin-bottom: 1rem; }
        .about-panel {
            background: var(--navy); border-radius: 10px; padding: 2.25rem;
            color: var(--shell); position: relative; overflow: hidden;
        }
        .about-panel::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(42,157,143,0.25), transparent 60%);
        }
        .about-panel .quote-mark { font-family: 'Fraunces', serif; font-size: 3rem; color: var(--teal); opacity: 0.5; line-height: 1; }
        .about-panel blockquote {
            font-family: 'Fraunces', serif; font-size: 1.15rem; font-weight: 500;
            line-height: 1.5; margin: 0.5rem 0 1.25rem; position: relative;
        }
        .about-panel .cite { font-size: 0.8rem; color: #A9C1CC; font-family: 'IBM Plex Mono', monospace; letter-spacing: 0.04em; }

        /* FOOTER */
        footer { background: var(--navy-deep); color: #A9C1CC; padding: 3rem 2.5rem 2rem; }
        .footer-inner {
            max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between;
            align-items: flex-start; flex-wrap: wrap; gap: 2rem;
        }
        .footer-brand { color: var(--shell); font-family: 'Fraunces', serif; font-size: 1.1rem; font-weight: 600; }
        .footer-brand small { display: block; font-family: 'Public Sans', sans-serif; font-size: 0.75rem; color: #7C93A0; margin-top: 0.3rem; font-weight: 500; }
        .footer-meta { font-size: 0.8rem; text-align: right; }
        .footer-rule { max-width: 1000px; margin: 2rem auto 0; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; text-align: center; font-size: 0.75rem; color: #5E7684; }

        @media (max-width: 760px) {
            .about-inner { grid-template-columns: 1fr; }
            .stat-strip { grid-template-columns: repeat(2, 1fr); }
            .stat:nth-child(2) { border-right: none; }
        }
        @media (max-width: 640px) {
            .hero h1 { font-size: 2rem; }
            .nav { padding: 1rem 1.25rem; }
            .body-section, .about-section { padding: 3.5rem 1.25rem; }
            .footer-inner { flex-direction: column; }
            .footer-meta { text-align: left; }
        }
    </style>
</head>
<body>

    <nav class="nav">
        <div class="brand-block">
            <div class="crest">SC</div>
            <div class="brand">SmartCampus<small>Batu-Batu National Integrated High School</small></div>
        </div>
        <div class="nav-links">
            <a href="/login" class="cta">Log in</a>
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
    </header>

    <div class="stat-strip">
        <div class="stat"><div class="num">1</div><div class="label">Campus Served</div></div>
        <div class="stat"><div class="num">262+</div><div class="label">Records Digitized</div></div>
        <div class="stat"><div class="num">6</div><div class="label">User Roles</div></div>
        <div class="stat"><div class="num">100%</div><div class="label">DepEd Aligned</div></div>
    </div>

    <svg class="horizon" viewBox="0 0 1440 44" preserveAspectRatio="none">
        <path d="M0,22 C240,4 480,40 720,22 C960,4 1200,40 1440,22 L1440,44 L0,44 Z" fill="#E8DCC4"/>
    </svg>

    <section class="body-section" id="about">
        <div class="body-inner">
            <div class="section-head">
                <div class="eyebrow-dark">What changed</div>
                <h2>Built for how the school actually runs</h2>
                <p>From reactive record-keeping to a system the whole school can trust.</p>
            </div>
            <div class="grid">
                <div class="card">
                    <div class="icon">📋</div>
                    <div class="mark">ENROLLMENT</div>
                    <h3>No more duplicate files</h3>
                    <p>Every student record lives in one place — no re-entering the same form at every office.</p>
                </div>
                <div class="card">
                    <div class="icon">📊</div>
                    <div class="mark">GRADING</div>
                    <h3>DepEd-aligned by default</h3>
                    <p>Quarterly grades compute the way DepEd expects, without a manual spreadsheet per section.</p>
                </div>
                <div class="card">
                    <div class="icon">🗂️</div>
                    <div class="mark">RECORDS</div>
                    <h3>Nothing left to a filing cabinet</h3>
                    <p>Attendance, library, and accounts are logged as they happen, not reconstructed later.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="about-inner">
            <div class="about-copy">
                <span class="eyebrow-dark">Our mission</span>
                <h2>A single source of truth for an island community.</h2>
                <p>Batu-Batu National Integrated High School has run on paper for as long as it has existed — enrollment forms photocopied by hand, attendance re-tallied at the end of each term, grades reconciled from a dozen different ledgers.</p>
                <p>SmartCampus moves the school from a reactive posture, reconstructing what happened after the fact, to a proactive one: every record entered once, trusted everywhere it's needed.</p>
            </div>
            <div class="about-panel">
                <div class="quote-mark">"</div>
                <blockquote>A system built for a remote island community shouldn't ask more of its users than the paper it replaces.</blockquote>
                <div class="cite">— SmartCampus design principle</div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-inner">
            <div>
                <div class="footer-brand">SmartCampus K-12<small>School Management System</small></div>
            </div>
            <div class="footer-meta">
                Batu-Batu National Integrated High School<br>
                Turtle Islands, Tawi-Tawi, Region IX
            </div>
        </div>
        <div class="footer-rule">&copy; SmartCampus K-12 — built for one school, not a hundred.</div>
    </footer>

</body>
</html>

