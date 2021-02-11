<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Dropbox_product_images
 * @subpackage Dropbox_product_images/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dropbox_product_images
 * @subpackage Dropbox_product_images/admin
 * @author     Himanshu Arora <himanshuarora@cedcoss.com>
 */
class Dropbox_product_images_Admin {

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
		 * defined in Dropbox_product_images_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dropbox_product_images_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dropbox_product_images-admin.css', array(), $this->version, 'all' );

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
		 * defined in Dropbox_product_images_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dropbox_product_images_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dropbox_product_images-admin.js', array( 'jquery' ), $this->version, false );

	}



	
	/**
	 * ced_add_dropbox_menu
	 * 02-02-2021
	 * Creating a custom menu page named Dropbox
	 * @return void
	 */
	public function ced_add_dropbox_menu(){
		add_menu_page( 
			__( 'Dropbox Linking', 'textdomain' ),
			'Dropbox Linking',
			'manage_options',
			'dropbox',
			 array($this,'ced_display_dropbox_menu'),
			'dashicons-camera-alt',
			8
		); 
	}

	/**
	 * ced_display_dropbox_menu
	 * 02-02-2021
	 * Diplaying content of dropbox menu
	 * @return void
	 */
	public function ced_display_dropbox_menu(){
		if(isset($_POST['save_authenticate'])){
			$appkey = $_POST['appkey'];
			$appsecret = $_POST['appsecret'];
			
		}
		if(isset($_GET['code'])){
			$auth_code = $_GET['code'];
			$redirect_url = 'http://localhost/woo_wordpress/wp-admin/admin.php?page=dropbox';
			$header = 'Authorization: Basic '.base64_encode($appkey.':'.$appsecret);
			print_r($header);
			$curl = curl_init();
			$auth_data[] = array(
				'code' 		=> $auth_code,
				'grant_type' => 'authorization_code',
				'redirect_uri' 		=> $redirect_url
			);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_data);
			curl_setopt($curl, CURLOPT_URL, 'https://www.dropbox.com/oauth2/token'.http_build_query($auth_data));
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			$result = curl_exec($curl);
			if(!$result){die("Connection Failure");}
			curl_close($curl);
			echo $result;
		}
		?>
		<form method="post">
		<label for="dropbox_settings"><b>Tick the box to enable dropbox setting on product edit</b></label><br>
		<input type="checkbox" name="dropbox_settings" id="dropbox_settings"><br>
		<label for="appkey"><b>Enter AppKey</b></label><br>
		<input type="input" name="appkey" id="appkey"><br>

		<label for="appsecret"><b>Enter AppSecret</b></label><br>
		<input type="input" name="appsecret" id="appsecret"><br>
		<input type="submit" name="save" id="save" value="Save">
		<input type="submit" name="authenticate" id="authenticate" value="Authenticate">
		<input type="hidden" name="auth_code" id="auth_code" value=<?php echo $auth_code;?>>
		</form>
		<?php 
	}

	
	/**
	 * ced_image_upload_dropbox
	 * 02-02-2021
	 * Adding a custom metabox named dropbox metabox in product's edit section
	 * @return void
	 */
	public function ced_image_upload_dropbox() {
        add_meta_box(
            'Dropbox Image',
            __( 'Dropbox Image', 'textdomain' ),
            array( $this, 'ced_render_metabox' ),
            'product',
            'advanced',
            'default'
        );
 
	}
	
	public function ced_render_metabox(){
		?>
		<input type="file" name="dropbox_image" id="dropbox_image">
		<input type="submit" name="upload_image" id="upload_image" value="Upload Image">
		<?php
	}
	
 
}
