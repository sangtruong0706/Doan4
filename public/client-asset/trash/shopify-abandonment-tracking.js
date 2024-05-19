(function(){
    if ("sendBeacon" in navigator && "performance" in window) {
        var session_token = document.cookie.match(/_shopify_s=([^;]*)/);
        
        function handle_abandonment_event(e) {
            var entries = performance.getEntries().filter(function(entry) {
                return /monorail-edge.shopifysvc.com/.test(entry.name);
            });
            
            if (!window.abandonment_tracked && entries.length === 0) {
                window.abandonment_tracked = true;
                var currentMs = Date.now();
                var navigation_start = performance.timing.navigationStart;
                var payload = {
                    shop_id: 15771653,
                    url: window.location.href,
                    navigation_start,
                    duration: currentMs - navigation_start,
                    session_token: session_token && session_token.length === 2 ? session_token[1] : "",
                    page_type: "index"
                };
                
                window.navigator.sendBeacon("https://monorail-edge.shopifysvc.com/v1/produce", JSON.stringify({
                    schema_id: "online_store_buyer_site_abandonment/1.1",
                    payload: payload,
                    metadata: {
                        event_created_at_ms: currentMs,
                        event_sent_at_ms: currentMs
                    }
                }));
            }
        }
        
        window.addEventListener('pagehide', handle_abandonment_event);
    }
})();
