<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DepEd K-12 default grading component weights (Written Work, Performance
    | Tasks, Quarterly Assessment). Schools may override per course.
    |--------------------------------------------------------------------------
    */
    'default_weights' => [
        'WW' => 40,
        'PT' => 40,
        'QA' => 20,
    ],

    /*
    |--------------------------------------------------------------------------
    | DepEd performance descriptors for quarterly and final grades.
    |--------------------------------------------------------------------------
    */
    'descriptors' => [
        ['min' => 90, 'max' => 100, 'code' => 'O', 'label' => 'Outstanding'],
        ['min' => 85, 'max' => 89.99, 'code' => 'VS', 'label' => 'Very Satisfactory'],
        ['min' => 80, 'max' => 84.99, 'code' => 'S', 'label' => 'Satisfactory'],
        ['min' => 75, 'max' => 79.99, 'code' => 'FS', 'label' => 'Fairly Satisfactory'],
        ['min' => 0, 'max' => 74.99, 'code' => 'D', 'label' => 'Did Not Meet Expectations'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Component type codes used across the grading service.
    |--------------------------------------------------------------------------
    */
    'component_codes' => [
        'written_work' => 'WW',
        'performance_task' => 'PT',
        'quarterly_assessment' => 'QA',
    ],
];
