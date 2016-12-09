<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/25/2016
 * Time: 9:07 PM
 */
 
 
/**
 * Function to repeat the booking form text input fields
 *
 * @param $title
 * @param $type
 * @param $name
 * @param $required
 * @param null $min_length
 * @return string
 */
function tvds_homes_booking_form_text_input($title, $type, $name, $required, $min_length = NULL){
    
    (isset($_POST[$name])) ? $value = $_POST[$name] : $value = '';
    ($required) ? $required = 'required' : $required = '';
    ($min_length) ? $min_length = $min_length : $min_length = '';
    
    $output = '<div class="tvds_homes_booking_form_group col-sm-6 col-xs-12">';
        $output .= '<label>'.$title.'</label><br>';
        $output .= '<input minlength="'.$min_length.'" '.$required.' type="'.$type.'" name="'.$name.'" placeholder="'.$title.'" value="'.$value.'"/>';
    $output .= '</div>';
    
    return $output;
}
 
/**
 * Function to get the homes terms as link
 *
 * @param $terms
 * @return string
 */
function tvds_homes_get_terms($terms){
	if(is_array($terms)){												
		foreach($terms as $term){
			return '<a href="'.get_term_link($term->term_id).'">'.$term->name.'</a>';
		}	
	}
    else {
        return false;
    }

    return null;
}

/**
 * Function to repeat the homes custom post type radio fields
 *
 * @param $name
 * @param $label
 * @param $value
 * @return string
 */
function tvds_homes_cpt_fields_radio_helper($name, $label, $value){

    $html = '<tr>';
    $html .= '<td>'.$label.'</td>';
    $html .= '<td>';
    if($value == 0){
        $html .= '<input type="radio" name="'.$name.'" value="0" checked>'.__('Nee', 'tvds');
        $html .= '<input type="radio" name="'.$name.'" value="1">'.__('Ja', 'tvds');
    }
    elseif($value == 1) {
        $html .= '<input type="radio" name="'.$name.'" value="0">'.__('Nee', 'tvds');
        $html .= '<input type="radio" name="'.$name.'" value="1" checked>'.__('Ja', 'tvds');
    }
    else {
        $html .= '<input type="radio" name="'.$name.'" value="0">'.__('Nee', 'tvds');
        $html .= '<input type="radio" name="'.$name.'" value="1">'.__('Ja', 'tvds');
    }
    $html .= '</td>';
    $html .= '</tr>';

    return $html;
}

/**
 * Function To Repeat The Services Search GET Request
 *
 * @param $key
 * @param $value
 * @return array
 */
function tvds_homes_search_services($key, $value){
    if(!empty($_GET[$key])){
        if($value == 1){
            $search_array = array(
                'key'     => $key,
                'value'   => 1,
                'compare' => '='
            );
            return $search_array;
        }
        elseif($value == 0){
            $search_array = array(
                'key'     => $key,
                'value'   => 0,
                'compare' => '='
            );
            return $search_array;
        }
    }

    return false;
}

/**
 * Function To Repeat The Taxonomy Search GET Request
 *
 * @param $key
 * @param $value
 * @return array|bool
 */
function tvds_homes_search_taxonomies($key, $value){
    if(!empty($_GET[$key])){
        $tax_search[] = array(
            'taxonomy' => 'homes_'.$key,
            'field'    => 'slug',
            'terms'    => array($value),
        );

        return $tax_search;
    }

    return false;
}

/**
 * Function To Repeat The Numbers Search GET Request
 *
 * @param $key
 * @param $value
 * @return array|bool
 */
function tvds_homes_search_numbers($key, $value){
    if(!empty($_GET[$key])){
        $search_array = array(
            'key'     => $key,
            'value'   => $value,
            'compare' => '>='
        );

        return $search_array;
    }

    return false;
}

/**
 * Homes Search Form By Date
 *
 * @param $arrival_date
 * @param $weeks
 * @return array
 */
function tvds_homes_search_dates($arrival_date, $weeks){
    // Get The Search Arrival date
    $start_date = new DateTime($arrival_date);
    $end_date   = new DateTime($arrival_date);

    $end_date->modify('+'.$weeks.' week');
    $end_date->modify('-1 second');

    return tvds_homes_exclude_booked_homes($start_date, $end_date);
}


/**
 * Check if a Date is inside a range
 *
 * @param $i
 * @param $x
 * @param $y
 * @return bool
 */
function tvds_homes_check_in_date_range($i, $x, $y){
    if((($y >= $i) && ($y <= $x))){
        return true;
    }

    return false;
}


/**
 * Exclude Booked Homes Function
 *
 * @param $search_start_date
 * @param $search_end_date
 * @return array
 */
function tvds_homes_exclude_booked_homes($search_start_date, $search_end_date){
    $exclude_array = array();

    // The Query Arguments
    $booking_args = array(
        'post_type' => 'booking',
        'post_per_page' => '-1',
    );

    // The Query
    $booking_query = new WP_Query($booking_args);

    if($booking_query->have_posts()){
        while($booking_query->have_posts()) : $booking_query->the_post();

            // Get The Booked Arrival Date & Weeks
            $arrival_date 	= get_post_meta(get_the_ID(), 'arrival_date', true);
            $weeks 			= get_post_meta(get_the_ID(), 'weeks', true);

            // Make DateTime from the strings
            $start_date = new DateTime($arrival_date);
            $end_date 	= new DateTime($arrival_date);

            // Add The Number Of Weeks To The End Date
            $end_date->modify('+'.$weeks.' week');
            $end_date->modify('-1 second');

            // Find Out If The Search Is Available
            if(tvds_homes_check_in_date_range($start_date, $end_date, $search_start_date) || tvds_homes_check_in_date_range($start_date, $end_date, $search_end_date)){
                // Make Int Of The String An Add It To The Array
                $home_id = intval(get_post_meta(get_the_ID(), 'home_id', true));
                $exclude_array[] = $home_id;
            }

        endwhile;
        wp_reset_postdata();
    }

    // Return The Homes To Be Excluded In The Search
    return $exclude_array;
}


/**
 * Exclude Days In The Booking Form
 *
 * @return array
 */
function tvds_homes_booking_form_exclude_booked_days(){
	
	$form_args = array(
		'post_type' 		=> 'booking',
		'posts_per_page' 	=> -1,
		'orderby'       => 'meta_value',
		'post_status'	=> 'publish',
		"meta_query" => array(
			array(
				"key" 		=> "home_id",
				"value" 	=> get_the_ID(),
				'compare' 	=> '=',
			),
		),
	);
	
	$form_query = new WP_Query($form_args);
	
	if($form_query->have_posts()){
		while($form_query->have_posts()) : $form_query->the_post();
		
			$arrival_date 	= get_post_meta(get_the_ID(), 'arrival_date', true);
			$weeks 			= get_post_meta(get_the_ID(), 'weeks', true);

			$start_date = new DateTime($arrival_date);
			$end_date 	= new DateTime($arrival_date);

			$end_date->modify('+'.$weeks.' week');

			$interval = DateInterval::createFromDateString('+1 day');
			$period	= new DatePeriod($start_date, $interval, $end_date);

			foreach($period as $datetime){
				$booked_days[] = $datetime->format('n-j-Y');
			}	
		
		endwhile;
		wp_reset_postdata();
	}
	else {
		$booked_days = '';
	}
	
	return $booked_days;
}

/**
 * Function to make adding new taxonomy fields easy
 *
 *
 * @param $get_value
 * value that is required for the get request
 *
 * @param $get_type
 * type of taxonomy
 *
 * @param $label_title
 * Title for the label
 *
 * @param $taxonomy
 * If archive is taxonomy get the taxonomy
 *
 * @param $tax_slug
 * If archive is taxonomy get the taxonomy slug
 *
 * @param $show_labels
 * If Show lables is set display the label
 *
 * @return string
 */
function tvds_homes_search_widget_form_taxonomy_fields($get_value, $get_type, $label_title, $taxonomy, $tax_slug, $show_labels){

    // Get The $_GET Value or if Tax Get The Tax Slug
    if(isset($_GET[$get_value])){
        $value = $_GET[$get_value];
    }
    elseif($taxonomy == $get_type){
        $value = $tax_slug;
    }
    else {
        $value = 'no no.';
    }

    // Get The Set Term
    $terms = get_terms($get_type, array('hide_empty' => true));

    // Get The Selected Term
    if(isset($value)){
        foreach($terms as $term){
            if($value == $term->slug){
                $term_slug = $term->slug;
                $term_name = $term->name;
            }
        }
    }

    // If The Term Is Not Set Take The Label For The Initial Value
    if(!isset($term_name)){
        $term_name = $label_title;
    }

    if(!isset($term_slug)){
        $term_slug = '';
    }

    // Generate The Output
    $output = '';

    // If Show Labels Is Set
    if($show_labels){
        $output .= '<label>'.$label_title.'</label>';
    }

    $output .= '<div class="tvds_homes_search_form_group">';
        $output .= '<a class="btn btn-default btn-select">';

            $output .= '<input type="hidden" class="btn-select-input" id="" name="'.$get_value.'" value="'.$term_slug.'" />';
            $output .= '<span class="btn-select-value">'.$term_name.'</span>';
            $output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';

            $output .= '<ul>';
                $output .= '<li data-value="">'. __('Alle', 'tvds').'</li>';

                foreach($terms as $term){
                    $output .= '<li data-value="'.$term->slug.'">'.$term->name.'</li>';
                }

            $output .= '</ul>';

        $output .= '</a>';
    $output .= '</div>';

    return $output;
}

/**
 * Function to make adding new number fields easy
 *
 * @param $get_value
 * value that is required for the get request
 *
 * @param $label_title
 * Title for the label
 *
 * @param $max_options
 * Max number of options
 *
 * @param $show_labels
 * If Show lables is set display the label
 *
 * @return string
 *
 */
function tvds_homes_search_widget_form_number_select_fields($get_value, $label_title, $max_options, $show_labels){

    // Get The $_GET Value or if Tax Get The Tax Slug
    if(isset($_GET[$get_value])){
        $value = $_GET[$get_value];
    }
    else {
        $value = '';
    }

    // If no value set initial text
    if(!empty($value)){
        $initial_title = $value;
    }
    else {
        $initial_title = __('Maak keuze', 'tvds');
    }

    // Generate The Output
    $output = '';

    // If Show Labels Is Set
    if($show_labels){
        $output .= '<label>'.$label_title.'</label>';
    }

    $output .= '<div id="tvds_homes_search_number_select_'.$get_value.'" class="tvds_homes_search_form_group">';
        $output .= '<a class="btn btn-default btn-select">';

            $output .= '<input type="hidden" class="btn-select-input" id="" name="'.$get_value.'" value="'.$value.'" />';
            $output .= '<span class="btn-select-value">'.$initial_title.'</span>';
            $output .= '<span class="btn-select-arrow glyphicon glyphicon glyphicon-menu-down pull-right"></span>';

            $output .= '<ul>';
                $output .= '<li data-value="">'. __('Maak keuze', 'tvds').'</li>';

                for($x = 1; $x <= $max_options; $x++){
                    if($x == $value){
                        $output .= '<li data-selected value="'.$x.'">'.$x.'</option>';
                    }
                    else {
                        $output .= '<li data-value="'.$x.'">'.$x.'</option>';
                    }
                }

            $output .= '</ul>';

        $output .= '</a>';
    $output .= '</div>';


    return $output;
}

/**
 * Function to make adding new number fields easy
 *
 * @param $get_value
 * value that is required for the get request
 *
 * @param $label_title
 * Title for the label
 *
 * @return string
 */
function tvds_homes_search_widget_form_services_fields($get_value, $label_title){

    // Get The $_GET Value or if Tax Get The Tax Slug
    if(isset($_GET[$get_value])){
        $value = $_GET[$get_value];
    }

    if(isset($value) == 1){
        $checked = 'checked';
    }
    else {
        $checked = '';
    }

    $output = '<div id="tvds_homes_search_form_check_'.$get_value.'" class="tvds_homes_search_form_check">';
        $output .= '<input type="checkbox" '.$checked.' value="1" name="'.$get_value.'" id="'.$get_value.'"/>';
        $output .= '<label for="'.$get_value.'">'.$label_title.'</label>';
    $output .= '</div>';

    return $output;
}


/**
 * Function to return an array of the services
 *
 * @return array
 */
function tvds_homes_get_services(){
    return array(
        array(
            'name' 	=> 'wifi',
            'label' => __('Wifi', 'tvds'),
        ),
        array(
            'name' 	=> 'phone',
            'label'	=> __('Telefoon', 'tvds'),
        ),
        array(
            'name' 	=> 'tv',
            'label'	=> __('TV', 'tvds'),
        ),
        array(
            'name' 	=> 'satellite',
            'label'	=> __('Satelliet', 'tvds'),
        ),
        array(
            'name' 	=> 'washer',
            'label'	=> __('Wasmachine', 'tvds'),
        ),
        array(
            'name' 	=> 'dishwasher',
            'label'	=> __('Vaatwasser', 'tvds'),
        ),
        array(
            'name' 	=> 'microwave',
            'label'	=> __('Magnetron', 'tvds'),
        ),
        array(
            'name' 	=> 'airco',
            'label'	=> __('Airco', 'tvds'),
        ),
        array(
            'name' 	=> 'sauna',
            'label'	=> __('Sauna', 'tvds'),
        ),
        array(
            'name' 	=> 'restaurant',
            'label'	=> __('Restaurant', 'tvds'),
        ),
        array(
            'name' 	=> 'breakfast',
            'label'	=> __('Ontbijt', 'tvds'),
        ),
        array(
            'name' 	=> 'manege',
            'label'	=> __('Manege', 'tvds'),
        ),
        array(
            'name' 	=> 'pool',
            'label'	=> __('Zwembad', 'tvds'),
        ),
        array(
            'name' 	=> 'bbq',
            'label'	=> __('BBQ', 'tvds'),
        ),
        array(
            'name' 	=> 'animals',
            'label'	=> __('Huisdieren', 'tvds'),
        ),
        array(
            'name' 	=> 'alpine',
            'label'	=> __('Wintersport', 'tvds'),
        ),
        array(
            'name' 	=> 'sea',
            'label'	=> __('Zee', 'tvds'),
        ),
    );
}

/**
 * Function to check if value is inside a multidimensional array
 *
 * @param $needle
 * @param $haystack
 * @param bool|false $strict
 * @return bool
 */
function tvds_in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && tvds_in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}