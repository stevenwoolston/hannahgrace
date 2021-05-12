<?php
/*
@package: wwd blankslate
*/
$page_header = get_field('header_items', $post->ID);
// var_dump($page_header[0]['background_image']['sizes']);
if ($page_header):
?>
<section <?php post_class(array("page-hero", $post->post_name)); ?>>
<?php
    foreach($page_header as $header):
        $title = $header['title'];
        $hero_text = $header['hero_text'];
        $hero_image = $header['background_image'];
?>
    <article class="hero-content">
<?php 
    if ($title): echo '<h1 class="hero-title">' .$title. '</h1>'; endif;
    if ($hero_text): echo '<div class="hero-text">' .$hero_text. '</div>'; endif;    
?>
    </article>
    <div class="header-image-container">
        <img src="<?php echo $hero_image['sizes']['1536x1536']; ?>" alt="" />
    </div>
<?php
    endforeach;
	wp_reset_query();
?>
</section>
<?php
endif;
?>