<?php
/*
@package: wwd blankslate
*/
global $product;
$product_id = $product->get_id();
$product_types = wp_get_object_terms($product_id, 'product_type');
$product_categories = wc_get_product_term_ids($product_id, 'product_cat');
$category_class = [];
foreach( $product_categories as $cat_id ) {
    $term = get_term_by('id', $cat_id, 'product_cat');
    array_push($category_class, 'category-' .strtolower($term->slug));
}
// var_dump(get_post_meta($product_id, 'mwb_wgm_pricing', true));
if ( isset( $product_types[0] ) ) {
    $product_type = $product_types[0]->slug;
    if ( 'wgm_gift_card' == $product_type ) {
        $post_meta = get_post_meta($product_id, 'mwb_wgm_pricing', true);
        $post_prices = explode('|', $post_meta['price']);
        $product_price = $post_prices[0]. ' - $' .$post_prices[count($post_prices)-1];
    } else {
        $product_price = $product->get_price();
    }
}
array_push($category_class, 'product-' .$product->get_id());
array_push($category_class, 'product-' .$product->get_slug());
array_push($category_class, 'product-type-' .$product->get_type());
?>

<article <?php post_class($category_class); ?>>
    <div class="product-image d-none"><a href="<?php echo get_the_permalink(); ?>"><?php echo $product->get_image(); ?></a></div>
    <div class="product-meta">
        <div class="product-name">
            <a href="<?php echo get_the_permalink(); ?>">
                <?php echo $product->get_name(); ?>
            </a>
        </div>
        <div class="product-price">$<?php echo $product_price; ?></div>
    </div>
</article>
