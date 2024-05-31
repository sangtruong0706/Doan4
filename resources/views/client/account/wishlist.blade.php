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
                  <li><a href="{{ route("account.profile") }}" title="Back to the frontpage">Profile</a></li>
                  <li>Wishlist</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="content">
    <div id="customer-account">
        <section class=" section-11 ">
            <div class="container  mt-5">
                <div class="row">
                    <div class="col-md-3">
                        @include('client.account.sidebar')
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                            </div>
                            <div class="card-body p-4">
                                @if ($wishlists->isNotEmpty())
                                    @foreach ($wishlists as $wishlist)
                                        <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                            <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                                <?php
                                                    $productImage =getProductImages($wishlist->product_id);
                                                ?>
                                                @if (!empty($productImage->image))
                                                    <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route("client.product", $wishlist->product_id) }}" style="width: 10rem;">
                                                        <img style="width: 120px;height: 120px;" src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                                    </a>
                                                @else
                                                    <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="#" style="width: 10rem;">
                                                        <img style="width: 120px;height: 120px;" src="{{ asset('admin-asset/img/default-150x150.png') }}"  >
                                                    </a>
                                                @endif
                                                {{-- <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="#" style="width: 10rem;">
                                                    <img src="images/product-1.jpg" alt="Product">
                                                </a> --}}
                                                <div class="pt-2">
                                                    <h3 class="product-title fs-base mb-2"><a href="{{ route("client.product", $wishlist->product_id) }}">{{ $wishlist->product->title }}</a></h3>
                                                    <div class="fs-lg text-left pt-2">{{ number_format($wishlist->product->price, 0, ',', '.') }} vnđ</div>
                                                </div>
                                            </div>
                                            <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center my-3">
                                                <button onclick="removeProduct({{ $wishlist->product_id }})" class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                                                {{-- <button>
                                                    <span><i class="fa fa-times"></i></span>
                                                </button> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div>
                                        <h3>Your wishlist is empty!!</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
@section('customJs')
    <script>
        function removeProduct(id) {
            $.ajax({
                url: '{{ route("account.removeProductFromWishlist") }}',
                type: 'post',
                data: {
                    product_id: id,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        window.location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
            })
        }
    </script>
@endsection
