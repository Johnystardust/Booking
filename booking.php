<?php
/**
 * Plugin Name: Booking
 * Plugin URI: http://danielpataki.com
 * Description: Booking plugin
 * Version: 1.0.0
 * Author: Tim van der Slik
 * Author URI: http://timvanderslik.nl
 */

// Include CPT
//----------------------------------------------------------------------------------------------------------------------
include_once('cpt.php');

// Include Single Template
//----------------------------------------------------------------------------------------------------------------------
function tvds_homes_include_template_function($template_path){
    if(get_post_type() == 'homes'){
        if(is_single()){
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if($theme_file = locate_template(array('single-homes.php'))){
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__).'/single-homes.php';
            }
        }
        elseif ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-homes.php' ) ) ) {
                $template_path = $theme_file;
            } else { $template_path = plugin_dir_path( __FILE__ ) . '/archive-homes.php';

            }
        }
    }
    return $template_path;
}
add_filter( 'template_include', 'tvds_homes_include_template_function', 1 );

// Create Taxonomies
//----------------------------------------------------------------------------------------------------------------------
function tvds_create_homes_taxonomies(){
    register_taxonomy(
        'homes_place',
        'homes',
        array(
            'labels' => array(
                'name' => __('Plaats', 'tvds'),
                'add_new_item' => __('Nieuwe plaats', 'tvds'),
                'new_item_name' => __('Nieuwe plaats type', 'tvds')
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
    register_taxonomy(
        'homes_type',
        'homes',
        array(
            'labels' => array(
                'name' => __('Type', 'tvds'),
                'add_new_item' => __('Nieuw type', 'tvds'),
                'new_item_name' => __('Nieuw type', 'tvds')
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
}
add_action('init', 'tvds_create_homes_taxonomies', 0);