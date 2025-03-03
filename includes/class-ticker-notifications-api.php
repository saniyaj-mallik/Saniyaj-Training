<?php
/**
 * Ticker notification Rest Api.
 *
 * @package Ticker Notification
 * @since 1.0.0
 */

/**
 * Ticker Notifications API Class
 *
 * Handles REST API endpoints for managing ticker notifications in WordPress.
 * Provides functionality to receive, validate, store, and manage notification data.
 *
 * @package Ticker_Notifications
 * @since 1.0.0
 * @author xAI
 */
class Ticker_Notifications_API {
	/**
	 * Initializes the API by hooking into WordPress REST API initialization.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
	}

	/**
	 * Registers REST API routes for notification handling.
	 *
	 * @return void
	 */
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

	/**
	 * Handles incoming notification requests.
	 *
	 * Validates authentication token, processes notification data,
	 * stores it in the database, and manages storage limits.
	 *
	 * @param WP_REST_Request $request The REST API request object.
	 * @return array|WP_Error Response array on success or WP_Error on failure.
	 */
	public static function handle_notification( $request ) {
		$options = get_option( 'ticker_notifications_options', array() );
		$auth_token = isset( $options['auth_token'] ) ? $options['auth_token'] : '';

		// Validate authentication token from headers.
		$header_token = $request->get_header( 'Authorization' );
		if ( empty( $header_token ) || $auth_token !== $header_token ) {
			return new WP_Error( 'invalid_token', 'Invalid or missing authentication token', array( 'status' => 401 ) );
		}

		$data = $request->get_params();
		$required_fields = array( 'event_type', 'product_name', 'user_name', 'price', 'company_location', 'shipping_address' );
		foreach ( $required_fields as $field ) {
			if ( empty( $data[ $field ] ) ) {
				return new WP_Error( 'missing_data', 'Missing required field: ' . $field, array( 'status' => 400 ) );
			}
		}

		// Store notification in database.
		global $wpdb;
		$table_name = $wpdb->prefix . 'ticker_notifications';

		$result = $wpdb->insert(
			$table_name,
			array(
				'event_type' => $data['event_type'],
				'user_name' => $data['user_name'],
				'product_name' => $data['product_name'],
				'product_hyperlink' => isset( $data['product_hyperlink'] ) ? $data['product_hyperlink'] : null,
				'price' => isset( $data['price'] ) ? floatval( $data['price'] ) : null,
				'company_location' => isset( $data['company_location'] ) ? $data['company_location'] : null,
				'shipping_address' => isset( $data['shipping_address'] ) ? $data['shipping_address'] : null,
				'supplier_address' => isset( $data['supplier_address'] ) ? $data['supplier_address'] : null,
				'supplier_amount' => isset( $data['supplier_amount'] ) ? floatval( $data['supplier_amount'] ) : null,
				'employee_initials' => isset( $data['employee_initials'] ) ? $data['employee_initials'] : null,
				'authorization_group' => isset( $data['authorization_group'] ) ? $data['authorization_group'] : null,
			),
			array( '%s', '%s', '%s', '%s', '%f', '%s', '%s', '%s', '%f', '%s', '%s' )
		);

		if ( false === $result ) {
			return new WP_Error( 'storage_error', 'Failed to store notification', array( 'status' => 500 ) );
		}

		update_option( 'ticker_notifications_last_updated', current_time( 'mysql' ) );

		return array(
			'success' => true,
			'message' => 'Notification stored successfully',
			'result' => $result,
		);
	}
}
