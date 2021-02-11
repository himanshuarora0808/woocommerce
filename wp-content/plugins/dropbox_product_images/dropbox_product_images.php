<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.cedcommerce.com
 * @since             1.0.0
 * @package           Dropbox_product_images
 *
 * @wordpress-plugin
 * Plugin Name:       Dropbox for Product Images
 * Plugin URI:        www.cedcommerce.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Himanshu Arora
 * Author URI:        www.cedcommerce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dropbox_product_images
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DROPBOX_PRODUCT_IMAGES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dropbox_product_images-activator.php
 */
function activate_dropbox_product_images() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropbox_product_images-activator.php';
	Dropbox_product_images_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dropbox_product_images-deactivator.php
 */
function deactivate_dropbox_product_images() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropbox_product_images-deactivator.php';
	Dropbox_product_images_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dropbox_product_images' );
register_deactivation_hook( __FILE__, 'deactivate_dropbox_product_images' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dropbox_product_images.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dropbox_product_images() {

	$plugin = new Dropbox_product_images();
	$plugin->run();

}
run_dropbox_product_images();
