@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Event Reports</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 text-center align-middle">
                            <thead class="table-dark">
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
                                @forelse($reports as $report)
                                <tr>
                                    <td>{{ $report->id }}</td>
                                    <td>{{ $report->event->title ?? '-' }}</td>
                                    <td>{{ $report->user->name ?? '-' }}</td>
                                    <td>{{ $report->reason }}</td>
                                    <td>
                                        <span class="badge bg-{{ $report->status == 'pending' ? 'warning' : ($report->status == 'resolved' ? 'success' : 'secondary') }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-info btn-sm">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">No reports found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 