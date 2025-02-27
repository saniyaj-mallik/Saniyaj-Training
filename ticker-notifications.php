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
