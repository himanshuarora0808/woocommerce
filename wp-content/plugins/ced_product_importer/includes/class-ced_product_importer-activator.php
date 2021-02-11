<?php

/**
 * Fired during plugin activation
 *
 * @link       www.cedcommerce.com
 * @since      1.0.0
 *
 * @package    Ced_product_importer
 * @subpackage Ced_product_importer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ced_product_importer
 * @subpackage Ced_product_importer/includes
 * @author     Himanshu Arora <himanshuarora@cedcoss.com>
 */
class Ced_product_importer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$upload = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		
		$upload_dir = $upload_dir . '/product_import_uploads';
		// die($upload_dir);
		if (! is_dir($upload_dir)) {
			mkdir( $upload_dir, 0700 );
		}


		$upload_folder = wp_upload_dir();
		$upload_dir_path = $upload_folder['basedir'];
		
		$upload_dir_path = $upload_dir_path . '/product_order_uploads';
		// die($upload_dir);
		if (! is_dir($upload_dir_path)) {
			mkdir( $upload_dir_path, 0700 );
		}
	}

}
