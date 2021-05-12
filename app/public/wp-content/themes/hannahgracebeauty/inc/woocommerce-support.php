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