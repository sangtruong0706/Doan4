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
    <div id="customer-account">
       <div class="container">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
          <div class="row">
             <div class="section_title black_border">
                <h1>ACCOUNT DETAILS</h1>
                <span class="title_border black_border"></span>
             </div>
          </div>
          <div class="grid">
             <div class="grid__item one-whole">
                <div class="user_name">
                   <p class="email">{{ Auth::user()->email }}<a href="{{ route("account.logout") }}">Log out</a></p>
                </div>
             </div>
             <div class="row grid__item large--four-twelfths medium-down--one-whole">
                <div id="customer_sidebar" class="span4">
                   <div class="address">
                      <p>
                        {{ Auth::user()->name }}
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>Türkiye
                         <br>
                      </p>
                      <a href="{{ route("account.address") }}" id="view_address" class="add-new-address btn">View Addresses <span><i class="fa fa-angle-right"></i></span></a>
                   </div>
                </div>
             </div>
             <p>You haven't placed any orders yet.</p>
             <ul>
             </ul>
          </div>
       </div>
    </div>
</div>
@endsection
