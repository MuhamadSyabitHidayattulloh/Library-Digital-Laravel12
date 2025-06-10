<!-- CometChat Widget -->
<div id="cometchat"></div>

@push('scripts')
<script src="{{ asset('node_modules/@cometchat/chat-sdk-javascript/CometChat.js') }}"></script>
<script>
    const appID = "276779a773176e9b";
    const region = "US";
    const authKey = "f27128a72c963e6278a0fc1abb848000ba93704a";
    const widgetID = "cd864c10-488b-4d66-88ae-49a3e2a0c5d9";

    (function(d, w) {
        const CometChatWidget = w.CometChatWidget;

        CometChat.init(appID, {
            region: region,
            appId: appID,
            authKey: authKey,
        }).then(
            () => {
                console.log('CometChat initialized successfully');

                // Initialize widget after successful initialization
                CometChatWidget.init({
                    "appID": appID,
                    "appRegion": region,
                    "authKey": authKey,
                    "widgetID": widgetID,
                }).then(response => {
                    // Launch widget in floating mode
                    CometChatWidget.launch({
                        "widgetID": widgetID,
                        "target": "#cometchat",
                        "roundedCorners": "true",
                        "height": "600px",
                        "width": "800px",
                        "defaultID": '', // default user or group ID to load
                        "defaultType": 'group', // user or group
                    });
                });
            },
            error => {
                console.log('CometChat initialization failed', error);
            }
        );
    })(document, window);
</script>
@endpush
