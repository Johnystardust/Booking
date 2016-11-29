/**
 * Created by Tim on 10/30/2016.
 */
jQuery(document).ready(function($){
    
    // Validate the booking form
	//----------------------------------------------------------------------------------------------------------------------
// 	$("#single-book-form").validate();
    



	// Jquery DatePicker Booking Form Disable All Booked Days And All Days Except Saturday
	//----------------------------------------------------------------------------------------------------------------------

	/** Days to be disabled as an array */
	var disableddates = ["12-3-2016","12-4-2016","12-5-2016","12-6-2016","12-7-2016","12-8-2016","12-9-2016","12-17-2016","12-18-2016","12-19-2016","12-20-2016","12-21-2016","12-22-2016","12-23-2016","12-24-2016","12-25-2016","12-26-2016","12-27-2016","12-28-2016","12-29-2016","12-30-2016"];


	function DisableBookedDates(date) {
		
		var booked_days = $('#single-book-form').attr('data-booked-days');
		booked_days = JSON.parse('['+booked_days+']');
		
		console.log(booked_days);

		var m = date.getMonth();
		var d = date.getDate();
		var y = date.getFullYear();

		// First convert the date in to the mm-dd-yyyy format
		// Take note that we will increment the month count by 1
		var currentdate = (m + 1) + '-' + d + '-' + y ;

		// We will now check if the date belongs to disableddates array
		for (var i = 0; i < disableddates.length; i++) {

			// Now check if the current date is in disabled dates array.
			if ($.inArray(currentdate, disableddates) != -1 ) {
				return [false];
			}
		}

		// Only Return When Saturday
		var day = date.getDay();

		// If day == 6 then it is Saturday
		if (day !== 6) {
			return [false] ;
		} else {
			return [true] ;
		}
		
	}

	$(function() {
		$(".datepicker_booking_form").datepicker({
			beforeShowDay: DisableBookedDates
		});
	});


	// Jquery DatePicker Search From Disable All Days Except Saturday
	//----------------------------------------------------------------------------------------------------------------------
	function DisableSpecificDates(date) {

		var m = date.getMonth();
		var d = date.getDate();
		var y = date.getFullYear();

		// First convert the date in to the mm-dd-yyyy format
		// Take note that we will increment the month count by 1
		var currentdate = (m + 1) + '-' + d + '-' + y ;

		// Only Return When Saturday
		var day = date.getDay();

		// If day == 6 then it is Saturday
		if (day !== 6) {
			return [false] ;
		} else {
			return [true] ;
		}

	}

	$(function() {
		$(".datepicker").datepicker({
			beforeShowDay: DisableSpecificDates
		});
	});
	
	
	
	
	
	
	
	// Bootstrap Select Buttons
	//----------------------------------------------------------------------------------------------------------------------
	
	// Get the value on reset
	$(document).ready(function () {
	    $(".btn-select").each(function (e) {
	        var value = $(this).find("ul li.selected").html();
	        if (value != undefined) {
	            $(this).find(".btn-select-input").val(value);
	            $(this).find(".btn-select-value").html(value);
	        }
	    });
	});
	
	// Send The Value To The Hidden Field
	$(document).on('click', '.btn-select', function (e) {
	    e.preventDefault();
	    var ul = $(this).find("ul");
	    
	    if ($(this).hasClass("active")) {
	        if (ul.find("li").is(e.target)) {
	            var target = $(e.target);
	            target.addClass("selected").siblings().removeClass("selected");
	            var value = target.attr('data-value');
	            var text = target.html();
	            $(this).find(".btn-select-input").val(value);
	            $(this).find(".btn-select-value").html(text);
				$(this).find(".btn-select-value").addClass('selected');
	        }
	        ul.hide();
	        $(this).removeClass("active");
	    }
	    else {
	        $('.btn-select').not(this).each(function () {
	            $(this).removeClass("active").find("ul").hide();
	        });
	        ul.slideDown(300);
	        $(this).addClass("active");
	    }
	});
	
	$(document).on('click', function (e) {
	    var target = $(e.target).closest(".btn-select");
	    if (!target.length) {
	        $(".btn-select").removeClass("active").find("ul").hide();
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
	
	
	
	
	
	
	
	// Homes Archive View
	//----------------------------------------------------------------------------------------------------------------------
	$('.tvds_homes_archive_view_btn').click(function(){
		var view = $(this).attr('data-view');
		
		if(view == 'grid'){
			$('.tvds_homes_archive_items_wrapper').removeClass('list');	
			$('.tvds_homes_archive_items_wrapper').addClass(view+' row');
			$('.tvds_homes_archive_items_wrapper').find('.tvds_homes_archive_item').removeClass('col-md-12');
			$('.tvds_homes_archive_items_wrapper').find('.tvds_homes_archive_item').addClass('col-md-4');
		}
		else if(view == 'list'){
			$('.tvds_homes_archive_items_wrapper').removeClass('grid row');	
			$('.tvds_homes_archive_items_wrapper').addClass(view);
			$('.tvds_homes_archive_items_wrapper').find('.tvds_homes_archive_item').removeClass('col-md-4');
			$('.tvds_homes_archive_items_wrapper').find('.tvds_homes_archive_item').addClass('col-md-12');
		}
		
		$('.tvds_homes_archive_view_btn').removeClass('active');	
		$(this).addClass('active');	
		
		
		

	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	

});