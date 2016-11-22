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
    public function widget($args, $instance){
        $title      = apply_filters('widget_title', $instance['title']);
        $text       = isset($instance['text']) ? $instance['text'] : '';


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

        ?>
        <form method="get">
	        
			<!-- Keyword -->
			<?php 
				if(isset($_GET['s'])){
					$keyword = $_GET['s'];
				}
			?>
			<label>Zoekwoord</label>
			<input type="text" name="s" value="<?php if(isset($keyword)){ echo $keyword;} ?>" /></br></br>
			
			<!-- Type Filter -->
			<label>Type</label>
	        <select name="type" >
 		        <option value="">Alle Types</option>
 		        
 		        <?php
	 		        // If Filter Is Active
			        if(isset($_GET['type'])) {
						$type = $_GET['type'];
					}
					elseif($taxonomy == 'homes_type'){
						$type = $tax_slug;
						echo $type;
					}

	 		        // Get All Type Taxonomies
	 				$terms = get_terms('homes_type', array('hide_empty' => false));
	 				
			        foreach($terms as $term){
				        if(isset($type) && $type == $term->slug){
					        echo '<option selected value="'.$term->slug.'">'.$term->name.'</option>';
				        }
				        else {
					        echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
				        }
			        }
 		        ?> 
	        </select></br></br>
	        
			<!-- Region Filter -->
			<label>Regio</label>
	        <select name="region">
 		        <option value="">Alle Regio's</option>
 		        
 		        <?php
	 		        // If Filter Is Active
	 		        if(isset($_GET['region'])){
				        $region = $_GET['region'];
			        }

	 		      	// Get All Place Taxonomies
	 		      	$terms = get_terms('homes_region', array('hide_empty' => false));
	 		      	
	 		      	foreach($terms as $term){
		 		      	if(isset($region) && $region == $term->slug){
			 		      	echo '<option selected value="'.$term->slug.'">'.$term->name.'</option>';
		 		      	}
		 		      	else {
			 		      	echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
		 		      	}
			        }
	 		    ?>
	        </select></br></br>

	        
			<!-- Place Filter -->
			<label>Plaats</label>
	        <select name="place">
 		        <option value="">Alle Plaatsen</option>
 		        
 		        <?php
	 		        // If Filter Is Active
	 		        if(isset($_GET['place'])){
				        $place = $_GET['place'];
			        }
			        
	 		      	// Get All Place Taxonomies
	 		      	$terms = get_terms('homes_place', array('hide_empty' => false));
	 		      	
	 		      	// For each Taxonomy check if it is t
	 		      	foreach($terms as $term){
		 		      	if(isset($place) && $place == $term->slug){
			 		      	echo '<option selected value="'.$term->slug.'">'.$term->name.'</option>';
		 		      	}
		 		      	else {
			 		      	echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
		 		      	}
			        }
	 		    ?>
	        </select></br></br>
	        
	        <!-- Arrival Date -->
	        <label>Aankomst Datum</label></br>
	        <input type="text" class="datepicker" name="arrival_date" value="<?php if(isset($_GET['arrival_date'])) echo $_GET['arrival_date']; ?>"/></br></br>
	        
	        <!-- Weeks Filter -->
	        <label>Aantal Weken</label></br>
	        <?php
		        // If Filter Is Active
		        if(isset($_GET['weeks'])){
			        $weeks = $_GET['weeks'];
		        }
		    ?>
            <select name="weeks">
		        <option value="">Maak keuze</option>
		        <?php 
		            for($x = 0; $x <= 20; $x++){
			            if($x == $weeks){
				        	echo '<option selected value="'.$x.'">'.$x.'</option>';    
			            }
			            else {
				            echo '<option value="'.$x.'">'.$x.'</option>';
			            }
					}
		        ?>
			</select></br></br>
            	        
	        <!-- Persons Filter -->
			<label>Aantal personen</label>
			<?php
				// If Filter Is Active
				if(isset($_GET['max_persons'])){
			        $max_persons = $_GET['max_persons'];
		        }
		    ?>
	        <select name="max_persons">
		        <option value="">Maak keuze</option>
		        
	            <?php
		            for($x = 1; $x <= 20; $x++){
			            if($x == $max_persons){
				            echo '<option selected value="'.$x.'">'.$x.'</option>';
			            }
			            else {
				            echo '<option value="'.$x.'">'.$x.'</option>';
			            }
		            }
		        ?>
            </select></br></br>
            
            <!-- Bedrooms Filter -->
			<label>Aantal Slaapkamers</label>
			<?php
				// If Filter Is Active
				if(isset($_GET['bedrooms'])){
			        $bedrooms = $_GET['bedrooms'];
		        }
		    ?>
	        <select name="bedrooms">
		        <option value="">Maak keuze</option>
		        
	            <?php
		            for($x = 1; $x <= 10; $x++){
			            if($x == $bedrooms){
				            echo '<option selected value="'.$x.'">'.$x.'</option>';
			            }
			            else {
				            echo '<option value="'.$x.'">'.$x.'</option>';
			            }
		            }
		        ?>
            </select></br></br>
	        
			<!-- Wifi -->
			<?php
				// If Filter Is Active
				if(isset($_GET['wifi'])){
					$wifi = $_GET['wifi'];
				}
		    ?>
	        <label>Wifi</label></br>
	        <input type="checkbox" <?php if(isset($wifi) == 1){echo 'checked';} ?> value="1" name="wifi"/></br></br>

			<!-- Pool -->	        
	        <?php
				// If Filter Is Active
				if(isset($_GET['pool'])){
					$pool = $_GET['pool'];
				}
		    ?>
	        <label>Pool</label></br>
	        <input type="checkbox" <?php if(isset($pool) == 1){echo 'checked';} ?> value="1" name="pool"/></br></br>
	        
   			<!-- Animals -->
	        <?php
				// If Filter Is Active
				if(isset($_GET['animals'])){
					$animals = $_GET['animals'];
				}
		    ?>
	        <label>Dieren</label></br>
	        <input type="checkbox" <?php if(isset($animals) == 1){echo 'checked';} ?> value="1" name="animals"/></br></br>
	        
			<!-- Alpine -->
	        <?php
				// If Filter Is Active
				if(isset($_GET['alpine'])){
					$alpine = $_GET['alpine'];
				}
		    ?>
	        <label>Wintersport</label></br>
	        <input type="checkbox" <?php if(isset($alpine) == 1){echo 'checked';} ?> value="1" name="alpine"/></br></br>
	        
			<!-- Clear all Filters -->
	        <?php $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2); ?>
	        <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0]; ?>">Clear all filters</a><br/><br/>
	        
			<!-- Submit -->
	        <input type="submit" value="Filter"/>
	        
        </form>
        
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

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>

        <?php
    }

	// Update function.
	//
	// Updating widget replacing old instances with new
	//---------------------------------------------------------------
    public function update($new_instance, $old_instance){
        $instance = array();
        $instance['title']      = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}