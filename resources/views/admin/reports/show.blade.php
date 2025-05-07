@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2 class="mb-4">Report Details</h2>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Event:</strong> {{ $report->event->title ?? '-' }}</p>
            <p><strong>User:</strong> {{ $report->user->name ?? '-' }}</p>
            <p><strong>Reason:</strong> {{ $report->reason }}</p>
            <p><strong>Status:</strong> {{ ucfirst($report->status) }}</p>
            <p><strong>Admin Notes:</strong> {{ $report->admin_notes }}</p>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.reports.update', $report) }}">
        @csrf
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending" @if($report->status=='pending') selected @endif>Pending</option>
                <option value="resolved" @if($report->status=='resolved') selected @endif>Resolved</option>
                <option value="rejected" @if($report->status=='rejected') selected @endif>Rejected</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="admin_notes" class="form-label">Admin Notes</label>
            <textarea name="admin_notes" id="admin_notes" class="form-control">{{ $report->admin_notes }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.reports') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection 