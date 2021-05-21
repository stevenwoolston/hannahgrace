<style>
	#woocommerce-product-data ul.wc-tabs li.add_to_cart_redirect a::before {
		font-family: Dashicons;
		content: '\f504';
	}

	#rv_add_to_cart_redirect_product_data_tab input[type="text"]::placeholder {
		color: #fff;
	}

	#rv_add_to_cart_redirect_product_data_tab input[type="text"]:focus::placeholder {
		color: inherit;
	}

	#<?php echo $key; ?> {
		width: 90%;
	}
</style>

<!-- id below must match target registered in above add_my_custom_product_data_tab function -->
<div id="rv_add_to_cart_redirect_product_data_tab" class="panel woocommerce_options_panel">
	
	<?php

		$args = array(
			'id' => $key,
			'label' => __( 'Add-to-Cart Redirect URL', 'woocommerce-add-to-cart-redirect' ),
			'placeholder' => 'https://',
			'wrapper_class' => 'hide_if_external',
			'default' => '',
			'desc_tip' => 'true',
			'description' => __( 'This is where the user will be redirected to after this product is added to the cart. Enter a full URL.', 'woocommerce-add-to-cart-redirect' ) ,
			'value' => get_post_meta( $post_id, $key, true ),
			'data_type' => 'wc_input_url'
		);

		do_action( 'woocommerce_custom_redirects_product_data_tab_start' );

		woocommerce_wp_text_input( $args );

		do_action( 'woocommerce_custom_redirects_product_data_tab_end' );
	?>

</div>