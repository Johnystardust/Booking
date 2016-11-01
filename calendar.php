<?php

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
