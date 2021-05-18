<?php
/*
@package: wwd blankslate
*/
require get_template_directory() . '/inc/theme-shortcodes.php';
require get_template_directory() . '/inc/theme-support.php';
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce-support.php';
}

// maintenance redirect
function maintenance_redirect(){
    if (!current_user_can('administrator')) {
        wp_redirect(site_url('index.html'), 302);
        exit();
    }
}
// add_action('init', 'maintenance_redirect');

function wwd_load_scripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js', false, '3.3.1', true);

    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Roboto&family=Varela+Round', array(), '1.0', 'all');

    wp_enqueue_style('icon-fonts', get_template_directory_uri() . '/css/line-awesome.min.css', array(), '1.0.0', 'all');
    wp_enqueue_style('lite-yt-css', get_template_directory_uri() . '/css/lite-yt-embed.min.css', array(), '1.0.0', 'all');
    wp_enqueue_style('wwd-core-css', get_template_directory_uri() . '/css/style.min.css', array(), '0.0.79', 'all');

    //  I have moved away from this library
    // wp_enqueue_script('fitvids', get_stylesheet_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), '1.0', true);
    wp_enqueue_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', array(), '1.16.1', true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.5.0', true);
    wp_enqueue_script('fitvids', get_stylesheet_directory_uri() . '/js/lite-yt-embed.min.js', array('jquery'), '1.0', true);
    wp_enqueue_script('wwd-core-js', get_template_directory_uri() . '/js/core.min.js', array('jquery'), '0.0.79', true);
}
add_action('wp_enqueue_scripts', 'wwd_load_scripts');