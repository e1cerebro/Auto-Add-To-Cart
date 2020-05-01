<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/includes
 * @author     Uchenna Christian <nwachukwu16@gmail.com>
 */
class Chmg_Auto_Add_To_Cart_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'chmg-auto-add-to-cart',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
