<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pickup_Shipping_Method extends WC_Shipping_Method {

	public function __construct( $instance_id = 0 ) {
		parent::__construct( $instance_id );
		$this->id = 'pickup_shipping_method';
		$this->method_title = __( 'Pickup Shipping', 'woocommerce' );
		$this->method_description = __( 'Allow customers to pick up their orders from selected stores.', 'woocommerce' );
		$this->supports = array( 'shipping-zones', 'instance-settings' );

		$this->init();
	}

	public function init() {
		$this->init_form_fields();
		$this->init_settings();

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title' => __( 'Enable/Disable', 'woocommerce' ),
				'type' => 'checkbox',
				'label' => __( 'Enable Pickup Shipping', 'woocommerce' ),
				'default' => 'yes',
			),
			'title' => array(
				'title' => __( 'Method Title', 'woocommerce' ),
				'type' => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
				'default' => __( 'Pickup', 'woocommerce' ),
				'desc_tip' => true,
			),
		);
	}
}
