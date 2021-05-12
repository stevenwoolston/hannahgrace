<?php
/*
@package: wwd blankslate
*/
$audience = wp_get_post_terms($post->ID, 'maker-audience', array('fields' => 'names'));
$products = wp_get_post_terms($post->ID, 'maker-product', array('fields' => 'names'));
$background_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail')[0];
$contact_person = esc_html(get_field('contact_person'));
$contact_email = esc_html(get_field('contact_email'));
$website = esc_html(get_field('website'));
$facebook_url = esc_html(get_field('facebook_url'));
$instagram_url = esc_html(get_field('instagram_url'));
$youtube_url = esc_html(get_field('youtube_url'));
$twitter_url = esc_html(get_field('twitter_url'));
?>

<article class="maker-item">
<?php   if ($background_image): ?>
    <div class="entry-image">
        <img src="<?php echo $background_image; ?>" alt="<?php esc_html(the_title()); ?>">
    </div>
<?php   endif;  ?>
    <div class="entry-content">
        <div class="entry-header">
            <?php echo $website ? 
                the_title('<h4 class="entry-title"><a target="_blank" href="' .$website. '">', '</a></h4>') :
                the_title('<h4 class="entry-title">', '</h4>'); ?>
        </div>	
        <div class="entry-body">
            <?php the_content(); ?>
        </div>
        <div class="entry-footer">
<?php 
        // echo '<div class="contact-email"><i class="las la-envelope-open"></i></div>';
        // echo '<div class="contact-website"><i class="las la-link"></i></div>';
        // echo '<div class="contact-facebook"><i class="lab la-facebook"></i></div>';
        // echo '<div class="contact-instagram"><i class="lab la-instagram"></i></div>';
        // echo '<div class="contact-youtube"><i class="lab la-youtube"></i></div>';
        // echo '<div class="contact-twitter"><i class="lab la-twitter"></i></div>';

        printf($contact_email ? '<div class="contact-email"><a href="mailto:%s"><i class="las la-envelope-open"></i></a></div>' : null, esc_html($contact_email));
        printf($website ? '<div class="contact-website"><a href="%s" target="_blank"><i class="las la-link"></i></a></div>' : null, esc_html($website));
        printf($facebook_url ? '<div class="contact-facebook"><a href="%s" target="_blank"><i class="lab la-facebook"></i></a></div>' : null, esc_html($facebook_url));
        printf($instagram_url ? '<div class="contact-instagram"><a href="%s" target="_blank"><i class="lab la-instagram"></i></a></div>' : null, esc_html($instagram_url));
        printf($youtube_url ? '<div class="contact-youtube"><a href="%s" target="_blank"><i class="lab la-youtube"></i></a></div>' : null, esc_html($youtube_url));
        printf($twitter_url ? '<div class="contact-twitter"><a href="%s" target="_blank"><i class="lab la-twitter"></i></a></div>' : null, esc_html($twitter_url));
?>
        </div>
    </div>
</article>