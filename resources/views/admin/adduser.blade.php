@extends('layouts.app')
@section('content')

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Single User Form (Add / Edit) -->
    <div class="card shadow-sm mb-4" style="border: none;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 style="font-weight: 600; margin: 0;" id="userFormTitle">Add New User</h5>
            <button type="button" class="btn btn-outline-secondary btn-sm" id="resetFormBtn" style="display: none;" onclick="resetUserForm()">Cancel Edit</button>
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
                        <button type="submit" class="btn btn-primary" id="userFormSubmit">Add User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users List -->
    <div class="card shadow-sm mb-4" style="border: none;">
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
        document.getElementById('userFormTitle').textContent = 'Edit User';
        document.getElementById('passwordLabel').textContent = 'New Password (blank = unchanged)';
        document.getElementById('passwordConfirmationLabel').innerHTML = 'Confirm New Password';
        document.getElementById('userFormSubmit').textContent = 'Save Changes';
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
        document.getElementById('userFormTitle').textContent = 'Add New User';
        document.getElementById('passwordLabel').textContent = 'Password';
        document.getElementById('passwordConfirmationLabel').textContent = 'Confirm Password';
        document.getElementById('userFormSubmit').textContent = 'Add User';
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