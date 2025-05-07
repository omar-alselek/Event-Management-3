@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Pending Organizer Requests</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Organizer Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Organization</th>
                <th>Document</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($organizers as $organizer)
                <tr>
                    <td>{{ $organizer->user->name }}</td>
                    <td>{{ $organizer->user->email }}</td>
                    <td>{{ $organizer->user->phone }}</td>
                    <td>{{ $organizer->user->organization }}</td>
                    <td>
                        @if($organizer->document_path)
                            <a href="{{ asset('storage/'.$organizer->document_path) }}" target="_blank">View Document</a>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.organizers.approve', $organizer) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 