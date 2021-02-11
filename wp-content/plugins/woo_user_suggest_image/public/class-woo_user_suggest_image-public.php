<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woo_user_suggest_image
 * @subpackage Woo_user_suggest_image/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_user_suggest_image
 * @subpackage Woo_user_suggest_image/public
 * @author     CEDCOSS <Abhishekpandey@cedcoss.com>
 */
class Woo_user_suggest_image_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Woo_user_suggest_image_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_user_suggest_image_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo_user_suggest_image-public.css', array(), $this->version, 'all' );

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
		 * defined in Woo_user_suggest_image_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_user_suggest_image_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo_user_suggest_image-public.js', array( 'jquery' ), $this->version, false );

	}
	

	
	/**
	 * Ced_show_the_textbox_suggest_ulpoad_file
	 *
	 * @return void
	 */
	public function ced_show_the_textbox_suggest_upload_file() {
		if('user_suggest_enable' == get_option('ced_user_image_suggestion_setting')) {

			$value = isset( $_POST['custom_text_add_on'] ) ? sanitize_text_field( $_POST['custom_text_add_on'] ) : '';
			echo '<div><label>Custom Text Add-On</label><p><input name="custom_text_add_on" value="' . $value . '"></p></div>';

		}
			
	}

		
	/**
	 * ced_the_textbox_product_add_on_cart_item_data
	 *
	 * @param  mixed $cart_item
	 * @param  mixed $product_id
	 * @return void
	 */
	public function ced_the_textbox_product_add_on_cart_item_data( $cart_item, $product_id ){
		// var_dump($cart_item);

		if( isset( $_POST['custom_text_add_on'] ) ) {

			$cart_item['custom_text_add_on'] = sanitize_text_field( $_POST['custom_text_add_on'] );
	
		}
		return $cart_item;
	
	}


		
	/**
	 * ced_the_textbox_product_add_on_display_cart
	 *
	 * @param  mixed $data
	 * @param  mixed $cart_item
	 * @return void
	 */
	public function ced_the_textbox_product_add_on_display_cart( $data, $cart_item ) {

		if ( isset( $cart_item['custom_text_add_on'] ) ){
	
			$data[] = array(
	
				'name' => 'Custom Text Add-On',
	
				'value' => sanitize_text_field( $cart_item['custom_text_add_on'] )
	
			);
	
		}
	
		return $data;
	
	}
	

		
	/**
	 * ced_the_textbox_product_add_on_order_item_meta
	 *
	 * Description : Save custom input field value into order item meta
	 * @param  mixed $item_id
	 * @param  mixed $values
	 * @return void
	 */
	public function ced_the_textbox_product_add_on_order_item_meta( $item_id, $values ) {
	
		if ( ! empty( $values['custom_text_add_on'] ) ) {
	
			wc_add_order_item_meta( $item_id, 'Custom_Text_Add-On', $values['custom_text_add_on'], true );
	
		}
	
	}

		
	/**
	 * ced_the_textbox_product_add_on_display_order
	 * Description : Display custom input field value into order table
	 * @param  mixed $cart_item
	 * @param  mixed $order_item
	 * @return void
	 */
	public function ced_the_textbox_product_add_on_display_order( $cart_item, $order_item ){
	
		if( isset( $order_item['custom_text_add_on'] ) ){
	
			$cart_item['custom_text_add_on'] = $order_item['custom_text_add_on'];
	
		}
	
		return $cart_item;
	
	}

	public function ced_show_the_textdata_content_order( $cart_object ) {
		var_dump($cart_object);
		echo "yewidgushac";	
		foreach ( $cart_object as $hash => $value ) {
			print_r($value);
		}
		// // 	// $data = ($value ['custom_text_add_on']);
		// // 	// if(!empty($data)) {
		// // 	// 	// $price = $value['data']->get_price();
		// // 	// 	// $extended_price = $price + 10;
		// // 	// 	// $value['data']->set_price( $extended_price);
		// // 	// 	return $data;
		// // 	// }
		// }
		// if ( isset( $cart_item['custom_text_add_on'] ) ){
		// 	$value = sanitize_text_field( $cart_item['custom_text_add_on'] );
		// 	echo $value;
		// }
	}

	

	

//###################-------------------#######################----------------------################-----------------------

										// for image   					

//###################-------------------#######################----------------------################-----------------------
	
	/**
	 * Display additional product fields (+ jQuery code)
	 *
	 * @return void
	 */
	public function ced_display_additional_product_fields(){
		if('user_suggest_enable' == get_option('ced_user_image_suggestion_setting')) { 
			?>
			<p class="form-row" id="image" >
				<label for="file_field"><?php echo __("Upload Image") . ': '; ?>
					<input type='file' name='image' accept='image/*'>
				</label>
			</p>
			<?php
		}
	}

	
	/**
	 * Add custom fields data as the cart item custom data
	 *
	 * @param  mixed $cart_item
	 * @param  mixed $product_id
	 * @return void
	 */
	public function ced_add_custom_fields_data_as_custom_cart_item_data( $cart_item, $product_id ){
		if( isset($_FILES['image']) && ! empty($_FILES['image']) ) {
			$upload       = wp_upload_bits( $_FILES['image']['name'], null, file_get_contents( $_FILES['image']['tmp_name'] ) );
			$filetype     = wp_check_filetype( basename( $upload['file'] ), null );
			$upload_dir   = wp_upload_dir();
			$upl_base_url = is_ssl() ? str_replace('http://', 'https://', $upload_dir['baseurl']) : $upload_dir['baseurl'];
			$base_name    = basename( $upload['file'] );

			$cart_item['file_upload'] = array(
				'guid'      => $upl_base_url .'/'. _wp_relative_upload_path( $upload['file'] ), // Url
				'file_type' => $filetype['type'], // File type
				'file_name' => $base_name, // File name
				'title'     => ucfirst( preg_replace('/\.[^.]+$/', '', $base_name ) ), // Title
			);
			$cart_item['unique_key'] = md5( microtime().rand() ); // Avoid merging items
		}
		return $cart_item;
	}

	/**
	 * Display custom cart item data in cart (optional)
	 *
	 * @param  mixed $cart_item_data
	 * @param  mixed $cart_item
	 * @return void
	 */
	public function ced_display_custom_item_data( $cart_item_data, $cart_item ) {
		if ( isset( $cart_item['file_upload']['title'] ) ){
			$cart_item_data[] = array(
				'name' => __( 'Image uploaded', 'woocommerce' ),
				'value' =>  str_pad($cart_item['file_upload']['title'], 16, 'X', STR_PAD_LEFT) . '…',
			);
		}
		return $cart_item_data;
	}

 
	public function ced_change_the_product_price( $cart_object ) {
		foreach ( $cart_object->get_cart() as $hash => $value ) {
			$data = ($value ['file_upload']['title']);
			if(!empty($data)) {
				$price = $value['data']->get_price();
				$extended_price = $price + 10;
				$value['data']->set_price( $extended_price);
			}
		}
	}

	/**
	 * Save Image data as order item meta data
	 *
	 * @param  mixed $item
	 * @param  mixed $cart_item_key
	 * @param  mixed $values
	 * @param  mixed $order
	 * @return void
	 */
	public function ced_custom_field_update_order_item_meta( $item, $cart_item_key, $values, $order ) {
		if ( isset( $values['file_upload'] ) ){
			$item->update_meta_data( '_img_file',  $values['file_upload'] );
		}
	}


	/**
	 * Admin orders: Display a linked button + the link of the image file	
	 *
	 * @param  mixed $item_id
	 * @param  mixed $item
	 * @param  mixed $product
	 * @return void
	 */
	public function ced_backend_image_link_after_order_itemmeta( $item_id, $item, $product ) {
		// Only in backend for order line items (avoiding errors)
		if( is_admin() && $item->is_type('line_item') && $file_data = $item->get_meta( '_img_file' ) ){
			echo '<p><a href="'.$file_data['guid'].'" target="_blank" class="button">'.__("Open Image") . '</a></p>'; 
			// echo '<p><code>'.$file_data['guid'].'</code></p>'; // Optional
		}
	}





	// task 2


 
	public function ced_rename_last_name_feild_checkout_page( $fields ) {
		$fields['first_name']['label'] = 'Full Name';
		return $fields;
	}

	public function ced_remove_the_checkout_feilds( $fields ) {
		unset($fields['billing']['billing_last_name']['validate']);
		unset($fields['billing']['billing_last_name']);
		unset($fields['billing']['billing_company']['validate']);
		unset($fields['billing']['billing_company']);
		unset($fields['billing']['billing_address_2']);
		unset($fields['billing']['billing_country']['validate']);
		unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_state']['validate']);
		unset($fields['billing']['billing_state']);
		unset($fields['billing']['billing_phone']['validate']);
		unset($fields['billing']['billing_phone']);

		unset($fields['shipping']['shipping_last_name']['validate']);
		unset($fields['shipping']['shipping_last_name']);
		unset($fields['shipping']['shipping_company']['validate']);
		unset($fields['shipping']['shipping_company']);
		unset($fields['shipping']['shipping_address_2']);
		unset($fields['shipping']['shipping_country']['validate']);
		unset($fields['shipping']['shipping_country']);
		unset($fields['shipping']['shipping_state']['validate']);
		unset($fields['shipping']['shipping_state']);
		unset($fields['shipping']['shipping_phone']['validate']);
		unset($fields['shipping']['shipping_phone']);
	
		return $fields;
	}


	// closing of task 2

	// __________________________________________________________________________________________________

		
	/**
	 * ced_create_custom_link_myaccount_page
	 * Discription : for create a custom menu in my account page
	 * 
	 * @param  mixed $menu_links
	 * @return void
	 */
	public function ced_create_custom_link_myaccount_page( $menu_links ){
	
		$menu_links = array_slice( $menu_links, 0, 5, true ) 
		+ array( 'order-history' => 'Order History' )
		+ array_slice( $menu_links, 5, NULL, true );
	
		return $menu_links;
	
	}
	
	public function ced_endpoint_for_custom_link_myaccount() {
		add_rewrite_endpoint( 'order-history', EP_PAGES );
	}
	
	public function ced_my_account_endpoint_content() {
		global $woocommerce;
		$cuid = get_current_user_id();
		$customer_orders = get_posts( array(
			'meta_key'    => '_customer_user',
			'meta_value'  => $cuid,
			'post_type'   => 'shop_order',
			'post_status' => array_keys( wc_get_order_statuses() ),
			'numberposts' => -1
		));
		echo '<table>';
		foreach($customer_orders as $key => $val) {
			$order_id = $val->ID;
			$order = wc_get_order($order_id);
			$total = $order->get_total();
			$status = $order->get_status();
			foreach ( $order->get_items() as $item_id => $item ) {
				$name = $item->get_name();
				echo '<tr><td>'.$name."</td>";
				echo '<td>'.$total."</td>";
				echo '<td>'.$status."</td></tr>";
			}
		}
		echo '</table>';					
	}
	// =------------=--------=----------------=--------------------------------------------------========
}
