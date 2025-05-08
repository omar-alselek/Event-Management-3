@extends('layouts.admin')
@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Events Management</h4>
            <form class="d-flex" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Search events..." aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Organizer</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->organizer->user->name ?? '-' }}</td>
                            <td>{{ $event->start_date }} - {{ $event->end_date }}</td>
                            <td>
                                @if($event->is_published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @if($event->is_published)
                                    <form action="{{ route('admin.events.unpublish', $event) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-secondary">Unpublish</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.events.publish', $event) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Publish</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection 