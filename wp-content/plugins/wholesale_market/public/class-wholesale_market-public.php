<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/public
 * author     Himanshu Arora <himanshuarora@cedcoss.com>
 */
class Wholesale_Market_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wholesale_market-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wholesale_market-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register_form_checkbox
	 * 22-01-2021
	 * Adding a checkbox on registration page to make wholesale customer
	 *
	 * @return void
	 */
	public function register_form_checkbox() {      ?>
		<label>
			<input  name="wholesaleuser" type="checkbox" id="wholesaleuser" value="wholesale" /> <span><?php esc_html_e( 'Register as a Wholesale Customer', 'woocommerce' ); ?></span>
		</label>
		<label>
			<input type="hidden" id="register_wholesale_nonce" value='<?php echo esc_html( wp_create_nonce( 'register_nonce' ) ); ?>'>
		</label>
		<?php

	}

	/**
	 * Ced_save_wholesale_checkbox_register
	 * 22-01-2021
	 * Saving the checkbox value to db
	 *
	 * @param  mixed $user_id
	 * @return void
	 */
	public function ced_save_wholesale_checkbox_register( $user_id ) {
		if ( isset( $_POST['register_wholesale_nonce'] ) && wp_verify_nonce( sanitize_text_field( isset( $_POST['register_whoelsale_nonce'] ) ), 'register_nonce' ) ) {
			$check = isset( $_POST['wholesaleuser'] ) ? 'wholesale' : 'normal';
			update_user_meta( isset( $user_id ), 'Register_wholesale_user', isset( $check ) );
		}

	}



	/**
	 * Ced_shop_page_display_wholesale
	 * 23-01-2021
	 * Displaying the wholesale price on shop page
	 *
	 * @return void
	 */
	public function ced_shop_page_display_wholesale() {
		global $product;
		$type         = $product->get_type();
		$prod_id      = get_the_ID();
		$checkbox     = get_option( 'wholesale_checkbox' );
		$radio_button = get_option( 'radio_buttons' );
		if ( 'yes' == $checkbox && 'all_user' == $radio_button ) {
			if ( 'simple' == $type ) {
				$wholesale_price = get_post_meta( $prod_id, '_wholesale_price', true );
				echo '<b>Wholesale Price: £</b>' . esc_html( $wholesale_price );

			}
			if ( 'variable' == $type ) {
				$variable_wholesale_price = get_post_meta( get_the_ID() + 1, 'variable_wholesale_price', true );
				echo ' <b>Wholesale Price: £</b> ' . esc_html( $variable_wholesale_price );
			}
		}

	}

	/**
	 * Ced_display_variation_wholesale
	 * 23-01-2021
	 * Display wholesale price for every variation
	 *
	 * @param  mixed $variation_data
	 * @param  mixed $product
	 * @param  mixed $variation
	 * @return void
	 */
	public function ced_display_variation_wholesale( $variation_data, $product, $variation ) {
		$type = $product->get_type();
		if ( 'variable' == $type ) {
			$variation_price               = get_post_meta( $variation_data['variation_id'], 'variable_wholesale_price', true );
			$variation_quantity            = get_post_meta( $variation_data['variation_id'], 'variable_min_quantity', true );
			$variation_data['price_html'] .= ' <span class="price-suffix">' . __( 'Add ' . $variation_quantity . ' into cart to avail wholesale price £' . $variation_price, 'woocommerce' ) . '</span>';
		}

		return $variation_data;
	}

	/**
	 * Ced_change_price_to_wholesale
	 * 25-01-2021
	 * Changing the cart price with wholesale price if min quantity,
	 * to apply wholesale price is achieved.
	 *
	 * @param  mixed $cart_data
	 * @return void
	 */
	public function ced_change_price_to_wholesale( $cart_data ) {
		foreach ( $cart_data->get_cart() as $cart => $data ) {
			$prod_type          = $data['data']->get_type();
			$min_quantity_check = get_option( 'invetory_checkbox' );
			$cart_quantity      = $data['quantity'];
			$min_quantity_radio = get_option( 'inventory_radio_buttons' );
			if ( 'simple' == $prod_type ) {
				if ( 'yes' == $min_quantity_check && 'all_product' == $min_quantity_radio ) {
					$product_id                 = $data['product_id'];
					$minimun_wholesale_quantity = get_option( 'common_min_quantity' );
					$apply_wholesale_price      = get_post_meta( $product_id, '_wholesale_price', true );
					if ( $cart_quantity >= $minimun_wholesale_quantity ) {
						$data['data']->set_price( $apply_wholesale_price );
					}
				} else {
					$product_id                 = $data['product_id'];
					$minimun_wholesale_quantity = get_post_meta( $product_id, '_min_quantity', true );
					$apply_wholesale_price      = get_post_meta( $product_id, '_wholesale_price', true );
					if ( $cart_quantity >= $minimun_wholesale_quantity ) {
						$data['data']->set_price( $apply_wholesale_price );
					}
				}
			} elseif ( 'variation' == $prod_type ) {
				if ( 'yes' == $min_quantity_check && 'all_product' == $min_quantity_radio ) {
					$product_id                 = $data['variation_id'];
					$minimun_wholesale_quantity = get_option( 'common_min_quantity' );
					$apply_wholesale_price      = get_post_meta( $product_id, 'variable_wholesale_price', true );
					if ( $cart_quantity >= $minimun_wholesale_quantity ) {
						$data['data']->set_price( $apply_wholesale_price );
					}
				} else {
					$product_id                 = $data['variation_id'];
					$minimun_wholesale_quantity = get_post_meta( $product_id, 'variable_min_quantity', true );
					$apply_wholesale_price      = get_post_meta( $product_id, 'variable_wholesale_price', true );
					if ( $cart_quantity >= $minimun_wholesale_quantity ) {
						$data['data']->set_price( $apply_wholesale_price );
					}
				}
			}
		}
		return $cart_data;

	}
}
