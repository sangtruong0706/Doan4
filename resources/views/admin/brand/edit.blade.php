@extends('admin.layouts.app')
@section('content')
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route("brands.index") }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="brandForm" name="brandForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value="{{ $brand->name }}" type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input value="{{ $brand->slug }}" type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ ($brand->status === 1)? 'selected':'' }} value="1">Active</option>
                                        <option {{ ($brand->status === 0)? 'selected':'' }} value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route("brands.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
    $("#brandForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    $.ajax({
        url: '{{ route("brands.update", $brand->id) }}',
        type: 'put',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response){
            if (response['status'] == true) {
                // Swal.fire({
                // icon: 'success',
                // title: 'Success!',
                // text: response.message,
                // }).then((result) => {
                //     if (result.isConfirmed) {
                //         // Nếu người dùng nhấn OK, thực hiện chuyển hướng
                //         window.location.href = "{{ route('brands.index') }}";
                //     }
                // });
                window.location.href = "{{ route('brands.index') }}";
                $("#name").removeClass('is-invalid').siblings('p')
                .addClass('invalid-feedback').html("");
                $("#slug").removeClass('is-invalid').siblings('p')
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
                if (error['slug']) {
                    $("#slug").addClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html(error['slug']);
                }else {
                    $("#slug").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");
                }
            }
        },
        error: function(jqXHR, exception) {
            console.log("Something went wrong!")
        }
    });
});
// get slug
$('#name').change(function(){
    var element = $(this);
    $.ajax({
    url: '{{ route("getSlug") }}',
    type: 'get',
    data: {title: element.val()},
    dataType: 'json',
    success: function(response){
        if (response['status'] == true) {
            $('#slug').val(response['slug']);
        }
    }
    });
});

</script>
@endsection
