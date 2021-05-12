<?php

/*
@package: wwd blankslate
*/

add_theme_support('post-thumbnails');
add_theme_support('automatic-feed-links');
add_post_type_support('layout', 'thumbnail');
add_post_type_support('post', 'page-attributes');
add_image_size('medium_large', 600, 600);
add_filter( 'widget_text', 'do_shortcode' );

function wwd_custom_logo_setup() {
    $defaults = array(
        'height'      => 100,
        'width'       => 100,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'wwd_custom_logo_setup' );

function wwd_posted_meta() {
    $posted_on = human_time_diff( get_the_time('U'), current_time('timestamp') );
    $categories = get_the_category();
    $separator = ", ";
    $output = '';
    $i = 1;

    if (!empty($categories)) {
        foreach($categories as $category) {
            if ($i > 1) { $output .= $separator; }
            $output .= '<a href="'. esc_url(get_category_link($category->term_id)) . '" alt="'. esc_attr('View all posts in %s', $category->name) . '">' . esc_html($category->name) .'</a>';
            $i++;
        }
    }
    return '<span class="posted-on">Posted <a href="'. esc_url(get_permalink()) .'">' . $posted_on . '</a> ago</span> &nbsp;&raquo;&nbsp; <span class="posted-in">'. $output .'</span>';
}

function add_appearance_menu() {
    add_submenu_page( 'themes.php', 'Custom Stylesheet', 'Custom Stylesheet', 'manage_options', 'customstyle', '__return_null'); 
}
add_action('admin_menu', 'add_appearance_menu');    

//  Makes available a custom CSS file in the appearance section of the theme
function custom_redirect() {
    if ( 'customstyle' === filter_input( INPUT_GET, 'page' ) ) {
        $file2edit = "customstyles.css"; // change this to your needs
        $location = get_admin_url().'theme-editor.php?file='.$file2edit.'&theme='. get_stylesheet().'&scrollto=0';
        wp_redirect( $location, 301);
        exit();
    }
}
//  DO NOT TURN THIS ON FOR JUST ANYONE
//add_action( 'load-appearance_page_customstyle', 'custom_redirect' );

//  Special methods for adding dashboard videos.
function wwd_dashboard_videos()
{
    $videos = array(
        // array(
        //     'url' => 'https://res.cloudinary.com/woolston-web-design/video/upload/v1593785366/focussed_marketing/lacuna-editing-navigating.mp4', 
        //     'title' => '04/07/2020: Editing Layout Content'
        // ),
        // array(
        //     'url' => 'https://res.cloudinary.com/woolston-web-design/video/upload/v1593083090/focussed_marketing/lacuna.mp4', 
        //     'title' => 'Development Methodology'
        // )
    );
    if (function_exists('wwd_render_videos') && count($videos) > 0) {
        echo wwd_render_videos($videos);
    } else {
        echo "<h2>No videos at this time</h2>";
    }
}    

//  Custom Post Types specific to this theme
function wwd_custom_post_types() {
    if (function_exists('wwd_generic_taxonomy')) {
        //  these items have the incorrect id format. Should use underscores
        wwd_generic_taxonomy('builder-component', 'Component Locations', 'builder-component', array('layout'));
        wwd_generic_taxonomy('news-topic', 'Topics', 'news-topic', array('news'));

        // wwd_generic_taxonomy('maker-audience', 'Makers Audience', 'maker-audience', array('maker'));
        // wwd_generic_taxonomy('maker-product', 'Makers Products', 'maker-product', array('maker'));
        wwd_generic_taxonomy('maker_audience', 'Makers\' Audiences', 'maker-audience', array('maker'));
        wwd_generic_taxonomy(
            $name = 'maker_product', 
            $label = 'Makers\' Products',
            $slug = 'maker-product', 
            $custom_post_type = array('maker'));
    }

    if (function_exists('wwd_add_custom_post')) {
        wwd_add_custom_post('faq', 'FAQ', 'FAQs', 'dashicons-book-alt', array('post'));
        wwd_add_custom_post('layout', 'Layout Builder', 'Layout Builders', 'dashicons-book-alt', array('post'));
        wwd_add_custom_post('news', 'News', 'News', 'dashicons-book-alt', array('post'));
        wwd_add_custom_post('fabric', 'Our Fabric', 'Our Fabrics', 'dashicons-book-alt', array('post'));
        wwd_add_custom_post(
            $name = 'maker', 
            $label = 'Makers\' Directory', 
            $pluralisedName = 'Makers', 
            $icon = 'dashicons-book-alt', 
            $taxonomy = array('post'));
    }
}
add_action('init', 'wwd_custom_post_types');

if (class_exists('WWD_Custom_Taxonomy')) {
    $wwd_custom_tax = new WWD_Custom_Taxonomy();
    $wwd_custom_tax->Taxonomies = array('builder-component');
    $wwd_custom_tax->init();
}

function tm_add_style_select_buttons($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'tm_add_style_select_buttons');

function my_custom_styles($init_array) {
    $formats = 
    $style_formats = array(
        array(
            'title' => 'Call To Action',
            'block' => 'span',
            'classes' => 'call-to-action',
            'wrapper' => true
        ),
        // array(
        //     'title' => 'T+M Blue Button',
        //     'block' => 'span',
        //     'classes' => 'btn pill alt-color',
        //     'wrapper' => true
        // ),

        // array(
        //     'title' => '2 Column Layout - Keep Together',
        //     'selector' => 'blockquote',
        //     'classes' => 'two-column-layout-keep-together',
        //     'wrapper' => true,
        // ),
    );
    $init_array['style_formats'] = wp_json_encode($style_formats);
    return $init_array;
}
add_filter('tiny_mce_before_init', 'my_custom_styles');

function wwd_search_filter($query) {

    if (is_admin() || !$query->is_main_query()) { 
        return $query; 
    }

    global $wp_post_types;
    $wp_post_types['layout']->exclude_from_search = true;

    $meta_query = [];

    if ($query->is_archive) {
        
        if (array_key_exists('post_type', $query->query) && (
            $query->query['post_type'] == 'faq' ||
            $query->query['post_type'] == 'fabric'
        )) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'menu_order');
            $query->set('posts_per_page', -1);
        }

        if (array_key_exists('product_cat', $query->query)) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
            $query->set('posts_per_page', -1);
        }

        if ($query->query['post_type'] == 'maker') {
            $query->set('posts_per_page', -1);
            $query->set('orderby', 'rand');
            //$query->set('paged', $paged);
        }
    }

    // var_dump($query);
    return $query;
}
add_action('pre_get_posts', 'wwd_search_filter');

function handle_post_attachment($file_handler, $post_id, $set_thu=false) {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
  
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
  
    $attach_id = media_handle_upload($file_handler, $post_id);
   
    if (is_numeric($attach_id)) {
        update_post_meta($post_id, '_product_image_gallery', $attach_id);
        set_post_thumbnail($post_id, $attach_id);
    }

    return $attach_id;  
}