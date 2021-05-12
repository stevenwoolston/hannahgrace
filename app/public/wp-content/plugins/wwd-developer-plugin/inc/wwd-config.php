<?php

add_filter('plugin_action_links_' . WWD_PLUGIN_BASENAME, 'wwd_build_settings_link');

function wwd_build_settings_link($links) {
    $settings_link = '<a href="admin.php?page=wwd_plugin">View Settings</a>';
    array_push($links, $settings_link);
    return $links;
}