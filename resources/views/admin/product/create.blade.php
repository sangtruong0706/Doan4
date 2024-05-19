@extends('admin.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Create Product</h1>
            </div>
            <div class="col-sm-6 text-right">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <form action="" method="POST" name="productForm" id="productForm">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="mb-3">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Title">
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
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                <p class="error"></p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Media</h2>
                        <div id="image" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">
                            <br>Drop files here or click to upload.<br><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="product-gallery">

                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Pricing</h2>
                        <div class="row">
                            <div class="col-md-12">
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                <p class="error"></p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Inventory</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="barcode">Product Code</label>
                                <input type="text" name="product_code" id="product_code" class="form-control" placeholder="Product Code">
                                <p class="error"></p>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Số lượng:</label><br>
                                    <div class="row">
                                        @foreach ($sizes as $size)
                                            <div class="col-md-4">
                                                <label>Size: {{ $size->name }}</label><br>
                                                @foreach ($colors as $color)
                                                    <div>
                                                        <label>Color: {{ $color->name }}:</label>
                                                        <input type="number" name="quantities[{{ $size->id }}][{{ $color->id }}]" class="form-control" min="0">
                                                        <p class="error"></p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product status</h2>
                        <div class="mb-3">
                            <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Block</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4  mb-3">Product category</h2>
                        <div class="mb-3">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">--Select a category--</option>
                                @if ($categories->isnotempty())
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="error"></p>
                        </div>
                        <h2 class="h4 mb-3">Product brand</h2>
                        <div class="mb-3">
                            <label for="brand">Brand</label>
                            <select name="brand" id="brand" class="form-control">
                                <option value="">--Select a brand--</option>
                                @if ($brands->isnotempty())
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="error"></p>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Featured product</h2>
                        <div class="mb-3">
                            <select name="is_feature" id="is_feature" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <p class="error"></p>
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
    $('#title').change(function(){
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
    $('#productForm').submit(function(event){
        event.preventDefault();
        var formArray = $(this).serializeArray();
        $.ajax({
            url: '{{ route("products.store") }}',
            type: 'POST',
            data: formArray,
            dataType: 'json',
            success: function(response) {
                $("button[type='submit']").prop('disabled',false);
                if(response['status'] == true) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Nếu người dùng nhấn OK, thực hiện chuyển hướng
                            window.location.href = "{{ route('products.index') }}";
                        }
                    });
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'], select").removeClass('is-invalid');
                }else {
                    var errors = response['errors'];
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'], select").removeClass('is-invalid');

                    $.each(errors, function(key,value){
                        $(`#${key}`).addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(value);
                    });
                }
            },
            error: function(jqXHR, exception) {
                console.log("something went wrong");
            }
        });
    });


    //Dropzone
    Dropzone.autoDiscover = false;
    const drop = new Dropzone("#image", {
        url: "{{ route('temp-images.create') }}",
        maxFiles: 10,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(file, response){
            // $("#image_id").val(response.image_id);
            var html = `<div class="col-md-3" id = "image-row-${response.image_id}">
                            <div class="card">
                                <input type="hidden" name="image_array[]" value="${response.image_id}">
                                <img src="${response.imagePath}" class="card-img-top" alt="">
                                <div class="card-body">
                                    <a href="javascript:void(0)" onClick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>`;
            $("#product-gallery").append(html);
        },
        complete: function(file) {
            this.removeFile(file);
        }
    });
    function deleteImage(id) {
        $("#image-row-"+id).remove();
    }
</script>
@endsection
