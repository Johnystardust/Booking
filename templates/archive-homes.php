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
				<?php dynamic_sidebar('booking_sidebar'); ?>
			</div>
			
			<!-- The Homes -->
			<div class="col-md-9">
				<?php
		
				// Test if there is a search
/*
				if($_GET){
				    echo 'post';
				}
				if(is_archive()){
					echo 'ARCHIVE';
				}
*/
				
				
				
				
				
				
				
				
				
				
				// Get Available Homes In The Date
				if(isset($_GET['arrival_date'])){
					$booking_arrival_date = $_GET['arrival_date'];
				}
				
				if(isset($_GET['weeks'])){
					$booking_weeks = $_GET['weeks'];	
				}
				
				if(isset($booking_arrival_date) && isset($booking_weeks)){
					// Get The Search Arrival date
					$start_date = new DateTime($booking_arrival_date);
					$end_date   = new DateTime($booking_arrival_date);
					
					$end_date->modify('+'.$booking_weeks.' week');
					
					$exclude_homes_array = tvds_homes_exclude_booked_homes($start_date, $end_date);
					var_dump($exclude_homes_array);
				}
				else {
					$exclude_homes_array = '';
				}
				
				

				
				
				
				
				// Search Keyword
				if(isset($_GET['s'])){
					$keyword = $_GET['s'];
				}
				else {
					$keyword = '';
				}
				
				// Create The Search Meta
				//--------------------------------------------------------------
				$search_meta = array();
				
				// Max Persons Search Meta
				if(isset($_GET['max_persons'])){
					$max_persons = $_GET['max_persons'];

					if(!empty($max_persons)){
						$max_persons_array = array(
					        'key'     => 'max_persons',
					        'value'   => $max_persons,
					        'compare' => '>='
					    );

						array_push($search_meta, $max_persons_array);
					}
				}
				
				// Bedrooms Search Meta
				if(isset($_GET['bedrooms'])){
					$bedrooms = $_GET['bedrooms'];

					if(!empty($bedrooms)){
						$bedrooms_array = array(
					        'key'     => 'bedrooms',
					        'value'   => $bedrooms,
					        'compare' => '>='
					    );

						array_push($search_meta, $bedrooms_array);
					}
				}

				// Wifi Search Meta
				if(isset($_GET['wifi'])){
					$wifi = $_GET['wifi'];

					if(!empty($wifi)){
						if($wifi == 1){
							$wifi_array = array(
						        'key'     => 'wifi',
						        'value'   => 1,
						        'compare' => '='
						    );

							array_push($search_meta, $wifi_array);
						}
						else if($wifi == 0){
							$wifi_array = array(
						        'key'     => 'wifi',
						        'value'   => 0,
						        'compare' => '='
						    );

						    array_push($search_meta, $wifi_array);
						}
					}
				}

				// Pool Search Meta
				if(isset($_GET['pool'])){
					$pool = $_GET['pool'];
					if(!empty($pool)){
						if($pool == 1){
							$pool_array = array(
						        'key'     => 'pool',
						        'value'   => 1,
						        'compare' => '='
						    );

							array_push($search_meta, $pool_array);
						}
						else if($pool == 0){
							$pool_array = array(
						        'key'     => 'pool',
						        'value'   => 0,
						        'compare' => '='
						    );

						    array_push($search_meta, $pool_array);
						}
					}
				}
				
				// Animals Search Meta
				if(isset($_GET['animals'])){
					$animals = $_GET['animals'];
					if(!empty($animals)){
						if($animals == 1){
							$animals_array = array(
						        'key'     => 'animals',
						        'value'   => 1,
						        'compare' => '='
						    );

							array_push($search_meta, $animals_array);
						}
						else if($animals == 0){
							$animals_array = array(
						        'key'     => 'animals',
						        'value'   => 0,
						        'compare' => '='
						    );

						    array_push($search_meta, $animals_array);
						}
					}
				}
				
				// Alpine Search Meta
				if(isset($_GET['alpine'])){
					$alpine = $_GET['alpine'];
					if(!empty($alpine)){
						if($alpine == 1){
							$alpine_array = array(
						        'key'     => 'alpine',
						        'value'   => 1,
						        'compare' => '='
						    );

							array_push($search_meta, $alpine_array);
						}
						else if($alpine == 0){
							$alpine_array = array(
						        'key'     => 'alpine',
						        'value'   => 0,
						        'compare' => '='
						    );

						    array_push($search_meta, $alpine_array);
						}
					}
				}

				// Create The Tax Query
				//--------------------------------------------------------------
				$tax_query = array('relation' => 'AND');

				// Region Taxonomy Search
				if(isset($_GET['region'])){
					$region = $_GET['region'];

					if(!empty($region)){
						$tax_query[] = array(
							'taxonomy' => 'homes_region',
							'field'    => 'slug',
							'terms'    => array($region),
						);
					}
				}

				// Place Taxonomy Search
				if(isset($_GET['place'])){
					$place = $_GET['place'];

					if(!empty($place)){
						$tax_query[] = array(
							'taxonomy' => 'homes_place',
							'field'    => 'slug',
							'terms'    => array($place),
						);
					}
				}

				// Type Taxonomy Search
				if(isset($_GET['type'])){
					$type = $_GET['type'];

					if(!empty($type)){
					    $tax_query[] = array(
							'taxonomy' => 'homes_type',
							'field'    => 'slug',
							'terms'    => array($type),
						);
					}
				}

				// If is taxonomy query by taxonomy
				if(is_tax()){
					echo 'TAX';
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

					$taxonomy = $term->taxonomy;
					$tax_slug = $term->slug;

					$tax_query = array(
						array(
							'taxonomy' => $taxonomy,
							'field'    => 'slug',
							'terms'    => $tax_slug,
						),
					);
				}


				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

				// The Query Arguments
				$args = array(
				    'post_type' 		=> 'homes',
					'paged'				=> $paged,
					'posts_per_page' 	=> 2,
				    'tax_query' 		=> $tax_query,
				    'orderby'       	=> 'meta_value',
				    'meta_query'  		=> $search_meta,
				    's'					=> $keyword,
				    'post__not_in' 		=> $exclude_homes_array
				);
				
				$query = new WP_Query( $args );
				
				if ( $query->have_posts() ){
					while($query->have_posts()) : $query->the_post();
						?>
						<div class="tvds_homes_archive_item col-md-12">
							<div class="row">
								<?php
								if(has_post_thumbnail()){
									?>
									<div class="tvds_homes_archive_item_thumbnail">
										<?php the_post_thumbnail('homes_archive_thumb'); ?>
									</div>
									<?php
								}
								?>

								<div class="tvds_homes_archive_item_info">
									<div class="tvds_home_archive_item_info_content">
										<h3><?php echo get_the_title(); ?></h3>
										<p><?php echo get_the_excerpt(); ?></p>
									</div>

									<div class="tvds_homes_archive_item_info_services">
										<ul>
											<?php
											// Wifi
											if (get_post_meta($post->ID, 'wifi', true) == 1) {
												echo '<li><i class="icon icon-signal"></i></li>';
											}

											// Pool
											if (get_post_meta($post->ID, 'pool', true) == 1) {
												echo '<li><i class="icon icon-swimming"></i></li>';
											}

											// Animals
											if (get_post_meta($post->ID, 'animals', true) == 1) {
												echo '<li><i class="icon-guidedog"></i></li>';
											}

											// Alpine
											if (get_post_meta($post->ID, 'alpine', true) == 1) {
												echo '<li><i class="icon icon-skiing"></i></li>';
											}

											// Max Persons
											if (get_post_meta($post->ID, 'max_persons', true)){
												echo '<li><i class="icon icon-user"></i><span>'.get_post_meta($post->ID, 'max_persons', true).'</span></li>';
											}

											// Bedrooms
											if (get_post_meta($post->ID, 'bedrooms', true)){
												echo '<li><i class="icon icon-bed"></i><span>'.get_post_meta($post->ID, 'bedrooms', true).'</span></li>';
											}
											?>

											<div class="clearfix"></div>
										</ul>
									</div>
								</div>

								<div class="tvds_homes_archive_item_details">

									<span><?php echo __('Vanaf', 'tvds'); ?></span></br>
									<h3><?php echo get_post_meta($post->ID, 'min_week_price', true); ?></h3>

									<a href="<?php echo get_the_permalink(); ?>"><?php echo __('Bekijk', 'tvds'); ?></a>
								</div>

							</div>
						</div>

					    <?php
				    endwhile;

					echo paginate_links( array(
						'base' => str_replace( 9999999, '%#%', get_pagenum_link( 9999999 ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $query->max_num_pages
					) );

					wp_reset_postdata();
				}				
				else {
					echo '<p>'._e( 'Sorry, no posts matched your criteria.' ).'</p>';
				}	
				?>	
			</div>

		</div>

	</div><!-- container end -->
</div><!-- primary end -->

<?php get_footer();
