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
	
<div id="primary">
	<div class="container">
		<div class="row">
			
			<!-- The Homes -->
			<div class="col-md-9">
				<?php
		
				// Test if there is a search
				if($_GET){
				    echo 'post';
				}
				
				// Create The Search Meta
				$search_meta = array();
				
				
				// Wifi Search Meta
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
				
				// Pool Search Meta
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
				
				// Create The Tax Query
				$tax_query = array('relation' => 'AND');
				
				// Place Taxonomy Search
				$place = $_GET['place'];
				
				if(!empty($place)){
					$tax_query[] = array(
						'taxonomy' => 'homes_place',
						'field'    => 'slug',
						'terms'    => array($place),
					);
				}
				
				// Type Taxonomy Search
				$type = $_GET['type'];
				
				if(!empty($type)){
				    $tax_query[] = array(
						'taxonomy' => 'homes_type',
						'field'    => 'slug',
						'terms'    => array($type),
					);
				}
				
				// The Query Arguments
				$args = array(
				    'post_type' 	=> 'homes',
				    'tax_query' 	=> $tax_query,
				    'orderby'       => 'meta_value',
				    'meta_query'  	=> $search_meta,
				);
				
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) : ?>
				
					<div class="row" style="margin-top: 20px;">
				
					    <!-- pagination here -->
					
					    <!-- the loop -->
					    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
					    
					    	<div class="col-md-12" style="margin-bottom: 20px;">
						    	<div class="thumbnail">
							    	<?php
								    	if(has_post_thumbnail()){
									    	the_post_thumbnail('full');
								    	}
								   	?>
						    	</div>
						    	
						        <h2><?php the_title(); ?></h2>
						
						        <ul>
						            <li>Type: <?php echo get_post_meta( get_the_ID(), 'type', true ); ?></li>
						            <li>Wifi: <?php echo get_post_meta( get_the_ID(), 'wifi', true ); ?></li>
						            <li>Pool: <?php echo get_post_meta( get_the_ID(), 'pool', true ); ?></li>
						            <li>Animals: <?php echo get_post_meta( get_the_ID(), 'animals', true ); ?></li>
						        </ul>
						
						        <a href="<?php the_permalink(); ?>">Book</a>
					    	</div>
					    <?php endwhile; ?>
					    <!-- end of the loop -->
				    
  					</div>
				
				    <!-- pagination here -->
				
				    <?php wp_reset_postdata(); ?>
				
				<?php else : ?>
				    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif; ?>	
			</div>
			
			<!-- The Sidebar -->
			<div class="col-md-3">
				<?php dynamic_sidebar('booking_sidebar'); ?>
			</div>
		</div>

	</div><!-- container end -->
</div><!-- primary end -->

<?php get_footer();
