<?php
/**
 * Template Name: Search Page
 */
get_header();
?>

<main id="main" class="site-main" role="main">
    <section id="page-<?php the_ID(); ?>" 
        <?php post_class(array('wwd-content-page', 'gutter', (have_posts() ? '' : 'no-results-found'))); ?>>
        <h1>
            <?php echo $wp_query->found_posts; ?> <?php _e( 'Search Results Found For', 'locale' ); ?>: "<?php the_search_query(); ?>"
        </h1>        
<?php
	if (have_posts()):
?>
        <section class="search-results-container">
<?php
        while(have_posts()): the_post();
            $template = get_post_type() . (get_post_format() ? '-' . get_post_format() : '');
            switch (get_post_type()) {
                // case 'product':
                //     echo do_shortcode('[md-template template_name="content-product-thumb"]');
                //     break;
                default:
                    echo do_shortcode('[md-template template_name="content-search-result"]');
                    break;
            }
            //var_dump($template);
            // echo do_shortcode('[md-template template_name="content-product-thumb"]');
            // get_template_part('template-parts/content-search', get_post_type());
        endwhile;
?>
        </section>
<?php
    endif;
?>
    </section>
</main>
<?php
    get_footer();
?>