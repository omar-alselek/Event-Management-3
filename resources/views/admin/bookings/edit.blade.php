@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">Edit Booking</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Save Changes</button>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-secondary w-100 mt-2">Back to Booking</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 