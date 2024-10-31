<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://loudbells.com
 * @since             1.0.0
 * @package           Products_Missing_Featured_Image
 *
 * @wordpress-plugin
 * Plugin Name:       Products Missing Featured Image
 * Plugin URI:        https://loudbells.com/?products-missing-featured-image
 * Description:       This plugin adds a link in Tools that lists all Products products that do not have a featured image set.
 * Version:           1.0.0
 * Author:            Loud Bells
 * Author URI:        https://loudbells.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       products-missing-featured-image
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
define( 'PRODUCTS_MISSING_FEATURED_IMAGE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-products-missing-featured-image-activator.php
 */
function activate_products_missing_featured_image() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-products-missing-featured-image-activator.php';
	Products_Missing_Featured_Image_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-products-missing-featured-image-deactivator.php
 */
function deactivate_products_missing_featured_image() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-products-missing-featured-image-deactivator.php';
	Products_Missing_Featured_Image_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_products_missing_featured_image' );
register_deactivation_hook( __FILE__, 'deactivate_products_missing_featured_image' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-products-missing-featured-image.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_products_missing_featured_image() {

	$plugin = new Products_Missing_Featured_Image();
	$plugin->run();

}
run_products_missing_featured_image();
