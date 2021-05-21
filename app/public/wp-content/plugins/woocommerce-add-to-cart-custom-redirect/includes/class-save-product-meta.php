<?php

/**
 *	Save product meta
 *
 *	@package Custom WooCommerce Redirects
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RV_Custom_WooCommerce_Redirects_Save_Product_Meta' ) ) :

class RV_Custom_WooCommerce_Redirects_Save_Product_Meta {

	public function __construct() {

		add_action( 'woocommerce_process_product_meta', array( $this , 'save_product_meta' ) );	
	}

	/**
	 *	Update product meta, or delete
	 */
	public function save_product_meta( $post_id ) {

		$key = RV_Custom_WooCommerce_Redirects()->get_meta_key();

		$redirect = isset( $_POST[$key] ) ? filter_var( $_POST[$key], FILTER_SANITIZE_URL ) : false;

		if ( $redirect ) {
			update_post_meta( $post_id, $key, $redirect );
		} else {
			delete_post_meta( $post_id, $key );
		}
	}
}

endif;

new RV_Custom_WooCommerce_Redirects_Save_Product_Meta;