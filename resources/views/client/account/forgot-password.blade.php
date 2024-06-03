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
                       <p>We will send you an email to reset your password.</p>
                       <div class="form-vertical">
                          <form method="post" action="{{ route("account.processForgotPassword") }}" accept-charset="UTF-8">
                            @csrf
                            <div class="row" style="height: 70px;">
                               <label for="email">Recover Email</label>
                               <input type="email" name="email" id="email"  class="input-full form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                               @error('email')
                                   <p class="invalid-feedback">{{ $message }}</p>
                               @enderror
                            </div>
                             <div class="submit_row">
                                <button type="submit" arial-label="submit" class="btn btn--full">Submit</button>
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
