<!doctype html>
<html class="no-js">
   <!--<![endif]-->
   <head>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
      <!-- Google Tag Manager -->
      <script src="{{ asset ("client-asset/js/gmt.js") }}" type="text/javascript"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <!-- Basic page needs ================================================== -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <link rel="shortcut icon" href="{{ asset("client-asset/favicon/favicon_icon.png") }}" type="image/png" />
      <!-- Title and description ================================================== -->
      <title>
         Sang &ndash; Chicago Theme
      </title>
      <!-- CSS ================================================== -->
      <link href="{{ asset("client-asset/css/style.scss.css") }}" rel="stylesheet" type="text/css" media="all" />
      <link href="{{ asset("client-asset/css/ion.rangeSlider.min.css") }}" rel="stylesheet" type="text/css" media="all" />
      {{-- <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,400italic,300,500,700' rel='stylesheet' type='text/css'> --}}
      <link href="{{ asset ("client-asset/font/font-awesome.css") }}" rel="stylesheet" type="text/css" media="all" />
      {{-- <link href="{{ asset ("client-asset/owl_carousel/owl.carousel.css") }}" rel="stylesheet" type="text/css" media="all" /> --}}
      <link href="{{ asset ("client-asset/css/jquery-ui.css") }}" rel="stylesheet" type="text/css" media="all" />


      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>


      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

      <!-- js ================================================== -->
      <script src="{{ asset ("client-asset/js/jquery.min.js") }}" type="text/javascript"></script>
      <script src="{{ asset ("client-asset/js/jquery.bxslider.js") }}" type="text/javascript"></script>
      {{-- <script src="{{ asset ("client-asset/js/owl.carousel.min.js") }}" type="text/javascript"></script> --}}
      <script src="{{ asset ("client-asset/js/jquery.meanmenu.js") }}" type="text/javascript"></script>
      <script src="{{ asset ("client-asset/js/jquery-ui.js") }}" type="text/javascript"></script>
      <script src="{{ asset ("client-asset/js/grids.js") }}" type="text/javascript"></script>
      <script src="{{ asset ("client-asset/js/fastclick.min.js") }}" type="text/javascript"></script>
      <script src="{{ asset ("client-asset/js/hulkthemes.js") }}" type="text/javascript"></script>




      <script src="{{ asset ("client-asset/js/chicago.js") }}" type="text/javascript"></script>
      <script src="{{ asset ("client-asset/js/jquery.history.js") }}" type="text/javascript"></script>
      {{-- <script src="{{ asset ("client-asset/js/shopify-modules.js") }}" type="text/javascript"></script> --}}
      <script src="{{ asset ("client-asset/js/shopify-analytics-setup.js") }}" type="text/javascript"></script>
      {{-- <script src="{{ asset ("client-asset/js/shopify-features.js") }}" type="text/javascript"></script> --}}
      <script src="{{ asset ("client-asset/js/jquery.cookie.js") }}" type="text/javascript"></script>
      <script src="{{ asset ("client-asset/js/handlebars.min.js") }}" type="text/javascript"></script>
      {{-- <script src="{{ asset ("client-asset/js/modernizr.min.js") }}" type="text/javascript"></script> --}}
      {{-- <script src="{{ asset ("client-asset/js/jquery.zoom.js") }}" type="text/javascript"></script> --}}
      <!-- Body font -->
      <link href="{{ asset ("client-asset/font/font.css") }}" rel="stylesheet" type="text/css" media="all" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
   </head>
   <body  class="template-index" >
      <div id="PageContainer">
         <header>
            <!-- Header Start -->
            <div class="container">
               <div class="grid">
                  <div class="grid__item five-twelfths max-large--four-twelfths max-medium--four-twelfths">
                     <div class="logo_section">
                        <a href="{{ route("client.home") }}" itemprop="url">
                        <img src="{{ asset ("client-asset/img/logo/logo.png") }}" itemprop="logo"/>
                        </a>
                     </div>
                  </div>
                  <div class="grid__item seven-twelfths small--one-whole medium--one-whole max-medium--eight-twelfths medium-header max-large--eight-twelfths">
                     <div class="right_header">
                        <div class="header_right_icon">
                           <ul>
                              <li class="search_icon">
                                 <a class="btn_icon" id="opened_search"> </a><a class="close_btn"></a>
                              </li>
                              <li class="account_icon">
                                 <a class="btn_icon small--hide medium--hide max-medium--hide" id="opened_account"></a><a class="close_btn"></a>
                                 <a href="/account/login" class="mob_btn_icon hide max-medium--show small--show medium--show"></a>
                              </li>
                              <li>
                                 <a class="site-header__cart-toggle js-drawer-open-right cart_ico" >
                                    <span id="CartCount">
                                        @if ($countCart > 0)
                                            {{ $countCart }}
                                        @else
                                            {{ "0"; }}
                                        @endif
                                    </span>
                                 </a>
                              </li>
                           </ul>
                           <div class="opened_search">
                              <!-- form serch-->
                              <form action="/search" method="get"  role="search">
                                 <input type="search" name="keyword" id="search-input"  placeholder="Search Products here...." required>
                                 <input type="submit"/>
                                 <!-- <button type="submit"><img src="assets/img/svg/search-ico.svg"alt=""></button> -->
                              </form>
                           </div>
                           <div class="opened_account {{ Auth::check() ? 'login active' : '' }}">
                                <!-- Nếu người dùng chưa đăng nhập, hiển thị form login -->
                                @guest
                                    <form method="post" action="{{ route("account.authenticate") }}" id="customer_login">
                                        @csrf
                                        <input type="email" name="email" id="CustomerEmail" placeholder="Email">
                                        <input type="password" name="password" id="CustomerPassword" placeholder="Password">
                                        <input type="submit" value="Login">
                                    </form>
                                    <p> or <a href="{{ route('account.register') }}">Register</a> </p>
                                @endguest

                                <!-- Nếu người dùng đã đăng nhập, hiển thị các liên kết Account và Wishlist -->
                                @auth
                                    <a href="{{ route("account.profile") }}" class="btn">Account</a>
                                    <a href="/pages/wishlist" class="btn">Wishlist</a>
                                @endauth
                            </div>

                        </div>
                        <div class="header_opations">
                           <nav id="main-nav">
                              <!-- start menu -->
                              <ul>
                                 <li class=" active">
                                    <a href="{{ route("client.home") }}">Home</a>
                                 </li>
                                 <li class=" ">
                                    <a href="pages/collection.html">Collections</a>
                                 </li>
                                 <li class="has-sub ">
                                    <a href="{{ route("client.shop") }}">Shop</a>
                                    <ul>
                                        @if (getCategories()->isNotEmpty())
                                            @foreach (getCategories() as $category)
                                                <li class=" ">
                                                    <a href="{{ route("client.shop", $category->slug) }}">{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <!-- END SECOND LEVEL -->
                                 </li>
                                 <li class=" ">
                                    <a href="pages/blog.html">Blog</a>
                                    <!-- END SECOND LEVEL -->
                                 </li>
                                 <li class="has-sub ">
                                    <a href="#">Pages</a>
                                    <!-- START SECOND LEVEL -->
                                    <ul>
                                       <li class=" ">
                                          <a href="pages/about_us.html"> About Us</a>
                                          <!-- START THIRD LEVEL -->
                                          <!-- END THIRD LEVEL -->
                                       </li>
                                       <li class=" ">
                                          <a href="pages/contact_us.html"> Contact Us</a>
                                          <!-- START THIRD LEVEL -->
                                          <!-- END THIRD LEVEL -->
                                       </li>
                                       <li class=" ">
                                          <a href="/pages/wishlist"> Wishlist</a>
                                          <!-- START THIRD LEVEL -->
                                          <!-- END THIRD LEVEL -->
                                       </li>
                                    </ul>
                                    <!-- END SECOND LEVEL -->
                                 </li>
                              </ul>
                           </nav>
                           @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <!-- /templates/index.liquid -->

         <!-- content start -->
         @yield('content')
         <!-- content end -->

         {{-- <script src="client-asset/js/instafeed.min.js" type="text/javascript"></script>
         <script src="client-asset/js/instagram.js" type="text/javascript"></script> --}}
         {{-- <script src="client-asset/js/parallax.js" type="text/javascript"></script> --}}
         <footer>
            <!-- Footer Start -->
            <div class="container">
               <div class="top_footer">
                  <div class="grid">
                     <div class="grid__item three-twelfths small--one-whole medium--one-half">
                        <div class="column sitemap">
                           <h1>SITEMAP</h1>
                           <ul>
                              <li><a href="/">Home</a></li>
                              <li><a href="/collections/all">Shop</a></li>
                              <li><a href="/collections/mens">Men's Watches</a></li>
                              <li><a href="/collections/womens">Women's Watches</a></li>
                              <li><a href="/blogs/news">Blog</a></li>
                              <li><a href="/pages/contact-us">Contact us</a></li>
                              <li><a href="#">Form Builder</a></li>
                              <li><a href="#">Metafields</a></li>
                              <li><a href="#">Nulled Shopify Themes</a></li>
                              <li><a href="#">Product Options</a></li>
                              <li><a href="#">Recommended content</a></li>
                              <li><a href="#">Careers</a></li>
                              <li><a href="#">Mobile App Builder</a></li>
                              <li><a href="#">Sitemap</a></li>
                           </ul>
                        </div>
                     </div>
                     <div class="grid__item three-twelfths small--one-whole medium--one-half">
                        <div class="column service-column">
                           <h1>Customer Service</h1>
                           <ul>
                              <li> <a href="/pages/orders-and-returns">Orders and Returns</a></li>
                              <li> <a href="/pages/contact-us">Contact Us</a></li>
                              <li> <a href="/pages/help-faqs">Help & FAQs</a></li>
                              <li> <a href="/pages/privecy-policy">Privacy & Policy</a></li>
                           </ul>
                        </div>
                     </div>
                     <div class="grid__item three-twelfths small--one-whole medium--one-whole">
                        <div class="column newsletter">
                           <h1>Join Our Newsletter</h1>
                           <p>Subscribe to our newsletter and stay updated. We don't share your email address with others.</p>
                           <form action="//planetx.us8.list-manage.com/subscribe/post?u=3833ce08f165fe81039e703ff&amp;id=bf7eef9782" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" >
                              <div class="email_field">
                                 <input type="email" value=""  placeholder="Enter email address...." name="EMAIL" id="mail" required>
                              </div>
                              <div class="submit_field">
                                 <button type="submit"  value="Subscribe" name="subscribe" id="subscribe" >SIGN UP
                                 <span><i class="fa fa-angle-right"></i></span>
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="grid__item three-twelfths small--one-whole medium--one-whole">
                        <div class="column social">
                           <h1>STAY CONNECTED</h1>
                           <ul>
                              <ul>
                                 <li><a href="https://www.facebook.com/shopify" target="_blank" title="Facebook"> <span><i class="fa fa-facebook"></i></span></a></li>
                                 <li><a href="https://pinterest.com/shopify" target="_blank" title="Pinterest"><span><i class="fa fa-pinterest-p"></i></span></a></li>
                                 <li><a href="https://www.twitter.com/shopify" target="_blank" title="Twitter"><span><i class="fa fa-twitter"></i></span></a></li>
                                 <li><a href="https://instagram.com/shopify" target="_blank" title="Instagram"><span ><i class="fa fa-instagram"></i></span></a></li>
                              </ul>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <a href="javascript:;" id="scrollToTop">
                  <span><i class="fa fa-angle-up"></i></span>
                  </a>
               </div>
            </div>
            <div class="mini_footer">
               <div class="container">
                  <div class="grid">
                     <div class="grid__item seven-twelfths max-medium--one-half small--one-whole medium--one-whole">
                        <div class="mini_footer_left">
                           <p>©Copyright 2016, All rights reserved by Chicago Theme</p>
                           <p>Designed with <i class="fa fa-heart"></i>  by <a href="https://www.hulkthemes.com/" target="_blank" >Hulk Themes</a> <span>|</span> Powered by <a href="http://www.shopify.in/" target="_blank"> Shopify.</a></p>
                        </div>
                     </div>
                     <div class="grid__item five-twelfths max-medium--one-half small--one-whole medium--one-whole">
                        <div class="payment_method">
                           <ul>
                              <li><img src="{{ asset ("client-asset/img/payment_icons/visa.svg") }}" alt="visa"/> </li>
                              <li><img src="{{ asset ("client-asset/img/payment_icons/master.svg") }}" alt="master"/> </li>
                              <li><img src="{{ asset ("client-asset/img/payment_icons/american_express.svg") }}" alt="american_express"/> </li>
                              <li><img src="{{ asset ("client-asset/img/payment_icons/paypal.svg") }}" alt="paypal"/> </li>
                              <li><img src="{{ asset ("client-asset/img/payment_icons/diners_club.svg") }}" alt="diners_club"/> </li>
                              <li><img src="{{ asset ("client-asset/img/payment_icons/discover.svg") }}" alt="discover"/> </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
      </div>
      <div id="CartDrawer" class="drawer drawer--right">
        <div class="drawer__header">
           <div class="drawer__title h3">Shopping Cart</div>
           <div class="drawer__close js-drawer-close">
              <button type="button" class="icon-fallback-text">
                 <!-- <span class="icon icon-x" aria-hidden="true"></span> -->
                 <span><i style="font-size: 20px;" class="bi bi-x"></i></span>

              </button>
           </div>
        </div>
        <div id="CartContainer">
              <div class="ajaxcart__inner">
                @if ($cartContent->isNotEmpty())
                    @foreach ($cartContent as $item)
                        <div class="ajaxcart__product">
                            <div class="ajaxcart__row" data-line="">
                            <div class="grid">
                                <div class="grid__item one-quarter">
                                    <a href="{{ route("client.product", $item->id) }}" class="ajaxcart__product-image">
                                        <?php
                                            $productImage = $item->options->productImages;
                                        ?>
                                        @if (!empty($productImage->image))
                                            <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                        @else
                                            <img src="{{ asset('admin-asset/img/default-150x150.png') }}"  >
                                        @endif
                                    </a>
                                </div>
                                <div class="grid__item three-quarters">
                                    <p>
                                        <a href="{{ route("client.product", $item->id) }}" class="ajaxcart__product-name">{{ $item->name }}</a>
                                        <span class="ajaxcart__product-meta">{{ $item->options->size }} / {{ $item->options->color }}</span>
                                        <span class="ajaxcart__product-meta">{{ $item->options->brand }}</span>
                                        <span class="ajaxcart__product-meta">${{ $item->price }} x {{ $item->qty }}</span>
                                    </p>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach
                @else

                @endif
                 <div class="ajaxcart__footer">
                    <div class="grid--full">
                       <div class="grid__item one-half">
                          <p class="ajax_subtotal">Order Total</p>
                       </div>
                       <div class="grid__item one-half text-right">
                          <p>${{ $cartSubTotal }}</p>
                       </div>
                    </div>
                    <a href="{{ route("client.checkout") }}" class="btn btn--full cart__checkout" name="checkout">
                    Checkout &rarr;
                    </a>
                    <a href="{{ route("client.cart") }}" class="cart_redirect"> View Cart <span><i class="fa fa-angle-right"></i></span></a>
                 </div>
                </div>
        </div>





      <script id="CartTemplate" type="text/template"></script>
      <script src="{{ asset ("client-asset/js/ajax-cart.js") }}" type="text/javascript"></script>
      <script src="{{ asset ("client-asset/js/ion.rangeSlider.min.js") }}" type="text/javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <!-- AdRoll Pixel setup on 08 Dec 2017 -->
      {{-- <div id="messageBox"></div>
      <div class="loading-modal" data-translate="cart.ajax_cart.loading" style="display: none;">Loading...</div>
      <div class="body_overlay"></div> --}}
      {{-- <script type="text/javascript">
         adroll_adv_id = "TO7KTPCXQZHLBETWL6HGQY";
         adroll_pix_id = "UL3L23DUERDGHMPNHSDKKZ";
         /* OPTIONAL: provide email to improve user identification */
         /* adroll_email = "username@example.com"; */
         (function () {
               var _onload = function(){
                  if (document.readyState && !/loaded|complete/.test(document.readyState)){setTimeout(_onload, 10);return}
                  if (!window.__adroll_loaded){__adroll_loaded=true;setTimeout(_onload, 50);return}
                  var scr = document.createElement("script");
                  var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
                  scr.setAttribute('async', 'true');
                  scr.type = "text/javascript";
                  scr.src = host + "/j/roundtrip.js";
                  ((document.getElementsByTagName('head') || [null])[0] ||
                     document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
               };
               if (window.addEventListener) {window.addEventListener('load', _onload, false);}
               else {window.attachEvent('onload', _onload)}
         }());
      </script> --}}
      <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>


      <!-- End AdRoll Pixel setup on 08 Dec 2017 -->
      @yield('customJs')
      <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
   </body>
</html>
