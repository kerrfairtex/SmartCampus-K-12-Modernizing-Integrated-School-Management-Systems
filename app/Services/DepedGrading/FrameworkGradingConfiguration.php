<?php

namespace App\Services\DepedGrading;

use App\Core\DepedGrading\Contracts\GradingConfiguration;

class FrameworkGradingConfiguration implements GradingConfiguration
{
    public function getDefaultWeights(): array
    {
        return config('deped_grading.default_weights', []);
    }

    public function getDescriptors(): array
    {
        return config('deped_grading.descriptors', []);
    }

    public function getComponentCodes(): array
    {
        return config('deped_grading.component_codes', []);
    }
}
