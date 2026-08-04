# DepEd K–12 Grading (Phase 2)

Phase 2 implements the DepEd quarterly grading schema and computation service for SmartCampus K–12.

## Schema

| Table | Purpose |
|-------|---------|
| `school_years` | Academic year per school (e.g. 2025–2026) |
| `quarters` | Q1–Q4 per school year |
| `grading_component_types` | WW (Written Work), PT (Performance Task), QA (Quarterly Assessment) |
| `course_grading_weights` | Per-course weight overrides (default 40/40/20) |
| `deped_transmutation_tables` | School or system transmutation config |
| `deped_transmutation_rows` | Score range → transmuted grade rows |
| `quarterly_component_scores` | Raw scores per student/course/quarter/component |
| `quarterly_grades` | Computed initial, transmuted, and descriptor grades |

## Computation Flow

```
Raw scores (WW, PT, QA)
    → Component percentages (raw / max × 100)
    → Initial grade (weighted: WW×40% + PT×40% + QA×20%)
    → Transmuted grade (DepEd transmutation table)
    → Descriptor (O, VS, S, FS, D)
```

Final grade = average of Q1–Q4 transmuted grades.

## Service

`App\Services\DepedGrading\DepEdGradingService`

| Method | Description |
|--------|-------------|
| `computeComponentPercentage()` | Raw/max → percentage |
| `computeInitialGrade()` | Weighted average of components |
| `transmute()` | Apply transmutation table |
| `getDescriptor()` | Numeric → O/VS/S/FS/D |
| `computeQuarterlyGrade()` | Full pipeline (no DB) |
| `computeAndPersistQuarterlyGrade()` | Load scores, compute, save |
| `computeFinalGrade()` | Average of quarterly grades |
| `createSchoolYearWithQuarters()` | Create year + Q1–Q4 |
| `ensureDefaultWeightsForCourse()` | Seed 40/40/20 on course |

## Configuration

`config/deped_grading.php` — default weights, descriptor bands, component codes.

## Seeding

```bash
php artisan db:seed --class=DepedGradingTableSeeder
```

Included in `DatabaseSeeder` after gradesystems.

## Example Usage

```php
$service = app(\App\Services\DepedGrading\DepEdGradingService::class);

// Create school year with quarters
$schoolYear = $service->createSchoolYearWithQuarters(
    $schoolId, '2025-2026', '2025-06-01', '2026-03-31', $userId, true
);

$quarter = $schoolYear->quarters->first();
$service->ensureDefaultWeightsForCourse($course);

// Store component scores then compute
\App\QuarterlyComponentScore::create([...]); // WW, PT, QA

$grade = $service->computeAndPersistQuarterlyGrade(
    $quarter->id, $course->id, $studentId, $userId, $teacherId
);

// $grade->initial_grade, $grade->transmuted_grade, $grade->descriptor
```

## Tests

`tests/Unit/DepEdGradingServiceTest.php` — 8 unit tests covering computation and persistence.

```bash
./vendor/bin/phpunit tests/Unit/DepEdGradingServiceTest.php
```

## Remaining Phase 2 Items

- SF9 report card PDF (Blade template + export)
- Parent role and minimal portal
