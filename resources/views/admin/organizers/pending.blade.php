@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Pending Organizer Requests</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Action</th>
                                    <th>Document</th>
                                    <th>Organization</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Organizer Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($organizers as $organizer)
                                    <tr>
                                        <td>
                                            <form method="POST" action="{{ route('admin.organizers.approve', $organizer) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                        </td>
                                        <td>
                                            @if($organizer->document_path)
                                                <a href="{{ asset('storage/'.$organizer->document_path) }}" target="_blank">View Document</a>
                                            @else
                                                <span class="text-muted">No Document</span>
                                            @endif
                                        </td>
                                        <td>{{ $organizer->user->organization ?? '-' }}</td>
                                        <td>{{ $organizer->user->phone ?? '-' }}</td>
                                        <td>{{ $organizer->user->email ?? '-' }}</td>
                                        <td>{{ $organizer->user->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">No pending organizer requests.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 