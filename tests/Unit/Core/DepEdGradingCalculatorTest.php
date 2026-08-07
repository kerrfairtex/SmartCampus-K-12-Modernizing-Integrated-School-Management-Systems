<?php

namespace Tests\Unit\Core;

use App\Core\DepedGrading\ArrayGradingConfiguration;
use App\Core\DepedGrading\DepEdGradingCalculator;
use PHPUnit\Framework\TestCase;

class DepEdGradingCalculatorTest extends TestCase
{
    /** @var DepEdGradingCalculator */
    protected $calculator;

    public function setUp()
    {
        parent::setUp();

        $this->calculator = new DepEdGradingCalculator(
            new ArrayGradingConfiguration(
                ['WW' => 40, 'PT' => 40, 'QA' => 20],
                [
                    ['min' => 90, 'max' => 100, 'code' => 'O'],
                    ['min' => 85, 'max' => 89.99, 'code' => 'VS'],
                    ['min' => 80, 'max' => 84.99, 'code' => 'S'],
                    ['min' => 75, 'max' => 79.99, 'code' => 'FS'],
                    ['min' => 0, 'max' => 74.99, 'code' => 'D'],
                ],
                [
                    'written_work' => 'WW',
                    'performance_task' => 'PT',
                    'quarterly_assessment' => 'QA',
                ]
            )
        );
    }

    /** @test */
    public function it_computes_quarterly_grade_without_framework_runtime()
    {
        $result = $this->calculator->computeQuarterlyGrade(
            [
                'WW' => ['raw' => 36, 'max' => 40],
                'PT' => ['raw' => 34, 'max' => 40],
                'QA' => ['raw' => 44, 'max' => 50],
            ],
            ['WW' => 40, 'PT' => 40, 'QA' => 20],
            [
                ['from_score' => 88.51, 'to_score' => 88.99, 'transmuted_grade' => 89],
            ]
        );

        $this->assertSame(88.6, $result['initial_grade']);
        $this->assertSame(89.0, $result['transmuted_grade']);
        $this->assertSame('VS', $result['descriptor']);
    }

    /** @test */
    public function it_supports_object_transmutation_rows()
    {
        $row = new \stdClass();
        $row->from_score = 80;
        $row->to_score = 100;
        $row->transmuted_grade = 95;

        $this->assertSame(95.0, $this->calculator->transmute(85, [$row]));
    }
}
