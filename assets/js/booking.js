/**
 * Created by Tim on 10/30/2016.
 */
jQuery(document).ready(function($){
    
    // Jquery DatePicker Booking Form Disable All Booked Days And All Days Except Saturday
	//----------------------------------------------------------------------------------------------------------------------
	function DisableBookedDates(date) {	

		var booked_days = $('#single-book-form').attr('data-booked-days');
		booked_days = JSON.parse('['+booked_days+']');
		booked_days = $.map(booked_days, function(el){return el});

		var m = date.getMonth();
		var d = date.getDate();
		var y = date.getFullYear();

		// First convert the date in to the mm-dd-yyyy format
		// Take note that we will increment the month count by 1
		var currentdate = (m + 1) + '-' + d + '-' + y ;

		// We will now check if the date belongs to disableddates array
		for (var i = 0; i < booked_days.length; i++) {
			
			// Now check if the current date is in disabled dates array.
			if ($.inArray(currentdate, booked_days) != -1 ){
				console.log(currentdate);
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
	
	// Jquery DatePicker Booking Form Disable Booked Weeks
	//----------------------------------------------------------------------------------------------------------------------
	function DisableBookedWeeks(date){

		// Get The Selected Date
		var selected_date = $(this).datepicker('getDate');
		var date = new Date(selected_date);
		
		// Get The Booked Days	
		var booked_days = $('#single-book-form').attr('data-booked-days');
		booked_days = JSON.parse('['+booked_days+']');
		booked_days = $.map(booked_days, function(el){return el});
		
		// Loop Over The Weeks
		for(var x = 1; x < 20; x++){
						
			// Add Weeks to the Selected Date		
			var weekLater = new Date(date.getFullYear(), date.getMonth(), date.getDate() + ((1 * 7) * x) - 1);			
				
			// Make It A Useable Date
			var d = weekLater.getDate();
			var m =  weekLater.getMonth();
			m += 1;  // JavaScript months are 0-11
			var y = weekLater.getFullYear();
			
			
			var selected_date = m + "-" + d + "-" + y;
			
			// If The weekLater Date is in The Booked_days Remove all the next weeks
			if($.inArray(selected_date, booked_days) != -1){
				
				// If A Date is Booked Run The Function To Disable The options In The Select
				DisableBookedWeeksSelectOptions(x)
				return false;
			}
			else {
				$('#tvds_homes_booking_form_weeks option').removeAttr('disabled');
			}
		}
	}
	
	// Weeks Select Field Disable Booked Weeks
	//----------------------------------------------------------------------------------------------------------------------
	function DisableBookedWeeksSelectOptions(max_weeks){
		
		$('#tvds_homes_booking_form_weeks option').attr('disabled', 'disabled');
		
		max_weeks = max_weeks - 1;
		
		for(var x = 1; x <= max_weeks; x++){
			$('#tvds_homes_booking_form_weeks option[value="'+x+'"]').removeAttr('disabled');
		}
	}
	
	// Booking Form Datepicker Function
	$(function() {
		$(".datepicker_booking_form").datepicker({
			dateFormat: 'd-m-yy',
			beforeShowDay: DisableBookedDates,
			onSelect: DisableBookedWeeks,
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

	// Filter Form Datepicker Function
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

	// Booking Calendar
	//----------------------------------------------------------------------------------------------------------------------
	$('.tvds_booking_calendars').each(function(){
		tvds_booking_calendars($(this));
	});
	
	function tvds_booking_calendars(obj){
		
		var ul 				= obj.find('ul');
		var num_calendars	= ul.children().length;
		var calendar_index 	= 0;
		
		var nav_prev		= obj.find('.tvds_booking_calendars_prev');
		var nav_next		= obj.find('.tvds_booking_calendars_next');
		
		var calendar_item 	= obj.find('.tvds_booking_calendars_item');
		var calendar_height = 0;		
		
		calendar_height = obj.find(calendar_item).first().outerHeight();
		
		$('.tvds_booking_calendars').height(calendar_height);
		
		// Set The Active Calendar
		obj.find(calendar_item).first().addClass('active_calendar');
		
		// Hide The Nav Prev at First
		nav_prev.hide();
		
		// Slide Next
		nav_next.click(function(){
			calendar_slide(calendar_index + 1);
		});
		
		// Slide Prev
		nav_prev.click(function(){
			calendar_slide(calendar_index - 1);
		});
		
		// The Slide/Fade Function
		function calendar_slide(new_calendar_index){
			
			// Remove the current active class		
			calendar_item.removeClass('active_calendar');
			
			// Add New Active Class
			$('.tvds_booking_calendars_item[data-index="'+new_calendar_index+'"]').addClass('active_calendar');
			
			// Get The New Calendar Height
			var new_height = $('.tvds_booking_calendars_item[data-index="'+new_calendar_index+'"]').outerHeight();
			$('.tvds_booking_calendars').height(new_height);

			calendar_index = new_calendar_index;
			
			update_menu(new_calendar_index);
		}
		
		// Update Menu Function
		function update_menu(new_calendar_index){
			
			if(new_calendar_index >= (num_calendars -1)){
				nav_next.hide();
			}
			else {
				nav_next.show();
			}
			
			
			if(new_calendar_index < 1){
				nav_prev.hide();
			}
			else {
				nav_prev.show();
			}
		}
	}
	
	// Homes Filter Widget Open/close
	//----------------------------------------------------------------------------------------------------------------------
	$('#tvds_homes_open_search_filter').on('click', function(){
		// Get The Height Of The
		var form_height = $('#tvds_homes_search_form_widget_form').outerHeight();
		
		// Add The Toggle Class
		$('.tvds_homes_search_filter_title').toggleClass('tvds_open');

		// Open The Form		
		if($('.tvds_homes_search_filter_title').hasClass('tvds_open')){
			$('.tvds_homes_search_filter_form').css('max-height', form_height);
		}
		else {
			$('.tvds_homes_search_filter_form').css('max-height', 0);
		}
	});
	
	$(window).resize(function(){
		if($(window).width() > 992){
			var form_height = $('#tvds_homes_search_form_widget_form').outerHeight();
			$('.tvds_homes_search_filter_form').css('max-height', form_height);
		}
		else {
			$('.tvds_homes_search_filter_form').css('max-height', 0);
		}
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


