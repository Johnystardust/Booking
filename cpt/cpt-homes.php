<?php
// Create custom post type
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_create_homes_post_type(){
    register_post_type('homes',
        array(
            'labels' => array(
                'name'                  => __('Huizen', 'tvds'),
                'singular_name'         => __('Huis', 'tvds'),
                'add_new'               => __('Nieuw huis', 'tvds'),
                'add_new_item'          => __('Nieuw huis toevoegen', 'tvds'),
                'edit'                  => __('Edit', 'tvds'),
                'edit_item'             => __('Edit Huis', 'tvds'),
                'new_item'              => __('Nieuw huis', 'tvds'),
                'view'                  => __('Bekijk', 'tvds'),
                'view_item'             => __('Bekijk huis', 'tvds'),
                'search_items'          => __('Zoek huis', 'tvds'),
                'not_found'             => __('Geen huizen gevonden', 'tvds'),
                'not_found_in_trash'    => __('Geen huizen gevonden in de prullenbak', 'tvds'),
                'parent'                => 'Parent huis'
            ),

            'public'        => true,
            'menu_position' => 15,
            'supports'      => array('title', 'editor', 'comments', 'excerpt', 'thumbnail', 'custom-fields'),
            'taxonomies'    => array('category', 'homes_place', 'homes_type'),
            'menu_icon'     => 'dashicons-palmtree',
            'has_archive'   => true,
            'hierarchical'  => true
        )
    );
}
add_action('init', 'tvds_booking_create_homes_post_type');

// Add meta boxes
//----------------------------------------------------------------------------------------------------------------------
function tvds_add_homes_meta_boxes(){
    add_meta_box('homes_detail_meta_box', __('Huis details', 'tvds'), 'tvds_display_homes_detail_meta_box', 'homes', 'normal', 'high');
    add_meta_box('homes_booking_meta_box', __('Reserveringen', 'tvds'), 'tvds_display_homes_booking_meta_box', 'homes', 'normal', 'high');
}
add_action('admin_init', 'tvds_add_homes_meta_boxes');


/*
 * Meta boxes die erbij moeten komen
 *
 * Nieuwe Aanwinst
 *
 *
 *
 */

// Display meta boxes
//----------------------------------------------------------------------------------------------------------------------
function tvds_display_homes_detail_meta_box($home){
    $wifi               = esc_html(get_post_meta($home->ID, 'wifi', true));
    $pool               = esc_html(get_post_meta($home->ID, 'pool', true));
    $animals            = esc_html(get_post_meta($home->ID, 'animals', true));
    $alpine             = esc_html(get_post_meta($home->ID, 'alpine', true));
    
    $min_week_price     = esc_html(get_post_meta($home->ID, 'min_week_price', true));
    $max_week_price     = esc_html(get_post_meta($home->ID, 'max_week_price', true));
    $for_sale           = esc_html(get_post_meta($home->ID, 'for_sale', true));
    $sale_price         = esc_html(get_post_meta($home->ID, 'sale_price', true));
    
    $max_persons        = esc_html(get_post_meta($home->ID, 'max_persons', true));
    $type               = esc_html(get_post_meta($home->ID, 'type', true));
    $bedrooms		    = esc_html(get_post_meta($home->ID, 'bedrooms', true));
    $new_contender      = esc_html(get_post_meta($home->ID, 'new_contender', true));

    $rating             = esc_html(get_post_meta($home->ID, 'rating', true));
    $additional_info    = get_post_meta($home->ID, 'additional_info', true);
    ?>
    <table cellpadding="5px" cellpadding="homes-detail">
	    
	    <!-- Details Section -->
		<tr>
            <th style="width: 100%;"><?php echo __('Details', 'tvds'); ?></th>
            <th><?php echo __('Waarde', 'tvds'); ?></th>
        </tr>
        
		<!-- Max Persons -->
        <tr>
            <td style="width: 100%;"><?php echo __('Maximum aantal personen', 'tvds'); ?></td>
            <td>
	            <select name="max_persons">
		            <?php
			            for($x = 1; $x <= 20; $x++){
				            if($x == $max_persons){
					            echo '<option selected value="'.$x.'">'.$x.'</option>';
				            }
				            else {
					            echo '<option value="'.$x.'">'.$x.'</option>';
				            }
			            }
			        ?>
	            </select>
	        </td>
        </tr>
        <!-- Home Type -->
        <tr>
            <td style="width: 100%;"><?php echo __('Huis type', 'tvds'); ?></td>
            <td>
                <select name="type">
                    <option value="0" <?php if($type == 0){echo 'selected';} ?>><?php echo __('Vrijstaand', 'tvds'); ?></option>
                    <option value="1" <?php if($type == 1){echo 'selected';} ?>><?php echo __('Half vrijstaand', 'tvds'); ?></option>
                    <option value="2" <?php if($type == 2){echo 'selected';} ?>><?php echo __('Appartament', 'tvds'); ?></option>
                    <option value="3" <?php if($type == 3){echo 'selected';} ?>><?php echo __('Hotel & Residence', 'tvds'); ?></option>
                </select>
            </td>
        </tr>
        <!-- Slaapkamers -->
        <tr>
            <td style="width: 100%;"><?php echo __('Slaapkamers', 'tvds'); ?></td>
            <td>
	            <select name="bedrooms">
		            <?php
			            for($x = 1; $x <= 10; $x++){
				            if($x == $bedrooms){
					            echo '<option selected value="'.$x.'">'.$x.'</option>';
				            }
				            else {
					            echo '<option value="'.$x.'">'.$x.'</option>';
				            }
			            }
			        ?>
	            </select>
	        </td>
        </tr>
        <!-- New Contender -->
        <tr>
            <td style="width: 100%;"><?php echo __('Nieuwe aanwinst', 'tvds'); ?></td>
            <td>
                <input type="radio" name="new_contender" value="0" <?php if($new_contender == 0){ echo 'checked'; } ?>> <?php echo __('Nee', 'tvds'); ?>
                <input type="radio" name="new_contender" value="1" <?php if($new_contender == 1){ echo 'checked'; } ?>> <?php echo __('Ja', 'tvds'); ?>
            </td>
        </tr>

		<!-- Divider -->
        <tr>
	        <td colspan="2"><hr/></td>
        </tr>

	    <!-- Voorzieningen Section -->
		<tr>
            <th style="width: 100%;"><?php echo __('Voorzieningen', 'tvds'); ?></th>
            <th><?php echo __('Aanwezig', 'tvds'); ?></th>
        </tr>

        <!-- Wifi -->
        <tr>
            <td style="width: 100%;"><?php echo __('Wifi', 'tvds'); ?></td>
            <td>
                <input type="radio" name="wifi" value="0" <?php if($wifi == 0){ echo 'checked'; } ?>> <?php echo __('Nee', 'tvds'); ?>
                <input type="radio" name="wifi" value="1" <?php if($wifi == 1){ echo 'checked'; } ?>> <?php echo __('Ja', 'tvds'); ?>
            </td>
        </tr>
        <!-- Pool -->
        <tr>
            <td style="width: 100%;"><?php echo __('Zwembad', 'tvds'); ?></td>
            <td>
                <input type="radio" name="pool" value="0" <?php if($pool == 0){ echo 'checked'; } ?>> <?php echo __('Nee', 'tvds'); ?>
                <input type="radio" name="pool" value="1" <?php if($pool == 1){ echo 'checked'; } ?>> <?php echo __('Ja', 'tvds'); ?>
            </td>
        </tr>
        <!-- Animals -->        
        <tr>
            <td style="width: 100%;"><?php echo __('Huisdieren', 'tvds'); ?></td>
            <td>
                <input type="radio" name="animals" value="0" <?php if($animals == 0){ echo 'checked'; } ?>> <?php echo __('Nee', 'tvds'); ?>
                <input type="radio" name="animals" value="1" <?php if($animals == 1){ echo 'checked'; } ?>> <?php echo __('Ja', 'tvds'); ?>
            </td>
        </tr>
        <!-- Alpine -->        
        <tr>
            <td style="width: 100%;"><?php echo __('Wintersport', 'tvds'); ?></td>
            <td>
                <input type="radio" name="alpine" value="0" <?php if($alpine == 0){ echo 'checked'; } ?>> <?php echo __('Nee', 'tvds'); ?>
                <input type="radio" name="alpine" value="1" <?php if($alpine == 1){ echo 'checked'; } ?>> <?php echo __('Ja', 'tvds'); ?>
            </td>
        </tr>

        <!-- Divider -->
        <tr>
	        <td colspan="2"><hr/></td>
        </tr>
        
		<!-- Prijs Section -->
        <tr>
            <th style="width: 100%;"><?php echo __('Prijs', 'tvds'); ?></th>
            <th><?php echo __('Waarde', 'tvds'); ?></th>
        </tr>
        
        <!-- Min Week Price -->
        <tr>
	        <td style="width: 100%;"><?php echo __('Minimale week prijs', 'tvds'); ?></td>
            <td><input type="text" name="min_week_price" value="<?php echo $min_week_price; ?>" /></td>
        </tr>
        <!-- Max Week Price -->
        <tr>
	        <td style="width: 100%;"><?php echo __('Maximale week prijs', 'tvds'); ?></td>
            <td><input type="text" name="max_week_price" value="<?php echo $max_week_price; ?>" /></td>
        </tr>
        <!-- For Sale -->
        <tr>
            <td style="width: 100%;"><?php echo __('Te koop', 'tvds'); ?></td>
            <td>
                <input type="radio" name="for_sale" value="0" <?php if($for_sale == 0){ echo 'checked'; } ?>> <?php echo __('Nee', 'tvds'); ?>
                <input type="radio" name="for_sale" value="1" <?php if($for_sale == 1){ echo 'checked'; } ?>> <?php echo __('Ja', 'tvds'); ?>
            </td>
        </tr>
        <!-- Sale Price -->
        <tr>
            <td style="width: 100%;"><?php echo __('Verkoopprijs', 'tvds'); ?></td>
            <td><input type="text" name="sale_price" value="<?php echo $sale_price; ?>" /></td>
        </tr>

        <!-- Divider -->
        <tr>
            <td colspan="2"><hr/></td>
        </tr>

        <!-- Extra Info Section -->
        <tr>
            <th style="width: 100%;"><?php echo __('Extra informatie', 'tvds'); ?></th>
            <th><?php echo __('Waarde', 'tvds'); ?></th>
        </tr>

        <!-- Rating -->
        <tr>
            <td style="width: 100%;"><?php echo __('Waardering', 'tvds'); ?></td>
            <td>
                <select name="rating">
	                <option value=""><?php echo __('Geen waardering', 'tvds'); ?></option>
                    <?php
                    for($x = 1; $x <= 5; $x++){
                        if($x == $rating){
                            echo '<option selected value="'.$x.'">'.$x.' '.__('Sterren', 'tvds').'</option>';
                        }
                        else {
                            echo '<option value="'.$x.'">'.$x.' '.__('Sterren', 'tvds').'</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <!-- Additional Info -->
        <tr>
            <td style="width: 100%;"><?php echo __('Extra informatie', 'tvds'); ?></td>
            <td><textarea cols="40" rows name="additional_info"><?php echo $additional_info; ?></textarea></td>
        </tr>

    </table>
    <?php
}

// Display meta boxes
//----------------------------------------------------------------------------------------------------------------------
function tvds_display_homes_booking_meta_box( $home ) {
	
	// Display the bookings	
	do_shortcode('[tvds_booking_calendar]');
}

// Save Post
//----------------------------------------------------------------------------------------------------------------------
function tvds_save_homes_post( $home_id, $home ) {
    // Check post type for movie reviews
    if ( $home->post_type == 'homes' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['wifi'] ) && $_POST['wifi'] != '' ) {
            update_post_meta( $home_id, 'wifi', $_POST['wifi'] );
        }
        if ( isset( $_POST['pool'] ) && $_POST['pool'] != '' ) {
            update_post_meta( $home_id, 'pool', $_POST['pool'] );
        }
        if ( isset( $_POST['animals'] ) && $_POST['animals'] != '' ) {
            update_post_meta( $home_id, 'animals', $_POST['animals'] );
        }
        if ( isset( $_POST['alpine'] ) && $_POST['alpine'] != '' ) {
            update_post_meta( $home_id, 'alpine', $_POST['alpine'] );
        }
        
        if ( isset( $_POST['min_week_price'] ) && $_POST['min_week_price'] != '' ) {
            update_post_meta( $home_id, 'min_week_price', $_POST['min_week_price'] );
        }
        if ( isset( $_POST['max_week_price'] ) && $_POST['max_week_price'] != '' ) {
            update_post_meta( $home_id, 'max_week_price', $_POST['max_week_price'] );
        }
        if ( isset( $_POST['for_sale'] ) && $_POST['for_sale'] != '' ) {
            update_post_meta( $home_id, 'for_sale', $_POST['for_sale'] );
        }
        if ( isset( $_POST['sale_price'] ) && $_POST['sale_price'] != '' ) {
            update_post_meta( $home_id, 'sale_price', $_POST['sale_price'] );
        }
        if ( isset( $_POST['max_persons'] ) && $_POST['max_persons'] != '' ) {
            update_post_meta( $home_id, 'max_persons', $_POST['max_persons'] );
        }
        if ( isset( $_POST['type'] ) && $_POST['type'] != '' ) {
            update_post_meta( $home_id, 'type', $_POST['type'] );
        }

        if ( isset( $_POST['arrival_date'] ) && $_POST['arrival_date'] != '' ) {
            update_post_meta( $home_id, 'arrival_date', $_POST['arrival_date'] );
        }
        if ( isset( $_POST['leave_date'] ) && $_POST['leave_date'] != '' ) {
            update_post_meta( $home_id, 'leave_date', $_POST['leave_date'] );
        }
        if ( isset( $_POST['bedrooms'] ) && $_POST['bedrooms'] != '' ) {
            update_post_meta( $home_id, 'bedrooms', $_POST['bedrooms'] );
        }
        if ( isset( $_POST['new_contender'] ) && $_POST['new_contender'] != '' ) {
            update_post_meta( $home_id, 'new_contender', $_POST['new_contender'] );
        }

        if ( isset( $_POST['rating'] ) && $_POST['rating'] != '' ) {
            update_post_meta( $home_id, 'rating', $_POST['rating'] );
        }
    }
}
add_action( 'save_post', 'tvds_save_homes_post', 10, 2 );

// Register Listing Columns
//----------------------------------------------------------------------------------------------------------------------
function tvds_create_homes_columns( $columns ) {
    $columns['max_persons'] = __('Max personen', 'tvds');
    $columns['place'] = __('Plaats', 'tvds');
    unset( $columns['comments'] );
    return $columns;
}
add_filter('manage_edit-homes_columns', 'tvds_create_homes_columns');

// Populate Listing Columns
//----------------------------------------------------------------------------------------------------------------------
function tvds_populate_homes_columns($column){
    if ('max_persons' == $column){
        $max_persons = esc_html(get_post_meta(get_the_ID(), 'max_persons', true));
        echo $max_persons;
    }
    elseif ('place' == $column){
        $place = get_post_meta(get_the_ID(), 'place', true);
        echo $place;
    }
}
add_action('manage_posts_custom_column', 'tvds_populate_homes_columns');

// Sort Listing Columns
//----------------------------------------------------------------------------------------------------------------------
function tvds_sort_homes_columns($columns){
    $columns['max_persons'] = 'max_persons';
    $columns['place'] = 'place';

    return $columns;
}
add_filter('manage_edit-homes_sortable_columns', 'tvds_sort_homes_columns');

//add_filter( 'request', 'column_ordering' );
add_filter( 'request', 'tvds_homes_column_orderby' );
function tvds_homes_column_orderby ( $vars ) {
    if ( !is_admin() )
        return $vars;
    if ( isset( $vars['orderby'] ) && 'max_persons' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'max_persons', 'orderby' => 'meta_value_num' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'place' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'place', 'orderby' => 'meta_value' ) );
    }
    return $vars;
}

// Include The Templates
//----------------------------------------------------------------------------------------------------------------------
function tvds_homes_include_template_function($template_path){
    if(get_post_type() == 'homes'){
        if(is_single()){
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if($theme_file = locate_template(array('single-homes.php'))){
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__).'../templates/single-homes.php';
            }
        }
        elseif ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-homes.php' ) ) ) {
                $template_path = $theme_file;
            } else { $template_path = plugin_dir_path( __FILE__ ) . '../templates/archive-homes.php';

            }
        }
    }
    return $template_path;
}
add_filter( 'template_include', 'tvds_homes_include_template_function', 1 );

// Create Taxonomies
//----------------------------------------------------------------------------------------------------------------------
function tvds_create_homes_taxonomies(){
	register_taxonomy(
		'homes_region',
		'homes',
		array(
			'labels' => array(
				'name' => __('Regio'),
				'add_new_item' => __('Nieuwe regio', 'tvds'),
				'new_item_name' => __('Nieuw regio type', 'tvds'),
			),
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'regio'),
		)
	);
    register_taxonomy(
        'homes_place',
        'homes',
        array(
            'labels' => array(
                'name' => __('Plaats', 'tvds'),
                'add_new_item' => __('Nieuwe plaats', 'tvds'),
                'new_item_name' => __('Nieuwe plaats type', 'tvds')
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'plaats' ),
        )
    );
    register_taxonomy(
        'homes_type',
        'homes',
        array(
            'labels' => array(
                'name' => __('Type', 'tvds'),
                'add_new_item' => __('Nieuw type', 'tvds'),
                'new_item_name' => __('Nieuw type', 'tvds')
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'type' ),
        )
    );
}
add_action('init', 'tvds_create_homes_taxonomies', 0);
