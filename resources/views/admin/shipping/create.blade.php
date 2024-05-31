@extends('admin.layouts.app')
@section('content')
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Management</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route("categories.index") }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    @include('admin.message')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="shippingForm" name="shippingForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="status">Province</label>
                                    <select name="province" id="province" class="form-control">
                                        <option value="">--Select a province--</option>
                                        @if ($provinces->isNotEmpty())
                                            @foreach ($provinces as $province )
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="amount">Amount</label>
                                    <input type="text" name="amount" id="amount" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-body">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th width="60">ID</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($shippingCharges->isNotEmpty())
                                    @foreach ($shippingCharges as $shippingCharge)
                                        <tr>
                                            <td>{{ $shippingCharge->id }}</td>
                                            <td>{{ $shippingCharge->name }}</td>
                                            <td>{{ number_format($shippingCharge->amount, 0, ',', '.') }} vnđ</td>

                                            <td>
                                                <a href="{{ route('shipping.edit', $shippingCharge->id) }}">
                                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                </a>
                                                <a href="#" onclick="deleteShippingCharge({{ $shippingCharge->id }})" class="text-danger w-4 h-4 mr-1">
                                                    <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">Records Not Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{-- <div class="card-footer clearfix">
                            <ul class="pagination pagination m-0 float-right">
                              <li class="page-item"><a class="page-link" href="#">«</a></li>
                              <li class="page-item"><a class="page-link" href="#">1</a></li>
                              <li class="page-item"><a class="page-link" href="#">2</a></li>
                              <li class="page-item"><a class="page-link" href="#">3</a></li>
                              <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div> --}}
                        {{ $shippingCharges->links('vendor.pagination.custom_admin') }}

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $("#shippingForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $.ajax({
            url: '{{ route("shipping.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                if (response['status'] == true) {
                    window.location.href = "{{ route('shipping.create') }}";
                    $("#province").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");
                    $("#amount").removeClass('is-invalid').siblings('p')
                    .addClass('invalid-feedback').html("");

                }else {
                    var error = response['errors'];
                    if (error['province']) {
                        $("#province").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(error['province']);
                    }else {
                        $("#province").removeClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html("");
                    }

                    if (error['amount']) {
                        $("#amount").addClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html(error['amount']);
                    }else {
                        $("#amount").removeClass('is-invalid').siblings('p')
                        .addClass('invalid-feedback').html("");
                    }
                    // window.location.href = "{{ route('shipping.create') }}";
                }
            },
            error: function(jqXHR, exception) {
                console.log("Something went wrong!")
            }
        });
    });
    function deleteShippingCharge(id){
        var url = '{{ route("shipping.delete",'ID') }}';
        var newUrl = url.replace('ID', id);
        Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this shipping charge?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            // Nếu người dùng xác nhận muốn xóa
            if (result.isConfirmed) {
                // Thực hiện ajax để xóa category
                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    data: {},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response){
                        if (response.status == true) {
                            window.location.href = "{{ route('shipping.create') }}";
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log("Something went wrong!")
                    }
                });
            }
        });
    }
</script>
@endsection
