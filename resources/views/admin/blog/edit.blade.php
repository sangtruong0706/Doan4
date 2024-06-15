@extends('admin.layouts.app')
@section('content')
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Blog</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route("blogs.index") }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="editBlogForm" name="editBlogForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $blog->title }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-mb-3">
                                    <label for="image">Image</label>
                                    <input type="hidden" name="image_id" id="image_id" value="">
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($blog->image))
                                    <div class="my-3">
                                        <img width="150px" height="150px" src="{{ asset('uploads/blog/thumb/'.$blog->image) }}" alt="">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" cols="30" rows="10" class="summernote" placeholder="Description">
                                        {{ $blog->content }}"
                                    </textarea>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="blog_category">Blog Category</label>
                                    <select name="blog_category" id="blog_category" class="form-control">
                                        <option value="">--Select Blog Category--</option>
                                        @if ($blog_categories->isNotEmpty())
                                            @foreach ($blog_categories as $blog_category)
                                                <option {{ ($blog->blog_category_id == $blog_category->id) ? 'selected' : '' }} value="{{ $blog_category->id }}">{{ $blog_category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="author">Author</label>
                                    <select name="author" id="author" class="form-control">
                                        <option value="">--Select Author--</option>
                                        <option {{ ($blog->author == 'admin') ? 'selected' : '' }} value="admin">Admin</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route("blogs.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('customJs')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$("#editBlogForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    $.ajax({
        url: '{{ route("blogs.update", $blog->id) }}',
        type: 'put',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response){
            if (response['status'] == true) {
                window.location.href = "{{ route('blogs.index') }}";
                $("#title").removeClass('is-invalid').siblings('p')
                .addClass('invalid-feedback').html("");
                $("#content").removeClass('is-invalid').siblings('p')
                .addClass('invalid-feedback').html("");

            }else {
                var errors = response['errors'];
                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'], select").removeClass('is-invalid');
                    // $("input[type='text'], select").removeClass('is-invalid');

                    $.each(errors, function(key,value){
                        $(`#${key}`).addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(value);
                    });
            }
        },
        error: function(jqXHR, exception) {
            console.log("Something went wrong!")
        }
    });
});


//Dropzone
    Dropzone.autoDiscover = false;
    const drop = new Dropzone("#image", {
    init: function() {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
        },
        url: "{{ route('temp-images.create') }}",
        maxFiles: 1,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(file, response){
            $("#image_id").val(response.image_id);
            //console.log(response)
        }
    });



</script>
@endsection
