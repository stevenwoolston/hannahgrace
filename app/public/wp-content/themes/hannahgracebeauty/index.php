<?php
get_header();
?>

<main id="main" class="site-main" role="main">
    <section id="page-<?php the_ID(); ?>" 
        <?php post_class(array('wwd-content-page', $post->post_name)); ?>>
<?php
	if (have_posts()):
        while(have_posts()): the_post();
            if (is_front_page()):
                get_template_part('template-parts/content', 'page-header');
                get_template_part('template-parts/content-home');
            else:
                get_template_part('template-parts/content', 'page-header');
                get_template_part('template-parts/content', 'page');
            endif;
        endwhile;
    endif;
?>
    </section>
</main>
<?php
    get_footer();
?>