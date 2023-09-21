<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://viderlab.com
 * @since      1.0.0
 *
 * @package    ViderLab_Customizations_for_Woocommerce
 * @subpackage ViderLab_Customizations_for_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    ViderLab_Customizations_for_Woocommerce
 * @subpackage ViderLab_Customizations_for_Woocommerce/public
 * @author     ViderLab
 */
class ViderLab_Customizations_for_Woocommerce_Public {

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
		 * defined in ViderLab_Customizations_for_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ViderLab_Customizations_for_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/viderlab-customizations-for-woocommerce-public.css', array(), $this->version, 'all' );

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
		 * defined in ViderLab_Customizations_for_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ViderLab_Customizations_for_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/viderlab-customizations-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Skip cart page a redirects to checkout.
	 *
	 * @return void.
	 */
	public function skip_wc_cart( $url ) {
		$options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
		if( isset($options['viderlab-customizations-for-woocommerce-settings_remove-cart']) ) {
			$url = wc_get_checkout_url();
		}

		return $url;
	}

	/**
	 * Clean cart before adding a new item.
	 *
	 * @return void.
	 */
	public function remove_cart_item_before_add_to_cart( $passed, $product_id, $quantity ) {
		$options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
		if( isset($options['viderlab-customizations-for-woocommerce-settings_empty-cart']) && 
				! WC()->cart->is_empty() )
			WC()->cart->empty_cart();
		return $passed;
	}

	/**
	 * Remove add to cart notification.
	 *
	 * @return string|bool.
	 */
	public function add_to_cart_message( $message, $products, $show_qty ) {
		$options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
		if( isset($options['viderlab-customizations-for-woocommerce-settings_remove-addtocart-message']) ) {
			$message = false;
		}

		return $message;
	}

	/**
	 * Change 'Add to cart' button text.
	 *
	 * @return string.
	 */
	public function addtocart_button_text($button_text) {
		$options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
		$text = $options['viderlab-customizations-for-woocommerce-settings_addtocart-text'];
		if( ! empty($text) )  {
			$button_text = $text;
		}
		return $button_text;
	}

	/**
	 * Remove My Account tabs. If 'dashboard'is not the default tab it removes it too.
	 *
	 * @return array.
	 */
	function remove_my_account_tabs($items) {
		$options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );

		$my_account_tabs = ['dashboard', 'orders', 'downloads', 'edit-address', 'members-area', 'payment-methods', 'edit-account', 'customer-logout'];
        foreach($my_account_tabs as $tab) {
			if(isset($options["viderlab-customizations-for-woocommerce-settings_remove-{$tab}-tab"]))
				unset($items[$tab]);
		}

		// If My Account default tab is redirected 'dashboard' must be removed
		if(isset($options["viderlab-customizations-for-woocommerce-settings_default-tab"]) && 
				$options["viderlab-customizations-for-woocommerce-settings_default-tab"] != 'dashboard') {
			unset($items['dashboard']);
		}

		return $items;
	}

	/**
	 * Redirect 'My Account'page to specific tab.
	 *
	 * @return array.
	 */
	public function my_account_redirect(){
		$options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );

		if ( is_account_page() && 
				isset($options["viderlab-customizations-for-woocommerce-settings_default-tab"]) && 
				$options["viderlab-customizations-for-woocommerce-settings_default-tab"] != 'dashboard' &&
				empty( WC()->query->get_current_endpoint() ) ) {
		   wp_safe_redirect( wc_get_account_endpoint_url( $options["viderlab-customizations-for-woocommerce-settings_default-tab"] ) );
		   exit;
		}
	}

	public function display_product_description( $atts ){
		$atts = shortcode_atts( array(
			'id' => get_the_id(),
		), $atts, 'viderlab_product_description' );
	
		global $product;
	
		if ( ! is_a( $product, 'WC_Product') )
			$product = wc_get_product($atts['id']);
	
		return $product ? $product->get_description() : null;
	}

	public function display_product_short_description( $atts ){
		$atts = shortcode_atts( array(
			'id' => get_the_id(),
		), $atts, 'viderlab_product_short_description' );
	
		global $product;
	
		if ( ! is_a( $product, 'WC_Product') )
			$product = wc_get_product($atts['id']);
	
		return $product ? $product->get_short_description() : null;
	}

	public function display_product_price( $atts ){
		$atts = shortcode_atts( array(
			'id' => get_the_id(),
		), $atts, 'viderlab_product_price' );

		global $product;

		if ( ! is_a( $product, 'WC_Product') )
			$product = wc_get_product($atts['id']);

		return $product ? $product->get_price_html() : null;
	}

	public function remove_checkout_fields( $fields ) {
		$options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );

		$checkout_fields = [
            ['billing','billing_first_name'],
            ['billing','billing_last_name'],
            ['billing','billing_company'],
            ['billing','billing_country'],
            ['billing','billing_address_1'],
            ['billing','billing_address_2'],
            ['billing','billing_city'],
            ['billing','billing_state'],
            ['billing','billing_postcode'],
            ['billing','billing_phone'],
            ['billing','billing_email'],
            ['shipping','shipping_first_name'],
            ['shipping','shipping_last_name'],
            ['shipping','shipping_company'],
            ['shipping','shipping_country'],
            ['shipping','shipping_address_1'],
            ['shipping','shipping_address_2'],
            ['shipping','shipping_city'],
            ['shipping','shipping_state'],
            ['shipping','shipping_postcode'],
            ['order','order_comments'],
        ];

        foreach($checkout_fields as $field) {
			if(isset($options["viderlab-customizations-for-woocommerce-settings_remove-{$field[0]}-{$field[1]}-field"]))
				unset($fields[$field[0]][$field[1]]);
		}

		return $fields;
	}

	public function remove_checkout_additional_info( $enable ) {
		$options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
		if( isset($options['viderlab-customizations-for-woocommerce-settings_remove-additional-info']) ) {
			$enable = false;
		}

		return $enable;		
	}
}
