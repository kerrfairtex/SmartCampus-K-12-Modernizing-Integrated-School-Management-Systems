<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\DepedGrading\DepEdGradingService;
use App\DepedTransmutationTable;
use App\GradingComponentType;
use App\School;
use App\Course;
use App\QuarterlyComponentScore;
use App\QuarterlyGrade;

class DepEdGradingServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var DepEdGradingService */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->seed(\DepedGradingTableSeeder::class);
        $this->service = new DepEdGradingService();
    }

    /** @test */
    public function it_computes_component_percentage()
    {
        $this->assertSame(85.0, $this->service->computeComponentPercentage(34, 40));
        $this->assertSame(0.0, $this->service->computeComponentPercentage(10, 0));
        $this->assertSame(100.0, $this->service->computeComponentPercentage(50, 40));
    }

    /** @test */
    public function it_computes_initial_grade_with_deped_weights()
    {
        $weights = ['WW' => 40, 'PT' => 40, 'QA' => 20];
        $percentages = ['WW' => 90, 'PT' => 85, 'QA' => 88];

        $initial = $this->service->computeInitialGrade($percentages, $weights);

        // (90*40 + 85*40 + 88*20) / 100 = 88.6
        $this->assertSame(88.6, $initial);
    }

    /** @test */
    public function it_maps_grade_to_deped_descriptor()
    {
        $this->assertSame('O', $this->service->getDescriptor(95));
        $this->assertSame('VS', $this->service->getDescriptor(87));
        $this->assertSame('S', $this->service->getDescriptor(82));
        $this->assertSame('FS', $this->service->getDescriptor(76));
        $this->assertSame('D', $this->service->getDescriptor(70));
    }

    /** @test */
    public function it_transmutes_using_table_rows()
    {
        $table = DepedTransmutationTable::where('is_default', true)->first();
        $rows = $table->rows;

        $this->assertSame(95.0, $this->service->transmute(95, $rows));
        $this->assertSame(60.0, $this->service->transmute(55, $rows));
    }

    /** @test */
    public function it_computes_full_quarterly_grade_pipeline()
    {
        $table = DepedTransmutationTable::where('is_default', true)->first();
        $weights = config('deped_grading.default_weights');

        $componentScores = [
            'WW' => ['raw' => 36, 'max' => 40],  // 90%
            'PT' => ['raw' => 34, 'max' => 40],  // 85%
            'QA' => ['raw' => 44, 'max' => 50],  // 88%
        ];

        $result = $this->service->computeQuarterlyGrade(
            $componentScores,
            $weights,
            $table->rows
        );

        $this->assertSame(90.0, $result['written_work_percent']);
        $this->assertSame(85.0, $result['performance_task_percent']);
        $this->assertSame(88.0, $result['quarterly_assessment_percent']);
        $this->assertSame(88.6, $result['initial_grade']);
        $this->assertSame(88.6, $result['transmuted_grade']);
        $this->assertSame('VS', $result['descriptor']);
    }

    /** @test */
    public function it_computes_final_grade_from_quarters()
    {
        $final = $this->service->computeFinalGrade([88, 90, 85, 87]);
        $this->assertSame(87.5, $final);
    }

    /** @test */
    public function it_creates_school_year_with_four_quarters()
    {
        $school = factory(School::class)->create();
        $schoolYear = $this->service->createSchoolYearWithQuarters(
            $school->id,
            '2025-2026',
            '2025-06-01',
            '2026-03-31',
            1,
            true
        );

        $this->assertCount(4, $schoolYear->quarters);
        $this->assertSame('Q1', $schoolYear->quarters->first()->name);
        $this->assertSame('Q4', $schoolYear->quarters->last()->name);
    }

    /** @test */
    public function it_persists_quarterly_grade_from_component_scores()
    {
        $school = factory(School::class)->create();
        $schoolYear = $this->service->createSchoolYearWithQuarters(
            $school->id,
            '2025-2026',
            '2025-06-01',
            '2026-03-31',
            1
        );
        $quarter = $schoolYear->quarters->first();

        $course = factory(Course::class)->create(['school_id' => $school->id]);
        $this->service->ensureDefaultWeightsForCourse($course);

        $ww = GradingComponentType::where('code', 'WW')->first();
        $pt = GradingComponentType::where('code', 'PT')->first();
        $qa = GradingComponentType::where('code', 'QA')->first();

        $studentId = 999;

        QuarterlyComponentScore::create([
            'quarter_id' => $quarter->id,
            'course_id' => $course->id,
            'student_id' => $studentId,
            'grading_component_type_id' => $ww->id,
            'raw_score' => 36,
            'max_score' => 40,
            'user_id' => 1,
        ]);
        QuarterlyComponentScore::create([
            'quarter_id' => $quarter->id,
            'course_id' => $course->id,
            'student_id' => $studentId,
            'grading_component_type_id' => $pt->id,
            'raw_score' => 34,
            'max_score' => 40,
            'user_id' => 1,
        ]);
        QuarterlyComponentScore::create([
            'quarter_id' => $quarter->id,
            'course_id' => $course->id,
            'student_id' => $studentId,
            'grading_component_type_id' => $qa->id,
            'raw_score' => 44,
            'max_score' => 50,
            'user_id' => 1,
        ]);

        $grade = $this->service->computeAndPersistQuarterlyGrade(
            $quarter->id,
            $course->id,
            $studentId,
            1
        );

        $this->assertInstanceOf(QuarterlyGrade::class, $grade);
        $this->assertSame(88.6, (float) $grade->initial_grade);
        $this->assertSame('VS', $grade->descriptor);
        $this->assertNotNull($grade->computed_at);
    }
}
