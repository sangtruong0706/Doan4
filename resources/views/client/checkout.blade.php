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
    <div class=" cart_section container" >
        <div class="grid">
           <div class="cart_title grid__item">
              <span class="cart_page_top_icon"></span>
              <h1>Chechout</h1>
           </div>
        </div>
    </div>
<div class="container my-3">
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
                                <input type="text" name="first_name" id="first_name" class="input-full" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="text" name="last_name" id="last_name" class="input-full" placeholder="Last Name">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="text" name="email" id="email" class="input-full" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="grid__item large--four-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                <div class="row">
                                    <label for="province">Provinces</label>
                                    <select id="province" name="province" class="input-full" >
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
                                    <label for="ward">Ward</label>
                                    <select id="ward" name="ward" class="input-full">
                                        <option value="---">--Select ward--</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 my-3">
                            <div class="mb-3">
                                <textarea style="resize: none" name="address" id="address" cols="30" rows="3" placeholder="Address" class="input-full"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="text" name="mobile" id="mobile" class="input-full" placeholder="Mobile No.">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                {{-- <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea> --}}
                                <textarea style="resize: none" rows="7" id="ContactFormMessage" class="input-full" name="contact[body]" placeholder="Order Notes"></textarea>
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
                    <div class="d-flex justify-content-left align-items-center  pb-2">
                        <img src="{{ asset("client-asset/img/collection/collection1.jpg") }}" alt="" style="width:64px; heigh:64px;">
                        <div class="h5 mx-2">Product Name Goes Here X 1</div>
                        <div class="h5 mx-4">$100</div>
                    </div>
                    <div class="d-flex justify-content-left align-items-center  pb-2">
                        <img src="{{ asset("client-asset/img/collection/collection1.jpg") }}" alt="" style="width:64px; heigh:64px;">
                        <div class="h5 mx-2">Product Name Goes Here X 1</div>
                        <div class="h5 mx-4">$100</div>
                    </div>
                    <div class="d-flex justify-content-left align-items-center  pb-2">
                        <img src="{{ asset("client-asset/img/collection/collection1.jpg") }}" alt="" style="width:64px; heigh:64px;">
                        <div class="h5 mx-2">Product Name Goes Here X 1</div>
                        <div class="h5 mx-4">$100</div>
                    </div>
                    <div class="d-flex justify-content-left align-items-center  pb-2">
                        <img src="{{ asset("client-asset/img/collection/collection1.jpg") }}" alt="" style="width:64px; heigh:64px;">
                        <div class="h5 mx-2">Product Name Goes Here X 1</div>
                        <div class="h5 mx-4">$100</div>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <div class="h2"><strong>Shipping</strong></div>
                        <div class="h3"><strong>$20</strong></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2 summery-end">
                        <div class="h2"><strong>Total</strong></div>
                        <div class="h3"><strong>$420</strong></div>
                    </div>
                </div>
            </div>

            <div class="card payment-form " style="padding: 13px; !important">
                <h3 class="card-title h2 mb-3">Payment Method</h3>
                <div class="card-body p-0">
                    <div class="radio_row">
                        <input class="brand_label" type="radio" id="radio" name="brand" value="cod">
                        <label for="radio"><span></span>Thanh toan bang tien mat</label>
                    </div>
                    <div class="radio_row">
                        <input class="brand_label" type="radio" id="radio" name="brand" value="vnp">
                        <label for="radio"><span></span>VNpay</label>
                    </div>
                    <div class="pt-4">
                        <a href="#" class="btn-dark btn btn-block w-100">Pay Now</a>
                    </div>
                </div>

            </div>


            <!-- CREDIT CARD FORM ENDS HERE -->

        </div>
    </div>
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
    </script>
@endsection
