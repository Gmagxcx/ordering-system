@extends('app')

@section('content')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">

<div class="container mt-5">

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    

    <div class="table-container">

    <span class="top">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
     <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
    </svg> <h2 class="text-center">Users</h2></h1></span>

        <div class="report-container">
            <div class="report r-total">
                <h6 class="total">Total</h6>
                <h3 class="total">{{ $totalUsers }}</h3>
            </div>

            <div class="report">
                <h6>Regular Users</h6>
                <h3>{{ $regularUsers }}</h3>
            </div>

            <div class="report">
                <h6>Administrators</h6>
                <h3>{{ $administrators }}</h3>
            </div>

            <div class="report">
                <h6>Employees</h6>
                <h3>{{ $employees }}</h3>
            </div>
        </div>

        <form action="{{ url('/users') }}" method="GET" class="searchGroup mb-0 d-flex justify-content align-items-center">
            <input type="search" name="search" class="form-control w-20 me-2" placeholder="Search names, access levels etc. Hit enter to search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div class="table-responsive">
            <table class="table table-hover custom-table">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Access Level</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr id="userRow{{ $user->id }}">
                        <td class="align-middle">{{ $user->id }}</td>
                        <td class="align-middle">
                            <span id="firstName{{ $user->id }}">{{ $user->first_name }}</span>
                            <input type="text" id="editFirstName{{ $user->id }}" value="{{ $user->first_name }}" class="form-control" style="display:none;">
                        </td>
                        <td class="align-middle">
                            <span id="lastName{{ $user->id }}">{{ $user->last_name }}</span>
                            <input type="text" id="editLastName{{ $user->id }}" value="{{ $user->last_name }}" class="form-control" style="display:none;">
                        </td>
                        <td class="align-middle">
                            <span id="email{{ $user->id }}">{{ $user->email }}</span>
                            <input type="email" id="editEmail{{ $user->id }}" value="{{ $user->email }}" class="form-control" style="display:none;">
                        </td>
                        <td class="align-middle">
                            <span id="accessLevel{{ $user->id }}">{{ ucfirst($user->access) }}</span>
                            <select id="editAccess{{ $user->id }}" class="form-control" style="display:none;">
                                <option value="admin" {{ $user->access == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="employee" {{ $user->access == 'employee' ? 'selected' : '' }}>Employee</option>
                                <option value="user" {{ $user->access == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-warning btn-sm" id="editBtn{{ $user->id }}" onclick="editUser('{{ $user->id }}')">Edit</button>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" id="deleteForm{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" id="deleteBtn{{ $user->id }}">Delete</button>
                            </form>

                            <button id="updateBtn{{ $user->id }}" class="btn btn-success btn-sm" onclick="updateUser('{{ $user->id }}')" style="display:none;">Update</button>
                            <button id="cancelBtn{{ $user->id }}" class="btn btn-secondary btn-sm" onclick="cancelEdit('{{ $user->id }}')" style="display:none;">Cancel</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination">
    {{ $users->links() }} 
    </div>
</div>
@endsection

@section('scripts')
<script>
    function editUser(userId) {
        document.getElementById('editFirstName' + userId).style.display = 'inline';
        document.getElementById('editLastName' + userId).style.display = 'inline';
        document.getElementById('editEmail' + userId).style.display = 'inline';
        document.getElementById('editAccess' + userId).style.display = 'inline';

        document.getElementById('firstName' + userId).style.display = 'none';
        document.getElementById('lastName' + userId).style.display = 'none';
        document.getElementById('email' + userId).style.display = 'none';
        document.getElementById('accessLevel' + userId).style.display = 'none';

        document.getElementById('editBtn' + userId).style.display = 'none';
        document.getElementById('deleteForm' + userId).style.display = 'none';

        document.getElementById('updateBtn' + userId).style.display = 'inline';
        document.getElementById('cancelBtn' + userId).style.display = 'inline';
    }

    function cancelEdit(userId) {
        document.getElementById('editFirstName' + userId).style.display = 'none';
        document.getElementById('editLastName' + userId).style.display = 'none';
        document.getElementById('editEmail' + userId).style.display = 'none';
        document.getElementById('editAccess' + userId).style.display = 'none';

        document.getElementById('firstName' + userId).style.display = 'inline';
        document.getElementById('lastName' + userId).style.display = 'inline';
        document.getElementById('email' + userId).style.display = 'inline';
        document.getElementById('accessLevel' + userId).style.display = 'inline';

        document.getElementById('updateBtn' + userId).style.display = 'none';
        document.getElementById('cancelBtn' + userId).style.display = 'none';

        document.getElementById('editBtn' + userId).style.display = 'inline';
        document.getElementById('deleteForm' + userId).style.display = 'inline';
    }

    function updateUser(userId) {
        var firstName = document.getElementById('editFirstName' + userId).value;
        var lastName = document.getElementById('editLastName' + userId).value;
        var email = document.getElementById('editEmail' + userId).value;
        var access = document.getElementById('editAccess' + userId).value;

        var updateUrl = "{{ route('admin.users.update', ':id') }}".replace(':id', userId);

        var form = document.createElement('form');
        form.method = 'POST';
        form.action = updateUrl; 

        var csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        var methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        var firstNameInput = document.createElement('input');
        firstNameInput.type = 'hidden';
        firstNameInput.name = 'first_name';
        firstNameInput.value = firstName;
        form.appendChild(firstNameInput);

        var lastNameInput = document.createElement('input');
        lastNameInput.type = 'hidden';
        lastNameInput.name = 'last_name';
        lastNameInput.value = lastName;
        form.appendChild(lastNameInput);

        var emailInput = document.createElement('input');
        emailInput.type = 'hidden';
        emailInput.name = 'email';
        emailInput.value = email;
        form.appendChild(emailInput);

        var accessInput = document.createElement('input');
        accessInput.type = 'hidden';
        accessInput.name = 'access';
        accessInput.value = access;
        form.appendChild(accessInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection
@yield('scripts')
