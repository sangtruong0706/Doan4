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
                  <li><a href="{{ route("client.blog") }}" title="">Blog</a></li>
                  <li><a class="text-black" href="" title="">{{ $blog->title }}</a></li>
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
             <!-- /snippets/blog-sidebar.liquid -->
             <div class="sidebar_section">
                <div class="sidebar_item">
                   <h1>Search</h1>
                   <form action="/search" method="get" role="search">
                      <input type="search" id="search-input_blog" name="q" value="" placeholder="search..." required="">
                      <input type="hidden" name="type" value="article">
                   </form>
                </div>
                <div class="sidebar_item medium-down--hide">
                    <h1>Categories</h1>
                    <ul>
                     <li>
                         <a class="active" href="{{ route("client.blog","all") }}">All</a>
                     </li>
                         @if ($blog_categories->isNotEmpty())
                             @foreach ($blog_categories as $blog_category)
                                 <li>
                                     <a class="{{ $categorySelected ==$blog_category->id ? 'active' : '' }}" href="{{ route("client.blog", $blog_category->slug) }}">{{ $blog_category->name }}</a>
                                 </li>
                             @endforeach
                         @endif
                    </ul>
                 </div>
             </div>
          </div>
          <div class="grid__item nine-twelfths small--one-whole medium--one-whole right">
            <div class="blog_detail_listing grid">
               <div class="blog_detail_item">
                  <div class="grid__item one-whole">
                     <div class="blog_detail_title">
                        <h3>{{ $blog->title }}</h3>
                        <h6>By <span>{{ $blog->author }}</span> On <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d-m-Y') }}</h6>
                     </div>
                     <div>
                        {!! $blog->content !!}
                     </div>
                     <div class="blog_detail_footer">
                        <div class="blog_share">
                           <h3>Share on:</h3>
                           <ul data-permalink="https://chicago-theme.myshopify.com/blogs/news/elevate-your-online-business-with-shopify-new-order-notification-mastery">
                              <li>
                                 <a target="_blank" href="//www.facebook.com/sharer.php?u=https://chicago-theme.myshopify.com/blogs/news/elevate-your-online-business-with-shopify-new-order-notification-mastery">
                                 <span><i class="fa fa-facebook"></i></span>
                                 </a>
                              </li>
                              <li> <a target="_blank" href="//twitter.com/share?url=https://chicago-theme.myshopify.com/blogs/news/elevate-your-online-business-with-shopify-new-order-notification-mastery&amp;text=Elevate%20Your%20Online%20Business%20with%20Shopify%20New%20Order%20Notification%20Mastery">
                                 <span><i class="fa fa-twitter"></i></span>
                                 </a>
                              </li>
                              <li> <a target="_blank" href="//pinterest.com/pin/create/button/?url=https://chicago-theme.myshopify.com/blogs/news/elevate-your-online-business-with-shopify-new-order-notification-mastery&amp;media=http://chicago-theme.myshopify.com/cdn/shopifycloud/shopify/assets/no-image-2048-5e88c1b20e087fb7bbe9a3771824e743c244f437e4f8ba93bbf7b11b53f7824c_1024x1024.gif&amp;description=Elevate%20Your%20Online%20Business%20with%20Shopify%20New%20Order%20Notification%20Mastery">
                                 <span><i class="fa fa-pinterest-p"></i></span>
                                 </a>
                              </li>
                              <li>
                                 <a target="_blank" href="//plus.google.com/share?url=https://chicago-theme.myshopify.com/blogs/news/elevate-your-online-business-with-shopify-new-order-notification-mastery" class="share-google">
                                    <!-- Cannot get Google+ share count with JS yet -->
                                    <span> <i class="fa fa-google-plus" aria-hidden="true"></i>
                                    </span>
                                 </a>
                              </li>
                           </ul>
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
    {{-- <script>
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
            grid: true,
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

            // search filter
            var keyword = $("#keyword").val();
            if (keyword.length > 0) {
                url += '&search='+ keyword;
            }

            //Sorting filter
            url += '&sort='+$("#sort").val();


            window.location.href = url;
        }
    </script> --}}
@endsection
