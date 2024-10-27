self.addEventListener('message', (event) => {
    notification = event.data;
    self.registration.showNotification(
        notification.title,
        notification.options
    ).catch((error) => {
        console.log(error);
    });
});
