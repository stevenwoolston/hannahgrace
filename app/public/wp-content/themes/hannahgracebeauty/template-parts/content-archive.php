<?php
/*
@package: wwd blankslate
*/
$background_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail')[0];
?>

<article>
    <div class="entry-image">
        <img src="<?php echo $background_image; ?>" alt="">
    </div>
    <div class="entry-content">
        <div class="entry-header">
            <?php the_title( '<h1 class="entry-title">', '</h1>'); ?>
        </div>	
        <div class="entry-body">
            <?php the_excerpt(); ?>
        </div>
        <div class="entry-footer"></div>
    </div>
</article>