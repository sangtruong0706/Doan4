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
             <a href="{{ route("client.page",'about-us') }}" class="btn btn--large">View More</a>
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
                                    <h4>{{ number_format($product->price, 0, ',', '.') }} vnđ</h4>
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
                                    <h4>{{ number_format($product_latest->price, 0, ',', '.') }} vnđ</h4>
                                </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

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
            @if($blogs->isnotempty())
                @foreach ($blogs as $blog)
                    <div class="grid__item one-half small--one-whole medium--one-whole">
                        <div class="blog_item">
                        <div class="blog_img">
                            <a href="">
                                @if (!empty($blog->image))
                                    <img src="{{ asset('uploads/blog/thumb/'.$blog->image) }}"  >
                                @else
                                    <img src="{{ asset('admin-asset/img/default-150x150.png') }}">
                                @endif
                            </a>
                        </div>
                        <h2> <a href="">{{ $blog->title }}</a></h2>
                        <h5>{{ \Carbon\Carbon::parse($blog->created_at)->format('d-m-Y') }}</h5>
                        <div class="content-blog-home"> {!! $blog->content !!}</div>
                        <a href="" class="blog_read_more my-2">Read more
                        <span><i class="fa fa-angle-right"></i></span></a>
                        </div>
                    </div>
                @endforeach
            @endif
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
