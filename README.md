# SmartCampus K–12

Modernizing integrated school management systems for Philippine K–12 education, with a regional focus on Tawi-Tawi.

## Overview

SmartCampus K–12 is a custom web application that combines DepEd-compliant workflows, Laravel architecture, and local-hosted deployment for low-bandwidth environments. No single open-source repository matches the full specification; this project builds on the closest match and documents gaps for custom development.

## Base Architecture

This repository use as its foundation:

- Laravel 5.5 MVC with services layer
- Roles: Master, Admin, Teacher, Student, Librarian, Accountant
- Modules: SIS, enrollment, attendance, grades, library, exams, messaging, accounting
- Docker deployment support
- PHPUnit and Dusk test suites

## Documentation

| Document | Description |
|----------|-------------|
| [Literature Review](docs/LITERATURE_REVIEW.md) | Comparison of open-source and Philippine commercial systems |
| [Gap Analysis](docs/GAP_ANALYSIS.md) | Technical gaps between base repo and SmartCampus requirements |
| [DepEd Grading (Phase 2)](docs/DEPED_GRADING.md) | Quarterly grading schema and computation service |
| [Serverless Deployment Baseline](docs/SERVERLESS_DEPLOYMENT.md) | AWS-focused serverless migration baseline and env model |
| [readme.md](readme.md) | Original Unifiedtransform project documentation |

## Quick Start

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

For Docker:

```bash
docker-compose up -d
```

## License

GNU General Public License v3.0 (inherited from Unifiedtransform base).
