<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Chmg_Auto_Add_To_Cart
 * @subpackage Chmg_Auto_Add_To_Cart/public
 * @author     Uchenna Christian <nwachukwu16@gmail.com>
 */
class Chmg_Auto_Add_To_Cart_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/chmg-auto-add-to-cart-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/chmg-auto-add-to-cart-public.js', array( 'jquery' ), $this->version, false );

	}

	public function aatc_process_add_to_cart($cart_item_data, $product_id, $variation_id){
		require_once plugin_dir_path( __FILE__ ).'../utils/db-utils.php';

		$product_id = $variation_id ? $variation_id : $product_id;
 
		$prod_data = CPLC_DB_Utils::Fetch_aatc_specific_data($product_id);
		
		if(count($prod_data) < 1){
 			$prod_data = CPLC_DB_Utils::get_product_from_cats($product_id);
		} 

		$today 			= date("Y-m-d");
		$start_date 	= $prod_data[0]->start_date;
		$end_date  		= $prod_data[0]->end_date;
		$status			= $prod_data[0]->status;
		$coupon_code 	= $prod_data[0]->coupon_code;
		$quantity 		= $prod_data[0]->quantity;
 
		if(sizeof($prod_data) > 0 && $status === 'active' && $start_date <= $today ){

			if($end_date !== '0000-00-00' && $end_date < $today ) return;
 
			$product_ids = explode(",", $prod_data[0]->target_ids);

			foreach($product_ids as $id){

				$product_exists_in_cart = $this->aatc_product_in_cart($id);

				if($product_exists_in_cart) continue;

					WC()->cart->add_to_cart($id, $quantity);

					if($coupon_code){
						WC()->cart->add_discount( sanitize_text_field( $coupon_code ));
					}
			}
			return;
		}
 
	}


	public function aatc_product_in_cart($id){
		$product_cart_id = WC()->cart->generate_cart_id($id);
		$in_cart = WC()->cart->find_product_in_cart($product_cart_id);
		return $in_cart;
	}

}
