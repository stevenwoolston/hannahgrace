<?php
/*
@package: wwd blankslate
*/
$background_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium')[0];
$background_image = $background_image == null ?
    wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'medium')[0] :
    $background_image;
?>

<article>
    <div class="entry-image">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo $background_image; ?>" alt=""></a>
    </div>
    <div class="entry-content">
        <div class="entry-header">
            <?php the_title( '<a href="' .get_the_permalink(). '"><h2 class="entry-title">', '</h2></a>'); ?>
            <div class="classification">
<?php 
$postType = get_post_type_object(get_post_type());
if ($postType) {
    echo esc_html($postType->labels->singular_name);
}
?>
            </div>
        </div>	
        <div class="entry-footer"></div>
    </div>
</article>