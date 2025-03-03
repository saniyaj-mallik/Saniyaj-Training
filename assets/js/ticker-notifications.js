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
                console.log(response); // Log the response for debugging
                const processedNotifications = processNotifications(response);

                if (processedNotifications && Array.isArray(processedNotifications)) {
                    // Get all existing <li> elements
                    const $listItems = $('.ticker-notifications-list li');

                    // Update the content of each <li> element
                    processedNotifications.forEach((notification, index) => {
                        if ($listItems[index]) {
                            // Update the text content of the existing <li>
                            $($listItems[index]).text(notification.displayMessage
                            );
                        } else {
                            // If there are more notifications than <li> elements, append new ones
                            $('.ticker-notifications-list').append('<li>' + notification.displayMessage
                                + '</li>').hide().slideDown(200);
                        }
                    });

                    // If there are fewer notifications than <li> elements, hide the extra ones
                    if (response.length < $listItems.length) {
                        $listItems.slice(response.length).hide().slideDown(200);
                    }
                } else {
                    console.error('Invalid response format:', response);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error); // Log any errors
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