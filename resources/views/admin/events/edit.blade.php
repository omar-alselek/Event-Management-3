@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">Edit Event</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.events.update', $event) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $event->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $event->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ $event->category }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ $event->start_date ? date('Y-m-d\TH:i', strtotime($event->start_date)) : '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ $event->end_date ? date('Y-m-d\TH:i', strtotime($event->end_date)) : '' }}" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Save Changes</button>
                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-secondary w-100 mt-2">Back to Event</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 