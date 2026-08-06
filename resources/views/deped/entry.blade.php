@extends('layouts.app')

@section('title', 'Score Entry')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">
                    {{ $course->course_name }} — {{ $quarter->name }} ({{ $quarter->schoolYear->name }})
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('deped.scores.store', [$course->id, $quarter->id]) }}">
                        {{ csrf_field() }}
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    @foreach($components as $comp)
                                        <th>{{ $comp->name }} ({{ $comp->code }})<br><small>raw / max</small></th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        @foreach($components as $comp)
                                            @php
                                                $score = isset($existingScores[$student->id])
                                                    ? $existingScores[$student->id]->firstWhere('grading_component_type_id', $comp->id)
                                                    : null;
                                            @endphp
                                            <td>
                                                <input type="number" step="0.01" min="0"
                                                    name="students[{{ $student->id }}][{{ $comp->code }}][raw]"
                                                    value="{{ $score ? $score->raw_score : '' }}"
                                                    class="form-control input-sm" style="width:70px;display:inline-block">
                                                /
                                                <input type="number" step="0.01" min="1"
                                                    name="students[{{ $student->id }}][{{ $comp->code }}][max]"
                                                    value="{{ $score ? $score->max_score : 100 }}"
                                                    class="form-control input-sm" style="width:60px;display:inline-block">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Save & Compute Grades</button>
                        <a href="{{ route('deped.teacher-courses') }}" class="btn btn-default">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
