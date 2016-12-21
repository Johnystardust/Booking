<?php
// Homes Archive Template
get_header();


// Header, a before and after hook where you can hook in.
if(get_option('show_default_archive_header')){
	include(plugin_dir_path( __FILE__ ).'content/content-header.php');
}
?>

<div id="primary" style="background-color: <?php echo get_option('archive_background'); ?>;">
	<div class="<?php if(get_option('layout') == 'boxed'){echo 'container';} ?>">
		<div class="row">

			<!-- The Sidebar -->
			<div class="col-md-3">
				<div class="tvds_homes_archive_sidebar tvds_homes_sidebar">
					<?php dynamic_sidebar('booking_sidebar'); ?>
				</div>
			</div>

			<!-- The Homes -->
			<div class="col-md-9">				

				<!-- Archive Title and Options -->
				<?php 
					if(get_option('show_archive_title')){
						include(plugin_dir_path( __FILE__ ).'content/content-archive-title-options.php');
					}
				?>
			
				<div class="tvds_homes_archive_items_wrapper">
					<?php
						// Create The Meta And Taxonomy Search Arguments For the Query
						$args = tvds_create_search_meta_and_tax_query($_GET);
						$query = new WP_Query($args);
	
						// Query The Posts
						if($query->have_posts()){
							
							while($query->have_posts()) : $query->the_post();
							
								include(plugin_dir_path( __FILE__ ).'content/content-home.php');
						    
						    endwhile;
		
							wp_reset_postdata();
						}
						// If There are no posts
						else {
							include(plugin_dir_path( __FILE__ ).'content/content-home-none.php');
						}
					?>
					<div class="clearfix"></div>
				</div><!-- tvds_homes_archive_items_wrapper end -->
								
				<?php include(plugin_dir_path( __FILE__ ).'content/content-archive-pagination.php'); ?>
				
				<?php
					// If The Archive Is A Taxonomy Get The Term Name And Description And Display It
					if(is_tax()){
						include(plugin_dir_path( __FILE__ ).'content/content-tax-description.php');
					}
				?>

			</div><!-- col-md-9 end -->

		</div><!-- row end -->

	</div><!-- container end -->
</div><!-- primary end -->

<!-- The Footer -->
<?php get_footer();
