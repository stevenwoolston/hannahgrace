<?php
/*
@package WWD_Developer
@version 0.1.0

Plugin Name: WWD Developer
Plugin URI: https://github.com/woolstonwebdesign/wwd-developer-plugin
Description: Woolston Web Design Developer Plugin
Version: 3.1
Author: Steven Woolston
Author URI: https://www.woolston.com.au
Text Domain: social_share_button
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/woolstonwebdesign/wwd-developer-plugin
*/

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

define("WWD_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("WWD_PLUGIN_BASENAME", plugin_basename(__FILE__));

require_once(plugin_dir_path(__FILE__) . '/inc/wwd-config.php');

require_once(plugin_dir_path(__FILE__) . '/library/wwd-activate-plugin.php');

require_once(plugin_dir_path(__FILE__) . '/library/wwd-custom-layout-type.php');

require_once(plugin_dir_path(__FILE__) . '/library/wwd-sitemap.php');

require_once(plugin_dir_path(__FILE__) . '/library/wwd-admin-options.php');

require_once(plugin_dir_path(__FILE__) . '/library/wwd-gallery.php');

require_once(plugin_dir_path(__FILE__) . '/library/wwd-optimisation.php');

require_once(plugin_dir_path(__FILE__) . '/library/wp-bootstrap-navwalker.php');

require_once(plugin_dir_path(__FILE__) . '/library/yamm-nav-walker.php');

require_once(plugin_dir_path(__FILE__) . '/library/wwd-register-theme-support.php');

require_once(plugin_dir_path(__FILE__) . '/library/wwd-theme-functions.php');

wwd_init();
function wwd_init() {
    add_action('admin_enqueue_scripts', 'wwd_enqueue_assets');
    register_activation_hook(__FILE__, 'wwd_activation_hook');
    register_deactivation_hook(__FILE__, 'wwd_deactivation_hook');
}

function wwd_enqueue_assets() {
    wp_enqueue_media();
    wp_enqueue_style('wwd-developer-style', plugin_dir_url(__FILE__) . '/css/wwd-admin.css', array(), '1.0', 'all');
    wp_enqueue_script('wwd-developer-script', plugin_dir_url(__FILE__) . '/js/wwd-admin.js', array('jquery'), '1.0', true);
}

function wwd_activation_hook() {
    wwd_plugin_activate();
    simple_optimization_cron_on();
}

function wwd_deactivation_hook() {
    wwd_plugin_deactivate();
    simple_optimization_cron_off();
}
