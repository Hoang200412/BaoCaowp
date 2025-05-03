<?php
/**
 * @package plugin qlsv
 * @version 1.7.2
 */
/*
Plugin Name: Quan ly can bo
Plugin URI: http://wordpress.org/plugins/quanlycanbo
Description: plugin quan ly can bo
Author: Nguyen Huy Hoang
Version: 1.7.2
Author URI: http:/quanlycanbo
*/


register_activation_hook(__FILE__, 'qlsb_active');

function qlsb_active() {
    require_once plugin_dir_path(__FILE__) . 'includes/database.php' ; 
    qlcb_create_table();
}

register_deactivation_hook(__FILE__, 'qlcb_deactive');

function qlcb_deactive() {
    require_once plugin_dir_path(__FILE__) . 'includes/database.php';
    qlcb_delete_table();
}


function qlcb_enqueue_style() {
    wp_enqueue_style(
        'qlcb-style',
        plugin_dir_url(__FILE__) . 'assets/style.css',
        [],
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'qlcb_enqueue_style');

require_once plugin_dir_path(__FILE__) . 'includes/qlcb.php'; 
require_once plugin_dir_path(__FILE__) . 'includes/qlcb_search.php'; 


