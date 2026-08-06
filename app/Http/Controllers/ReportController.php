<?php

namespace App\Http\Controllers;

use App\Course;
use App\QuarterlyGrade;
use App\SchoolYear;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * DepEd SF9 — Learner's Progress Report Card (print-ready HTML).
     */
    public function sf9($studentId, $schoolYearId = null)
    {
        $student = User::with(['section.class.school', 'studentInfo'])->findOrFail($studentId);
        $this->authorizeStudentAccess($student);

        $schoolYear = $schoolYearId
            ? SchoolYear::with('quarters')->findOrFail($schoolYearId)
            : SchoolYear::with('quarters')
                ->where('school_id', $student->school_id)
                ->where('is_active', true)
                ->firstOrFail();

        $grades = QuarterlyGrade::with(['course', 'quarter'])
            ->where('student_id', $student->id)
            ->whereIn('quarter_id', $schoolYear->quarters->pluck('id'))
            ->get()
            ->groupBy('course_id');

        $courses = Course::whereIn('id', $grades->keys())->get()->keyBy('id');

        return view('reports.sf9', compact('student', 'schoolYear', 'grades', 'courses'));
    }

    protected function authorizeStudentAccess(User $student)
    {
        $user = auth()->user();

        if ($user->hasRole('student') && $user->id !== $student->id) {
            abort(403);
        }

        if ($user->hasRole('parent')) {
            $linked = \App\ParentStudent::where('parent_id', $user->id)
                ->where('student_id', $student->id)
                ->exists();
            if (!$linked) {
                abort(403);
            }
        }

        if ($user->hasRole('teacher') || $user->hasRole('admin')) {
            if ($student->school_id !== $user->school_id) {
                abort(403);
            }
            return;
        }

        if (!$user->hasRole('student') && !$user->hasRole('parent') && !$user->hasRole('admin') && !$user->hasRole('teacher')) {
            abort(403);
        }
    }
}
