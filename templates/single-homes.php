<?php
/* Template Name: Single Homes */
get_header();

// Header, a before and after hook where you can hook in.
if(get_option('show_default_single_header')){
	include(plugin_dir_path( __FILE__ ).'content/content-header.php');	
}
?>

<div id="primary" style="background-color: <?php echo get_option('single_background'); ?>;">
	<div class="<?php if(get_option('layout') == 'boxed'){echo 'container';} ?>">
		
		<!-- Single Home Title -->
		<?php 
			if(get_option('single_homes_title')){
				include(plugin_dir_path( __FILE__ ).'content/content-single-homes-title.php');	
			}	
		?>
		
		<!-- Content/Sidebar-->
		<div class="row">
			<!-- Content -->
			<div class="<?php if(get_option('single_sidebar')){echo 'col-md-9';}else{echo 'col-md-12';} ?>">
				<?php	
					if(have_posts()){
						while(have_posts()) : the_post();
						
							echo '<div class="tvds_homes_single_home">';
							
								do_action('tvds_before_single_home_content');
							
								the_content();
							
								do_action('tvds_after_single_home_content');
							
							echo '</div>';
							
						endwhile;
					}
					else {
						echo '<h2 class="center">Not Found</h2>';
						echo '<p class="center">'._e("Sorry, but you are looking for something that isn't here.").'</p>';
					}
				?>
			</div>
			
			<!-- Sidebar -->
			<?php
			if(get_option('single_sidebar')){
				?>
				<div class="col-md-3">
					<div class="tvds_homes_single_sidebar tvds_homes_sidebar">
						<?php
							do_action('tvds_single_home_sidebar_content');
							dynamic_sidebar('single_homes_sidebar');
						?>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		
		<!-- Single Related Homes -->
		<?php 
			if(get_option('show_single_related_homes')){
				include(plugin_dir_path( __FILE__ ).'content/content-single-related-homes.php');
			} 
		?>
		
	</div><!-- container end -->
</div><!-- primary end -->

<?php wp_reset_query();


do_action('tvds_before_single_home_footer');
get_footer();
do_action('tvds_after_single_home_footer');