<?php
/*
@package: wwd blankslate
**	Post archive
 * @version 4.7.0
*/

get_header();
?>

<main id="main" class="site-main" role="main">
    <section class="page-wrap">
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
    </section>
    <section class="page-template-page-fullwidth">
<?php
    get_template_part('template-parts/content-home');
?>
    </section>
</main>
<?php
get_footer();
?>