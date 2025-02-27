jQuery(document).ready(function($) {
    let index = 0;
    const notifications = $('.ticker-notifications-list li');
    const duration = tickerNotificationsSettings.displayDuration; // Use the localized variable

    function rotateNotifications() {
        notifications.removeClass('active').hide();
        $(notifications[index]).addClass('active').show();
        index = (index + 1) % notifications.length;
        setTimeout(rotateNotifications, duration);
    }

    if (notifications.length > 0) {
        $(notifications[0]).addClass('active').show(); // Show the first notification immediately
        setTimeout(rotateNotifications, duration); // Start rotation after the initial delay
    }
});