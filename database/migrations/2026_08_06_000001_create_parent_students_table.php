<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('parent_students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->integer('school_id')->unsigned();
            $table->timestamps();

            $table->unique(['parent_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('parent_students');
    }
}
