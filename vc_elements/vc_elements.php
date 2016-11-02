<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/2/2016
 * Time: 7:36 PM
 */

//	Spacing.
//-----------------------------------------------------------------------------------------------------------------------

add_action( 'plugins_loaded', 'tvds_booking_vc_elements' );

function tvds_booking_vc_elements(){
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
}

//	Spacing Shortcode.
//------------------------------------------------------------
function tvds_spacing_test_shortcode($atts, $content = null){
    // Get all the atts from the element
    $atts = vc_map_get_attributes( 'tvds_homes_search', $atts );
    extract( $atts );

    $args = array(
        'post_type'         => 'homes',
        'posts_per_page'    => (isset($max_posts)) ? $max_posts : '8',
    );

    $args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;

    $the_query = new WP_Query($args);
    $output = '';

    global $post;

    // If have posts
    //------------------
    if($the_query->have_posts()) {

        // Container Output
        $output .= '<div id="" class="tvds_vc_booking_display_homes">';

        while ($the_query->have_posts()): $the_query->the_post();

            $output .= '<div class="col-md-4">';

                if(has_post_thumbnail()){
                    $output .= '<div class="tvds_vc_booking_display_homes_image">';
                        $output .= '<img src="'.get_the_post_thumbnail_url().'"/>';
                    $output .= '</div>';
                }

                $output .= '<div class="tvds_vc_booking_display_homes_info">';
                    $output .= get_the_title();
                $output .= '</div>';

                $output .= '<a href="'.get_the_permalink().'">'.__('Bekijk', 'tvds').'</a>';


                if(get_post_meta($post->ID, 'wifi', true) == 1){
                    $output .= '<i class="fa fa-wifi" aria-hidden="true"></i>';
                }

            $output .= '</div>';

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
add_shortcode('tvds_homes_display', 'tvds_spacing_test_shortcode');