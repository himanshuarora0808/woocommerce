<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woo_user_suggest_image
 * @subpackage Woo_user_suggest_image/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_user_suggest_image
 * @subpackage Woo_user_suggest_image/admin
 * @author     CEDCOSS <Abhishekpandey@cedcoss.com>
 */
class Woo_user_suggest_image_Admin {

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
		 * defined in Woo_user_suggest_image_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_user_suggest_image_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo_user_suggest_image-admin.css', array(), $this->version, 'all' );

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
		 * defined in Woo_user_suggest_image_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_user_suggest_image_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo_user_suggest_image-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function ced_setting_page_for_user_suggest_image() {
		add_menu_page( 'user-suggest-image', 'User Image Suggest', 'manage_options','user_suggest_image', array($this, 'ced_content_setting_page_for_user_suggest_image'),'dashicons-format-gallery', 4 );
	}

	public function ced_content_setting_page_for_user_suggest_image() {
		require_once WOO_USER_SUGGEST_IMAGE_VERSION_PLUGIN_PATH.'admin/partials/woo_user_suggest_image-admin-display.php';
	}

}
