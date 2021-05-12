<?php
/*
@package: wwd blankslate
**	Attachment template
*/
get_header();
$attachment = wp_get_attachment_image_src(get_the_ID(), 'full')[0];
// var_dump($attachment);
?>

<main id="main" class="site-main" role="main">
    <section id="page-<?php the_ID(); ?>" 
        <?php post_class(array('wwd-content-page', $post->post_name)); ?>>

        <article id="page-<?php the_ID(); ?>" class="container">

            <div class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>'); ?>
            </div>	

            <div class="entry-body text-center">
                <?php
                    $image_size = apply_filters( 'wporg_attachment_size', 'medium_large' ); 
                    echo wp_get_attachment_image( get_the_ID(), $image_size ); 
                ?>
            </div>

            <div class="entry-footer"></div>

        </article>
    </section>
</main>
<?php
    get_footer();
?>