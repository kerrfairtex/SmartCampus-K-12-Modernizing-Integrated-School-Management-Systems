@extends('layouts.app')

@section('title', 'My Quarterly Grades')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">Quarterly Grades — {{ $student->name }}</div>
                <div class="panel-body">
                    @if(!$schoolYear)
                        <div class="alert alert-info">No active school year configured.</div>
                    @else
                        <p>School Year: <strong>{{ $schoolYear->name }}</strong></p>
                        <a href="{{ route('reports.sf9', $student->id) }}" class="btn btn-primary" target="_blank">Download SF9 Report</a>
                        <hr>
                        @foreach($grades as $courseId => $courseGrades)
                            <h4>{{ $courseGrades->first()->course->course_name }}</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Quarter</th>
                                        <th>WW%</th>
                                        <th>PT%</th>
                                        <th>QA%</th>
                                        <th>Grade</th>
                                        <th>Descriptor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courseGrades as $g)
                                        <tr>
                                            <td>{{ $g->quarter->name }}</td>
                                            <td>{{ $g->written_work_percent }}</td>
                                            <td>{{ $g->performance_task_percent }}</td>
                                            <td>{{ $g->quarterly_assessment_percent }}</td>
                                            <td><strong>{{ $g->transmuted_grade }}</strong></td>
                                            <td>{{ $g->descriptor }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @empty
                            <p>No quarterly grades yet.</p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
