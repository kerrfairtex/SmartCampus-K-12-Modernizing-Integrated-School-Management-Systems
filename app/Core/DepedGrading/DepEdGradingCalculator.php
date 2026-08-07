<?php

namespace App\Core\DepedGrading;

use App\Core\DepedGrading\Contracts\GradingConfiguration;

class DepEdGradingCalculator
{
    /** @var GradingConfiguration */
    protected $configuration;

    public function __construct(GradingConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function computeComponentPercentage(float $rawScore, float $maxScore): float
    {
        if ($maxScore <= 0) {
            return 0.0;
        }

        $percent = ($rawScore / $maxScore) * 100;

        return round(min(100, max(0, $percent)), 2);
    }

    /**
     * @param array<string, int|float> $componentPercentages
     * @param array<string, int|float> $weights
     */
    public function computeInitialGrade(array $componentPercentages, array $weights): float
    {
        $totalWeight = 0;
        $weightedSum = 0;

        foreach ($weights as $code => $weight) {
            if (!isset($componentPercentages[$code])) {
                continue;
            }

            $weightedSum += $componentPercentages[$code] * $weight;
            $totalWeight += $weight;
        }

        if ($totalWeight <= 0) {
            return 0.0;
        }

        return round($weightedSum / $totalWeight, 2);
    }

    /**
     * @param array<int, array<string, mixed>|object> $transmutationRows
     */
    public function transmute(float $initialGrade, array $transmutationRows): float
    {
        if (empty($transmutationRows)) {
            return round($initialGrade, 2);
        }

        foreach ($transmutationRows as $row) {
            $fromScore = (float) $this->getRowValue($row, 'from_score', 0.0);
            $toScore = (float) $this->getRowValue($row, 'to_score', 0.0);
            $transmutedGrade = (float) $this->getRowValue($row, 'transmuted_grade', $initialGrade);

            if ($initialGrade >= $fromScore && $initialGrade <= $toScore) {
                return round($transmutedGrade, 2);
            }
        }

        return round($initialGrade, 2);
    }

    public function getDescriptor(float $grade): string
    {
        $descriptors = $this->configuration->getDescriptors();

        foreach ($descriptors as $descriptor) {
            if (
                $grade >= (float) $this->getRowValue($descriptor, 'min', 0.0) &&
                $grade <= (float) $this->getRowValue($descriptor, 'max', 0.0)
            ) {
                return (string) $this->getRowValue($descriptor, 'code', 'D');
            }
        }

        return 'D';
    }

    /**
     * @param array<string, array{raw: int|float, max: int|float}> $componentScores
     * @param array<string, int|float> $weights
     * @param array<int, array<string, mixed>|object> $transmutationRows
     *
     * @return array{written_work_percent: float|null, performance_task_percent: float|null,
     *               quarterly_assessment_percent: float|null, initial_grade: float,
     *               transmuted_grade: float, descriptor: string}
     */
    public function computeQuarterlyGrade(array $componentScores, array $weights, array $transmutationRows): array
    {
        $codes = $this->configuration->getComponentCodes();
        $percentages = [];

        foreach ($codes as $field => $code) {
            if (isset($componentScores[$code])) {
                $raw = (float) $componentScores[$code]['raw'];
                $max = (float) $componentScores[$code]['max'];
                $percentages[$code] = $this->computeComponentPercentage($raw, $max);
            }
        }

        $initialGrade = $this->computeInitialGrade($percentages, $weights);
        $transmutedGrade = $this->transmute($initialGrade, $transmutationRows);

        return [
            'written_work_percent' => isset($codes['written_work']) && isset($percentages[$codes['written_work']]) ? $percentages[$codes['written_work']] : null,
            'performance_task_percent' => isset($codes['performance_task']) && isset($percentages[$codes['performance_task']]) ? $percentages[$codes['performance_task']] : null,
            'quarterly_assessment_percent' => isset($codes['quarterly_assessment']) && isset($percentages[$codes['quarterly_assessment']]) ? $percentages[$codes['quarterly_assessment']] : null,
            'initial_grade' => $initialGrade,
            'transmuted_grade' => $transmutedGrade,
            'descriptor' => $this->getDescriptor($transmutedGrade),
        ];
    }

    /**
     * @param array<int, int|float> $quarterlyTransmutedGrades
     */
    public function computeFinalGrade(array $quarterlyTransmutedGrades): float
    {
        if (empty($quarterlyTransmutedGrades)) {
            return 0.0;
        }

        return round(array_sum($quarterlyTransmutedGrades) / count($quarterlyTransmutedGrades), 2);
    }

    /**
     * @param array<string, mixed>|object $row
     * @param mixed $default
     * @return mixed
     */
    protected function getRowValue($row, string $key, $default = null)
    {
        if (is_array($row)) {
            return array_key_exists($key, $row) ? $row[$key] : $default;
        }

        if (is_object($row) && isset($row->{$key})) {
            return $row->{$key};
        }

        return $default;
    }
}
