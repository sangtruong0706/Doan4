(function e(e,n,a,t,r){
    var o="function"==typeof BigInt&&-1!==BigInt.toString().indexOf("[native code]")?"modern":"legacy";
    window.Shopify=window.Shopify||{};
    var i=window.Shopify;
    i.analytics=i.analytics||{};
    var s=i.analytics;
    s.replayQueue=[],s.publish=function(e,n,a){return s.replayQueue.push([e,n,a]),!0};
    try{
        self.performance.mark("wpm:start")
    }catch(e){}

    var l=[a,"/wpm","/b",r,o.substring(0,1),".js"].join("");
    
    !function(e){
        var n=e.src,a=e.async,t=void 0===a||a,r=e.onload,o=e.onerror,
            i=document.createElement("script"),
            s=document.head,
            l=document.body;
        
        i.async=t,i.src=n,r&&i.addEventListener("load",r),o&&i.addEventListener("error",o),
        s?s.appendChild(i):l?l.appendChild(i):console.error("Did not find a head or body element to append the script")
    }({
        src:l,
        async:!0,
        onload:function(){
            var a=window.webPixelsManager.init(e);
            n(a);
            var t=window.Shopify.analytics;
            t.replayQueue.forEach((function(e){
                var n=e[0],t=e[1],r=e[2];
                a.publishCustomEvent(n,t,r)
            })),
            t.replayQueue=[],
            t.publish=a.publishCustomEvent,
            t.visitor=a.visitor
        },
        onerror:function(){
            var n=e.storefrontBaseUrl.replace(/\/$/,""),
                a="".concat(n,"/.well-known/shopify/monorail/unstable/produce_batch"),
                r=JSON.stringify({
                    metadata:{event_sent_at_ms:(new Date).getTime()},
                    events:[{
                        schema_id:"web_pixels_manager_load/2.0",
                        payload:{
                            version:t||"latest",
                            page_url:self.location.href,
                            status:"failed",
                            error_msg:"".concat(l," has failed to load")
                        },
                        metadata:{event_created_at_ms:(new Date).getTime()}
                    }]
                });
            
            try{
                if(self.navigator.sendBeacon.bind(self.navigator)(a,r))return!0
            }catch(e){}
            
            var o=new XMLHttpRequest;
            
            try{
                return o.open("POST",a,!0),
                o.setRequestHeader("Content-Type","text/plain"),
                o.send(r),!0
            }catch(e){
                console&&console.warn&&console.warn("[Web Pixels Manager] Got an unhandled error while logging a load error.")
            }
            return!1
        }
    })
})({
    shopId: 15771653,
    storefrontBaseUrl: "https://chicago-theme.myshopify.com",
    cdnBaseUrl: "https://chicago-theme.myshopify.com/cdn",
    surface: "storefront-renderer",
    enabledBetaFlags: [],
    webPixelsConfigList: [
        {
            "id":"shopify-app-pixel",
            "configuration":"{}",
            "eventPayloadVersion":"v1",
            "runtimeContext":"STRICT",
            "scriptVersion":"063",
            "apiClientId":"shopify-pixel",
            "type":"APP",
            "purposes":["ANALYTICS"]
        },
        {
            "id":"shopify-custom-pixel",
            "eventPayloadVersion":"v1",
            "runtimeContext":"LAX",
            "scriptVersion":"063",
            "apiClientId":"shopify-pixel",
            "type":"CUSTOM",
            "purposes":["ANALYTICS"]
        }
    ],
    initData: {
        "cart":null,
        "checkout":null,
        "customer":null,
        "productVariants":[]
    }
});

// ShopifyAnalytics meta
window.ShopifyAnalytics = window.ShopifyAnalytics || {};
window.ShopifyAnalytics.meta = window.ShopifyAnalytics.meta || {};
window.ShopifyAnalytics.meta.currency = 'USD';
var meta = {"page":{"pageType":"home"}};
for (var attr in meta) {
    window.ShopifyAnalytics.meta[attr] = meta[attr];
}
