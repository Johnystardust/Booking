<?php 

// Custom booking filter widget
//---------------------------------------------------------------
class tvds_homes_last_minute_widget extends WP_Widget
{
    // Construct function.
	//---------------------------------------------------------------
    function __construct(){
        parent::__construct(
        // Base ID of your widget
            'tvds_homes_last_minute',

            // Widget name will appear in UI
            __('Huizen aanbiedingen/last-minute widget', 'tvds'),

            // Widget description
            array('description' => __('Last-minute huizen in een widget', 'tvds'),)
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
        $num_posts		= isset($instance['num_posts']) ? $instance['num_posts'] : 3;

		global $post;

        echo $args['before_widget'];

        if(!empty($title)){
	        echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $favorite_args = array(
	        'post_type' 		=> 'homes',
			'posts_per_page' 	=> $num_posts,
			'post__not_in'		=> array(get_the_id()),
			'orderby'       	=> 'meta_value',
		    'meta_query'  		=> array(
			    array(
				    'key'		=> 'last_minute',
				    'value' 	=> true,
				    'compare'	=> '=',
			    ),
		    ),
        );
        
        $favorite_query = new WP_Query($favorite_args);
        
        // Query The Posts
		if($favorite_query->have_posts()){
			
			echo '<div class="tvds_homes_favorite_widget_inner">';
				
				while($favorite_query->have_posts()) : $favorite_query->the_post();
				
					echo '<div class="tvds_homes_favorite_widget_row">';
						
						echo '<div class="tvds_homes_favorite_widget_thumbnail">';
							if(has_post_thumbnail()){
								the_post_thumbnail('thumbnail');
							}
						echo '</div>'; // tvds_homes_favorite_widget_thumbnail end					
						
						
						echo '<div class="tvds_homes_favorite_widget_content">';
							
							echo '<h4>'.get_the_title().'</h4>';
							
							echo '<div>Vanaf: <strong>€ '.get_post_meta($post->ID, 'min_week_price', true).'</strong></div>';
							
							echo '<a href="'.get_the_permalink().'" class="tvds_homes_btn small">'.__('Boek', 'tvds').'</a>';
							
						echo '</div>'; // tvds_homes_favorite_widget_content end
	
					echo '</div>'; // tvds_homes_favorite_widget_row end
									
			    endwhile;
			    
			echo '</div>'; // tvds_homes_favorite_inner end

			wp_reset_postdata();
		}
		else {
			echo '<p>There are no posts to display.</p>';
		}
        
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
        
        $num_posts = (isset($instance['num_posts'])) ? $instance['num_posts'] : 3;
        
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
	        <label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('Max Posts:'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" type="text" value="<?php echo esc_attr($num_posts); ?>"
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
        $instance['num_posts']		= (!empty($new_instance['num_posts'])) ? strip_tags($new_instance['num_posts']) : '';
        
        return $instance;
    }
}