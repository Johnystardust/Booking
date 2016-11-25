/**
 * Created by Tim on 10/30/2016.
 */
jQuery(document).ready(function($){
   	
	jQuery(".datepicker").datepicker();
	
	// Edit the Booking Info Data
	//----------------------------------------------------------------------------------------------------------------------
	$('#booking_booking_info').find('.enable_edit').click(function(){
		var popup = window.confirm('Are you sure you want to edit the data?');
		
		if(popup == true){
			$('#booking_booking_info').find('input, select, textarea').removeAttr('disabled');
		}
		else {
			
		}
	});
	
	// Edit the Booking Info Data
	//----------------------------------------------------------------------------------------------------------------------
	$('#booking_personal_info').find('.enable_edit').click(function(){
		var popup = window.confirm('Are you sure you want to edit the data?');
		
		if(popup == true){
			$('#booking_personal_info').find('input, select, textarea').removeAttr('disabled');
		}
		else {
			
		}
	});
	
	
	// Calendar Carousel
	//----------------------------------------------------------------------------------------------------------------------
	
	// Get Some Vars
	var wrapper 		= $('#tvds_booking_calendars_wrapper');
	var wrapperWidth 	= wrapper.width();
	var ul 				= $('.tvds_booking_calendars_container');
	var calendarsCount 	= ul.children().length;
	var calendar 		= wrapper.find('.tvds_calendar_item');
	var slideIndex 		= 0;
	
	// Set The CSS
	ul.width(wrapperWidth * calendarsCount);
	calendar.width(wrapperWidth);
	
	
	// Slide Function
	function slide(newSlideIndex){
		// Animate With CSS3 Transition
		var left =  wrapperWidth * slideIndex;
		ul.css('left', -left);
		
		// Run The Update Menu Function
		updateMenu(newSlideIndex);
	}
	
	// Update Menu
	function updateMenu(slideNumber){
// 		alert(slideNumber);
		
		// Hide Next If There Are No Next Slides
		if(slideNumber >= (calendarsCount - 1)){
			$('.tvds_booking_calendars_next').hide();
		}
		else {
			$('.tvds_booking_calendars_next').show();
		}
		
		// Hide Prev If There Are No Prev Slidex
		if(slideNumber <= 0){
			$('.tvds_booking_calendars_prev').hide();
		}
		else {
			$('.tvds_booking_calendars_prev').show();
		}
		
	}
	
	
	// Slide Prev
	$('.tvds_booking_calendars_prev').click(function(){
		slide(slideIndex -= 1);
	});
	
	// Slide Next
	$('.tvds_booking_calendars_next').click(function(){
		slide(slideIndex += 1);
	});
	

});