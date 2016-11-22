<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/2/2016
 * Time: 7:36 PM
 */


function tvds_booking_vc_elements(){
    //	Homes Display.
    //------------------------------------------
    vc_map(array(
        "name"                    	=> __('Huizen', 'tvds'),
        "base"                    	=> 'tvds_homes_display',
        "description"				=> __('Huizen weergeven', 'tvds'),
        "icon"                    	=> "",
        "show_settings_on_create" 	=> true,
        "category"                	=> __('TVDS Huizen', 'tvds'),
        "controls"                	=> "full",
        "save_always" 			  	=> true,
        "params"                  	=> array(
            array(
                "type" 				=> "dropdown",
                "class" 			=> "",
                "heading" 			=> __("Style Type", "tvds"),
                "param_name" 		=> "columns",
                "value" 			=> array(
                    __("1 kolom", "tvds") 	    => "col-md-12",
                    __("2 kolommen", "tvds")    => "col-md-6",
                    __("3 kolommen", "tvds") 	=> "col-md-4",
                    __("4 kolommen", "tvds") 	=> "col-md-3",
                ),
            ),
            array(
                'type'              => 'checkbox',
                "class" 			=> "",
                "heading" 			=> __("Toon details", "tvds"),
                "param_name" 		=> "show_details",
                "value" 			=> "",
            ),
            array(
                'type'              => 'checkbox',
                "class" 			=> "",
                "heading" 			=> __("Toon voorzieningen", "tvds"),
                "param_name" 		=> "show_services",
                "value" 			=> "",
            ),
            array(
                'type'              => 'checkbox',
                "class" 			=> "",
                "heading" 			=> __("Toon excerpt", "tvds"),
                "param_name" 		=> "show_excerpt",
                "value" 			=> "",
            ),
            array(
                "type" 				=> "textfield",
                "class" 			=> "",
                "heading" 			=> __("Aantal posts", "tvds"),
                "param_name" 		=> "max_posts",
                "value" 			=> "",
            ),
            array(
                "type" 				=> "textfield",
                "class" 			=> "",
                "heading" 			=> __("Extra Class", "tvds"),
                "param_name" 		=> "el_class",
                "value" 			=> "",
                "description" 		=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'themeawesome' )
            ),
        ),
    ));

    //	Homes Search.
    //------------------------------------------
    vc_map(array(
        "name"                    	=> __('Huizen zoeken', 'tvds'),
        "base"                    	=> 'tvds_homes_search',
        "description"				=> __('Huizen zoeken', 'tvds'),
        "icon"                    	=> "",
        "show_settings_on_create" 	=> true,
        "category"                	=> __('TVDS Huizen', 'tvds'),
        "controls"                	=> "full",
        "save_always" 			  	=> true,
        "params"                  	=> array(
            array(
                "type" 				=> "textfield",
                "class" 			=> "",
                "heading" 			=> __("Titel", "tvds"),
                "param_name" 		=> "title",
                "value" 			=> "",
            ),
            array(
                "type" 				=> "textfield",
                "class" 			=> "",
                "heading" 			=> __("Extra Class", "tvds"),
                "param_name" 		=> "el_class",
                "value" 			=> "",
                "description" 		=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'themeawesome' )
            ),
        ),
    ));
}
add_action( 'vc_before_init', 'tvds_booking_vc_elements' );

//	Homes Display Shortcode.
//------------------------------------------------------------
function tvds_homes_display_shortcode($atts, $content = null){
    // Get all the atts from the element
    $atts = vc_map_get_attributes( 'tvds_homes_display', $atts );
    extract( $atts );
    
    
    $columns = (isset($columns)) ? $columns : 'col-md-4';
    
    
	// The Query Arguments
    $args = array(
        'post_type'         => 'homes',
        'posts_per_page'    => (isset($max_posts)) ? $max_posts : '8',
    );

	// Pagination
    $args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;

	// The Query
    $the_query = new WP_Query($args);

    $output = '';

    global $post;

    // If have posts
    //------------------
    if($the_query->have_posts()) {
		
		// Start A Counter
		$i = 0;
		
        // Container Output
        $output .= '<div id="" class="tvds_vc_booking_display_homes">';

        while ($the_query->have_posts()): $the_query->the_post();
        
        	// Echo A Opening Row Div
/*
        	if($i%2 == 0){
	        	if($i >= 0){
			        $output .= '</div>';	
	        	}        	
            	$output .= "<div class='row'>";
        	}
*/

            $output .= '<div class="'.$columns.'">';

                if(has_post_thumbnail()){
                    $output .= '<div class="tvds_vc_booking_display_homes_image">';
                        $output .= '<img src="'.get_the_post_thumbnail_url().'"/>';
                    $output .= '</div>';
                }

                // Services

                $output .= '<div class="tvds_vc_booking_display_homes_service_details">';
                    if($show_services){
                        $output .= '<ul class="tvds_vc_booking_display_homes_services">';
                            // Wifi
                            if (get_post_meta($post->ID, 'wifi', true) == 1) {
                                $output .= '<li><i class="icon icon-signal"></i></li>';
                            }

                            // Pool
                            if (get_post_meta($post->ID, 'pool', true) == 1) {
                                $output .= '<li><i class="icon icon-swimming"></i></li>';
                            }

                            // Animals
                            if (get_post_meta($post->ID, 'animals', true) == 1) {
                                //                            $output .= '<li><i class="icon-guidedog"></i></li>';
                            }

                            // Alpine
                            if (get_post_meta($post->ID, 'alpine', true) == 1) {
                                $output .= '<li><i class="icon icon-skiing"></i></li>';
                            }

                            $output .= '<div class="clearfix"></div>';
                        $output .= '</ul>';
                    }

                    if($show_details){
                        $output .= '<ul class="tvds_vc_booking_display_homes_details">';
                            // Max Persons
                            if (get_post_meta($post->ID, 'max_persons', true)){
                                $output .= '<li><i class="icon icon-user"></i><span>'.get_post_meta($post->ID, 'max_persons', true).'</span></li>';
                            }

                            // Bedrooms
                            if (get_post_meta($post->ID, 'bedrooms', true)){
                                $output .= '<li><i class="icon icon-bed"></i><span>'.get_post_meta($post->ID, 'bedrooms', true).'</span></li>';
                            }

                            $output .= '<div class="clearfix"></div>';
                        $output .= '</ul>';
                    }

                    $output .= '<div class="clearfix"></div>';
                $output .= '</div>';

                // Title Excerpt
                $output .= '<div class="tvds_vc_booking_display_homes_info">';
                    $output .= '<h3>'.get_the_title().'</h3>';

                    if($show_excerpt){
                        $output .= '<p>'.get_the_excerpt().'</p>';
                    }
                $output .= '</div>';
                
                $output .= '<a href="'.get_the_permalink().'">'.__('Bekijk', 'tvds').'</a>';

            $output .= '</div>';
			
			// Increment The Counter
            $i++;
        endwhile;

        // Container Output
        $output .= '</div>';
    }

    // If there are no posts
    //------------------
    else {
        $output = 'There are no posts to display';
    }

    // Return the output
    return $output;
}
add_shortcode('tvds_homes_display', 'tvds_homes_display_shortcode');

//	Homes Search Shortcode.
//------------------------------------------------------------
function tvds_homes_search_shortcode($atts, $content = null){
    // Get all the atts from the element
    $atts = vc_map_get_attributes( 'tvds_homes_search', $atts );
    extract( $atts );


    $output = '<div class="tvds_homes_search_form">';
    
    	// If there is a title display it
    	if($title){
	    	$output .= '<div class="tvds_homes_search_form_head">';
	            $output .= '<h3>Huizen zoeken</h3>';
	        $output .= '</div>';	
    	}
        
        $output .= '<div class="tvds_homes_search_form_body">';

            $output .= '<form method="get" action="'.home_url().'/homes/">';
            	
            	
            	// Arrival Date
            	$output .= '<div class="tvds_homes_search_form_field_wrap">';
	                $output .= '<input class="datepicker" type="text" name="arrival_date" style="width: 100%;" placeholder="'.__('Vertrekdatum', 'tvds').'"/>';
            	$output .= '</div>';
    
				// Weeks
            	$output .= '<div class="tvds_homes_search_form_field_wrap">';

					// Bootstrap Select Button            	            	
            		$output .= '<a class="btn btn-default btn-select">';
            		
            			// The Hidden Value Field
						$output .= '<input type="hidden" class="btn-select-input" id="" name="weeks" value="" />';
						
						// Initial Title
						$output .= '<span class="btn-select-value">'.__('Aantal weken', 'tvds').'</span>';
						
						// Arrow icon
// 						$output .= '<span class="btn-select-arrow glyphicon glyphicon-chevron-down"></span>';
						
						// The Values
						$output .= '<ul>';
							for($x = 0; $x <= 20; $x++){
								$output .= '<li data-value="'.$x.'">'.$x.' Week</li>';
							}
						$output .= '</ul>';
					$output .= '</a>';

            	$output .= '</div>';

				// Max Persons
				$output .= '<div class="tvds_homes_search_form_field_wrap">';
					
					// Bootstrap Select Button
					$output .= '<a class="btn btn-default btn-select">';
						
						// The Hidden Value Field
						$output .= '<input type="hidden" class="btn-select-input" id="" name="max_person" value="" />';
						
						// Initial Title
						$output .= '<span class="btn-select-value">'.__('Aantal personen', 'tvds').'</span>';
						
						// Arrow Icon
// 						$output .= '<span class="btn-select-arrow glyphicon glyphicon-chevron-down"></span>';
						
						// The Values
						$output .= '<ul>';
							for($x = 0; $x <= 20; $x++){
								$output .= '<li data-value="'.$x.'">'.$x.' Personen</li>';
							}
						$output .= '</ul>';
					$output .= '</a>';

				$output .= '</div>';

				// Submit
                $output .= '<div class="tvds_homes_search_form_field_wrap submit-wrap">';
	                $output .= '<input type="submit" value="'.__('Zoeken', 'tvds').'"/>';
    			$output .= '</div>';
    			
    			// Clearfix
    			$output .= '<div class="clearfix"></div>';
            
            
            
            
            
/*
                // Keyword
                $output .= '<label class="tvds_homes_search_form_keyword" style="float: left; margin-right: 2.427%; width: 31.650%;">';
                    $output .= '<span>'.__('Zoekwoord', 'tvds').'</span><br/>';
                    $output .= '<input type="text" name="s" style="width: 100%;"/>';
                $output .= '</label>';

                // Place Filter
                $output .= '<label class="tvds_homes_search_form_place" style="float: left; margin-right: 2.427%; width: 31.650%;">';
                	
                	$output .= '<span>'.__('Plaats', 'tvds').'</span></br>';
                	
                	$output .= '<select name="place" style="width: 100%;">';
                    	$output .= '<option value="">Alle Plaatsen</option>';	
                    
						// Get All Place Taxonomies
						$place_terms = get_terms('homes_place', array('hide_empty' => false));
                	
	                	foreach($place_terms as $term){
		                	if(isset($place) == $term->slug){
			                	$output .= '<option selected value"'.$term->slug.'">'.$term->name.'</option>';
		                	}
		                	else {
			                	$output .= '<option value"'.$term->slug.'">'.$term->name.'</option>';
		                	}
	                	}                	
                	$output .= '</select>';
                $output .= '</label>';

                // Type Filter
                $output .= '<label class="tvds_homes_search_form_type" style="float: left; width: 31.650%;">';
                    $output .= '<span>'.__('Type', 'tvds').'</span></br>';
                    $output .= '<select name="type" style="width: 100%;">';
                        $output .= '<option value="">Alle Types</option>';

                        // Get All Type Taxonomies
                        $type_terms = get_terms('homes_type', array('hide_empty' => false));

                        foreach($type_terms as $term){
                            if(isset($type) == $term->slug){
                                $output .= '<option selected value="'.$term->slug.'">'.$term->name.'</option>';
                            }
                            else {
                                $output .= '<option value="'.$term->slug.'">'.$term->name.'</option>';
                            }
                        }
                    $output .= '</select>';
                $output .= '</label>';

                // Persons Filter
                $output .= '<label>'.__('Aantal Personen', 'tvds').'</label></br>';
                $output .= '<select name="max_persons">';
                    $output .= '<option value="">Kies aantal personen</option>';
                    for($x = 1; $x <= 20; $x++){
                        $output .= '<option value="'.$x.'">'.$x.'</option>';
                    }
                $output .= '</select>';
*/





            $output .= '</form>';

        $output .= '</div>';
    $output .= '</div>';

    // Return the output
    return $output;
}
add_shortcode('tvds_homes_search', 'tvds_homes_search_shortcode');