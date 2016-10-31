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
					
					            <?php
						            // Update the post meta
					                if($_POST['arrival_date']){
					                    update_post_meta(get_the_ID(), 'arrival_date', $_POST['arrival_date']);
					                }
					            ?>
					            
					            
					            <!-- The booking form -->
					            <form id="new_booking" name="new_booking" method="post" action="http://dev.timvanderslik.nl/themeawesome/homes/test/">
					                <input id="arival_date" name="arrival_date" type="text" class="datepicker"/>
					                <input type="text" class="datepicker"/>
					
					                <input type="submit" value="submit">
					            </form>
					            
					            <?php 
// 						            do_action('tvds_after_booking_entry');
						            
						            /* sample usages */

									echo '<h2>Oktober 2016</h2>';
									echo tvds_booking_draw_calendar(10,2016);

									echo '<h2>November 2016</h2>';
									echo tvds_booking_draw_calendar(11,2016);

									echo '<h2>December 2016</h2>';
									echo tvds_booking_draw_calendar(12,2016);

									
//									echo '<h2>Beschikbaarheid</h2>';
//									echo tvds_booking_calendar('2016-10-01', '2017-10-31');
								?>


								<div class="week-calendar">

								</div>
					            
					            
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

<?php wp_reset_query(); ?>
<?php get_footer(); ?>