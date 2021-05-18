<?php
/*
@package: wwd blankslate
**	Post archive
 * @version 4.7.0
*/

get_header();
?>

<main id="main" class="site-main" role="main">
<?php
$hero = new WP_Query(array(
    'post_type' => 'layout',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy'         => 'builder-component',
            'field'            => 'slug', // Or 'term_id' or 'name'
            'terms'            => 'shop-hero', // A slug term
        )
    )
));
if ($hero->have_posts()):
    while($hero->have_posts()): $hero->the_post();
        the_content();
    endwhile;
endif;
wp_reset_query();
?>
<?php
$categories = get_terms('product_cat', array(
    'hide_empty' => true,
    'exclude' => array(21, 116, 18, 177, 187)
));
foreach($categories as $category):
    // var_dump($category);
?>
    <section class="product-category">
        <article class="product-category-content">
            <h4><?php echo $category->name; ?></h4>
            <div class="category-meta">
                <div class="category-description d-none">
                    <?php echo $category->description; ?>
                </div>
                <div class="category-products">
                    <div class="category-product-list">
<?php
$products = new WP_Query(array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug', // Or 'term_id' or 'name'
            'terms'            => $category->slug, // A slug term
            // 'include_children' => false // or true (optional)
        )
    ),
    'orderby' => 'rand',
    'order' => 'ASC'
));
if ($products->have_posts()):
    while($products->have_posts()): $products->the_post();
        echo do_shortcode('[md-template template_name="content-product-thumb"]');
    endwhile;
endif;
wp_reset_query();
?>
                    </div>
                </div>
            </div>
        </article>
    </section>
<?php
endforeach;
wp_reset_query();
$products = new WP_Query(array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy'         => 'product_cat',
            'field'            => 'slug', // Or 'term_id' or 'name'
            'terms'            => 'quick-access', // A slug term
            // 'include_children' => false // or true (optional)
        )
    ),
    'orderby' => 'rand',
    'order' => 'ASC'
));
if ($products->have_posts()):   ?>
    <section class="product-category quick-access-roll">
        <article>
            <h4>Here are some more items we think you might be interested in</h4>
            <div>
<?php
    while($products->have_posts()): $products->the_post();
        echo do_shortcode('[md-template template_name="content-product-thumb"]');
    endwhile;
?>
            </div>
        </article>
    </section>
<?php
endif;
wp_reset_query();
?>
</main>
<?php
get_footer();
?>