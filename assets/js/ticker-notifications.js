jQuery(document).ready(function ($) {
    const duration = tickerNotificationsSettings.displayDuration; // Interval for fetching notifications

    function processNotifications(data) {
        const { notifications, options } = data;

        return notifications.map(notification => {
            let template;
            switch (notification.event_type) {
                case 'item_delivered':
                    template = options.notification_delivered;
                    break;
                case 'item_sold':
                    template = options.notification_sold;
                    break;
                case 'item_dispatched':
                    template = options.notification_dispatched;
                    break;
                default:
                    template = notification.notification_message;
            }

            let displayMessage = template
                .replace('{product_name}', notification.product_name || 'Unknown Product')
                .replace('{user_name}', notification.user_name || 'Unknown User')
                .replace('{shipping_address}', notification.shipping_address || 'Unknown Location')
                .replace('{company_location}', notification.company_location || 'Unknown');

            const time = notification.notification_time.split(' ')[1].slice(0, 5);

            return { ...notification, displayMessage, displayTime: time };
        }).sort((a, b) => {
            return new Date(`1970-01-01T${b.displayTime}:00`).getTime() - new Date(`1970-01-01T${a.displayTime}:00`).getTime();
        });
    }

    function fetchNotifications() {
        $.ajax({
            url: 'http://ticker-notify.local/wp-admin/admin-ajax.php',
            type: 'POST',
            data: { action: 'fetch_ticker_notifications' },
            success: function (response) {
                const processedNotifications = processNotifications(response);
                const notificationList = $('.ticker-notifications-list');

                if (!notificationList.length) {
                    console.error('Notification list element not found.');
                    return;
                }
                notificationList.css('height', `${processedNotifications.length *100}`)

                // Fade out existing notifications and remove them before adding new ones
                // notificationList.children().each(function (index) {
                //     $(this).delay(index * 100).fadeOut(400, function () {
                //         $(this).remove();
                //     });
                // });

                setTimeout(() => {
                    notificationList.empty(); // Ensure no lingering old notifications

                    processedNotifications.forEach((notification, index) => {
                        const newItem = $(`
                            <li class="notification-item" style="display: none; opacity: 0; transform: translateY(10px);">
                                <span class="notification-text">${notification.displayMessage}</span>
                                <span class="notification-time">${notification.displayTime}</span>
                            </li>
                        `);
                        notificationList.append(newItem);

                        // Animate each item with a slight delay for a smooth effect
                        newItem.delay(index * 300).queue(function (next) {
                            $(this).css({ opacity: 1}).slideDown(200);
                            next();
                        });
                    });
                }, 600); // Ensure old notifications are fully removed before adding new ones
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            },
            complete: function () {
                setTimeout(fetchNotifications, duration);
            }
        });
    }

    fetchNotifications();
});
