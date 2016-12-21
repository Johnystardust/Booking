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
                __("Aanbiedingen")			=> "last_minute",
                __("Te koop")				=> "for_sale",
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
            "value" 			=> "-1",
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
    $search_meta = array();

    if($based_on == 'last_minute'){
		$search_meta[] = array(
            'key'     => 'last_minute',
            'value'   => 1,
            'compare' => '='
        );
	}
	elseif($based_on == 'for_sale'){
		$search_meta[] = array(
            'key'     => 'for_sale',
            'value'   => 1,
            'compare' => '='
        );
	}
    elseif($based_on != 'show_all' || $based_on != 'category'){
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
	    elseif(!empty($province)){
		    $tax_query = array(
			    array(
					'taxonomy' => 'homes_province',
					'field'    => 'slug',
					'terms'    => $province,
			    ),
		    );
	    }
	}


	// The Query Arguments
    $args = array(
        'post_type'         => 'homes',
        'posts_per_page'    => (isset($max_posts)) ? $max_posts : '8',
        'order'				=> $order,
        'tax_query' 		=> $tax_query,
        'orderby'       	=> 'meta_value',
	    'meta_query'  		=> $search_meta,
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
        	$output .= '<div class="row">';

		        while ($the_query->have_posts()): $the_query->the_post();

		            $output .= '<div class="tvds_vc_booking_display_homes_item '.$columns.'">';
						$output .= '<div class="tvds_vc_booking_display_homes_item_inner">';

							// Post Thumbnail
							$output .= '<div class="tvds_vc_booking_display_homes_item_thumbnail">';

                                $output .= '<a href="'.get_the_permalink().'">';
                                    // If Post Has Thumbnail Display it. If Not Display Placeholder Image
                                    if(has_post_thumbnail()){
                                        $output .= '<img src="'.get_the_post_thumbnail_url($post->ID, $size = 'homes_archive_thumb').'"/>';
                                    }
                                    else {
                                        $output .= '<img src="/placeholder" />';
                                    }
					            $output .= '</a>';

								// If Home Is Last Minute Or For Sale
					            $last_minute = get_post_meta($post->ID, 'last_minute', true);
					            $for_sale	 = get_post_meta($post->ID, 'for_sale', true);


					            if($last_minute || $for_sale){
					                $output .= '<ul class="tvds_vc_booking_display_homes_item_thumbnail_banners tvds_homes_thumbnail_banners">';

					                    if($last_minute){
					                        $output .= '<li class="tvds_homes_thumbnail_banner"><span class="tvds_homes_thumbnail_last_minute">'.__('Last minute', 'tvds').'</span></li>';
					                    }
					                    if($for_sale){
					                        $output .= '<li class="tvds_homes_thumbnail_banner"><span class="tvds_homes_thumbnail_for_sale">'.__('Te koop', 'tvds').'</span></li>';
					                    }

					                $output .= '</ul>';
					            }
							$output .= '</div>';



							// Post Content
							$output .= '<div class="tvds_vc_booking_display_homes_item_info">';

								// The Title
								$output .= '<a href="'.get_the_permalink().'"><h4>'.get_the_title().'</h4></a>';

								// Stars
					            if(get_post_meta($post->ID, 'stars', true) && get_option('show_stars')){
						            $output .= '<ul class="tvds_vc_booking_display_homes_item_info_rating">';

						                $stars = intval(get_post_meta($post->ID, 'stars', true));

					                    // For Each Rating Echo A Filed Star
					                    for($x = 1; $x <= $stars; $x++){
					                        $output .= '<li><i class="icon icon-star"></i></li>';
					                    }

					                    // For Each Rating Below 5 That isn't set Echo A Empty Star
					                    for($i = 1; $i <= (5 - $stars); $i++){
					                        $output .= '<li><i class="icon icon-star-empty"></i></li>';
					                    }
					                $output .= '</ul>';
					            }
                                else {
                                    $output .= '<ul class="tvds_vc_booking_display_homes_item_info_rating">';

                                        // For Each Rating Below 5 That isn't set Echo A Empty Star
                                        for($i = 1; $i <= 5; $i++){
                                            $output .= '<li><i class="icon icon-star-empty"></i></li>';
                                        }

                                    $output .= '</ul>';
                                }

					            // The Excerpt
					            if($show_excerpt){
							        $output .= '<p class="tvds_vc_booking_display_homes_item_excerpt">'.wp_trim_words(get_the_excerpt(), 14).'</p>';
					            }

					            // The Services
					            if($show_services){
						            $output .= '<ul class="tvds_vc_booking_display_homes_item_services">';
							            // Max Persons
					                    if (get_post_meta($post->ID, 'max_persons', true)){
					                        $output .= '<li><i class="icon icon-user"></i> <strong>'.get_post_meta($post->ID, 'max_persons', true).'</strong></li>';
					                    }

					                    // Bedrooms
					                    if (get_post_meta($post->ID, 'bedrooms', true)){
					                        $output .= '<li class="tvds_homes_archive_beds"><i class="icon icon-bed"></i> <strong>'.get_post_meta($post->ID, 'bedrooms', true).'</strong></li>';
					                    }
					                $output .= '</ul>';
					            }

					            // The Price
					            $output .= '<div class="tvds_vc_booking_display_homes_item_price">';
						            $output .= '<strong>'.__('Vanaf', 'tvds').' </strong>';
									$output .= '<h3 class="tvds_homes_archive_price">&euro;'.get_post_meta($post->ID, 'min_week_price', true).'</h3>';
									$output .= '<small>/per week</small><br>';
								$output .= '</div>';

								// The Button
								$output .= '<a class="tvds_homes_btn" href="'.get_the_permalink().'">'.__('Bekijk', 'tvds').'</a>';

							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';


					// Increment The Counter
		            $i++;
		        endwhile;
		    $output .= '</div>';
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