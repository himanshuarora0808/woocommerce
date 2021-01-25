<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/admin
 */
class Wholesale_Market_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wholesale_market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wholesale_market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wholesale_market-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wholesale_market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wholesale_market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wholesale_market-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add_settings_tab
	 * 20-01-2021
	 * Adding a new setting tab into woocommerce settings
	 *
	 * @param  mixed $settings_tabs
	 * @return void
	 */
	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['wholesale'] = __( 'Wholesale', 'woocommerce-wholesale' );
		return $settings_tabs;
	}




	/**
	 * Ced_add_subsection_wholesalemarket
	 * 20-01-2021
	 * Adding subsection to wholesale market setting in woocommerce
	 *
	 * @param  mixed $settings_tab
	 * @return void
	 */
	public function ced_add_subsection_wholesalemarket() {
		global $current_section;

		$sections = array(
			''          => 'General',
			'inventory' => 'Inventory',
		);

		if ( empty( $sections ) || 1 === count( $sections ) ) {
			return;
		}

		echo '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			echo '<li><a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=wholesale&section=' . sanitize_title( $id ) ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . esc_html( $label ) . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}

		echo '</ul><br class="clear" />';
	}



	/**
	 * Set_settings
	 * 21-01-2021
	 * adding checkbox and radio button to general section in wholesale tab
	 *
	 * @param  mixed $current_section
	 * @return void
	 */
	public function set_settings( $current_section = '' ) {
		if ( 'inventory' == $current_section ) {

			$settings = array(

				array(
					'name' => __( 'Check the box to enable minimum quantity required to apply wholesale price', 'my-textdomain' ),
					'type' => 'title',
					'desc' => '',
					'id'   => 'myplugin_group1_options',
				),

				array(
					'type'    => 'checkbox',
					'id'      => 'invetory_checkbox',
					'name'    => __( 'Minimum quantity setting', 'my-textdomain' ),
					'desc'    => __( 'Enable to apply the minimun quantity setting', 'my-textdomain' ),
					'default' => 'no',
				),

				array(
					'type'    => 'radio',
					'id'      => 'inventory_radio_buttons',
					'name'    => __( 'Wholesale Price setting', 'my-textdomain' ),
					'desc'    => __( 'Wholesale Quantity Options', 'my-textdomain' ),
					'default' => '',
					'options' => array(
						'prod_level'  => 'Select to Set Min qty on product level',
						'all_product' => 'Select to apply common min qty for all products.',
					),
				),
				array(
					'name'              => __( 'Fill this field if you select the second radio button', 'woocommerce-settings-tab-demo' ),
					'type'              => 'number',
					'desc'              => __( 'Minimum Quantity', 'woocommerce-settings-tab-demo' ),
					'placeholder'       => 'Input minimum quantity required to apply wholesale price',
					'id'                => 'common_min_quantity',
					'value'             => get_option( 'common_min_quantity' ),
					'custom_attributes' => array(
						'step' => 'any',
						'min'  => '1',
					),
				),
				array(
					'type' => 'sectionend',
					'id'   => 'myplugin_group1_options',
				),

			);

		} else {
			$settings = array(

				array(
					'name' => __( 'Check the box to enable wholesale settings', 'my-textdomain' ),
					'type' => 'title',
					'desc' => '',
					'id'   => 'myplugin_group1_options',
				),

				array(
					'type'    => 'checkbox',
					'id'      => 'wholesale_checkbox',
					'name'    => __( 'Wholesale settings', 'my-textdomain' ),
					'desc'    => __( 'Enable to apply the wholesale setting', 'my-textdomain' ),
					'default' => 'no',
				),

				array(
					'type'    => 'radio',
					'id'      => 'radio_buttons',
					'name'    => __( 'Wholesale Price setting', 'my-textdomain' ),
					'desc'    => __( 'Wholesale Price Options', 'my-textdomain' ),
					'default' => '',
					'options' => array(
						'all_user'       => 'Select to display wholesale price to all user',
						'wholesale_user' => 'Select to display wholesale price to only wholesale customer',
					),
				),

				array(
					'type' => 'sectionend',
					'id'   => 'myplugin_group1_options',
				),

			);

		}
		return apply_filters( 'woocommerce_set_settings_', $settings, $current_section );
	}


	/**
	 * Output
	 * 21-01-2021
	 * Outputting the checkbox and radio button
	 *
	 * @return void
	 */
	public function output() {

		global $current_section;

		$settings = $this->set_settings( $current_section );
		WC_Admin_Settings::output_fields( $settings );

	}


	/**
	 * Save
	 * 21-01-2021
	 * saving the settings to the db
	 *
	 * @return void
	 */
	public function save() {

		global $current_section;

		if ( isset( $_POST['common_min_quantity'] ) > 1 ) {
			$settings = $this->set_settings( $current_section );
			WC_Admin_Settings::save_fields( $settings );
		}

	}

	/**
	 * Ced_add_wholesaleprice_product
	 * 21-01-2021
	 * Adding field for wholesale price in product's edit
	 *
	 * @return void
	 */
	public function ced_add_wholesaleprice_product() {
		global $woocommerce;
		woocommerce_wp_text_input(
			array(
				'id'                => '_wholesale_price',
				'value'             => get_post_meta( get_the_ID(), '_wholesale_price', true ),
				'label'             => __( 'Wholesale price', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
				'data_type'         => 'price',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '1',
				),

			)
		);
		woocommerce_wp_text_input(
			array(
				'id'                => '_min_quantity',
				'value'             => get_post_meta( get_the_ID(), '_min_quantity', true ),
				'label'             => __( 'Minimum Quantity', 'woocommerce' ) . '',
				'data_type'         => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '1',
				),

			)
		);

	}


	/**
	 * Ced_save_wholesaleprice_product
	 * 21-01-2021
	 * Saving value of wholesale price in product's edit
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function ced_save_wholesaleprice_product( $post_id ) {
		$wholesale_price = isset( $_POST['_wholesale_price'] );
		if ( ! empty( $wholesale_price ) && $wholesale_price > 1 && $wholesale_price < isset( $_POST['_regular_price'] ) ) {
			update_post_meta( $post_id, '_wholesale_price', esc_attr( $wholesale_price ) );
		}

		$min_quantity = isset( $_POST['_min_quantity'] );
		if ( ! empty( $min_quantity ) && $min_quantity > 1 ) {
			update_post_meta( $post_id, '_min_quantity', sanitize_text_field( $min_quantity ) );
		}
	}


	/**
	 * Ced_add_custom_column
	 * 21-01-2021
	 * Adding custom column in user table
	 *
	 * @param  mixed $column_headers
	 * @return void
	 */
	public function ced_add_custom_column( $column_headers ) {
		$column_headers['num_posts'] = 'Wholesale User';
		return $column_headers;
	}




	/**
	 * Ced_add_customfields_variable_variation
	 * 21-01-2021
	 * Adding custom fields to variable product's variation field
	 *
	 * @return void
	 */
	public function ced_add_customfields_variable_variation( $loop, $variation_data, $variation ) {
		 global $woocommerce;

		woocommerce_wp_text_input(
			array(
				'id'                => 'variable_wholesale_price[' . $loop . ']',
				'value'             => get_post_meta( $variation->ID, 'variable_wholesale_price', true ),
				'label'             => __( 'Wholesale price', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
				'data_type'         => 'price',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '1',
				),

			)
		);
			woocommerce_wp_text_input(
				array(
					'id'                => 'variable_min_quantity[' . $loop . ']',
					'value'             => get_post_meta( $variation->ID, 'variable_min_quantity', true ),
					'label'             => __( 'Minimum Quantity', 'woocommerce' ),
					'data_type'         => 'number',
					'custom_attributes' => array(
						'step' => 'any',
						'min'  => '1',
					),

				)
			);

	}


	/**
	 * Ced_save_wholesaleprice_and_min_quantity_variation
	 * 21-01-2021
	 * Saving value of wholesale price and min quantity in variable product's variation
	 *
	 * @param  mixed $post_id
	 * @return void
	 */
	public function ced_save_wholesaleprice_and_min_quantity_variation( $variation_id, $i ) {
		$wholesale_price_variation = isset( $_POST['variable_wholesale_price'][ $i ] );
		if ( ! empty( $wholesale_price_variation ) && $wholesale_price_variation > 1 ) {
			update_post_meta( $variation_id, 'variable_wholesale_price', sanitize_text_field( $wholesale_price_variation ) );
		}

		$min_quant_variation = isset( $_POST['variable_min_quantity'][ $i ] );
		if ( ! empty( $min_quant_variation ) && $min_quant_variation > 1 ) {
			update_post_meta( $variation_id, 'variable_min_quantity', sanitize_text_field( $min_quant_variation ) );
		}
	}


	/**
	 * Ced_user_edit_checkbox
	 * 21-01-2021
	 * Adding a custom checkbox to convert user to wholesale customer
	 *
	 * @return void
	 */
	public function ced_user_edit_checkbox() {      ?>
		<tr class="show-admin-bar user-admin-bar-front-wrap">
			<th scope="row"><?php esc_html_e( 'Make Wholesale Customer' ); ?></th>
			<td>
				<label for="wholesale_customer">
					<input name="wholesale_customer" type="checkbox" id="wholesale_customer" value="wholesale_check" />
					<?php esc_html_e( 'Make User a wholesale customer' ); ?>
				</label><br />
			</td>
		</tr>
		<?php
	}


	/**
	 * Ced_add_button_wholesale_column
	 * 22-01-2021
	 * Adding approve button on wholesale user column
	 *
	 * @return void
	 */
	public function ced_add_button_wholesale_column( $value, $column_name, $user_id ) {
		$user = get_userdata( $user_id );
		// print_r($user);
		if ( 'num_posts' == $column_name ) {
			if ( 1 == $user->caps['customer'] ) {
				$get          = $user->ID;
				$is_wholesale = get_user_meta( $get, 'Register_wholesale_user', true );
				if ( 'wholesale' == $is_wholesale ) {
					$value = "<form method='GET'><input type='submit' name='approve' id='approve' value='Approve'>
					<input type='hidden' name='hidden' value=" . $get . '></form>';
				}
			}
		}
		return $value;
	}


	/**
	 * Ced_change_customer_role_wholesale_column
	 * 22-01-2021
	 * Changing the role of customer to wholesale user,
	 * who has applied for the wholesale user role during regitration
	 *
	 * @return void
	 */
	public function ced_change_customer_role_wholesale_column() {
		$change_role_id = isset( $_GET['hidden'] );
		$detail_data    = new WP_User( sanitize_text_field( $change_role_id ) );
		$detail_data->remove_role( $detail_data->roles[0] );
		$detail_data->add_role( 'custom_role' );
		update_user_meta( $change_role_id, 'Register_wholesale_user', 'Approved' );

	}


}
