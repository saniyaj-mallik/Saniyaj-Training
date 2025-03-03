<?php
/**
 * Plugin Name: Ticker Notifications
 * Description: A custom plugin to handle and display ticker notifications from an eCommerce site.
 * Version: 1.0
 * Author: Saniyaj Mallik
 * Author URI: https://saniyajmallik.vercel.app
 * Requires at least: 6.6
 * Requires PHP: 7.4
 *
 * @package Ticker Notifications
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the plugin constants.
define( 'TICKER_NOTIFICATIONS_VERSION', '1.0' );
define( 'TICKER_NOTIFICATIONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'TICKER_NOTIFICATIONS_URL', plugin_dir_url( __FILE__ ) );

// Include the required files.
require_once TICKER_NOTIFICATIONS_PATH . 'includes/class-ticker-notifications-activation.php';
require_once TICKER_NOTIFICATIONS_PATH . 'includes/class-ticker-notifications-settings.php';
require_once TICKER_NOTIFICATIONS_PATH . 'includes/class-ticker-notifications-api.php';

// Activation and deactivation hooks.
register_activation_hook( __FILE__, array( 'Ticker_Notifications_Activation', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Ticker_Notifications_Activation', 'deactivate' ) );

/**
 * Initializes the Ticker Notifications plugin.
 *
 * This function triggers the initialization of the settings class and optionally the API class
 * to set up the plugin's functionality within WordPress.
 *
 * @since 1.0.0
 */
function ticker_notifications_init() {
	Ticker_Notifications_Settings::init();
	Ticker_Notifications_API::init();
}
add_action( 'plugins_loaded', 'ticker_notifications_init' );

/**
 * Enqueues frontend scripts and styles for Ticker Notifications.
 *
 * Registers and enqueues the CSS and JavaScript files needed for the ticker
 * notifications functionality, and passes PHP variables to the JavaScript
 * environment using wp_localize_script.
 *
 * @return void
 */
function ticker_notifications_enqueue_scripts() {
	// Define the assets URL using the plugin constant.
	$plugin_url = TICKER_NOTIFICATIONS_URL . 'assets/';

	// Enqueue the stylesheet.
	wp_enqueue_style(
		'ticker-notifications-css',
		$plugin_url . 'css/ticker-notifications.css',
		array(),
		TICKER_NOTIFICATIONS_VERSION
	);

	// Enqueue the JavaScript file with jQuery dependency.
	wp_enqueue_script(
		'ticker-notifications-js',
		$plugin_url . 'js/ticker-notifications.js',
		array( 'jquery' ),
		TICKER_NOTIFICATIONS_VERSION,
		true
	);

	// Retrieve plugin options.
	$options = get_option( 'ticker_notifications_options', array() );

	// Get display duration from options, default to 3 seconds if not set.
	$display_duration = isset( $options['display_duration'] ) ? (int) $options['display_duration'] : 3;

	// Pass settings to JavaScript.
	wp_localize_script(
		'ticker-notifications-js',
		'tickerNotificationsSettings',
		array(
			'displayDuration' => $display_duration * 1000,
			'nonce' => wp_create_nonce( 'ticker_notifications_nonce' ),
		)
	);
}

// Hook the function into WordPress enqueue system.
add_action( 'wp_enqueue_scripts', 'ticker_notifications_enqueue_scripts' );



// Shortcode for frontend display.
add_shortcode( 'ticker_notifications', 'ticker_notifications_shortcode' );

/**
 * Renders the ticker notifications list via shortcode.
 *
 * Queries the database for stored notifications and generates HTML markup
 * to display them in a list format. Supports options for randomization
 * and limiting the number of displayed notifications.
 *
 * @return string HTML content of the notifications list.
 */
function ticker_notifications_shortcode() {
	ob_start();
	?>
	<div class="ticker-notifications-container">
		<h3 class="container-heading">Recent Orders</h3>
		<hr>
		<ul class="ticker-notifications-list">
			<!-- Notifications will be dynamically inserted here -->
		</ul>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ticker_notifications', 'ticker_notifications_shortcode' );

/**
 * Summary of fetch_ticker_notifications.
 *
 * @return void
 */
function fetch_ticker_notifications() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'ticker_notifications';
	$options = get_option( 'ticker_notifications_options', array() );
	$store_limit = isset( $options['store_last_n'] ) ? (int) $options['store_last_n'] : 10;
	$randomize_order = isset( $options['randomize_order'] ) ? (bool) $options['randomize_order'] : false;

	$order_by = $randomize_order ? 'RAND()' : 'notification_time DESC';
	$notifications = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY $order_by LIMIT $store_limit" );
	$response = array(
		'notifications' => $notifications,
		'options' => $options,
	);
	wp_send_json( $response );
}
add_action( 'wp_ajax_fetch_ticker_notifications', 'fetch_ticker_notifications' );
add_action( 'wp_ajax_nopriv_fetch_ticker_notifications', 'fetch_ticker_notifications' );
