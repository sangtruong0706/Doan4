(function (a) {
  a.fn.prepareTransition = function () {
    return this.each(function () {
      var b = a(this);
      b.one(
        "TransitionEnd webkitTransitionEnd transitionend oTransitionEnd",
        function () {
          b.removeClass("is-transitioning");
        }
      );
      var c = [
          "transition-duration",
          "-moz-transition-duration",
          "-webkit-transition-duration",
          "-o-transition-duration",
        ],
        d = 0;
      a.each(c, function (a2, c2) {
        d = parseFloat(b.css(c2)) || d;
      }),
        d != 0 && (b.addClass("is-transitioning"), b[0].offsetWidth);
    });
  };
})(jQuery);
function replaceUrlParam(e, r, a) {
  var n = new RegExp("(" + r + "=).*?(&|$)"),
    c = e;
  return (c =
    e.search(n) >= 0
      ? e.replace(n, "$1" + a + "$2")
      : c + (c.indexOf("?") > 0 ? "&" : "?") + r + "=" + a);
}
typeof Shopify == "undefined" && (Shopify = {}),
  Shopify.formatMoney ||
    // (Shopify.formatMoney = function (cents, format) {
    //   var value = "",
    //     placeholderRegex = /\{\{\s*(\w+)\s*\}\}/,
    //     formatString = format || this.money_format;
    //   typeof cents == "string" && (cents = cents.replace(".", ""));
    //   function defaultOption(opt, def) {
    //     return typeof opt == "undefined" ? def : opt;
    //   }
    //   function formatWithDelimiters(number, precision, thousands, decimal) {
    //     if (
    //       ((precision = defaultOption(precision, 2)),
    //       (thousands = defaultOption(thousands, ",")),
    //       (decimal = defaultOption(decimal, ".")),
    //       isNaN(number) || number == null)
    //     )
    //       return 0;
    //     number = (number / 100).toFixed(precision);
    //     var parts = number.split("."),
    //       dollars = parts[0].replace(
    //         /(\d)(?=(\d\d\d)+(?!\d))/g,
    //         "$1" + thousands
    //       ),
    //       cents2 = parts[1] ? decimal + parts[1] : "";
    //     return dollars + cents2;
    //   }
    //   switch (formatString.match(placeholderRegex)[1]) {
    //     case "amount":
    //       value = formatWithDelimiters(cents, 2);
    //       break;
    //     case "amount_no_decimals":
    //       value = formatWithDelimiters(cents, 0);
    //       break;
    //     case "amount_with_comma_separator":
    //       value = formatWithDelimiters(cents, 2, ".", ",");
    //       break;
    //     case "amount_no_decimals_with_comma_separator":
    //       value = formatWithDelimiters(cents, 0, ".", ",");
    //       break;
    //   }
    //   return formatString.replace(placeholderRegex, value);
    // }),
  (window.hulkthemes = window.hulkthemes || {}),
  (hulkthemes.cacheSelectors = function () {
    hulkthemes.cache = {
      $html: $("html"),
      $body: $("body"),
      $productImage: $("#ProductPhotoImg"),
      $thumbImages: $("#ProductThumbs").find("a.product-single__thumbnail"),
      $recoverPasswordLink: $("#RecoverPassword"),
      $hideRecoverPasswordLink: $("#HideRecoverPasswordLink"),
      $recoverPasswordForm: $("#RecoverPasswordForm"),
      $customerLoginForm: $("#CustomerLoginForm"),
      $passwordResetSuccess: $("#ResetSuccess"),
    };
  }),
  (hulkthemes.init = function () {
    FastClick.attach(document.body),
      hulkthemes.cacheSelectors(),
      hulkthemes.drawersInit(),
      hulkthemes.productImageSwitch(),
      hulkthemes.responsiveVideos(),
      hulkthemes.loginForms();
  }),
  (hulkthemes.drawersInit = function () {
    (hulkthemes.LeftDrawer = new hulkthemes.Drawers("NavDrawer", "left")),
      (hulkthemes.RightDrawer = new hulkthemes.Drawers("CartDrawer", "right", {
        onDrawerOpen: ajaxCart.load,
      }));
  }),
  (hulkthemes.getHash = function () {
    return window.location.hash;
  }),
  (hulkthemes.updateHash = function (hash) {
    (window.location.hash = "#" + hash),
      $("#" + hash)
        .attr("tabindex", -1)
        .focus();
  }),
  (hulkthemes.productPage = function (options) {
    var moneyFormat = options.money_format,
      variant = options.variant,
      selector = options.selector,
      $productImage = $("#ProductPhotoImg"),
      $addToCart = $("#AddToCart"),
      $productPrice = $("#ProductPrice"),
      $comparePrice = $("#ComparePrice"),
      $quantityElements = $(".quantity-selector, label + .js-qty"),
      $addToCartText = $("#AddToCartText");
    if (variant) {
      if (variant)
        for (
          var form = jQuery("#" + selector.domIdPrefix).closest("form"),
            i = 0,
            length = variant.options.length;
          i < length;
          i++
        ) {
          var radioButton = form.find(
            '.swatch[data-option-index="' +
              i +
              '"] :radio[value="' +
              variant.options[i] +
              '"]'
          );
          radioButton.size() && (radioButton.get(0).checked = !0);
        }
      if (variant.featured_image) {
        var newImg = variant.featured_image,
          el = $productImage[0];
        Shopify.Image.switchImage(newImg, el, hulkthemes.switchImage);
      }
      variant.available
        ? ($addToCart.removeClass("disabled").prop("disabled", !1),
          $addToCart.html("Add to Cart"),
          $addToCart.val("Add to Cart"),
          $quantityElements.show())
        : ($addToCart.addClass("disabled").prop("disabled", !0),
          $addToCart.html("Sold Out"),
          $addToCart.val("Sold Out"),
          $quantityElements.hide()),
        $productPrice.html(Shopify.formatMoney(variant.price, moneyFormat)),
        variant.compare_at_price > variant.price
          ? $comparePrice
              .html(
                "<del>" +
                  Shopify.formatMoney(variant.compare_at_price, moneyFormat) +
                  "</del>"
              )
              .show()
          : $comparePrice.hide();
    } else
      $addToCart.addClass("disabled").prop("disabled", !0),
        $addToCart.html("Unavailable"),
        $addToCart.val("Unavailable"),
        $quantityElements.hide();
  }),
  (hulkthemes.productImageSwitch = function () {
    hulkthemes.cache.$thumbImages.length &&
      hulkthemes.cache.$thumbImages.on("click", function (evt) {
        evt.preventDefault();
        var newImage = $(this).attr("href");
        hulkthemes.switchImage(newImage, null, hulkthemes.cache.$productImage);
      });
  }),
  (hulkthemes.switchImage = function (src, imgObject, el) {
    var $el = $(el),
      $el = $(el),
      variant_src = src.replace("https:", "");
    $("#bx-pager a img").each(function () {
      var data = $(this).attr("src");
      variant_src == data && $(this).trigger("click");
    });
  }),
  (hulkthemes.responsiveVideos = function () {
    var $iframeVideo = $(
        'iframe[src*="youtube.com/embed"], iframe[src*="player.vimeo"]'
      ),
      $iframeReset = $iframeVideo.add("iframe#admin_bar_iframe");
    $iframeVideo.each(function () {
      $(this).wrap('<div class="video-wrapper"></div>');
    }),
      $iframeReset.each(function () {
        this.src = this.src;
      });
  }),
  (hulkthemes.loginForms = function () {
    function showRecoverPasswordForm() {
      hulkthemes.cache.$recoverPasswordForm.show(),
        hulkthemes.cache.$customerLoginForm.hide();
    }
    function hideRecoverPasswordForm() {
      hulkthemes.cache.$recoverPasswordForm.hide(),
        hulkthemes.cache.$customerLoginForm.show();
    }
    hulkthemes.cache.$recoverPasswordLink.on("click", function (evt) {
      evt.preventDefault(), showRecoverPasswordForm();
    }),
      hulkthemes.cache.$hideRecoverPasswordLink.on("click", function (evt) {
        evt.preventDefault(), hideRecoverPasswordForm();
      }),
      hulkthemes.getHash() == "#recover" && showRecoverPasswordForm();
  }),
  (hulkthemes.resetPasswordSuccess = function () {
    hulkthemes.cache.$passwordResetSuccess.show();
  }),
  (hulkthemes.Drawers = (function () {
    var Drawer = function (id, position, options) {
      var defaults = {
        close: ".js-drawer-close",
        open: ".js-drawer-open-" + position,
        openClass: "js-drawer-open",
        dirOpenClass: "js-drawer-open-" + position,
      };
      if (
        ((this.$nodes = {
          parent: $("body, html"),
          page: $("#PageContainer"),
          moved: $(".is-moved-by-drawer"),
        }),
        (this.config = $.extend(defaults, options)),
        (this.position = position),
        (this.$drawer = $("#" + id)),
        !this.$drawer.length)
      )
        return !1;
      (this.drawerIsOpen = !1), this.init();
    };
    return (
      (Drawer.prototype.init = function () {
        $(this.config.open).on("click", $.proxy(this.open, this)),
          this.$drawer
            .find(this.config.close)
            .on("click", $.proxy(this.close, this));
      }),
      (Drawer.prototype.open = function (evt) {
        var externalCall = !1;
        if (
          (evt ? evt.preventDefault() : (externalCall = !0),
          evt &&
            evt.stopPropagation &&
            (evt.stopPropagation(),
            (this.$activeSource = $(evt.currentTarget))),
          this.drawerIsOpen && !externalCall)
        )
          return this.close();
        this.$nodes.moved.addClass("is-transitioning"),
          this.$drawer.prepareTransition(),
          this.$nodes.parent.addClass(
            this.config.openClass + " " + this.config.dirOpenClass
          ),
          (this.drawerIsOpen = !0),
          this.trapFocus(this.$drawer, "drawer_focus"),
          this.config.onDrawerOpen &&
            typeof this.config.onDrawerOpen == "function" &&
            (externalCall || this.config.onDrawerOpen()),
          this.$activeSource &&
            this.$activeSource.attr("aria-expanded") &&
            this.$activeSource.attr("aria-expanded", "true"),
          this.$nodes.page.on("touchmove.drawer", function () {
            return !1;
          }),
          this.$nodes.page.on(
            "click.drawer",
            $.proxy(function () {
              return this.close(), !1;
            }, this)
          );
      }),
      (Drawer.prototype.close = function () {
        this.drawerIsOpen &&
          ($(document.activeElement).trigger("blur"),
          this.$nodes.moved.prepareTransition({ disableExisting: !0 }),
          this.$drawer.prepareTransition({ disableExisting: !0 }),
          this.$nodes.parent.removeClass(
            this.config.dirOpenClass + " " + this.config.openClass
          ),
          (this.drawerIsOpen = !1),
          this.removeTrapFocus(this.$drawer, "drawer_focus"),
          this.$nodes.page.off(".drawer"));
      }),
      (Drawer.prototype.trapFocus = function ($container, eventNamespace) {
        var eventName = eventNamespace
          ? "focusin." + eventNamespace
          : "focusin";
        $container.attr("tabindex", "-1"),
          $container.focus(),
          $(document).on(eventName, function (evt) {
            $container[0] !== evt.target &&
              !$container.has(evt.target).length &&
              $container.focus();
          });
      }),
      (Drawer.prototype.removeTrapFocus = function (
        $container,
        eventNamespace
      ) {
        var eventName = eventNamespace
          ? "focusin." + eventNamespace
          : "focusin";
        $container.removeAttr("tabindex"), $(document).off(eventName);
      }),
      Drawer
    );
  })()),
  $(hulkthemes.init);
//# sourceMappingURL=/cdn/shop/t/3/assets/hulkthemes.js.map?v=11679377744935043281526642396
