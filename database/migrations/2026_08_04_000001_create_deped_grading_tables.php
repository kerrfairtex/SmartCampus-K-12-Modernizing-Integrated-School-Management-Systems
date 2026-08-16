<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepedGradingTables extends Migration
{
    /**
     * DepEd K-12 quarterly grading schema for SmartCampus.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_years', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->unsigned();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(false);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->unique(['school_id', 'name']);
        });

        Schema::create('quarters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_year_id')->unsigned();
            $table->unsignedTinyInteger('quarter_number');
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['school_year_id', 'quarter_number']);
        });

        Schema::create('grading_component_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('default_weight_percent');
            $table->timestamps();
        });

        Schema::create('course_grading_weights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->integer('grading_component_type_id')->unsigned();
            $table->unsignedTinyInteger('weight_percent');
            $table->timestamps();

            $table->unique(['course_id', 'grading_component_type_id'], 'course_component_weight_unique');
        });

        Schema::create('deped_transmutation_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('deped_transmutation_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deped_transmutation_table_id')->unsigned();
            $table->decimal('from_score', 5, 2);
            $table->decimal('to_score', 5, 2);
            $table->decimal('transmuted_grade', 5, 2);
            $table->timestamps();
        });

        Schema::create('quarterly_component_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quarter_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->integer('grading_component_type_id')->unsigned();
            $table->decimal('raw_score', 8, 2);
            $table->decimal('max_score', 8, 2)->default(100);
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->unique(
                ['quarter_id', 'course_id', 'student_id', 'grading_component_type_id'],
                'quarterly_component_unique'
            );
        });

        Schema::create('quarterly_grades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quarter_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->decimal('written_work_percent', 5, 2)->nullable();
            $table->decimal('performance_task_percent', 5, 2)->nullable();
            $table->decimal('quarterly_assessment_percent', 5, 2)->nullable();
            $table->decimal('initial_grade', 5, 2);
            $table->decimal('transmuted_grade', 5, 2);
            $table->string('descriptor', 5)->nullable();
            $table->string('remarks')->nullable();
            $table->integer('teacher_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamp('computed_at')->nullable();
            $table->timestamps();

            $table->unique(['quarter_id', 'course_id', 'student_id'], 'quarterly_grade_unique');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quarterly_grades');
        Schema::dropIfExists('quarterly_component_scores');
        Schema::dropIfExists('deped_transmutation_rows');
        Schema::dropIfExists('deped_transmutation_tables');
        Schema::dropIfExists('course_grading_weights');
        Schema::dropIfExists('grading_component_types');
        Schema::dropIfExists('quarters');
        Schema::dropIfExists('school_years');
    }
}
