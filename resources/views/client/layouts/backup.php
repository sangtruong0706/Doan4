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
                                <li class="{{ is_array($brandSelected) && in_array($brand->id, $brandSelected) ? 'active' : '' }}">
                                    <a class="brand_label" href="{{ route('client.shop', [ $category->slug, $brand->id]) }}" data-value="{{ $brand->id }}">{{ $brand->name }}</a>
                                </li>
                            @endforeach
                        @endif
                     </ul>
                  </div>
               </div>
               <div class="">
                  <div class="" style="width:200px;">
                     <h1>Price</h1>
                        {{-- <input  type="text" class="js-range-slider" name="my_range" value="" /> --}}
                        <input type="text" class="js-range-slider" name="my_range" value="" data-from="{{ $priceRange['from'] ?? 0 }}" data-to="{{ $priceRange['to'] ?? 500 }}" />
                  </div>
               </div>
            </div>
         </div>
         <div class="grid__item  nine-twelfths small--one-whole medium--one-whole">
            <div class="shop_product_section">
               <div class="grid">
                  <div class="product_grid">
                     <div class="top_bar">
                        <div class="grid__item one-half small--one-whole medium--one-whole">
                           <h1>WATCHES</h1>
                        </div>
                        <div class="grid__item one-half">
                           <div class="filter_toggle hide small--show medium--show">
                              <h4><span><i class="fa fa-plus-square" aria-hidden="true"></i></span>Filter</h4>
                           </div>
                        </div>
                        <div class="grid__item one-half small--one-half">
                           <div class="sorting">
                              <p class="small--hide">Sort By</p>
                              <!-- /snippets/collection-sorting.liquid -->
                              <div class="sorting_item">
                                 <button class="sorting_btn"  id="sorting_title" data-toggle="dropdown">
                                 Sort By
                                 </button>
                                 <ul class="dropdown-sort" id="sort_by" role="menu" style="overflow: hidden; display: none;">
                                    <li name="featured">Featured</li>
                                    <li name="best-selling">Best Selling</li>
                                    <li name="title-ascending">Alphabetically, A-Z</li>
                                    <li name="title-descending">Alphabetically, Z-A</li>
                                    <li name="price-ascending">Price, low to high</li>
                                    <li name="price-descending">Price, high to low</li>
                                    <li name="created-descending">Date, new to old</li>
                                    <li name="created-ascending">Date, old to new</li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="block-row">
                        <div class="product_list">
                            @if ($products->isNotEmpty())
                                @foreach ($products as $product )
                                    <div class="grid__item three-twelfths small--one-whole medium--one-half">
                                        <div class="product_item">
                                        <a href="/products/ancher-leather-chronograph-watch">
                                            <div class="product_image">
                                                <span class="product_overlay"></span>
                                        <a href="/products/ancher-leather-chronograph-watch" class="btn">Shop Now</a>
                                        <?php
                                            $productImage = $product->productImages->first();
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
                                            <a href="/products/ancher-leather-chronograph-watch">{{ $product->brand->name }}</a>
                                            <h3><a href="/products/ancher-leather-chronograph-watch">{{ $product->title }}</a></h3>
                                            <h4>${{ $product->price }}
                                            </h4>
                                            <span class="shopify-product-reviews-badge" data-id="8162296584"></span>
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
      </div>
   </div>
</div>
@endsection
@section('customJs')
    <script>
        rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 1000,
            from: 0,
            step: 10,
            to: 500,
            skin: "square",
            max_postfix: "+",
            prefix: "$",
            onChange: function() {
                apply_filters()
            }
        });
        var slider = $(".js-range-slider").data("ionRangeSlider");


        $(".brand_label").click(function(event){
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
            apply_filters();
        });



        function apply_filters() {
            // var brand = [];
            // $("#brand-label").each(function() {
            //     if ($(this).is(":focus")) { // Kiểm tra xem thẻ có được click không
            //         brand.push($(this).data('value'));
            //     }
            // });
            var brand = ''; // Khởi tạo biến brand là một chuỗi rỗng

            $(".brand_label").each(function() {
                if ($(this).is(":focus")) { // Kiểm tra xem thẻ có được click không
                    brand = $(this).data('value'); // Gán giá trị của brand đã được chọn vào biến brand
                }
            });

            var url = '{{ url()->current() }}?';

            url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;

            // console.log(brand.toString());
            window.location.href = url +'&brand='+ brand.toString();
        }

    </script>

@endsection
