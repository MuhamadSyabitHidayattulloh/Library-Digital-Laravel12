<!-- CometChat Widget -->
<div id="cometchat"></div>

@push('scripts')
<script src="https://widget-js.cometchat.io/v3/cometchatwidget.js"></script>
<script>
window.addEventListener('DOMContentLoaded', (event) => {
    CometChatWidget.init({
        "appID": "276779a773176e9b",
        "appRegion": "US",
        "authKey": "f27128a72c963e6278a0fc1abb848000ba93704a",
    }).then(response => {
        console.log("CometChat Widget initialization completed successfully");

        // Launch the widget in floating mode
        CometChatWidget.launch({
            "widgetID": "cd864c10-488b-4d66-88ae-49a3e2a0c5d9",
            "target": "#cometchat",
            "roundedCorners": "true",
            "height": "600px",
            "width": "800px",
            "defaultID": '', // default user or group ID to load
            "defaultType": 'group', // user or group
        });

        // If user is authenticated, login to CometChat
        @auth
        fetch('/cometchat/token')
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    CometChatWidget.login({
                        "uid": "{{ auth()->id() }}",
                        "authToken": data.token,
                    });
                }
            })
            .catch(error => {
                console.error("Failed to get CometChat auth token:", error);
            });
        @endauth
    }).catch(error => {
        console.log("CometChat Widget initialization failed with error:", error);
    });
});
</script>
@endpush
