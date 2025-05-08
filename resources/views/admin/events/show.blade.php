@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Event Details</h3>
                </div>
                <div class="card-body">
                    <h4>{{ $event->title }}</h4>
                    <p class="mb-2"><strong>Description:</strong> {{ $event->description }}</p>
                    <p class="mb-2"><strong>Location:</strong> {{ $event->location }}</p>
                    <p class="mb-2"><strong>Category:</strong> {{ $event->category }}</p>
                    <p class="mb-2"><strong>Start Date:</strong> {{ $event->start_date }}</p>
                    <p class="mb-2"><strong>End Date:</strong> {{ $event->end_date }}</p>
                    <p class="mb-2"><strong>Organizer:</strong> {{ $event->organizer->user->name ?? '-' }}</p>
                    <p class="mb-2"><strong>Status:</strong> <span class="badge bg-{{ $event->is_published ? 'success' : 'secondary' }}">{{ $event->is_published ? 'Published' : 'Draft' }}</span></p>
                    @if($event->image_path)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$event->image_path) }}" alt="Event Image" class="img-fluid rounded">
                        </div>
                    @endif
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">Edit Event</a>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Back to Events</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 