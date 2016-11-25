<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/2/2016
 * Time: 7:36 PM
 */


function tvds_booking_vc_elements(){

	// Include All The Elements
	include_once('elements/vc_display_homes.php');
	
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