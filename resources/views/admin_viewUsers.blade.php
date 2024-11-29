@extends('app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Users</h2>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Access Level</th>
                <th>Actions</th>
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
