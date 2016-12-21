<!-- Related Homes -->
<div class="row">
	<div class="col-md-12">
		<h3>Gerelateerde vakantiehuizen</h3><br>
	</div>
	
	<?php
		$terms_region 	= get_the_terms($post->ID, 'homes_region');
		
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
				include(plugin_dir_path( __FILE__ ).'content-home-related.php');
										
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
					include(plugin_dir_path( __FILE__ ).'content-home-related.php');
				endwhile;
				
				wp_reset_postdata();
			}
		}
	?>
</div>