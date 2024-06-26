!(function (a) {
  "use strict";
  (a.fn.equalHeight = function () {
    var b = [];
    return (
      a.each(this, function (c, d) {
        var f,
          e = a(d),
          g =
            "border-box" === e.css("box-sizing") ||
            "border-box" === e.css("-moz-box-sizing");
        (f = g ? e.innerHeight() : e.height()), b.push(f);
      }),
      this.css("height", Math.max.apply(window, b) + "px"),
      this
    );
  }),
    (a.fn.equalHeightGrid = function (b) {
      var c = this.filter(":visible");
      c.css("height", "auto");
      for (var d = 0; d < c.length; d++)
        if (d % b === 0) {
          for (var e = a(c[d]), f = 1; f < b; f++) e = e.add(c[d + f]);
          e.equalHeight();
        }
      return this;
    }),
    (a.fn.detectGridColumns = function () {
      var b = 0,
        c = 0,
        d = this.filter(":visible");
      return (
        d.each(function (d, e) {
          var f = a(e).offset().top;
          return (0 === b || f === b) && (c++, void (b = f));
        }),
        c
      );
    });
  var b = 0;
  (a.fn.responsiveEqualHeightGrid = function () {
    function e() {
      var a = c.detectGridColumns();
      c.equalHeightGrid(a);
    }
    var c = this,
      d = ".grids_" + b;
    return (
      c.data("grids-event-namespace", d),
      a(window).bind("resize" + d + " load" + d, e),
      e(),
      b++,
      this
    );
  }),
    (a.fn.responsiveEqualHeightGridDestroy = function () {
      var b = this;
      return (
        b.css("height", "auto"),
        a(window).unbind(b.data("grids-event-namespace")),
        this
      );
    });
})(window.jQuery);
