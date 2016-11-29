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
                $last_minute = get_post_meta($post->ID, 'last_minute', true);

                if($last_minute == 1){
                    echo '<span class="tvds_homes_archive_last_minute">Last Minute</span>';
                }
                ?>

                <a href="<?php echo get_the_post_thumbnail_url(); ?>">
                    <?php the_post_thumbnail('homes_archive_thumb'); ?>
                </a>

            </div>
            <?php
        }
        ?>

        <div class="tvds_homes_archive_item_info">
            <div class="tvds_home_archive_item_info_content">

                <a href="<?php echo get_the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>


                <?php
                if(get_post_meta($post->ID, 'stars', true)){
                    ?>
                    <ul class="tvds_homes_archive_item_info_rating">
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
                    <br/>
                    <?php
                }
                ?>


                <p class="tvds_homes_archive_item_excerpt"><?php echo wp_trim_words(get_the_excerpt(), 14); ?></p>
            </div>

            <div class="tvds_homes_archive_item_info_services">
                <ul class="tvds_homes_archive_services_information">
                    <?php
                    // Wifi
                    if(get_post_meta($post->ID, 'wifi', true) == 1) {
                        echo '<li><i class="icon icon-check"></i> <strong>Wifi</strong></li>';
                    }
                    else {
                        echo '<li><i class="icon icon-check-empty"></i> <strong>Wifi</strong></li>';
                    }

                    // Pool
                    if(get_post_meta($post->ID, 'pool', true) == 1) {
                        echo '<li><i class="icon icon-check"></i> <strong>Zwembad</strong></li>';
                    }
                    else {
                        echo '<li><i class="icon icon-check-empty"></i> <strong>Zwembad</strong></li>';
                    }

                    // Animals
                    if(get_post_meta($post->ID, 'animals', true) == 1) {
                        echo '<li><i class="icon icon-check"></i> <strong>Dieren</strong></li>';
                    }
                    else {
                        echo '<li><i class="icon icon-check-empty"></i> <strong>Dieren</strong></li>';
                    }

                    // Alpine
                    if(get_post_meta($post->ID, 'alpine', true) == 1) {
                        echo '<li><i class="icon icon-check"></i> <strong>Wintersport</strong></li>';
                    }
                    else {
                        echo '<li><i class="icon icon-check-empty"></i> <strong>Wintersport</strong></li>';
                    }
                    ?>

                    <div class="clearfix"></div>
                </ul>

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
