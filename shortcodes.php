<?php



// Booking Form
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_show_book_form(){
	
	// Validate And Send Booking to Cpt Booking
	if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')){

	    $post_information = array(
	        'post_title' 	=> wp_strip_all_tags($_POST['name'].' '. $_POST['last_name']),
	        'post_type' 	=> 'booking',
	        'post_status' 	=> 'publish',
	        'meta_input' 	=> array(
		        'home_id'		=> get_the_ID(),
		        
		        'name'			=> $_POST['name'],
		        'last_name'		=> $_POST['last_name'],
		        'street'		=> $_POST['street'],
		        'city'			=> $_POST['city'],
		        'postal'		=> $_POST['postal'],
		        'phone'			=> $_POST['phone'],
		        'email'			=> $_POST['email'],
		        'notes'			=> $_POST['notes'],
		        
		        'arrival_date' 	=> $_POST['arrival_date'],
		        'weeks'			=> $_POST['weeks'],
	        ),
	    );
		$post = wp_insert_post($post_information);
		
		if($post){

			// If The Post Is Accepted Send The Client A Confirmation E-mail
			$subject 	= 'Dit is de titel van het test bericht';
			$email 		= 'Dit is de inhoud van het test bericht';
			$to 		= $_POST['email'];
			$from 		= 'timvdslik@gmail.com';

			$headers   	= array();
			$headers[] 	= "MIME-Version: 1.0";
			$headers[] 	= "Content-type: text/plain; charset=iso-8859-1";
			$headers[] 	= "From: Realhosting Servicedesk <{$from}>";
			$headers[] 	= "Reply-To: Realhosting Servicedesk <{$from}>";
			//$headers[] = "Subject: {$subject}";
			$headers[] 	= "X-Mailer: PHP/".phpversion();

			mail($to, $subject, $email, implode("\r\n", $headers), "-f".$from );

			?>
			<script>
				window.location.href = '<?php echo esc_attr(get_option('confirmation_page')); ?>';
			</script>
			<?php
		}
	}

	echo get_the_ID().'<br>';
	
	
	echo json_encode(tvds_homes_booking_form_exclude_booked_days())
	?>
	
	<!-- The booking form -->
    <form action="" id="single-book-form" method="POST" data-booked-days='<?php echo json_encode(tvds_homes_booking_form_exclude_booked_days()); ?>'>
        
        <table>
            <tbody>
	            
	            <!-- Personal Info Section -->
	            <tr>
		            <th><?php echo __('Persoonsgegevens', 'tvds'); ?></th>
	            </tr>
	            <tr>
		            <td colspan="2"><hr/></td>
	            </tr>
	            
				<!-- First Name -->
	            <tr>
		            <td><label><?php echo __('Naam', 'tvds'); ?></label></td>
		            <td><input required minlength="2" type="text" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>"/>
	            </tr>

				<!-- Last Name -->	            
	            <tr>
		            <td><label><?php echo __('Achternaam', 'tvds'); ?></label></td>
		            <td><input required minlength="2" type="text" name="last_name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>"/>
	            </tr>
				
				<!-- Street -->
	            <tr>
		            <td><label><?php echo __('Straat', 'tvds') ?></label></td>
		            <td><input required type="text" name="street" value="<?php if(isset($_POST['street'])) echo $_POST['street']; ?>"/>
	            </tr>
	            
	            <!-- Woonplaats -->
	            <tr>
		            <td><label><?php echo __('Woonplaats', 'tvds') ?></label></td>
		            <td><input required type="text" name="city" value="<?php if(isset($_POST['city'])) echo $_POST['city']; ?>"/>
	            </tr>
	            
				<!-- Postal -->
	            <tr>
		            <td><label><?php echo __('Postcode', 'tvds') ?></label></td>
		            <td><input required type="text" name="postal" value="<?php if(isset($_POST['postal'])) echo $_POST['postal']; ?>"/>
	            </tr>
	            
	            <!-- Phone -->
	            <tr>
		            <td><label><?php echo __('Phone', 'tvds') ?></label></td>
		            <td><input required type="tel" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>"/>
	            </tr>
	            
	            <!-- E-mail -->
	            <tr>
		            <td><label><?php echo __('Email', 'tvds') ?></label></td>
		            <td><input required type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/>
	            </tr>
	            
	            
				<!-- Home Section -->
	            <tr>
		            <th><?php echo __('Huis', 'tvds'); ?></th>
	            </tr>
	            <tr>
		            <td colspan="2"><hr/></td>
	            </tr>
	            
				
				<!-- Arrival Date -->
	            <tr>
		            <td><label><?php echo __('Aankomst datum', 'tvds') ?></label></td>
		            <td><input required type="text" class="datepicker_booking_form" name="arrival_date" value="<?php if(isset($_POST['arrival_date'])) echo $_POST['arrival_date']; ?>"/>
	            </tr>
	            
				<!-- Weeks -->
	            <tr>
		            <td><label><?php echo __('Aantal weken', 'tvds') ?></label></td>
		            <td>
			            <select required name="weeks">
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
	<script>
		$("#single-book-form").validate();
	</script>
	<?php
}
add_action('tvds_single_home_sidebar_content', 'tvds_booking_show_book_form', 10);


