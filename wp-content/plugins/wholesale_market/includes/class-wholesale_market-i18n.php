<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wholesale_market
 * @subpackage Wholesale_market/includes
 * author     Himanshu Arora <himanshuarora@cedcoss.com>
 */
class Wholesale_Market_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wholesale_market',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
