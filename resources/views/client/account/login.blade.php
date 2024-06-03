@extends('client.layouts.app')
@section('content')
<div class="header_height" style="height: 90px;"></div>
<div class="breadcrumb_section">
    <div class="container">
       <div class="grid">
          <div class="grid__item one-whole">
             <div class="breadcrumb_item">
                <!-- /snippets/breadcrumb.liquid -->
                <ul>
                   <li><a href="/" title="Back to the frontpage">Home</a></li>
                   <li>Account</li>
                </ul>
             </div>
          </div>
       </div>
    </div>
 </div>
<div class="content">
    <div class="back_bg product_bg">
       <div id="customer-login">
          <div class="container">
             <div class="grid">
                <div class="grid__item large--two-fifths push--large--three-tenths max-large--three-fifths push--max-large--one-fifth text-center max-medium--eight-twelfths push--max-medium--two-twelfths">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                   <div id="CustomerLoginForm" style="display:block;">
                      <div class="section_title">
                         <h1>Login</h1>
                         <p>Are you New? <a href="{{ route("account.register") }}">Register</a></p>
                      </div>
                      <form method="post" action="{{ route("account.authenticate") }}" id="customer_login" accept-charset="UTF-8" autocomplete="off">
                         @csrf
                         <div class="row" style="height: 70px;">
                            <input type="email" name="email" id="email"  class="input-full form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                         </div>
                         <div class="row" style="height: 70px;">
                            <input type="password" name="password" id="password" class="input-full form-control @error('password') is-invalid @enderror" placeholder="Password" >
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                         </div>
                         <p>
                            <button type="submit">Sign In<span><i class="fa fa-angle-right"></i></span></button>
                         </p>
                         <a href="{{ route("client.shop") }}"><span><i class="fa fa-angle-left"></i></span>Return to Store </a>
                         <a href="{{ route("account.forgotPasswordForm") }}"> Forgot your password? <span><i class="fa fa-angle-right"></i></span></a>
                      </form>
                   </div>
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
