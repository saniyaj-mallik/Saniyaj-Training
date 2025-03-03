jQuery(document).ready(function ($) {
    const duration = tickerNotificationsSettings.displayDuration; // Duration in milliseconds

    function processNotifications(data) {
        const { notifications, options } = data;

        // Map through notifications and create display messages
        const formattedNotifications = notifications.map(notification => {
            // Determine which template to use based on event_type
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
                    template = notification.notification_message; // Fallback to default message
            }

            // Replace placeholders with actual values
            let displayMessage = template
                .replace('{product_name}', notification.product_name || 'Unknown Product')
                .replace('{user_name}', notification.user_name || 'Unknown User')
                .replace('{shipping_address}', notification.shipping_address || 'Unknown Location')
                .replace('{company_location}', notification.company_location || 'Unknown');


            const time = notification.notification_time.split(' ')[1].slice(0, 5);


            // Return formatted notification object
            return {
                ...notification,
                displayMessage: displayMessage,
                displayTime: time
            };
        });

        // Sort notifications by displayTime (newest at the top)
        formattedNotifications.sort((a, b) => {
            // Convert displayTime to a comparable format (e.g., timestamp)
            const timeA = new Date(`1970-01-01T${a.displayTime}:00`).getTime();
            const timeB = new Date(`1970-01-01T${b.displayTime}:00`).getTime();

            // Sort in descending order (newest first)
            return timeB - timeA;
        });

        return formattedNotifications;
    }

    function fetchNotifications() {
        $.ajax({
            url: 'http://ticker-notify.local/wp-admin/admin-ajax.php', // AJAX URL
            type: 'POST',
            data: {
                action: 'fetch_ticker_notifications'
            },
            success: function (response) {
                const processedNotifications = processNotifications(response);

                if (processedNotifications && Array.isArray(processedNotifications)) {
                    const notificationList = $('.ticker-notifications-list');
                    console.log(notificationList);
                    notificationList.css('height', `${processedNotifications.length *110}`)
                    // Clear existing notifications
                    notificationList.empty();

                    // Add new notifications
                    processedNotifications.forEach((notification, index) => {

                        // Create new list item with notification content
                        const newItem = $(`
                            <li class="notification-item">
                                <span class="notification-text">${notification.displayMessage}</span>
                                <span class="notification-time">${notification.displayTime}</span>
                            </li>
                        `);
                        notificationList.append(newItem);
                        // Animate the new item
                        newItem.hide().slideDown(200);
                        
                    });
                } else {
                    console.error('Invalid response format:', processedNotifications);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            },
            complete: function () {
                // Schedule the next fetch after the duration
                setTimeout(fetchNotifications, duration);
            }
        });
    }

    // Initial fetch and start the periodic updates
    fetchNotifications();
});