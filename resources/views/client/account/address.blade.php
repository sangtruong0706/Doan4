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
                  <li>Profile</li>
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
       <div class="container">
          <div class="grid">
             <div class="grid__item one-whole">
                <div class="user_name">
                   <p class="email">{{ Auth::user()->email }}<a href="{{ route("account.logout") }}">Log out</a></p>
                </div>
             </div>
             <div class="grid__item">
                <div id="customer-addresses">
                   <div class="section_title black_border">
                      <h1>Your Addresses</h1>
                      <span class="title_border black_border"></span>
                   </div>
                   <div id="address_tables">
                      <div class="customer_address">
                         <div id="view_address_7825450827822" class="customer_address">
                            <p class="address_actions">
                               <span onclick="openFormEdit()" class="action_link action_edit"><a href="#">Edit address</a></span> |
                               <span class="action_link action_delete"><a href="#" >Delete</a></span>
                            </p>
                            <div class="view_address large--one-third medium--three-quarters">
                               <p>
                                  Full name: {{ (!empty($customerAddress)) ? $customerAddress->first_name : ''  }} {{ (!empty($customerAddress)) ? $customerAddress->last_name : ''  }}
                                  <br>
                                  {{ (!empty($customerProvince)) ? $customerProvince->name : ''  }}
                                  <br>
                                  {{ (!empty($customerDistrict)) ? $customerDistrict->name : ''  }}
                                  <br>
                                  {{ (!empty($customerWard)) ? $customerWard->name : ''  }}
                                  <br>
                                  Phone: {{ (!empty($customerAddress)) ? $customerAddress->phone : ''  }}
                                  <br>
                               </p>
                            </div>
                         </div>
                         <div id="EditAddressForm" class="form-vertical" style="display:none;">
                            <form method="post" action="" id="address_form" accept-charset="UTF-8">
                                <h2>Edit address</h2>
                                {{-- <div class="card shadow-lg border-0"> --}}
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
                   {{-- <div class="address-section form-vertical">
                      <a href="#" class="add-new-address" onclick="openFormAddress();"><span><i class="fa fa-plus"></i></span> New Address</a>
                      <div id="AddAddress" class="customer_address" style="display: none;">
                         <form method="post" action="/account/addresses" id="address_form_new" accept-charset="UTF-8">
                            <input type="hidden" name="form_type" value="customer_address"><input type="hidden" name="utf8" value="✓">
                            <div id="add_address" class="customer_address">
                               <div class="large--seven-tenths large-medium--one-whole">
                                  <div class="grid">
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
                                     <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                           <label for="address_company_new">Company</label>
                                           <input type="text" for="address_company_new_new" class="input-full" name="address[company]" value="" required="">
                                        </div>
                                     </div>
                                     <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                           <label for="address_address1_new">Address1</label>
                                           <input type="text" id="address_address1_new_new" class="input-full" name="address[address1]" value="" required="">
                                        </div>
                                     </div>
                                     <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                           <label for="address_address2_new">Address2</label>
                                           <input type="text" id="address_address2_new_new" class="input-full" name="address[address2]" value="">
                                        </div>
                                     </div>
                                     <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                           <label for="address_city_new">City</label>
                                           <input type="text" id="address_city_new_new" class="input-full" name="address[city]" value="" size="40" required="">
                                        </div>
                                     </div>
                                     <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                           <label for="address_country_new">Country</label>
                                           <select id="AddressCountryNew" name="address[country]" class="input-full" data-default="">
                                              <option value="---" data-provinces="[]">---</option>
                                              <option value="Zimbabwe" data-provinces="[]">Zimbabwe</option>
                                           </select>
                                        </div>
                                     </div>
                                     <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths" id="AddressProvinceContainerNew" style="display:none">
                                        <div class="row">
                                           <label for="address_province_new">Province</label>
                                           <select id="AddressProvinceNew" class="input-full" name="address[province]" data-default=""></select>
                                        </div>
                                     </div>
                                     <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                           <label for="address_zip_new">Postal/Zip Code</label>
                                           <input type="text" id="address_zip_new_" class="input-full" name="address[zip]" value="" required="">
                                        </div>
                                     </div>
                                     <div class="grid__item large--five-tenths large-medium--one-half medium--one-half small--one-whole max-medium--six-twelfths">
                                        <div class="row">
                                           <label for="address_phone_new">Phone</label>
                                           <input type="text" id="address_phone_new_" class="input-full" name="address[phone]" value="" required="">
                                        </div>
                                     </div>
                                  </div>
                                  <div class="action_bottom">
                                     <div class="row">
                                        <input type="checkbox" id="address_default" name="address[default]" value="1">
                                        <label for="address_default"><span class="check-icon"></span>Set as default address</label>
                                     </div>
                                     <input class="btn" type="submit" value="Add Address">
                                     <a href="#" class="btn" onclick="openFormAddress();">Cancel</a>
                                  </div>
                               </div>
                            </div>
                         </form>
                      </div>
                   </div> --}}
                   {{-- <ul>
                   </ul> --}}
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
@endsection
@section('customJs')
    <script>
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
