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
                  <li>Thank You</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-error alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div style="height: 500px;" class="col-md-12 text-center">
        <h1>Payment Failed</h1>
        <p>There was an error processing your payment. Please try again.</p>
    </div>
</div>

@endsection
