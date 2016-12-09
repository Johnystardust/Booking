<?php

// Register Booking Sidebar
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_add_archive_sidebar(){
    register_sidebar(array(
        'name' 			=> __( 'Booking sidebar', 'tvds'),
        'id' 			=> 'booking_sidebar',
        'description' 	=> __( 'Sidebar voor de booking archief pagina', 'tvds'),
        'before_widget' => '<div id="%1$s" class="booking-widget %2$s">',
        'after_widget' 	=> '</div>',
        'before_title' 	=> '<h3 class="widget-title">',
        'after_title' 	=> '</h3>',
    ));
    register_sidebar(array(
        'name' 			=> __( 'Single Homes sidebar', 'tvds'),
        'id' 			=> 'single_homes_sidebar',
        'description' 	=> __( 'Sidebar voor single homes pagina', 'tvds'),
        'before_widget' => '<div id="%1$s" class="homes-widget %2$s">',
        'after_widget' 	=> '</div>',
        'before_title' 	=> '<h3 class="widget-title">',
        'after_title' 	=> '</h3>',
    ));
}
add_action( 'widgets_init', 'tvds_booking_add_archive_sidebar' );

// Include All The Booking Widgets
//----------------------------------------------------------------------------------------------------------------------
include_once('booking-filter-widget.php');
include_once('homes-favorite-widget.php');
include_once('homes-for-sale-widget.php');
include_once('homes-last-minute-widget.php');

// Register All The Widgets
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_register_widget() {
	register_widget('tvds_booking_filter_widget');
	register_widget('tvds_homes_favorite_widget');
	register_widget('tvds_homes_for_sale_widget');
	register_widget('tvds_homes_last_minute_widget');
}
add_action('widgets_init', 'tvds_booking_register_widget');
