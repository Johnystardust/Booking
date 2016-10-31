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
        'before_title' 	=> '<h4 class="widget-title">',
        'after_title' 	=> '</h4>',
    ));
}
add_action( 'widgets_init', 'tvds_booking_add_archive_sidebar' );

// Include All The Booking Widgets
//----------------------------------------------------------------------------------------------------------------------
include_once('booking-widget.php');

// Register All The Widgets
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_register_widget() {
	register_widget('tvds_booking_filter_widget');
}
add_action('widgets_init', 'tvds_booking_register_widget');
