<?php 

// Custom booking filter widget
//---------------------------------------------------------------
class tvds_booking_filter_widget extends WP_Widget
{
    // Construct function.
	//---------------------------------------------------------------
    function __construct(){
        parent::__construct(
        // Base ID of your widget
            'tvds_booking_filter_widget',

            // Widget name will appear in UI
            __('Huizen filter widget', 'tvds'),

            // Widget description
            array('description' => __('Zoek huizen op categorieen en attributen', 'tvds'),)
        );
    }

    //  Widget function.
    //
    // Creating widget front-end, this is where the action happens
	//---------------------------------------------------------------
	/**
	 * @param array $args
	 * @param array $instance
     */
	public function widget($args, $instance){
        $title      	= apply_filters('widget_title', $instance['title']);
        $show_labels 	= (isset($instance['show_labels'])) ? $instance['show_labels'] : '';
        
        $show_search    = (isset($instance['show_search'])) ? $instance['show_search'] : '';
        $search_title   = (isset($instance['search_title'])) ? $instance['search_title'] : '';
        
        $show_location	= (isset($instance['show_location'])) ? $instance['show_location'] : '';
        $location_title = (isset($instance['location_title'])) ? $instance['location_title'] : '';
        
        $show_date		= (isset($instance['show_date'])) ? $instance['show_date'] : '';
        $date_title		= (isset($instance['date_title'])) ? $instance['date_title'] : '';
        
        $show_room		= (isset($instance['show_room'])) ? $instance['show_room'] : '';
        $room_title		= (isset($instance['room_title'])) ? $instance['room_title'] : '';
        
        $show_services  = (isset($instance['show_services'])) ? $instance['show_services'] : '';
        $services_title	= (isset($instance['services_title'])) ? $instance['services_title'] : '';
        
        $show_stars		= (isset($instance['show_stars'])) ? $instance['show_stars'] : '';
        $stars_title	= (isset($instance['stars_title'])) ? $instance['stars_title'] : '';


        echo $args['before_widget'];

		?>
		
		<div class="tvds_homes_search_filter_title">
			<?php
		        if(!empty($title)){        
			        echo $args['before_title'] . $title . $args['after_title'];
		        }
			?>
			
			<a id="tvds_homes_open_search_filter"><i class="icon icon icon-down-dir"></i></a>
		</div>
		
		<?php
		// If is taxonomy query by taxonomy
		if(is_tax()){
			// Get The Taxonomy and its slug
			$tax_url = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

			$taxonomy = $tax_url->taxonomy;
			$tax_slug = $tax_url->slug;
		}
		else {
			$taxonomy = null;
			$tax_slug = null;
		}


		$action_url = (!empty(get_option('rewrite_homes'))) ? home_url().'/'.get_option('rewrite_homes') : home_url().'/homes';
        ?>
        
        <div class="tvds_homes_search_filter_form">
	        
	    	<form id="tvds_homes_search_form_widget_form" method="get" autocomplete="off" action="<?php echo $action_url; ?>">

				<?php
					if($show_search){
						?>
						<!-- Keyword -->
						<div class="tvds_homes_search_form_section">
							<?php
								if(!empty($search_title)){
									echo '<div class="tvds_homes_search_form_group form_group_title">';
										echo '<h3>'.$search_title.'</h3>';
									echo '</div>';
								}
							?>
							
							<div class="tvds_homes_search_form_group">
								<?php
								if(isset($_GET['keyword'])){
									$keyword = $_GET['keyword'];
								}
			
								if($show_labels){
									echo '<label>Zoekwoord</label>';
								}
								?>
								<input type="text" name="keyword" value="<?php if(isset($keyword)){ echo $keyword;} ?>" />
							</div>
						</div>
						<?php
					}
					
					if($show_location){
						?>
						<!-- Taxonomy Section-->
						<div class="tvds_homes_search_form_section">
							<?php
								if(!empty($location_title)){
									echo '<div class="tvds_homes_search_form_group form_group_title">';
										echo '<h3>'.$location_title.'</h3>';
									echo '</div>';
								}
								
								echo tvds_homes_search_widget_form_taxonomy_fields('province', 'homes_province', 'Provincie', $taxonomy, $tax_slug, $show_labels);
								echo tvds_homes_search_widget_form_taxonomy_fields('region', 'homes_region', 'Regio', $taxonomy, $tax_slug, $show_labels);
								echo tvds_homes_search_widget_form_taxonomy_fields('place', 'homes_place', 'Plaats', $taxonomy, $tax_slug, $show_labels);
							?>
						</div>
						<?php
					}
					
					if($show_date){
						?>
						<!-- Date Section -->
						<div class="tvds_homes_search_form_section">
							<?php
								if(!empty($date_title)){
									echo '<div class="tvds_homes_search_form_group form_group_title">';
										echo '<h3>'.$date_title.'</h3>';
									echo '</div>';
								}
							?>
			
							<!-- Arrival Date -->
							<div class="tvds_homes_search_form_group">
								<?php
								if($show_labels){
									echo '<label>Aankomst Datum</label>';
								}
								?>
								<input type="text" class="datepicker" name="arrival_date" <?php if(isset($_GET['arrival_date'])) echo 'value="'.$_GET['arrival_date'].'"'; ?>/>
							</div>
			
							<div class="tvds_homes_search_form_group">
								<?php echo tvds_homes_search_widget_form_number_select_fields('weeks', 'Aantal Weken', 12 , $show_labels); ?>
							</div>
						</div>
						<?php
					}
					
					if($show_room){
						?>
						<!-- Room Section -->
						<div class="tvds_homes_search_form_section">
							<?php
								if(!empty($room_title)){
									echo '<div class="tvds_homes_search_form_group form_group_title">';
										echo '<h3>'.$room_title.'</h3>';
									echo '</div>';
								}
							?>
			
							<div class="tvds_homes_search_form_group">
								<?php echo tvds_homes_search_widget_form_taxonomy_fields('type', 'homes_type', 'Type', $taxonomy, $tax_slug, $show_labels); ?>
							</div>
			
							<!-- Persons Filter -->
							<div class="tvds_homes_search_form_group">
								<?php echo tvds_homes_search_widget_form_number_select_fields('max_persons', 'Aantal personen', 20 , $show_labels); ?>
							</div>
			
							<!-- Bedrooms Filter -->
							<div class="tvds_homes_search_form_group">
								<?php echo tvds_homes_search_widget_form_number_select_fields('bedrooms', 'Aantal Slaapkamers', 10 , $show_labels); ?>
							</div>
						</div>
	
						<?php
					}
	
					// Facilities Section
					if($show_services){
						echo '<div class="tvds_homes_search_form_section">';
							if(!empty($services_title)){
								echo '<div class="tvds_homes_search_form_group form_group_title">';
									echo '<h3>'.$services_title.'</h3>';
								echo '</div>';
							}
	
							// Get all the services
							$services = tvds_homes_get_services();
	
							foreach($services as $service){
								echo '<div class="tvds_homes_search_form_group">';
									echo tvds_homes_search_widget_form_services_fields($service['name'], $service['label']);
								echo '</div>';
							}
						echo '</div>';
					}
					
					if($show_stars){
						?>
						<!-- Rating Section -->
						<div class="tvds_homes_search_form_section">
							<?php
								if(!empty($stars_title)){
									echo '<div class="tvds_homes_search_form_group form_group_title">';
										echo '<h3>'.$stars_title.'</h3>';
									echo '</div>';
								}
							?>
			
							<div class="tvds_homes_search_form_group">
								<?php
			
								if(isset($_GET['stars'])){
									$rating = $_GET['stars'];
								}
								else {
									$rating = '';
								}
			
								for($x = 5; $x > 0; $x--){
									if($rating == $x){
										echo '<input id="tvds_stars_'.$x.'" checked type="radio" name="stars" value="'.$x.'">';
									}
									else {
										echo '<input id="tvds_stars_'.$x.'" type="radio" name="stars" value="'.$x.'">';
									}
			
			
									echo '<label for="tvds_stars_'.$x.'">';
										for($i = 5; $i > 0; $i--){
											if($i <= $x){
												echo '<i class="icon icon-star"></i>';
											}
										}
									echo '</label><br>';
								}
								?>
							</div>
						</div>
						<?php
					}		
				?>
	
				<!-- Submit -->
		        <input type="submit" value="Filter"/>
	        </form>
    
        </div>
        
		<!-- Form Validation  -->
		<script>
			jQuery("#tvds_homes_search_form_widget_form").submit(function() {
				// Remove The Name So The Input Doesnt Get Send When It Has No Value
				jQuery('input[value=""]').attr('name', '');
			});
		</script>
        
        <?php

        echo $args['after_widget'];
    }

	// Form function.
	//
	// Creating widget backend, this is where the edit happens
	//---------------------------------------------------------------
    public function form($instance){
	    // Widget Admin Form
        if (isset($instance['title'])){
            $title = $instance['title'];
        } else {
            $title = __('New title', 'tvds');
        }
        if(isset($instance['show_labels'])){
	    	$show_labels = $instance['show_labels'];    
        }
        
        // Enable Sections        
        (isset($instance['show_search'])) ? $show_search = $instance['show_search'] : '';
        (isset($instance['search_title'])) ? $search_title = $instance['search_title'] : '';
        
        (isset($instance['show_location'])) ? $show_location = $instance['show_location'] : '';
        (isset($instance['location_title'])) ? $location_title = $instance['location_title'] : '';
        
        (isset($instance['show_date'])) ? $show_date = $instance['show_date'] : '';
        (isset($instance['date_title'])) ? $date_title = $instance['date_title'] : '';
        
        (isset($instance['show_room'])) ? $show_room = $instance['show_room'] : '';
        (isset($instance['room_title'])) ? $room_title = $instance['room_title'] : '';

        (isset($instance['show_services'])) ? $show_services = $instance['show_services'] : '';
        (isset($instance['services_title'])) ? $services_title = $instance['services_title'] : '';
        
        (isset($instance['show_stars'])) ? $show_stars = $instance['show_stars'] : '';
        (isset($instance['stars_title'])) ? $stars_title = $instance['stars_title'] : '';

        
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
	        <input id="<?php echo $this->get_field_id('show_labels'); ?>" name="<?php echo $this->get_field_name('show_labels'); ?>" type="checkbox" <?php if($show_labels){echo 'checked';} ?> />
	        <label for="<?php echo $this->get_field_id('show_labels'); ?>"><?php _e('Show labels') ?></label>
        </p>
        
		<!-- Enable Sections -->
        <p>
	        <input id="<?php echo $this->get_field_id('show_search'); ?>" name="<?php echo $this->get_field_name('show_search'); ?>" type="checkbox" <?php if($show_search == true){echo 'checked';} ?> />
	        <label for="<?php echo $this->get_field_id('show_search'); ?>"><?php _e('Show Search') ?></label>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id('search_title'); ?>"><?php _e('Search title:'); ?></label><br>
	        <input class="widefat" type="text" name="<?php echo $this->get_field_name('search_title'); ?>" value="<?php if(!empty($search_title)){ echo $search_title; } ?>" />
        </p>
        
        <p>
	        <input id="<?php echo $this->get_field_id('show_location'); ?>" name="<?php echo $this->get_field_name('show_location'); ?>" type="checkbox" <?php if($show_location == true){echo 'checked';} ?> />
	        <label for="<?php echo $this->get_field_id('show_location'); ?>"><?php _e('Show Location') ?></label>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id('location_title'); ?>"><?php _e('Location title:'); ?></label><br>
	        <input class="widefat" type="text" name="<?php echo $this->get_field_name('location_title'); ?>" value="<?php if(!empty($location_title)){ echo $location_title; } ?>" />
        </p>
        
        <p>
	        <input id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" type="checkbox" <?php if($show_date == true){echo 'checked';} ?> />
	        <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show Date') ?></label>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id('date_title'); ?>"><?php _e('Date title'); ?></label><br>
	        <input class="widefat" type="text" name="<?php echo $this->get_field_name('date_title'); ?>" value="<?php if(!empty($date_title)){ echo $date_title; } ?>" />
        </p>
        
        <p>
	        <input id="<?php echo $this->get_field_id('show_room'); ?>" name="<?php echo $this->get_field_name('show_room'); ?>" type="checkbox" <?php if($show_room == true){echo 'checked';} ?> />
	        <label for="<?php echo $this->get_field_id('show_room'); ?>"><?php _e('Show Room') ?></label>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id('room_title'); ?>"><?php _e('Room title:'); ?></label><br>
	        <input class="widefat" type="text" name="<?php echo $this->get_field_name('room_title'); ?>" value="<?php if(!empty($room_title)){ echo $room_title; } ?>" />
        </p>
        
        <p>
	        <input id="<?php echo $this->get_field_id('show_services'); ?>" name="<?php echo $this->get_field_name('show_services'); ?>" type="checkbox" <?php if($show_services == true){echo 'checked';} ?> />
	        <label for="<?php echo $this->get_field_id('show_services'); ?>"><?php _e('Show Services') ?></label>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id('services_title'); ?>"><?php _e('Services title:'); ?></label><br>
	        <input class="widefat" type="text" name="<?php echo $this->get_field_name('services_title'); ?>" value="<?php if(!empty($services_title)){ echo $services_title; } ?>" />
        </p>
        
        <p>
	        <input id="<?php echo $this->get_field_id('show_stars'); ?>" name="<?php echo $this->get_field_name('show_stars'); ?>" type="checkbox" <?php if($show_stars == true){echo 'checked';} ?> />
	        <label for="<?php echo $this->get_field_id('show_stars'); ?>"><?php _e('Show Stars') ?></label>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id('stars_title'); ?>"><?php _e('Stars title:'); ?></label><br>
	        <input class="widefat" type="text" name="<?php echo $this->get_field_name('stars_title'); ?>" value="<?php if(!empty($stars_title)){ echo $stars_title; } ?>" />
        </p>
        
        <?php
    }

	// Update function.
	//
	// Updating widget replacing old instances with new
	//---------------------------------------------------------------
    public function update($new_instance, $old_instance){
        $instance = array();
        
        $instance['title']      	= (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['show_labels'] 	= (!empty($new_instance['show_labels'])) ? strip_tags($new_instance['show_labels']) : '';
        
        $instance['show_search'] 	= (!empty($new_instance['show_search'])) ? strip_tags($new_instance['show_search']) : '';
        $instance['search_title']	= (!empty($new_instance['search_title'])) ? strip_tags($new_instance['search_title']) : '';
        
        $instance['show_location'] 	= (!empty($new_instance['show_location'])) ? strip_tags($new_instance['show_location']) : '';
        $instance['location_title'] = (!empty($new_instance['location_title'])) ? strip_tags($new_instance['location_title']) : '';
        
        $instance['show_date'] 		= (!empty($new_instance['show_date'])) ? strip_tags($new_instance['show_date']) : '';
        $instance['date_title'] 	= (!empty($new_instance['date_title'])) ? strip_tags($new_instance['date_title']) : '';
        
        $instance['show_room'] 		= (!empty($new_instance['show_room'])) ? strip_tags($new_instance['show_room']) : '';
        $instance['room_title'] 	= (!empty($new_instance['room_title'])) ? strip_tags($new_instance['room_title']) : '';
        
        $instance['show_services'] 	= (!empty($new_instance['show_services'])) ? strip_tags($new_instance['show_services']) : '';
        $instance['services_title'] = (!empty($new_instance['services_title'])) ? strip_tags($new_instance['services_title']) : '';
        
        $instance['show_stars'] 	= (!empty($new_instance['show_stars'])) ? strip_tags($new_instance['show_stars']) : '';
        $instance['stars_title'] 	= (!empty($new_instance['stars_title'])) ? strip_tags($new_instance['stars_title']) : '';
        
        return $instance;
    }
}