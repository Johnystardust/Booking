<?php

//	Homes Display.
//------------------------------------------

// Put all The Categories/Taxonomies In A Array
$type_terms = get_terms(array(
    'taxonomy'		=> 'homes_type',
    'hide_empty'	=> true,
));
$region_terms = get_terms(array(
	'taxonomy'		=> 'homes_region',
	'hide_empty'	=> true,
));
$place_terms = get_terms(array(
	'taxonomy'		=> 'homes_place',
	'hide_empty'	=> true,
));
$province_terms = get_terms(array(
	'taxonomy'		=> 'homes_province',
	'hide_empty'	=> true,
));


$types 		= array('Alles' => '',);
$regions	= array('Alles' => '',);
$places		= array('Alles' => '',);
$provinces  = array('Alles' => '',);

foreach($type_terms as $term){
	$types[$term->name]=$term->slug;
}
foreach($region_terms as $term){
	$regions[$term->name]=$term->slug;
}
foreach($place_terms as $term){
	$places[$term->name]=$term->slug;
}
foreach($province_terms as $term){
	$provinces[$term->name]=$term->slug;
}

vc_map(array(
    "name"                    	=> __('Huizen weergeven', 'tvds'),
    "base"                    	=> 'tvds_homes_display',
    "description"				=> __('Huizen weergeven op taxonomy of alles', 'tvds'),
    "icon"                    	=> "",
    "show_settings_on_create" 	=> true,
    "category"                	=> __('TVDS Huizen', 'tvds'),
    "controls"                	=> "full",
    "save_always" 			  	=> true,
    "params"                  	=> array(
         
        // General
        //-----------------------
        
        // Based On
         array(
            "type" 				=> "dropdown",
            "class" 			=> "",
            "heading" 			=> __("Toon op", "tvds"),
            "param_name" 		=> "based_on",
            "value" 			=> array(
                __("Toon alles", "tvds") 	=> "show_all",
                __("Provincie", "tvds")    	=> "provinces",
                __("Types", "tvds") 		=> "types",
                __("Regio", "tvds") 		=> "region",
                __("Plaats", "tvds") 		=> "places",
            ),
        ),
        // Types
        array(
            "type" 				=> "dropdown",
            "class" 			=> "",
            "heading" 			=> __("Types", "tvds"),
            "param_name" 		=> "types",
            "value" 			=> $types,
            "dependency"		=> array(
                "element"	=> "based_on",
                "value"		=> "types",
                "not_empty" => false,
            ),
        ),
        // Region
        array(
            "type" 				=> "dropdown",
            "class" 			=> "",
            "heading" 			=> __("Regio", "tvds"),
            "param_name" 		=> "region",
            "value" 			=> $regions,
            "dependency"		=> array(
                "element"	=> "based_on",
                "value"		=> "region",
                "not_empty" => false,
            ),
        ),
        // Place
        array(
            "type" 				=> "dropdown",
            "class" 			=> "",
            "heading" 			=> __("Place", "tvds"),
            "param_name" 		=> "place",
            "value" 			=> $places,
            "dependency"		=> array(
                "element"	=> "based_on",
                "value"		=> "places",
                "not_empty" => false,
            ),
        ),
        // Province
        array(
            "type" 				=> "dropdown",
            "class" 			=> "",
            "heading" 			=> __("Provincie", "tvds"),
            "param_name" 		=> "province",
            "value" 			=> $provinces,
            "dependency"		=> array(
                "element"	=> "based_on",
                "value"		=> "provinces",
                "not_empty" => false,
            ),
        ),
        // Order
        array(
            "type" 				=> "dropdown",
            "class" 			=> "",
            "heading" 			=> __("Volgorde", "tvds"),
            "param_name" 		=> "order",
            "value" 			=> array(
                __("Aflopend", "tvds") => "DESC",
                __("Oplopend", "tvds") => "ASC",
            ),
        ),
        // Max Posts
        array(
            "type" 				=> "textfield",
            "class" 			=> "",
            "heading" 			=> __("Aantal posts", "tvds"),
            "param_name" 		=> "max_posts",
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
        
        
        // Design Options
        //-----------------------
        
        // Columns
        array(
            "type" 				=> "dropdown",
            "class" 			=> "",
            "heading" 			=> __("Kolommen", "tvds"),
            "param_name" 		=> "columns",
            "value" 			=> array(
                __("1 kolom", "tvds") 	    => "col-md-12",
                __("2 kolommen", "tvds")    => "col-md-6",
                __("3 kolommen", "tvds") 	=> "col-md-4",
                __("4 kolommen", "tvds") 	=> "col-md-3",
            ),
			"group"				=> __("Design opties", 'tvds'),
        ),
        // Show Details
        array(
            'type'              => 'checkbox',
            "class" 			=> "",
            "heading" 			=> __("Toon details", "tvds"),
            "param_name" 		=> "show_details",
            "value" 			=> true,
            "group"				=> __("Design opties", 'tvds'),
        ),
        // Show Services
        array(
            'type'              => 'checkbox',
            "class" 			=> "",
            "heading" 			=> __("Toon voorzieningen", "tvds"),
            "param_name" 		=> "show_services",
            "value" 			=> true,
            "group"				=> __("Design opties", 'tvds'),
        ),
        // Show Excerpt
        array(
            'type'              => 'checkbox',
            "class" 			=> "",
            "heading" 			=> __("Toon excerpt", "tvds"),
            "param_name" 		=> "show_excerpt",
            "value" 			=> true,
            "group"				=> __("Design opties", 'tvds'),
        ),
    ),
));


//	Homes Display Shortcode.
//------------------------------------------------------------
function tvds_homes_display_shortcode($atts, $content = null){
    // Get all the atts from the element
    $atts = vc_map_get_attributes( 'tvds_homes_display', $atts );
    extract($atts);
    
    // If The Columns Is Set Use Columns Else Use 'col-md-4'
    $columns = (isset($columns)) ? $columns : 'col-md-4';
    
    // If based_on Is Not show_all or category Make The Tax Query
    $tax_query = '';
    
    if($based_on != 'show_all' || $based_on != 'category'){
		// Create Tax Query If Types Is Set
	    if(!empty($types)){
		    $tax_query = array(
			    array(
					'taxonomy' => 'homes_type',
					'field'    => 'slug',
					'terms'    => $types,    
			    ),
		    );
	    }
	    elseif(!empty($region)){
		    $tax_query = array(
			    array(
					'taxonomy' => 'homes_region',
					'field'    => 'slug',
					'terms'    => $region,    
			    ),
		    );
	    }
	}


	// The Query Arguments
    $args = array(
        'post_type'         => 'homes',
        'posts_per_page'    => (isset($max_posts)) ? $max_posts : '8',
        'category_name'		=> $category,
        'order'				=> $order,
        'tax_query' 		=> $tax_query,
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
        $output .= var_dump($atts);
    }

    // Return the output
    return $output;
}
add_shortcode('tvds_homes_display', 'tvds_homes_display_shortcode');