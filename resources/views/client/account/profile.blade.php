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
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="content">
    <section class=" section-11 ">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('client.account.sidebar')
                </div>
                <div class="col-md-9" id="customer-account">
                    <h1>My Profile</h1>
                    <div class="customer_address">
                        <p style="font-size: 20px;" class="address_actions">
                            <span  onclick="openFormEdit()" class="action_link action_edit"><a style="color:#d63612;" href="#">Edit Profile</a></span>
                        </p>
                        <div class="view_address large--two-thirds medium--three-quarters">
                            <ul style="font-size: 18px;">
                                <li><strong>Name: </strong> <u>{{ $user->name }} </u></li>
                                <li><strong>Email: </strong>{{ $user->email }} </li>
                                <li> <strong>Phone: </strong> {{ $user->phone }} </li>
                            </ul>
                        </div>
                        <div id="EditProfileForm" class="form-vertical my-4" style="display:none;">
                            <form method="post" action="" id="profile_form" accept-charset="UTF-8">
                                <h2>Edit Profile</h2>
                                <div class="large--seven-tenths max-large--four-fifths">
                                    <div class="card-body checkout-form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="name" class="">Name</label>
                                                    <input type="text" name="name" id="name" class="input-full form-control" placeholder="Name" value="{{ $user->name }}">
                                                    <p class="p_error"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="email" class="">Email</label>
                                                    <input type="text" name="email" id="email" class="input-full form-control" placeholder="Email" value="{{ $user->email }}">
                                                    <p class="p_error"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="phone" class="">Phone</label>
                                                    <input type="text" name="phone" id="phone" class="input-full form-control" placeholder="Phone" value="{{ $user->phone }}">
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
    </section>
</div>
@endsection
@section('customJs')
    <script>
        function openFormEdit() {
            var element = document.getElementById("EditProfileForm");
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
        $("#profile_form").submit(function(event) {
            event.preventDefault();
            $.ajax ({
                url: '{{ route("account.updateProfile") }}',
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
                        window.location.href = '{{ route("account.profile") }}';
                    }
                }
            })
        })
    </script>
@endsection
