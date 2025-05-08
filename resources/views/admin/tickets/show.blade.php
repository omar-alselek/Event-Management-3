@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Ticket Details</h3>
                </div>
                <div class="card-body">
                    <h5>Type: {{ $ticket->type }}</h5>
                    <p><strong>Price:</strong> ${{ $ticket->price }}</p>
                    <p><strong>Quantity:</strong> {{ $ticket->quantity }}</p>
                    <p><strong>Description:</strong> {{ $ticket->description ?? '-' }}</p>
                    @if(isset($ticket->is_active))
                        <p><strong>Status:</strong> <span class="badge bg-{{ $ticket->is_active ? 'success' : 'secondary' }}">{{ $ticket->is_active ? 'Active' : 'Inactive' }}</span></p>
                    @endif
                    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="btn btn-warning">Edit Ticket</a>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Back to Tickets</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 