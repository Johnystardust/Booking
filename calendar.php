<?php

// Calendars
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_show_calendars(){

	// Make Array for the booked days
	$booked_days = array();

	// The Query Arguments
	//
	// Get the bookings with the page ID
	$booking_args = array(
		'post_type' 		=> 'booking',
		'posts_per_page' 	=> -1,
		'orderby'       => 'meta_value',
		'post_status'	=> 'publish',
		"meta_query" => array(
			array(
				"key" 		=> "home_id",
				"value" 	=> get_the_ID(),
				'compare' 	=> '=',
			),
		),
	);

	$booking_query = new WP_Query($booking_args);

	if($booking_query->have_posts()){
		while($booking_query->have_posts()) : $booking_query->the_post();
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
	
	// Calendars Output
	$output = '<h3>'.__("Beschikbaarheid", "tvds").'</h3>';
	
	$output .= '<div class="tvds_booking_calendars">';
		
		// Calendars Nav
		$output .= '<div class="tvds_booking_calendars_nav">';
			
			$output .= '<a class="tvds_booking_calendars_prev"><span class="homes-chevron left"></span></a>';
			$output .= '<a class="tvds_booking_calendars_next"><span class="homes-chevron right"></span></a>';
			
		$output .= '</div>'; // tvds_booking_calendars_carousel_nav end
		
		// Calendars
		$output .= '<div class="tvds_booking_calendars_container">';
		
			$output .= '<ul>';
			
				// Get the number of calender months allowed in the future, if not set is 12
				$max_calendar_future = (!empty(get_option('max_future_calendars')) ? get_option('max_future_calendars') : 12);
				
				// For every month in the future draw a calendar
				for($x = 0; $x <= ($max_calendar_future - 1); $x++){
					
					$output .= '<li class="tvds_booking_calendars_item" data-index="'.$x.'">';
					
					
						// The Calendar
						$output .= '<div class="tvds_booking_calendar">';
						
							// Date Format For The Calendar Title
							$date 		= strtotime($current_month.'/1/'.$current_year);
							$newformat 	= date('Y-M',$date);
					
							// The Calendar Title
							$output .= '<div class="tvds_booking_calendars_title">';
								$output .= '<h3>'.$newformat.'</h3>';
							$output .= '</div>'; // tvds_booking_calendars_title end
							
							$booked_month = tvds_booking_get_booked_month($booked_days, $current_year, $current_month);
							$output .= tvds_booking_draw_calendar($current_month, $current_year, $booked_month);
					
							// If The Month Is December Start a New Year
							if($current_month > 11){
								$current_month = 1;
								$current_year++;
							}
							else {
								$current_month++;
							}

						$output .= '</div>'; // tvds_booking_calendar end
					
					$output .= '</li>'; // tvds_booking_calendars_item end
					
				}
			
			$output .= '</ul>'; // ul end
			
		$output .= '</div>'; // tvds_booking_calendars_container end
		
	$output .= '</div>'; // tvds_booking_calendars end 
	
	echo $output;
	
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
function tvds_booking_draw_calendar($month, $year, $booked_month){
	// days and weeks vars now ...
	//---------------------------------------------------------------
	$running_day 		= date('w',mktime(0,0,0,$month,1,$year));	// Number of days before Saturday
	$days_in_month 		= date('t',mktime(0,0,0,$month,1,$year));	// Number of days in the month
	$days_in_this_week 	= 1;
	$day_counter 		= 0;
	$dates_array 		= array();
	
	// Calendar Output
	$calendar = '<div class="tvds_booking_calendar_month">';
	
		// Calendar Headings
		$headings = array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');
		$calendar .= '<div class="calendar-heading calendar-row"><span class="calendar-day-head">'.implode('</span><span class="calendar-day-head">', $headings).'</span></div>';
	
		// Row For Week One
		//---------------------------------------------------------------
		$calendar.= '<div class="calendar-row">';
		
		// Print blank days till the first day of the week
		//---------------------------------------------------------------
		for($x = 0; $x < $running_day; $x++):
			$calendar.= '<span class="calendar-day-np"> </span>';
			$days_in_this_week++;
		endfor;
	
		// keep going with days....
		//---------------------------------------------------------------
		for($list_day = 1; $list_day <= $days_in_month; $list_day++):
			// Add The Day, If The Day Is In Booked Array Color It
			if(in_array($list_day, $booked_month)){
				$calendar.= '<span class="calendar-day calendar-day-booked">';
			}
			else {
				$calendar.= '<span class="calendar-day">';
			}
			
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
	
			/** QUERY THE DATABASE FOR AN ENdivY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);
			
			$calendar.= '</span>';
			if($running_day == 6):
				$calendar.= '</div>';
				if(($day_counter+1) != $days_in_month):
					$calendar.= '<div class="calendar-row">';
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
				$calendar.= '<span class="calendar-day-np"> </span>';
			endfor;
		endif;	
	
	$calendar .= '</div>'; // tvds_booking_calendar end
	
	// Return The Result
	return $calendar;
}