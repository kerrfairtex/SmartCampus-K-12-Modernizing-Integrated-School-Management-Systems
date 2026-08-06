# SmartCampus K-12 Fullstack Completion Plan

## Vision

Deliver a functional DepEd-aligned school management web app: public landing → authenticated portals per role → quarterly grading → SF9 reports → parent access.

## Phase A — Public frontend (done in this sprint)

- [x] Professional landing page with hero asset
- [x] Branded login page
- [x] Design system (`smartcampus-landing.css`)

## Phase B — Academic calendar & DepEd grading UI

- [x] School year + Q1–Q4 admin
- [x] Teacher WW/PT/QA score entry
- [x] Compute & persist quarterly grades
- [x] Section and student quarterly grade views
- [x] Sidebar navigation entries

## Phase C — Reports & parent portal

- [x] SF9 learner progress report (print-ready HTML)
- [x] Parent role + `parent_students` link table
- [x] Parent dashboard (children, grades, attendance summary)

## Phase D — Remaining (next sprint)

- [ ] SF1, SF2, SF10 exports
- [ ] PDF library integration (dompdf/snappy)
- [ ] Parent messaging
- [ ] Load testing suite
- [ ] Laravel framework upgrade (5.5 → 10+)
- [ ] PWA / low-bandwidth optimizations

## Architecture

| Layer | Stack |
|-------|--------|
| Public | Blade + `smartcampus-landing.css` |
| App | Laravel 5.5, Blade, Bootstrap 3 (legacy dashboard) |
| DepEd grades | `DepEdGradingService` + new controllers |
| Auth | 7 roles: master, admin, teacher, student, librarian, accountant, parent |
