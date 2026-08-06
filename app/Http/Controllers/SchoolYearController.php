<?php

namespace App\Http\Controllers;

use App\SchoolYear;
use App\Services\DepedGrading\DepEdGradingService;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    protected $gradingService;

    public function __construct(DepEdGradingService $gradingService)
    {
        $this->middleware(['auth', 'admin']);
        $this->gradingService = $gradingService;
    }

    public function index()
    {
        $schoolYears = SchoolYear::with('quarters')
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('academic.school-years', compact('schoolYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        SchoolYear::where('school_id', auth()->user()->school_id)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $this->gradingService->createSchoolYearWithQuarters(
            auth()->user()->school_id,
            $request->name,
            $request->start_date,
            $request->end_date,
            auth()->id(),
            true
        );

        return redirect()->route('school-years.index')
            ->with('status', 'School year created with Q1–Q4 quarters.');
    }
}
