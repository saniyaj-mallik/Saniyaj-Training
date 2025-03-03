<?php
/**
 * Ticker notification activation Class.
 *
 * @package Ticker Notification
 * @since 1.0.0
 */

/**
 * Handles activation and deactivation logic for the Ticker Notifications plugin.
 *
 * This class manages the creation of the plugin's database table and default options
 * upon activation, and cleanup (table removal and option deletion) upon deactivation.
 *
 * @since 1.0
 */
class Ticker_Notifications_Activation {
	/**
	 * Activates the plugin by creating the notifications table and setting default options.
	 *
	 * This method creates a database table to store ticker notification data and initializes
	 * plugin options with default values. It uses WordPress's dbDelta for safe table creation.
	 *
	 * @global wpdb $wpdb WordPress database access abstraction object.
	 * @return void
	 */
	public static function activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'ticker_notifications';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            notification_time datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            event_type varchar(50) NOT NULL,
            user_name varchar(50) NOT NULL,
            product_name varchar(255) NOT NULL,
            product_hyperlink varchar(255) DEFAULT NULL,
            price decimal(10,2) DEFAULT NULL,
            company_location varchar(100) DEFAULT NULL,
            shipping_address varchar(100) DEFAULT NULL,
            supplier_address varchar(100) DEFAULT NULL,
            supplier_amount decimal(10,2) DEFAULT NULL,
            employee_initials varchar(10) DEFAULT NULL,
            authorization_group varchar(100) DEFAULT NULL,
            notification_message text DEFAULT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		// Setting default options.
		$default_options = array(
			'notification_sold' => '{product_name} sold to {user_name} at {company_location}',
			'notification_dispatched' => '{product_name} dispatched to {user_name} at {shipping_address}',
			'notification_delivered' => '{product_name} delivered to {user_name} at {shipping_address}',
			'store_last_n' => 10,
			'display_duration' => 3,
			'randomize_order' => false,
			'auth_token' => wp_generate_password( 32, false ),
		);
		add_option( 'ticker_notifications_options', $default_options );
	}

	/**
	 * Deactivates the plugin by dropping the notifications table and deleting options.
	 *
	 * This method performs cleanup by removing the plugin's database table and its stored
	 * options from the WordPress options table.
	 *
	 * @global wpdb $wpdb WordPress database access abstraction object.
	 * @return void
	 */
	public static function deactivate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'ticker_notifications';
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );
		delete_option( 'ticker_notifications_options' );
	}
}
