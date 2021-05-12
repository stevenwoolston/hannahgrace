<?php
/*
@package: wwd blankslate
**	Post archive
 * @version 4.7.0
*/
?>

<?php
get_header();
$taxonomy = get_queried_object();
// var_dump($taxonomy);
?>

<main id="main" class="site-main" role="main">
<?php
    if (have_posts()):
?>
    <section <?php echo post_class(); ?>>
        <span class="archive-breadcrumb">
            <i class="las la-arrow-circle-left"></i>
            <a href="/shop">Back to Shop</a>
        </span>
        <div class="taxonomy-meta">
            <h2><?php echo $taxonomy->name; ?></h2>
            <p><?php echo $taxonomy->description; ?></p>
        </div>
        <div class="taxonomy-terms">
<?php
        while(have_posts()): the_post();
            get_template_part('template-parts/content', 'product-thumb');
        endwhile;
?>
        </div>
        <span class="archive-breadcrumb">
            <i class="las la-arrow-circle-left"></i>
            <a href="/shop">Back to Shop</a>
        </span>
    </section>
<?php
    endif;
?>
</main>

<?php get_footer(); ?>