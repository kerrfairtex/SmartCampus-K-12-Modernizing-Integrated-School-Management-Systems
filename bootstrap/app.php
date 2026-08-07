<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
        ]);

        $middleware->alias([
            'master'          => \App\Http\Middleware\CheckMaster::class,
            'master.admin'    => \App\Http\Middleware\CheckMasterOrAdmin::class,
            'teacher.student' => \App\Http\Middleware\CheckTeacherOrStudent::class,
            'admin'           => \App\Http\Middleware\CheckAdmin::class,
            'accountant'      => \App\Http\Middleware\CheckAccountant::class,
            'librarian'       => \App\Http\Middleware\CheckLibrarian::class,
            'student'         => \App\Http\Middleware\CheckStudent::class,
            'teacher'         => \App\Http\Middleware\CheckTeacher::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
