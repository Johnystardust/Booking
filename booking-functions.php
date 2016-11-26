<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/25/2016
 * Time: 9:07 PM
 */


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
    $terms = get_terms($get_type, array('hide_empty' => false));

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