<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        Route::patterns([
            'teacher_id' => '[0-9]+',
            'course_id'  => '[0-9]+',
            'exam_id'    => '[0-9]+',
            'section_id' => '[0-9]+',
            'student_id' => '[0-9]+',
            'school_code'=> '[0-9]+',
            'user_code'  => '[0-9]+',
            'id'         => '[0-9]+',
            'code'       => '[0-9]+',
            'role'       => '[a-z]+',
        ]);

        parent::boot();
    }
}
