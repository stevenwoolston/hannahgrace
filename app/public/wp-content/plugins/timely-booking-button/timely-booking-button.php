<?php

/**
 * Plugin Name:     Timely Booking Widgets
 * Plugin URI:      http://wordpress.org/extend/plugins/timely-booking-button/
 * Description:     Timely is appointment software for beauty and wellbeing businesses. As well as managing your business, staff, and customers within the app, you can also integrate Timely with your WordPress site to offer online bookings.
 * Author:          Timely - Appointment software
 * Author URI:      https://www.gettimely.com/
 * Text Domain:     timely-booking-button
 * Domain Path:     /languages
 * Version:         2.0.2
 *
 * @package         Timely_Booking_Button
 */

require_once __DIR__ . '/widget/timely-booking-button-widget.php';
require_once __DIR__ . '/widget/timely-booking-frame-widget.php';

// Your code starts here.
if (!class_exists('Timely_Plugin')) {
    class Timely_Plugin
    {

        public function __construct()
        {
            if (is_admin()) {
                require_once __DIR__ . '/admin/timely-booking-button-admin.php';
            }
            register_activation_hook(__FILE__, array($this, 'setOptions'));

            add_action('plugins_loaded', array($this, 'init'));
        }

        public static function init()
        {
            add_action("plugins_loaded", "tbb_init");
            add_shortcode('tbb-button', 'tbb_widget_output');
            add_shortcode('tbw-widget', 'tbw_widget_output');

            wp_register_sidebar_widget('tbb-widget', 'Timely Booking Button', 'tbb_widget_output', array('description' => 'Add a booking button for your Timely account'));
            wp_register_sidebar_widget('tbw-widget', 'Timely Booking Widget', 'tbw_widget_output', array('description' => 'Add a booking widget for your Timely account'));
        }

        public static function setOptions()
        {

            // if we already have options return early
            if (false != get_option('tbb_options')) {
                return;
            }

            // set defaults
            $defaults = array(
                'tbb_account' => '',
                'tbb_field_pill' => 'dark',
                'tbb_width_pill' => 480,
                'tbb_height_pill' => 600,
                'tbb_responsive_pill' => 'on'
            );

            // check old options
            $tbbaccount = get_option('tbb_account');
            $tbbcolour = get_option('tbb_colour');
            $tbwwidth = get_option('tbw_width');
            $tbwheight = get_option('tbw_height');
            $tbwresp = get_option('tbw_resp');

            if (!empty($tbbaccount)) {
                $defaults['tbb_account'] = $tbbaccount;
            }

            if (!empty($tbbcolour)) {
                $defaults['tbb_field_pill'] = $tbbcolour;
            }

            if (!empty($tbwwidth)) {
                $defaults['tbb_width_pill'] = $tbwwidth;
            }

            if (!empty($tbwheight)) {
                $defaults['tbb_height_pill'] = $tbwheight;
            }

            if (!empty($tbwresp)) {
                $defaults['tbb_responsive_pill'] = $tbwresp;
            }

            update_option('tbb_options', $defaults, false);

            // if old options exist delete them
            // clean up on isle 10
            delete_option('tbb_account');
            delete_option('tbb_colour');
            delete_option('tbw_width');
            delete_option('tbw_height');
            delete_option('tbw_resp');
        }
    }

    new Timely_Plugin();
}


// Shortcode for iframe
function tbw_widget_output()
{
    $options = get_option('tbb_options');
    $output = '';

    if ($options['tbb_responsive_pill']) {
        $style = "margin: 0 auto; display: block; width: 100%; max-width: " . $options['tbb_width_pill'] . "px; height:" . $options['tbb_height_pill'] . "px";
    } else {
        $style = "width: " . $options['tbb_width_pill'] . "px; height:" . $options['tbb_height_pill'] . "px";
    }

    if ($options['tbb_account'] != "") {
        $output .= ' <iframe src="//' . $options['tbb_account'] . '.gettimely.com/book/embed" scrolling="no" id="timelyWidget" style="' . $style . '; border: 1px solid #4f606b;"></iframe>';
    }

    return $output;
}

// Shortcode for booking button
function tbb_widget_output()
{
    $options = get_option('tbb_options');
    $style = ($options['tbb_field_pill'] == 'dark') ? ', { style : "dark" }' : '';
    $output = " <div style='padding: 20px 0;'>
        <script id='timelyScript' src='//book.gettimely.com/widget/book-button-v1.5.js'></script>
        <script>
            var timelyButton = new timelyButton('" . $options['tbb_account'] . "'" . $style . ");
        </script>
    </div>";
    return $output;
}
