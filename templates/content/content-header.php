<?php do_action('tvds_before_homes_header'); ?>

<!-- The Single Homes Header - First The Post Is Checked For A Header If is Not Set Check The Booking Options For Header -->
<div class="tvds_homes_archive_header">
	<div class="<?php if(get_option('header_layout') == 'boxed'){echo 'container';} ?>">
		<?php	
			if(get_post_meta($post->ID, 'header_select', true) == 'slider'){
				echo do_shortcode(get_post_meta($post->ID, 'header_slider', true));
			}
			else if(get_post_meta($post->ID, 'header_select', true) == 'image'){
				echo '<img src="'.get_post_meta($post->ID, 'header_image', true).'"/>';
			}
			else if(get_option('single_header_select') == 'slider'){
				echo do_shortcode(get_option('single_slider'));
			}
			else if(get_option('single_header_select') == 'image'){
				echo '<img src="'.get_option('single_image').'" />';
			}
		?>
	</div>
</div>

<?php do_action('tvds_after_homes_header'); ?>