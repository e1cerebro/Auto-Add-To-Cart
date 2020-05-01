<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Chmg_Auto_Add_To_Cart
 *
 * @wordpress-plugin
 * Plugin Name:       Auto Add To Cart
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Uchenna Christian
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       chmg-auto-add-to-cart
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
define( 'CHMG_AUTO_ADD_TO_CART_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-chmg-auto-add-to-cart-activator.php
 */
function activate_chmg_auto_add_to_cart() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chmg-auto-add-to-cart-activator.php';
	Chmg_Auto_Add_To_Cart_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-chmg-auto-add-to-cart-deactivator.php
 */
function deactivate_chmg_auto_add_to_cart() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chmg-auto-add-to-cart-deactivator.php';
	Chmg_Auto_Add_To_Cart_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_chmg_auto_add_to_cart' );
register_deactivation_hook( __FILE__, 'deactivate_chmg_auto_add_to_cart' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-chmg-auto-add-to-cart.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_chmg_auto_add_to_cart() {

	$plugin = new Chmg_Auto_Add_To_Cart();
	$plugin->run();

}
run_chmg_auto_add_to_cart();
