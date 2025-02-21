<?php
/**
 * Plugin Name: WooCommerce Pickup Shipping Method
 * Description: Adds a custom "Pickup" shipping method to WooCommerce with store location and pickup date selection.
 * Version: 1.0
 * Author: Saniyaj Mallik
 * Author URI: https://saniyajmallik.vercel.app
 * Requires at least: 6.6
 * Requires PHP: 7.4
 *
 * @package Woocommerce Pickup Shipping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Check if WooCommerce is active.
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	// Include the shipping method class.
	add_action( 'woocommerce_shipping_init', 'pickup_shipping_method_init' );

	function pickup_shipping_method_init() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/class-pickup-shipping-method.php';

		$pickup_shipping_method = new Pickup_Shipping_Method();
	}

	// Add the shipping method to WooCommerce.
	add_filter( 'woocommerce_shipping_methods', 'add_pickup_shipping_method' );
	function add_pickup_shipping_method( $methods ) {
		$methods['pickup_shipping_method'] = 'Pickup_Shipping_Method';
		return $methods;
	}

	// Include the admin settings class.
	add_action( 'plugins_loaded', 'pickup_shipping_settings_init' );
	function pickup_shipping_settings_init() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-pickup-shipping-settings.php';
		new Pickup_Shipping_Settings();
	}

	// Enqueue admin scripts and styles.
	add_action( 'admin_enqueue_scripts', 'pickup_shipping_admin_scripts' );
	function pickup_shipping_admin_scripts( $hook ) {
		if ( 'woocommerce_page_wc-settings' === $hook ) {
			wp_enqueue_script( 'pickup-shipping-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', array( 'jquery', 'jquery-ui-sortable' ), '1.0', true );
			wp_enqueue_style( 'pickup-shipping-admin', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', array(), '1.0' );
		}
	}
}
