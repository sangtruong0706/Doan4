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
                    <div id="RecoverPasswordForm" style="">
                       <h2>Reset your password</h2>
                       <div class="form-vertical">
                          <form method="post" action="{{ route("account.processResetPassword") }}" accept-charset="UTF-8">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row" style="height: 70px;">
                               <input type="password" name="new_password" id="new_password"  class="input-full form-control @error('password') is-invalid @enderror" placeholder="New Password" value="">
                               @error('password')
                                   <p class="invalid-feedback">{{ $message }}</p>
                               @enderror
                            </div>
                            <div class="row" style="height: 70px;">
                               <input type="password" name="confirm_password" id="confirm_password"  class="input-full form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password" value="">
                               @error('confirm_password')
                                   <p class="invalid-feedback">{{ $message }}</p>
                               @enderror
                            </div>
                             <div class="submit_row">
                                <button type="submit" arial-label="submit" class="btn btn--full">Reset Password</button>
                             </div>
                             <a href="{{ route('account.login') }}" class="btn">Cancel</a>
                          </form>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
</div>
@endsection
