@extends('layouts.app')
@section('content')

<!-- Hero -->
<div class="hero-section text-white" style="background: linear-gradient(135deg, #696cff 0%, #4a4fbf 50%, #8592a3 100%); padding: 56px 0;">
    <div class="container">
        <h1 style="font-weight: 700; margin: 0;">Manage Users</h1>
        <p class="mb-0 mt-1" style="color: rgba(255,255,255,.85); font-size: 1.05rem;">Create, edit, and remove accounts for the COTS Tracker system.</p>
    </div>
</div>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Add New User -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm" style="border: none;">
                <h5 class="card-header" style="font-weight: 600;">Add New User</h5>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role_id" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm" style="border: none;">
                <h5 class="card-header" style="font-weight: 600;">
                    Users List
                    <span class="badge rounded-pill text-white" style="background: #696cff;">{{ $users->count() }}</span>
                </h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge text-white" style="background: #696cff;">{{ $user->role->role_name }}</span></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="collapse" data-bs-target="#editUser{{ $user->id }}" aria-expanded="false" aria-controls="editUser{{ $user->id }}">
                                    <i class="bx bx-edit"></i>
                                </button>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr class="collapse" id="editUser{{ $user->id }}">
                            <td colspan="4" class="p-3" style="background: #f8f9fa;">
                                <h6 class="mb-3">Edit: {{ $user->name }}</h6>
                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="editName{{ $user->id }}" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="editName{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editEmail{{ $user->id }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="editEmail{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editPassword{{ $user->id }}" class="form-label">New Password <span class="text-muted">(blank = unchanged)</span></label>
                                            <input type="password" class="form-control" id="editPassword{{ $user->id }}" name="password">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editPasswordConfirmation{{ $user->id }}" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="editPasswordConfirmation{{ $user->id }}" name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#editUser{{ $user->id }}">Close</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection