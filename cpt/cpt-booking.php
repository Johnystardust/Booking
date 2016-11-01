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
            'public'        => true,
            'menu_position' => 15,
            'supports'      => array('title', 'editor', 'custom-fields'),
            'taxonomies'    => array(''),
            'has_archive'   => true,
            'show_in_menu' => 'edit.php?post_type=homes'
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
    $name = esc_html(get_post_meta($home->ID, 'name', true));
	?>
    <table>
        <tr>
            <td style="width: 100%"><?php echo __('Naam', 'tvds'); ?></td>
            <td>
                <input type="text" name="name" value="<?php echo $name; ?>" />
            </td>
        </tr>
    </table>
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
            <td style="width: 100%"><?php echo __('Home ID', 'tvds'); ?></td>
            <td>
                <input type="number" name="home_id" value="<?php echo $home_id; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Aankomst datum', 'tvds'); ?></td>
            <td>
                <input type="text" name="arrival_date" value="<?php echo $arrival; ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 100%"><?php echo __('Aantal weken', 'tvds'); ?></td>
            <td>
                <input type="number" name="weeks" value="<?php echo $weeks; ?>" />
            </td>
        </tr>
    </table>
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
        if ( isset( $_POST['arrival_date'] ) && $_POST['arrival_date'] != '' ) {
            update_post_meta( $home_id, 'arrival_date', $_POST['arrival_date'] );
        }
    }
}
add_action( 'save_post', 'tvds_save_booking_post', 10, 2 );