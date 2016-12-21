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

	// Archive Options
	register_setting('tvds_homes_settings_group', 'show_default_archive_header');
	register_setting('tvds_homes_settings_group', 'show_archive_title');
	register_setting('tvds_homes_settings_group', 'archive_background');
    register_setting('tvds_homes_settings_group', 'enable_archive_grid');
    register_setting('tvds_homes_settings_group', 'archive_max_posts');
    register_setting('tvds_homes_settings_group', 'header_select');
    register_setting('tvds_homes_settings_group', 'header');
    register_setting('tvds_homes_settings_group', 'slider');

    // Single Options
    register_setting('tvds_homes_settings_group', 'show_default_single_header');
   	register_setting('tvds_homes_settings_group', 'show_single_related_homes');
    register_setting('tvds_homes_settings_group', 'single_background');
    register_setting('tvds_homes_settings_group', 'single_homes_title');
    register_setting('tvds_homes_settings_group', 'display_price');
    register_setting('tvds_homes_settings_group', 'single_header_select');
    register_setting('tvds_homes_settings_group', 'single_header');
    register_setting('tvds_homes_settings_group', 'single_slider');
    register_setting('tvds_homes_settings_group', 'single_sidebar');

    // Misc Options
    register_setting('tvds_homes_settings_group', 'layout');
    register_setting('tvds_homes_settings_group', 'header_layout');

    register_setting('tvds_homes_settings_group', 'confirmation_page');
    register_setting('tvds_homes_settings_group', 'max_future_calendars');

    register_setting('tvds_homes_settings_group', 'price_per');
    
    register_setting('tvds_homes_settings_group', 'show_empty_stars');
    
    // Rewrite Conditions
    register_setting('tvds_homes_settings_group', 'rewrite_homes');
    register_setting('tvds_homes_settings_group', 'rewrite_homes_region');
    register_setting('tvds_homes_settings_group', 'rewrite_homes_place');
    register_setting('tvds_homes_settings_group', 'rewrite_homes_type');
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
				<!-- Archive Options -->
				<!---------------------------------------->
	            <tr>
		            <th colspan="2"><?php echo __('Archief pagina', 'tvds'); ?></th>
	            </tr>
	            
	            <!-- Show Default Archive Header -->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Toon standaard archief header', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="show_default_archive_header" <?php if(get_option('show_default_archive_header') == true){ echo 'checked'; } ?>></td>
                </tr>
	            
	            <!-- Show Archive Title-->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Toon archief titel', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="show_archive_title" <?php if(get_option('show_archive_title') == true){ echo 'checked'; } ?>></td>
                </tr>
                
                <!-- Allow Grid View-->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Sta grid weergave toe op archief', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="enable_archive_grid" <?php if(get_option('enable_archive_grid') == true){ echo 'checked'; } ?>></td>
                </tr>

				<!-- Posts Per Page -->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Archive Posts per pagina', 'tvds'); ?></label></td>
                    <td><input type="number" name="archive_max_posts" value="<?php echo esc_attr(get_option('archive_max_posts')); ?>"></td>
                </tr>

                <!-- Background Color -->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Archive achtergrond', 'tvds'); ?></label></td>
                    <td><input type="text" name="archive_background" value="<?php echo esc_attr(get_option('archive_background')); ?>"></td>
                </tr>

				<!-- Archive Header -->
                <tr valign="top">
	                <td scope="row"><label><?php echo __('Archief header', 'tvds'); ?></label></td>
	                <td>
		                <select class="header_select" name="header_select">
			                <option <?php if(get_option('header_select') == 'none'){ echo 'selected'; } ?> value="none"><?php echo __('Geen', 'tvds'); ?></option>
			                <option <?php if(get_option('header_select') == 'image'){ echo 'selected'; } ?> value="image"><?php echo __('Afbeelding', 'tvds'); ?></option>
			                <option <?php if(get_option('header_select') == 'slider'){ echo 'selected'; } ?> value="slider"><?php echo __('Slider', 'tvds'); ?></option>
		                </select>
	                </td>
                </tr>

				<!-- Header Image -->
                <tr valign="top" class="header_options header_image">
	                <td scope="row"><label><?php echo __('Afbeelding', 'tvds'); ?></label></td>
	                <td><input type="text" name="header" value="<?php echo esc_attr(get_option('header')); ?>"/></td>
                </tr>

				<!-- Header Slider -->
                <tr valign="top" class="header_options header_slider">
	                <td scope="row"><label><?php echo __('Slider Shortcode', 'tvds'); ?></label></td>
	                <td><input type="text" name="slider" value="<?php echo esc_attr(get_option('slider')); ?>"></td>
                </tr>


                <!-- Single Options -->
				<!---------------------------------------->
	            <tr>
		            <th colspan="2"><?php echo __('Single pagina', 'tvds'); ?></th>
	            </tr>
	            
	            <!-- Show Default Single Header -->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Toon standaard single header', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="show_default_single_header" <?php if(get_option('show_default_single_header') == true){ echo 'checked'; } ?>></td>
                </tr>

	            <!-- Background Color -->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Single achtergrond', 'tvds'); ?></label></td>
                    <td><input type="text" name="single_background" value="<?php echo esc_attr(get_option('single_background')); ?>"></td>
                </tr>
                
                <!-- Show Archive Title-->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Toon gerelateerde huizen', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="show_single_related_homes" <?php if(get_option('show_single_related_homes') == true){ echo 'checked'; } ?>></td>
                </tr>

				<!-- Display Single Title -->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Toon titel op single homes pagina', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="single_homes_title" <?php if(get_option('single_homes_title') == true){ echo 'checked'; } ?>></td>
                </tr>
				
	            <!-- Display Price -->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Toon prijs in titel', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="display_price" <?php if(get_option('display_price') == true){ echo 'checked'; } ?>></td>
                </tr>
                
                <!-- Single Sidebar -->
                <tr valign="top">
                    <td scope="row"><label><?php echo __('Sidebar weergeven', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="single_sidebar" <?php if(get_option('single_sidebar') == true){ echo 'checked'; } ?>></td>
                </tr>

	            <!-- Single Header -->
                <tr valign="top">
	                <td scope="row"><label><?php echo __('Single header', 'tvds'); ?></label></td>
	                <td>
		                <select class="single_header_select" name="single_header_select">
			                <option <?php if(get_option('single_header_select') == 'none'){ echo 'selected'; } ?> value="none"><?php echo __('Geen', 'tvds'); ?></option>
			                <option <?php if(get_option('single_header_select') == 'image'){ echo 'selected'; } ?> value="image"><?php echo __('Afbeelding', 'tvds'); ?></option>
			                <option <?php if(get_option('single_header_select') == 'slider'){ echo 'selected'; } ?> value="slider"><?php echo __('Slider', 'tvds'); ?></option>
		                </select>
	                </td>
                </tr>

				<!-- Single Image -->
                <tr valign="top" class="single_header_options single_header_image">
	                <td scope="row"><label><?php echo __('Afbeelding', 'tvds'); ?></label></td>
	                <td><input type="text" name="single_header" value="<?php echo esc_attr(get_option('single_header')); ?>"/></td>
                </tr>

				<!-- Single Slider -->
                <tr valign="top" class="single_header_options single_header_slider">
	                <td scope="row"><label><?php echo __('Slider Shortcode', 'tvds'); ?></label></td>
	                <td><input type="text" name="single_slider" value="<?php echo esc_attr(get_option('single_slider')); ?>"></td>
                </tr>
                <tr>
	                <td><p class="howto">Deze instelling kan worden overschreven door op de individuele pagina een andere achtergrond of slider te selecteren</p></td>
                </tr>


                <!-- Misc Options -->
				<!---------------------------------------->
	            <tr>
		            <th colspan="2"><?php echo __('Overig', 'tvds'); ?></th>
	            </tr>

				<!-- Layout -->
	            <tr valign="top">
                    <td scope="row"><label><?php echo __('Layout', 'tvds'); ?></label></td>
                    <td>
	                    <label><?php echo __('Boxed', 'tvds'); ?></label>
	                    <input type="radio" name="layout" value="boxed" <?php if(get_option('layout') == 'boxed'){echo 'checked';} ?> />
                    </td>
                    <td>
	                    <label><?php echo __('Full width', 'tvds'); ?></label>
	                    <input type="radio" name="layout" value="full-width" <?php if(get_option('layout') == 'full-width'){echo 'checked';} ?> />
                    </td>
                </tr>

				<!-- Header Layout -->
                <tr valign="top">
                    <td scope="row"><label><?php echo __('Header Layout', 'tvds'); ?></label></td>
                    <td>
	                    <label><?php echo __('Boxed', 'tvds'); ?></label>
	                    <input type="radio" name="header_layout" value="boxed" <?php if(get_option('header_layout') == 'boxed'){echo 'checked';} ?> />
                    </td>
                    <td>
	                    <label><?php echo __('Full width', 'tvds'); ?></label>
	                    <input type="radio" name="header_layout" value="full-width" <?php if(get_option('header_layout') == 'full-width'){echo 'checked';} ?> />
                    </td>
                </tr>

				<!-- Confirmation Of Order Page -->
                <tr valign="top">
                    <td scope="row"><label><?php echo __('Bedankt pagina link', 'tvds'); ?></label></td>
                    <td><input type="text" name="confirmation_page" value="<?php echo esc_attr(get_option('confirmation_page')); ?>"></td>
                </tr>

				<!-- Calender Months In The Future -->
                <tr valign="top">
                    <td scope="row"><label><?php echo __('Aantal kalender maanden vooruit', 'tvds'); ?></label></td>
                    <td><input type="number" name="max_future_calendars" value="<?php echo esc_attr(get_option('max_future_calendars')); ?>"></td>
                </tr>
                <tr valign="top">
	                <td><p class="howto">Selecteer het aantal maanden de kalender heeft. Standaard 12 maanden.</p></td>
                </tr>

				<!-- Price Per -->
				<tr valign="top">
					<td><label><?php echo __('Prijs per', 'tvds') ?></label></td>
					<td>
						<select name="price_per">
							<option <?php if(get_option('price_per') == 'per_week'){echo 'selected';} ?> value="per_week"><?php echo __('Per week', 'tvds'); ?></option>
							<option <?php if(get_option('price_per') == 'per_day'){echo 'selected';} ?> value="per_day"><?php echo __('Per dag', 'tvds'); ?></option>
						</select>
					</td>
				</tr>
				
				<!-- Show Empty Stars -->
				<tr valign="top">
                    <td scope="row"><label><?php echo __('Toon lege sterren', 'tvds'); ?></label></td>
                    <td><input type="checkbox" name="show_empty_stars" <?php if(get_option('show_empty_stars') == true){ echo 'checked'; } ?>></td>
                </tr>
                
            </table>

            <?php submit_button(); ?>
        </form>
        
        
<!--
		List The Hooks for ease refference
        
        // tvds_before_homes_header
		// tvds_after_homes_header
		
		// tvds_before_single_home_footer
		// tvds_after_single_home_footer
        
-->
    </div>
    <?php
}
