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

	// Add Pickup Store and Date Fields to Checkout Page
	add_action('woocommerce_after_checkout_billing_form', 'add_pickup_store_selection', 11);
	function add_pickup_store_selection() {
		// if ($method->id === 'pickup_shipping_method') {
			// Get saved stores from the database
			$stores = get_option('pickup_shipping_stores', array());

			if (!empty($stores)) {
				echo '<div class="pickup-store-selection">';
				echo '<label for="pickup-store">' . __('Select Store:', 'woocommerce') . '</label>';
				echo '<select name="pickup_store" id="pickup-store" required>';
				echo '<option value="">' . __('Select a store', 'woocommerce') . '</option>';
				foreach ($stores as $store) {
					echo '<option value="' . esc_attr($store['name']) . '">' . esc_html($store['name']) . '</option>';
				}
				echo '</select>';
				echo '</div>';
			}

			// Add pickup date field
			echo '<div class="pickup-date-selection">';
			echo '<label for="pickup-date">' . __('Pickup Date:', 'woocommerce') . '</label>';
			echo '<input type="date" name="pickup_date" id="pickup-date" min="' . date('Y-m-d') . '" max="' . date('Y-m-d', strtotime('+1 month')) . '" required>';
			echo '</div>';
		// }
	}
}


