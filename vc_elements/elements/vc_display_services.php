<?php

//	Homes Display Services.
//------------------------------------------
vc_map(array(
    "name"                    	=> __('Huis Faciliteiten', 'tvds'),
    "base"                    	=> 'tvds_homes_services_display',
    "description"				=> __('Huis Faciliteiten weergeven', 'tvds'),
    "icon"                    	=> "",
    "show_settings_on_create" 	=> true,
    "category"                	=> __('TVDS Huizen', 'tvds'),
    "controls"                	=> "full",
    "save_always" 			  	=> true,
    "params"                  	=> array(
         
        // General
        //-----------------------
		
		// Title
		array(
            "type" 				=> "textfield",
            "class" 			=> "",
            "heading" 			=> __("Titel", "tvds"),
            "param_name" 		=> "title",
            "value" 			=> "Details",
        ),
        // Show Empty Services
        array(
            'type'              => 'checkbox',
            "class" 			=> "",
            "heading" 			=> __("Toon lege voorzieningen", "tvds"),
            "param_name" 		=> "show_empty_services",
            "value" 			=> false,
        ),
        // Extra Class
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


//	Homes Display Services Shortcode.
//------------------------------------------------------------
function tvds_homes_services_display_shortcode($atts, $content = null){
    // Get all the atts from the element
    $atts = vc_map_get_attributes( 'tvds_homes_services_display', $atts );
    extract($atts);
    
    $output = '';
    
    $services_args = array(
		'post_type' 		=> 'homes',
		'posts_per_page' 	=> -1,
		'p'					=> get_the_ID(),
	);
	
	$services_query = new WP_Query($services_args);
	
	if($services_query->have_posts()){
		while($services_query->have_posts()) : $services_query->the_post();
			
			
			$output .= '<div class="tvds_vc_booking_display_services">';
			
				// If Have Title Display it
				if(!empty($title)){
					$output .= '<h3>'.$title.'</h3>';
				}
				
				$terms_type = get_the_terms(get_the_ID(), 'homes_type');

				$terms_region = get_the_terms(get_the_ID(), 'homes_region');
				$terms_place = get_the_terms(get_the_ID(), 'homes_place');
				
				
				$output .= '<div class="row">';
				
					// Detailed Info
					$output .= '<div class="col-sm-6 col-xs-12">';				
						$output .= '<ul>';
							// Type
							$output .= '<li>Type: <span>'.tvds_homes_get_terms($terms_type).'</span></li>';

							// Price
							$output .= '<li>Prijs: <span> € '.get_post_meta(get_the_ID(), 'min_week_price', true).'</span></li>';

							// Max Price
							if(!empty(get_post_meta(get_the_ID(), 'max_week_price', true))){
								$output .= '<li>Max prijs: <span> € '.get_post_meta(get_the_ID(), 'max_week_price', true).'</span></li>';
							}

							// For Sale
							if(get_post_meta(get_the_ID(), 'for_sale', true)){
								$output .= '<li>Koop prijs: <span> € '.get_post_meta(get_the_ID(), 'sale_price', true).'</span></li>';
							}

							// Location
							$output .= '<li>Location: <span>'.tvds_homes_get_terms($terms_region).', '.tvds_homes_get_terms($terms_place).'</span></li>';
		
							// Rating
							$output .= '<li>';
								$output .= 'Rating: ';
								
								if(!empty(get_post_meta(get_the_ID(), 'stars', true))){
									$stars = get_post_meta(get_the_ID(), 'stars', true);
									
									for($x = 0; $x < $stars; $x++){
										$output .= '<i class="icon icon-star"></i>';
									}	
								}
								else {
									$output .= __('Niet beschikbaar', 'tvds');
								}
							$output .= '</li>';
						$output .= '</ul>';
					$output .= '</div>';
					
					
					// Display services
					$output .= '<div class="col-sm-6 col-xs-12">';
						$output .= '<ul class="tvds_vc_booking_display_services_information">';
								
							// Get All The Services In An Array For Easy Usage	
							$services = tvds_homes_get_services();
							
							// For Each Row In The Array Return The Icon
							foreach($services as $service){
								if(get_post_meta(get_the_ID(), $service['name'], true) == 1){
									$output .= '<li><i class="icon icon-check"></i> <strong>'.$service['label'].'</strong></li>';
								}
								else if($show_empty_services) {
									$output .= '<li><i class="icon icon-check-empty"></i> <strong>'.$service['label'].'</strong></li>';
								}
							}
														
						$output .= '</ul>';
					$output .= '</div>';
					
					$output .= '<div class="clearfix"></div>';
				$output .= '</div>';
				
				
			$output .= '</div>';
				
		endwhile;
	}

    // Return the output
    return $output;
}
add_shortcode('tvds_homes_services_display', 'tvds_homes_services_display_shortcode');