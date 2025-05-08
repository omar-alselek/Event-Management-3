@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Booking Details</h3>
                </div>
                <div class="card-body">
                    <h5>User: {{ $booking->user->name ?? '-' }} ({{ $booking->user->email ?? '-' }})</h5>
                    <p><strong>Event:</strong> {{ $booking->ticket->event->title ?? '-' }}</p>
                    <p><strong>Ticket Type:</strong> {{ $booking->ticket->type ?? '-' }}</p>
                    <p><strong>Quantity:</strong> {{ $booking->quantity }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-{{ $booking->status == 'completed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'secondary') }}">{{ ucfirst($booking->status) }}</span></p>
                    <p><strong>Date:</strong> {{ $booking->created_at }}</p>
                    @if($booking->qr_code)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$booking->qr_code) }}" alt="QR Code" class="img-fluid" style="max-width:200px;">
                        </div>
                    @endif
                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning">Edit Booking</a>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 