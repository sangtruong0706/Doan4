(function ($) {
  $.fn.meanmenu = function (options) {
    var defaults = {
        meanMenuTarget: jQuery(this),
        meanMenuClose: "<span /><span /><span />",
        meanMenuCloseSize: "18px",
        meanMenuOpen: "<span /><span /><span />",
        meanRevealPosition: "right",
        meanRevealPositionDistance: "0",
        meanRevealColour: "",
        meanRevealHoverColour: "",
        meanScreenWidth: "1024",
        meanNavPush: "",
        meanShowChildren: !0,
        meanExpandableChildren: !0,
        meanExpand: "<i class='fa fa-angle-down'></i>",
        meanContract: "<i class='fa fa-angle-up'></i>",
        meanRemoveAttrs: !1,
      },
      options = $.extend(defaults, options);
    return (
      (currentWidth =
        window.innerWidth || document.documentElement.clientWidth),
      this.each(function () {
        var meanMenu = options.meanMenuTarget,
          meanReveal = options.meanReveal,
          meanMenuClose = options.meanMenuClose,
          meanMenuCloseSize = options.meanMenuCloseSize,
          meanMenuOpen = options.meanMenuOpen,
          meanRevealPosition = options.meanRevealPosition,
          meanRevealPositionDistance = options.meanRevealPositionDistance,
          meanRevealColour = options.meanRevealColour,
          meanRevealHoverColour = options.meanRevealHoverColour,
          meanScreenWidth = options.meanScreenWidth,
          meanNavPush = options.meanNavPush,
          meanRevealClass = ".meanmenu-reveal";
        (meanShowChildren = options.meanShowChildren),
          (meanExpandableChildren = options.meanExpandableChildren);
        var meanExpand = options.meanExpand,
          meanContract = options.meanContract,
          meanRemoveAttrs = options.meanRemoveAttrs;
        if (
          navigator.userAgent.match(/iPhone/i) ||
          navigator.userAgent.match(/iPod/i) ||
          navigator.userAgent.match(/iPad/i) ||
          navigator.userAgent.match(/Android/i) ||
          navigator.userAgent.match(/Blackberry/i) ||
          navigator.userAgent.match(/Windows Phone/i)
        )
          var isMobile = !0;
        (navigator.userAgent.match(/MSIE 8/i) ||
          navigator.userAgent.match(/MSIE 7/i)) &&
          jQuery("html").css("overflow-y", "scroll");
        function meanCentered() {
          if (meanRevealPosition == "center") {
            var newWidth =
                window.innerWidth || document.documentElement.clientWidth,
              meanCenter = newWidth / 2 - 22 + "px";
            (meanRevealPos = "left:" + meanCenter + ";right:auto;"),
              isMobile
                ? jQuery(".meanmenu-reveal").animate({ left: meanCenter })
                : jQuery(".meanmenu-reveal").css("left", meanCenter);
          }
        }
        (menuOn = !1),
          (meanMenuExist = !1),
          meanRevealPosition == "right" &&
            (meanRevealPos =
              "right:" + meanRevealPositionDistance + ";left:auto;"),
          meanRevealPosition == "left" &&
            (meanRevealPos =
              "left:" + meanRevealPositionDistance + ";right:auto;"),
          meanCentered(),
          (meanStyles =
            "background:" +
            meanRevealColour +
            ";color:" +
            meanRevealColour +
            ";" +
            meanRevealPos);
        function meanInner() {
          jQuery($navreveal).is(".meanmenu-reveal.meanclose")
            ? $navreveal.html(meanMenuClose)
            : $navreveal.html(meanMenuOpen);
        }
        function meanOriginal() {
          jQuery(".mean-bar,.mean-push").remove(),
            jQuery("body").removeClass("mean-container"),
            jQuery(meanMenu).show(),
            (menuOn = !1),
            (meanMenuExist = !1);
        }
        function showMeanMenu() {
          if (currentWidth <= meanScreenWidth) {
            (meanMenuExist = !0),
              jQuery("body").addClass("mean-container"),
              jQuery(".mean-container").prepend(
                '<div class="mean-bar"><div class="container"><a href="/" class="mob_logo"><img src="//chicago-theme.myshopify.com/cdn/shop/files/logo_168x_f2d044d6-182c-486e-ae35-d47b5ae32df0_large.png?v=1487851519" /></a><a href="#nav" class="meanmenu-reveal" style="' +
                  meanStyles +
                  '">Show Navigation</a><nav class="mean-nav"></nav></div></div>'
              );
            var meanMenuContents = jQuery(meanMenu).html();
            jQuery(".mean-nav").html(meanMenuContents),
              meanRemoveAttrs &&
                jQuery("nav.mean-nav *").each(function () {
                  jQuery(this).removeAttr("class"),
                    jQuery(this).removeAttr("id");
                }),
              jQuery(meanMenu).before('<div class="mean-push" />'),
              jQuery(".mean-push").css("margin-top", meanNavPush),
              jQuery(meanMenu).hide(),
              jQuery(".meanmenu-reveal").show(),
              jQuery(meanRevealClass).html(meanMenuOpen),
              ($navreveal = jQuery(meanRevealClass)),
              jQuery(".mean-nav ul").hide(),
              meanShowChildren
                ? meanExpandableChildren
                  ? (jQuery(".mean-nav ul ul").each(function () {
                      jQuery(this).children().length &&
                        jQuery(this, "li:first")
                          .parent()
                          .append(
                            '<a class="mean-expand" href="#" style="font-size: ' +
                              meanMenuCloseSize +
                              '">' +
                              meanExpand +
                              "</a>"
                          );
                    }),
                    jQuery(".mean-expand").on("click", function (e) {
                      e.preventDefault(),
                        jQuery(this).hasClass("mean-clicked")
                          ? (jQuery(this).html(meanExpand),
                            console.log("Been clicked"),
                            jQuery(this)
                              .prev("ul")
                              .slideUp(300, function () {}))
                          : (jQuery(this).html(meanContract),
                            jQuery(this)
                              .prev("ul")
                              .slideDown(300, function () {})),
                        jQuery(this).toggleClass("mean-clicked");
                    }))
                  : jQuery(".mean-nav ul ul").show()
                : jQuery(".mean-nav ul ul").hide(),
              jQuery(".mean-nav ul li").last().addClass("mean-last"),
              $navreveal.removeClass("meanclose"),
              jQuery($navreveal).click(function (e) {
                e.preventDefault(),
                  menuOn == !1
                    ? ($navreveal.css("text-align", "center"),
                      $navreveal.css("text-indent", "0"),
                      $navreveal.css("font-size", meanMenuCloseSize),
                      jQuery(".mean-nav ul:first").slideDown(),
                      (menuOn = !0))
                    : (jQuery(".mean-nav ul:first").slideUp(), (menuOn = !1)),
                  $navreveal.toggleClass("meanclose"),
                  meanInner();
              });
          } else meanOriginal();
        }
        isMobile ||
          jQuery(window).resize(function () {
            (currentWidth =
              window.innerWidth || document.documentElement.clientWidth),
              currentWidth > meanScreenWidth,
              meanOriginal(),
              currentWidth <= meanScreenWidth
                ? (showMeanMenu(), meanCentered())
                : meanOriginal();
          }),
          (window.onorientationchange = function () {
            meanCentered(),
              (currentWidth =
                window.innerWidth || document.documentElement.clientWidth),
              currentWidth >= meanScreenWidth && meanOriginal(),
              currentWidth <= meanScreenWidth &&
                meanMenuExist == !1 &&
                showMeanMenu();
          }),
          showMeanMenu();
      })
    );
  };
})(jQuery);
//# sourceMappingURL=/cdn/shop/t/3/assets/jquery.meanmenu.js.map?v=103147856434142879641712667563
