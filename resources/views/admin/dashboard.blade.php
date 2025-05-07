@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-6">{{ $users->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Organizers</h5>
                    <p class="card-text display-6">{{ $organizers->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Attendees</h5>
                    <p class="card-text display-6">{{ $attendees->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-dark mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Admins</h5>
                    <p class="card-text display-6">{{ $admins->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <h4 class="mb-3">All Users</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Approved</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->is_approved ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 