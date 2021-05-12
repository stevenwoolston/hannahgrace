<?php
/*
@package: wwd blankslate
*/
$background_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium')[0];
?>

<article>
    <div class="entry-image">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo $background_image; ?>" alt=""></a>
    </div>
    <div class="entry-content">
        <div class="entry-header">
            <?php the_title( '<a href="' .get_the_permalink(). '"><h2 class="entry-title">', '</h2></a>'); ?>
            <div class="meta">
                <span class="author"><?php printf(__('By %s on', 'wwd'), esc_html(get_the_author())); ?></span>
                <span class="date"><?php echo get_the_date('F j, Y'); ?></span>
            </div>
        </div>	
        <div class="entry-body">
            <?php the_excerpt(); ?>
        </div>
        <div class="entry-footer"></div>
    </div>
</article>