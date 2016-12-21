<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/2/2016
 * Time: 7:36 PM
 */


function tvds_booking_vc_elements(){

	// Include All The Elements
	include_once('elements/vc_display_homes.php');
	include_once('elements/vc_display_services.php');
	include_once('elements/vc_display_regions.php');
	include_once('elements/vc_display_homes_search.php');
}
add_action( 'vc_before_init', 'tvds_booking_vc_elements' );