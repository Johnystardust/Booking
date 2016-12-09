<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 12/1/2016
 * Time: 14:47 PM
 */

?>
<div class="tvds_homes_related_item col-md-3 col-sm-6 col-xs-12">
	<div class="tvds_homes_related_item_inner">
		
		<!-- Post Thumbnail -->
		<div class="tvds_homes_related_thumbnail">
			<?php
				// If Post Has Thumbnail Display it. If Not Display Placeholder Image
				if(has_post_thumbnail()){
					echo '<img src="'.get_the_post_thumbnail_url().'"/>';
				}
				else {
					echo '<img src="/placeholder" />';
				}
				
				// If Home Is Last Minute Or For Sale	                
	            $last_minute = get_post_meta($post->ID, 'last_minute', true);
	            $for_sale	 = get_post_meta($post->ID, 'for_sale', true);
	            
	            
	            if($last_minute || $for_sale){
	                echo '<ul class="tvds_homes_related_thumbnail_banners tvds_homes_thumbnail_banners">';
	                
	                    if($last_minute){
	                        echo '<li class="tvds_homes_thumbnail_banner"><span class="tvds_homes_thumbnail_last_minute">'.__('Last minute', 'tvds').'</span></li>';
	                    }
	                    if($for_sale){
	                        echo '<li class="tvds_homes_thumbnail_banner"><span class="tvds_homes_thumbnail_for_sale">'.__('Te koop', 'tvds').'</span></li>';
	                    }
	                
	                echo '</ul>';
	            }
			?>
		</div>
		
		<!-- Post Content -->
		<div class="tvds_homes_related_info">
			
			<!-- The Title -->
			<a href="<?php echo get_the_permalink(); ?>"><h4><?php echo get_the_title(); ?></h4></a>
			
			<!-- Stars -->
			<?php
	            if(get_post_meta($post->ID, 'stars', true)){
	                ?>
		                <ul class="tvds_homes_related_info_rating">
		                    <?php
		                    $stars = intval(get_post_meta($post->ID, 'stars', true));
		
		                    // For Each Rating Echo A Filed Star
		                    for($x = 1; $x <= $stars; $x++){
		                        echo '<li><i class="icon icon-star"></i></li>';
		                    }
		
		                    // For Each Rating Below 5 That isn't set Echo A Empty Star
		                    for($i = 1; $i <= (5 - $stars); $i++){
		                        echo '<li><i class="icon icon-star-empty"></i></li>';
		                    }
		                    ?>
		                </ul>
	                <?php
	            }
	        ?>
	        
			<!-- The Excerpt -->
	        <p class="tvds_homes_related_excerpt"><?php echo wp_trim_words(get_the_excerpt(), 14); ?></p>
	        
			<!-- The Price -->
	        <div class="tvds_homes_related_price">
		        <strong><?php echo __('Vanaf', 'tvds'); ?></strong>		        
	            <h3 class="tvds_homes_archive_price">&euro; <?php echo get_post_meta($post->ID, 'min_week_price', true); ?></h3>
	            
	            <?php $price = (get_option('price_per') == 'per_week') ? __('Per week', 'tvds') : __('Per dag', 'tvds'); ?>
				<small>/<?php echo $price; ?></small><br>
	        </div>
	        
			<!-- The Button -->
	        <a class="tvds_homes_btn" href="<?php echo get_the_permalink(); ?>"><?php echo __('Bekijk', 'tvds'); ?></a>
		</div>
	</div>
</div>
