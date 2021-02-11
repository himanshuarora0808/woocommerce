<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Ced_product_importer
 * @subpackage Ced_product_importer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ced_product_importer
 * @subpackage Ced_product_importer/admin
 * @author     Himanshu Arora <himanshuarora@cedcoss.com>
 */
class Ced_product_importer_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);	

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
		 * defined in Ced_product_importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_product_importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ced_product_importer-admin.css', array(), $this->version, 'all' );

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
		 * defined in Ced_product_importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ced_product_importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ced_product_importer-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name,'product_files',array(
			'ajax_url' => admin_url('admin-ajax.php')
		));
	}
	
	/**
	 * ced_create_import_product_menu
	 * 27-01-2021
	 * Registering a custom admin menu named import product
	 * @return void
	 */
	public function ced_create_import_product_menu(){
		add_menu_page( 
			__( 'Import Product', 'textdomain' ),
			'Import Products',
			'manage_options',
			'import',
			 array($this,'ced_display_custom_menu'),
			'dashicons-cloud-upload',
			6
		); 
	}



	
	/**
	 * ced_display_custom_menu
	 * 27-01-2021
	 * Displaying the content inside menu page
	 * @return void
	 */
	public function ced_display_custom_menu(){
		?>
		<form method="POST" enctype="multipart/form-data" >
		<h3>Upload Product File</h3><br>
		<input type="file" name="file" id="file" multiple="multiple"><br>
		<input type="submit" name="upload" id="upload" value="Upload"><br>
		</form>
		<h3>Select File to Import products</h3>
		<select name="product_list" id="product_list">
		<?php
		$get_products=get_option('Import_products');
		foreach($get_products as $get=>$products):
			echo "<option id='options' value='".$products['filename']."'>".$products['filename']."</option>";
			
		endforeach;
		?>
		</select>
		<div id="content"></div>
		<?php
		if(isset($_POST['upload'])){
			$upload=wp_upload_dir();
			$upload_dir=$upload['basedir'];
			$filename = $_FILES['file']['name'];
			$temp_name =$_FILES['file']['tmp_name'];
			$path_filename = $upload_dir.'/product_import_uploads/'.$filename;
			if(file_exists($path_filename)){
				echo "File Already Exist";
			}
			else{
				move_uploaded_file($temp_name,$path_filename);
				echo "File Uploaded Successfully";
				$products = array();
				$products= get_option('Import_products');
				if($products==''){
					$products[] = array('filename' =>$filename, 'filepath' => $path_filename);
				}
				else{
					$products[]=array('filename' =>$filename, 'filepath' => $path_filename);
				}
				update_option('Import_products',$products);
			}
		}
	}

	
	/**
	 * ced_display_products_ajax
	 * 27-01-2021
	 * Displaying the content inside the json file using ajax and wp_list
	 * @return void
	 */
	public function ced_display_products_ajax(){
		$file =$_POST['send_file'];
		$upload=wp_upload_dir();
		$output=json_decode(file_get_contents($upload['basedir'].'/product_import_uploads/'.$file),1);
		require_once('partials/ced_product_importer-admin-display.php' );

		$varfobj = new Customers_List;
		$varfobj->items = $output;
		$varfobj->prepare_items();
		$varfobj->display();
	}

	
	/**
	 * ced_create_products_ajax
	 * Receiving file name and prod sku from page and creating a product with attributes in the product section 
	 * @return void
	 */
	public function ced_create_products_ajax(){
		$prod_sku = $_POST['prod_sku'];
		$get_content = $_POST['import_file'];
		$file_root = wp_upload_dir();
		$file_data = json_decode(file_get_contents($file_root['basedir'].'/product_import_uploads/'.$get_content),1);
		foreach($file_data as $key=>$value){
				if($value['item']['item_sku'] == $prod_sku){
					$author = get_current_user_id();
					global $wpdb;
					$check_product = $wpdb->get_col( $wpdb->prepare( "SELECT meta_value FROM $wpdb->postmeta
					 WHERE  meta_value='%s'", $prod_sku) );
					$product = array(
						'post_author'           => $author,
						'post_content'          => $value['item']['description'],
						'post_content_filtered' => '',
						'post_title'            => $value['item']['name'],
						'post_excerpt'          => '',
						'post_status'           => 'publish',
						'post_type'             => 'product',
						'post_mime_type'        => $value['item']['images'][0],
						'comment_status'        => 'closed',
						'ping_status'           => '',
						'post_password'         => '',
						'to_ping'               => '',
						'pinged'                => '',
						'post_parent'           => 0,
						'menu_order'            => 0,
						'guid'                  => '',
						'import_id'             => 0,
						'context'               => '',
					);
					
					if($check_product){
						echo "Product Already Exist";
					}
					else{
						$insert_product = wp_insert_post($product);
						if($insert_product){
							echo "Success";
						}
						if(isset($value['item']['sale_price'])){
							$sale_price = $value['item']['sale_price'];
						}
						else{
							$sale_price ='';
						}
						update_post_meta($insert_product,'_price',$value['item']['original_price']);
						update_post_meta($insert_product,'_regular_price',$value['item']['original_price']);
						update_post_meta($insert_product,'_sale_price',$sale_price);
						update_post_meta($insert_product,'_sku',$value['item']['item_sku']);
						update_post_meta($insert_product,'_stock',$value['item']['stock']);
						update_post_meta($insert_product,'_stock_status','instock ');
						update_post_meta($insert_product,'_downloadable','no');
						update_post_meta($insert_product,'_virtual','no');
						update_post_meta($insert_product,'_sold_individually','no');
						update_post_meta($insert_product,'_backorder','no');
						if($value['item']['has_variation']){
							wp_set_object_terms( $insert_product, 'variable', 'product_type');
							$this->ced_create_variable_attributes($insert_product,$value['tier_variation']);
							$this->ced_create_variable_variation($insert_product,$value['item']['variations'],$value['tier_variation']);
						}
						else{
							wp_set_object_terms( $insert_product, 'simple', 'product_type');
							$this->ced_product_attributes($insert_product,$value['item']['attributes']);
						}
					}
			}
			$this->ced_set_product_image($value['item']['images'][0],$insert_product);
		}
	}




	
	/**
	 * ced_product_attributes
	 * 29-01-2021
	 * Creating attributes for simple product
	 * @param  mixed $insert_product
	 * @param  mixed $attributes
	 * @return void
	 */
	public function ced_product_attributes($insert_product,$attributes){
		foreach($attributes as $attr){
			$attr_name = isset($attr['attribute_name'])?$attr['attribute_name']:'';
			$attr_value = isset($attr['attribute_value'])?$attr['attribute_value']:'';
		}
		$save[$attr_name]=array(
			'name' => $attr_name,
			'value' => $attr_value,
			'is_visible' => 1,
			'is_variaton' => 1,
			'is_taxonomy' =>0
		);
		update_post_meta($insert_product,'_product_attributes',$save);
	}

	
	/**
	 * ced_create_variable_attributes
	 * 29-01-2021
	 * Creating attributes for variable products
	 * @param  mixed $insert_product
	 * @param  mixed $variation_attr
	 * @return void
	 */
	public function ced_create_variable_attributes($insert_product,$variation_attr){
		foreach($variation_attr as $var=>$attr){
			$attr_name = isset($attr['name'])?$attr['name']:'';
			$attr_value = isset($attr['options'])?$attr['options']:'';
			$attr_imploded_value = implode('|',$attr_value);
			$save[$attr_name]=array(
				'name' => $attr_name,
				'value' => $attr_imploded_value,
				'is_visible' => 1,
				'is_variation' => 1,
				'is_taxonomy' =>0
			);
		}
		update_post_meta($insert_product,'_product_attributes',$save);
	}

	
	/**
	 * ced_create_variable_variation
	 * 30-01-2021
	 * Creating variable products variation
	 * @param  mixed $insert_product
	 * @param  mixed $varitions
	 * @param  mixed $tier_variation
	 * @return void
	 */
	public function ced_create_variable_variation($insert_product,$varitions,$tier_variation){
		foreach($varitions as $vars){
			$author=get_current_user_id();
			$price = $vars['price'];
			$name = $vars['name'];
			$sku = $vars['variation_sku'];
			$stock = $vars['stock'];
			$prods = array(
				'post_author'  => $author,
				'post_content' => $name,
				'post_title'  => $name,
				'post_status' => 'publish',
				'post_parent' => $insert_product,
				'post_type'   => 'product_variation'
			 );
			 $variation_id = wp_insert_post($prods);
			 update_post_meta($variation_id, '_regular_price', $price);
			 update_post_meta($variation_id, '_price', $price );
			 update_post_meta($variation_id, '_sku', $sku );
			 update_post_meta($variation_id, '_stock',$stock );
			 update_post_meta($variation_id,'_stock_status','instock');

			 foreach($tier_variation as $tier){
				 $attribute_name = $tier['name'];
				 foreach($tier['options'] as $values){
					 if($name == $values){
						 $attribute_value = $values;
					 }
				 }
				 update_post_meta($variation_id,'attribute_'.strtolower($attribute_name),$attribute_value);
			 }

		 }
		 WC_Product_Variable::sync($insert_product);
	}
	
	
	/**
	 * ced_set_product_image
	 * 01-02-2021
	 * setting images for every product
	 * @return void
	 */
	public function ced_set_product_image($image_path,$post_id){
		// Add Featured Image to Post
		$image_url        = $image_path; // Define the image URL here
		$image_name       = basename($image_url);
		$upload_dir       = wp_upload_dir(); // Set upload folder
		$image_data       = file_get_contents($image_url); // Get image data
		$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
		$filename         = basename( $unique_file_name ); // Create image file name

		// Check folder permission and define file location
		if( wp_mkdir_p( $upload_dir['path'] ) ) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}

		// Create the image  file on the server
		file_put_contents( $file, $image_data );

		// Check image file type
		$wp_filetype = wp_check_filetype( $filename, null );

		// Set attachment data
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name( $filename ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		// Create the attachment
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

		// Include image.php
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		// Define attachment metadata
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

		// Assign metadata to attachment
		wp_update_attachment_metadata( $attach_id, $attach_data );

		// And finally assign featured image to post
		set_post_thumbnail( $post_id, $attach_id );
	}

	public function ced_bulk_import(){
		$import_file = $_POST['import_file'];
		$bulk_product = $_POST['bulk_action'];
		$file_dir = wp_upload_dir();
		$file_data = json_decode(file_get_contents($file_dir['basedir'].'/product_import_uploads/'.$import_file));
		foreach($file_data as $file=>$data){
			foreach($bulk_product as $bulk=>$prod){

			}
			$data['item']['item_sku'];
		}
		
	}



	/**
	 * ced_create_order_menu
	 * 01-02-2021
	 * Registering a custom admin menu named orders
	 * @return void
	 */
	public function ced_create_order_menu(){
		add_menu_page( 
			__( 'Orders', 'textdomain' ),
			'Import Orders',
			'manage_options',
			'orders',
			 array($this,'ced_display_order_menu'),
			'dashicons-cart',
			10
		); 
	}

	
	/**
	 * ced_display_order_menu
	 * 01-02-2021
	 * Displaying order menu page content and uploading order file
	 * @return void
	 */
	public function ced_display_order_menu(){
		?>
		<form method="POST" enctype="multipart/form-data" >
		<h3>Upload Order File</h3><br>
		<input type="file" name="order" id="order" multiple="multiple"><br>
		<input type="submit" name="upload_order" id="upload_order" value="Upload File"><br>
		</form>
		<h3>Select File to Import orders</h3>
		<select name="order_list" id="order_list">
		<option id="default" value="default">Select file to import order</option>
		<?php
		$get_products=get_option('Import_orders');
		foreach($get_products as $get=>$products):
			echo "<option id='options' value='".$products['filename']."'>".$products['filename']."</option>";
			
		endforeach;
		?>
		</select>
		<div id="content"></div>
		<?php
		if(isset($_POST['upload_order'])){
			$upload=wp_upload_dir();
			$upload_dir=$upload['basedir'];
			$filename = $_FILES['order']['name'];
			$temp_name =$_FILES['order']['tmp_name'];
			$path_filename = $upload_dir.'/product_order_uploads/'.$filename;
			if(file_exists($path_filename)){
				echo "File Already Exist";
			}
			else{
				move_uploaded_file($temp_name,$path_filename);
				echo "File Uploaded Successfully";
				$products = array();
				$products= get_option('Import_orders');
				if($products==''){
					$products[] = array('filename' =>$filename, 'filepath' => $path_filename);
				}
				else{
					$products[]=array('filename' =>$filename, 'filepath' => $path_filename);
				}
				update_option('Import_orders',$products);
			}
		}
	}



	public function ced_create_order(){
		$order = $_POST['order_file'];
		$path = wp_upload_dir();
		global $wpdb;
		$order_data = json_decode(file_get_contents($path['basedir'].'/product_order_uploads/'.$order),1);
		foreach($order_data as $orderr=>$data){
			foreach($data['Order'] as $key=>$val){
				$name = $val['ShippingAddress']['Name'];
				$phone = $val['ShippingAddress']['Phone'];
				$post_code = $val['ShippingAddress']['PostalCode'];
				$street1 = $val['ShippingAddress']['Street1'];
				$city = $val['ShippingAddress']['CityName'];
				$state = $val['ShippingAddress']['Country'];
				$country = $val['ShippingAddress']['CountryName'];
				$address = array(
					'first_name' => $name,
					'company'    => '',
					'email'      => $email,
					'phone'      => $phone,
					'address_1'  => $street1,
					'address_2'  => '', 
					'city'       => $city,
					'state'      => $state,
					'postcode'   => $post_code,
					'country'    => $country
				);
				foreach($val['TransactionArray'] as $trans=>$array){
					foreach($array as $sku){
						$sku_check = ($sku['Item']['SKU']);
						
					}
				}
				$check_product = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM $wpdb->postmeta
				WHERE  meta_value='%s'", $sku_check) );
				$prods_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta
				WHERE  meta_value='%s'", $sku_check) );
				if($check_product){
					$order = wc_create_order();
					$order->set_address($address,'shipping');
					$order->set_address($address,'billing');
					$order->add_product( get_product($prods_id, 1 ));
					$order->calculate_totals();
					$order->update_status('completed', 'Imported order', TRUE);
					echo "Order Added Successfully";
				}
				else{
					echo "Product not available";
				}
			}
		}
	}
}
