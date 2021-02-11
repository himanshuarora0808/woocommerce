<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.cedcoss.com/
 * @since      1.0.0
 *
 * @package    Woo_user_suggest_image
 * @subpackage Woo_user_suggest_image/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_user_suggest_image
 * @subpackage Woo_user_suggest_image/includes
 * @author     CEDCOSS <Abhishekpandey@cedcoss.com>
 */
class Woo_user_suggest_image {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_user_suggest_image_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOO_USER_SUGGEST_IMAGE_VERSION' ) ) {
			$this->version = WOO_USER_SUGGEST_IMAGE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woo_user_suggest_image';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_user_suggest_image_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_user_suggest_image_i18n. Defines internationalization functionality.
	 * - Woo_user_suggest_image_Admin. Defines all hooks for the admin area.
	 * - Woo_user_suggest_image_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo_user_suggest_image-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo_user_suggest_image-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo_user_suggest_image-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo_user_suggest_image-public.php';

		$this->loader = new Woo_user_suggest_image_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_user_suggest_image_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_user_suggest_image_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woo_user_suggest_image_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'ced_setting_page_for_user_suggest_image' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woo_user_suggest_image_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	// FOR text Feild
		// $this->loader->add_action( 'woocommerce_before_add_to_cart_button', $plugin_public, 'ced_show_the_textbox_suggest_upload_file' );
		// $this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_public, 'ced_the_textbox_product_add_on_cart_item_data' , 10, 2 );
		// $this->loader->add_filter( 'woocommerce_get_item_data', $plugin_public, 'ced_the_textbox_product_add_on_display_cart' , 10, 2);
		// $this->loader->add_action( 'woocommerce_add_order_item_meta', $plugin_public, 'ced_the_textbox_product_add_on_display_cart' , 10, 2);
		// $this->loader->add_filter( 'woocommerce_order_item_product', $plugin_public, 'ced_the_textbox_product_add_on_display_order' , 10, 4);
		// $this->loader->add_action( 'woocommerce_after_order_itemmeta', $plugin_public, 'ced_show_the_textdata_content_order',10);
	

	// for uploads image 
		$this->loader->add_action( 'woocommerce_before_add_to_cart_button', $plugin_public, 'ced_display_additional_product_fields', 9 );
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_public, 'ced_add_custom_fields_data_as_custom_cart_item_data', 10, 2 );
		$this->loader->add_filter( 'woocommerce_get_item_data', $plugin_public, 'ced_display_custom_item_data' , 10, 2 );
		$this->loader->add_filter( 'woocommerce_before_calculate_totals', $plugin_public, 'ced_change_the_product_price', 10 );
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_public, 'ced_custom_field_update_order_item_meta',20, 4);
		$this->loader->add_action( 'woocommerce_after_order_itemmeta', $plugin_public, 'ced_backend_image_link_after_order_itemmeta',10, 3);

		// for checkout costmization
			// add_filter( 'woocommerce_checkout_fields' , 'ced_remove_the_checkout_feilds' );
		$this->loader->add_filter( 'woocommerce_default_address_fields', $plugin_public, 'ced_rename_last_name_feild_checkout_page', 9999 );
		$this->loader->add_filter( 'woocommerce_checkout_fields', $plugin_public, 'ced_remove_the_checkout_feilds' );

		// add_filter( 'woocommerce_default_address_fields' , 'ced_rename_last_name_feild_checkout_page', 9999 );
	
		// -------------------------------------------------------
		// add_filter ( 'woocommerce_account_menu_items', 'ced_create_custom_link_myaccount_page', 40 );
		$this->loader->add_filter( 'woocommerce_account_menu_items', $plugin_public, 'ced_create_custom_link_myaccount_page', 40 );
		$this->loader->add_action( 'init', $plugin_public, 'ced_endpoint_for_custom_link_myaccount',10, 3);
		$this->loader->add_action( 'woocommerce_account_order-history_endpoint', $plugin_public, 'ced_my_account_endpoint_content');

		// -------------------------------------------------------
		// add_action( 'init', 'ced_endpoint_for_custom_link_myaccount' );
		// add_action( 'woocommerce_account_order-history_endpoint', 'misha_my_account_endpoint_content' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_user_suggest_image_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
