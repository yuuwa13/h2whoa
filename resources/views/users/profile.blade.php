@extends('layouts.app') <!-- This is me assuming we will have a layout file -->

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">My Profile</h2>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $user->name }}</h4>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
            <p class="card-text"><strong>Registered:</strong> {{ $user->created_at->format('F j, Y') }}</p>

            <!-- Edit button -->
            <a href="{{ route('users.editprofile') }}" class="btn btn-primary mt-3">Edit Profile</a>
        </div>
    </div>

    <!-- Change password -->

    <div class="card mb-4">
        <div class="card-header">Change Password</div>
        <div class="card-body">
            @if (session('password_success'))
                <div class="alert alert-success">{{ session('password_success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('user.changePassword') }}">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning">Update Password</button>
            </form>
        </div>
    </div>
    <!-- Delete button -->
    <form method="POST" action="{{ route('user.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-4">Delete Account</button>
    </form>
    
</div>
@endsection
