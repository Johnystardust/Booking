<?php
/*Template Name: Single Homes
*/

get_header(); ?>

<div style="background-image: url('http://dev.timvanderslik.nl/themeawesome/wp-content/uploads/2016/10/slide2.jpg'); background-position: center top; background-size: cover; width: 100%; height: 400px;">
</div>
	
<div id="primary">
	<div class="container">
		
		<div class="row">
			<div class="col-md-12">
				<!-- Single Homes Title -->
				<div class="tvds_single_homes_title">
					<div class="row">
						
						<!-- Single Homes title/categories/rating -->									
						<div class="col-sm-8 col-xs-12">
							<!-- Categories -->										
							<div class="tvds_single_homes_categories">
								<!-- Get The Taxonomies And Display Them, If Allowed -->
								<?php
									$terms_province = get_the_terms($post->ID, 'homes_province');
									echo tvds_homes_single_get_terms($terms_province);
									
									$terms_region = get_the_terms($post->ID, 'homes_region');
									echo tvds_homes_single_get_terms($terms_region).', ';
									
									$terms_place = get_the_terms($post->ID, 'homes_place');
									echo tvds_homes_single_get_terms($terms_place).', ';
									
									$terms_type = get_the_terms($post->ID, 'homes_type');
									echo tvds_homes_single_get_terms($terms_type).', ';
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
						<div class="col-sm-4 col-xs-12">
							<div class="tvds_single_homes_pricing">
								<span><?php echo __('Vanaf: ') ?><h3>€ <?php echo get_post_meta(get_the_ID(), 'min_week_price', true); ?></h3><small> /per week</small></span>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="row">
			
			<div class="col-md-9">

				<?php if (have_posts()) : ?>
				    <?php while (have_posts()) : the_post(); ?>						
						
						<div class="tvds_single_home">
							
				            <?php the_content(); ?>
				            
					        <div class="book">
					            
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
			
			<div class="col-md-3">
				<?php do_action('tvds_single_home_sidebar_content'); ?>
			</div>
			
			
			
			
			
			
			
			
			
		</div>
	</div><!-- container end -->
</div><!-- primary end -->

<?php wp_reset_query();

do_action('tvds_before_single_home_footer');

get_footer();