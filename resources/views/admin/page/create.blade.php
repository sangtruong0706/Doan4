@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Create Static Page</h1>
            </div>
            <div class="col-sm-6 text-right">
            <a href="{{ route('pages.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="" method="POST" name="pageForm" id="pageForm">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                        <p class="error"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="title">Slug</label>
                                        <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Content</label>
                                        <textarea name="content" id="content" cols="30" rows="10" class="summernote" placeholder="Content"></textarea>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </form>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('customJs')
<!-- jQuery -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

    //handle submit form
    $('#pageForm').submit(function(event){
        event.preventDefault();
        var formArray = $(this).serializeArray();
        $.ajax({
            url: '{{ route("pages.store") }}',
            type: 'POST',
            data: formArray,
            dataType: 'json',
            success: function(response) {
                $("button[type='submit']").prop('disabled',false);
                if(response['status'] == true) {
                    window.location.href = "{{ route('pages.index') }}";
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'], select").removeClass('is-invalid');
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
                console.log("something went wrong");
            }
        });
    });
</script>
@endsection
