@extends('admin.layouts.app')
@section('content')
<div class="wrapper">
     <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Shipper</h1>
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
                <form action="" method="post" id="shipperForm" name="shipperForm">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" cols="30" rows="10" class="summernote" placeholder="Address"></textarea>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="province">Provinces</label>
                                        <select id="province" name="province" class=" form-control" >
                                            <option value="">--Select province--</option>
                                                @foreach($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @endforeach
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="district">District</label>
                                        <select id="district" name="district" class=" form-control">
                                            <option value="---">--Select district--</option>
                                                <option></option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="ward">Ward</label>
                                        <select id="ward" name="ward" class="form-control">
                                            <option value="---">--Select ward--</option>
                                            <option></option>
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route("shippers.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#province').change(function() {
            var province_id = $(this).val();
            if (province_id) {
                $.ajax({
                    url: '/districts/' + province_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#district').empty();
                        $('#district').append('<option value="">Chọn quận/huyện</option>');
                        $.each(data, function(key, value) {
                            $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#district').empty();
                $('#district').append('<option value="">Chọn quận/huyện</option>');
            }
        });
        $('#district').change(function() {
            var district_id = $(this).val();
            if (district_id) {
                $.ajax({
                    url: '/wards/' + district_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#ward').empty();
                        $('#ward').append('<option value="">Chọn xã</option>');
                        $.each(data, function(key, value) {
                            $('#ward').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#ward').empty();
                $('#ward').append('<option value="">Chọn xã</option>');
            }
        });
    });
    $("#shipperForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $.ajax({
            url: '{{ route("shippers.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                if (response['status'] == true) {
                    window.location.href = "{{ route('shippers.index') }}";
                    $("#full_name").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");
                    $("#email").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");
                    $("#password").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");
                    $("#phone").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");

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
                console.log("Something went wrong!")
            }
        });
    });


</script>
@endsection
