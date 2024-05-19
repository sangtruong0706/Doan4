(function() {
    function asyncLoad() {
        var urls = [
            "//productreviews.shopifycdn.com/embed/loader.js?shop=chicago-theme.myshopify.com",
            "https://assets1.adroll.com/shopify/latest/j/shopify_rolling_bootstrap_v2.js?adroll_adv_id=TO7KTPCXQZHLBETWL6HGQY&adroll_pix_id=UL3L23DUERDGHMPNHSDKKZ&shop=chicago-theme.myshopify.com",
            "https://reviews.hulkapps.com/js/reviews-by-hulkapps.js?shop=chicago-theme.myshopify.com"
        ];
        
        for (var i = 0; i < urls.length; i++) {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = urls[i];
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        }
    }

    if (window.attachEvent) {
        window.attachEvent('onload', asyncLoad);
    } else {
        window.addEventListener('load', asyncLoad, false);
    }
})();
