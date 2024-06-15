(function ($2) {
  $2(document).ready(function () {
    chicago.init(),
      $2(".sidebar_item ul li").click(function (e) {
        $2(this).addClass("active"), $2(this).siblings().removeClass("active");
      });
  });
  var chicago = {
    chicagoTimeout: null,
    isSidebarAjaxClick: !1,
    init: function () {
      this.slider(),
        this.header(),
        this.resizeContent(),
        this.quantity(),
        this.wishlist(),
        this.headerHeight(),
        this.grid_height(),
        this.sorting(),
        this.search();
    },
    mob_img: function () {
      var theme_name = $2("body").data("shop");
      $2(".mob_logo").html("<h2>" + theme_name + "</h2>");
    },
    // search: function () {
    //   var product_detail = $2(".search_section .product_item").html();
    //   product_detail || $2(".search_section #collection").hide();
    //   var blog_detail = $2(".search_section .blog_item").html();
    //   blog_detail || $2(".search_section #blog").hide();
    //   var page_detail = $2(".search_section #page .content").html();
    //   page_detail || $2(".search_section #page").hide();
    // },
    grid_height: function () {
      $2(".grid__item .product_image").responsiveEqualHeightGrid();
    },
    slider: function () {
      $2("#slider_show").bxSlider({
        mode: "fade",
        captions: !0,
        controls: !($2("#slider_show").children().length < 2),
        pager: !1,
        auto: !1,
        speed: 1 * 1e3,
      }),
        $2(".product_slider").bxSlider({
          pagerCustom: "#bx-pager",
          mode: "fade",
          controls: !1,
        }),
        $2("#bx-pager").bxSlider({
          mode: "vertical",
          pager: !1,
          controls: !0,
          minSlides: 4,
          maxSlides: 4,
          slideWidth: 165,
          slideMargin: 12,
          nextText: '<i class="fa fa-angle-down"></i>',
          prevText: '<i class="fa fa-angle-up"></i>',
          infiniteLoop: !1,
        }),
        $2(window).width() <= 480 &&
          $2(".product_slider").bxSlider({
            pagerCustom: "",
            mode: "fade",
            controls: !0,
            pager: !1,
          });
    },
    header: function () {
      $2(window).resize(function () {
        chicago.resizeContent();
      }),
        chicago.sticky_nav(),
        $2("header nav").meanmenu();
      var didScroll,
        lastScrollTop = 0,
        delta = 5,
        navbarHeight = $2("header").outerHeight();
      $2(window).scroll(function (event) {
        didScroll = !0;
      }),
        setInterval(function () {
          didScroll && (hasScrolled(), (didScroll = !1));
        }, 250),
        hasScrolled();
      function hasScrolled() {
        var st = $2(this).scrollTop();
        Math.abs(lastScrollTop - st) <= delta ||
          ($2(window).width() <= 767 &&
            (st > lastScrollTop && st > navbarHeight
              ? $2(".mean-bar").removeClass("nav-down").addClass("nav-up")
              : st + $2(window).height() < $2(document).height() &&
                (st == 0
                  ? $2(".mean-bar")
                      .removeClass("nav-up")
                      .removeClass("nav-down")
                  : $2(".mean-bar").removeClass("nav-up").addClass("nav-down")),
            (lastScrollTop = st)));
      }
      $2(".btn_icon").click(function (e) {
        $2(".header_right_icon .active").removeClass("active"),
          $2(".right_header").removeClass("active-icons"),
          $2(".header_right_icon .close_btn").css("display", "none"),
          $2(".header_right_icon .btn_icon").css("display", "block"),
          $2(this).css("display", "none"),
          $2(this).next().css("display", "block");
        var get_class = $2(this).attr("id");
        $2("div." + get_class).addClass("active"),
          $2(".right_header").addClass("active-icons");
      }),
        $2(".close_btn").click(function (e) {
          $2(this).css("display", "none"),
            $2(this).prev().css("display", "block"),
            $2(".header_right_icon .active").removeClass("active"),
            $2(".right_header").removeClass("active-icons");
        });
    },
    headerHeight: function () {
      $2(".header_height").css("height", $2("header").outerHeight());
    },
    sticky_nav: function () {
      var fixed_menu = !0;
      window.jQuery = window.$ = jQuery;
      var w_width = $2(window).width();
      if ($2("header").size() && fixed_menu == !0 && w_width > 1024)
        var fixd_menu = setInterval(scrolled_menu, 100);
      function scrolled_menu() {
        $2(window).scrollTop() > jQuery("header").height() + 250
          ? ($2("header").addClass("second_nav"),
            $2("header .container").show())
          : $2("header").removeClass("second_nav");
      }
    },
    showLoading: function () {
      $2(".loading-modal").show();
    },
    hideLoading: function () {
      $2(".loading-modal").hide();
    },
    sorting: function () {
      icon_dropdown();
      function icon_dropdown() {
        var shop_dropdown = $2(".dropdown-sort");
        $2("#sorting_title").click(function (e) {
          e.preventDefault(),
            $2(".sorting_item .dropdown-sort").slideToggle(1),
            $2(".sorting_item .dropdown-sort").click(function (ev) {
              ev.stopPropagation();
            }),
            e.stopPropagation();
        }),
          $2(document).click(function (e) {
            shop_dropdown.slideUp(1);
          });
      }
    },
    resizeContent: function () {
      var height_screen = $2(window).height();
      if (
        ($2(".hero-slider ul li").height(height_screen),
        $2(window).width() > 767)
      ) {
        var slide_height = $2(window).height();
        $2(".blank_height").css("height", slide_height);
      }
      $2("#tabs").tabs(),
        $2(window).width() <= 676 &&
          ($2(".shop_filter").css(
            "height",
            $2(window).height() - $2(".mean-bar").outerHeight()
          ),
          $2(".filter_toggle h4").click(function (e) {
            $2(".shop_filter").addClass("active_sidebar"),
              $2("body").css("overflow", "hidden");
          }),
          $2(".filter_close").click(function (e) {
            $2(".shop_filter").removeClass("active_sidebar"),
              $2("body").css("overflow", "auto");
          }));
    },
    quantity: function () {
      $2(".plus").click(function () {
        (getval = $2(this).parent().find(".product-quantity").val()),
          getval++,
          $2(this).parent().find(".product-quantity").val(getval),
          $2("#update-cart").trigger("click");
      }),
        $2(".minus").click(function () {
          var getval2 = $2(this).parent().find(".product-quantity").val();
          getval2 > 1
            ? (getval2--,
              $2(this).parent().find(".product-quantity").val(getval2))
            : $2(this).parent().find(".product-quantity").val(getval2),
            $2("#update-cart").trigger("click");
        });
    },
    wishlist: function () {
      $2("#wish-item .product-item").length == 0
        ? ($2("#share_via_mail").hide(),
          $2("#wishlist-header").hide(),
          $2(".empty_wishlist").show())
        : $2(".empty_wishlist").hide();
    },
  };
})(jQuery),
  $(document).ready(function () {
    var window_width = $(window).width();
    if (window_width > 1024) {
      var mainProductImage = $(".product_slider li img");
      if (mainProductImage.size()) {
        var zoomedSrc = mainProductImage
          .attr("src")
          .replace("_1024x1024.", ".");
        mainProductImage
          .wrap('<span style="display:inline-block;max-width:100%"></span>')
          .css("display", "block")
          .parent()
          .zoom({ url: zoomedSrc });
      }
    }
    $(window).load(function () {
      $(".product_slider li")
        .not($(".product_slider li:first"))
        .each(function (index, element) {
          var get_img_src = $("span img:first", this).attr("src");
          $("span img:last", this).attr("src", get_img_src);
        });
    });
  });
//# sourceMappingURL=/cdn/shop/t/3/assets/chicago.js.map?v=148012118288221614971511774182
