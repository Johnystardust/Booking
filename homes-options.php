<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/22/2016
 * Time: 8:49 PM
 */

// Add Options Menu Page
//----------------------------------------------------------------------------------------------------------------------
function tvds_homes_add_options_menu(){
    // Create a Submenu Options Page
    add_submenu_page('edit.php?post_type=homes', __('Opties', 'tvds'), __('Opties', 'tvds'), 'manage_options', 'homes_options', 'tvds_homes_options_page');

    // Register The Plugin Settings
    add_action('admin_init', 'tvds_homes_options_settings');
}
add_action('admin_menu', 'tvds_homes_add_options_menu');

// Register Options Settings
//----------------------------------------------------------------------------------------------------------------------
function tvds_homes_options_settings(){
    register_setting('tvds_homes_settings_group', 'confirmation_page');
    register_setting('tvds_homes_settings_group', 'archive_max_posts');
    register_setting('tvds_homes_settings_group', 'max_future_calendars');
}

// The Settings Page
//----------------------------------------------------------------------------------------------------------------------
function tvds_homes_options_page(){
    ?>
    <div class="wrap">
        <h1><?php echo __('Huizen', 'tvds'); ?></h1>

        <form method="post" action="options.php">
            <?php settings_fields('tvds_homes_settings_group'); ?>
            <?php do_settings_sections('tvds_homes_settings_group'); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php echo __('Bedankt pagina link', 'tvds'); ?></th>
                    <td><input type="text" name="confirmation_page" value="<?php echo esc_attr(get_option('confirmation_page')); ?>"></td>
                </tr>
                
				<tr valign="top">
                    <th scope="row"><?php echo __('Archive Posts per pagina', 'tvds'); ?></th>
                    <td><input type="number" name="archive_max_posts" value="<?php echo esc_attr(get_option('archive_max_posts')); ?>"></td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><?php echo __('Aantal kalender maanden vooruit', 'tvds'); ?></th>
                    <td><input type="number" name="max_future_calendars" value="<?php echo esc_attr(get_option('max_future_calendars')); ?>"></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}