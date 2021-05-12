<?php
/*
@package: wwd blankslate
*/
?>

<?php
get_header();
?>

<main id="main" class="site-main" role="main">
    <section id="page-<?php the_ID(); ?>" 
        <?php post_class(array($post->post_name)); ?>>
<?php
    if (have_posts()): while(have_posts()): the_post();
        get_template_part('template-parts/content', 'single');
    endwhile; endif;
    wp_reset_query();
?>
    </section>
</main>

<?php get_footer(); ?>