@extends('layouts.app')
@section('content')

<div class="container-fluid mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="card mb-4" style="border: none; border-radius: 18px; overflow: hidden; background: linear-gradient(120deg, #001e3c 0%, #00447a 60%, #0a5bac 100%);">
        <div class="card-body p-4 text-white">
            <h4 class="mb-1" style="font-weight: 800;"><i class="bx bx-user-circle me-2"></i>Manage Users</h4>
            <small class="text-white-50">Create, edit, and manage accounts for the COTS Tracker community.</small>
        </div>
    </div>

    <!-- Single User Form (Add / Edit) -->
    <div class="card mb-4" style="border: none; border-radius: 18px; box-shadow: 0 8px 24px rgba(0, 40, 80, 0.08);">
        <div class="card-header d-flex justify-content-between align-items-center bg-white" style="border-bottom: 1px solid #eef1f5; border-radius: 18px 18px 0 0;">
            <h5 class="mb-0" style="font-weight: 700; color: #003049;" id="userFormTitle">
                <i class="bx bxs-user-plus me-1" style="color: #0056b3;"></i>Add New User
            </h5>
            <button type="button" class="btn btn-outline-secondary btn-sm" id="resetFormBtn" style="display: none;" onclick="resetUserForm()">
                <i class="bx bx-x me-1"></i>Cancel Edit
            </button>
        </div>
        <div class="card-body">
            <form id="userForm" method="POST" action="{{ route('users.store') }}" autocomplete="off">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="">
                <div class="row g-3">
                    <div class="col-md-2 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="password" class="form-label" id="passwordLabel">Password</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="password_confirmation" class="form-label" id="passwordConfirmationLabel">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role_id" required>
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn text-white fw-semibold" id="userFormSubmit" style="background: linear-gradient(135deg, #0ea5e9, #0056b3); border: none; border-radius: 10px;">
                            <i class="bx bx-check me-1"></i>Add User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users List -->
    <div class="card mb-4" style="border: none; border-radius: 18px; box-shadow: 0 8px 24px rgba(0, 40, 80, 0.08);">
        <div class="card-header d-flex justify-content-between align-items-center bg-white" style="border-bottom: 1px solid #eef1f5; border-radius: 18px 18px 0 0;">
            <h5 class="mb-0" style="font-weight: 700; color: #003049;">
                <i class="bx bxs-user-detail me-1" style="color: #0056b3;"></i>Users List
            </h5>
            <span class="badge rounded-pill text-white" style="background: #0056b3;">{{ $users->count() }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge text-white" style="background: #0056b3;">{{ $user->role->role_name }}</span>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-warning btn-sm"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role_id }}"
                                onclick="editUser(this)">
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
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function editUser(btn) {
        var f = document.getElementById('userForm');
        var editing = btn.getAttribute('data-id');

        document.getElementById('methodField').value = 'PUT';
        document.getElementById('userFormTitle').innerHTML = '<i class="bx bxs-user-edit me-1" style="color: #0056b3;"></i>Edit User';
        document.getElementById('passwordLabel').textContent = 'New Password (blank = unchanged)';
        document.getElementById('passwordConfirmationLabel').innerHTML = 'Confirm New Password';
        document.getElementById('userFormSubmit').innerHTML = '<i class="bx bx-check me-1"></i>Save Changes';
        document.getElementById('resetFormBtn').style.display = 'inline-block';

        document.getElementById('name').value = btn.getAttribute('data-name');
        document.getElementById('email').value = btn.getAttribute('data-email');
        document.getElementById('role').value = btn.getAttribute('data-role');
        document.getElementById('password').value = '';
        document.getElementById('password').required = false;
        document.getElementById('password_confirmation').value = '';
        document.getElementById('password_confirmation').required = false;

        f.action = '/users/' + editing;
        f.scrollIntoView({ behavior: 'smooth' });
    }

    function resetUserForm() {
        var f = document.getElementById('userForm');

        document.getElementById('methodField').value = '';
        document.getElementById('userFormTitle').innerHTML = '<i class="bx bxs-user-plus me-1" style="color: #0056b3;"></i>Add New User';
        document.getElementById('passwordLabel').textContent = 'Password';
        document.getElementById('passwordConfirmationLabel').textContent = 'Confirm Password';
        document.getElementById('userFormSubmit').innerHTML = '<i class="bx bx-check me-1"></i>Add User';
        document.getElementById('resetFormBtn').style.display = 'none';

        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('role').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').value = '';
        document.getElementById('password_confirmation').required = true;

        f.action = "{{ route('users.store') }}";
    }
</script>
@endsection