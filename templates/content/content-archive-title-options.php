<?php
	// Archive Page Options
	if(get_option('enable_archive_grid') == true){
		?>
		<div class="tvds_homes_archive_options">
					
			<!-- View Options -->
			<div class="tvds_homes_archive_options_views">
				
				<div class="tvds_homes_archive_options_view_list tvds_homes_archive_view_btn active" data-view="list">
					<i class="icon icon-th-list"></i>
				</div>
				
				<div class="tvds_homes_archive_options_view_grid tvds_homes_archive_view_btn" data-view="grid">
					<i class="icon icon-th"></i>
				</div>
				<div class="tvds_homes_archive_options_view_text"><span>View:</span></div>
			</div>
			
			<div class="clearfix"></div>
		</div>
		<?php
	}
	// Archive Page Title
	if(is_tax()){
		$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy'));

		// Echo The Title
		echo '<h1>Vakantiehuizen '.$term->name.'</h1><br>';
	}
	elseif(is_archive()){
		echo '<h1>Vakantiehuizen</h1><br>';
	}