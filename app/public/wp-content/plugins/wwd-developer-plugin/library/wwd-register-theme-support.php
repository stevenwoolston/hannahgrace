<?php
/*
@package Woolston Web Design Developer Plugin
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$options = get_option('wwd-plugin');
// if (!empty($options)) {
//     $formats = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video');
//     $output = array();

//     foreach($formats as $format) {
//         $output[] = (@$options['theme_options']['post_formats'][$format] == 1 ? $format : '');
//     }

//     add_theme_support('post-formats', $output);
// }

$custom_header = $options['use_custom_header'];
if ($custom_header == 1) {
    add_theme_support('custom-header');
}

$custom_background = $options['use_custom_background'];
if ($custom_background == 1) {
    add_theme_support('custom-background');
}

function wwd_register_menus() {
    register_nav_menu('primary', 'Header Navigation Menu');
}
add_action( 'after_setup_theme', 'wwd_register_menus' );

function wwd_widget_setup() {
    register_sidebar(
        array(
            'name' => 'Site Wide Sidebar',
            'id' => 'global-sidebar',
            'class' => 'wwd-sidebar',
            'description' => 'Standard Sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h1 class="widget-title">',
            'after_title' => '</h1>'
        )
    );
}
add_action('widgets_init', 'wwd_widget_setup');

function wwd_wp_title( $title, $sep ) {
    if ( is_404() ) {
        return "Nothing Found" . " - " . $title;
    } else if ( !is_home() ) {
        return get_the_title() . " - " . $title;
    } else {
        return $title;
    }
}
add_filter( 'wp_title', 'wwd_wp_title', 10, 2 );
