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
		        'home_id'		=> $_POST['home_id'],
	
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
			$subject 	= 'Reservering vakantie';
			$to 		= $_POST['email'];
			$from		= 'timvdslik@gmail.com';
			
			$headers   	= array();
			$headers[] 	= "MIME-Version: 1.0";
			$headers[] 	= "Content-Type: text/html; charset=ISO-8859-1";
			$headers[] 	= "From: Tim van der Slik <{$from}>";
			$headers[] 	= "Reply-To: Tim van der Slik <{$from}>";
			//$headers[] = "Subject: {$subject}";
			$headers[] 	= "X-Mailer: PHP/".phpversion();
			
			$email = '<html><body>';
				$email .= '<h3>Beste '.$_POST['name'].'</h3>';
				$email .= 'U heeft een reservering bij ons gedaan voor het vakantie huis '.$_POST['home_id'].'. Let op dit is geen bevestiging deze zal worden gedaan nadat u de factuur betaald heeft. U zult spoedig van ons een factuur ontvangen.';
				
				$email .= '<table>';
					$email .= '<tr>';
						$email .= '<td>Vakantiehuis</td>';
						$email .= '<td>'.$_POST['home_id'].'</td>';
					$email .= '</tr>';
				
					$email .= '<tr>';
						$email .= '<td>Aankomst datum</td>';
						$email .= '<td>'.$_POST['arrival_date'].'</td>';
					$email .= '</tr>';
					
					$email .= '<tr>';
						$email .= '<td>Aantal weken</td>';
						$email .= '<td>'.$_POST['weeks'].'</td>';
					$email .= '</tr>';
				$email .= '</table>';
				
				$email .= 'Heeft u nog vragen of opmerkingen dan staan wij voor u klaar. U kunt ons bereiken op:';
				$email .= 'Tel: <a href="tel:0612345678">06 123 456 78</a>';
				$email .= 'Mail: <a href="mailto:timvdslik@gmail.com">timvdslik@gmail.com</a>';
				$email .= 'Adres: Broerenstraat 39-35';
				$email .= 'Postcode: 6811 EB';
				$email .= 'Plaats: Arnhem';
				
			$email .= '</body></html>';
			
			
			
			
	
			if(mail($to, $subject, $email, implode("\r\n", $headers), "-f".$from )){
				?>
				<script>
					window.location.href = '<?php echo esc_attr(get_option('confirmation_page')); ?>';
				</script>					
				<?php
			}
			else {
				echo "<h1>ERRORS</h1>";
			}
		}
	}
	?>

    
    <!-- The Booking Form -->
    <div class="tvds_homes_booking_form">
	    
	    <!-- The Form Title -->
	    <div class="tvds_homes_booking_form_title">
		    <h3><?php echo __('Boek nu!', 'tvds'); ?></h3>
	    </div>

	    <?php
		    // Get The Booked Days And See If It Is An Array So We Can Use It in The JS Function
		    $booked_days = tvds_homes_booking_form_exclude_booked_days();
		    
		    if(is_array($booked_days)){
			    $booked_days = json_encode($booked_days);
		    }
		    else {
			    $booked_days = NULL;
		    }
	    ?>

		<!-- The Form -->
	    <form autocomplete="off" action="<?php /* echo plugin_dir_url(__FILE__).'booking-confirmation.php'; */ ?>" id="single-book-form" method="POST" data-booked-days='<?php echo $booked_days; ?>'>
		    <div class="row">
				<input type="hidden" name="home_id" value="<?php echo get_the_ID(); ?>"/>

				<!-- Get The Text Fields Via Function -->
				<?php
					echo tvds_homes_booking_form_text_input(__('Naam', 'tvds'), 'text', 'name', true);
					echo tvds_homes_booking_form_text_input(__('Achternaam', 'tvds'), 'text', 'last_name', true, 2);
					echo tvds_homes_booking_form_text_input(__('Straat/huisnummer', 'tvds'), 'text', 'street', true);
					echo tvds_homes_booking_form_text_input(__('Woonplaats', 'tvds'), 'text', 'city', true);
					echo tvds_homes_booking_form_text_input(__('Postcode', 'tvds'), 'text', 'postal', true);
					echo tvds_homes_booking_form_text_input(__('Phone', 'tvds'), 'text', 'phone', true);
					echo tvds_homes_booking_form_text_input(__('Email', 'tvds'), 'text', 'email', true);
				?>

				<!-- Arrival Date -->
				<div class="tvds_homes_booking_form_group col-sm-6 col-xs-12">
					<label><?php echo __('Aankomst datum', 'tvds') ?></label>
					<input required type="text" class="datepicker_booking_form" name="arrival_date" value="<?php if(isset($_POST['arrival_date'])) echo $_POST['arrival_date']; ?>"/>
				</div>

				<!-- Weeks -->
				<div class="tvds_homes_booking_form_group col-sm-6 col-xs-12">
					<label><?php echo __('Aantal weken', 'tvds') ?></label><br>
					<select required id="tvds_homes_booking_form_weeks" name="weeks">
						<option><?php echo __('Aantal weken', 'tvds'); ?></option>

						<?php
							for ($x = 1; $x <= 20; $x++) {
								echo '<option value="'.$x.'">'.$x.'</option>';
							}
						?>
					</select>
				</div>

				<!-- Notes -->
				<div class="tvds_homes_booking_form_group col-sm-12 col-xs-12">
					<label><?php echo __('Opmerkingen', 'tvds') ?></label>
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
				</div>

				<!-- Submit -->
				<div class="tvds_homes_booking_form_group col-sm-12 col-xs-12">
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					<input type="hidden" name="submitted" id="submitted" value="true" />
					<button type="submit"><?php _e('Boeken', 'tvds') ?></button>
				</div>
			</div>
		</form>
		
		<!-- Validate on send -->
		<script>
			jQuery("#single-book-form").validate();
		</script>
			
    </div>
	<?php
}

if(get_option('single_sidebar')){
	add_action('tvds_single_home_sidebar_content', 'tvds_booking_show_book_form', 10);
}
else {
	add_action('tvds_after_single_home_content', 'tvds_booking_show_book_form', 20);
}
add_shortcode('tvds_booking_form', 'tvds_booking_show_book_form');