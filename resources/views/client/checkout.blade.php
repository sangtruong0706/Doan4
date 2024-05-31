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
                  <li>Checkout</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
{{-- <div class="content">
    <div class="container">
        <div class="grid" style="display: flex">
            <div class="grid__item ten-twelfths small--one-whole medium--one-whole">
                <div class="address-section form-vertical">
                    <div id="AddAddress" class="customer_address" style="">
                       <form method="post" action="/account/addresses" id="address_form_new" accept-charset="UTF-8">
                          <input type="hidden" name="form_type" value="customer_address"><input type="hidden" name="utf8" value="✓">
                          <div id="add_address" class="customer_address">
                             <div class="large--seven-tenths large-medium--one-whole">
                                <div class="grid">
                                   <h2>Delivery</h2>
                                   <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                      <div class="row">
                                         <label for="address_first_name_new">First Name</label>
                                         <input type="text" id="address_first_name_new" class="input-full" name="address[first_name]" value="" required="">
                                      </div>
                                   </div>
                                   <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                      <div class="row">
                                         <label for="address_last_name_new">Last Name</label>
                                         <input type="text" id="address_last_name_new_{form.id}}" class="input-full" name="address[last_name]" value="">
                                      </div>
                                   </div>
                                   <div class="grid__item large--four-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                            <label for="province">Provinces</label>
                                            <select id="province" name="province" class="input-full">
                                                <option value="">--Select province--</option>
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   <div class="grid__item large--three-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                            <label for="district">District</label>
                                            <select id="district" name="district" class="input-full">
                                                <option value="---">--Select district--</option>
                                            </select>
                                        </div>
                                    </div>
                                   <div class="grid__item large--three-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                            <label for="ward">Commune</label>
                                            <select id="ward" name="ward" class="input-full">
                                                <option value="---">--Select ward--</option>
                                            </select>
                                        </div>
                                    </div>
                                   <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                      <div class="row">
                                         <label for="address_company_new">Address</label>
                                         <input type="text" for="address_company_new_new" class="input-full" name="address[company]" value="" required="">
                                      </div>
                                   </div>
                                   <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                      <div class="row">
                                         <label for="address_address1_new">Phone</label>
                                         <input type="text" id="address_address1_new_new" class="input-full" name="address[address1]" value="" required="">
                                      </div>
                                   </div>
                                   <h2>Shipping method</h2>
                                </div>
                                <div class="action_bottom">
                                   <input class="btn" type="submit" value="Pay Now">
                                   <a href="#" class="btn">Cancel</a>
                                </div>
                             </div>
                          </div>
                       </form>
                    </div>
                </div>
            </div>
            <div class="grid__item five-twelfths small--one-whole medium--one-whole">
                <div class="row my-4">
                    <div class="col-md-8">
                        <img src="{{ asset("client-asset/img/collection/collection1.jpg") }}" alt="" style="heigh:64px; width: 64px;">
                        <span>name</span>
                    </div>
                    <div class="col-md-4">
                        <span>price</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div> --}}
<section class="section-9 pt-4">
    {{-- <div class="container">
        <div class="grid" style="text-align: center;">
            <div class="cart_title grid__item">
                <span class="cart_page_top_icon"></span>
                <h1>Checkout</h1>
                <div class="grid__item">
            </div>
        </div>
    </div> --}}
    <div class=" cart_section container checkout_section" >
        <div class="grid">
           <div class="cart_title grid__item">
              <span class="cart_page_top_icon"></span>
              <h1>Chechout</h1>
           </div>
        </div>
    </div>
<div class="container my-3">
    <form action="" id="orderForm" name="orderForm" method="post">
        <div class="row">
            <div class="col-md-8">
                <div class="sub-title">
                    <h2>Shipping Address</h2>
                </div>
                <div class="card shadow-lg border-0">
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
                                            <option value="0">--Select province--</option>
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
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea style="resize: none" rows="7" id="note" class="input-full" name="note" placeholder="Order Notes"></textarea>
                                    <p class="p_error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sub-title">
                    <h2>Order Summery</h3>
                </div>
                <div class="card cart-summery" >
                    <div class="card-body">
                        @foreach (Cart::content() as $item )
                            <div class="d-flex justify-content-left align-items-center  pb-2">
                                <?php
                                    $productImage = $item->options->productImages;
                                ?>
                                @if (!empty($productImage->image))
                                    <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" style="width:64px; heigh:64px;">
                                @else
                                    <img src="{{ asset('admin-asset/img/default-150x150.png') }}" style="width:64px; heigh:64px;" >
                                @endif
                                {{-- <img src="{{ asset("client-asset/img/collection/collection1.jpg") }}" alt="" style="width:64px; heigh:64px;"> --}}
                                <div class="h5 mx-2">{{ $item->name }} X {{ $item->qty }}</div>
                                <div class="h5 mx-4">{{ number_format($item->price, 0, ',', '.') }} vnđ</div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between mt-2">
                            <div class="h2"><strong>Discount</strong></div>
                            <div id="discount_val" class="h3">{{ number_format($discount, 0, ',', '.') }} vnđ</div>
                            {{-- <input type="hidden" name="shipping_charge" id="shipping_charge_input" value="{{ $shippingCharge }}"> --}}
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div class="h2"><strong>Shipping</strong></div>
                            <div id="shipping-charge" class="h3">{{ number_format($shippingCharge, 0, ',', '.') }} vnđ</div>
                            <input type="hidden" name="shipping_charge" id="shipping_charge_input" value="{{ $shippingCharge }}">
                        </div>
                        <div class="d-flex justify-content-between mt-2 summery-end">
                            <div class="h2"><strong>Total</strong></div>
                            <div id="grand_total" class="h3">{{ number_format($grandTotal, 0, ',', '.') }} vnđ</div>
                        </div>
                    </div>
                </div>
                <div class="input-group apply-coupon" style="padding: 13px; !important; margin-top: 25px;">
                    <input type="text" class="input-full form-control" placeholder="Coupon Code" name="discount_code" id="discount_code">
                    <div class="input-group-append">
                        <button type="button" id="apply-discount" class="apply-btn">Apply Coupon</button>
                    </div>
                </div>
                <div id="discount-response-wraper">
                    @if ((session()->has('code')))
                        <div id="discount-response" class="input-group apply-coupon" style="margin-top: 25px;">
                            <strong>{{ session()->get('code') }}</strong>
                            <button id="removeDiscount" class="mx-2"><i class="fa-solid fa-x"></i></button>
                        </div>
                    @endif
                </div>
                <div class="card payment-form " style="padding: 13px; !important; margin-top: 25px;">
                    <h3 class="card-title h2 mb-3">Payment Method</h3>
                    <div class="card-body p-0">
                        <div class="radio_row">
                            <input checked class="brand_label" type="radio" id="radio_cod" name="payment_method" value="cod">
                            <label for="radio_cod"><span></span>Thanh toán bằng tiền mặt(COD)</label>
                        </div>
                        <div class="radio_row">
                            <input id="vnpay" class="brand_label" type="radio" name="payment_method" value="vnpay">
                            <label for="vnpay"><span></span>VNpay</label>
                        </div>
                        <div class="pt-4">
                            <button name="redirect" type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</section>
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
                    // AJAX request to get shipping charge
                    $.ajax({
                        url: '/get-shipping-charge/' + province_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == true) {
                                $('#shipping-charge').text(response.shipping_charge_formatted);
                                $('#shipping_charge_input').val(response.shipping_charge);
                                $('#grand_total').text(response.grand_total_formatted);
                                $('#discount_val').html(response.discount_format);
                            }
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
        $("#orderForm").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: '{{ route("client.processCheckout") }}',
                type: "POST",
                dataType: "json",
                data: $(this).serializeArray(),
                success: function(response) {
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
                        if (response.url) {
                            window.location.href = response.url;
                        } else {
                            window.location.href = '{{ url('thank-you/') }}/' + response.orderId;
                        }
                        // window.location.href = '{{ url('thank-you/') }}/' + response.orderId;
                    }
                }

            })
        });
        $("#apply-discount").click(function(event){
            event.preventDefault();
            var province_id = $("#province").val();
            var code = $("#discount_code").val();
            $.ajax({
                    url: '/apply-discount/' + province_id + '/' + code,
                    type: 'GET',
                    data: {code: $("#discount_code").val(), province: $("#province").val()},
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status == true){
                            $('#shipping-charge').html(response.shipping_charge_formatted);
                            $('#shipping_charge_input').val(response.shipping_charge);
                            $('#grand_total').html(response.grand_total_formatted);
                            $('#discount_val').html(response.discount_format);
                            $("#discount-response-wraper").html(response.discountString);

                        }else {
                            $("#discount-response-wraper").html("<span class='text-danger'>"+response.message+"</span>");
                        }
                    }
            });
        });
        $('body').on('click','#removeDiscount', function(){
            event.preventDefault();
            var province_id = $("#province").val();
            // var code = $("#discount_code").val();
            $.ajax({
                    url: '/remove-discount/' + province_id ,
                    type: 'GET',
                    data: {province: $("#province").val()},
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status == true){
                            $('#shipping-charge').html(response.shipping_charge_formatted);
                            $('#shipping_charge_input').val(response.shipping_charge);
                            $('#grand_total').html(response.grand_total_formatted);
                            $('#discount_val').html(response.discount_format);
                            $("#discount-response").html('');
                            $("#discount_code").val('');
                        }else {
                            alert('loi');
                        }
                    }
            });
        });
        // $("#removeDiscount").click(function(event){

        // });
    </script>
@endsection
