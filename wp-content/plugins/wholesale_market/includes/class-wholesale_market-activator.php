<?php

/**
 * Fired during plugin activation
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Wholesale_market
 * @subpackage Wholesale_market/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wholesale_market
 * @subpackage Wholesale_market/includes
 * author     Himanshu Arora <himanshuarora@cedcoss.com>
 */
class Wholesale_Market_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		if ( get_option( 'custom_roles' ) < 1 ) {
			add_role(
				'custom_role',
				'Wholesale User',
				array(
					'read'    => true,
					'level_0' => true,
				)
			);
			update_option( 'custom_roles', 'Wholesale User' );
		}

	}

}
