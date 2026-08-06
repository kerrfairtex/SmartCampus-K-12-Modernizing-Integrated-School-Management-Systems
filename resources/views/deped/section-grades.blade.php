@extends('layouts.app')

@section('title', 'Section Quarterly Grades')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">
                    {{ $section->class->class_number }} Section {{ $section->section_number }} — {{ $quarter->name }}
                </div>
                <div class="panel-body table-responsive">
                    @forelse($grades as $studentId => $studentGrades)
                        @php $student = $studentGrades->first()->student; @endphp
                        <h4>{{ $student->name }}</h4>
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Initial</th>
                                    <th>Transmuted</th>
                                    <th>Descriptor</th>
                                    <th>SF9</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentGrades as $g)
                                    <tr>
                                        <td>{{ $g->course->course_name }}</td>
                                        <td>{{ $g->initial_grade }}</td>
                                        <td>{{ $g->transmuted_grade }}</td>
                                        <td><span class="label label-primary">{{ $g->descriptor }}</span></td>
                                        <td>
                                            <a href="{{ route('reports.sf9', $student->id) }}" target="_blank" class="btn btn-xs btn-default">View SF9</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @empty
                        <p>No quarterly grades recorded for this section yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
