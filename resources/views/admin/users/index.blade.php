@extends('layouts.master')
@section('users-css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('pro/dist/css/emp.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection
@section('users-table')
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2>Manage <b>Users</b></h2>
                        </div>
                        <div class="col-xs-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                    class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
                            <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i
                                    class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="checkbox{{ $user->id }}" name="options[]"
                                            value="{{ $user->id }}">
                                        <label for="checkbox{{ $user->id }}"></label>
                                    </span>
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->getRoleNames() as $roleName)
                                        {{ $roleName }}
                                    @endforeach
                                </td>
                                <td>
                                    <a href="#editEmployeeModal" class="edit" data-user-id="{{ $user->id }}"
                                        data-toggle="modal"><i class="material-icons" data-toggle="tooltip"
                                            title="Edit">&#xE254;</i></a>
                                </td>
                            </tr>
                        @endforeach


                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="addEmployeeModal" class="modal fade">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="modal-dialog">
            <div class="modal-content">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Add User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" required value="{{ old('name') }}" name="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" required value="{{ old('email') }}" name="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>ConfirmPassword</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editUserName">Name</label>
                            <input type="text" id="editUserName" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="editUserEmail">Email</label>
                            <input type="email" id="editUserEmail" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="editUserPassword">Password</label>
                            <input type="password" id="editUserPassword" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-info" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST" action="{{ route('users.update', ['user' => ':userId']) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h4 class="modal-title">Delete User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this record?</p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- delete scripts -->
    <script>
        $(document).ready(function() {
            // Listen for form submission
            $('#deleteForm').submit(function(event) {
                // Prevent the default form submission
                event.preventDefault();

                // Get the ID of the checked checkbox
                var userId = $('input[name="options[]"]:checked').val();

                // Set the form action dynamically to include the user ID
                $(this).attr('action', '{{ route('users.destroy', ':userId') }}'.replace(':userId',
                    userId));

                // Submit the form
                $(this).unbind('submit').submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Activate tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function() {
                if (this.checked) {
                    checkbox.each(function() {
                        this.checked = true;
                    });
                } else {
                    checkbox.each(function() {
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function() {
                if (!this.checked) {
                    $("#selectAll").prop("checked", false);
                }
            });
            $(document).ready(function() {
                // Activate tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // Prevent modal from closing on form submission if there are errors
                $('#addEmployeeModal form').submit(function(event) {
                    var form = $(this);
                    var modal = form.closest('.modal');
                    var errorMessages = modal.find('.text-danger');

                    if (errorMessages.length > 0) {
                        // Prevent the modal from closing
                        event.preventDefault();
                        event.stopPropagation();

                        // Display the modal without closing
                        modal.modal('show');
                    }

                });

                // Select/Deselect checkboxes
                var checkbox = $('table tbody input[type="checkbox"]');
                $("#selectAll").click(function() {
                    if (this.checked) {
                        checkbox.each(function() {
                            this.checked = true;
                        });
                    } else {
                        checkbox.each(function() {
                            this.checked = false;
                        });
                    }
                });

                checkbox.click(function() {
                    if (!this.checked) {
                        $("#selectAll").prop("checked", false);
                    }
                });

                $('#addEmployeeModal form').submit(function(event) {
                    console.log('Form submitted');
                    // Your existing code here
                });

            });

        });
    </script>
    <!-- edit form scripts -->
    {{-- <script>
        $(document).ready(function() {
            $('.edit').click(function() {
                var userId = $(this).data('user-id');
                var user = users.find(user => user.id ===
                userId); // Assuming users is an array containing user objects
                $('#editForm').attr('action', '{{ route('users.update', ['user' => ':userId']) }}'.replace(
                    ':userId', userId));
                $('#editUserName').val(user.name);
                $('#editUserEmail').val(user.email);
                // Clear password field for security reasons
                $('#editUserPassword').val('');
            });
        });
    </script> --}}
@endsection
