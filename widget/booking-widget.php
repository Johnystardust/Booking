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
            __('Booking filter widget', 'tvds'),

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


        echo $args['before_widget'];

        if(!empty($title)){
	        echo $args['before_title'] . $title . $args['after_title'];
        }

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

        ?>
        
        
        <form id="tvds_homes_search_form_widget_form" method="get" action="/themeawesome/homes/">

			<div class="tvds_homes_search_form_section">

				<div class="tvds_homes_search_form_group">
					<!-- Keyword -->
					<?php
					if(isset($_GET['s'])){
						$keyword = $_GET['s'];
					}

					if($show_labels){
						echo '<label>Zoekwoord</label>';
					}
					?>
					<input type="text" name="s" value="<?php if(isset($keyword)){ echo $keyword;} ?>" />
				</div>
			</div>


			<!-- Taxonomy Section-->
			<div class="tvds_homes_search_form_section">

				<div class="tvds_homes_search_form_group form_group_title">
					<h3>Zoeken</h3>
				</div>

				<?php
					echo tvds_homes_search_widget_form_taxonomy_fields('province', 'homes_province', 'Provincie', $taxonomy, $tax_slug, $show_labels);
					echo tvds_homes_search_widget_form_taxonomy_fields('region', 'homes_region', 'Regio', $taxonomy, $tax_slug, $show_labels);
					echo tvds_homes_search_widget_form_taxonomy_fields('place', 'homes_place', 'Plaats', $taxonomy, $tax_slug, $show_labels);
				?>
			</div>

			<!-- Date Section -->
			<div class="tvds_homes_search_form_section">
				<div class="tvds_homes_search_form_group form_group_title">
					<h3>Datum</h3>
				</div>

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


			<!-- Room Section -->
			<div class="tvds_homes_search_form_section">
				<div class="tvds_homes_search_form_group form_group_title">
					<h3>Room</h3>
				</div>

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


			<!-- Facilities Section -->
			<div class="tvds_homes_search_form_section">
				<div class="tvds_homes_search_form_group form_group_title">
					<h3>Faciliteiten</h3>
				</div>

				<!-- Wifi -->
				<div class="tvds_homes_search_form_group">
					<?php echo tvds_homes_search_widget_form_services_fields('wifi', 'Wifi'); ?>
				</div>

				<!-- Pool -->
				<div class="tvds_homes_search_form_group">
					<?php echo tvds_homes_search_widget_form_services_fields('pool', 'Zwembad'); ?>
				</div>

				<!-- Animals -->
				<div class="tvds_homes_search_form_group">
					<?php echo tvds_homes_search_widget_form_services_fields('animals', 'Huisdieren'); ?>
				</div>

				<!-- Alpine -->
				<div class="tvds_homes_search_form_group">
					<?php echo tvds_homes_search_widget_form_services_fields('alpine', 'Wintersport'); ?>
				</div>
			</div>

			<!-- Rating Section -->
			<div class="tvds_homes_search_form_section">
				<div class="tvds_homes_search_form_group form_group_title">
					<h3>Sterren</h3>
				</div>

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

	        
			<!-- Submit -->
	        <input type="submit" value="Filter"/>
        </form>

		<!-- Form Validation  -->
		<script>
			$("#tvds_homes_search_form_widget_form").submit(function() {
				// Remove The Name So The Input Doesnt Get Send When It Has No Value
				$('input[value=""]').attr('name', '');
			});
//			$("#tvds_homes_search_form_widget_form").validate();
		</script>
        
        <?php

        echo $args['after_widget'];
    }

	// Form function.
	//
	// Creating widget backend, this is where the edit happens
	//---------------------------------------------------------------
    public function form($instance){
	    
        if (isset($instance['title'])){
            $title = $instance['title'];
        } else {
            $title = __('New title', 'tvds');
        }
        
        
        if(isset($instance['show_labels'])){
	    	$show_labels = $instance['show_labels'];    
        }
        
        

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id('show_labels'); ?>"><?php _e('Show labels') ?></label>
	        <input id="<?php echo $this->get_field_id('show_labels'); ?>" name="<?php echo $this->get_field_name('show_labels'); ?>" type="checkbox" <?php if($show_labels){echo 'checked';} ?> value="1"/>
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

        return $instance;
    }
}