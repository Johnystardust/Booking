/**
 * Created by Tim on 10/30/2016.
 */
jQuery(document).ready(function($){
    
    // Validate the booking form
	//----------------------------------------------------------------------------------------------------------------------
	jQuery("#single-book-form").validate();
    
	
    // Disable days in date picker
	//----------------------------------------------------------------------------------------------------------------------

	/** Days to be disabled as an array */
	var disableddates = ["11-5-2016", "11-12-2016", "10-26-2016", "10-26-2016"];

	function DisableSpecificDates(date) {

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
	

});