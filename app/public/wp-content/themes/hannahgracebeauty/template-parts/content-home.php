<?php
/*
@package: wwd blankslate
*/
// var_dump($post);
?>

<?php 
    the_content();

    $categories = get_terms('product_cat', array(
        'hide_empty' => true
    ));
    foreach($categories as $category):
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $image_url = wp_get_attachment_url($thumbnail_id);
?>
    <section class="home-product-category">
        <article class="home-product-category-content">
            <div class="category-image">
                <img src="<?php echo $image_url; ?>" alt="" />
            </div>
            <div class="category-meta">
                <h2><a href="/product-category/<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></h2>
                <div class="category-description">
                    <?php echo $category->description; ?>
                </div>
                <div class="category-permalink">
                    <a class="md-btn" href="<?php echo site_url() .'/product-category/'. $category->slug; ?>">View All</a>
                </div>
            </div>
        </article>
    </section>
<?php
    endforeach;
    wp_reset_query();
?>