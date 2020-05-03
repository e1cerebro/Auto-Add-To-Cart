<?php

/**
 * Fired during plugin activation
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/includes
 * @author     Uchenna Christian <nwachukwu16@gmail.com>
 */
class Chmg_Auto_Add_To_Cart_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		global $wpdb;

		$table = AATC_TABLE_NAME; 
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table ( 
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`target_ids` varchar(225) DEFAULT NULL,
				`type` varchar(225) DEFAULT NULL,
				`source_ids` varchar(225) DEFAULT NULL,
				`date_start` DATE DEFAULT NULL,
				`date_end` DATE DEFAULT NULL,
				`status` varchar(225) DEFAULT NULL,
				PRIMARY KEY (`id`)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}

}
