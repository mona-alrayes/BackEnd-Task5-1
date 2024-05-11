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
@section('books-table')
<div class="container mr-5 pl-5 pr-5">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-xs-6">
                        <h2>Manage <b>Categories and Subcategories</b></h2>
                    </div>
                    <div class="col-xs-6">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                class="material-icons">&#xE147;</i> <span>Add New category/Subcategory</span></a>
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
                        <th>category</th>
                        <th>subcategory</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="checkbox{{$category->id}}" name="options[]" value="{{$category->id}}">
                                    <label for="checkbox{{$category->id}}"></label>
                                </span>                                
                            </td>
                            <td>
                                <span class="user-id" data-user-id="{{ $category->id }}" data-toggle="tooltip"
                                    title="User ID: {{ $category->id }}">
                                    {{optional($category->category)->category}}
                                </span>
                            </td>
                            <td>{{ $category->subcategory}}</td>
                            
                        </tr>
                    @endforeach

                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<!-- Edit Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="modal-dialog">
        <div class="modal-content">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('Category.store') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Add Subcategory and Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Subcategory</label>
                        <input type="text" class="form-control" required value="{{ old('subcategory') }}" name="subcategory">
                        @error('subcategory')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" class="form-control" required value="{{ old('category') }}" name="category">
                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST" action="{{ route('Category.destroy', ['Category' => ':CategoryId']) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Delete Subcategory</h4>
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

<script>
    $(document).ready(function() {
        // Listen for form submission
        $('#deleteForm').submit(function(event) {
            // Prevent the default form submission
            event.preventDefault();

            // Get the ID of the checked checkbox
            var categoryId = $('input[name="options[]"]:checked').val();

            // Set the form action dynamically to include the category ID
            var actionUrl = '{{ route("Category.destroy", ":CategoryId") }}';
            actionUrl = actionUrl.replace(':CategoryId', categoryId);
            $(this).attr('action', actionUrl);

            // Submit the form
            $(this).submit();
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
@endsection
