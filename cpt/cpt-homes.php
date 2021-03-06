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
            'taxonomies'    => array('homes_place', 'homes_type', 'homes_region', 'homes_province', 'homes_category'),
            'menu_icon'     => 'dashicons-palmtree',
            'has_archive'   => true,
            'hierarchical'  => true,
            'rewrite'		=> 'homes',
        )
    );
}
add_action('init', 'tvds_booking_create_homes_post_type');

// Add meta boxes
//----------------------------------------------------------------------------------------------------------------------
function tvds_add_homes_meta_boxes(){
    add_meta_box('homes_detail_meta_box', __('Huis details', 'tvds'), 'tvds_display_homes_detail_meta_box', 'homes', 'normal', 'high');
    add_meta_box('homes_services_meta_box', __('Huis diensten', 'tvds'), 'tvds_display_homes_services_meta_box', 'homes', 'normal', 'high');
//    add_meta_box('homes_booking_meta_box', __('Reserveringen', 'tvds'), 'tvds_display_homes_booking_meta_box', 'homes', 'normal', 'high');
    add_meta_box('homes_header_meta_box',  __('Header', 'tvds'), 'tvds_display_homes_header_meta_box', 'homes', 'side', 'default');
}
add_action('admin_init', 'tvds_add_homes_meta_boxes');

// Display Detail meta boxes
//----------------------------------------------------------------------------------------------------------------------
function tvds_display_homes_detail_meta_box($home){
    $min_week_price     = esc_html(get_post_meta($home->ID, 'min_week_price', true));
    $max_week_price     = esc_html(get_post_meta($home->ID, 'max_week_price', true));
    $for_sale           = esc_html(get_post_meta($home->ID, 'for_sale', true));
    $sale_price         = esc_html(get_post_meta($home->ID, 'sale_price', true));
    
    $max_persons        = esc_html(get_post_meta($home->ID, 'max_persons', true));
    $bedrooms		    = esc_html(get_post_meta($home->ID, 'bedrooms', true));
    $bathrooms          = esc_html(get_post_meta($home->ID, 'bathrooms', true));
    $new_contender      = esc_html(get_post_meta($home->ID, 'new_contender', true));
    $last_minute	    = esc_html(get_post_meta($home->ID, 'last_minute', true));
    $favorite			= esc_html(get_post_meta($home->ID, 'favorite', true));

    $stars              = esc_html(get_post_meta($home->ID, 'stars', true));
    $additional_info    = get_post_meta($home->ID, 'additional_info', true);
    ?>
    <table cellpadding="5px">
	    
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
        <!-- Badkamers -->
        <tr>
            <td style="width: 100%;"><?php echo __('Badkamers', 'tvds'); ?></td>
            <td>
                <select name="bathrooms">
                    <?php
                    for($x = 1; $x <= 10; $x++){
                        if($x == $bathrooms){
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
        <!-- Last Minute -->        
        <tr>
            <td style="width: 100%;"><?php echo __('Aanbieding/Last-minute', 'tvds'); ?></td>
            <td>
                <input type="radio" name="last_minute" value="0" <?php if($last_minute == 0){ echo 'checked'; } ?>> <?php echo __('Nee', 'tvds'); ?>
                <input type="radio" name="last_minute" value="1" <?php if($last_minute == 1){ echo 'checked'; } ?>> <?php echo __('Ja', 'tvds'); ?>
            </td>
        </tr>
		<!-- Favorite -->
		<tr>
			<td style="width: 100%;"><?php echo __('Favoriet', 'tvds'); ?></td>
			<td>
				<input type="radio" name="favorite" value="0" <?php if($favorite == 0){ echo 'checked'; } ?>> <?php echo __('Nee', 'tvds'); ?>
                <input type="radio" name="favorite" value="1" <?php if($favorite == 1){ echo 'checked'; } ?>> <?php echo __('Ja', 'tvds'); ?>
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
            <td style="width: 100%;"><?php echo __('Sterren', 'tvds'); ?></td>
            <td>
                <select name="stars">
	                <option value=""><?php echo __('Geen Sterren', 'tvds'); ?></option>
                    <?php
                    for($x = 1; $x <= 5; $x++){
                        if($x == $stars){
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

/**
 * Display the services meta box for the homes custom post type
 *
 * @param $home
 */
function tvds_display_homes_services_meta_box($home){
    // Get All The Services
    $services_array = tvds_homes_get_services();

    ?>
	<table cellpadding="5px">
		<tr>
	        <th style="width: 100%;"><?php echo __('Voorzieningen', 'tvds'); ?></th>
	        <th><?php echo __('Aanwezig', 'tvds'); ?></th>
	    </tr>
		<?php
		foreach($services_array as $field){
			$value = esc_html(get_post_meta($home->ID, $field['name'], true));
			echo tvds_homes_cpt_fields_radio_helper($field['name'], $field['label'], $value);
		}
		?>

        <!-- Additional Info -->
        <tr>
            <td style="width: 100%;"><?php echo __('Extra voorzienigen informatie', 'tvds'); ?></td>
            <td><textarea cols="40" rows name="additional_services_info"><?php echo $additional_services_info; ?></textarea></td>
        </tr>
	</table>
	<?php
	
}

// Display Calendar Meta Box
//----------------------------------------------------------------------------------------------------------------------
function tvds_display_homes_booking_meta_box( $home ) {
	
	// Display the bookings	
	do_shortcode('[tvds_booking_calendar]');
}


// Display Header Meta Box
//----------------------------------------------------------------------------------------------------------------------
function tvds_display_homes_header_meta_box($home){
	
	$header_select 	= get_post_meta($home->ID, 'header_select', true);
	$header_image	= get_post_meta($home->ID, 'header_image', true);
	$header_slider 	= get_post_meta($home->ID, 'header_slider', true);
	
	
	?>
	<table cellpadding="5px">
		<!-- Header -->
		<tr>
            <td style="width: 100%;"><?php echo __('Header', 'tvds'); ?></td>
            <td>
	            <select class="header_select" name="header_select">
	                <option <?php if($header_select == 'none'){echo 'selected';} ?> value="none"><?php echo __('Geen', 'tvds'); ?></option>
	                <option <?php if($header_select == 'image'){echo 'selected';}  ?> value="image"><?php echo __('Afbeelding', 'tvds'); ?></option>
	                <option <?php if($header_select == 'slider'){echo 'selected';}  ?> value="slider"><?php echo __('Slider', 'tvds'); ?></option>
                </select>
	        </td>
        </tr>
        
        <tr class="header_options header_image">
	        <td style="width: 100%;"><?php echo __('Afbeelding', 'tvds'); ?></td>
	        <td><input name="header_image" type="text" value="<?php echo $header_image; ?>" ></td>
        </tr>
        
        <tr class="header_options header_slider">
	        <td style="width: 100%;"><?php echo __('Slider Shortcode', 'tvds'); ?></td>
	        <td><input name="header_slider" type="text" value="<?php echo $header_slider; ?>" ></td>
        </tr>	
	</table>
	<p class="howto">With the header you can set what kind of header you would like on the single home page</p>
	<?php
}

// Save Post
//----------------------------------------------------------------------------------------------------------------------
function tvds_save_homes_post( $home_id, $home ) {
    // Check post type for movie reviews
    if ( $home->post_type == 'homes' ) {

        // Get All The Services
        $services_array = tvds_homes_get_services();

        // For each service create the update_post_meta save
        foreach($services_array as $field){
            if(isset($_POST[$field['name']]) && $_POST[$field['name']] != ''){
                update_post_meta($home_id, $field['name'], $_POST[$field['name']]);
            }
        }







        if ( isset( $_POST['min_week_price'] ) ) {
            update_post_meta( $home_id, 'min_week_price', $_POST['min_week_price'] );
        }
        if ( isset( $_POST['max_week_price'] ) ) {
            update_post_meta( $home_id, 'max_week_price', $_POST['max_week_price'] );
        }
        if ( isset( $_POST['for_sale'] ) && $_POST['for_sale'] != '' ) {
            update_post_meta( $home_id, 'for_sale', $_POST['for_sale'] );
        }
        if ( isset( $_POST['sale_price'] ) ) {
            update_post_meta( $home_id, 'sale_price', $_POST['sale_price'] );
        }
        if ( isset( $_POST['max_persons'] ) && $_POST['max_persons'] != '' ) {
            update_post_meta( $home_id, 'max_persons', $_POST['max_persons'] );
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
        if ( isset( $_POST['bathrooms'] ) && $_POST['bathrooms'] != '' ) {
            update_post_meta( $home_id, 'bathrooms', $_POST['bathrooms'] );
        }
        if ( isset( $_POST['new_contender'] ) && $_POST['new_contender'] != '' ) {
            update_post_meta( $home_id, 'new_contender', $_POST['new_contender'] );
        }
        if ( isset( $_POST['last_minute'] ) && $_POST['last_minute'] != '' ) {
            update_post_meta( $home_id, 'last_minute', $_POST['last_minute'] );
        }
        if ( isset( $_POST['favorite'] ) && $_POST['favorite'] != '' ) {
            update_post_meta( $home_id, 'favorite', $_POST['favorite'] );
        }
                

        if ( isset( $_POST['stars'] ) && $_POST['stars'] != '' ) {
            update_post_meta( $home_id, 'stars', $_POST['stars'] );
        }
        
        
        
        
        
		// Header Meta Fields
		if(isset($_POST['header_select']) && $_POST['header_select'] != ''){
			update_post_meta($home_id, 'header_select', $_POST['header_select']);
		}
		if(isset($_POST['header_image']) && $_POST['header_image'] != ''){
			update_post_meta($home_id, 'header_image', $_POST['header_image']);
		}
		if(isset($_POST['header_slider']) && $_POST['header_slider'] != ''){
			update_post_meta($home_id, 'header_slider', $_POST['header_slider']);
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
			'rewrite' => array(
				'slug' 			=> 'regio',
				'with_front' 	=> false
			)
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
            'rewrite' => array(
				'slug' 			=> 'plaats',
				'with_front' 	=> false
			)
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
            'rewrite' => array(
				'slug' 			=> 'type',
				'with_front' 	=> false
			)
        )
    );
    register_taxonomy(
        'homes_province',
        'homes',
        array(
            'labels' => array(
                'name' => __('Provincie', 'tvds'),
                'add_new_item' => __('Nieuwe provincie', 'tvds'),
                'new_item_name' => __('Nieuwe provincie', 'tvds')
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => array(
				'slug' 			=> 'provincie',
				'with_front' 	=> false
			)
        )
    );
    register_taxonomy(
        'homes_category',
        'homes',
        array(
            'labels' => array(
                'name' => __('Categorie', 'tvds'),
                'add_new_item' => __('Nieuwe categorie', 'tvds'),
                'new_item_name' => __('Nieuwe categorie', 'tvds')
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'categorie' ),
        )
    );
}
add_action('init', 'tvds_create_homes_taxonomies', 0);
