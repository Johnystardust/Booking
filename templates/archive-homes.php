<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/27/2016
 * Time: 8:51 PM
 */


get_header(); ?>

<div style="background-image: url('http://dev.timvanderslik.nl/themeawesome/wp-content/uploads/2016/10/slide2.jpg'); background-position: center top; background-size: cover; width: 100%; height: 400px;">
</div>
	
<div id="primary" style="background-color: #f8f8f8;">
	<div class="container">
		<div class="row">

			<!-- The Sidebar -->
			<div class="col-md-3">
				<div class="tvds_homes_archive_sidebar">
					<?php dynamic_sidebar('booking_sidebar'); ?>
				</div>
			</div>

			<!-- The Homes -->
			<div class="col-md-9">				
				
				<!-- Archive Page Options -->
				<div class="tvds_homes_archive_options">
					
					<!-- Order Options -->
					<div class="tvds_homes_archive_options_order">
						<form method="get" action="/themeawesome/homes/">
							
						</form>
					</div>
					
					<!-- View Options -->
					<div class="tvds_homes_archive_options_views">
						
						<div class="tvds_homes_archive_options_view_list tvds_homes_archive_view_btn active" data-view="list">
							<i class="icon icon-th-list"></i>
						</div>
						
						<div class="tvds_homes_archive_options_view_grid tvds_homes_archive_view_btn" data-view="grid">
							<i class="icon icon-th"></i>
						</div>
						<div class="tvds_homes_archive_options_view_text"><span>View:</span></div>
					</div>
					
					<div class="clearfix"></div>
				</div>
				
				
				
				<div class="tvds_homes_archive_items_wrapper">
					<?php

					// Create The Search Meta & Tax Query
					//--------------------------------------------------------------
					$search_meta 	= array();
					$tax_query 		= array('relation' => 'AND');

					// Arrays For The Different Fields
					$services 	= array('wifi', 'pool', 'animals', 'alpine');
					$taxonomies = array('province', 'region', 'place', 'type');
					$numbers 	= array('max_persons', 'bedrooms', 'stars');

					// For Each GET Request Check The $key in the arrays And Run The Appropriate Function
					foreach($_GET as $key => $value){
						if(in_array($key, $services)){
							$search_array = tvds_homes_search_services($key, $value);
							array_push($search_meta, $search_array);
						}
						elseif(in_array($key, $taxonomies)){
							$tax_search = tvds_homes_search_taxonomies($key, $value);
							array_push($tax_query, $tax_search);
						}
						elseif(in_array($key, $numbers)){
							$search_array = tvds_homes_search_numbers($key, $value);
							array_push($search_meta, $search_array);
						}
					}

					// Search Keyword
					if(isset($_GET['s'])){
						$keyword = $_GET['s'];
					}
					else {
						$keyword = '';
					}

					// Get Available Homes In The Date
					if(isset($_GET['arrival_date']) && isset($_GET['weeks'])){
						$booking_arrival_date = $_GET['arrival_date'];
						$booking_weeks = $_GET['weeks'];

						if(!empty($booking_arrival_date) && !empty($booking_weeks)){
							$exclude_homes_array = tvds_homes_search_dates($booking_arrival_date, $booking_weeks);
						}
						else {
							$exclude_homes_array = '';
						}
					}
					else {
						$exclude_homes_array = '';
					}

					// If is taxonomy query by taxonomy
					if(is_tax()){
						$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	
						$tax_query = array(
							array(
								'taxonomy' => $term->taxonomy,
								'field'    => 'slug',
								'terms'    => $term->slug,
							),
						);

						echo '<h1>Vakantiehuizen '.$term->name.'</h1><br>';
					}
					elseif(is_archive()){
						echo '<h1>Vakantiehuizen</h1><br>';
					}

					// Pagination Settings
					$posts_per_page = get_option('archive_max_posts');
					$posts_per_page = (!empty($posts_per_page) ? $posts_per_page : 12);
					$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	
	
					// The Query Arguments
					$args = array(
					    'post_type' 		=> 'homes',
						'paged'				=> $paged,
						'posts_per_page' 	=> $posts_per_page,
					    'tax_query' 		=> $tax_query,
					    'orderby'       	=> 'meta_value',
					    'meta_query'  		=> $search_meta,
					    's'					=> $keyword,
					    'post__not_in' 		=> $exclude_homes_array
					);
					
					$query = new WP_Query( $args );

					// Query The Posts
					if ( $query->have_posts() ){
						while($query->have_posts()) : $query->the_post();
							include(plugin_dir_path( __FILE__ ).'/content-home.php');
					    endwhile;

						// If The Archive Is A Taxonomy Get The Term Name And Description And Display It
						if(is_tax()){
							$term_id = get_queried_object()->term_id;
							$term = get_term($term_id);

							if(!empty($term->name) && !empty($term->description)){
								?>
								<div class="tvds_homes_archive_taxonomy_description col-md-12">
									<h4><?php echo $term->name; ?></h4>
									<p><?php echo $term->description; ?></p>
								</div>
								<?php
							}
						}
	
						wp_reset_postdata();
					}				
					else {
						include(plugin_dir_path( __FILE__ ).'/content-home-none.php');
					}
					?>
					<div class="clearfix"></div>
				</div><!-- tvds_homes_archive_items_wrapper end -->
								
				<div class="tvds_homes_archive_paginate">
					<?php
					echo paginate_links(array(
						'base'   		  	 => str_replace( 9999999, '%#%', get_pagenum_link(9999999)),
						'format' 			 => '?paged=%#%',
						'current' 			 => max(1, get_query_var('paged')),
						'total' 			 => $query->max_num_pages,
						'show_all'           => false,
						'end_size'           => 1,
						'mid_size'           => 2,
						'prev_next'          => false,
						'prev_text'          => __('« Previous'),
						'next_text'          => __('Next »'),
						'type'               => 'plain',
						'add_args'           => false,
						'add_fragment'       => '',
						'before_page_number' => '',
						'after_page_number'  => ''
					));
					?>
				</div><!-- tvds_homes_archive_paginate -->


<!--				--><?php
//				// The Query Arguments
//				$testargs = array(
//					'post_type' 		=> 'booking',
//					'posts_per_page' 	=> '-1',
//				);
//
//				$testquery = new WP_Query( $testargs );
//
//				if($testquery->have_posts() ) {
//					while ($testquery->have_posts()) : $testquery->the_post();
//						the_title();
//
//						// Get The Booked Arrival Date & Weeks
//						$arrival_date 	= get_post_meta(get_the_ID(), 'arrival_date', true);
//						$weeks 			= get_post_meta(get_the_ID(), 'weeks', true);
//
//						// Make DateTime from the strings
//						$start_date = new DateTime($arrival_date);
//						$end_date 	= new DateTime($arrival_date);
//
//						// Add The Number Of Weeks To The End Date
//						$end_date->modify('+'.$weeks.' week');
//						$end_date->modify('-1 second');
////						$start_date->modify('+1 second');
//
//
//						echo '<br>';
//						echo 'arrival_date: ';
//						print_r($start_date);
//						echo '<br>';
//						echo '<br>';
//						echo 'arrival_date: ';
//						print_r($end_date);
//						echo '<br>';
//						echo '<br>';
//						echo 'weeks: '.get_post_meta($post->ID, 'weeks', true);
//						echo '<br>';
//						echo '<br>';
//						echo 'home_id: '.get_post_meta($post->ID, 'home_id', true);
//						echo '<br><br>';
//						echo '<br><br>';
//
//
//					endwhile;
//				}
//
//
//				?>

			</div><!-- col-md-9 end -->

		</div><!-- row end -->

	</div><!-- container end -->
</div><!-- primary end -->

<?php get_footer();
