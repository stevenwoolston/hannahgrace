<?php

/**
 *	Handle the redirects
 *
 *	@package Custom WooCommerce Redirects
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'RV_Custom_WooCommerce_Redirects_Redirects' ) ) :

class RV_Custom_WooCommerce_Redirects_Redirects {

	public function __construct() {

		add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'redirects' ) );		
	}

	/**
	 *	Handle the appropriate redirects (non-AJAX)
	 */
	public function redirects( $url ) {

		$product_id = isset( $_REQUEST['add-to-cart'] ) ? absint( $_REQUEST['add-to-cart'] ) : false;

		if ( ! $product_id ) {
			return $url;
		}

		$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', $product_id );

		$redirect_url = RV_Custom_WooCommerce_Redirects()->get_redirect_url( $product_id );

		// Do the redirect
		if ( $redirect_url ) {
			wp_redirect( $redirect_url );
			exit;
		}
	}
}

endif;

new RV_Custom_WooCommerce_Redirects_Redirects;