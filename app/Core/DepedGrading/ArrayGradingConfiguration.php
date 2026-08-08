<?php

namespace App\Core\DepedGrading;

use App\Core\DepedGrading\Contracts\GradingConfiguration;

class ArrayGradingConfiguration implements GradingConfiguration
{
    /** @var array<string, int|float> */
    protected $defaultWeights;

    /** @var array<int, array{min: int|float, max: int|float, code: string}> */
    protected $descriptors;

    /** @var array{written_work: string, performance_task: string, quarterly_assessment: string} */
    protected $componentCodes;

    /**
     * @param array<string, int|float> $defaultWeights
     * @param array<int, array{min: int|float, max: int|float, code: string}> $descriptors
     * @param array{written_work: string, performance_task: string, quarterly_assessment: string} $componentCodes
     */
    public function __construct(array $defaultWeights, array $descriptors, array $componentCodes)
    {
        $this->defaultWeights = $defaultWeights;
        $this->descriptors = $descriptors;
        $this->componentCodes = $componentCodes;
    }

    public function getDefaultWeights(): array
    {
        return $this->defaultWeights;
    }

    public function getDescriptors(): array
    {
        return $this->descriptors;
    }

    public function getComponentCodes(): array
    {
        return $this->componentCodes;
    }
}
