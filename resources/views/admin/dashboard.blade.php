@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-dark text-center">
                <div class="card-body">
                    <h4>Admins</h4>
                    <div class="display-5">{{ $admins->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-info text-center">
                <div class="card-body">
                    <h4>Attendees</h4>
                    <div class="display-5">{{ $attendees->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-success text-center">
                <div class="card-body">
                    <h4>Organizers</h4>
                    <div class="display-5">{{ $organizers->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-primary text-center">
                <div class="card-body">
                    <h4>Total Users</h4>
                    <div class="display-5">{{ $users->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Latest Reports</div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>User</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestReports as $report)
                            <tr>
                                <td>{{ $report->event->title ?? '-' }}</td>
                                <td>{{ $report->user->name ?? '-' }}</td>
                                <td>{{ Str::limit($report->reason, 20) }}</td>
                                <td><span class="badge bg-{{ $report->status == 'pending' ? 'warning' : 'success' }}">{{ ucfirst($report->status) }}</span></td>
                                <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                <td><a href="{{ route('admin.reports.show', $report) }}" class="btn btn-sm btn-primary">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Latest Events</div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Organizer</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestEvents as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->organizer->user->name ?? '-' }}</td>
                                <td>{{ $event->start_date }}</td>
                                <td><span class="badge bg-{{ $event->is_published ? 'success' : 'secondary' }}">{{ $event->is_published ? 'Active' : 'Draft' }}</span></td>
                                <td><a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-primary">View</a></td>
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