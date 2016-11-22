<?php

// Calendars
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_show_calendars(){

	// Make Array for the booked days
	$booked_days = array();

	// The Query Arguments
	//
	// Get the bookings with the page ID
	$args = array(
		'post_type' 	=> 'booking',
		'orderby'       => 'meta_value',
		'post_status'	=> 'publish',
		"meta_query" => array(
			array(
				"key" 		=> "home_id",
				"value" 	=> get_the_ID(),
			),
		),
	);

	$query = new WP_Query($args);
	if($query->have_posts()){
		while($query->have_posts()) : $query->the_post();
			$arrival_date 	= get_post_meta(get_the_ID(), 'arrival_date', true);
			$weeks 			= get_post_meta(get_the_ID(), 'weeks', true);

			$start_date = new DateTime($arrival_date);
			$end_date 	= new DateTime($arrival_date);

			$end_date->modify('+'.$weeks.' week');

			$interval = DateInterval::createFromDateString('+1 day');
			$period	= new DatePeriod($start_date, $interval, $end_date);

			foreach($period as $datetime){
				$booked_days[] = $datetime->format('Y-m-d');
			}
		endwhile;

		wp_reset_postdata();
	}

	// Get The Current Date And Extract Year & Month
	$date = new DateTime();
	$current_year  = $date->format('Y');
	$current_month = $date->format('m');

	// Calendars Container
	echo '<div id="tvds_booking_calendars_wrapper">';
	echo '<div class="tvds_booking_calendars_container">';

	// For Each Month Display a Calendar
	for ($x = 0; $x <= 12; $x++){
		$date = strtotime($current_month.'/1/'.$current_year);
		$newformat = date('Y-M',$date);

		echo '<div class="calendar">';
		echo '<h2>'.$newformat.'</h2>';
		$booked_month = tvds_booking_get_booked_month($booked_days, $current_year, $current_month);
		echo tvds_booking_draw_calendar($current_month, $current_year, $booked_month);

		// If The Month Is December Start a New Year
		if($current_month > 11){
			$current_month = 1;
			$current_year++;
		}
		else {
			$current_month++;
		}
		echo '</div>';
	}
	echo '<div class="clearfix"></div>';
	echo '</div>';
	echo '</div>';
}
add_action('tvds_after_single_home_content', 'tvds_booking_show_calendars', 20);
add_shortcode('tvds_booking_calendar', 'tvds_booking_show_calendars');

// Return All The Booked Days In A Month
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_get_booked_month($booked_days, $year, $month){
	// Get Leading 0 If Is One Character
	$month = sprintf('%02d', $month);

	// Make Array For The Booked Day
	$booked_month = array();

	// Get All The Booked Days From A Month & Year
	foreach($booked_days as $key => $booked_day){
		if(strpos($booked_day, $year.'-'.$month) !== false){
			$booked_day = str_replace($year.'-'.$month.'-', "", $booked_day);
			array_push($booked_month, $booked_day);
		}
	}
	return $booked_month;
}

// Draw Calendar
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_draw_calendar($month,$year, $booked_month){
	// Draw Table
	//---------------------------------------------------------------
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	// Table Headings
	//---------------------------------------------------------------
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	// days and weeks vars now ...
	//---------------------------------------------------------------
	$running_day 		= date('w',mktime(0,0,0,$month,1,$year));	// Number of days before Saturday
	$days_in_month 		= date('t',mktime(0,0,0,$month,1,$year));	// Number of days in the month
	$days_in_this_week 	= 1;
	$day_counter 		= 0;
	$dates_array 		= array();

	// Row For Week One
	//---------------------------------------------------------------
	$calendar.= '<tr class="calendar-row">';
	
	// Print blank days till the first day of the week
	//---------------------------------------------------------------
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	// keep going with days....
	//---------------------------------------------------------------
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		// Add The Day, If The Day Is In Booked Array Color It
		if(in_array($list_day, $booked_month)){
			$calendar.= '<td style="background-color: #333333;" class="calendar-day">';
		}
		else {
			$calendar.= '<td class="calendar-day">';
		}
		
		$calendar.= '<div class="day-number">'.$list_day.'</div>';

		/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		$calendar.= str_repeat('<p> </p>',2);
		
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	// finish the rest of the days in the week
	//---------------------------------------------------------------
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	// final row
	//---------------------------------------------------------------
	$calendar.= '</tr>';

	// end the table
	//---------------------------------------------------------------
	$calendar.= '</table>';
	
	// all done, return result
	//---------------------------------------------------------------
	return $calendar;
}
