<?php
/* Template Name: Single Homes */
echo get_option('single_header_slider');
get_header(); 

// Get The Taxonomy Terms
$terms_province = get_the_terms($post->ID, 'homes_province');
$terms_region 	= get_the_terms($post->ID, 'homes_region');
$terms_place 	= get_the_terms($post->ID, 'homes_place');
$terms_type 	= get_the_terms($post->ID, 'homes_type');
?>


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

	
<div id="primary">
	<div class="<?php if(get_option('layout') == 'boxed'){echo 'container';} ?>">
		
		<div class="row">
			<div class="col-md-12">
				<!-- Single Homes Title -->
				<div class="tvds_single_homes_title">
					<div class="row">
						
						<!-- Single Homes title/categories/rating -->									
						<div class="col-sm-8 col-xs-12">
							<!-- Categories -->										
							<div class="tvds_single_homes_categories">
								
								<!-- Echo The Taxonomy Terms -->
								<?php
									$province 	= tvds_homes_get_terms($terms_province);
									$region   	= tvds_homes_get_terms($terms_region);
									$place	 	= tvds_homes_get_terms($terms_place);
									$type		= tvds_homes_get_terms($terms_type);
									
									if(!empty($province)){
										echo $province.', ';
									}
									if(!empty($region)){
										echo $region.', ';
									}
									if(!empty($place)){
										echo $region.', ';
									}
									if(!empty($type)){
										echo $type;
									}
								?>
							</div>
							
							<!-- The Title -->
							<h1><?php echo get_the_title(); ?></h1>
							
							<!-- Rating -->
							<div class="tvds_single_homes_rating">
								<?php											
									if(!empty(get_post_meta($post->ID, 'stars', true))){
										$stars = get_post_meta($post->ID, 'stars', true);
								
										for($x = 0; $x < $stars; $x++){
											echo '<i class="icon icon-star"></i>';
										}	
									}
								?>
							</div>
						</div>
						
						<!-- Single Homes pricing -->
						<?php
							if(get_option('display_price')){
								$price = (get_option('price_per') == 'per_week') ? __('Per week', 'tvds') : __('Per dag', 'tvds');
								?>
								<div class="col-sm-4 col-xs-12">
									<div class="tvds_single_homes_pricing">
										<span><?php echo __('Vanaf: ') ?><h3>€ <?php echo get_post_meta(get_the_ID(), 'min_week_price', true); ?></h3><small> /<?php echo $price; ?></small></span>
									</div>
								</div>								
								<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Content/Sidebar-->
		<div class="row">
			<!-- Content -->
			<div class="<?php if(get_option('single_sidebar')){echo 'col-md-9';}else{echo 'col-md-12';} ?>">
				<?php if (have_posts()) : ?>
				    <?php while (have_posts()) : the_post(); ?>						
						
						<div class="tvds_homes_single_home">
							
				            <?php the_content(); ?>
				            
					        <div class="book">
						        <h3>Beschikbaarheid</h3>
					            <?php do_action('tvds_after_single_home_content'); ?>

					        </div>
						</div>
				    <?php endwhile; ?>
				    <div class="navigation">
				        <div class="alignleft">
				            <?php posts_nav_link('','','&laquo; Previous Entries') ?>
				        </div>
				        <div class="alignright">
				            <?php posts_nav_link('','Next Entries &raquo;','') ?>
				        </div>
				    </div>
				<?php else : ?>
				    <h2 class="center">Not Found</h2>
				    <p class="center"><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>
				<?php endif; ?>
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
		
		<!-- Related Homes -->
		<div class="row">
			<div class="col-md-12">
				<h3>Gerelateerde vakantiehuizen</h3><br>
			</div>
			
			<?php
				// Get The homes region taxonomy and display only this posts
				$tax_query = array();
								
				if($terms_region){
					foreach($terms_region as $term){
						$tax_query[] = array(
				            'taxonomy' => 'homes_region',
				            'field'    => 'slug',
				            'terms'    => $term->slug,
				        );
					}
				}
				
				// The Query Arguments
				$args = array(
				    'post_type' 		=> 'homes',
					'posts_per_page' 	=> 4,
					'post__not_in' 		=> array(get_the_ID()),
					'tax_query' 		=> $tax_query,
				);
				
				$query = new WP_Query($args);
				
				// Get The Number Of Queried Posts And Get The Post ID
				$count = $query->post_count;
				$excluded_posts = array(get_the_ID(),);
				

				// Query The Posts
				if($query->have_posts()){
					while($query->have_posts()) : $query->the_post();
						include(plugin_dir_path( __FILE__ ).'/content-home-related.php');
												
						array_push($excluded_posts, get_the_ID());
				    endwhile;

					wp_reset_postdata();
				}
				
				
				// Query More Posts If The Related Posts Are Less Than 4
				if($count < 4){
					
					// The Query Arguments
					$more_args = array(
						'post_type' 		=> 'homes',
						'posts_per_page' 	=> 4 - $count,
						'post__not_in' 		=> $excluded_posts,
					);
					
					$more_query = new WP_Query($more_args);
					
					// Query The Posts
					if($more_query->have_posts()){
						while($more_query->have_posts()) : $more_query->the_post();
							include(plugin_dir_path( __FILE__ ).'/content-home-related.php');
						endwhile;
						
						wp_reset_postdata();
					}
				}
			?>
		</div>
		
	</div><!-- container end -->
</div><!-- primary end -->

<?php wp_reset_query();

do_action('tvds_before_single_home_footer');

get_footer();