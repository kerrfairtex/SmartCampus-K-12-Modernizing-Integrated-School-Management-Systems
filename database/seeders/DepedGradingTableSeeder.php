<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\GradingComponentType;
use App\DepedTransmutationTable;
use App\DepedTransmutationRow;

class DepedGradingTableSeeder extends Seeder
{
    /**
     * Seed DepEd K-12 grading component types and default transmutation table.
     *
     * @return void
     */
    public function run()
    {
        $components = [
            [
                'code' => 'WW',
                'name' => 'Written Work',
                'description' => 'DepEd Written Work component (quizzes, seatwork, etc.)',
                'default_weight_percent' => 40,
            ],
            [
                'code' => 'PT',
                'name' => 'Performance Task',
                'description' => 'DepEd Performance Tasks (projects, practical work, etc.)',
                'default_weight_percent' => 40,
            ],
            [
                'code' => 'QA',
                'name' => 'Quarterly Assessment',
                'description' => 'DepEd Quarterly Assessment (periodical exam)',
                'default_weight_percent' => 20,
            ],
        ];

        foreach ($components as $component) {
            GradingComponentType::firstOrCreate(
                ['code' => $component['code']],
                $component
            );
        }

        $table = DepedTransmutationTable::firstOrCreate(
            ['name' => 'DepEd Standard (Percentage)'],
            [
                'school_id' => null,
                'description' => 'Default 1:1 transmutation for percentage-based initial grades (60–100).',
                'is_default' => true,
            ]
        );

        if ($table->rows()->count() === 0) {
            $rows = [];
            for ($grade = 100; $grade >= 60; $grade--) {
                $rows[] = [
                    'deped_transmutation_table_id' => $table->id,
                    'from_score' => $grade,
                    'to_score' => $grade === 100 ? 100 : $grade + 0.99,
                    'transmuted_grade' => $grade,
                ];
            }
            // Below 60 maps to failing band per DepEd practice
            $rows[] = [
                'deped_transmutation_table_id' => $table->id,
                'from_score' => 0,
                'to_score' => 59.99,
                'transmuted_grade' => 60,
            ];

            foreach ($rows as $row) {
                DepedTransmutationRow::create($row);
            }
        }
    }
}
