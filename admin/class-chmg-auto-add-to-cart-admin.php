<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/admin
 * @author     Uchenna Christian <nwachukwu16@gmail.com>
 */
class Chmg_Auto_Add_To_Cart_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook_suffix) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chmg_Auto_Add_To_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chmg_Auto_Add_To_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/chmg-auto-add-to-cart-admin.css', array(), $this->version, 'all' );
 
		if(strpos($hook_suffix, 'product_page_auto-add-to-cart-page') !== false) {
		 
			wp_enqueue_style( $this->plugin_name."-chosen-css", "https://harvesthq.github.io/chosen/chosen.css", array(), '', 'all' );
			wp_enqueue_style( $this->plugin_name."-data-table-css", "https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css", array(), '', 'all' );

		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook_suffix) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Chmg_Auto_Add_To_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chmg_Auto_Add_To_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/chmg-auto-add-to-cart-admin.js', array( 'jquery' ), $this->version, false );
		
		
		if(strpos($hook_suffix, 'product_page_auto-add-to-cart-page') !== false) {
 			wp_enqueue_script( $this->plugin_name."-chosen-js","//harvesthq.github.io/chosen/chosen.jquery.js", '', true );
 			wp_enqueue_script( $this->plugin_name."-data-table-js","https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js", '', time(), true );
		} 

	}


	public function aatc_admin_menu(){
		
		add_submenu_page( 
			'edit.php?post_type=product', 
			__('Auto Add to Cart', AATC_TEXT_DOMAIN), 
			__('Auto Add to Cart', AATC_TEXT_DOMAIN), 
			'manage_options', 
			'auto-add-to-cart-page', 
			[ $this, 'chmg_auto_add_to_cart_cb'] );

	}


	public function chmg_auto_add_to_cart_cb(){
		include_once( 'partials/chmg-auto-add-to-cart-admin-display.php' );
	}




}
