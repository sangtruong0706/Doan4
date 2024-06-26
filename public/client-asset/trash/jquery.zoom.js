/*!
	Zoom v1.7.13 - 2014-04-29
	Enlarge images on click or mouseover.
	(c) 2014 Jack Moore - http://www.jacklmoore.com/zoom
	license: http://www.opensource.org/licenses/mit-license.php
*/
(function (o) {
  var t = {
    url: !1,
    callback: !1,
    target: !1,
    duration: 120,
    on: "mouseover",
    touch: !0,
    onZoomIn: !1,
    onZoomOut: !1,
    magnify: 1,
  };
  (o.zoom = function (t, n, e, i) {
    var u,
      c,
      a,
      m,
      l,
      r,
      s,
      f = o(t).css("position"),
      h = o(n);
    return (
      (t.style.position = /(absolute|fixed)/.test(f) ? f : "relative"),
      (t.style.overflow = "hidden"),
      (e.style.width = e.style.height = ""),
      o(e)
        .addClass("zoomImg")
        .css({
          position: "absolute",
          top: 0,
          left: 0,
          opacity: 0,
          width: e.width * i,
          height: e.height * i,
          border: "none",
          maxWidth: "none",
          maxHeight: "none",
        })
        .appendTo(t),
      {
        init: function () {
          (c = o(t).outerWidth()),
            (u = o(t).outerHeight()),
            n === t
              ? ((m = c), (a = u))
              : ((m = h.outerWidth()), (a = h.outerHeight())),
            (l = (e.width - c) / m),
            (r = (e.height - u) / a),
            (s = h.offset());
        },
        move: function (o) {
          var t = o.pageX - s.left,
            n = o.pageY - s.top;
          (n = Math.max(Math.min(n, a), 0)),
            (t = Math.max(Math.min(t, m), 0)),
            (e.style.left = t * -l + "px"),
            (e.style.top = n * -r + "px");
        },
      }
    );
  }),
    (o.fn.zoom = function (n) {
      return this.each(function () {
        var e,
          i = o.extend({}, t, n || {}),
          u = i.target || this,
          c = this,
          a = o(c),
          m = document.createElement("img"),
          l = o(m),
          r = "mousemove.zoom",
          s = !1,
          f = !1;
        (i.url ||
          ((e = a.find("img")),
          e[0] && (i.url = e.data("src") || e.attr("src")),
          i.url)) &&
          ((function () {
            var o = u.style.position,
              t = u.style.overflow;
            a.one("zoom.destroy", function () {
              a.off(".zoom"),
                (u.style.position = o),
                (u.style.overflow = t),
                l.remove();
            });
          })(),
          (m.onload = function () {
            function t(t) {
              e.init(),
                e.move(t),
                l
                  .stop()
                  .fadeTo(
                    o.support.opacity ? i.duration : 0,
                    1,
                    o.isFunction(i.onZoomIn) ? i.onZoomIn.call(m) : !1
                  );
            }
            function n() {
              l.stop().fadeTo(
                i.duration,
                0,
                o.isFunction(i.onZoomOut) ? i.onZoomOut.call(m) : !1
              );
            }
            var e = o.zoom(u, c, m, i.magnify);
            "grab" === i.on
              ? a.on("mousedown.zoom", function (i) {
                  1 === i.which &&
                    (o(document).one("mouseup.zoom", function () {
                      n(), o(document).off(r, e.move);
                    }),
                    t(i),
                    o(document).on(r, e.move),
                    i.preventDefault());
                })
              : "click" === i.on
              ? a.on("click.zoom", function (i) {
                  return s
                    ? void 0
                    : ((s = !0),
                      t(i),
                      o(document).on(r, e.move),
                      o(document).one("click.zoom", function () {
                        n(), (s = !1), o(document).off(r, e.move);
                      }),
                      !1);
                })
              : "toggle" === i.on
              ? a.on("click.zoom", function (o) {
                  s ? n() : t(o), (s = !s);
                })
              : "mouseover" === i.on &&
                (e.init(),
                a
                  .on("mouseenter.zoom", t)
                  .on("mouseleave.zoom", n)
                  .on(r, e.move)),
              i.touch &&
                a
                  .on("touchstart.zoom", function (o) {
                    o.preventDefault(),
                      f
                        ? ((f = !1), n())
                        : ((f = !0),
                          t(
                            o.originalEvent.touches[0] ||
                              o.originalEvent.changedTouches[0]
                          ));
                  })
                  .on("touchmove.zoom", function (o) {
                    o.preventDefault(),
                      e.move(
                        o.originalEvent.touches[0] ||
                          o.originalEvent.changedTouches[0]
                      );
                  }),
              o.isFunction(i.callback) && i.callback.call(m);
          }),
          (m.src = i.url));
      });
    }),
    (o.fn.zoom.defaults = t);
})(window.jQuery);
