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

        if(!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        ?>
        
       
        
        <form method="get">
			
			<!-- Type Filter -->
	        <select name="type" >
 		        <option value="">Alle Types</option>
 		        
 		        <?php
	 		        // If Filter Is Active
			        if(isset($_GET['type'])){
				        $type = $_GET['type'];
			        }	        

	 		        // Get All Type Taxonomies
	 				$terms = get_terms('homes_type', array('hide_empty' => false));
	 				
			        foreach($terms as $term){
				        ?>
				        <option <?php if(isset($type) == $term->slug){echo 'selected';} ?> value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
				        <?
			        }
 		        ?> 
	        </select></br></br>
	        
	        <select name="place">
 		        <option value="">Alle Plaatsen</option>
 		        
 		        <?php
	 		        // If Filter Is Active
	 		        if(isset($_GET['place'])){
				        $place = $_GET['place'];
			        }
			        
	 		      	// Get All Place Taxonomies
	 		      	$terms = get_terms('homes_place', array('hide_empty' => false));
	 		      	
	 		      	foreach($terms as $term){
				        ?>
				        <option <?php if(isset($place) == $term->slug){echo 'selected';} ?> value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
				        <?
			        }
	 		    ?>
	        </select></br></br>
	        
	        
			<?php
				// If Filter Is Active
				if(isset($_GET['wifi'])){
					$wifi = $_GET['wifi'];
				}
		    ?>
	        <label>Wifi</label></br>
	        <input type="checkbox" <?php if(isset($wifi) == 1){echo 'checked';} ?> value="1" name="wifi"/></br></br>
	        
	        <?php
				// If Filter Is Active
				if(isset($_GET['pool'])){
					$pool = $_GET['pool'];
				}
		    ?>
	        <label>Pool</label></br>
	        <input type="checkbox" <?php if(isset($pool) == 1){echo 'checked';} ?> value="1" name="pool"/></br></br>
	        
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
        if (isset($instance['title'])) {
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