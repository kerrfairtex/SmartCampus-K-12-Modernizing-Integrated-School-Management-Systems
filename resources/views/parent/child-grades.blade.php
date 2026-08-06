@extends('layouts.app')

@section('title', 'Child Grades')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">Grades — {{ $student->name }}</div>
                <div class="panel-body">
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-default btn-sm">← Back</a>
                    @if($schoolYear)
                        @foreach($grades as $courseGrades)
                            <h4>{{ $courseGrades->first()->course->course_name }}</h4>
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr><th>Quarter</th><th>Grade</th><th>Descriptor</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($courseGrades as $g)
                                        <tr>
                                            <td>{{ $g->quarter->name }}</td>
                                            <td>{{ $g->transmuted_grade }}</td>
                                            <td>{{ $g->descriptor }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
