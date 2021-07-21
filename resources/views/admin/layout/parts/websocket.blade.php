<script>
    var pusher = new Pusher('12345', {
        wsHost: '3x1.test',
        wsPort: 6001,
        wssPort: 6001,
        disableStats: true,
        // encrypted: true,
        authEndpoint: '{{ url(request()->path().'/auth') }}',
        auth: {
            headers: {
                'X-CSRF-Token': "{{ csrf_token() }}",
                'X-App-ID': this.app.id
            }
        },
        enabledTransports: ['ws', 'flash', 'wss'],
    });
    // pusher.connection.bind('state_change', states => {
    //     console.log("Channels current state is " + states.current)
    // });
    //
    // pusher.connection.bind('connected', () => {
    //     console.log("Channels current state is connected")
    // });
    //
    // pusher.connection.bind('disconnected', () => {
    //     console.log("Channels current state is disconnected")
    // })
    //
    // pusher.connection.bind('error', event => {
    //     if (event.error.data.code === 4100) {
    //         console.log("Maximum connection limit exceeded!")
    //         throw new Error("Over capacity");
    //     }
    // });
    Pusher.logToConsole = false;
    var channel = pusher.subscribe('push-notifications');
    channel.bind('App\\Events\\PushNotification', function(data) {
        console.log(data);
        if(data.type === 'all' || authId == data.authId){
            Notification.requestPermission( permission => {
                let notification = new Notification(data.title, {
                    body: data.message, // content for the alert
                    icon: data.image // optional image url
                });

                // link to page on clicking the notification
                notification.onclick = (data) => {
                    window.open(data.url);
                };
            });

            //Push To Notification
            $('#not-empty').remove();
            $('#not-area').append('<a href="'+data.url+'" class="dropdown-item"><i class="fa '+data.icon+' text-success"></i> '+data.title+'</a>');
            let current_value = $('#not-count').text();
            current_value++;
            $('#not-count').text(current_value);
        }
    });
</script>
