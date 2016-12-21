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
							$terms_province = get_the_terms($post->ID, 'homes_province');
							$terms_region 	= get_the_terms($post->ID, 'homes_region');
							$terms_place 	= get_the_terms($post->ID, 'homes_place');
							$terms_type 	= get_the_terms($post->ID, 'homes_type');
														
							$province 		= tvds_homes_get_terms($terms_province);
							$region   		= tvds_homes_get_terms($terms_region);
							$place	 		= tvds_homes_get_terms($terms_place);
							$type			= tvds_homes_get_terms($terms_type);
							
							if(!empty($province)){
								echo $province.', ';
							}
							if(!empty($region)){
								echo $region.', ';
							}
							if(!empty($place)){
								echo $place.', ';
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
							if(get_post_meta($post->ID, 'stars', true) && get_option('show_stars')){

								$stars = intval(get_post_meta($post->ID, 'stars', true));

								// For Each Rating Echo A Filed Star
								for($x = 1; $x <= $stars; $x++){
									echo '<i class="icon icon-star"></i>';
								}

								// For Each Rating Below 5 That isn't set Echo A Empty Star
								for($i = 1; $i <= (5 - $stars); $i++){
									echo '<i class="icon icon-star-empty"></i>';
								}
							}
							else {
								// For Each Rating Below 5 That isn't set Echo A Empty Star
								for($i = 1; $i <= 5; $i++){
									echo '<i class="icon icon-star-empty"></i>';
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