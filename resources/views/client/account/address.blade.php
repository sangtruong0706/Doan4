@extends('client.layouts.app')
@section('content')
<div class="header_height"></div>
<div class="breadcrumb_section">
   <div class="container">
      <div class="grid">
         <div class="grid__item one-whole">
            <div class="breadcrumb_item">
               <!-- /snippets/breadcrumb.liquid -->
               <ul>
                  <li><a href="{{ route("client.home") }}" title="Back to the frontpage">Home</a></li>
                  <li><a href="{{ route("account.profile") }}" title="Back to the frontpage">Profile</a></li>
                  <li>Address</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="content">
    <div id="customer-account">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <section class=" section-11 ">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        @include('client.account.sidebar')
                    </div>
                    <div class="col-md-9">
                        <h1>Your Addresses</h1>
                        <div class="customer_address">
                            <p style="font-size: 20px;" class="address_actions">
                                <span  onclick="openFormEdit()" class="action_link action_edit"><a style="color:#d63612;" href="#">Edit address</a></span> |
                                <span  class="action_link action_delete"><a style="color:#d63612;" href="#" >Delete</a></span>
                            </p>
                            <div class="view_address large--two-thirds medium--three-quarters">
                                <ul style="font-size: 17px;">
                                    <li><strong>Full name: </strong> <u> {{ (!empty($customerAddress)) ? $customerAddress->first_name : '' }} {{ (!empty($customerAddress)) ? $customerAddress->last_name : '' }}</u></li>
                                    <li><strong>Email: </strong> {{ (!empty($customerAddress)) ? $customerAddress->email : '' }}</li>
                                    <li><strong>Province: </strong>{{ (!empty($customerProvince)) ? $customerProvince->name : '' }}</li>
                                    <li><strong>District: </strong>{{ (!empty($customerDistrict)) ? $customerDistrict->name : '' }}</li>
                                    <li><strong>Ward: </strong>{{ (!empty($customerWard)) ? $customerWard->name : '' }}</li>
                                    <li><strong>Address: </strong>{{ (!empty($customerAddress)) ? $customerAddress->address : '' }}</li>
                                    <li> <strong>Phone: </strong> {{ (!empty($customerAddress)) ? $customerAddress->phone : '' }}</li>
                                </ul>

                            </div>

                            <div id="EditAddressForm" class="form-vertical my-4" style="display:none;">
                                <form method="post" action="" id="address_form" accept-charset="UTF-8">
                                    <h2>Edit address</h2>
                                    <div class="large--seven-tenths max-large--four-fifths">
                                        <div class="card-body checkout-form">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <input type="text" name="first_name" id="first_name" class="input-full form-control" placeholder="First Name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : '' }}">
                                                        <p class="p_error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <input type="text" name="last_name" id="last_name" class="input-full form-control" placeholder="Last Name" value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : '' }}">
                                                        <p class="p_error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <input type="text" name="email" id="email" class="input-full form-control" placeholder="Email" value="{{  (!empty($customerAddress)) ? $customerAddress->email : '' }}">
                                                        <p class="p_error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                <div class="grid__item large--four-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                                    <div class="row">
                                                        <label for="province">Provinces</label>
                                                        <select id="province" name="province" class="input-full form-control" >
                                                            <option value="">--Select province--</option>
                                                                @foreach($provinces as $province)
                                                                <option {{ (((!empty($customerAddress)) ? $customerAddress->province_id : '') == $province->id) ? 'selected' : '' }} value="{{ $province->id }}">{{ $province->name }}</option>
                                                                @endforeach
                                                        </select>
                                                        <p class="p_error"></p>
                                                    </div>
                                                </div>
                                                <div class="grid__item large--three-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                                    <div class="row">
                                                        <label for="district">District</label>
                                                        <select id="district" name="district" class="input-full form-control">
                                                            <option value="---">--Select district--</option>
                                                                @if($customerDistrict)
                                                                <option value="{{ $customerDistrict->id }}" selected>{{ $customerDistrict->name }}</option>
                                                                @endif
                                                        </select>
                                                        <p class="p_error"></p>
                                                    </div>
                                                </div>
                                                <div class="grid__item large--three-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                                    <div class="row">
                                                        <label for="ward">Ward</label>
                                                        <select id="ward" name="ward" class="input-full form-control">
                                                            <option value="---">--Select ward--</option>
                                                            @if($customerWard)
                                                            <option value="{{ $customerWard->id }}" selected>{{ $customerWard->name }}</option>
                                                            @endif
                                                        </select>
                                                        <p class="p_error"></p>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-md-12 my-3">
                                                <div class="mb-3">
                                                    <textarea style="resize: none" name="address" id="address" cols="30" rows="5" placeholder="Address" class="input-full ">
                                                        {{ (!empty($customerAddress)) ? $customerAddress->address : ''}}
                                                    </textarea>
                                                    <p class="p_error"></p>
                                                </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <input type="text" name="phone" id="phone" class="input-full form-control" placeholder="Mobile phone" value="{{ (!empty($customerAddress)) ? $customerAddress->phone : '' }}">
                                                        <p class="p_error"></p>
                                                    </div>
                                                </div>
                                                <div class="action_bottom my-3">
                                                    <input type="submit" class="btn" value="Update Address">
                                                    <a href="#" onclick="openFormEdit()" class="btn">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
@section('customJs')
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
                    $('#shipping-charge').text('0 vnđ');
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
        function openFormAddress() {
            var element = document.getElementById("AddAddress");
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
        function openFormEdit() {
            var element = document.getElementById("EditAddressForm");
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
        $("#address_form").submit(function(event) {
            event.preventDefault();
            $.ajax ({
                url: '{{ route("account.updateAddress") }}',
                type: 'post',
                dataType: 'json',
                data: $(this).serializeArray(),
                success: function (response) {
                    var error = response['errors'];
                    if (response.status == false) {
                        $("input[type='text'], select").removeClass('is-invalid');
                        $("textarea[type='text'], select").removeClass('is-invalid');
                        $(".p_error").removeClass('invalid-feedback').html('');
                        $.each(error, function(key,value){
                            $(`#${key}`).addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(value);
                        });
                    }else {
                        window.location.href = '{{ route("account.address") }}';
                    }
                }
            })
        })
    </script>
@endsection
