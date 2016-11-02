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
include_once('cpt/cpt.php');

// Include The Widgets
//----------------------------------------------------------------------------------------------------------------------
include_once('widget/widgets.php');

// Include The Calendar
//----------------------------------------------------------------------------------------------------------------------
include_once('calendar.php');

// Include The Shortcodes
//----------------------------------------------------------------------------------------------------------------------
include_once('shortcodes.php');

// Include VC Elements
//----------------------------------------------------------------------------------------------------------------------
include_once('vc_elements/vc_elements.php');

// Enqueue Scripts
//----------------------------------------------------------------------------------------------------------------------

// Enqueue normal scripts
function tvds_homes_enqueue_script(){
    // Scripts
    wp_enqueue_script('booking_js', plugin_dir_url(__FILE__).'assets/js/booking.js');

	wp_register_script('validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js');
	wp_enqueue_script('validation');
       
    // Styles
    wp_enqueue_style('booking_css', plugin_dir_url(__FILE__).'assets/css/booking.css');
}
add_action('wp_enqueue_scripts', 'tvds_homes_enqueue_script');

// Enqueue admin scripts
function tvds_homes_enqueue_admin(){
	 // Styles
    wp_enqueue_style('booking_admin_css', plugin_dir_url(__FILE__).'assets/css/homes-admin.css');
    
    // Scripts
    wp_enqueue_script('booking_admin_js', plugin_dir_url(__FILE__).'assets/js/booking-admin.js');
    
    wp_register_script('jquery_ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js');
	wp_enqueue_script('jquery_ui');
	
	wp_register_style('jquery_ui_css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
	wp_enqueue_style('jquery_ui_css');
}
add_action('admin_head', 'tvds_homes_enqueue_admin');



// Include The Templates
//----------------------------------------------------------------------------------------------------------------------
function tvds_homes_include_template_function($template_path){
    if(get_post_type() == 'homes'){
        if(is_single()){
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if($theme_file = locate_template(array('single-homes.php'))){
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__).'/templates/single-homes.php';
            }
        }
        elseif ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-homes.php' ) ) ) {
                $template_path = $theme_file;
            } else { $template_path = plugin_dir_path( __FILE__ ) . '/templates/archive-homes.php';

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
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'homes_place' ),
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

