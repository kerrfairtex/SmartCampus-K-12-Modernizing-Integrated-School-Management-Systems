# SmartCampus K–12

Modernizing integrated school management systems for Philippine K–12 education, with a regional focus on Tawi-Tawi.

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](LICENSE)

---

## Overview

SmartCampus K–12 is a full-stack school management system built for Philippine K–12 education. It combines:

- **Laravel 5.5** PHP backend (MVC + services layer)
- **Supabase** hosted PostgreSQL database
- **Prisma 7** TypeScript schema and client for type-safe database access
- **Railway** cloud deployment via Nixpacks
- **Docker** for local development

The system covers student information, enrollment, attendance, DepEd-compliant quarterly grading, library, accounting, and role-based access for six user roles.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 5.5 (PHP 8.1) |
| Database | Supabase (PostgreSQL) |
| ORM / Schema | Prisma 7 (`prisma/schema.prisma`) |
| Deployment | Railway (Nixpacks) |
| Local dev | Docker Compose + Nginx |
| Tests | PHPUnit + Laravel Dusk |

> **Shared Supabase project:** This database is shared across multiple repositories. All table names are unique to this application and are documented in `prisma/schema.prisma`.

---

## Modules & Roles

**Roles:** Master · Admin · Teacher · Student · Librarian · Accountant

| Module | Description |
|--------|-------------|
| Student Information System | Profiles, guardian info, board exam records |
| Enrollment | Registration, section assignment, student import (Excel) |
| Attendance | Per-section, per-exam attendance tracking |
| Grades | Legacy GPA grades + DepEd K–12 quarterly grading (Phase 2) |
| DepEd Grading | Written Work / Performance Task / Quarterly Assessment → transmuted grade |
| Exams | Exam schedule, exam-for-class assignments |
| Library | Books, issued books, librarian management |
| Accounting | Fees, accounts, account sectors, payments (Stripe) |
| Messaging | Internal messages, notices, events, notifications |
| Curriculum | Classes, sections, courses, syllabuses, routines, homeworks |

---

## Database Schema

All 28 tables are defined in [`prisma/schema.prisma`](prisma/schema.prisma). Connection configuration lives in [`prisma/prisma.config.ts`](prisma/prisma.config.ts) (Prisma 7 requirement).

Key tables:

```
schools → users → sections → courses
                           → attendances
                           → quarterly_component_scores
                           → quarterly_grades
school_years → quarters → quarterly_component_scores
                        → quarterly_grades
deped_transmutation_tables → deped_transmutation_rows
```

See [`docs/DEPED_GRADING.md`](docs/DEPED_GRADING.md) for the full DepEd grading pipeline.

---

## Quick Start (Local)

### Prerequisites

- PHP 8.1+
- Composer
- Node.js 18+
- A Supabase project (or local PostgreSQL)

### Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Install JS dependencies
npm install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Set database credentials in .env
#    DATABASE_URL=postgresql://...  (pooler URL for runtime)
#    DIRECT_URL=postgresql://...    (direct URL for migrations)
#    NEXT_PUBLIC_SUPABASE_URL=https://<project>.supabase.co
#    NEXT_PUBLIC_SUPABASE_ANON_KEY=<anon key>

# 5. Run migrations
php artisan migrate

# 6. (Optional) Seed the database
php artisan db:seed

# 7. Start the dev server
php artisan serve
```

### Docker

```bash
docker-compose up -d
```

Nginx serves on port 80. The PHP container uses `php:8.1-fpm`.

---

## Prisma (TypeScript client)

```bash
# Install Prisma dependencies
npm install prisma @prisma/client @prisma/adapter-pg pg

# Generate the typed client
npx prisma generate

# (Optional) Pull schema from live DB to verify sync
npx prisma db pull
```

The Prisma client can be used in TypeScript/Next.js layers alongside the Laravel backend for type-safe queries against the same Supabase database.

---

## Deployment (Railway)

This project deploys to Railway via Nixpacks. The build is defined in [`nixpacks.toml`](nixpacks.toml):

- **PHP 8.1** with extensions: `gd`, `mbstring`, `bcmath`, `xml`, `zip`
- Build: `composer install` → `config:cache` → `route:cache` → `view:cache`
- Start: `php artisan serve --host=0.0.0.0 --port=$PORT`

Set the following environment variables in Railway:

| Variable | Description |
|----------|-------------|
| `APP_KEY` | Laravel app key (`php artisan key:generate`) |
| `DATABASE_URL` | Supabase pooler connection string |
| `DIRECT_URL` | Supabase direct connection string (for migrations) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |

---

## Documentation

| Document | Description |
|----------|-------------|
| [Literature Review](docs/LITERATURE_REVIEW.md) | Comparison of open-source and Philippine commercial systems |
| [Gap Analysis](docs/GAP_ANALYSIS.md) | Technical gaps between base repo and SmartCampus requirements |
| [DepEd Grading (Phase 2)](docs/DEPED_GRADING.md) | Quarterly grading schema and computation service |
| [Original readme](readme.md) | Unifiedtransform base project documentation |

---

## Testing

```bash
# PHPUnit feature and unit tests
php artisan test

# Laravel Dusk browser tests (requires running server)
php artisan dusk
```

---

## License

GNU General Public License v3.0 — inherited from the [Unifiedtransform](https://github.com/changeweb/Unifiedtransform) base project. See [LICENSE](LICENSE).
