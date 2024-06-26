!(function (a, b, c, d) {
  function e(b, c) {
    var f = this;
    "object" == typeof c &&
      (delete c.refresh, delete c.render, a.extend(this, c)),
      (this.$element = a(b)),
      !this.imageSrc &&
        this.$element.is("img") &&
        (this.imageSrc = this.$element.attr("src"));
    var g = (this.position + "").toLowerCase().match(/\S+/g) || [];
    return (
      g.length < 1 && g.push("center"),
      1 == g.length && g.push(g[0]),
      ("top" != g[0] &&
        "bottom" != g[0] &&
        "left" != g[1] &&
        "right" != g[1]) ||
        (g = [g[1], g[0]]),
      this.positionX != d && (g[0] = this.positionX.toLowerCase()),
      this.positionY != d && (g[1] = this.positionY.toLowerCase()),
      (f.positionX = g[0]),
      (f.positionY = g[1]),
      "left" != this.positionX &&
        "right" != this.positionX &&
        (isNaN(parseInt(this.positionX))
          ? (this.positionX = "center")
          : (this.positionX = parseInt(this.positionX))),
      "top" != this.positionY &&
        "bottom" != this.positionY &&
        (isNaN(parseInt(this.positionY))
          ? (this.positionY = "center")
          : (this.positionY = parseInt(this.positionY))),
      (this.position =
        this.positionX +
        (isNaN(this.positionX) ? "" : "px") +
        " " +
        this.positionY +
        (isNaN(this.positionY) ? "" : "px")),
      navigator.userAgent.match(/(iPod|iPhone|iPad)/)
        ? (this.iosFix &&
            !this.$element.is("img") &&
            this.$element.css({
              backgroundImage: "url(" + this.imageSrc + ")",
              backgroundSize: "cover",
              backgroundPosition: this.position,
            }),
          this)
        : navigator.userAgent.match(/(Android)/)
        ? (this.androidFix &&
            !this.$element.is("img") &&
            this.$element.css({
              backgroundImage: "url(" + this.imageSrc + ")",
              backgroundSize: "cover",
              backgroundPosition: this.position,
            }),
          this)
        : ((this.$mirror = a("<div />").prependTo("body")),
          (this.$slider = a("<img />").prependTo(this.$mirror)),
          this.$mirror
            .addClass("parallax-mirror")
            .css({
              visibility: "hidden",
              zIndex: this.zIndex,
              position: "fixed",
              top: 0,
              left: 0,
              overflow: "hidden",
            }),
          this.$slider.addClass("parallax-slider").one("load", function () {
            (f.naturalHeight && f.naturalWidth) ||
              ((f.naturalHeight = this.naturalHeight || this.height || 1),
              (f.naturalWidth = this.naturalWidth || this.width || 1)),
              (f.aspectRatio = f.naturalWidth / f.naturalHeight),
              e.isSetup || e.setup(),
              e.sliders.push(f),
              (e.isFresh = !1),
              e.requestRender();
          }),
          (this.$slider[0].src = this.imageSrc),
          void (
            ((this.naturalHeight && this.naturalWidth) ||
              this.$slider[0].complete) &&
            this.$slider.trigger("load")
          ))
    );
  }
  function f(d) {
    return this.each(function () {
      var f = a(this),
        g = "object" == typeof d && d;
      this == b || this == c || f.is("body")
        ? e.configure(g)
        : f.data("px.parallax") ||
          ((g = a.extend({}, f.data(), g)),
          f.data("px.parallax", new e(this, g))),
        "string" == typeof d && e[d]();
    });
  }
  !(function () {
    for (
      var a = 0, c = ["ms", "moz", "webkit", "o"], d = 0;
      d < c.length && !b.requestAnimationFrame;
      ++d
    )
      (b.requestAnimationFrame = b[c[d] + "RequestAnimationFrame"]),
        (b.cancelAnimationFrame =
          b[c[d] + "CancelAnimationFrame"] ||
          b[c[d] + "CancelRequestAnimationFrame"]);
    b.requestAnimationFrame ||
      (b.requestAnimationFrame = function (c) {
        var d = new Date().getTime(),
          e = Math.max(0, 16 - (d - a)),
          f = b.setTimeout(function () {
            c(d + e);
          }, e);
        return (a = d + e), f;
      }),
      b.cancelAnimationFrame ||
        (b.cancelAnimationFrame = function (a) {
          clearTimeout(a);
        });
  })(),
    a.extend(e.prototype, {
      speed: 0.2,
      bleed: 0,
      zIndex: -100,
      iosFix: !0,
      androidFix: !0,
      position: "center",
      overScrollFix: !1,
      refresh: function () {
        (this.boxWidth = this.$element.outerWidth()),
          (this.boxHeight = this.$element.outerHeight() + 2 * this.bleed),
          (this.boxOffsetTop = this.$element.offset().top - this.bleed),
          (this.boxOffsetLeft = this.$element.offset().left),
          (this.boxOffsetBottom = this.boxOffsetTop + this.boxHeight);
        var a = e.winHeight,
          b = e.docHeight,
          c = Math.min(this.boxOffsetTop, b - a),
          d = Math.max(this.boxOffsetTop + this.boxHeight - a, 0),
          f = (this.boxHeight + (c - d) * (1 - this.speed)) | 0,
          g = ((this.boxOffsetTop - c) * (1 - this.speed)) | 0;
        if (f * this.aspectRatio >= this.boxWidth) {
          (this.imageWidth = (f * this.aspectRatio) | 0),
            (this.imageHeight = f),
            (this.offsetBaseTop = g);
          var h = this.imageWidth - this.boxWidth;
          "left" == this.positionX
            ? (this.offsetLeft = 0)
            : "right" == this.positionX
            ? (this.offsetLeft = -h)
            : isNaN(this.positionX)
            ? (this.offsetLeft = (-h / 2) | 0)
            : (this.offsetLeft = Math.max(this.positionX, -h));
        } else {
          (this.imageWidth = this.boxWidth),
            (this.imageHeight = (this.boxWidth / this.aspectRatio) | 0),
            (this.offsetLeft = 0);
          var h = this.imageHeight - f;
          "top" == this.positionY
            ? (this.offsetBaseTop = g)
            : "bottom" == this.positionY
            ? (this.offsetBaseTop = g - h)
            : isNaN(this.positionY)
            ? (this.offsetBaseTop = (g - h / 2) | 0)
            : (this.offsetBaseTop = g + Math.max(this.positionY, -h));
        }
      },
      render: function () {
        var a = e.scrollTop,
          b = e.scrollLeft,
          c = this.overScrollFix ? e.overScroll : 0,
          d = a + e.winHeight;
        this.boxOffsetBottom > a && this.boxOffsetTop < d
          ? (this.visibility = "visible")
          : (this.visibility = "hidden"),
          (this.mirrorTop = this.boxOffsetTop - a),
          (this.mirrorLeft = this.boxOffsetLeft - b),
          (this.offsetTop =
            this.offsetBaseTop - this.mirrorTop * (1 - this.speed)),
          this.$mirror.css({
            transform: "translate3d(0px, 0px, 0px)",
            visibility: this.visibility,
            top: this.mirrorTop - c,
            left: this.mirrorLeft,
            height: this.boxHeight,
            width: this.boxWidth,
          }),
          this.$slider.css({
            transform: "translate3d(0px, 0px, 0px)",
            position: "absolute",
            top: this.offsetTop,
            left: this.offsetLeft,
            height: this.imageHeight,
            width: this.imageWidth,
            maxWidth: "none",
          });
      },
    }),
    a.extend(e, {
      scrollTop: 0,
      scrollLeft: 0,
      winHeight: 0,
      winWidth: 0,
      docHeight: 1 << 30,
      docWidth: 1 << 30,
      sliders: [],
      isReady: !1,
      isFresh: !1,
      isBusy: !1,
      setup: function () {
        if (!this.isReady) {
          var d = a(c),
            f = a(b);
          f
            .on("scroll.px.parallax load.px.parallax", function () {
              var a = e.docHeight - e.winHeight,
                b = e.docWidth - e.winWidth;
              (e.scrollTop = Math.max(0, Math.min(a, f.scrollTop()))),
                (e.scrollLeft = Math.max(0, Math.min(b, f.scrollLeft()))),
                (e.overScroll = Math.max(
                  f.scrollTop() - a,
                  Math.min(f.scrollTop(), 0)
                )),
                e.requestRender();
            })
            .on("resize.px.parallax load.px.parallax", function () {
              (e.winHeight = f.height()),
                (e.winWidth = f.width()),
                (e.docHeight = d.height()),
                (e.docWidth = d.width()),
                (e.isFresh = !1),
                e.requestRender();
            }),
            (this.isReady = !0);
        }
      },
      configure: function (b) {
        "object" == typeof b &&
          (delete b.refresh, delete b.render, a.extend(this.prototype, b));
      },
      refresh: function () {
        a.each(this.sliders, function () {
          this.refresh();
        }),
          (this.isFresh = !0);
      },
      render: function () {
        this.isFresh || this.refresh(),
          a.each(this.sliders, function () {
            this.render();
          });
      },
      requestRender: function () {
        var a = this;
        this.isBusy ||
          ((this.isBusy = !0),
          b.requestAnimationFrame(function () {
            a.render(), (a.isBusy = !1);
          }));
      },
    });
  var g = a.fn.parallax;
  (a.fn.parallax = f),
    (a.fn.parallax.Constructor = e),
    (a.fn.parallax.noConflict = function () {
      return (a.fn.parallax = g), this;
    }),
    a(c).on("ready.px.parallax.data-api", function () {
      a('[data-parallax="scroll"]').parallax();
    });
})(jQuery, window, document);
