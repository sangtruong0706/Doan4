typeof ShopifyAPI == "undefined" && (ShopifyAPI = {});
// function attributeToString(attribute) {
//   return (
//     typeof attribute != "string" &&
//       ((attribute += ""), attribute === "undefined" && (attribute = "")),
//     jQuery.trim(attribute)
//   );
// }
// (ShopifyAPI.onCartUpdate = function (cart) {}),
//   (ShopifyAPI.updateCartNote = function (note, callback) {
//     var params = {
//       type: "POST",
//       url: "/cart/update.js",
//       data: "note=" + attributeToString(note),
//       dataType: "json",
//       success: function (cart) {
//         typeof callback == "function"
//           ? callback(cart)
//           : ShopifyAPI.onCartUpdate(cart);
//       },
//       error: function (XMLHttpRequest2, textStatus2) {
//         ShopifyAPI.onError(XMLHttpRequest2, textStatus2);
//       },
//     };
//     jQuery.ajax(params);
//   });
var ajaxCart = (function (module, $) {
  "use strict";
  var init,
    loadCart,
    settings,
    $body,
    $cartContainer,
    $drawerContainer,
    cartCallback,
    adjustCart,
    validateQty;
  return (
    (loadCart = function () {
      $body.addClass("drawer--is-loading"),
        ShopifyAPI.getCart(cartUpdateCallback);
    }),
    (cartCallback = function (cart) {
      $body.removeClass("drawer--is-loading"),
        $body.trigger("ajaxCart.afterCartLoad", cart);
    }),
    (module = { init: init, load: loadCart }),
    module
  );
})(ajaxCart || {}, jQuery);
// # sourceMappingURL=/cdn/shop/t/3/assets/ajax-cart.js.map?v=110047211724516994121478512602

