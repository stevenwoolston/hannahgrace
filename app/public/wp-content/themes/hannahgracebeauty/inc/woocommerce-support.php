<?php
/*
@package: wwd blankslate
*/

function wwd_add_woocommerce_support() {
	add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 200,
        'gallery_thumbnail_image_width' => 300,
		'single_image_width'    => 800,

        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
     ),
	));
}
add_action('after_setup_theme', 'wwd_add_woocommerce_support');

function wwd_include_font_awesome_css() {
	// Enqueue Font Awesome from a CDN.
	wp_enqueue_style('font-awesome-cdn', get_template_directory_uri() . '/css/line-awesome.min.css');
}
add_action('wp_enqueue_scripts', 'wwd_include_font_awesome_css');

/**
 * Show cart contents / total Ajax
 */
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment($fragments) {
	global $woocommerce;

	ob_start();

	?>
	<a class="md-cart-total" href="<?php echo wc_get_cart_url();?>">(<?php echo WC()->cart->get_cart_contents_count(); ?>)</a>
	<?php
	$fragments['a.md-cart-total'] = ob_get_clean();
	return $fragments;
}

function quantity_description() {
    echo '<label class="quantity-description"><i class="las la-info-circle"></i><span>Quantities are in 0.5m increments</span></label>';
}
add_action('woocommerce_after_add_to_cart_button', 'quantity_description');

function jk_woocommerce_quantity_input_args($args, $product) {
	if (is_singular('product')) {
        $args['min_value'] 	= 1;   	// Minimum value
        $args['input_value'] = 1;   	// Default value
        $args['step'] 	= 1;	// Starting value (we only want to affect product pages, not cart)
	}
	// $args['max_value'] 	= 80; 	// Maximum value
	// $args['min_value'] 	= 2;   	// Minimum value
	// $args['step'] 		= 2;    // Quantity steps
	return $args;
}
add_filter('woocommerce_quantity_input_args', 'jk_woocommerce_quantity_input_args', 10, 2); // Simple products

function jk_woocommerce_available_variation($args) {
    $args['min_value'] 	= 1;   	// Minimum value
    $args['input_value'] = 1;   	// Default value
    $args['step'] 	= 1;	// Starting value (we only want to affect product pages, not cart)
    return $args;
}
add_filter('woocommerce_available_variation', 'jk_woocommerce_available_variation'); // Variations

// define the woocommerce_add_to_cart callback 
function action_woocommerce_add_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) { 
    $data = 'cart_item_key = "' .$cart_item_key. '", productid = "' .$product_id. '", quantity = "' .$quantity. '", variation_id = "' .$variation_id. '", variation = "' .implode(",", $variation). '", cart_item_data = "' .implode(",", $cart_item_data). '"';
    $booking_date = $_POST['bookingdate'];
    $booking_time = $_POST['bookingtime'];
    createBooking('New Booking for Product - ' .get_the_title($product_id), $data, $product_id, $cart_item_key, $booking_date, $booking_time);
}; 
add_action('woocommerce_add_to_cart', 'action_woocommerce_add_to_cart', 10, 6);

function remove_from_cart() {

    $cart = WC()->cart->get_cart();

    if (isset($_GET[ 'remove_item' ])) {
        $cart_item_key = $_GET[ 'remove_item' ];

        $posts = get_posts(
            array(
                'post_type' => 'booking',
                'meta_key' => 'cart_item_key',
                'meta_value' => $cart_item_key
          )
      );
    
        if (count($posts) == 1) {
            wp_delete_post($posts[0]->ID);
        }
    }
}
add_action('woocommerce_cart_updated', 'remove_from_cart');

function so_payment_complete($order_id){
    $order = wc_get_order($order_id);

    // $user = $order->get_user();
    // if ($user){
    //     // do something with the user
    // }

    // Loop though order items
    foreach ( $order->get_items() as $item ){
        // Get the corresponding cart item key
        $cart_item_key = $item->get_meta( '_cart_item_key' );
        $booking = get_posts(
            array(
                'post_status'   => 'publish',           // Choose: publish, preview, future, draft, etc.
                'post_type' => 'booking',
                'meta_key' => 'cart_item_key',
                'meta_value' => $cart_item_key
            )
        );
        if (count($booking) == 1) {
            update_field('order_id', $order_id, $booking[0]->ID);
            delete_post_meta($item->get_id(), '_cart_item_key');
        }
    }
}
add_action('woocommerce_payment_complete', 'so_payment_complete');

// /**
//  * Clear cart after payment.
//  */
// function st_wc_clear_cart_after_payment() {
// 	global $wp;

// 	if ( ! empty( $wp->query_vars['order-received'] ) ) {

// 		$order_id  = absint( $wp->query_vars['order-received'] );
// 		$order_key = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : ''; // WPCS: input var ok, CSRF ok.

// 		if ( $order_id > 0 ) {
// 			$order = wc_get_order( $order_id );
//             var_dump(WC()->cart);
//             var_dump($order);
//             var_dump($order->get_items(array('line_item', 'fee', 'shipping')));
//             var_dump($order->get_order_key());

// 			if ( $order && hash_equals( $order->get_order_key(), $order_key ) ) {
// 				// WC()->cart->empty_cart();
// 			}
// 		}
// 	}

// 	if ( WC()->session->order_awaiting_payment > 0 ) {
// 		$order = wc_get_order( WC()->session->order_awaiting_payment );

// 		if ( $order && $order->get_id() > 0 ) {
// 			// If the order has not failed, or is not pending, the order must have gone through.
// 			if ( ! $order->has_status( array( 'failed', 'pending', 'cancelled' ) ) ) {
// 				// WC()->cart->empty_cart();
// 			}
// 		}
// 	}
// }
// function override_wc_clear_cart_after_payment() {
//     remove_action('get_header', 'wc_clear_cart_after_payment');
//     add_action('get_header', 'st_wc_clear_cart_after_payment');
// }
// // add_action('init', 'override_wc_clear_cart_after_payment');


// function wh_test_1($order_id) { //<--check this line

//     //create an order instance
//     $order = wc_get_order($order_id); //<--check this line

//     $paymethod = $order->payment_method_title;
//     $orderstat = $order->get_status();

//     if (($orderstat == 'completed') && ($paymethod == 'PayPal')) {
//         echo "something";
//     } 
//     elseif (($orderstat == 'processing') && ($paymethod == 'PayPal')) {

//         echo "some other code";
//     } 
//     elseif (($orderstat == 'pending') && ($paymethod == 'PayPal')) {
//         echo "some other code";
//     }
// }
// add_action('woocommerce_thankyou', 'wh_test_1', 10, 1);


//  add the cart item key to the order item so it can be used to retrieve the booking
function save_cart_item_key_as_custom_order_item_metadata( $item, $cart_item_key, $values, $order ) {
    // Save the cart item key as hidden order item meta data
    $item->update_meta_data( '_cart_item_key', $cart_item_key );
}
add_action('woocommerce_checkout_create_order_line_item', 'save_cart_item_key_as_custom_order_item_metadata', 10, 4 );