<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 11/29/2016
 * Time: 9:44 PM
 */

?>
<div class="tvds_homes_archive_item col-md-12">
    <div class="tvds_homes_archive_item_inner row">
        <?php
        if(has_post_thumbnail()){
            ?>
            <div class="tvds_homes_archive_item_thumbnail">
                <!-- Last Minute -->
                <?php
                // If Home Is Last Minute Or For Sale	                
                $last_minute = get_post_meta($post->ID, 'last_minute', true);
                $for_sale	 = get_post_meta($post->ID, 'for_sale', true);
                
                
                if($last_minute || $for_sale){
                    echo '<ul class="tvds_homes_archive_item_thumbnail_banners tvds_homes_thumbnail_banners">';
                    
                        if($last_minute){
	                        echo '<li class="tvds_homes_thumbnail_banner"><span class="tvds_homes_thumbnail_last_minute">'.__('Last minute', 'tvds').'</span></li>';
                        }
                        if($for_sale){
	                        echo '<li class="tvds_homes_thumbnail_banner"><span class="tvds_homes_thumbnail_for_sale">'.__('Te koop', 'tvds').'</span></li>';
                        }
                    
                    echo '</ul>';
                }
                ?>

                <a href="<?php echo get_the_permalink(); ?>">
                    <?php the_post_thumbnail('homes_archive_thumb'); ?>
                </a>

            </div>
            <?php
        }
        ?>

        <div class="tvds_homes_archive_item_info">
            <div class="tvds_home_archive_item_info_content">

                <a href="<?php echo get_the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                
                <div class="tvds_homes_archive_item_info_categories">
	                <?php
		                $terms_province = get_the_terms($post->ID, 'homes_province');
						$terms_region 	= get_the_terms($post->ID, 'homes_region');
						$terms_place 	= get_the_terms($post->ID, 'homes_place');
													
						$province 		= tvds_homes_get_terms($terms_province);
						$region   		= tvds_homes_get_terms($terms_region);
						$place	 		= tvds_homes_get_terms($terms_place);
						
						if(!empty($province)){
							echo $province.', ';
						}
						if(!empty($region)){
							echo $region.', ';
						}
						if(!empty($place)){
							echo $place.', ';
						}
		            ?>
                </div>

                <?php
                if(get_post_meta($post->ID, 'stars', true) && get_option('show_stars')){
                    echo '<ul class="tvds_homes_archive_item_info_rating">';

                    $stars = intval(get_post_meta($post->ID, 'stars', true));

                        // For Each Rating Echo A Filed Star
                        for($x = 1; $x <= $stars; $x++){
                            echo '<li><i class="icon icon-star"></i></li>';
                        }

                        // For Each Rating Below 5 That isn't set Echo A Empty Star
                        for($i = 1; $i <= (5 - $stars); $i++){
                            echo '<li><i class="icon icon-star-empty"></i></li>';
                        }
                    echo '</ul>';
                    echo '<br/>';
                }
                else {
                    echo '<ul class="tvds_homes_archive_item_info_rating">';

                        // For Each Rating Below 5 That isn't set Echo A Empty Star
                        for($i = 1; $i <= 5; $i++){
                            echo '<li><i class="icon icon-star-empty"></i></li>';
                        }

                    echo '</ul>';
                    echo '<br/>';
                }

                // The Excerpt
                if(get_the_excerpt()){
	                ?>
                    <p class="tvds_homes_archive_item_excerpt"><?php echo wp_trim_words(get_the_excerpt(), 14); ?></p>
	                <?php
                }
                ?>
            </div>

            <div class="tvds_homes_archive_item_info_services">
                <ul class="tvds_homes_archive_room_information">
                    <?php
                    // Max Persons
                    if (get_post_meta($post->ID, 'max_persons', true)){
                        echo '<li><i class="icon icon-user"></i> <strong>'.get_post_meta($post->ID, 'max_persons', true).'</strong></li>';
                    }

                    // Bedrooms
                    if (get_post_meta($post->ID, 'bedrooms', true)){
                        echo '<li class="tvds_homes_archive_beds"><i class="icon icon-bed"></i> <strong>'.get_post_meta($post->ID, 'bedrooms', true).'</strong></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="tvds_homes_archive_item_details">

            <!-- Price -->
            <strong><?php echo __('Vanaf', 'tvds'); ?></strong>
            <h3 class="tvds_homes_archive_price">&euro; <?php echo get_post_meta($post->ID, 'min_week_price', true); ?></h3>
            <small>/per week</small><br>

            <!-- Permalink -->
            <a class="tvds_homes_book_btn" href="<?php echo get_the_permalink(); ?>"><?php echo __('Bekijk', 'tvds'); ?></a>
        </div>

    </div>
</div>
