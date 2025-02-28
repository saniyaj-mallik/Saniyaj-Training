<?php
class Ticker_Notifications_API {
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	public static function register_routes() {
		register_rest_route(
			'ticker-notifications/v1',
			'/notification',
			array(
				'methods' => 'POST',
				'callback' => array( __CLASS__, 'handle_notification' ),
				'permission_callback' => '__return_true', // We'll handle auth in the callback.
			),
		);
	}

	public static function handle_notification( $request ) {
		$options = get_option( 'ticker_notifications_options', array() );
		$auth_token = isset( $options['auth_token'] ) ? $options['auth_token'] : '';

		// Validate authentication token from headers.
		$header_token = $request->get_header( 'Authorization' );
		if ( empty( $header_token ) || 'Bearer ' . $auth_token !== $header_token ) {
			return new WP_Error( 'invalid_token', 'Invalid or missing authentication token', array( 'status' => 401 ) );
		}

		$data = $request->get_params();
		$required_fields = array( 'date_time', 'event_type', 'product_name' );
		foreach ( $required_fields as $field ) {
			if ( empty( $data[ $field ] ) ) {
				return new WP_Error( 'missing_data', 'Missing required field: ' . $field, array( 'status' => 400 ) );
			}
		}

		// Store notification in database.
		global $wpdb;
		$table_name = $wpdb->prefix . 'ticker_notifications';
		$notification_message = self::generate_notification_message( $data['event_type'], $data );

		$result = $wpdb->insert(
			$table_name,
			array(
				'notification_time' => $data['date_time'],
				'event_type' => $data['event_type'],
				'product_name' => $data['product_name'],
				'product_hyperlink' => isset( $data['product_hyperlink'] ) ? $data['product_hyperlink'] : null,
				'price' => isset( $data['price'] ) ? floatval( $data['price'] ) : null,
				'company_location' => isset( $data['company_location'] ) ? $data['company_location'] : null,
				'shipping_address' => isset( $data['shipping_address'] ) ? $data['shipping_address'] : null,
				'supplier_address' => isset( $data['supplier_address'] ) ? $data['supplier_address'] : null,
				'supplier_amount' => isset( $data['supplier_amount'] ) ? floatval( $data['supplier_amount'] ) : null,
				'employee_initials' => isset( $data['employee_initials'] ) ? $data['employee_initials'] : null,
				'authorization_group' => isset( $data['authorization_group'] ) ? $data['authorization_group'] : null,
				'notification_message' => $notification_message,
			),
			array( '%s', '%s', '%s', '%s', '%f', '%s', '%s', '%s', '%f', '%s', '%s', '%s' )
		);

		if ( false === $result ) {
			return new WP_Error( 'storage_error', 'Failed to store notification', array( 'status' => 500 ) );
		}

		// Manage notification limit.
		$store_limit = isset( $options['store_last_n'] ) ? $options['store_last_n'] : 10;
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
		if ( $count > $store_limit ) {
			$wpdb->query( $wpdb->prepare( "DELETE FROM $table_name ORDER BY notification_time ASC LIMIT %d", $count - $store_limit ) );
		}

		update_option( 'ticker_notifications_last_updated', current_time( 'mysql' ) );

		return array(
			'success' => true,
			'message' => 'Notification stored successfully',
		);
	}

	private static function generate_notification_message( $event_type, $data ) {
		$options = get_option( 'ticker_notifications_options', array() );
		$template = '';

		switch ( $event_type ) {
			case 'item_sold':
				$template = $options['notification_sold'] ?? '{product_name} sold to {user_name} at {company_location}';
				break;
			case 'item_dispatched':
				$template = $options['notification_dispatched'] ?? '{product_name} dispatched to {user_name} at {shipping_address}';
				break;
			case 'item_delivered':
				$template = $options['notification_delivered'] ?? '{product_name} delivered to {user_name} at {shipping_address}';
				break;
			default:
				return '';
		}

		// Replace placeholders with actual data.
		$placeholders = array(
			'{product_name}' => $data['product_name'],
			'{user_name}' => isset( $data['user_name'] ) ? $data['user_name'] : 'Unknown',
			'{company_location}' => isset( $data['company_location'] ) ? $data['company_location'] : 'Unknown',
			'{shipping_address}' => isset( $data['shipping_address'] ) ? $data['shipping_address'] : 'Unknown',
		);

		return str_replace( array_keys( $placeholders ), array_values( $placeholders ), $template );
	}
}
