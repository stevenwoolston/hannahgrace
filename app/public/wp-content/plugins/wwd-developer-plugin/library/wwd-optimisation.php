<?php
/*
@package Woolston Web Design Developer Plugin
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

// Clean up wp_head - https://code.tutsplus.com/articles/your-first-wordpress-plugin-simple-optimization--net-11869
// Remove Really simple discovery link
remove_action('wp_head', 'rsd_link');
// Remove Windows Live Writer link
remove_action('wp_head', 'wlwmanifest_link');
// Remove the version number
remove_action('wp_head', 'wp_generator');
 
// Remove curly quotes
remove_filter('the_content', 'wptexturize');
remove_filter('comment_text', 'wptexturize');
 
// Allow HTML in user profiles
remove_filter('pre_user_description', 'wp_filter_kses');

//Optimize Database
function optimize_database(){
    global $wpdb; // get access to $wpdb object
    $all_tables = $wpdb->get_results('SHOW TABLES',ARRAY_A); // get all table names
    foreach ($all_tables as $tables){ // loop through every table name
        $table = array_values($tables); // get table name out of array
        $wpdb->query("OPTIMIZE TABLE ".$table[0]); // run the optimize SQL command on the table
    }
}
function simple_optimization_cron_on(){
    wp_schedule_event(time(), 'daily', 'optimize_database'); // rdd optimize_database to wp cron events
}

function simple_optimization_cron_off(){
    wp_clear_scheduled_hook('optimize_database'); // remove optimize_database from wp cron events
}

?>