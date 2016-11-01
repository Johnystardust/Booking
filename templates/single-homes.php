<?php
/*Template Name: Single Homes
*/

get_header(); ?>

<div style="background-image: url('http://dev.timvanderslik.nl/themeawesome/wp-content/uploads/2016/10/slide2.jpg'); background-position: center top; background-size: cover; width: 100%; height: 400px;">
</div>
	
<div id="primary">
	<div class="container">
		<div class="row">
			
			<div class="col-md-9">

				<?php if (have_posts()) : ?>
				    <?php while (have_posts()) : the_post(); ?>
						<div class="single-home">
							

				            <h1><?php echo get_the_title(); ?></h1>
				            
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
				<div class="booking-info">

				</div>

				<?php dynamic_sidebar('booking_sidebar'); ?>
			</div>
		</div>
	</div><!-- container end -->
</div><!-- primary end -->

<?php wp_reset_query();

do_action('tvds_before_single_home_footer');

get_footer();