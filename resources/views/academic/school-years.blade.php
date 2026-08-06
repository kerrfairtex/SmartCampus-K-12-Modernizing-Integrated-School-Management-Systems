@extends('layouts.app')

@section('title', 'School Years')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">DepEd School Years & Quarters</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('school-years.store') }}" class="form-inline" style="margin-bottom: 24px;">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="2025-2026" required>
                        </div>
                        <div class="form-group">
                            <label>Start</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>End</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Year + Q1–Q4</button>
                    </form>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>School Year</th>
                                <th>Period</th>
                                <th>Status</th>
                                <th>Quarters</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schoolYears as $year)
                                <tr>
                                    <td><strong>{{ $year->name }}</strong></td>
                                    <td>{{ $year->start_date->format('M d, Y') }} – {{ $year->end_date->format('M d, Y') }}</td>
                                    <td>
                                        @if($year->is_active)
                                            <span class="label label-success">Active</span>
                                        @else
                                            <span class="label label-default">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($year->quarters as $q)
                                            <span class="label label-info">{{ $q->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4">No school years yet. Create one to enable DepEd quarterly grading.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
