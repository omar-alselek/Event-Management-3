@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Event Reports</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Event</th>
                <th>User</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->event->title ?? '-' }}</td>
                    <td>{{ $report->user->name ?? '-' }}</td>
                    <td>{{ $report->reason }}</td>
                    <td>{{ ucfirst($report->status) }}</td>
                    <td><a href="{{ route('admin.reports.show', $report) }}" class="btn btn-info btn-sm">View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 