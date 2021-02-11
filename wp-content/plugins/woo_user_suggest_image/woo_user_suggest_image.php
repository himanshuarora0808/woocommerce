<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.cedcoss.com/
 * @since             1.0.0
 * @package           Woo_user_suggest_image
 *
 * @wordpress-plugin
 * Plugin Name:       User Suggest Image
 * Plugin URI:        https://www.cedcoss.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            CEDCOSS
 * Author URI:        https://www.cedcoss.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo_user_suggest_image
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
define( 'WOO_USER_SUGGEST_IMAGE_VERSION', '1.0.0' );
define( 'WOO_USER_SUGGEST_IMAGE_VERSION_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WOO_USER_SUGGEST_IMAGE_VERSION_PLUGIN_URL', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo_user_suggest_image-activator.php
 */
function activate_woo_user_suggest_image() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo_user_suggest_image-activator.php';
	Woo_user_suggest_image_Activator::ced_create_folder_suggest_image();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo_user_suggest_image-deactivator.php
 */
function deactivate_woo_user_suggest_image() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo_user_suggest_image-deactivator.php';
	Woo_user_suggest_image_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_user_suggest_image' );
register_deactivation_hook( __FILE__, 'deactivate_woo_user_suggest_image' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo_user_suggest_image.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_user_suggest_image() {

	$plugin = new Woo_user_suggest_image();
	$plugin->run();

}
run_woo_user_suggest_image();
