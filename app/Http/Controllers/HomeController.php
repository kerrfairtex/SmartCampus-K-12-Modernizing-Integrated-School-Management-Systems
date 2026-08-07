<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        if (\Auth::user()->role !== 'master') {
            $minutes   = 1440;
            $school_id = \Auth::user()->school->id;

            $classes = \Cache::remember('classes-'.$school_id, $minutes, fn () =>
                \App\Myclass::bySchool($school_id)->pluck('id')->toArray()
            );

            return Inertia::render('Home', [
                'totalStudents' => \Cache::remember('totalStudents-'.$school_id, $minutes, fn () =>
                    \App\User::bySchool($school_id)->where('role', 'student')->where('active', 1)->count()
                ),
                'totalTeachers' => \Cache::remember('totalTeachers-'.$school_id, $minutes, fn () =>
                    \App\User::bySchool($school_id)->where('role', 'teacher')->where('active', 1)->count()
                ),
                'totalBooks' => \Cache::remember('totalBooks-'.$school_id, $minutes, fn () =>
                    \App\Book::bySchool($school_id)->count()
                ),
                'totalClasses' => \Cache::remember('totalClasses-'.$school_id, $minutes, fn () =>
                    \App\Myclass::bySchool($school_id)->count()
                ),
                'totalSections' => \Cache::remember('totalSections-'.$school_id, $minutes, fn () =>
                    \App\Section::whereIn('class_id', $classes)->count()
                ),
                'notices' => \Cache::remember('notices-'.$school_id, $minutes, fn () =>
                    \App\Notice::bySchool($school_id)->where('active', 1)->get()
                ),
                'events' => \Cache::remember('events-'.$school_id, $minutes, fn () =>
                    \App\Event::bySchool($school_id)->where('active', 1)->get()
                ),
                'routines' => \Cache::remember('routines-'.$school_id, $minutes, fn () =>
                    \App\Routine::bySchool($school_id)->where('active', 1)->get()
                ),
                'syllabuses' => \Cache::remember('syllabuses-'.$school_id, $minutes, fn () =>
                    \App\Syllabus::bySchool($school_id)->where('active', 1)->get()
                ),
                'exams' => \Cache::remember('exams-'.$school_id, $minutes, fn () =>
                    \App\Exam::bySchool($school_id)->where('active', 1)->get()
                ),
            ]);
        }

        return redirect('/masters');
    }
}
