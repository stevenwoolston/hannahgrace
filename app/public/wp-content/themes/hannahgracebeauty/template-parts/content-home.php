<?php
/*
@package: wwd blankslate
*/
// var_dump($post);
?>

<?php 
    the_content(); 

    $categories = get_terms('product_cat', array(
        'slug' => 'whats-new'
    ));
    
    $products = new WP_Query(array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'tax_query' => array(
            array(
                'taxonomy'         => 'product_cat',
                'field'            => 'slug', // Or 'term_id' or 'name'
                'terms'            => 'whats-new', // A slug term
                // 'include_children' => false // or true (optional)
            )
        ),
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    if ($products->have_posts()):
?>
<section class="whats-new-container">
    <h3 class="text-center"><?php echo $categories[0]->name; ?></h3>
    <p class="text-center"><?php echo $categories[0]->description; ?></p>
    <div class="whats-new-articles">
<?php
        while($products->have_posts()): $products->the_post();
            echo do_shortcode('[md-template template_name="content-product-thumb"]');
        endwhile;
?>
    </div>
</section>
<?php
    endif;
    wp_reset_query();
?>    
<section class="instagram-feed">
    <h3 class="text-center">On the gram</h3>
    <p class="text-center">@materialdifference.com.au</p>
<?php
    echo do_shortcode('[instagram-feed]');
?>
</section>