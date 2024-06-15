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
                  <li><a class="text-black" href="" title="">all</a></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
 {{-- <!--Wishlist Modal -->
 <div class="modal fade" id="wishListModal" style="z-index: 999" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Succec</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div> --}}
<div class="content">
    <!-- Content Start -->
    <div class="container">
       <div class="grid">
          <div class="grid__item three-twelfths small--one-whole medium--one-whole">
             <!-- Sidebar Start -->
             <div class="sidebar_section shop_filter">
                <span class="filter_close hide small--show medium--show"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                <div class="sidebar-links">
                   <h1>Categories</h1>
                   <ul class="category-filter">
                      <li class=""><a href=""  > All</a></li>
                      @if ($categories->isNotEmpty())
                      @foreach ($categories as $category)
                      <li>
                         <a class="{{ $categorySelected ==$category->id ? 'active' : '' }}"  href="{{ route("client.shop", $category->slug) }}"  > {{ $category->name }}</a>
                      </li>
                      @endforeach
                      @endif
                   </ul>
                </div>
                <div class="filter_sidebar">
                   <div class="sidebar_item">
                      <h1>Brand</h1>
                      <ul class="brand-filter">
                         @if ($brands->isNotEmpty())
                         @foreach ($brands as $brand)
                         <div class="radio_row">
                            <input {{ (is_array($brandSelected) && in_array($brand->id, $brandSelected)) ? 'checked' : '' }} class="brand_label" type="radio" id="radio{{ $brand->id }}" name="brand" value="{{ $brand->id }}">
                            <label for="radio{{ $brand->id }}"><span></span>{{ $brand->name }}</label>
                         </div>
                         @endforeach
                         @endif
                      </ul>
                   </div>
                </div>
             </div>
          </div>
          <form action="" id="productForm">
            <div class="grid__item nine-twelfths small--one-whole medium--one-whole">
                <div class="product_slider_section">
                    <div class="slider_part">
                    <div class="bx-wrapper" style="max-width: 100%;">
                        <div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 445px;">
                            <?php
                            $productImage = $product->productImages;
                            ?>
                            <ul id="product-images" class="product_slider" style="width: auto; position: relative;">
                                @foreach ($productImage as $index => $image)
                                    <li style="float: none; list-style: none; position: absolute; width: 618px; z-index: {{ $index == 0 ? '50' : '0' }}; display: {{ $index == 0 ? 'block' : 'none' }};" class="{{ $index == 0 ? 'active' : '' }}">
                                        <span style="display: inline-block; max-width: 100%; position: relative; overflow: hidden;">
                                            <a href="{{ asset('uploads/product/large/' . $image->image) }}" class="zoom-image">
                                                <img class="product-image" src="{{ asset('uploads/product/small/' . $image->image) }}" alt="Product Image {{ $index + 1 }}" style="display: block;">
                                            </a>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>


                        </div>
                        <div class="bx-controls"></div>
                    </div>
                    </div>
                    <div class="product_pager">
                    <div class="bx-wrapper" style="max-width: 165px;">
                            <div class="bx-viewport" style="width: 100%; overflow: hidden; position: relative; height: 378px;">
                                <div id="bx-pager" style="width: auto; position: relative; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                                    @foreach ($productImage as $index => $image)
                                        <div class="pager_item" style="float: none; list-style: none; position: relative; width: 104px; margin-bottom: 12px;">
                                            <a href="#" data-slide-index="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('uploads/product/small/' . $image->image) }}" alt="Product Image {{ $index + 1 }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="bx-controls bx-has-controls-direction">
                                <div class="bx-controls-direction">
                                    <a class="bx-prev disabled" href=""><i class="fa fa-angle-up"></i></a>
                                    <a class="bx-next disabled" href=""><i class="fa fa-angle-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_specify">
                    <div class="grid">
                    <div class="grid__item five-twelfths small--one-whole medium--one-whole max-medium--six-twelfths">
                        <div class="left_specify product_detail">
                            <h2>{{ $product->title }}</h2>
                            <div class="detail_row">
                                <h4><span>Brand</span>:</h4>
                                <p>{{ $product->brand->name }}</p>
                            </div>
                            <div class="detail_row">
                                <h4><span>Product code</span>:</h4>
                                <p>{{ $product->product_code }} </p>
                            </div>
                            <div class="detail_row">
                                <div class="star-rating mt-2" title="70%">
                                    <div class="back-stars">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <p class="mx-2">({{ ($product->ratings_count > 1) ? $product->ratings_count.' Reviews' : $product->ratings_count.' Review' }})</p>
                                </div>
                            </div>
                            <div class="detail_row">
                                <h4><span>Share this</span>:</h4>
                                <ul>
                                <li>
                                    <a target="_blank" href="#">
                                    <span><i class="fa fa-facebook"></i></span>
                                    </a>
                                </li>
                                <li> <a target="_blank" href="#">
                                    <span><i class="fa fa-twitter"></i></span>
                                    </a>
                                </li>
                                <li> <a target="_blank" href="#">
                                    <span><i class="fa fa-pinterest-p"></i></span>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" href="#" class="share-google">
                                        <!-- Cannot get Google+ share count with JS yet -->
                                        <span> <i class="fa fa-google-plus" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="grid__item six-twelfths push--large--one-twelfth small--one-whole medium--one-whole max-medium--six-twelfths" itemscope="" itemtype="http://schema.org/Product">
                        <form action="/cart/add" method="post" enctype="multipart/form-data" id="AddToCartForm" style="display:inline;">
                            <div class="right_specify product_detail">
                                <div class="detail_row price_row">
                                <h4><span>Price</span>:</h4>
                                <h3>
                                    <span id="ProductPrice" class="h2">{{ number_format($product->price, 0, ',', '.') }} vnđ</span>

                                </h3>
                                </div>
                                <div class="detail_row color_row">
                                <style>
                                    label[for="product-select-option-0"] { display: none; }
                                    #product-select-option-0 { display: none; }
                                    #product-select-option-0 + .custom-style-select-box { display: none !important; }
                                </style>
                                <script>$(window).load(function() { $('.selector-wrapper:eq(0)').hide(); });</script>
                                <h4><span>Size</span>:</h4>
                                <div class="swatch Size clearfix color_form" data-option-index="0">
                                        @foreach ($sizes as $size)
                                        <div data-value="{{ $size->name }}" class="row swatch-element {{ $size->name}}">
                                            <input id="swatch-0-{{ $size->name }}" type="radio" name="size" value="{{ $size->name }}" {{ $loop->first ? 'checked' : '' }}>
                                            <label for="swatch-0-{{ $size->name }}">{{ $size->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="detail_row color_row">
                                <h4><span>Color </span>: </h4>
                                <div class="swatch Color clearfix color_form" data-option-index="1">
                                        @foreach ($colors as $color)
                                        <div data-value="{{ $color->name }}" class="row swatch-element color {{ $color->name }}">
                                            <input id="swatch-1-{{ $color->name }}" type="radio" name="color" value="{{ $color->name }}" {{ $loop->first ? 'checked' : '' }}>
                                            <label for="swatch-1-{{ $color->name  }}" class="chk_color" style="background: {{ ( $color->name=='black' ? '#000' : '#fff') }};')"></label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="detail_row qty_row">
                                    <h4><span>Quantity</span>:</h4>
                                    <div class="qty_form">
                                        <button type="button" class="plus" onclick="incrementQuantity()"></button>
                                        <input type="text" value="1" readonly="readonly" name="quantity" class="product-quantity" id="quantity">
                                        <button type="button" class="minus" onclick="decrementQuantity()"></button>
                                    </div>
                                </div>
                                @php
                                    $totalQuantity = $product->productDetails->sum('quantity');
                                @endphp
                                @if ($totalQuantity > 0)
                                    <div class="detail_row submit_row">
                                        {{-- <button>  <a href="javascript:void(0);" onclick="addToCart({{ $product->id }})" class="btn " name="add" >Add to Cart</a></button> --}}
                                          <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn " name="add" >Add to Cart</a>
                                        {{-- <button class="btn" onclick="addToCart({{ $product->id }})" name="add">Add to Cart</button> --}}
                                    </div>
                                @else
                                    <div class="detail_row submit_row">
                                        <a href="#" class="btn disabled">Sold Out</a>
                                    </div>
                                @endif
                            </div>
                        </form>
                        <div class="product_wishlist_btn">
                            <div class="js-wish-list">
                                <button> <a href="javascript:void(0);" onclick="addToWishList({{ $product->id }});" title="Add to wishlist">+ Add to Wishlist</a></button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="tabify_desc">
                    <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                        <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                            <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Description</a></li>
                            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Shipping</a></li>
                            <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Reviews</a></li>
                        </ul>
                        <div id="tabs-1" class="tabs_desc ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
                            <p>
                                {!! $product->description !!}
                            </p>
                        </div>
                        <div id="tabs-2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                        <div id="tabs-3" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
                            <div class="col-md-8">
                            @auth
                                @if ($hasPurchased == true)
                                    <div class="row">
                                    <h3 class="h4 pb-3">Write a Review</h3>
                                    <form action="" method="post" name="productRatingForm" id="productRatingForm">
                                            <div class="form-group mb-3">
                                                <label for="rating">Rating</label>
                                                <br>
                                                <div id="rating" class="rating" style="width: 10rem; display:flex;">
                                                    <input id="rating-5" type="radio" name="rating" value="5"/><label style="background: none!important;" for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-4" type="radio" name="rating" value="4"  /><label style="background: none!important;"  for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-3" type="radio" name="rating" value="3"/><label style="background: none!important;"  for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-2" type="radio" name="rating" value="2"/><label style="background: none!important;"  for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                                    <input id="rating-1" type="radio" name="rating" value="1"/><label style="background: none!important;"  for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                                </div>
                                                <p></p>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="">How was your overall experience?</label>
                                                <textarea name="comment"  id="comment" class="input-full" cols="30" rows="6" placeholder="How was your overall experience?"></textarea>
                                                <p></p>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-dark">Submit</button>
                                            </div>
                                        </form>
                                    <div class="col-md-12 mt-5">
                                        <div class="overall-rating mb-3">
                                            <div class="d-flex">
                                                <h1 class="h3 pe-3">{{ $avgRating }}</h1>
                                                <div class="star-rating mt-2" title="70%">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pt-2 ps-2">({{ ($product->ratings_count > 1) ? $product->ratings_count.' Reviews' : $product->ratings_count.' Review' }} )</div>
                                            </div>
                                        </div>
                                        @if ($product->ratings->isNotEmpty())
                                            @foreach ($product->ratings as $rating )
                                                @php
                                                    $ratingPer = ($rating->rating)*100/5;
                                                @endphp

                                                <div class="rating-group mb-4">
                                                    <span class="author"><strong>{{ $rating->user->name }} </strong></span>
                                                    <div class="star-rating mt-2" >
                                                        <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <div class="front-stars" style="width: {{ $ratingPer }}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="my-3">
                                                        <p>
                                                            {{ $rating->comment }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                    </div>
                                @else
                                    @if ($product->ratings->isNotEmpty())
                                        @foreach ($product->ratings as $rating )
                                            @php
                                                $ratingPer = ($rating->rating)*100/5;
                                            @endphp

                                            <div class="rating-group mb-4">
                                                <span class="author"><strong>{{ $rating->user->name }} </strong></span>
                                                <div class="star-rating mt-2" >
                                                    <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <div class="front-stars" style="width: {{ $ratingPer }}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="my-3">
                                                    <p>
                                                        {{ $rating->comment }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <p>You can only rate products you have purchased.</p>
                                @endif
                            @else
                                @if ($product->ratings->isNotEmpty())
                                    @foreach ($product->ratings as $rating )
                                        @php
                                            $ratingPer = ($rating->rating)*100/5;
                                        @endphp

                                        <div class="rating-group mb-4">
                                            <span class="author"><strong>{{ $rating->user->name }} </strong></span>
                                            <div class="star-rating mt-2" >
                                                <div class="back-stars">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <div class="front-stars" style="width: {{ $ratingPer }}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="my-3">
                                                <p>
                                                    {{ $rating->comment }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <p>Please <a style="font-size:14px; color:#d63612; font-weight:700;" href="{{ route('account.login') }}">Login</a> to rate this product.</p>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="related_products">
                    <div class="grid">
                    <div class="product_grid">
                        <div class="popular_product_section">
                            <h1>Related Products</h1>
                            <div class="product_list">
                                @if ($relatedProducts->isNotEmpty())
                                    @foreach ($relatedProducts as $relatedProduct)
                                        <div class="grid__item four-twelfths small--one-whole medium--one-third">
                                            <div class="product_item">
                                            <a href="{{ route("client.product", $relatedProduct->id) }}">
                                                <div class="product_image">
                                                    <span class="product_overlay"></span>
                                            <a href="{{ route("client.product", $relatedProduct->id) }}" class="btn">Shop Now</a>
                                            <?php
                                                $productImage = $relatedProduct->productImages->first();
                                            ?>
                                            @if (!empty($productImage->image))
                                                <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                            @else
                                                <img src="{{ asset('admin-asset/img/default-150x150.png') }}"  >
                                            @endif
                                            {{-- <img src="{{ asset('uploads/product/small/'.$product->image) }}" alt="Ancher Leather Chronograph Watch"/> --}}
                                            </div>
                                            </a>
                                            <div class="product_desc">
                                                <a href="{{ route("client.product", $relatedProduct->id) }}">{{ $relatedProduct->brand->name }}</a>
                                                <h3><a href="{{ route("client.product", $relatedProduct->id) }}">{{ $relatedProduct->title }}</a></h3>
                                                <h4>${{ $relatedProduct->price }}
                                                </h4>
                                            </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
          </form>
       </div>
    </div>
 </div>

 @endsection
 @section('customJs')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/2.2.0/jquery.elevatezoom.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.zoom-image').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });

        function addToCart(id) {
            var size = $("input[name='size']:checked").val();
            var color = $("input[name='color']:checked").val();
            var quantity = $("#quantity").val();

            $.ajax({
                url: '{{ route("client.addToCart") }}',
                type: 'post',
                data: {
                    id: id,
                    size: size,
                    color: color,
                    quantity: quantity,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        window.location.href = '{{ route("client.cart") }}'
                    } else {
                        toastr.error(response.message);
                    }
                },
            })
        }
        function incrementQuantity() {
            var quantity = parseInt($("#quantity").val());
            $("#quantity").val(quantity ++);
        }
        function decrementQuantity() {
            var quantity = parseInt($("#quantity").val());
            if (quantity > 1) {
                $("#quantity").val(quantity --);
            }
        }

        // document.addEventListener('DOMContentLoaded', function() {
        //     var productImages = document.querySelectorAll('.product-image');
        //     var mainProductImage = document.getElementById('main-product-image');
        //     var mainZoomImage = document.getElementById('main-zoom-image');

        //     // Loop through each product image
        //     productImages.forEach(function(image) {
        //         // Initialize Elevate Zoom for each image
        //         $(image).elevateZoom();

        //         // Attach click event listener to each image
        //         image.addEventListener('click', function(e) {
        //             e.preventDefault();

        //             // Get the URL of the selected image
        //             var selectedImageUrl = image.src;
        //             var zoomImageUrl = image.getAttribute('data-zoom-image');

        //             // Update the src of the main product image
        //             mainProductImage.src = selectedImageUrl;
        //             mainZoomImage.src = zoomImageUrl;

        //             // Destroy and reinitialize Elevate Zoom with the new image
        //             $(image).data('elevateZoom').swaptheimage(selectedImageUrl, zoomImageUrl);
        //         });
        //     });
        // });

        $(".brand_label").change(function() {
            apply_filters();
        });
        function apply_filters() {
            var brands = [];
            $(".brand_label").each(function() {
                if ($(this).prop("checked")) {
                    brands.push($(this).val());
                }
            });

            var url = '{{ url()->current() }}?';
            // Brands fiter
            if (brands.length > 0) {
                url += '&brand='+ brands.toString();
            }

            // Price Range Filter
            url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;

            //Sorting filter
            url += '&sort='+$("#sort").val();


            window.location.href = url;
        }

        function addToWishList(id) {
            var size = $("input[name='size']:checked").val();
            var color = $("input[name='color']:checked").val();
            var quantity = $("#quantity").val();

            $.ajax({
                url: '{{ route("client.addToWishList") }}',
                type: 'post',
                data: {
                    product_id: id,
                    size: size,
                    color: color,
                    quantity: quantity,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        toastr.success(response.message);
                    } else {
                        window.location.href = '{{ route("account.login") }}'
                    }
                },
            })
        }

        $("#productRatingForm").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route("account.saveRating", $product->id) }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        window.location.href = '{{ route("client.product", $product->id) }}'
                    } else {
                        var errors = response.errors;
                        if (errors.rating) {
                            $("#rating").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors.rating);
                        }else {
                            $("#rating").removeClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html("");
                        }
                        if (errors.comment) {
                            $("#comment").addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html(errors.comment);
                        }else {
                            $("#comment").removeClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback').html("");
                        }
                    }


                },
            })
        });
    </script>
@endsection
