<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\ParentStudent;
use App\QuarterlyGrade;
use App\SchoolYear;
use App\User;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'parent']);
    }

    public function dashboard()
    {
        $links = ParentStudent::with(['student.section.class'])
            ->where('parent_id', auth()->id())
            ->get();

        return view('parent.dashboard', compact('links'));
    }

    public function childGrades($studentId)
    {
        $link = ParentStudent::where('parent_id', auth()->id())
            ->where('student_id', $studentId)
            ->firstOrFail();

        $student = User::with('section.class')->findOrFail($link->student_id);
        $schoolYear = SchoolYear::with('quarters')
            ->where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->first();

        $grades = collect();
        if ($schoolYear) {
            $grades = QuarterlyGrade::with(['course', 'quarter'])
                ->where('student_id', $student->id)
                ->whereIn('quarter_id', $schoolYear->quarters->pluck('id'))
                ->get()
                ->groupBy('course_id');
        }

        return view('parent.child-grades', compact('student', 'schoolYear', 'grades'));
    }

    public function childAttendance($studentId)
    {
        $link = ParentStudent::where('parent_id', auth()->id())
            ->where('student_id', $studentId)
            ->firstOrFail();

        $student = User::with('section.class')->findOrFail($link->student_id);
        $attendances = Attendance::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->limit(60)
            ->get();

        $present = $attendances->where('present', 1)->count();
        $total = $attendances->count();
        $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;

        return view('parent.child-attendance', compact('student', 'attendances', 'rate', 'present', 'total'));
    }
}
