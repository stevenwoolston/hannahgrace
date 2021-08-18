<?php
/*
@package: wwd blankslate
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
<?php if (is_singular() && pings_open(get_queried_object())) : ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php endif; ?>
    <?php wp_head(); ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-204686943-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-204686943-1');
    </script>
</head>
<body <?php body_class(); ?>>
<header class="page-header">
    <ul id="menu-primary">
    <li class="custom-logo">
<?php 
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
?>
        <a href="/">
            <img src="<?php echo $image[0]; ?>" alt="" />
        </a>
    </li>
    <li class="nav-menu-items">
        <ul>
<?php
    $items = wp_get_nav_menu_items('Main Menu');
    foreach($items as $list) {
        $isSelected = $list->url == get_the_permalink() || $list->url == site_url().'/'.get_post_type().'/' ? "selected" : "";
        echo '<li class="menu-item ' . $isSelected . '"><a href="' . $list->url . '">' . $list->title . '</a></li>';
    }
?>      
        </ul>
    </li>
    <li class="social-navs">
<?php
    echo do_shortcode('[yoast_social wrapinlist=true usefonticons=true]');
?>
    </li>
    <li class="timely-book">
        <?php dynamic_sidebar('global-sidebar'); ?>    
    </li>
    </ul>
</header>