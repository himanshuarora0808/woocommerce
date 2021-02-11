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
 * @package    Dropbox_product_images
 * @subpackage Dropbox_product_images/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dropbox_product_images
 * @subpackage Dropbox_product_images/includes
 * @author     Himanshu Arora <himanshuarora@cedcoss.com>
 */
class Dropbox_product_images_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dropbox_product_images',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
