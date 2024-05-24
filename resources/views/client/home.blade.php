@extends('client.layouts.app')
@section('content')
<!-- Hero Slider Start -->
@include('client.layouts.slide')
 <!-- Hero Slider End -->

 <!-- Home about start -->
 <div class="home_about_section">
    <div class="container">
       <div class="grid">
          <div class="grid__item large--six-twelfths push--large--three-twelfths">
             <h1>Something About Us</h1>
             <p>Watches. We rely on them to get us where we need be on time.And with proper care, they will do just that. It's an uncomplicated relationship. But is that all you expect in a Watch?, Not a chance. And is that all our watch designs strive toward? Well, you know the answer. Your wrist watch just might be the most defining accessory you could choose. Whether your taste runs the gamut of designer watches to expensive watches even sport multifunction watches we know that what you put on your wrist takes thought and maybe even a little time (how ironic) to settle on. It's because you know that at a glance, your watch says something about you. And for the curious, it gives Just enough insight as to who you are.</p>
             <a href="/pages/about-us" class="btn btn--large">View More</a>
          </div>
       </div>
    </div>
 </div>
 <!-- Home about end -->
 <!--======  #Colection LIST  ===============-->
 <div class="home_coll_section">
    <div class="container">
       <div class="grid">
          <div class="home_collection">
             <h1>Collection</h1>
             <div class="collection_list">
                @if ($categories_index->isNotEmpty())
                    @foreach ($categories_index as $cate)
                        <div class="grid__item large--four-twelfths small--one-whole medium--one-whole max-medium--four-twelfths">
                            <a href="/collections/mens" class="collection_item">
                            <img src="{{ asset('uploads/category/'.$cate->image) }}" alt="{{ $cate->name }}" />
                            <span class="collection_overlay"></span>
                            <h2>{{ $cate->name }}</h2>
                            </a>
                        </div>
                    @endforeach
                @endif
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="home_coll_section">
    <div class="container">
       <div class="grid" id="popular_product">
          <div class="popular_product_section">
             <h1>Feature Products</h1>
             <div class="block-row">
                <div class="product_list">
                    @if ($features_products->isNotEmpty())
                        @foreach ($features_products as $product )
                            <div class="grid__item three-twelfths small--one-whole medium--one-half">
                                <div class="product_item">
                                <a href="{{ route("client.product", $product->id) }}">
                                    <div class="product_image">
                                        <span class="product_overlay"></span>
                                <a href="{{ route("client.product", $product->id) }}" class="btn">Shop Now</a>
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
                                    <a href="{{ route("client.product", $product->id) }}">{{ $product->brand->name }}</a>
                                    <h3><a href="{{ route("client.product", $product->id) }}">{{ $product->title }}</a></h3>
                                    <h4>${{ $product->price }}
                                    </h4>
                                </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
             </div>
             <div class="featured_btn">
                <a href="{{ route("client.shop") }}" class="btn">
                View All <span><i class="fa fa-angle-right"></i></span>
                </a>
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="home_coll_section">
    <div class="container">
       <div class="grid" id="popular_product">
          <div class="popular_product_section">
             <h1>Latest Products</h1>
             <div class="block-row">
                <div class="product_list">
                    @if ($latest_products->isNotEmpty())
                        @foreach ($latest_products as $product_latest )
                            <div class="grid__item three-twelfths small--one-whole medium--one-half">
                                <div class="product_item">
                                <a href="{{ route("client.product", $product_latest->id) }}">
                                    <div class="product_image">
                                        <span class="product_overlay"></span>
                                <a href="{{ route("client.product", $product_latest->id) }}" class="btn">Shop Now</a>
                                <?php
                                    $productImage = $product_latest->productImages->first();
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
                                    <a href="{{ route("client.product", $product_latest->id) }}">{{ $product_latest->brand->name }}</a>
                                    <h3><a href="{{ route("client.product", $product_latest->id) }}">{{ $product_latest->title }}</a></h3>
                                    <h4>${{ $product_latest->price }}
                                    </h4>
                                </div>
                                </div>
                            </div>
                        @endforeach
                    @endif


                   {{-- <div class="grid__item three-twelfths small--one-whole medium--one-half">
                      <div class="product_item">
                         <a href="/products/armani-swiss-made-cronograph-watch">
                            <div class="product_image">
                               <span class="product_overlay"></span>
                         <a href="/products/armani-swiss-made-cronograph-watch" class="btn">Shop Now</a>
                         <img src="client-asset/img/products/50158920rp_large.jpg" alt="armani- SWISS MADE CRONOGRAPH WATCH"/>
                         <span class="onsale">Sale</span>
                         <span class="onnew">New</span>
                         </div>
                         </a>
                         <div class="product_desc">
                            <a href="/products/armani-swiss-made-cronograph-watch">armani</a>
                            <h3><a href="/products/armani-swiss-made-cronograph-watch">Armani- swiss made cronograph watch</a></h3>
                            <h4>$359.00
                               <span><del>$450.00</del></span>
                            </h4>
                            <span class="shopify-product-reviews-badge" data-id="8162281608"></span>
                         </div>
                      </div>
                   </div>
                   <div class="grid__item three-twelfths small--one-whole medium--one-half">
                      <div class="product_item">
                         <a href="/products/pre-owned-rolex-mens-submariner-stainless-steel-black-dial-watch">
                            <div class="product_image">
                               <span class="product_overlay"></span>
                         <a href="/products/pre-owned-rolex-mens-submariner-stainless-steel-black-dial-watch" class="btn">Shop Now</a>
                         <img src="client-asset/img/products/Pre-Owned-Rolex-Mens-Submariner-Stainless-Steel-Black-Dial-Watch_arge.jpg" alt="Pre-Owned Rolex Men's Submariner Stainless Steel Black Dial Watch"/>
                         </div>
                         </a>
                         <div class="product_desc">
                            <a href="/products/pre-owned-rolex-mens-submariner-stainless-steel-black-dial-watch">rolex</a>
                            <h3><a href="/products/pre-owned-rolex-mens-submariner-stainless-steel-black-dial-watch">Pre-owned rolex men's submariner stainless steel black dial watch</a></h3>
                            <h4>$810.00
                            </h4>
                            <span class="shopify-product-reviews-badge" data-id="8162283400"></span>
                         </div>
                      </div>
                   </div>
                   <div class="grid__item three-twelfths small--one-whole medium--one-half">
                      <div class="product_item">
                         <a href="/products/tag-heuer-aquaracer-watch-1">
                            <div class="product_image">
                               <span class="product_overlay"></span>
                         <a href="/products/tag-heuer-aquaracer-watch-1" class="btn">Shop Now</a>
                         <img src="client-asset/img/products/Tag-Heuer-Formula_large.jpg" alt="Tag Heuer 1 Waz1110.ba0875 Watch"/>
                         <span class="onnew">New</span>
                         </div>
                         </a>
                         <div class="product_desc">
                            <a href="/products/tag-heuer-aquaracer-watch-1">tagheuer</a>
                            <h3><a href="/products/tag-heuer-aquaracer-watch-1">Tag heuer 1 waz1110.ba0875 watch</a></h3>
                            <h4>$499.00
                            </h4>
                            <span class="shopify-product-reviews-badge" data-id="8162274248"></span>
                         </div>
                      </div>
                   </div> --}}
                </div>
             </div>
             <div class="featured_btn">
                <a href="/collections/new-arrivals" class="btn">
                View All <span><i class="fa fa-angle-right"></i></span>
                </a>
             </div>
          </div>
       </div>
    </div>
 </div>
 <!--======  #Colection LIST end ===============-->

 <!--======  #BLOG LIST  ===============-->
 <div class="blog_section">
    <div class="container">
       <div class="grid">
          <h1>Style inspiration, straight from social</h1>
          <div class="blog_list">
             <div class="grid__item one-half small--one-whole medium--one-whole">
                <div class="blog_item">
                   <div class="blog_img">
                      <a href="/blogs/news/mercado-credito-shopify-integration-in-mexico-enhancing-e-commerce-payments">
                      <img src="" alt="Mercado Crédito Shopify Integration in Mexico: Enhancing E-commerce Payments" />
                      </a>
                   </div>
                   <h2> <a href="">Mercado Crédito Shopify Integration in Mexico: Enhancing E-commerce Payments</a></h2>
                   <h5>09 Apr 2024</h5>
                   <p> Mercado Crédito Shopify Integration in Mexico: Enhancing E-commerce Payments Introduction: Picture this: You've found the perfect item after hours of...</p>
                   <a href="" class="blog_read_more">Read more
                   <span><i class="fa fa-angle-right"></i></span></a>
                </div>
             </div>
             <div class="grid__item one-half small--one-whole medium--one-whole">
                <div class="blog_item">
                   <div class="blog_img">
                      <a href="">
                      <img src="" alt="We've got your wirst watch covered" />
                      </a>
                   </div>
                   <h2> <a href="">We've got your wirst watch covered</a></h2>
                   <h5>07 Nov 2016</h5>
                   <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut...</p>
                   <a href="" class="blog_read_more">Read more
                   <span><i class="fa fa-angle-right"></i></span></a>
                </div>
             </div>
          </div>
          <div class="more_blog_btn">
             <a href="/blogs/news" class="btn">VIEW ALL <span><i class="fa fa-angle-right"></i></span></a>
          </div>
       </div>
    </div>
 </div>
 <!--======  #INSTAGRAM  ===============-->
 <div class="parallax-window insta_section" >
    <span class="insta_overlay"></span>
    <div class="container">
       <h1>Follow us on Instagram @hulkthemes</h1>
       <div class="insta_list" id="instafeed" >
       </div>
    </div>
 </div>
@endsection
