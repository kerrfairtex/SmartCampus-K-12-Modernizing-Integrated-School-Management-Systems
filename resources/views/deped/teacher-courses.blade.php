@extends('layouts.app')

@section('title', 'DepEd Grade Entry')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">Quarterly Grading — Select Course</div>
                <div class="panel-body">
                    @if(!$schoolYear)
                        <div class="alert alert-warning">No active school year. Ask admin to create one under Academic → School Years.</div>
                    @else
                        <p class="text-muted">Active year: <strong>{{ $schoolYear->name }}</strong></p>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Quarter</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    @foreach($schoolYear->quarters as $quarter)
                                        <tr>
                                            <td>{{ $course->course_name }}</td>
                                            <td>{{ $course->section->class->class_number ?? '' }} - {{ $course->section->section_number ?? '' }}</td>
                                            <td>{{ $quarter->name }}</td>
                                            <td>
                                                <a href="{{ route('deped.entry', [$course->id, $quarter->id]) }}" class="btn btn-sm btn-primary">Enter WW/PT/QA</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
