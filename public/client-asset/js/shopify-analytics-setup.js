(window.gaDevIds=window.gaDevIds||[]).push('BwiEti');

(function () {
    var customDocumentWrite = function(content) {
        var jquery = null;

        if (window.jQuery) {
            jquery = window.JQuery;
        } else if (window.Checkout && window.Checkout.$) {
            jquery = window.Checkout.$;
        }

        if (jquery) {
            jquery('body').append(content);
        }
    };

    var hasLoggedConversion = function(token) {
        if (token) {
            return document.cookie.indexOf('loggedConversion=' + token) !== -1;
        }
        return false;
    };

    var setCookieIfConversion = function(token) {
        if (token) {
            var twoMonthsFromNow = new Date(Date.now());
            twoMonthsFromNow.setMonth(twoMonthsFromNow.getMonth() + 2);

            document.cookie = 'loggedConversion=' + token + '; expires=' + twoMonthsFromNow;
        }
    };

    var trekkie = window.ShopifyAnalytics.lib = window.trekkie = window.trekkie || [];
    if (trekkie.integrations) {
        return;
    }

    trekkie.methods = [
        'identify',
        'page',
        'ready',
        'track',
        'trackForm',
        'trackLink'
    ];

    trekkie.factory = function(method) {
        return function() {
            var args = Array.prototype.slice.call(arguments);
            args.unshift(method);
            trekkie.push(args);
            return trekkie;
        };
    };

    for (var i = 0; i < trekkie.methods.length; i++) {
        var key = trekkie.methods[i];
        trekkie[key] = trekkie.factory(key);
    }

    trekkie.load = function(config) {
        trekkie.config = config || {};
        trekkie.config.initialDocumentCookie = document.cookie;
        var first = document.getElementsByTagName('script')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.async = true;
        script.src = '//chicago-theme.myshopify.com/cdn/s/trekkie.storefront.88baf04046928b6edf6574afd22dbd026cc7d568.min.js';

        script.onerror = function(e) {
            var scriptFallback = document.createElement('script');
            scriptFallback.type = 'text/javascript';
            scriptFallback.async = true;
            scriptFallback.src = '//chicago-theme.myshopify.com/cdn/s/trekkie.storefront.88baf04046928b6edf6574afd22dbd026cc7d568.min.js';

            first.parentNode.insertBefore(scriptFallback, first);
        };

        first.parentNode.insertBefore(script, first);
    };

    trekkie.load({
        "Trekkie": {
            "appName": "storefront",
            "development": false,
            "defaultAttributes": {
                "shopId": 15771653,
                "isMerchantRequest": null,
                "themeId": 167765896,
                "themeCityHash": "8571186354372179461",
                "contentLanguage": "en",
                "currency": "USD"
            },
            "isServerSideCookieWritingEnabled": true,
            "monorailRegion": "shop_domain",
            "enabledBetaFlags": ["bbcf04e6"]
        },
        "Google Analytics": {
            "trackingId": "UA-85680309-6",
            "domain": "auto",
            "siteSpeedSampleRate": "10",
            "enhancedEcommerce": true,
            "doubleClick": true,
            "includeSearch": true
        },
        "Facebook Pixel": {
            "pixelIds": ["183589155381562"],
            "agent": "plshopify1.2"
        },
        "Session Attribution": {},
        "S2S": {
            "facebookCapiEnabled": false,
            "source": "trekkie-storefront-renderer"
        }
    });

    var loaded = false;
    trekkie.ready(function() {
        if (loaded) return;
        loaded = true;
        window.ShopifyAnalytics.lib = window.trekkie;
        
        ga('require', 'linker');
        
        function addListener(element, type, callback) {
            if (element.addEventListener) {
                element.addEventListener(type, callback);
            } else if (element.attachEvent) {
                element.attachEvent('on' + type, callback);
            }
        }

        function decorate(event) {
            event = event || window.event;
            var target = event.target || event.srcElement;
            if (target && (target.getAttribute('action') || target.getAttribute('href'))) {
                ga(function (tracker) {
                    var linkerParam = tracker.get('linkerParam');
                    document.cookie = '_shopify_ga=' + linkerParam + '; ' + 'path=/';
                });
            }
        }

        addListener(window, 'load', function(){
            for (var i=0; i < document.forms.length; i++) {
                var action = document.forms[i].getAttribute('action');
                if(action && action.indexOf('/cart') >= 0) {
                    addListener(document.forms[i], 'submit', decorate);
                }
            }
            
            for (var i=0; i < document.links.length; i++) {
                var href = document.links[i].getAttribute('href');
                if(href && href.indexOf('/checkout') >= 0) {
                    addListener(document.links[i], 'click', decorate);
                }
            }
        });

        var originalDocumentWrite = document.write;
        document.write = customDocumentWrite;
        try { window.ShopifyAnalytics.merchantGoogleAnalytics.call(this); } catch(error) {};
        document.write = originalDocumentWrite;

        window.ShopifyAnalytics.lib.page(null, {"pageType": "home"});

        var match = window.location.pathname.match(/checkouts\/(.+)\/(thank_you|post_purchase)/);
        var token = match ? match[1] : undefined;
        if (!hasLoggedConversion(token)) {
            setCookieIfConversion(token);
        }
    });

    var eventsListenerScript = document.createElement('script');
    eventsListenerScript.async = true;
    eventsListenerScript.src = "//chicago-theme.myshopify.com/cdn/shopifycloud/shopify/assets/shop_events_listener-61fa9e0a912c675e178777d2b27f6cbd482f8912a6b0aa31fa3515985a8cd626.js";
    document.getElementsByTagName('head')[0].appendChild(eventsListenerScript);
})();
