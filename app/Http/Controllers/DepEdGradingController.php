<?php

namespace App\Http\Controllers;

use App\Course;
use App\GradingComponentType;
use App\Quarter;
use App\QuarterlyComponentScore;
use App\QuarterlyGrade;
use App\SchoolYear;
use App\Section;
use App\Services\DepedGrading\DepEdGradingService;
use App\User;
use Illuminate\Http\Request;

class DepEdGradingController extends Controller
{
    protected $gradingService;

    public function __construct(DepEdGradingService $gradingService)
    {
        $this->middleware('auth');
        $this->gradingService = $gradingService;
    }

    public function teacherCourses()
    {
        $this->authorizeTeacher();

        $schoolYear = $this->activeSchoolYear();
        $courses = Course::with(['section.class', 'exam'])
            ->where('school_id', auth()->user()->school_id)
            ->where('teacher_id', auth()->id())
            ->get();

        return view('deped.teacher-courses', compact('courses', 'schoolYear'));
    }

    public function entryForm($courseId, $quarterId)
    {
        $this->authorizeTeacher();

        $course = Course::with('section')
            ->where('id', $courseId)
            ->where('school_id', auth()->user()->school_id)
            ->firstOrFail();

        if (auth()->user()->hasRole('teacher') && (int) $course->teacher_id !== (int) auth()->id()) {
            abort(403);
        }

        $quarter = Quarter::with('schoolYear')->findOrFail($quarterId);
        if ((int) $quarter->schoolYear->school_id !== (int) auth()->user()->school_id) {
            abort(403);
        }
        $components = GradingComponentType::orderBy('id')->get();

        $students = User::where('section_id', $course->section_id)
            ->where('role', 'student')
            ->where('active', 1)
            ->orderBy('name')
            ->get();

        $existingScores = QuarterlyComponentScore::where('quarter_id', $quarterId)
            ->where('course_id', $courseId)
            ->get()
            ->groupBy('student_id');

        return view('deped.entry', compact('course', 'quarter', 'components', 'students', 'existingScores'));
    }

    public function storeScores(Request $request, $courseId, $quarterId)
    {
        $this->authorizeTeacher();

        $course = Course::findOrFail($courseId);
        $this->gradingService->ensureDefaultWeightsForCourse($course);

        $components = GradingComponentType::all()->keyBy('code');

        foreach ($request->input('students', []) as $studentId => $studentScores) {
            foreach ($studentScores as $code => $data) {
                if (!isset($components[$code])) {
                    continue;
                }
                $raw = isset($data['raw']) ? (float) $data['raw'] : null;
                if ($raw === null) {
                    continue;
                }
                $max = isset($data['max']) ? (float) $data['max'] : 100;

                QuarterlyComponentScore::updateOrCreate(
                    [
                        'quarter_id' => $quarterId,
                        'course_id' => $courseId,
                        'student_id' => $studentId,
                        'grading_component_type_id' => $components[$code]->id,
                    ],
                    [
                        'raw_score' => $raw,
                        'max_score' => $max > 0 ? $max : 100,
                        'teacher_id' => auth()->id(),
                        'user_id' => auth()->id(),
                    ]
                );

                $this->gradingService->computeAndPersistQuarterlyGrade(
                    $quarterId,
                    $courseId,
                    $studentId,
                    auth()->id(),
                    auth()->id()
                );
            }
        }

        return redirect()->route('deped.entry', [$courseId, $quarterId])
            ->with('status', 'Scores saved and quarterly grades computed.');
    }

    public function sectionGrades($sectionId, $quarterId)
    {
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher')) {
            return redirect('home');
        }

        $section = Section::with('class')->findOrFail($sectionId);
        $quarter = Quarter::with('schoolYear')->findOrFail($quarterId);

        $grades = QuarterlyGrade::with(['student', 'course'])
            ->whereHas('course', function ($q) use ($sectionId) {
                $q->where('section_id', $sectionId);
            })
            ->where('quarter_id', $quarterId)
            ->orderBy('student_id')
            ->get()
            ->groupBy('student_id');

        return view('deped.section-grades', compact('section', 'quarter', 'grades'));
    }

    public function studentQuarterly($studentId = null)
    {
        $user = auth()->user();
        if ($user->hasRole('student')) {
            $studentId = $user->id;
        }

        $student = User::with('section.class')->findOrFail($studentId);
        $schoolYear = $this->activeSchoolYear();

        $grades = collect();
        if ($schoolYear) {
            $quarterIds = $schoolYear->quarters->pluck('id');
            $grades = QuarterlyGrade::with(['course', 'quarter'])
                ->where('student_id', $student->id)
                ->whereIn('quarter_id', $quarterIds)
                ->get()
                ->groupBy('course_id');
        }

        return view('deped.student-quarterly', compact('student', 'schoolYear', 'grades'));
    }

    protected function activeSchoolYear()
    {
        return SchoolYear::with('quarters')
            ->where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->first();
    }

    protected function authorizeTeacher()
    {
        if (!auth()->user()->hasRole('teacher') && !auth()->user()->hasRole('admin')) {
            abort(403);
        }
    }
}
