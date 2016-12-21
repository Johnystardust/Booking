<?php
	
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
	    
	    // General Options
	    //----------------
	    
	    // Title
        array(
            "type" 				=> "textfield",
            "class" 			=> "",
            "heading" 			=> __("Titel", "tvds"),
            "param_name" 		=> "title",
            "value" 			=> "",
        ),
        
        // Extra Class
        array(
            "type" 				=> "textfield",
            "class" 			=> "",
            "heading" 			=> __("Extra Class", "tvds"),
            "param_name" 		=> "el_class",
            "value" 			=> "",
            "description" 		=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'themeawesome' ),
        ),
        
        // Design Options
        //---------------
        
        // Design
        array(
            "type" 				=> "dropdown",
            "class" 			=> "",
            "heading" 			=> __("Desig", "tvds"),
            "param_name" 		=> "design",
            "value" 			=> array(
                __("Volledig", "tvds") 	 => "full",
                __("Compact", "tvds")    => "small",
            ),
			"group"				=> __("Design opties", 'tvds'),
        ),

		// Show Keyword
		array(
			'type'              => 'checkbox',
			"class" 			=> "",
			"heading" 			=> __("Toon zoekwoord", "tvds"),
			"param_name" 		=> "show_keyword",
			"value" 			=> false,
			"group"				=> __("Design opties", 'tvds'),
			'dependency'		=> array(
				'element' => 'design',
				'value' => 'full',
			),
		),

		// Show Province
		array(
			'type'              => 'checkbox',
			"class" 			=> "",
			"heading" 			=> __("Toon provincie", "tvds"),
			"param_name" 		=> "show_province",
			"value" 			=> false,
			"group"				=> __("Design opties", 'tvds'),
			'dependency'		=> array(
				'element' => 'design',
				'value' => 'full',
			),
		),

		// Show Type
		array(
			'type'              => 'checkbox',
			"class" 			=> "",
			"heading" 			=> __("Toon type", "tvds"),
			"param_name" 		=> "show_type",
			"value" 			=> false,
			"group"				=> __("Design opties", 'tvds'),
			'dependency'		=> array(
				'element' => 'design',
				'value' => 'full',
			),
		),

		// Show Arrival Date / Weeks
		array(
			'type'              => 'checkbox',
			"class" 			=> "",
			"heading" 			=> __("Toon aankomstdatum/aantal weken", "tvds"),
			"param_name" 		=> "show_date",
			"value" 			=> false,
			"group"				=> __("Design opties", 'tvds'),
			'dependency'		=> array(
				'element' => 'design',
				'value' => 'full',
			),
		),

		// Show Persons
		array(
			'type'              => 'checkbox',
			"class" 			=> "",
			"heading" 			=> __("Toon personen", "tvds"),
			"param_name" 		=> "show_persons",
			"value" 			=> false,
			"group"				=> __("Design opties", 'tvds'),
			'dependency'		=> array(
				'element' => 'design',
				'value' => 'full',
			),
		),

		// Show Bedrooms
		array(
			'type'              => 'checkbox',
			"class" 			=> "",
			"heading" 			=> __("Toon slaapkamers", "tvds"),
			"param_name" 		=> "show_bedrooms",
			"value" 			=> false,
			"group"				=> __("Design opties", 'tvds'),
			'dependency'		=> array(
				'element' => 'design',
				'value' => 'full',
			),
		),
        
        // Background Color
        array(
            "type" 				=> "colorpicker",
            "class" 			=> "",
            "heading" 			=> __("Achtergrond kleur", "tvds"),
            "param_name" 		=> "background_color",
            "value" 			=> "",
            "group"				=> __("Design opties", 'tvds'),
        ),
        
        
    ),
));


//	Homes Search Shortcode.
//------------------------------------------------------------
function tvds_homes_search_shortcode($atts, $content = null){
    // Get all the atts from the element
    $atts = vc_map_get_attributes( 'tvds_homes_search', $atts );
    extract( $atts );
    
    
    // Create the classes
    $class = $el_class;
    (isset($background_color)) ? $class .= ' background' : '';
    (isset($design)) ? $class .= ' '.$design : '';
    
	$action_url = (!empty(get_option('rewrite_homes'))) ? home_url().'/'.get_option('rewrite_homes') : home_url().'/homes';
    
    // The Output
    $output = '<div class="tvds_homes_search_form '.$class.'" style="background-color: '.$background_color.'">';
	    
	    $output .= '<div class="row">';
    
	    	// If there is a title display it
	    	if($title){
		    	$output .= '<div class="tvds_homes_search_form_head col-md-12">';
		    	
		            $output .= '<h3>'.$title.'</h3>';
		        
		        $output .= '</div>'; // tvds_homes_search_form_head end
	    	}
	    	
	    	// Output the chosen design
	    	//-------------------------
	    	
	    	// Full Design
	    	if($design == 'full'){
		    	
		    	
		    	$output .= '<div class="tvds_homes_search_form_body tvds_homes_search_full">';
	
		            $output .= '<form autocomplete="off" method="get" action="'.$action_url.'">';
		            
		            	$output .= '<div class="row">';

			            	// Keyword
			            	if($show_keyword){
								$output .= '<div class="tvds_homes_search_form_field_wrap col-md-4 col-sm-12">';

									$output .= '<label>'.__('Zoekwoord', 'tvds').'</label>';
									$output .= '<input type="text" name="keyword" style="width: 100%;" placeholder="'.__('Alle', 'tvds').'"/>';

								$output .= '</div>'; // tvds_homes_search_form_field_wrap end
							}

							// Province
							if($show_province){
								$terms_province = get_terms('homes_province', array('hide_empty' => true));

								$output .= '<div class="tvds_homes_search_form_field_wrap col-md-4 col-sm-6">';

									$output .= '<label>'.__('Provincie', 'tvds').'</label>';

									$output .= '<a class="btn btn-default btn-select">';

										$output .= '<input type="hidden" class="btn-select-input" id="" name="province" value="" />';

										$output .= '<span class="btn-select-value">Maakt niet uit</span>';

										$output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';

										$output .= '<ul>';

											$output .= '<li data-value="">'. __('Alle', 'tvds').'</li>';

											foreach($terms_province as $term){
												$output .= '<li data-value="'.$term->slug.'">'.$term->name.'</li>';
											}

										$output .= '</ul>';

									$output .= '</a>';

								$output .= '</div>'; // tvds_homes_search_form_field_wrap end
							}

			            	// Type
							if($show_type){
								$terms_type = get_terms('homes_type', array('hide_empty' => true));

								$output .= '<div class="tvds_homes_search_form_field_wrap col-md-4 col-sm-6">';

									$output .= '<label>'.__('Type', 'tvds').'</label>';

									$output .= '<a class="btn btn-default btn-select">';

										$output .= '<input type="hidden" class="btn-select-input" id="" name="type" value="" />';

										$output .= '<span class="btn-select-value">Maakt niet uit</span>';

										$output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';

										$output .= '<ul>';

											$output .= '<li data-value="">'. __('Alle', 'tvds').'</li>';

											foreach($terms_type as $term){
												$output .= '<li data-value="'.$term->slug.'">'.$term->name.'</li>';
											}

										$output .= '</ul>';

									$output .= '</a>';

								$output .= '</div>'; // tvds_homes_search_form_field_wrap end
							}

			            	
			            	// Arrival Date
							if($show_date){
								$output .= '<div class="tvds_homes_search_form_field_wrap col-md-4 col-sm-6 col-xs-6">';

									$output .= '<label>'.__('Aankomst datum', 'tvds').'</label>';
									$output .= '<input class="datepicker" type="text" name="arrival_date" style="width: 100%;" placeholder="'.__('Kies datum', 'tvds').'"/>';

								$output .= '</div>'; // tvds_homes_search_form_field_wrap end

								// Weeks
								$output .= '<div class="tvds_homes_search_form_field_wrap col-md-4 col-sm-6 col-xs-6">';

									$output .= '<label>'.__('Aantal weken', 'tvds').'</label>';

										$output .= '<a class="btn btn-default btn-select">';

											$output .= '<input type="hidden" class="btn-select-input" id="" name="weeks" value="" />';

											$output .= '<span class="btn-select-value">'.__('Aantal weken', 'tvds').'</span>';

											$output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';

											$output .= '<ul>';
												for($x = 1; $x <= 12; $x++){
													if($x == 1){
														$output .= '<li data-value="'.$x.'">'.$x.' Week</li>';
													}
													else {
														$output .= '<li data-value="'.$x.'">'.$x.' Weken</li>';
													}
												}
											$output .= '</ul>';

									$output .= '</a>';

								$output .= '</div>'; // tvds_homes_search_form_field_wrap end
							}

			            	// Persons
							if($show_persons){
								$output .= '<div class="tvds_homes_search_form_field_wrap col-md-2 col-sm-6 col-xs-6">';

									$output .= '<label>'.__('Personen', 'tvds').'</label>';

									$output .= '<a class="btn btn-default btn-select">';

										$output .= '<input type="hidden" class="btn-select-input" id="" name="max_person" value="" />';

										$output .= '<span class="btn-select-value">'.__('Maak keuze', 'tvds').'</span>';

										$output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';

										$output .= '<ul>';

											for($x = 1; $x <= 20; $x++){
												if($x == 1){
													$output .= '<li data-value="'.$x.'">'.$x.' Persoon</li>';
												}
												else {
													$output .= '<li data-value="'.$x.'">'.$x.' Personen</li>';
												}

											}

										$output .= '</ul>';

									$output .= '</a>';

								$output .= '</div>'; // tvds_homes_search_form_field_wrap end
							}

			            	
			            	// Bedrooms
							if($show_bedrooms){
								$output .= '<div class="tvds_homes_search_form_field_wrap col-md-2 col-sm-6 col-xs-6">';

									$output .= '<label>'.__('Slaapkamers', 'tvds').'</label>';

									$output .= '<a class="btn btn-default btn-select">';

										$output .= '<input type="hidden" class="btn-select-input" id="" name="bedrooms" value="" />';

										$output .= '<span class="btn-select-value">'.__('Maak keuze', 'tvds').'</span>';

										$output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';

										$output .= '<ul>';
											for($x = 1; $x <= 10; $x++){
												if($x == 1){
													$output .= '<li data-value="'.$x.'">'.$x.' Slaapkamer</li>';
												}
												else {
													$output .= '<li data-value="'.$x.'">'.$x.' Slaapkamers</li>';
												}
											}
										$output .= '</ul>';
									$output .= '</a>';

								$output .= '</div>'; // tvds_homes_search_form_field_wrap end
							}

			            
						$output .= '</div>'; // row end
						
						
						$output .= '<div class="row">';

							$output .= '<input type="submit" value="'.__('Zoeken', 'tvds').'"/>';
						
						$output .= '</div>'; //row end

		            $output .= '</form>';
		
		        $output .= '</div>'; // tvds_homes_search_full end
	    
		    }
		    
		    // Small Design
		    elseif($design == 'small'){
			    
			    $output .= '<div class="tvds_homes_search_form_body tvds_homes_search_small">';
	
		            $output .= '<form autocomplete="off" method="get" action="'.$action_url.'">';
		            	
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
								$output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';
								
								// The Values
								$output .= '<ul>';
									for($x = 1; $x <= 12; $x++){
										if($x == 1){
											$output .= '<li data-value="'.$x.'">'.$x.' Week</li>';	
										}
										else {
											$output .= '<li data-value="'.$x.'">'.$x.' Weken</li>';
										}
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
								$output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';
								
								// The Values
								$output .= '<ul>';
									for($x = 1; $x <= 20; $x++){
										if($x == 1){
											$output .= '<li data-value="'.$x.'">'.$x.' Persoon</li>';	
										}
										else {
											$output .= '<li data-value="'.$x.'">'.$x.' Personen</li>';
										}
										
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
		            
		            $output .= '</form>';
		
		        $output .= '</div>'; // tvds_homes_search_small end

		    }
	    	
		$output .= '</div>'; // row end
		
    $output .= '</div>'; // tvds_homes_search_form end


    // Return the output
    return $output;
}
add_shortcode('tvds_homes_search', 'tvds_homes_search_shortcode');