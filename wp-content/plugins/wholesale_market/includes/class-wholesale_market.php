<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/includes
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
 * @package    Wholesale_market
 * @subpackage Wholesale_market/includes
 * author     Himanshu Arora <himanshuarora@cedcoss.com>
 */
class Wholesale_Market {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * access   protected
	 * @var      Wholesale_market_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * access   protected
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
		if ( defined( 'WHOLESALE_MARKET_VERSION' ) ) {
			$this->version = WHOLESALE_MARKET_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wholesale_market';

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
	 * - Wholesale_market_Loader. Orchestrates the hooks of the plugin.
	 * - Wholesale_market_i18n. Defines internationalization functionality.
	 * - Wholesale_market_Admin. Defines all hooks for the admin area.
	 * - Wholesale_market_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wholesale_market-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wholesale_market-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wholesale_market-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wholesale_market-public.php';

		$this->loader = new Wholesale_market_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wholesale_market_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wholesale_market_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wholesale_market_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// hook for adding new setting tab
		$this->loader->add_filter( 'woocommerce_settings_tabs_array', $plugin_admin, 'add_settings_tab', 10 );

		// hook for adding subsection in wholesale settings section
		$this->loader->add_action( 'woocommerce_sections_wholesale', $plugin_admin, 'ced_add_subsection_wholesalemarket' );

		// hook for outputting the checkbox and radio button
		$this->loader->add_action( 'woocommerce_settings_wholesale', $plugin_admin, 'output' );

		// hook for saving the checkbox and radio button
		$this->loader->add_action( 'woocommerce_settings_save_wholesale', $plugin_admin, 'save' );

		// hook for adding wholesale price field in products edit
		$this->loader->add_action( 'woocommerce_product_options_pricing', $plugin_admin, 'ced_add_wholesaleprice_product' );

		// hook to save wholesale price field in db
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'ced_save_wholesaleprice_product' );

		// hook to add custom column in user table
		$this->loader->add_action( 'manage_users_columns', $plugin_admin, 'ced_add_custom_column' );

		// hook to add custom fields in variable product's variation
		$this->loader->add_action( 'woocommerce_variation_options_pricing', $plugin_admin, 'ced_add_customfields_variable_variation', 10, 3 );

		// hook to save wholesale price and min quantity of variation field in db
		$this->loader->add_action( 'woocommerce_save_product_variation', $plugin_admin, 'ced_save_wholesaleprice_and_min_quantity_variation', 1, 2 );

		// hook for adding custom checkbox for making user wholesale customer
		$this->loader->add_action( 'personal_options', $plugin_admin, 'ced_user_edit_checkbox' );

		// hook for adding approve button on wholesale user column
		$this->loader->add_action( 'manage_users_custom_column', $plugin_admin, 'ced_add_button_wholesale_column', 0, 3 );

		// hook to change customer's role in user table
		$this->loader->add_action( 'manage_users_extra_tablenav', $plugin_admin, 'ced_change_customer_role_wholesale_column' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wholesale_market_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// hook to add checkbox on user registration page for wholesale customer option
		$this->loader->add_action( 'woocommerce_register_form_start', $plugin_public, 'register_form_checkbox' );

		// hook to save register checkbox value
		$this->loader->add_action( 'woocommerce_created_customer', $plugin_public, 'ced_save_wholesale_checkbox_register' );

		// hook to display wholesale price on shop page
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'ced_shop_page_display_wholesale' );

		// hook to display wholesale price for all variation
		$this->loader->add_filter( 'woocommerce_available_variation', $plugin_public, 'ced_display_variation_wholesale', 10, 3 );

		// hook to modify cart price with wholesale price
		$this->loader->add_filter( 'woocommerce_before_calculate_totals', $plugin_public, 'ced_change_price_to_wholesale' );

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
	 * @return    Wholesale_market_Loader    Orchestrates the hooks of the plugin.
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
