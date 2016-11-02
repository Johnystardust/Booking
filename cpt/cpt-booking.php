<?php
	
// Create custom post type
//----------------------------------------------------------------------------------------------------------------------
function tvds_booking_create_post_type(){
    register_post_type('booking',
        array(
            'labels' => array(
                'name'                  => __('Bookings', 'tvds'),
                'singular_name'         => __('Booking', 'tvds'),
                'add_new'               => __('Add new', 'tvds'),
                'add_new_item'          => __('Add new booking', 'tvds'),
                'edit'                  => __('Edit', 'tvds'),
                'edit_item'             => __('Edit Booking', 'tvds'),
                'new_item'              => __('Nieuw booking', 'tvds'),
                'view'                  => __('Bekijk', 'tvds'),
                'view_item'             => __('Bekijk booking', 'tvds'),
                'search_items'          => __('Zoek boeking', 'tvds'),
                'not_found'             => __('Geen bookingen gevonden', 'tvds'),
                'not_found_in_trash'    => __('Geen bookingen gevonden in de prullenbak', 'tvds'),
                'parent'                => 'Parent booking'
            ),
            'public'        		=> true,
            'menu_position' 		=> 15,
            'supports'      		=> array('title', 'custom-fields'),
            'taxonomies'    		=> array(''),
            'has_archive'  	 		=> true,
            'show_in_menu' 			=> 'edit.php?post_type=homes',
            'show_in_nav_menus' 	=> false,
			'exclude_from_search' 	=> true,
			'publicly_queryable'  	=> false,
			'hierarchical'        	=> false,
        )
    );
}
add_action('init', 'tvds_booking_create_post_type');

// Add meta boxes
//----------------------------------------------------------------------------------------------------------------------
function tvds_add_booking_meta_boxes(){
    add_meta_box('booking_personal_info', __('Persoonsgegevens', 'tvds'), 'tvds_display_booking_personal_info_meta_box', 'booking', 'normal', 'high');
    add_meta_box('booking_booking_info', __('Booking gegevens', 'tvds'), 'tvds_display_booking_info_meta_box', 'booking', 'normal', 'high');
}
add_action('admin_init', 'tvds_add_booking_meta_boxes');

// Personal Info Meta Box
//----------------------------------------------------------------------------------------------------------------------
function tvds_display_booking_personal_info_meta_box($home){
    $name 		= esc_html(get_post_meta($home->ID, 'name', true));
    $last_name 	= esc_html(get_post_meta($home->ID, 'last_name', true));
    $street 	= esc_html(get_post_meta($home->ID, 'street', true));
    $city 		= esc_html(get_post_meta($home->ID, 'city', true));
    $postal 	= esc_html(get_post_meta($home->ID, 'postal', true));
    $phone 		= esc_html(get_post_meta($home->ID, 'phone', true));
    $email 		= esc_html(get_post_meta($home->ID, 'email', true));
    $notes 		= esc_html(get_post_meta($home->ID, 'notes', true));
    
	?>
    <table>
        <tr>
            <td style="width: 100%"><?php echo __('Naam', 'tvds'); ?></td>
            <td>
                <input disabled type="text" name="name" value="<?php echo $name; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Achternaam', 'tvds'); ?></td>
            <td>
                <input disabled type="text" name="last_name" value="<?php echo $last_name; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Straat', 'tvds'); ?></td>
            <td>
                <input disabled type="text" name="street" value="<?php echo $street; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Stad', 'tvds'); ?></td>
            <td>
                <input disabled type="text" name="city" value="<?php echo $city; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Postcode', 'tvds'); ?></td>
            <td>
                <input disabled type="text" name="postal" value="<?php echo $postal; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Telefoonnummer', 'tvds'); ?></td>
            <td>
                <input disabled type="text" name="phone" value="<?php echo $phone; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Email', 'tvds'); ?></td>
            <td>
                <input disabled type="text" name="email" value="<?php echo $email; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Opmerkingen', 'tvds'); ?></td>
            <td><textarea disabled name="notes"><?php if(isset($notes)){echo $notes;} ?></textarea></td>
        </tr>
    </table>
    
    <a class="enable_edit button"><?php echo __('Bewerken', 'tvds'); ?></a>
    <?php
}

// Booking Info Meta Box
//----------------------------------------------------------------------------------------------------------------------
function tvds_display_booking_info_meta_box($home){
	$home_id 	= esc_html(get_post_meta($home->ID, 'home_id', true));
	$arrival 	= esc_html(get_post_meta($home->ID, 'arrival_date', true));
	$weeks		= esc_html(get_post_meta($home->ID, 'weeks', true));
	?>
    <table>
	    <tr>
            <td style="width: 100%"><?php echo __('Home ID', 'tvds'); ?><a href="<?php echo get_admin_url().'post.php?post='.$home_id.'&action=edit'; ?>"><small> Huis Bekijken</small></a></td>
            <td>
                <input type="number" disabled name="home_id" value="<?php echo $home_id; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Aankomst datum', 'tvds'); ?></td>
            <td>
                <input type="text" class="datepicker" disabled name="arrival_date" value="<?php echo $arrival; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Aantal weken', 'tvds'); ?></td>
            <td>
	            <select disabled name="weeks">
		            <?php 
			            for ($x = 0; $x <= 20; $x++) {
				            ?>
					            <option <?php if($weeks == $x){echo 'selected';} ?> value="<?php echo $x; ?>"><?php echo $x; ?></option>
				            <?php
						}
			        ?>
	            </select>
            </td>
        </tr>
    </table>
    
    <a class="enable_edit button"><?php echo __('Bewerken', 'tvds'); ?></a>
    <?php
}

// Save Post
//----------------------------------------------------------------------------------------------------------------------
function tvds_save_booking_post( $home_id, $home ) {
    if ( $home->post_type == 'booking' ) {
	    
        // Store data in post meta table if present in post data
        if ( isset( $_POST['name'] ) && $_POST['name'] != '' ) {
            update_post_meta( $home_id, 'name', $_POST['name'] );
        }
        if ( isset( $_POST['last_name'] ) && $_POST['last_name'] != '' ) {
            update_post_meta( $home_id, 'last_name', $_POST['last_name'] );
        }
        if ( isset( $_POST['street'] ) && $_POST['street'] != '' ) {
            update_post_meta( $home_id, 'street', $_POST['street'] );
        }
        if ( isset( $_POST['city'] ) && $_POST['city'] != '' ) {
            update_post_meta( $home_id, 'city', $_POST['city'] );
        }
        if ( isset( $_POST['postal'] ) && $_POST['postal'] != '' ) {
            update_post_meta( $home_id, 'postal', $_POST['postal'] );
        }
        if ( isset( $_POST['phone'] ) && $_POST['phone'] != '' ) {
            update_post_meta( $home_id, 'phone', $_POST['phone'] );
        }
        if ( isset( $_POST['email'] ) && $_POST['email'] != '' ) {
            update_post_meta( $home_id, 'name', $_POST['name'] );
        }
        if ( isset( $_POST['notes'] ) && $_POST['notes'] != '' ) {
            update_post_meta( $home_id, 'notes', $_POST['notes'] );
        }


        if ( isset( $_POST['home_id'] ) && $_POST['home_id'] != '' ) {
            update_post_meta( $home_id, 'home_id', $_POST['home_id'] );
        }
        if ( isset( $_POST['arrival_date'] ) && $_POST['arrival_date'] != '' ) {
            update_post_meta( $home_id, 'arrival_date', $_POST['arrival_date'] );
        }
        if ( isset( $_POST['weeks'] ) && $_POST['weeks'] != '' ) {
            update_post_meta( $home_id, 'weeks', $_POST['weeks'] );
        }
    }
}
add_action( 'save_post', 'tvds_save_booking_post', 10, 2 );

// Register Listing Columns
//----------------------------------------------------------------------------------------------------------------------
function tvds_create_booking_columns( $columns ) {
    $columns['arrival_date'] 	= __('Aankomstdatum', 'tvds');
    $columns['home_id'] 		= __('Home ID', 'tvds');

    unset( $columns['comments'] );
    return $columns;
}
add_filter('manage_edit-booking_columns', 'tvds_create_booking_columns');

// Populate Listing Columns
//----------------------------------------------------------------------------------------------------------------------
function tvds_populate_booking_columns($column){
    if('arrival_date' == $column){
        $arrival_date = esc_html(get_post_meta(get_the_ID(), 'arrival_date', true));
        echo $arrival_date;
    }
    elseif('home_id' == $column){
	    $home_id = esc_html(get_post_meta(get_the_ID(), 'home_id', true));
	    
	    echo "<a href=".get_admin_url().'post.php?post='.$home_id.'&action=edit'.">".$home_id."</a>";
    }
}
add_action('manage_posts_custom_column', 'tvds_populate_booking_columns');

// Sort Listing Columns
//----------------------------------------------------------------------------------------------------------------------
function tvds_sort_booking_columns($columns){
    $columns['arrival_date'] 	= 'arrival_date';
    $columns['home_id']			= 'home_id';

    return $columns;
}
add_filter('manage_edit-booking_sortable_columns', 'tvds_sort_booking_columns');

//add_filter( 'request', 'column_ordering' );
add_filter( 'request', 'tvds_booking_column_orderby' );

function tvds_booking_column_orderby ( $vars ) {
    if(!is_admin())
        return $vars;
    if(isset( $vars['orderby']) && 'arrival_date' == $vars['orderby']){
        $vars = array_merge($vars, array('meta_key' => 'arrival_date', 'orderby' => 'meta_value_num'));
    }
    elseif(isset($vars['orderby']) && 'home_id' == $vars['orderby']){
	    $vars = array_merge($vars, array('meta_key' => 'home_id', 'orderby' => 'meta_value_num'));
    }
    return $vars;
}