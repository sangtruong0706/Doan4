@extends('admin.layouts.app')
@section('content')
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit ShippingCharge</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route("shipping.create") }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
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
                                                <option {{ ($shippingCharge->province_id == $province->id) ? 'selected' : '' }} value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="amount">Amount</label>
                                    <input value="{{ $shippingCharge->amount }}" type="text" name="amount" id="amount" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('customJs')

<script>
    $("#shippingForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    $.ajax({
        url: '{{ route("shipping.update", $shippingCharge->id) }}',
        type: 'put',
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
            }
            },
        error: function(jqXHR, exception) {
            console.log("Something went wrong!")
        }
    });
});



</script>
@endsection
