# Literature Review: Open-Source and Philippine School Management Systems

## Context

SmartCampus K–12 targets a combination of requirements that rarely exist together in a single publicly available repository:

| Requirement | Description |
|-------------|-------------|
| DepEd-compliant K–12 workflows | Philippine Department of Education grading, forms, and reporting |
| Laravel architecture | MVC framework with normalized schema |
| Student Information System (SIS) | Enrollment, records, demographics |
| Attendance | Section- and course-level tracking |
| Quarterly grade computation | Term-based marking aligned to K–12 |
| Role-based dashboards | Admin, teacher, student, and related roles |
| Normalized database | Relational schema with foreign keys |
| Local-hosted deployment | Low-bandwidth / on-premise suitability |
| Agile development | Iterative SDLC documentation |
| Stress/load testing | Performance validation under concurrent users |
| Regional focus | Tawi-Tawi deployment context |

That combination is essentially a **custom system**. No single open-source repository is 100% identical to the SmartCampus K–12 specification.

---

## Closest Open-Source Repositories

### 1. School Management System (Laravel) — Best Overall Match (~90%)

**Repository:** [abdulwahid880/School-Management-system-in-laravel-](https://github.com/abdulwahid880/School-Management-system-in-laravel-)

**Origin:** Fork of [changeweb/Unifiedtransform](https://github.com/changeweb/Unifiedtransform) (GPL-3.0).

**Features present:**

- Student and teacher management
- Attendance (section/course level)
- Enrollment and registration
- Grades and GPA computation
- Library, exams, messaging, notifications
- Excel import/export
- Multi-role authentication (Master, Admin, Teacher, Student, Librarian, Accountant)
- Laravel MVC with services layer and PHPUnit/Dusk tests

**Missing compared to SmartCampus literature:**

- DepEd grading rules and quarterly report templates
- Philippine school forms (SF1–SF10)
- Tawi-Tawi / low-bandwidth regional optimization
- Agile process documentation
- Stress/load testing
- Six-module decomposition as specified in SmartCampus
- Parent portal role

**Status in this repository:** Adopted as the **base architecture** (see `docs/GAP_ANALYSIS.md`).

---

### 2. Comprehensive Laravel School Management System (~88%)

**Repository:** [mo7amedshaban/school-management-system](https://github.com/mo7amedshaban/school-management-system)

**Features:**

- Admin, teacher, student, and parent roles
- Enrollment, attendance, library, notifications
- Financial management and reports
- Multi-role authentication

**Notes:** Closer to enterprise breadth but includes modules outside SmartCampus scope (transportation, fees, Zoom integration). Useful as a **feature benchmark** for parent portal and financial modules.

---

### 3. Laravel School Management System (Uganda) (~82%)

**Repository:** [Othie12/Laravel-School-Management-system](https://github.com/Othie12/Laravel-School-Management-system)

**Strengths:**

- Report cards
- Attendance
- Parent portal
- Calendar
- Student tracking

**Missing:**

- DepEd compliance
- Modern Laravel architecture
- Philippine K–12 workflows

---

## Philippine References (Not Open Source)

These align more closely with SmartCampus requirements but are commercial or proprietary.

### Paaralan

**Website:** [paaralan.ph](https://paaralan.ph/)

Very close to SmartCampus requirements:

- DepEd compliant
- Enrollment, attendance, grades
- Parent portal
- SF1–SF10 forms
- Notifications
- Student Information System

**Use:** Primary **feature benchmark** for DepEd workflows and form generation.

### Klasrom

**Website:** [klasrom.com](https://klasrom.com/)

Includes:

- DepEd grading
- Attendance
- Student records
- Analytics and reports
- Philippine K–12 focus

**Use:** **DepEd workflow reference** for grading policies and term structure.

---

## Research Paper Closest to SmartCampus Literature

**Title:** *Designing and Implementing e-School Systems: An Information Systems Approach to School Management of a Community College in Northern Mindanao*

**Relevance:**

- Agile SDLC methodology
- Information Systems theory framing
- ISO software quality evaluation
- Centralized records management
- School Management Information System (SMIS) architecture

**Use:** **Research foundation** for methodology, evaluation criteria, and academic framing.

---

## Match Score Summary

| Repository / System | Estimated Match |
|---------------------|-----------------|
| abdulwahid880/School-Management-system-in-laravel- | ~90% |
| mo7amedshaban/school-management-system | ~88% |
| Paaralan (commercial) | ~95% |
| Klasrom (commercial) | ~93% |
| Othie12/Laravel-School-Management-system | ~82% |

---

## Recommendation for SmartCampus K–12

| Layer | Source |
|-------|--------|
| **Architecture** | abdulwahid880/School-Management-system-in-laravel- |
| **Feature benchmark** | Paaralan |
| **DepEd workflow reference** | Klasrom |
| **Research foundation** | Northern Mindanao e-School Systems paper |

This combination most closely aligns with the SmartCampus K–12 literature and provides a strong basis for implementing the web application while documenting gaps that require custom development.
