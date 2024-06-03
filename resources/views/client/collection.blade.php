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
          <div class="shop_product_section collection_section">
             <div class="block-row">
                <div class="product_list">
                   <div class="section-header grid__item">
                      <p class="h1 section-header__left">All</p>
                      <div class="section-header__right">
                         <a class="btn btn-primary" href="/collections/all" title="Browse our All collection">View All <span><i class="fa fa-angle-right"></i></span></a>
                      </div>
                   </div>
                   <!-- /snippets/product-grid-item.liquid -->
                   <div class="grid__item three-twelfths small--one-whole medium--one-half list-collections">
                      <div class="product_item">
                         <a href="/collections/all/products/ancher-leather-chronograph-watch">
                         </a>
                         <div class="product_image" style="height: 318px;"><a href="/collections/all/products/ancher-leather-chronograph-watch">
                            <span class="product_overlay"></span>
                            </a><a href="/collections/all/products/ancher-leather-chronograph-watch" class="btn">Shop Now</a>
                            <img src="//chicago-theme.myshopify.com/cdn/shop/products/SKW6106_main_large_ba79bc2b-181b-40af-8447-b48d83316c18_large.jpg?v=1487908443" alt="Ancher Leather Chronograph Watch">
                         </div>
                         <div class="product_desc">
                            <a href="/collections/all/products/ancher-leather-chronograph-watch">skagen</a>
                            <h3><a href="/collections/all/products/ancher-leather-chronograph-watch">Ancher leather chronograph watch</a></h3>
                            <h4>$210.00
                            </h4>
                            <span class="shopify-product-reviews-badge" data-id="8162296584"></span>
                         </div>
                      </div>
                   </div>
                   <!-- /snippets/product-grid-item.liquid -->
                   <div class="grid__item three-twelfths small--one-whole medium--one-half list-collections">
                      <div class="product_item">
                         <a href="/collections/all/products/ancher-leather-watch">
                         </a>
                         <div class="product_image" style="height: 318px;"><a href="/collections/all/products/ancher-leather-watch">
                            <span class="product_overlay"></span>
                            </a><a href="/collections/all/products/ancher-leather-watch" class="btn">Shop Now</a>
                            <img src="//chicago-theme.myshopify.com/cdn/shop/products/SKW6024_main_large_a2bdaad3-d7de-4d59-9f74-bd99f11f0975_large.jpg?v=1487908466" alt="Ancher Leather Watch">
                            <span class="onsale">Sale</span>
                            <span class="onnew">New</span>
                         </div>
                         <div class="product_desc">
                            <a href="/collections/all/products/ancher-leather-watch">skagen</a>
                            <h3><a href="/collections/all/products/ancher-leather-watch">Ancher leather watch</a></h3>
                            <h4>$385.00
                               <span><del>$580.00</del></span>
                            </h4>
                            <span class="shopify-product-reviews-badge" data-id="8162295368"></span>
                         </div>
                      </div>
                   </div>
                   <!-- /snippets/product-grid-item.liquid -->
                   <div class="grid__item three-twelfths small--one-whole medium--one-half list-collections">
                      <div class="product_item">
                         <a href="/collections/all/products/armani-classic-collection-analogical-watch">
                         </a>
                         <div class="product_image" style="height: 318px;"><a href="/collections/all/products/armani-classic-collection-analogical-watch">
                            <span class="product_overlay"></span>
                            </a><a href="/collections/all/products/armani-classic-collection-analogical-watch" class="btn">Shop Now</a>
                            <img src="//chicago-theme.myshopify.com/cdn/shop/products/50181832xu_13_n_f_grande_6bb82a5f-436f-4311-a20e-21a3b11b1384_large.jpg?v=1478114828" alt="armani - CLASSIC COLLECTION ANALOGICAL WATCH">
                         </div>
                         <div class="product_desc">
                            <a href="/collections/all/products/armani-classic-collection-analogical-watch">armani</a>
                            <h3><a href="/collections/all/products/armani-classic-collection-analogical-watch">Armani - classic collection analogical watch</a></h3>
                            <h4>$273.00
                            </h4>
                            <span class="shopify-product-reviews-badge" data-id="8162282376"></span>
                         </div>
                      </div>
                   </div>
                   <!-- /snippets/product-grid-item.liquid -->
                   <div class="grid__item three-twelfths small--one-whole medium--one-half list-collections">
                      <div class="product_item">
                         <a href="/collections/all/products/armani-swiss-made-cronograph-watch">
                         </a>
                         <div class="product_image" style="height: 318px;"><a href="/collections/all/products/armani-swiss-made-cronograph-watch">
                            <span class="product_overlay"></span>
                            </a><a href="/collections/all/products/armani-swiss-made-cronograph-watch" class="btn">Shop Now</a>
                            <img src="//chicago-theme.myshopify.com/cdn/shop/products/50158920rp_13_n_f_large.jpg?v=1478114826" alt="armani- SWISS MADE CRONOGRAPH WATCH">
                            <span class="onsale">Sale</span>
                            <span class="onnew">New</span>
                         </div>
                         <div class="product_desc">
                            <a href="/collections/all/products/armani-swiss-made-cronograph-watch">armani</a>
                            <h3><a href="/collections/all/products/armani-swiss-made-cronograph-watch">Armani- swiss made cronograph watch</a></h3>
                            <h4>$359.00
                               <span><del>$450.00</del></span>
                            </h4>
                            <span class="shopify-product-reviews-badge" data-id="8162281608"></span>
                         </div>
                      </div>
                   </div>
                   <hr>
                   @if ($brands->isNotEmpty())
                        @foreach ($brands as $brand)
                            <div class="section-header grid__item">
                                <p class="h1 section-header__left">{{ $brand->name }}</p>
                                <div class="section-header__right">
                                <a class="btn btn-primary" href="{{ url('/shop') . '?&brand=' . $brand->id }}" title="Browse our {{ $brand->name }} collection">View {{ $brand->name }} <span><i class="fa fa-angle-right"></i></span></a>
                                </div>
                            </div>
                            @if($brand->products->isNotEmpty())
                                @foreach ($brand->products->slice(0, 4) as $product )
                                    <div class="grid__item three-twelfths small--one-whole medium--one-half list-collections">
                                        <div class="product_item">
                                        <a href="">
                                        </a>
                                        <div class="product_image" style="height: 258px;"><a href="">
                                            <span class="product_overlay"></span>
                                            </a><a href="" class="btn">Shop Now</a>
                                            @php
                                                $productImages = getProductImages($product->id);
                                            @endphp
                                            {{-- <img src="//chicago-theme.myshopify.com/cdn/shop/products/Pre-Owned-Rolex-Mens-Submariner-Stainless-Steel-Black-Dial-Watch-03510f01-0001-4d37-9b7d-f0018ad2682e_600_large.jpg?v=1478114831" alt="Pre-Owned Rolex Men's Submariner Stainless Steel Black Dial Watch"> --}}
                                            @if (!empty($productImages->image))
                                                <img src="{{ asset('uploads/product/small/'.$productImages->image) }}" >
                                            @else
                                                <img src="{{ asset('admin-asset/img/default-150x150.png') }}"  >
                                            @endif
                                        </div>
                                        <div class="product_desc">
                                            <a href="">{{ $product->brand->name }}</a>
                                            <h3><a href="">{{ $product->title }}</a></h3>
                                            <h4>
                                                {{ number_format($product->price, 0, ',' , '.') }} vnđ
                                            </h4>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                        <hr>
                   @endif
                   @if ($categories->isNotEmpty())
                        @foreach ($categories as $category)
                            <div class="section-header grid__item">
                                <p class="h1 section-header__left">{{ $category->name }}</p>
                                <div class="section-header__right">
                                <a class="btn btn-primary" href="{{ route("client.shop", $category->slug) }}" title="Browse our {{ $category->name }} collection">View {{ $category->name }} <span><i class="fa fa-angle-right"></i></span></a>
                                </div>
                            </div>
                            @if($category->products->isNotEmpty())
                                @foreach ($category->products->slice(0, 4) as $product )
                                    <div class="grid__item three-twelfths small--one-whole medium--one-half list-collections">
                                        <div class="product_item">
                                        <a href="">
                                        </a>
                                        <div class="product_image" style="height: 258px;"><a href="">
                                            <span class="product_overlay"></span>
                                            </a><a href="" class="btn">Shop Now</a>
                                            @php
                                                $productImages = getProductImages($product->id);
                                            @endphp
                                            {{-- <img src="//chicago-theme.myshopify.com/cdn/shop/products/Pre-Owned-Rolex-Mens-Submariner-Stainless-Steel-Black-Dial-Watch-03510f01-0001-4d37-9b7d-f0018ad2682e_600_large.jpg?v=1478114831" alt="Pre-Owned Rolex Men's Submariner Stainless Steel Black Dial Watch"> --}}
                                            @if (!empty($productImages->image))
                                                <img src="{{ asset('uploads/product/small/'.$productImages->image) }}" >
                                            @else
                                                <img src="{{ asset('admin-asset/img/default-150x150.png') }}"  >
                                            @endif
                                        </div>
                                        <div class="product_desc">
                                            <a href="">{{ $product->brand->name }}</a>
                                            <h3><a href="">{{ $product->title }}</a></h3>
                                            <h4>
                                                {{ number_format($product->price, 0, ',' , '.') }} vnđ
                                            </h4>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                        <hr>
                   @endif


                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection
@section('customJs')
@endsection
