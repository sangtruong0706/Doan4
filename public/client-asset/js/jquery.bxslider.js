!(function (a) {
  var b = {},
    c = {
      mode: "horizontal",
      slideSelector: "",
      infiniteLoop: !0,
      hideControlOnEnd: !1,
      speed: 500,
      easing: null,
      slideMargin: 0,
      startSlide: 0,
      randomStart: !1,
      captions: !1,
      ticker: !1,
      tickerHover: !1,
      adaptiveHeight: !1,
      adaptiveHeightSpeed: 500,
      video: !1,
      useCSS: !0,
      preloadImages: "visible",
      touchEnabled: !0,
      swipeThreshold: 50,
      oneToOneTouch: !0,
      preventDefaultSwipeX: !0,
      preventDefaultSwipeY: !1,
      pager: !0,
      pagerType: "full",
      pagerShortSeparator: " / ",
      pagerSelector: null,
      buildPager: null,
      pagerCustom: null,
      controls: !0,
      nextText: "Next",
      prevText: "Prev",
      nextSelector: null,
      prevSelector: null,
      autoControls: !1,
      startText: "Start",
      stopText: "Stop",
      autoControlsCombine: !1,
      autoControlsSelector: null,
      auto: !1,
      pause: 4e3,
      autoStart: !0,
      autoDirection: "next",
      autoHover: !1,
      autoDelay: 0,
      minSlides: 1,
      maxSlides: 1,
      moveSlides: 0,
      slideWidth: 0,
      onSliderLoad: function () {
        a(".product_slider > li").eq(0).addClass("active");
      },
      onSlideBefore: function () {},
      onSlideAfter: function (b, c, d) {
        a(".active").removeClass("active"),
          a(".product_slider > li").eq(d).addClass("active");
      },
      onSlideNext: function () {},
      onSlidePrev: function () {},
    };
  a.fn.bxSlider = function (d) {
    if (0 == this.length) return this;
    if (this.length > 1)
      return (
        this.each(function () {
          a(this).bxSlider(d);
        }),
        this
      );
    var e = {},
      f = this;
    b.el = this;
    var g = a(window).width(),
      h = a(window).height(),
      j = function () {
        (e.settings = a.extend({}, c, d)),
          (e.settings.slideWidth = parseInt(e.settings.slideWidth)),
          (e.children = f.children(e.settings.slideSelector)),
          e.children.length < e.settings.minSlides &&
            (e.settings.minSlides = e.children.length),
          e.children.length < e.settings.maxSlides &&
            (e.settings.maxSlides = e.children.length),
          e.settings.randomStart &&
            (e.settings.startSlide = Math.floor(
              Math.random() * e.children.length
            )),
          (e.active = { index: e.settings.startSlide }),
          (e.carousel = e.settings.minSlides > 1 || e.settings.maxSlides > 1),
          e.carousel && (e.settings.preloadImages = "all"),
          (e.minThreshold =
            e.settings.minSlides * e.settings.slideWidth +
            (e.settings.minSlides - 1) * e.settings.slideMargin),
          (e.maxThreshold =
            e.settings.maxSlides * e.settings.slideWidth +
            (e.settings.maxSlides - 1) * e.settings.slideMargin),
          (e.working = !1),
          (e.controls = {}),
          (e.interval = null),
          (e.animProp = "vertical" == e.settings.mode ? "top" : "left"),
          (e.usingCSS =
            e.settings.useCSS &&
            "fade" != e.settings.mode &&
            (function () {
              var a = document.createElement("div"),
                b = [
                  "WebkitPerspective",
                  "MozPerspective",
                  "OPerspective",
                  "msPerspective",
                ];
              for (var c in b)
                if (void 0 !== a.style[b[c]])
                  return (
                    (e.cssPrefix = b[c]
                      .replace("Perspective", "")
                      .toLowerCase()),
                    (e.animProp = "-" + e.cssPrefix + "-transform"),
                    !0
                  );
              return !1;
            })()),
          "vertical" == e.settings.mode &&
            (e.settings.maxSlides = e.settings.minSlides),
          k();
      },
      k = function () {
        f.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'),
          (e.viewport = f.parent()),
          (e.loader = a('<div class="bx-loading" />')),
          e.viewport.prepend(e.loader),
          f.css({
            width:
              "horizontal" == e.settings.mode
                ? 215 * e.children.length + "%"
                : "auto",
            position: "relative",
          }),
          e.usingCSS && e.settings.easing
            ? f.css(
                "-" + e.cssPrefix + "-transition-timing-function",
                e.settings.easing
              )
            : e.settings.easing || (e.settings.easing = "swing");
        p();
        if (
          (e.viewport.css({
            width: "100%",
            overflow: "hidden",
            position: "relative",
          }),
          e.viewport.parent().css({ maxWidth: n() }),
          e.children.css({
            float: "horizontal" == e.settings.mode ? "left" : "none",
            listStyle: "none",
            position: "relative",
          }),
          e.children.width(o()),
          "horizontal" == e.settings.mode &&
            e.settings.slideMargin > 0 &&
            e.children.css("marginRight", e.settings.slideMargin),
          "vertical" == e.settings.mode &&
            e.settings.slideMargin > 0 &&
            e.children.css("marginBottom", e.settings.slideMargin),
          "fade" == e.settings.mode &&
            (e.children.css({
              position: "absolute",
              zIndex: 0,
              display: "none",
            }),
            e.children
              .eq(e.settings.startSlide)
              .css({ zIndex: 50, display: "block" })),
          (e.controls.el = a('<div class="bx-controls" />')),
          e.settings.captions && y(),
          e.settings.infiniteLoop &&
            "fade" != e.settings.mode &&
            !e.settings.ticker)
        ) {
          var c =
              "vertical" == e.settings.mode
                ? e.settings.minSlides
                : e.settings.maxSlides,
            d = e.children.slice(0, c).clone().addClass("bx-clone"),
            g = e.children.slice(-c).clone().addClass("bx-clone");
          f.append(d).prepend(g);
        }
        (e.active.last = e.settings.startSlide == q() - 1),
          e.settings.video && f.fitVids();
        var h = e.children.eq(e.settings.startSlide);
        "all" == e.settings.preloadImages && (h = f.children()),
          e.settings.ticker
            ? (e.settings.pager = !1)
            : (e.settings.pager && v(),
              e.settings.controls && w(),
              e.settings.auto && e.settings.autoControls && x(),
              (e.settings.controls ||
                e.settings.autoControls ||
                e.settings.pager) &&
                e.viewport.after(e.controls.el)),
          h.imagesLoaded(l);
      },
      l = function () {
        e.loader.remove(),
          s(),
          "vertical" == e.settings.mode && (e.settings.adaptiveHeight = !0),
          e.viewport.height(m()),
          f.redrawSlider(),
          e.settings.onSliderLoad(e.active.index),
          (e.initialized = !0),
          a(window).bind("resize", P),
          e.settings.auto && e.settings.autoStart && I(),
          e.settings.ticker && J(),
          e.settings.pager && E(e.settings.startSlide),
          e.settings.controls && H(),
          e.settings.touchEnabled && !e.settings.ticker && L();
      },
      m = function () {
        var b = 0,
          c = a();
        if ("vertical" == e.settings.mode || e.settings.adaptiveHeight)
          if (e.carousel) {
            var d =
              1 == e.settings.moveSlides
                ? e.active.index
                : e.active.index * r();
            for (
              c = e.children.eq(d), i = 1;
              i <= e.settings.maxSlides - 1;
              i++
            )
              c =
                d + i >= e.children.length
                  ? c.add(e.children.eq(i - 1))
                  : c.add(e.children.eq(d + i));
          } else c = e.children.eq(e.active.index);
        else c = e.children;
        return (
          "vertical" == e.settings.mode
            ? (c.each(function (c) {
                b += a(this).outerHeight();
              }),
              e.settings.slideMargin > 0 &&
                (b += e.settings.slideMargin * (e.settings.minSlides - 1)))
            : (b = Math.max.apply(
                Math,
                c
                  .map(function () {
                    return a(this).outerHeight(!1);
                  })
                  .get()
              )),
          b
        );
      },
      n = function () {
        var a = "100%";
        return (
          e.settings.slideWidth > 0 &&
            (a =
              "horizontal" == e.settings.mode
                ? e.settings.maxSlides * e.settings.slideWidth +
                  (e.settings.maxSlides - 1) * e.settings.slideMargin
                : e.settings.slideWidth),
          a
        );
      },
      o = function () {
        var a = e.settings.slideWidth,
          b = e.viewport.width();
        return (
          0 == e.settings.slideWidth ||
          (e.settings.slideWidth > b && !e.carousel) ||
          "vertical" == e.settings.mode
            ? (a = b)
            : e.settings.maxSlides > 1 &&
              "horizontal" == e.settings.mode &&
              (b > e.maxThreshold ||
                (b < e.minThreshold &&
                  (a =
                    (b - e.settings.slideMargin * (e.settings.minSlides - 1)) /
                    e.settings.minSlides))),
          a
        );
      },
      p = function () {
        var a = 1;
        if ("horizontal" == e.settings.mode && e.settings.slideWidth > 0)
          if (e.viewport.width() < e.minThreshold) a = e.settings.minSlides;
          else if (e.viewport.width() > e.maxThreshold)
            a = e.settings.maxSlides;
          else {
            var b = e.children.first().width();
            a = Math.floor(e.viewport.width() / b);
          }
        else "vertical" == e.settings.mode && (a = e.settings.minSlides);
        return a;
      },
      q = function () {
        var a = 0;
        if (e.settings.moveSlides > 0)
          if (e.settings.infiniteLoop) a = e.children.length / r();
          else
            for (var b = 0, c = 0; b < e.children.length; )
              ++a,
                (b = c + p()),
                (c +=
                  e.settings.moveSlides <= p() ? e.settings.moveSlides : p());
        else a = Math.ceil(e.children.length / p());
        return a;
      },
      r = function () {
        return e.settings.moveSlides > 0 && e.settings.moveSlides <= p()
          ? e.settings.moveSlides
          : p();
      },
      s = function () {
        if (
          e.children.length > e.settings.maxSlides &&
          e.active.last &&
          !e.settings.infiniteLoop
        ) {
          if ("horizontal" == e.settings.mode) {
            var a = e.children.last(),
              b = a.position();
            t(-(b.left - (e.viewport.width() - a.width())), "reset", 0);
          } else if ("vertical" == e.settings.mode) {
            var c = e.children.length - e.settings.minSlides,
              b = e.children.eq(c).position();
            t(-b.top, "reset", 0);
          }
        } else {
          var b = e.children.eq(e.active.index * r()).position();
          e.active.index == q() - 1 && (e.active.last = !0),
            void 0 != b &&
              ("horizontal" == e.settings.mode
                ? t(-b.left, "reset", 0)
                : "vertical" == e.settings.mode && t(-b.top, "reset", 0));
        }
      },
      t = function (a, b, c, d) {
        if (e.usingCSS) {
          var g =
            "vertical" == e.settings.mode
              ? "translate3d(0, " + a + "px, 0)"
              : "translate3d(" + a + "px, 0, 0)";
          f.css("-" + e.cssPrefix + "-transition-duration", c / 1e3 + "s"),
            "slide" == b
              ? (f.css(e.animProp, g),
                f.bind(
                  "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",
                  function () {
                    f.unbind(
                      "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"
                    ),
                      F();
                  }
                ))
              : "reset" == b
              ? f.css(e.animProp, g)
              : "ticker" == b &&
                (f.css(
                  "-" + e.cssPrefix + "-transition-timing-function",
                  "linear"
                ),
                f.css(e.animProp, g),
                f.bind(
                  "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",
                  function () {
                    f.unbind(
                      "transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"
                    ),
                      t(d.resetValue, "reset", 0),
                      K();
                  }
                ));
        } else {
          var h = {};
          (h[e.animProp] = a),
            "slide" == b
              ? f.animate(h, c, e.settings.easing, function () {
                  F();
                })
              : "reset" == b
              ? f.css(e.animProp, a)
              : "ticker" == b &&
                f.animate(h, speed, "linear", function () {
                  t(d.resetValue, "reset", 0), K();
                });
        }
      },
      u = function () {
        for (var b = "", c = q(), d = 0; d < c; d++) {
          var f = "";
          e.settings.buildPager && a.isFunction(e.settings.buildPager)
            ? ((f = e.settings.buildPager(d)),
              e.pagerEl.addClass("bx-custom-pager"))
            : ((f = d + 1), e.pagerEl.addClass("bx-default-pager")),
            (b +=
              '<div class="bx-pager-item"><a href="" data-slide-index="' +
              d +
              '" class="bx-pager-link">' +
              f +
              "</a></div>");
        }
        e.pagerEl.html(b);
      },
      v = function () {
        e.settings.pagerCustom
          ? (e.pagerEl = a(e.settings.pagerCustom))
          : ((e.pagerEl = a('<div class="bx-pager" />')),
            e.settings.pagerSelector
              ? a(e.settings.pagerSelector).html(e.pagerEl)
              : e.controls.el.addClass("bx-has-pager").append(e.pagerEl),
            u()),
          e.pagerEl.delegate("a", "click", D);
      },
      w = function () {
        (e.controls.next = a(
          '<a class="bx-next" href="">' + e.settings.nextText + "</a>"
        )),
          (e.controls.prev = a(
            '<a class="bx-prev" href="">' + e.settings.prevText + "</a>"
          )),
          e.controls.next.bind("click", z),
          e.controls.prev.bind("click", A),
          e.settings.nextSelector &&
            a(e.settings.nextSelector).append(e.controls.next),
          e.settings.prevSelector &&
            a(e.settings.prevSelector).append(e.controls.prev),
          e.settings.nextSelector ||
            e.settings.prevSelector ||
            ((e.controls.directionEl = a(
              '<div class="bx-controls-direction" />'
            )),
            e.controls.directionEl
              .append(e.controls.prev)
              .append(e.controls.next),
            e.controls.el
              .addClass("bx-has-controls-direction")
              .append(e.controls.directionEl));
      },
      x = function () {
        (e.controls.start = a(
          '<div class="bx-controls-auto-item"><a class="bx-start" href="">' +
            e.settings.startText +
            "</a></div>"
        )),
          (e.controls.stop = a(
            '<div class="bx-controls-auto-item"><a class="bx-stop" href="">' +
              e.settings.stopText +
              "</a></div>"
          )),
          (e.controls.autoEl = a('<div class="bx-controls-auto" />')),
          e.controls.autoEl.delegate(".bx-start", "click", B),
          e.controls.autoEl.delegate(".bx-stop", "click", C),
          e.settings.autoControlsCombine
            ? e.controls.autoEl.append(e.controls.start)
            : e.controls.autoEl
                .append(e.controls.start)
                .append(e.controls.stop),
          e.settings.autoControlsSelector
            ? a(e.settings.autoControlsSelector).html(e.controls.autoEl)
            : e.controls.el
                .addClass("bx-has-controls-auto")
                .append(e.controls.autoEl),
          G(e.settings.autoStart ? "stop" : "start");
      },
      y = function () {
        e.children.each(function (b) {
          var c = a(this).find("img:first").attr("title");
          void 0 != c &&
            a(this).append(
              '<div class="bx-caption"><span>' + c + "</span></div>"
            );
        });
      },
      z = function (a) {
        e.settings.auto && f.stopAuto(), f.goToNextSlide(), a.preventDefault();
      },
      A = function (a) {
        e.settings.auto && f.stopAuto(), f.goToPrevSlide(), a.preventDefault();
      },
      B = function (a) {
        f.startAuto(), a.preventDefault();
      },
      C = function (a) {
        f.stopAuto(), a.preventDefault();
      },
      D = function (b) {
        e.settings.auto && f.stopAuto();
        var c = a(b.currentTarget),
          d = parseInt(c.attr("data-slide-index"));
        d != e.active.index && f.goToSlide(d), b.preventDefault();
      },
      E = function (b) {
        return "short" == e.settings.pagerType
          ? void e.pagerEl.html(
              b + 1 + e.settings.pagerShortSeparator + e.children.length
            )
          : (e.pagerEl.find("a").removeClass("active"),
            void e.pagerEl.each(function (c, d) {
              a(d).find("a").eq(b).addClass("active");
            }));
      },
      F = function () {
        if (e.settings.infiniteLoop) {
          var a = "";
          0 == e.active.index
            ? (a = e.children.eq(0).position())
            : e.active.index == q() - 1 && e.carousel
            ? (a = e.children.eq((q() - 1) * r()).position())
            : e.active.index == e.children.length - 1 &&
              (a = e.children.eq(e.children.length - 1).position()),
            "horizontal" == e.settings.mode
              ? t(-a.left, "reset", 0)
              : "vertical" == e.settings.mode && t(-a.top, "reset", 0);
        }
        (e.working = !1),
          e.settings.onSlideAfter(
            e.children.eq(e.active.index),
            e.oldIndex,
            e.active.index
          );
      },
      G = function (a) {
        e.settings.autoControlsCombine
          ? e.controls.autoEl.html(e.controls[a])
          : (e.controls.autoEl.find("a").removeClass("active"),
            e.controls.autoEl.find("a:not(.bx-" + a + ")").addClass("active"));
      },
      H = function () {
        1 == q()
          ? (e.controls.prev.addClass("disabled"),
            e.controls.next.addClass("disabled"))
          : !e.settings.infiniteLoop &&
            e.settings.hideControlOnEnd &&
            (0 == e.active.index
              ? (e.controls.prev.addClass("disabled"),
                e.controls.next.removeClass("disabled"))
              : e.active.index == q() - 1
              ? (e.controls.next.addClass("disabled"),
                e.controls.prev.removeClass("disabled"))
              : (e.controls.prev.removeClass("disabled"),
                e.controls.next.removeClass("disabled")));
      },
      I = function () {
        if (e.settings.autoDelay > 0) {
          setTimeout(f.startAuto, e.settings.autoDelay);
        } else f.startAuto();
        e.settings.autoHover &&
          f.hover(
            function () {
              e.interval && (f.stopAuto(!0), (e.autoPaused = !0));
            },
            function () {
              e.autoPaused && (f.startAuto(!0), (e.autoPaused = null));
            }
          );
      },
      J = function () {
        var b = 0;
        if ("next" == e.settings.autoDirection)
          f.append(e.children.clone().addClass("bx-clone"));
        else {
          f.prepend(e.children.clone().addClass("bx-clone"));
          var c = e.children.first().position();
          b = "horizontal" == e.settings.mode ? -c.left : -c.top;
        }
        t(b, "reset", 0),
          (e.settings.pager = !1),
          (e.settings.controls = !1),
          (e.settings.autoControls = !1),
          e.settings.tickerHover &&
            !e.usingCSS &&
            e.viewport.hover(
              function () {
                f.stop();
              },
              function () {
                var b = 0;
                e.children.each(function (c) {
                  b +=
                    "horizontal" == e.settings.mode
                      ? a(this).outerWidth(!0)
                      : a(this).outerHeight(!0);
                });
                var c = e.settings.speed / b,
                  d = "horizontal" == e.settings.mode ? "left" : "top",
                  g = c * (b - Math.abs(parseInt(f.css(d))));
                K(g);
              }
            ),
          K();
      },
      K = function (a) {
        speed = a ? a : e.settings.speed;
        var b = { left: 0, top: 0 },
          c = { left: 0, top: 0 };
        "next" == e.settings.autoDirection
          ? (b = f.find(".bx-clone").first().position())
          : (c = e.children.first().position());
        var d = "horizontal" == e.settings.mode ? -b.left : -b.top,
          g = "horizontal" == e.settings.mode ? -c.left : -c.top,
          h = { resetValue: g };
        t(d, "ticker", speed, h);
      },
      L = function () {
        (e.touch = { start: { x: 0, y: 0 }, end: { x: 0, y: 0 } }),
          e.viewport.bind("touchstart", M);
      },
      M = function (a) {
        if (e.working) a.preventDefault();
        else {
          e.touch.originalPos = f.position();
          var b = a.originalEvent;
          (e.touch.start.x = b.changedTouches[0].pageX),
            (e.touch.start.y = b.changedTouches[0].pageY),
            e.viewport.bind("touchmove", N),
            e.viewport.bind("touchend", O);
        }
      },
      N = function (a) {
        var b = a.originalEvent,
          c = Math.abs(b.changedTouches[0].pageX - e.touch.start.x),
          d = Math.abs(b.changedTouches[0].pageY - e.touch.start.y);
        if (
          (3 * c > d && e.settings.preventDefaultSwipeX
            ? a.preventDefault()
            : 3 * d > c &&
              e.settings.preventDefaultSwipeY &&
              a.preventDefault(),
          "fade" != e.settings.mode && e.settings.oneToOneTouch)
        ) {
          var f = 0;
          if ("horizontal" == e.settings.mode) {
            var g = b.changedTouches[0].pageX - e.touch.start.x;
            f = e.touch.originalPos.left + g;
          } else {
            var g = b.changedTouches[0].pageY - e.touch.start.y;
            f = e.touch.originalPos.top + g;
          }
          t(f, "reset", 0);
        }
      },
      O = function (a) {
        e.viewport.unbind("touchmove", N);
        var b = a.originalEvent,
          c = 0;
        if (
          ((e.touch.end.x = b.changedTouches[0].pageX),
          (e.touch.end.y = b.changedTouches[0].pageY),
          "fade" == e.settings.mode)
        ) {
          var d = Math.abs(e.touch.start.x - e.touch.end.x);
          d >= e.settings.swipeThreshold &&
            (e.touch.start.x > e.touch.end.x
              ? f.goToNextSlide()
              : f.goToPrevSlide(),
            f.stopAuto());
        } else {
          var d = 0;
          "horizontal" == e.settings.mode
            ? ((d = e.touch.end.x - e.touch.start.x),
              (c = e.touch.originalPos.left))
            : ((d = e.touch.end.y - e.touch.start.y),
              (c = e.touch.originalPos.top)),
            !e.settings.infiniteLoop &&
            ((0 == e.active.index && d > 0) || (e.active.last && d < 0))
              ? t(c, "reset", 200)
              : Math.abs(d) >= e.settings.swipeThreshold
              ? (d < 0 ? f.goToNextSlide() : f.goToPrevSlide(), f.stopAuto())
              : t(c, "reset", 200);
        }
        e.viewport.unbind("touchend", O);
      },
      P = function (b) {
        var c = a(window).width(),
          d = a(window).height();
        (g == c && h == d) || ((g = c), (h = d), f.redrawSlider());
      };
    return (
      (f.goToSlide = function (b, c) {
        if (!e.working && e.active.index != b)
          if (
            ((e.working = !0),
            (e.oldIndex = e.active.index),
            b < 0
              ? (e.active.index = q() - 1)
              : b >= q()
              ? (e.active.index = 0)
              : (e.active.index = b),
            e.settings.onSlideBefore(
              e.children.eq(e.active.index),
              e.oldIndex,
              e.active.index
            ),
            "next" == c
              ? e.settings.onSlideNext(
                  e.children.eq(e.active.index),
                  e.oldIndex,
                  e.active.index
                )
              : "prev" == c &&
                e.settings.onSlidePrev(
                  e.children.eq(e.active.index),
                  e.oldIndex,
                  e.active.index
                ),
            (e.active.last = e.active.index >= q() - 1),
            e.settings.pager && E(e.active.index),
            e.settings.controls && H(),
            "fade" == e.settings.mode)
          )
            e.settings.adaptiveHeight &&
              e.viewport.height() != m() &&
              e.viewport.animate(
                { height: m() },
                e.settings.adaptiveHeightSpeed
              ),
              e.children
                .filter(":visible")
                .fadeOut(e.settings.speed)
                .css({ zIndex: 0 }),
              e.children
                .eq(e.active.index)
                .css("zIndex", 51)
                .fadeIn(e.settings.speed, function () {
                  a(this).css("zIndex", 50), F();
                });
          else {
            e.settings.adaptiveHeight &&
              e.viewport.height() != m() &&
              e.viewport.animate(
                { height: m() },
                e.settings.adaptiveHeightSpeed
              );
            var d = 0,
              g = { left: 0, top: 0 };
            if (!e.settings.infiniteLoop && e.carousel && e.active.last)
              if ("horizontal" == e.settings.mode) {
                var h = e.children.eq(e.children.length - 1);
                (g = h.position()), (d = e.viewport.width() - h.width());
              } else {
                var i = e.children.length - e.settings.minSlides;
                g = e.children.eq(i).position();
              }
            else if (e.carousel && e.active.last && "prev" == c) {
              var j =
                  1 == e.settings.moveSlides
                    ? e.settings.maxSlides - r()
                    : (q() - 1) * r() -
                      (e.children.length - e.settings.maxSlides),
                h = f.children(".bx-clone").eq(j);
              g = h.position();
            } else if ("next" == c && 0 == e.active.index)
              (g = f.find(".bx-clone").eq(e.settings.maxSlides).position()),
                (e.active.last = !1);
            else if (b >= 0) {
              var k = b * r();
              g = e.children.eq(k).position();
            }
            if ("undefined" != typeof g) {
              var l = "horizontal" == e.settings.mode ? -(g.left - d) : -g.top;
              t(l, "slide", e.settings.speed);
            }
          }
      }),
      (f.goToNextSlide = function () {
        if (e.settings.infiniteLoop || !e.active.last) {
          var a = parseInt(e.active.index) + 1;
          f.goToSlide(a, "next");
        }
      }),
      (f.goToPrevSlide = function () {
        if (e.settings.infiniteLoop || 0 != e.active.index) {
          var a = parseInt(e.active.index) - 1;
          f.goToSlide(a, "prev");
        }
      }),
      (f.startAuto = function (a) {
        e.interval ||
          ((e.interval = setInterval(function () {
            "next" == e.settings.autoDirection
              ? f.goToNextSlide()
              : f.goToPrevSlide();
          }, e.settings.pause)),
          e.settings.autoControls && 1 != a && G("stop"));
      }),
      (f.stopAuto = function (a) {
        e.interval &&
          (clearInterval(e.interval),
          (e.interval = null),
          e.settings.autoControls && 1 != a && G("start"));
      }),
      (f.getCurrentSlide = function () {
        return e.active.index;
      }),
      (f.getSlideCount = function () {
        return e.children.length;
      }),
      (f.redrawSlider = function () {
        e.children.add(f.find(".bx-clone")).width(o()),
          e.viewport.css("height", m()),
          e.settings.ticker || s(),
          e.active.last && (e.active.index = q() - 1),
          e.active.index >= q() && (e.active.last = !0),
          e.settings.pager &&
            !e.settings.pagerCustom &&
            (u(), E(e.active.index));
      }),
      (f.destroySlider = function () {
        e.initialized &&
          ((e.initialized = !1),
          a(".bx-clone", this).remove(),
          e.children.removeAttr("style"),
          this.removeAttr("style").unwrap().unwrap(),
          e.controls.el && e.controls.el.remove(),
          e.controls.next && e.controls.next.remove(),
          e.controls.prev && e.controls.prev.remove(),
          e.pagerEl && e.pagerEl.remove(),
          a(".bx-caption", this).remove(),
          e.controls.autoEl && e.controls.autoEl.remove(),
          clearInterval(e.interval),
          a(window).unbind("resize", P));
      }),
      (f.reloadSlider = function (a) {
        void 0 != a && (d = a), f.destroySlider(), j();
      }),
      j(),
      this
    );
  };
})(jQuery),
  (function (a, b) {
    var c =
      "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
    a.fn.imagesLoaded = function (d) {
      function e() {
        var b = a(l),
          c = a(m);
        h && (m.length ? h.reject(j, b, c) : h.resolve(j)),
          a.isFunction(d) && d.call(g, j, b, c);
      }
      function f(b, d) {
        b.src === c ||
          -1 !== a.inArray(b, k) ||
          (k.push(b),
          d ? m.push(b) : l.push(b),
          a.data(b, "imagesLoaded", { isBroken: d, src: b.src }),
          i && h.notifyWith(a(b), [d, j, a(l), a(m)]),
          j.length === k.length && (setTimeout(e), j.unbind(".imagesLoaded")));
      }
      var g = this,
        h = a.isFunction(a.Deferred) ? a.Deferred() : 0,
        i = a.isFunction(h.notify),
        j = g.find("img").add(g.filter("img")),
        k = [],
        l = [],
        m = [];
      return (
        a.isPlainObject(d) &&
          a.each(d, function (a, b) {
            "callback" === a ? (d = b) : h && h[a](b);
          }),
        j.length
          ? j
              .bind("load.imagesLoaded error.imagesLoaded", function (a) {
                f(a.target, "error" === a.type);
              })
              .each(function (d, e) {
                var g = e.src,
                  h = a.data(e, "imagesLoaded");
                h && h.src === g
                  ? f(e, h.isBroken)
                  : e.complete && e.naturalWidth !== b
                  ? f(e, 0 === e.naturalWidth || 0 === e.naturalHeight)
                  : (e.readyState || e.complete) && ((e.src = c), (e.src = g));
              })
          : e(),
        h ? h.promise(g) : g
      );
    };
  })(jQuery);
