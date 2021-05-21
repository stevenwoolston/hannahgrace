<?php

/**
 *	Adds a custom tab to the Product Data meta box
 *
 *	@package Custom WooCommerce Redirects
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RV_Custom_WooCommerce_Redirects_Product_Data_Tabs' ) ) :

class RV_Custom_WooCommerce_Redirects_Product_Data_Tabs {

	public function __construct() {

		add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_data_tab' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_data_tab_target' ) );		
	}

	/**
	 *	Adds the tab to the meta box
	 *
	 *	@param array $tabs - Default tabs
	 *	@return array $tabs - New tabs
	 */
	public function add_product_data_tab( $tabs ) {

		$tabs['redirect'] = array(
			'label'  => __( 'Redirects', 'woocommerce-add-to-cart-redirect' ),
			'target' => 'rv_add_to_cart_redirect_product_data_tab',
			'class'  => array( 'add_to_cart_redirect', 'hide_if_external' ),
		);

		return $tabs;
	}

	/**
	 *	Render output for tab target
	 */
	public function add_product_data_tab_target() {

		global $post_id;

		$key = RV_Custom_WooCommerce_Redirects()->get_meta_key();

		include_once RV_CUSTOM_WC_REDIRECTS_PLUGIN_DIR_PATH . 'templates/product-data-tab-target.php';
	}
}

endif;

new RV_Custom_WooCommerce_Redirects_Product_Data_Tabs;