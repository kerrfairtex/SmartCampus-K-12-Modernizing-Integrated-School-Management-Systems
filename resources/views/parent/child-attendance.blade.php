@extends('layouts.app')

@section('title', 'Child Attendance')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">Attendance — {{ $student->name }}</div>
                <div class="panel-body">
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-default btn-sm">← Back</a>
                    <div class="alert alert-info">
                        Attendance rate (recent records): <strong>{{ $rate }}%</strong>
                        ({{ $present }} present / {{ $total }} records)
                    </div>
                    <table class="table table-striped table-condensed">
                        <thead><tr><th>Date</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($attendances as $a)
                                <tr>
                                    <td>{{ $a->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $a->present ? 'Present' : 'Absent' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
