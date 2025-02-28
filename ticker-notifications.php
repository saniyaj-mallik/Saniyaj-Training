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
