@extends('layouts.app')

@section('title', 'Parent Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">Parent Portal</div>
                <div class="panel-body">
                    <p class="text-muted">View your children's attendance and DepEd quarterly grades.</p>
                    @forelse($links as $link)
                        <div class="well">
                            <h4>{{ $link->student->name }}</h4>
                            <p>
                                Class {{ $link->student->section->class->class_number ?? '' }}
                                Section {{ $link->student->section->section_number ?? '' }}
                            </p>
                            <a href="{{ route('parent.child.grades', $link->student_id) }}" class="btn btn-primary btn-sm">Quarterly Grades</a>
                            <a href="{{ route('parent.child.attendance', $link->student_id) }}" class="btn btn-default btn-sm">Attendance</a>
                            <a href="{{ route('reports.sf9', $link->student_id) }}" class="btn btn-default btn-sm" target="_blank">SF9 Report</a>
                        </div>
                    @empty
                        <div class="alert alert-info">No children linked to your account. Contact the school administrator.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
