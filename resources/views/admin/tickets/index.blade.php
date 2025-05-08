@extends('layouts.admin')
@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Tickets Management</h4>
            <form class="d-flex" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Search tickets..." aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Event</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->event->title ?? '-' }}</td>
                            <td>{{ $ticket->type }}</td>
                            <td>{{ $ticket->price }}</td>
                            <td>{{ $ticket->quantity }}</td>
                            <td>{{ $ticket->remaining_quantity }}</td>
                            <td>
                                @if($ticket->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @if($ticket->is_active)
                                    <form action="{{ route('admin.tickets.deactivate', $ticket) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-secondary">Deactivate</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.tickets.activate', $ticket) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">Activate</button>
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
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection 