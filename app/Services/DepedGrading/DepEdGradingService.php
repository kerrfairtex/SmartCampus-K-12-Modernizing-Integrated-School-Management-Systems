<?php

namespace App\Services\DepedGrading;

use App\Core\DepedGrading\DepEdGradingCalculator;
use App\Course;
use App\CourseGradingWeight;
use App\DepedTransmutationTable;
use App\GradingComponentType;
use App\Quarter;
use App\QuarterlyComponentScore;
use App\QuarterlyGrade;
use App\SchoolYear;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DepEdGradingService
{
    /** @var DepEdGradingCalculator */
    protected $calculator;

    public function __construct(?DepEdGradingCalculator $calculator = null)
    {
        $this->calculator = $calculator ?: new DepEdGradingCalculator(
            new FrameworkGradingConfiguration()
        );
    }

    /**
     * Convert raw score to percentage (0–100).
     */
    public function computeComponentPercentage(float $rawScore, float $maxScore): float
    {
        return $this->calculator->computeComponentPercentage($rawScore, $maxScore);
    }

    /**
     * Compute initial grade from DepEd component percentages and weights.
     *
     * @param array $componentPercentages keyed by component code (WW, PT, QA)
     * @param array $weights keyed by component code, values as weight percent
     */
    public function computeInitialGrade(array $componentPercentages, array $weights): float
    {
        return $this->calculator->computeInitialGrade($componentPercentages, $weights);
    }

    /**
     * Apply DepEd transmutation table to an initial grade.
     */
    public function transmute(float $initialGrade, Collection $transmutationRows): float
    {
        return $this->calculator->transmute($initialGrade, $transmutationRows->all());
    }

    /**
     * Map numeric grade to DepEd performance descriptor code.
     */
    public function getDescriptor(float $grade): string
    {
        return $this->calculator->getDescriptor($grade);
    }

    /**
     * Full quarterly grade computation pipeline (no persistence).
     *
     * @return array{written_work_percent: float|null, performance_task_percent: float|null,
     *               quarterly_assessment_percent: float|null, initial_grade: float,
     *               transmuted_grade: float, descriptor: string}
     */
    public function computeQuarterlyGrade(
        array $componentScores,
        array $weights,
        Collection $transmutationRows
    ): array {
        return $this->calculator->computeQuarterlyGrade(
            $componentScores,
            $weights,
            $transmutationRows->all()
        );
    }

    /**
     * Resolve grading weights for a course (course overrides or DepEd defaults).
     *
     * @return array<string, int> keyed by WW, PT, QA
     */
    public function getWeightsForCourse(Course $course): array
    {
        $weights = CourseGradingWeight::with('componentType')
            ->where('course_id', $course->id)
            ->get();

        if ($weights->isEmpty()) {
            return config('deped_grading.default_weights');
        }

        $mapped = [];
        foreach ($weights as $weight) {
            $mapped[$weight->componentType->code] = $weight->weight_percent;
        }

        return $mapped;
    }

    /**
     * Resolve transmutation table for a school (school-specific or system default).
     */
    public function getTransmutationTableForSchool(int $schoolId): ?DepedTransmutationTable
    {
        $schoolTable = DepedTransmutationTable::with('rows')
            ->where('school_id', $schoolId)
            ->first();

        if ($schoolTable) {
            return $schoolTable;
        }

        return DepedTransmutationTable::with('rows')
            ->whereNull('school_id')
            ->where('is_default', true)
            ->first();
    }

    /**
     * Build component score map from quarterly_component_scores records.
     *
     * @return array<string, array{raw: float, max: float}>
     */
    public function buildComponentScoreMap(Collection $scores): array
    {
        $map = [];

        foreach ($scores as $score) {
            $code = $score->componentType->code;
            $map[$code] = [
                'raw' => (float) $score->raw_score,
                'max' => (float) $score->max_score,
            ];
        }

        return $map;
    }

    /**
     * Compute and persist quarterly grade from stored component scores.
     */
    public function computeAndPersistQuarterlyGrade(
        int $quarterId,
        int $courseId,
        int $studentId,
        int $userId,
        ?int $teacherId = null
    ): QuarterlyGrade {
        $course = Course::findOrFail($courseId);
        $quarter = Quarter::with('schoolYear')->findOrFail($quarterId);
        $schoolId = $quarter->schoolYear->school_id;

        $scores = QuarterlyComponentScore::with('componentType')
            ->where('quarter_id', $quarterId)
            ->where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->get();

        $componentMap = $this->buildComponentScoreMap($scores);
        $weights = $this->getWeightsForCourse($course);

        $transmutationTable = $this->getTransmutationTableForSchool($schoolId);
        $rows = $transmutationTable ? $transmutationTable->rows : collect();

        $computed = $this->computeQuarterlyGrade($componentMap, $weights, $rows);

        return QuarterlyGrade::updateOrCreate(
            [
                'quarter_id' => $quarterId,
                'course_id' => $courseId,
                'student_id' => $studentId,
            ],
            array_merge($computed, [
                'teacher_id' => $teacherId,
                'user_id' => $userId,
                'computed_at' => Carbon::now(),
            ])
        );
    }

    /**
     * Compute final grade as average of quarterly transmuted grades.
     */
    public function computeFinalGrade(array $quarterlyTransmutedGrades): float
    {
        return $this->calculator->computeFinalGrade($quarterlyTransmutedGrades);
    }

    /**
     * Create school year with four DepEd quarters (Q1–Q4).
     */
    public function createSchoolYearWithQuarters(
        int $schoolId,
        string $name,
        string $startDate,
        string $endDate,
        int $userId,
        bool $isActive = false
    ): SchoolYear {
        $schoolYear = SchoolYear::create([
            'school_id' => $schoolId,
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => $isActive,
            'user_id' => $userId,
        ]);

        for ($q = 1; $q <= 4; $q++) {
            Quarter::create([
                'school_year_id' => $schoolYear->id,
                'quarter_number' => $q,
                'name' => 'Q'.$q,
                'is_active' => true,
            ]);
        }

        return $schoolYear->load('quarters');
    }

    /**
     * Seed default DepEd weights on a course if none exist.
     */
    public function ensureDefaultWeightsForCourse(Course $course): void
    {
        if (CourseGradingWeight::where('course_id', $course->id)->exists()) {
            return;
        }

        $types = GradingComponentType::all();

        foreach ($types as $type) {
            CourseGradingWeight::create([
                'course_id' => $course->id,
                'grading_component_type_id' => $type->id,
                'weight_percent' => $type->default_weight_percent,
            ]);
        }
    }
}
