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
	
	// Homes Options Page
	//----------------------------------------------------------------------------------------------------------------------

	// Hiding proccess
	function headerOptions(chosenValue){
		if(chosenValue == 'image'){
			$('.header_options').hide();
			$('.header_image').show();
		}
		else if(chosenValue == 'slider'){
			$('.header_options').hide();
			$('.header_slider').show();
		}
		else if(chosenValue == 'none'){
			$('.header_options').hide();
		}
	}
	
	// On Start/Ready
	headerOptions($('.header_select').val());
	
	// On Change
	$('.header_select').on('change', function(){
		var chosenValue = this.value;
		headerOptions(chosenValue);
		return false;
	});

	// Hiding Procces
	function singleHeaderOptions(chosenValue){
		if(chosenValue == 'image'){
			$('.single_header_options').hide();
			$('.single_header_image').show();
		}
		else if(chosenValue == 'slider'){
			$('.single_header_options').hide();
			$('.single_header_slider').show();
		}
		else if(chosenValue == 'none'){
			$('.single_header_options').hide();
		}
	}
	
	// On Start/Ready
	singleHeaderOptions($('.single_header_select').val());

	// On Change	
	$('.single_header_select').on('change', function(){
		var chosenValue = this.value;
		singleHeaderOptions(chosenValue);
		return false;
	});
	

});