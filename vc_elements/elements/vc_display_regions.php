<?php

//	Homes Regions.
//------------------------------------------

vc_map(array(
    "name"                    	=> __('Huis regio', 'tvds'),
    "base"                    	=> 'tvds_homes_region_display',
    "description"				=> __('Regio weergeven', 'tvds'),
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
            "value" 			=> "",
        ),
        // Link
        array(
            "type" 				=> "textfield",
            "class" 			=> "",
            "heading" 			=> __("Link", "tvds"),
            "param_name" 		=> "link",
            "value" 			=> "",
        ),
        // Thumbnail
        array(
            "type" 				=> "attach_image",
            "class" 			=> "",
            "heading" 			=> __("Thumbnail", "tvds"),
            "param_name" 		=> "thumbnail",
            "value" 			=> "",
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


//	Homes Display Shortcode.
//------------------------------------------------------------
function tvds_homes_region_display_shortcode($atts, $content = null){
    // Get all the atts from the element
    $atts = vc_map_get_attributes( 'tvds_homes_region_display', $atts );
    extract($atts);
    
    $thumb = wp_get_attachment_image($thumbnail, 'homes_archive_thumb');
    
    $output = '';
    
    // The Output
    $output .= '<div class="tvds_homes_region">';

		$output .= '<a href="'.$link.'">';

		    $output .= '<div class="tvds_homes_region-inner">';
		    
		    	// Clip
		    	$output .= '<div class="tvds_homes_region_background_clip">';
		    	
		    		$output .= $thumb;
		    	
		    		$output .= '<div class="tvds_homes_region_background_overlay">';
		    		
		    			$output .= '<i class="icon-link icons"></i>';
		    		
		    		$output .= '</div>'; // tvds_homes_region_background_overlay end
		    			    	
		    	$output .= '</div>'; // tvds_homes_region_background_clip end
		    	
		    	// Title
		    	$output .= '<div class="tvds_homes_region_title">';
		    	
		    		$output .= '<span>'.$title.'</span>';
		    	
		    	$output .= '</div>'; // tvds_homes_region_title end
		    		    
		    $output .= '</div>'; // tvds_homes_region-inner end
		    
	    $output .= '</a>';

    $output .= '</div>'; // tvds_homes_region end
    
    
    // Return the output
    return $output;
}
add_shortcode('tvds_homes_region_display', 'tvds_homes_region_display_shortcode');