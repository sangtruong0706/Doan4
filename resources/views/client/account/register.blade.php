@extends('client.layouts.app')
@section('content')
<div class="header_height"></div>
<div class="breadcrumb_section">
   <div class="container">
      <div class="grid">
         <div class="grid__item one-whole">
            <div class="breadcrumb_item">
               <ul>
                  <li><a href="{{ route("client.home") }}" title="Back to the frontpage">Home</a></li>
                  <li>Register</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="content">
   <div id="customer-account" class="create_account">
      <div class="container">
         <div class="grid">
            <div class="grid__item large--two-fifths push--large--three-tenths max-large--three-fifths push--max-large--one-fifth medium--four-fifths push--medium--one-tenth text-center max-medium--six-twelfths push--max-medium--three-twelfths">
               <div class="section_title black_border">
                  <h1>Create Account</h1>
                  <span class="title_border black_border"></span>
               </div>
               <div class="form-vertical">
                  <form method="post" action="" id="create_customer"  accept-charset="UTF-8" autocomplete="off">
                     <div class="row">
                        <input type="text" name="name" id="name" class="input-full form-control " placeholder="Name" >
                        <p></p>
                     </div>
                     <div class="row">
                        <input type="email" name="email" id="email" class="input-full form-control" placeholder="Email" >
                        <p></p>
                     </div>
                     <div class="row">
                        <input type="text" name="phone" id="phone" class="input-full form-control" placeholder="Phone" >
                        <p></p>
                     </div>
                     <div class="row">
                        <input type="password" name="password" id="password" class="input-full form-control" placeholder="Password" >
                        <p></p>
                     </div>
                     <div class="row">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" >
                        <p></p>
                     </div>
                     <p>
                        <button type="submit">Create <span><i class="fa fa-angle-right"></i></span></button>
                     </p>
                     <a href="{{ route("client.shop") }}"><span><i class="fa fa-angle-left"></i></span>Return to Store</a>
                    </form>
                    <a class="my-3" href="{{ route("client.redirectToGoogle") }}">
                        <img src="{{ asset("client-asset/img/logo/google_signin.png") }}" style="margin-left: 3em;">
                    </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('customJs')
    <script type="text/javascript">
        $("#create_customer").submit(function(event){
            event.preventDefault();

            $.ajax({
                url: '{{ route("account.processRegister") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    var error = response['errors'];
                    if (response.status == false) {
                        if (error['name']) {
                            $("#name").siblings('p').addClass('invalid-feedback').html(error['name']);
                            $("#name").addClass('is-invalid');
                        }else {
                            $("#name").siblings('p').removeClass('invalid-feedback').html('');
                            $("#name").removeClass('is-invalid');
                        }
                        if (error['email']) {
                            $("#email").siblings('p').addClass('invalid-feedback').html(error['email']);
                            $("#email").addClass('is-invalid');
                        }else {
                            $("#email").siblings('p').removeClass('invalid-feedback').html('');
                            $("#email").removeClass('is-invalid');
                        }
                        if (error['phone']) {
                            $("#phone").siblings('p').addClass('invalid-feedback').html(error['phone']);
                            $("#phone").addClass('is-invalid');
                        }else {
                            $("#email").siblings('p').removeClass('invalid-feedback').html('');
                            $("#email").removeClass('is-invalid');
                        }
                        if (error['password']) {
                            $("#password").siblings('p').addClass('invalid-feedback').html(error['password']);
                            $("#password").addClass('is-invalid');
                        }else {
                            $("#password").siblings('p').removeClass('invalid-feedback').html('');
                            $("#password").removeClass('is-invalid');
                        }
                        if (response.errors.password_confirmation) {
                            $("#password_confirmation").siblings('p').addClass('invalid-feedback').html(response.errors.password_confirmation);
                            $("#password_confirmation").addClass('is-invalid');
                        } else {
                            $("#password_confirmation").siblings('p').removeClass('invalid-feedback').html('');
                            $("#password_confirmation").removeClass('is-invalid');
                        }
                    } else {
                            $("#name").siblings('p').removeClass('invalid-feedback').html('');
                            $("#name").removeClass('is-invalid');
                            $("#email").siblings('p').removeClass('invalid-feedback').html('');
                            $("#email").removeClass('is-invalid');
                            $("#phone").siblings('p').removeClass('invalid-feedback').html('');
                            $("#phone").removeClass('is-invalid');
                            $("#password").siblings('p').removeClass('invalid-feedback').html('');
                            $("#password").removeClass('is-invalid');
                            $("#password_confirmation").siblings('p').removeClass('invalid-feedback').html('');
                            $("#password_confirmation").removeClass('is-invalid');
                            window.location.href = '{{ route("account.login") }}';
                    }



                },
                error: function(jqXHR, exception) {
                    console.log("Something went wrong");
                }
            })
        });

    </script>
@endsection
