<?php
/**
 * Plugin Name: TVDS Booking
 * Plugin URI: 
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
include_once('booking-functions.php');

// Include The Shortcodes
//----------------------------------------------------------------------------------------------------------------------
include_once('shortcodes.php');

// Include VC Elements
//----------------------------------------------------------------------------------------------------------------------
include_once('vc_elements/vc_elements.php');

// Include Options
//----------------------------------------------------------------------------------------------------------------------
include_once('homes-options.php');

// Add Image Size
//----------------------------------------------------------------------------------------------------------------------
function tvds_homes_add_image_sizes() {
    add_image_size( 'homes_archive_thumb', 405, 330, true );
}
add_action( 'after_setup_theme', 'tvds_homes_add_image_sizes' );

// Enqueue Scripts
//----------------------------------------------------------------------------------------------------------------------

// Enqueue normal scripts
function tvds_homes_enqueue(){
    // Scripts
    wp_enqueue_script('booking_js', plugin_dir_url(__FILE__).'assets/js/booking.js');

    wp_enqueue_style('booking_fontello_css', plugin_dir_url(__FILE__).'assets/fontello/css/fontello-embedded.css');

	wp_register_script('validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js');
	wp_enqueue_script('validation');

    // Styles
    wp_enqueue_style('booking_css', plugin_dir_url(__FILE__).'assets/css/booking.css');
    
	// Temporary CSS !!!!!!!!!!!!!!!!!!!!!!!!!!_----------------------------_!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!    
    wp_enqueue_style('temp', plugin_dir_url(__FILE__).'assets/css/temp.css');
}
add_action('wp_enqueue_scripts', 'tvds_homes_enqueue');

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