<?php
/*
@package Woolston Web Design Developer Plugin
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

function wwd_plugin_activate() {
  
    if ( !is_admin() ) {
        return;
    }

    $default_options = array(
        'use_custom_header' => false,
        'bootstrap_carousel' => true,
        'carousel_speed' => 10,
        'use_custom_background' => false,
        'custom_posts' => array(),
        'seo' => array(
            'meta_description' => '',
            'google_analytics_tracking_code' => ''
        ), 
        'theme_options' => array(
            'post_formats' => array(),
            'google_map_embed' => ''
        ),
        'social_media' => array(
            'facebook_url' => '',
            'twitter_url' => '',
            'linkedin_url' => '',
            'instagram_url' => '',
            'pinterest_url' => '',
            'youtube_url' => ''
        )
    
    );
    
    $wwd_options = get_option('wwd-plugin');
    $new_options = $default_options + (is_array($wwd_options) ? $wwd_options : array());
    update_option('wwd-plugin', $default_options);
    flush_rewrite_rules();
    
    // if (!get_option('wwd-plugin')) {
    //     update_option('wwd-plugin', $defaultOptions);
    // }
}

function wwd_plugin_deactivate() {
  
    if ( !is_admin() || !get_option( 'wwd-plugin' ) ) {
        return;
    }

    // delete_option('wwd-plugin');
    // flush_rewrite_rules();

}
