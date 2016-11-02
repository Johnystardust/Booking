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
	
	

});