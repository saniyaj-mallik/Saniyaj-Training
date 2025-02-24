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
	/**
	 * Enqueues admin scripts and styles for the pickup shipping settings page.
	 *
	 * This function checks if the current page is the WooCommerce settings page
	 * and enqueues the necessary JavaScript and CSS files for the pickup shipping method.
	 *
	 * @since 1.0.0
	 * @hook admin_enqueue_scripts
	 * @return void
	 */
	function pickup_shipping_method_init() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/class-pickup-shipping-method.php';

		$pickup_shipping_method = new Pickup_Shipping_Method();
	}

	// Add the shipping method to WooCommerce.
	add_filter( 'woocommerce_shipping_methods', 'add_pickup_shipping_method' );
	/**
	 * Adds custom shipping methods to WooCommerce.
	 *
	 * @param array $methods Existing shipping methods.
	 * @return array Modified shipping methods.
	 */
	function add_pickup_shipping_method( $methods ) {
		$methods['pickup_shipping_method'] = 'Pickup_Shipping_Method';
		return $methods;
	}

	// Include the admin settings class.
	add_action( 'plugins_loaded', 'pickup_shipping_settings_init' );
	/**
	 * Initializes the pickup shipping settings.
	 *
	 * This function includes the necessary class file and initializes the
	 * `Pickup_Shipping_Settings` class to set up the pickup shipping method settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function pickup_shipping_settings_init() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-pickup-shipping-settings.php';
		new Pickup_Shipping_Settings();
	}

	// Enqueue admin scripts and styles.
	add_action( 'admin_enqueue_scripts', 'pickup_shipping_admin_scripts' );
	/**
	 * Enqueues admin scripts and styles for the pickup shipping settings page.
	 *
	 * This function checks if the current page is the WooCommerce settings page
	 * and enqueues the necessary JavaScript and CSS files for the pickup shipping method.
	 *
	 * @since 1.0.0
	 * @param string $hook The current admin page hook.
	 * @return void
	 */
	function pickup_shipping_admin_scripts( $hook ) {
		if ( 'woocommerce_page_wc-settings' === $hook ) {
			wp_enqueue_script( 'pickup-shipping-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', array( 'jquery', 'jquery-ui-sortable' ), '1.0', true );
			wp_enqueue_style( 'pickup-shipping-admin', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', array(), '1.0' );
		}
	}

	// Add Pickup Store and Date Fields to Checkout Page.
	add_action( 'woocommerce_after_checkout_billing_form', 'add_pickup_store_selection', 11 );
	/**
	 * Displays a pickup store selection dropdown and a pickup date input field.
	 *
	 * This function retrieves saved pickup stores from the database and generates
	 * a dropdown for selecting a store. It also adds a date input field for selecting
	 * a pickup date, with a minimum date of today and a maximum date of one month from today.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function add_pickup_store_selection() {

		// Get saved stores from the database.
		$stores = get_option( 'pickup_shipping_stores', array() );

		if ( ! empty( $stores ) ) {
			echo '<div class="pickup-store-selection">';
			echo '<label for="pickup-store">' . esc_html_e( 'Select Store:', 'woocommerce' ) . '</label>';
			echo '<select name="pickup_store" id="pickup-store" required>';
			echo '<option value="">' . esc_html_e( 'Select a store', 'woocommerce' ) . '</option>';
			foreach ( $stores as $store ) {
				echo '<option value="' . esc_attr( $store['name'] ) . '">' . esc_html( $store['name'] ) . '</option>';
			}
			echo '</select>';
			echo '</div>';
		}

			// Add pickup date field.
		echo '<div class="pickup-date-selection">';
		echo '<label for="pickup-date">' . esc_html_e( 'Pickup Date:', 'woocommerce' ) . '</label>';
		echo '<input type="date" name="pickup_date" id="pickup-date" min="' . gmdate( 'Y-m-d' ) . '" max="' . gmdate( 'Y-m-d', strtotime( '+1 month' ) ) . '" required>';
		echo '</div>';
	}

	// Validate Pickup Store and Date Selection( need to fix bug ).

	add_action( 'woocommerce_checkout_process', 'validate_pickup_store_and_date' );
	/**
	 * Validates the pickup store and date selection during checkout.
	 *
	 * This function checks if the selected shipping method is "pickup_shipping_method".
	 * If so, it ensures that a pickup store and pickup date have been selected.
	 * If either field is missing, an error notice is added to the checkout process.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function validate_pickup_store_and_date() {
		if ( empty( $_POST['pickup_store'] ) ) {
			wc_add_notice( 'Please select a pickup Store.', 'error' );
		}
		if ( empty( $_POST['pickup_date'] ) ) {
			wc_add_notice( 'Please select a pickup Date.', 'error' );
		}
	}


	// Save Pickup Store and Date as Order Meta.
	add_action( 'woocommerce_checkout_update_order_meta', 'save_pickup_store_and_date' );
	/**
	 * Saves the selected pickup store and pickup date as order meta data.
	 *
	 * This function checks if the pickup store and pickup date are set in the $_POST data.
	 * If they are, it sanitizes the values and saves them as meta data for the given order.
	 *
	 * @since 1.0.0
	 * @param int $order_id The ID of the order being processed.
	 * @return void
	 */
	function save_pickup_store_and_date( $order_id ) {
		if ( isset( $_POST['pickup_store'] ) ) {
			update_post_meta( $order_id, '_pickup_store', sanitize_text_field( $_POST['pickup_store'] ) );
		}
		if ( isset($_POST['pickup_date'] ) ) {
			update_post_meta( $order_id, '_pickup_date', sanitize_text_field( $_POST['pickup_date'] ) );
		}
	}

	// Display Pickup Store and Date in Order Details (need to fix bug ).
	// Display in admin order details.
	add_action( 'woocommerce_admin_order_data_after_shipping_address', 'display_pickup_details_in_admin', 10, 1 );
	/**
	 * Displays the pickup store and pickup date in the WooCommerce admin order details page.
	 *
	 * This function retrieves the pickup store and pickup date from the order meta data
	 * and displays them in the admin order details page if they exist.
	 *
	 * @since 1.0.0
	 * @hook woocommerce_admin_order_data_after_billing_address
	 * @param WC_Order $order The WooCommerce order object.
	 * @return void
	 */
	function display_pickup_details_in_admin( $order ) {
		$pickup_store = get_post_meta( $order->get_id(), '_pickup_store', true );
		$pickup_date = get_post_meta( $order->get_id(), '_pickup_date', true );

		if ( $pickup_store ) {
			echo '<p><strong>' . esc_html( 'Pickup Store:', 'woocommerce' ) . '</strong> ' . esc_html( $pickup_store ) . '</p>';
		}
		if ( $pickup_date ) {
			echo '<p><strong>' . esc_html( 'Pickup Date:', 'woocommerce' ) . '</strong> ' . esc_html( $pickup_date ) . '</p>';
		}
	}

	// Display in customer order details.
	add_action( 'woocommerce_order_details_after_order_table', 'display_pickup_details_in_order', 10, 1 );
	/**
	 * Displays the pickup store and pickup date in the WooCommerce order details page.
	 *
	 * This function retrieves the pickup store and pickup date from the order meta data
	 * and displays them in the order details page if they exist.
	 *
	 * @since 1.0.0
	 * @hook woocommerce_order_details_after_order_table
	 * @param WC_Order $order The WooCommerce order object.
	 * @return void
	 */
	function display_pickup_details_in_order( $order ) {
		$pickup_store = get_post_meta( $order->get_id(), '_pickup_store', true );
		$pickup_date = get_post_meta( $order->get_id(), '_pickup_date', true );

		if ( $pickup_store ) {
			echo '<p><strong>' . esc_html( 'Pickup Store:', 'woocommerce' ) . '</strong> ' . esc_html( $pickup_store ) . '</p>';
		}
		if ( $pickup_date ) {
			echo '<p><strong>' . esc_html( 'Pickup Date:', 'woocommerce' ) . '</strong> ' . esc_html( $pickup_date ) . '</p>';
		}
	}

	// Display in order confirmation email.
	add_filter( 'woocommerce_email_order_meta_fields', 'add_pickup_details_to_email', 10, 3 );
	/**
	 * Adds pickup store and pickup date details to WooCommerce email order details.
	 *
	 * This function retrieves the pickup store and pickup date from the order meta data
	 * and adds them to the email order details if they exist.
	 *
	 * @since 1.0.0
	 * @param array    $fields       The existing email order details fields.
	 * @param bool     $sent_to_admin Whether the email is being sent to the admin.
	 * @param WC_Order $order        The WooCommerce order object.
	 * @return array Modified email order details fields.
	 */
	function add_pickup_details_to_email( $fields, $sent_to_admin, $order ) {
		$pickup_store = get_post_meta( $order->get_id(), '_pickup_store', true );
		$pickup_date = get_post_meta( $order->get_id(), '_pickup_date', true );

		if ( $pickup_store ) {
			$fields['pickup_store'] = array(
				'label' => __( 'Pickup Store', 'woocommerce' ),
				'value' => $pickup_store,
			);
		}
		if ( $pickup_date ) {
			$fields['pickup_date'] = array(
				'label' => __( 'Pickup Date', 'woocommerce' ),
				'value' => $pickup_date,
			);
		}

		return $fields;
	}



	// Add Google Maps embed using share link on checkout page.
	add_action( 'woocommerce_after_checkout_billing_form', 'display_pickup_store_mini_map', 12 );
	/**
	 * Displays a mini Google Map for the selected pickup store on checkout using a share link.
	 *
	 * @return void
	 */
	function display_pickup_store_mini_map() {

		$stores = get_option( 'pickup_shipping_stores', array() );
		if ( empty( $stores ) ) {
			return;
		}

		$api_key = 'YOUR_GOOGLE_MAPS_API_KEY'; // Replace with your API key.
		wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $api_key, array(), null, true );

		?>
		<div class="pickup-store-map">
			<p><strong><?php esc_html_e( 'Pickup Location:', 'woocommerce' ); ?></strong></p>
			<div id="pickup-map-link" style="margin-bottom: 10px;"></div>
			<div id="pickup-map" style="width: 100%; height: 200px;"></div>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				var stores = <?php echo json_encode( $stores ); ?>;
				var $pickupStore = $('#pickup-store');
				var $mapLinkDiv = $('#pickup-map-link');

				function updateMap() {
					var selectedStore = $pickupStore.val();
					if (!selectedStore) {
						$mapLinkDiv.empty();
						$('#pickup-map').empty();
						return;
					}

					var store = stores.find(function(s) {
						return s.name === selectedStore;
					});

					if (store && store.location) {
						$mapLinkDiv.html('<a href="' + store.location + '" target="_blank"><?php esc_html_e( 'View on Google Maps', 'woocommerce' ); ?></a>' );

						// Fetch coordinates from the share link via AJAX or pre-resolve (simplified here)
						$.getJSON('https://api.allorigins.win/get?url=' + encodeURIComponent(store.location), function(data) {
							// This is a basic proxy; ideally, resolve server-side with API key
							var url = data.contents.match(/@([-.\d]+),([-.\d]+)/);
							if (url) {
								var lat = url[1];
								var lng = url[2];
								var map = new google.maps.Map(document.getElementById('pickup-map'), {
									center: { lat: parseFloat(lat), lng: parseFloat(lng) },
									zoom: 15,
									mapTypeId: 'roadmap'
								});
								new google.maps.Marker({
									position: { lat: parseFloat(lat), lng: parseFloat(lng) },
									map: map
								});
							} else {
								$('#pickup-map').html('<?php esc_html_e( 'Unable to load map', 'woocommerce' ); ?>');
							}
						}).fail(function() {
							$('#pickup-map').html('<?php esc_html_e( 'Unable to load map', 'woocommerce' ); ?>' );
						});
					} else {
						$mapLinkDiv.html( '<?php esc_html_e( 'Location not available', 'woocommerce' ); ?>' );
						$('#pickup-map').html( '<?php esc_html_e( 'Map not available', 'woocommerce' ); ?>' );
					}
				}

				updateMap();
				$pickupStore.on('change', updateMap);
			});
		</script>
		<?php
	}
	// google map ends here.
}
