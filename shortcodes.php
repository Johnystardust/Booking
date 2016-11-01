<?php

// Booking Form
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_show_book_form(){
	
	// Validate And Send Booking to Cpt Booking
	if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')){
		
		
	    if(trim($_POST['postTitle']) === ''){
	        $postTitleError = 'Please enter a title.';
	        $hasError = true;
	    }
	    
	    $post_information = array(
	        'post_title' 	=> wp_strip_all_tags( $_POST['name'] ),
	        'post_content' 	=> $_POST['notes'],
	        'post_type' 	=> 'booking',
	        'post_status' 	=> 'publish',
	        'meta_input' 	=> array(
		        'home_id'		=> get_the_ID(),
		        'arrival_date' 	=> $_POST['arrival_date'],
		        'weeks'			=> $_POST['weeks'],
	        ),
	    );
		wp_insert_post($post_information);
	}
	
	?>
	<!-- The booking form -->
    <form action="" id="single-book-form" method="POST">
        
        <table>
            <tbody>
				<!-- Name -->
	            <tr>
		            <td><label>Naam</label></td>
		            <td><input type="text" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>"/>
					<?php 
						if($postTitleError != ''){
							echo '<span class="error">'.$postTitleError.'</span>';
						}
					?>
	            </tr>
				
				<!-- Address -->
	            <tr>
		            <td><label><?php echo __('Adres', 'tvds') ?></label></td>
		            <td><input type="text" name="address"/>
	            </tr>
				
				<!-- Arrival Date -->
	            <tr>
		            <td><label><?php echo __('Aankomst datum', 'tvds') ?></label></td>
		            <td><input type="text" class="datepicker" name="arrival_date"/>
	            </tr>
	            
				<!-- Weeks -->
	            <tr>
		            <td><label><?php echo __('Aantal weken', 'tvds') ?></label></td>
		            <td>
			            <select name="weeks">
				            <?php 
					            for ($x = 0; $x <= 20; $x++) {
						            echo '<option value="'.$x.'">'.$x.'</option>';
								}
					        ?>
			            </select>
		            </td>
	            </tr>

				<!-- Opmerkingen -->	            
	            <tr>
		            <td><label><?php echo __('Opmerkingen', 'tvds') ?></label></td>
		            <td>
			            <textarea  name="notes">
			            	<?php 
				            	if(isset($_POST['notes'])){ 
					            	if(function_exists('stripslashes')){ 
						            	echo stripslashes($_POST['notes']); 
						            } 
						            else { 
							            echo $_POST['notes']; 
							        }
							    }
			            	?>
			            </textarea>
			        </td>
	            </tr>
				<tr>
					<td></td>
		            <td>
			            <?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
			            <input type="hidden" name="submitted" id="submitted" value="true" />
						<button type="submit"><?php _e('Add Post', 'framework') ?></button>
		            </td>
	            </tr>
	            					            
            </tbody>
        </table>	 
	</form>
	<?php
}
add_action('tvds_after_single_home_content', 'tvds_booking_show_book_form');

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
	    "meta_query" => array( 
	        array(
	            "key" 		=> "home_id",
	            "value" 	=> get_the_ID(),
	        ),
	    ),
	);
	
	$query = new WP_Query( $args );
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
    
    // For Each Month Display a Calendar
    for ($x = 0; $x <= 12; $x++){
        $date = strtotime($current_month.'/1/'.$current_year);
        $newformat = date('Y-M',$date);
        
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
	}
}
add_action('tvds_after_single_home_content', 'tvds_booking_show_calendars');
