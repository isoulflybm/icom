window.addEventListener('load', () => {
    if('serviceWorker' in navigator && 'Notification' in window) {
        webSocket = new WebSocket('wss://icom.hopto.org:8000');
        webSocket.onopen = () => {
            console.log('Open');
            navigator.serviceWorker.register('js/service-worker.js');
            Notification.requestPermission(function (permission) {
                if(permission == 'granted') {
                    console.log('Granted notifications');
                }
                else {
                    console.log('Deny notifications');
                    webSocket.close();
                }
            });
        }
        webSocket.onmessage = (message) => {
            console.log('Message', message.data);
            data = JSON.parse(message.data);
            if(data.type == 'notification') {
                title = data.notification.title;
                options = data.notification.options;
                notification = new Notification(
                    title, options
                );
                setTimeout(() => {
                    notification.close();
                }, 10000);
            }
        }
        webSocket.onclose = () => {
            console.log('Close');
        }
        webSocket.onerror = (error) => {
            console.log('Error', error);
        }
    }
});
