<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pickup_Shipping_Settings {

	public function __construct() {
		add_filter( 'woocommerce_get_sections_shipping', array ( $this, 'add_section' ) );
		add_filter( 'woocommerce_get_settings_shipping', array( $this, 'add_settings' ), 10, 2 );
		add_action( 'woocommerce_admin_field_pickup_stores', array( $this, 'pickup_stores_field' ) );
		add_action( 'woocommerce_update_option_pickup_stores', array( $this, 'save_pickup_stores' ) );
	}

	public function add_section( $sections ) {
		$sections['pickup_shipping'] = __( 'Pickup Stores', 'woocommerce' );
		return $sections;
	}

	public function add_settings( $settings, $current_section ) {
		if ( 'pickup_shipping' === $current_section ) {
			$settings = array(
				array(
					'title' => __( 'Pickup Stores', 'woocommerce' ),
					'type' => 'title',
					'id' => 'pickup_shipping_options',
				),
				array(
					'type' => 'pickup_stores',
					'id' => 'pickup_shipping_stores',
				),
				array(
					'type' => 'sectionend',
					'id' => 'pickup_shipping_options',
				),
			);
		}
		return $settings;
	}

	public function pickup_stores_field() {
		$stores = get_option( 'pickup_shipping_stores', array() );
		?>
		<tr valign="top">
			<th scope="row" class="titledesc"><?php esc_html_e( 'Stores', 'woocommerce' ); ?></th>
			<td class="forminp">

			<!-- add sortable ui here -->
				<div id="pickup-stores">
					<?php foreach ( $stores as $index => $store ) : ?>
						<div class="pickup-store-row" data-index="<?php echo $index ; ?>">
							<input type="text" name="pickup_store_name[]" value="<?php echo esc_attr( $store['name'] ); ?>" placeholder="Store Name">
							<input type="text" name="pickup_store_location[]" value="<?php echo esc_attr( $store['location'] ); ?>" placeholder="Store Location (Google Maps URL)">
							<!-- <button type="button" class="button cancel-store-row"> cancel</button> -->
							<button type="button" class="button cancel-store-row"><?php esc_html_e( 'Cancel', 'woocommerce' ); ?></button>
						</div>
					<?php endforeach; ?>
				</div>
				<button type="button" id="add-pickup-store" class="button"><?php esc_html_e( 'Add Store', 'woocommerce' ); ?></button>
			</td>
		</tr>
		<?php
	}

	public function save_pickup_stores() {
		if ( isset( $_POST['pickup_store_name'] ) && isset( $_POST['pickup_store_location'] ) ) {
			$stores = array();
			foreach ( $_POST['pickup_store_name'] as $index => $name ) {
				$stores[] = array(
					'name' => sanitize_text_field($name),
					'location' => esc_url_raw( $_POST['pickup_store_location'][$index] ),
				);
			}
			update_option( 'pickup_shipping_stores', $stores );
		}
	}
}