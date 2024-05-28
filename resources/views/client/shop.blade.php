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
                     <div class="brand-filter">
                        @if ($brands->isNotEmpty())
                            @foreach ($brands as $brand)
                                <div class="radio_row">
                                    <input {{ (is_array($brandSelected) && in_array($brand->id, $brandSelected)) ? 'checked' : '' }} class="brand_label" type="radio" id="radio{{ $brand->id }}" name="brand" value="{{ $brand->id }}">
                                    <label for="radio{{ $brand->id }}"><span></span>{{ $brand->name }}</label>
                                </div>
                            @endforeach
                        @endif
                     </div>
                  </div>
               </div>
               <div class="">
                  <div class="" style="width:200px;">
                     <h1>Price</h1>
                        <input  type="text" class="js-range-slider" name="my_range" value="" />
                        {{-- <input type="text" class="js-range-slider" name="my_range" value="" data-from="{{ $priceRange['from'] ?? 0 }}" data-to="{{ $priceRange['to'] ?? 500 }}" /> --}}
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
                            <p class="small--hide" style="margin-top: 5px" >Sort By</p>
                              <div class="sorting_item">
                                <div class="row">
                                    <select name="sort" id="sort"  class="sorting_select" id="sorting_title">
                                        <option value="" disabled selected>Sort By</option>
                                        <option {{ $sortSelected =='latest' ? 'selected' : '' }} value="latest">Latest</option>
                                        <option {{ $sortSelected =='price-ascending' ? 'selected' : '' }} value="price-ascending">Price, low to high</option>
                                        <option {{ $sortSelected =='price-descending' ? 'selected' : '' }} value="price-descending">Price, high to low</option>
                                    </select>
                                </div>


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
                                        <a  href="{{ route("client.product", $product->id) }}">
                                            <div class="product_image">
                                                <span class="product_overlay"></span>
                                        <a  href="{{ route("client.product", $product->id) }}" class="btn">Shop Now</a>
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
                                            <a  href="{{ route("client.product", $product->id) }}">{{ $product->brand->name }}</a>
                                            <h3><a  href="{{ route("client.product", $product->id) }}">{{ $product->title }}</a></h3>
                                            <h4>{{ number_format($product->price, 0, ',', '.') }} vnđ</h4>
                                            <span class="shopify-product-reviews-badge" data-id="8162296584"></span>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                     </div>
                     <div>
                        {{ $products->withQueryString()->links('vendor.pagination.custom') }}
                     </div>
                     {{-- <div class="pagination">
                        <ul>
                            <li><a href="/collections/all?page=1" class="prev_page"><span><i class="fa fa-angle-left"></i></span></a></li>
                            <li><a href="/collections/all?page=1" title="">1</a></li>
                            <li><a href="#" class="active_page">2</a></li>
                        </ul>
                     </div> --}}
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
            max: 100000000,
            from: {{ $price_min }},
            step: 100,
            to: {{ $price_max }},
            skin: "square",
            max_postfix: "+",
            prefix: "vnđ ",
            onChange: function() {
                apply_filters()
            }
        });
        var slider = $(".js-range-slider").data("ionRangeSlider");

        $(".brand_label").change(function() {
            apply_filters();
        });

        $("#sort").change(function() {
            apply_filters();
        })

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
    </script>
@endsection
