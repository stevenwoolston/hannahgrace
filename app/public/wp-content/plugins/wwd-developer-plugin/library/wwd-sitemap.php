<?php
/*
@package Woolston Web Design Developer Plugin

**  SEO Sitemaps
**  Function to create sitemap.xml file in root directory of site
*/


if ( ! defined('ABSPATH')) exit;  // if direct access 

add_action( "save_post", "eg_create_sitemap" );
function eg_create_sitemap() {
    
    $postsForSitemap = get_posts( array(
        'numberposts' => -1,
        'orderby'     => 'modified',
        'post_status' => 'publish',
        'post_type'   => array( 'post', 'page' ),
        'order'       => 'DESC'
        )
    );

    $sitemap = '<?xml version="1.0" encoding="UTF-8" ?>';
    $sitemap .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach( $postsForSitemap as $post ) {
        setup_postdata( $post );
        $url = get_permalink( $post->ID );
        if (substr($url, 0, 4) == "http") {
            $postdate = explode( " ", $post->post_modified );
            $postId = $post->ID;
            $sitemap .= "\t" . '<url>' . "\n" . "\t\t" . '<loc>' . $url . '</loc>' .
                "\n\t\t" . '<lastmod>' . $postdate[0] . '</lastmod>' .
                "\n\t\t" . '<changefreq>monthly</changefreq>' . "\n\t" . '</url>' . "\n";
        }
    }

    $sitemap .= '</urlset>';

    $fp = fopen( ABSPATH . "sitemap.xml", 'w' );
    fwrite( $fp, $sitemap );
    fclose( $fp );

}

add_action( "save_post", "create_news_sitemap" );
function create_news_sitemap() {
    $postsForSitemap = get_posts( array(
        'numberposts' => -1,
        'orderby'     => 'modified',
        'category_name' => 'news',
        'post_type'   => array( 'post', 'page' ),
        'post_status' => 'publish',
        'order'       => 'DESC'
        )
    );

    $sitemap = '<?xml version="1.0" encoding="UTF-8" ?>';
    $sitemap .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach( $postsForSitemap as $post ) {
        setup_postdata( $post );
        $url = get_permalink( $post->ID );
        if (substr($url, 0, 4) == "http") {
            $postdate = explode( " ", $post->post_modified );
            $postId = $post->ID;
            $sitemap .= "\t" . '<url>' . "\n" . "\t\t" . '<loc>' . $url . '</loc>' .
                "\n\t\t" . '<lastmod>' . $postdate[0] . '</lastmod>' .
                "\n\t\t" . '<changefreq>monthly</changefreq>' . "\n\t" . '</url>' . "\n";
        }
    }


    $sitemap .= '</urlset>';

    $fp = fopen( ABSPATH . "news_sitemap.xml", 'w' );
    fwrite( $fp, $sitemap );
    fclose( $fp );

}

?>