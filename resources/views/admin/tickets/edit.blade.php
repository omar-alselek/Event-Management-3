@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">Edit Ticket</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ $ticket->type }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $ticket->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $ticket->quantity }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $ticket->description }}</textarea>
                        </div>
                        @if(isset($ticket->is_active))
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ $ticket->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-success w-100">Save Changes</button>
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-secondary w-100 mt-2">Back to Ticket</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 