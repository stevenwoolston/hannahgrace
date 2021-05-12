<?php
/*
@package: wwd blankslate
**	Post archive
*/
?>

<?php
get_header();
wp_reset_query();
$archive_object = get_queried_object();
// var_dump($archive_object);
wp_reset_query();
?>

<main id="main" class="site-main" role="main">
<section id="page-<?php the_ID(); ?>" 
        <?php post_class(array('wwd-content-page')); ?>>
<?php
	query_posts(array( 
		'post_type' => 'layout',
		'post_status' => 'publish',
        'name' => $archive_object->label .' Archive Header',
        'posts_per_page' => 1)
	);
    if (have_posts()): 
        while(have_posts()): the_post();
            get_template_part('template-parts/content', 'page-header');
        endwhile; 
    else:
        wp_reset_query();
        echo '<h1 class="archive-title">' .$archive_object->label. '</h1>';
    endif;
    wp_reset_query();

    if (have_posts()):
?>
        <section class="archive-content">
<?php
        while(have_posts()): the_post();
            $template = get_post_type() . (get_post_format() ? '-' . get_post_format() : '');
            //  var_dump($template, $post);
            get_template_part('template-parts/content-archive', $template);
        endwhile;
?>
        </section>
<?php
    endif;
?>
    </section>
</main>
<?php get_footer(); ?>