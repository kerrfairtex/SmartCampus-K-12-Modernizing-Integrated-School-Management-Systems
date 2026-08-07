#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use App\Core\DepedGrading\ArrayGradingConfiguration;
use App\Core\DepedGrading\DepEdGradingCalculator;

/**
 * Usage:
 *   php php/deped_grading_standalone.php /path/to/input.json
 *   cat input.json | php php/deped_grading_standalone.php
 */

$input = '';

if (isset($argv[1])) {
    $input = (string) @file_get_contents($argv[1]);
} else {
    $input = (string) stream_get_contents(STDIN);
}

if ($input === '') {
    fwrite(STDERR, "Missing input JSON.\n");
    exit(1);
}

$payload = json_decode($input, true);
if (!is_array($payload)) {
    fwrite(STDERR, "Invalid JSON payload.\n");
    exit(1);
}

$configuration = new ArrayGradingConfiguration(
    isset($payload['default_weights']) && is_array($payload['default_weights']) ? $payload['default_weights'] : ['WW' => 40, 'PT' => 40, 'QA' => 20],
    isset($payload['descriptors']) && is_array($payload['descriptors']) ? $payload['descriptors'] : [
        ['min' => 90, 'max' => 100, 'code' => 'O'],
        ['min' => 85, 'max' => 89.99, 'code' => 'VS'],
        ['min' => 80, 'max' => 84.99, 'code' => 'S'],
        ['min' => 75, 'max' => 79.99, 'code' => 'FS'],
        ['min' => 0, 'max' => 74.99, 'code' => 'D'],
    ],
    isset($payload['component_codes']) && is_array($payload['component_codes']) ? $payload['component_codes'] : [
        'written_work' => 'WW',
        'performance_task' => 'PT',
        'quarterly_assessment' => 'QA',
    ]
);

$calculator = new DepEdGradingCalculator($configuration);

$result = $calculator->computeQuarterlyGrade(
    isset($payload['component_scores']) && is_array($payload['component_scores']) ? $payload['component_scores'] : [],
    isset($payload['weights']) && is_array($payload['weights']) ? $payload['weights'] : $configuration->getDefaultWeights(),
    isset($payload['transmutation_rows']) && is_array($payload['transmutation_rows']) ? $payload['transmutation_rows'] : []
);

echo json_encode($result, JSON_PRETTY_PRINT).PHP_EOL;
