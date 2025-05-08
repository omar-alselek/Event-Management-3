@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit User</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="organizer" {{ $user->role == 'organizer' ? 'selected' : '' }}>Organizer</option>
                                <option value="attendee" {{ $user->role == 'attendee' ? 'selected' : '' }}>Attendee</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="organization" class="form-label">Organization</label>
                            <input type="text" class="form-control" id="organization" name="organization" value="{{ $user->organization }}">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Save Changes</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100 mt-2">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 