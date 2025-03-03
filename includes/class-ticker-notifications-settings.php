<?php
/**
 * Ticker notification activation Class.
 *
 * @package Ticker Notification
 * @since 1.0.0
 */

/**
 * Handles the settings page and registration of settings for the Ticker Notifications plugin.
 *
 * This class adds a settings page to the WordPress admin menu, registers the settings,
 * and handles the saving of plugin options.
 */
class Ticker_Notifications_Settings {
	/**
	 * Initializes the Ticker Notifications settings by hooking into WordPress admin actions.
	 *
	 * This method sets up the admin menu page and registers the plugin's settings
	 * by attaching the appropriate methods to WordPress action hooks.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_admin_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}
	/**
	 * Adds the Ticker Notifications settings page to the WordPress admin menu.
	 *
	 * This method registers a top-level menu page in the WordPress admin dashboard,
	 * accessible to users with the 'manage_options' capability, using a bell icon.
	 *
	 * @since 1.0.0
	 */
	public static function add_admin_menu() {
		add_menu_page(
			'Ticker Notifications',
			'Ticker Notifications',
			'manage_options',
			'ticker-notifications',
			array( __CLASS__, 'settings_page' ),
			'dashicons-bell'
		);
	}
	/**
	 * Renders the Ticker Notifications settings page in the WordPress admin area.
	 *
	 * This method outputs the HTML for the settings page, including the page title
	 * and a form for managing plugin options, utilizing the WordPress Settings API.
	 *
	 * @since 1.0.0
	 */
	public static function settings_page() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?> </h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'ticker_notifications_settings' );
				do_settings_sections( 'ticker_notifications' );
				submit_button( 'Save Changes' );
				?>
			</form>
		</div>
		<?php
	}
	/**
	 * Registers settings, sections, and fields for the Ticker Notifications plugin.
	 *
	 * This method sets up the plugin's options group with sanitization, and defines
	 * two settings sections: one for notification templates and one for miscellaneous
	 * settings, each with their respective fields.
	 *
	 * @since 1.0.0
	 */
	public static function register_settings() {
		register_setting( 'ticker_notifications_settings', 'ticker_notifications_options', array( 'sanitize_callback' => array( __CLASS__, 'sanitize_options' ) ) );

		add_settings_section(
			'ticker_notifications_section',
			'Notification Templates',
			null,
			'ticker_notifications'
		);

		// Notification Templates.
		add_settings_field(
			'notification_sold',
			'Notification for "Item Sold":',
			array( __CLASS__, 'render_text_field' ),
			'ticker_notifications',
			'ticker_notifications_section',
			array( 'name' => 'notification_sold', 'placeholder' => '{product_name} sold to {user_name} at {company_location}' ),
		);

		add_settings_field(
			'notification_dispatched',
			'Notification for "Item Dispatched":',
			array( __CLASS__, 'render_text_field' ),
			'ticker_notifications',
			'ticker_notifications_section',
			array(
				'name' => 'notification_dispatched',
				'placeholder' => '{product_name} dispatched to {user_name} at {shipping_address}',
			),
		);

		add_settings_field(
			'notification_delivered',
			'Notification for "Item Delivered":',
			array( __CLASS__, 'render_text_field' ),
			'ticker_notifications',
			'ticker_notifications_section',
			array(
				'name' => 'notification_delivered',
				'placeholder' => '{product_name} delivered to {user_name} at {shipping_address}',
			),
		);

		// Miscellaneous Settings.
		add_settings_section(
			'ticker_notifications_misc',
			'Miscellaneous Settings',
			null,
			'ticker_notifications'
		);

		add_settings_field(
			'store_last_n',
			'Store Last "n" Notifications:',
			array( __CLASS__, 'render_number_field' ),
			'ticker_notifications',
			'ticker_notifications_misc',
			array(
				'name' => 'store_last_n',
				'min' => 1,
			),
		);

		add_settings_field(
			'display_duration',
			'Display each notification for',
			array( __CLASS__, 'render_number_field' ),
			'ticker_notifications',
			'ticker_notifications_misc',
			array(
				'name' => 'display_duration',
				'min' => 1,
				'suffix' => 'seconds',
			),
		);

		add_settings_field(
			'randomize_order',
			'Randomize Notification Order',
			array( __CLASS__, 'render_checkbox_field' ),
			'ticker_notifications',
			'ticker_notifications_misc',
			array(
				'name' => 'randomize_order',
			),
		);

		// Authentication Token.
		add_settings_field(
			'auth_token',
			'Authentication Token:',
			array( __CLASS__, 'render_text_field' ),
			'ticker_notifications',
			'ticker_notifications_misc',
			array(
				'name' => 'auth_token',
				'placeholder' => 'Enter a secure token',
			),
		);
	}
	/**
	 * Renders a text input field for the Ticker Notifications settings page.
	 *
	 * This method generates an HTML text input field, pre-populated with the saved option value,
	 * using the provided field name and placeholder from the arguments.
	 *
	 * @since 1.0.0
	 * @param array $args Arguments containing 'name' and 'placeholder' for the field.
	 */
	public static function render_text_field( $args ) {
		$options = get_option( 'ticker_notifications_options', array() );
		$value = isset( $options[ $args['name'] ] ) ? $options[ $args['name'] ] : '';
		?>
		<input type="text" name="ticker_notifications_options[<?php echo esc_attr( $args['name'] ); ?>]" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" class="regular-text">
		<?php
		// Add a "Generate Token" button for the auth_token field.
		if ( 'auth_token' === $args['name'] ) {
			?>
			<button type="button" id="generate-token-button" class="button">Generate Token</button>
			<script>
				document.getElementById('generate-token-button').addEventListener('click', function() {
					// Generate a random token (32 characters long)
					var token = Math.random().toString(36).substring(2) + Math.random().toString(36).substring(2);
					token = token.substring(0, 32); // Ensure it's 32 characters long
					// Set the generated token to the input field
					document.querySelector('input[name="ticker_notifications_options[auth_token]"]').value = token;
				});
			</script>
			<?php
		}
	}

	/**
	 * Renders a number input field for the Ticker Notifications settings page.
	 *
	 * This method generates an HTML number input field with a minimum value, pre-populated
	 * with the saved option value, and optionally appends a suffix (e.g., 'seconds').
	 *
	 * @since 1.0.0
	 * @param array $args Arguments containing 'name', 'min', and optional 'suffix' for the field.
	 */
	public static function render_number_field( $args ) {
		$options = get_option( 'ticker_notifications_options', array() );
		$value = isset( $options[ $args['name'] ] ) ? $options[ $args['name'] ] : '';
		?>
		<input type="number" name="ticker_notifications_options[<?php echo esc_attr( $args['name'] ); ?>]" value="<?php echo esc_attr( $value ); ?>" min="<?php echo esc_attr( $args['min'] ); ?>" class="small-text">
		<?php
			if ( ! empty( $args['suffix'] ) ) echo ' ' . esc_html( $args['suffix'] );
		?>
		<?php
	}
	/**
	 * Renders a checkbox input field for the Ticker Notifications settings page.
	 *
	 * This method generates an HTML checkbox input, checked if the saved option value is true,
	 * using the provided field name from the arguments.
	 *
	 * @since 1.0.0
	 * @param array $args Arguments containing 'name' for the field.
	 */
	public static function render_checkbox_field ( $args ) {
		$options = get_option( 'ticker_notifications_options', array() );
		$value = isset( $options[ $args['name'] ] ) ? $options[ $args['name'] ] : false;
		?>
		<input type="checkbox" name="ticker_notifications_options[<?php echo esc_attr( $args['name'] ); ?>]" value="1" <?php checked( $value, 1 ); ?>>
		<?php
	}
	/**
	 * Sanitizes the Ticker Notifications plugin options before saving.
	 *
	 * This method processes the input data, applying appropriate sanitization to each field:
	 * text fields are sanitized as strings, numbers as positive integers, and the checkbox as a boolean.
	 *
	 * @since 1.0.0
	 * @param array $input The raw input data from the settings form.
	 * @return array $output The sanitized options ready for storage.
	 */
	public static function sanitize_options( $input ) {
		$output = array();
		if ( isset( $input['notification_sold'] ) ) {
			$output['notification_sold'] = sanitize_text_field( $input['notification_sold'] );
		}
		if ( isset( $input['notification_dispatched'] ) ) {
			$output['notification_dispatched'] = sanitize_text_field( $input['notification_dispatched'] );
		}
		if ( isset( $input['notification_delivered'] ) ) {
			$output['notification_delivered'] = sanitize_text_field( $input['notification_delivered'] );
		}
		if ( isset( $input['store_last_n'] ) ) {
			$output['store_last_n'] = absint( $input['store_last_n'] );
		}
		if ( isset( $input['display_duration'] ) ) {
			$output['display_duration'] = absint( $input['display_duration'] );
		}
		if ( isset( $input['randomize_order'] ) ) {
			$output['randomize_order'] = (bool) $input['randomize_order'];
		}
		if ( isset( $input['auth_token'] ) ) {
			$output['auth_token'] = sanitize_text_field( $input['auth_token'] );
		}
		return $output;
	}
}
