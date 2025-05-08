@extends('layouts.admin')
@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Bookings Management</h4>
            <form class="d-flex" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Search bookings..." aria-label="Search">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>User</th>
                            <th>Event</th>
                            <th>Ticket</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->user->name ?? '-' }}</td>
                            <td>{{ $booking->ticket->event->title ?? '-' }}</td>
                            <td>{{ $booking->ticket->type ?? '-' }}</td>
                            <td>{{ $booking->quantity }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status == 'completed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'secondary') }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-warning">Edit</a>
                                @if($booking->status != 'cancelled')
                                <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Cancel</button>
                                </form>
                                @endif
                                @if($booking->status != 'completed')
                                <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Mark as Completed</button>
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
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection 