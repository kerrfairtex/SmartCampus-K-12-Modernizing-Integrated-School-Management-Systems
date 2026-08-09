<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartCampus — Batu-Batu National Integrated High School</title>
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
        body { font-family: 'Public Sans', sans-serif; color: var(--ink); background: var(--shell); line-height: 1.6; }
        h1, h2, h3, .brand { font-family: 'Fraunces', serif; }

        .nav { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 2.5rem; background: var(--navy); }
        .brand-block { display: flex; align-items: center; gap: 0.75rem; }
        .crest {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(160deg, var(--teal), var(--navy-deep));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Fraunces', serif; font-weight: 700; color: var(--shell); font-size: 1.05rem;
            border: 1.5px solid rgba(253,251,247,0.25);
        }
        .brand { color: var(--shell); font-size: 1.15rem; font-weight: 600; line-height: 1.25; }
        .nav-links a.cta {
            background: var(--coral); color: var(--shell); text-decoration: none;
            font-weight: 600; font-size: 0.9rem; padding: 0.65rem 1.4rem; border-radius: 4px;
        }

        .identity { background: var(--navy); color: var(--shell); padding: 3rem 2.5rem 3.5rem; text-align: center; }
        .identity .region {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.7rem; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--teal); margin-bottom: 0.6rem;
        }
        .identity h1 { font-size: 2rem; font-weight: 600; }
        .identity p { color: #C9D8E0; font-size: 0.95rem; margin-top: 0.5rem; }

        .horizon { display: block; width: 100%; height: 40px; margin-top: -1px; }

        .portal { background: var(--sand); padding: 3rem 2.5rem 4rem; }
        .portal-inner { max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; }

        .panel { background: var(--shell); border-radius: 8px; border: 1px solid var(--line); padding: 1.75rem; margin-bottom: 1.5rem; }
        .panel h2 { font-size: 1.05rem; font-weight: 600; color: var(--navy); display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.1rem; }
        .panel h2 .tag {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.62rem; color: var(--teal);
            background: rgba(42,157,143,0.12); padding: 0.2rem 0.5rem; border-radius: 3px;
            text-transform: uppercase; letter-spacing: 0.05em;
        }

        .post { padding: 0.9rem 0; border-bottom: 1px solid var(--line); }
        .post:last-child { border-bottom: none; padding-bottom: 0; }
        .post .date {
            font-family: 'IBM Plex Mono', monospace; font-size: 0.68rem; color: var(--teal);
            text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 0.25rem;
        }
        .post h3 { font-size: 0.95rem; font-weight: 600; color: var(--ink); margin-bottom: 0.2rem; }
        .post p { font-size: 0.85rem; color: #5A6B72; }

        .event { display: flex; gap: 0.9rem; align-items: flex-start; padding: 0.8rem 0; border-bottom: 1px solid var(--line); }
        .event:last-child { border-bottom: none; padding-bottom: 0; }
        .event .day-box {
            background: var(--navy); color: var(--shell); border-radius: 6px;
            width: 46px; height: 46px; flex-shrink: 0; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
        }
        .event .day-box .d { font-family: 'Fraunces', serif; font-weight: 700; font-size: 1.05rem; line-height: 1; }
        .event .day-box .m { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.04em; color: var(--teal); }
        .event h3 { font-size: 0.9rem; font-weight: 600; color: var(--ink); }
        .event p { font-size: 0.8rem; color: #5A6B72; margin-top: 0.15rem; }

        .quick-links { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
        .quick-links a {
            display: block; text-decoration: none; background: var(--shell);
            border: 1px solid var(--line); border-radius: 6px; padding: 0.9rem 0.75rem;
            text-align: center; transition: border-color 0.15s ease;
        }
        .quick-links a:hover { border-color: var(--teal); }
        .quick-links .qicon { font-size: 1.3rem; margin-bottom: 0.35rem; }
        .quick-links .qlabel { font-size: 0.78rem; font-weight: 600; color: var(--navy); }

        footer { background: var(--navy-deep); color: #A9C1CC; padding: 2rem 2.5rem; text-align: center; font-size: 0.78rem; }

        @media (max-width: 760px) { .portal-inner { grid-template-columns: 1fr; } }
        @media (max-width: 640px) {
            .nav { padding: 1rem 1.25rem; }
            .identity { padding: 2.25rem 1.25rem 2.75rem; }
            .identity h1 { font-size: 1.6rem; }
            .portal { padding: 2.25rem 1.25rem 3rem; }
        }
    </style>
</head>
<body>

    <nav class="nav">
        <div class="brand-block">
            <div class="crest">SC</div>
            <div class="brand">SmartCampus</div>
        </div>
        <div class="nav-links">
            <a href="/login" class="cta">Log in</a>
        </div>
    </nav>

    <header class="identity">
        <div class="region">Turtle Islands · Tawi-Tawi · Region IX</div>
        <h1>Batu-Batu National Integrated High School</h1>
        <p>Student and staff portal</p>
    </header>

    <svg class="horizon" viewBox="0 0 1440 40" preserveAspectRatio="none">
        <path d="M0,20 C240,4 480,36 720,20 C960,4 1200,36 1440,20 L1440,40 L0,40 Z" fill="#E8DCC4"/>
    </svg>

    <main class="portal">
        <div class="portal-inner">
            <div class="main-col">
                <div class="panel">
                    <h2>Announcements <span class="tag">Latest</span></h2>
                    <div class="post">
                        <div class="date">School Year 2026–2027</div>
                        <h3>Enrollment for the new school year is open</h3>
                        <p>New and returning students may complete enrollment through the registrar. Bring your Form 137 and birth certificate.</p>
                    </div>
                    <div class="post">
                        <div class="date">Quarter 2</div>
                        <h3>Second quarter grades are being finalized</h3>
                        <p>Teachers are encoding Q2 grades this week. Report cards will be released once all sections are complete.</p>
                    </div>
                    <div class="post">
                        <div class="date">Library</div>
                        <h3>Overdue book reminders sent this week</h3>
                        <p>Please return borrowed books to the library before the quarter ends to avoid holds on your record.</p>
                    </div>
                </div>

                <div class="panel">
                    <h2>What you need to update</h2>
                    <div class="post">
                        <h3>Confirm your contact information</h3>
                        <p>Make sure your phone number and address on file are current — this is how the school reaches your family.</p>
                    </div>
                    <div class="post">
                        <h3>Check your attendance record</h3>
                        <p>Review your attendance for this quarter and flag any discrepancy with your adviser before grading closes.</p>
                    </div>
                </div>
            </div>

            <div class="side-col">
                <div class="panel">
                    <h2>Upcoming</h2>
                    <div class="event">
                        <div class="day-box"><div class="d">14</div><div class="m">Aug</div></div>
                        <div><h3>Quarterly Examination begins</h3><p>All grade levels, per class schedule</p></div>
                    </div>
                    <div class="event">
                        <div class="day-box"><div class="d">21</div><div class="m">Aug</div></div>
                        <div><h3>Parent–Teacher Conference</h3><p>Afternoon session, per adviser</p></div>
                    </div>
                    <div class="event">
                        <div class="day-box"><div class="d">28</div><div class="m">Aug</div></div>
                        <div><h3>Buwan ng Wika program</h3><p>School grounds, whole-day activity</p></div>
                    </div>
                </div>

                <div class="panel">
                    <h2>Quick links</h2>
                    <div class="quick-links">
                        <a href="/login"><div class="qicon">📊</div><div class="qlabel">Grades</div></a>
                        <a href="/login"><div class="qicon">🗓️</div><div class="qlabel">Attendance</div></a>
                        <a href="/login"><div class="qicon">📚</div><div class="qlabel">Library</div></a>
                        <a href="/login"><div class="qicon">📝</div><div class="qlabel">Enrollment</div></a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        Batu-Batu National Integrated High School &middot; Turtle Islands, Tawi-Tawi
    </footer>

</body>
</html>
