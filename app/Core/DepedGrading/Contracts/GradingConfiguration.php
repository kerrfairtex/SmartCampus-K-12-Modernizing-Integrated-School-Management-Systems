<?php

namespace App\Core\DepedGrading\Contracts;

interface GradingConfiguration
{
    /**
     * @return array<string, int|float>
     */
    public function getDefaultWeights(): array;

    /**
     * @return array<int, array{min: int|float, max: int|float, code: string}>
     */
    public function getDescriptors(): array;

    /**
     * @return array{written_work: string, performance_task: string, quarterly_assessment: string}
     */
    public function getComponentCodes(): array;
}
