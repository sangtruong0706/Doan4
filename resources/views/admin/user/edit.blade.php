@extends('admin.layouts.app')
@section('content')
<div class="wrapper">
     <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route("users.index") }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form action="" method="put" id="userEditForm" name="userEditForm">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $user->name }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email"value="{{ $user->email }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        <span>To change password you have enter a value, otherwise leave blank</span>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="{{ $user->phone }}">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option {{ ($user->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                            <option {{ ($user->status == 0) ? 'selected' : '' }} value="0">Block</option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route("users.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->


</div>
@endsection
@section('customJs')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $("#userEditForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $.ajax({
            url: '{{ route("users.update", $user->id) }}',
            type: 'put',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                if (response['status'] == true) {
                    window.location.href = "{{ route('users.index') }}";
                    $("#name").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");
                    $("#email").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");
                    $("#password").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");
                    $("#phone").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");

                }else {
                    var error = response['errors'];
                    if (error['name']) {
                        $("#name").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(error['name']);
                    }else {
                        $("#name").removeClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html("");
                    }
                    if (error['email']) {
                        $("#email").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(error['email']);
                    }else {
                        $("#email").removeClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html("");
                    }
                    if (error['password']) {
                        $("#password").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(error['password']);
                    }else {
                        $("#password").removeClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html("");
                    }
                    if (error['phone']) {
                        $("#phone").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(error['phone']);
                    }else {
                        $("#phone").removeClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html("");
                    }
                }
            },
            error: function(jqXHR, exception) {
                console.log("Something went wrong!")
            }
        });
    });


</script>
@endsection
