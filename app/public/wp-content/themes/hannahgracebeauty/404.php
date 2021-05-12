<?php
/*
@package: wwd blankslate
*/

get_header();
?>

<main id="main" class="site-main" role="main">
    <section <?php post_class( array('wwd-content-404', 'container-fluid') ); ?>>
        <article class="container">
            <div class="row entry-content">
                <h1><?php _e( 'Oops! That page can&rsquo;t be found.', 'wwd' ); ?></h1>
                <p><?php _e( 'It looks like nothing was found at this location.', 'wwd' ); ?></p>
            </div>
        </article>
    </section>
</main>

<?php get_footer(); ?>