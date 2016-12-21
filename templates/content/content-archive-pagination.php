<div class="tvds_homes_archive_paginate">
	<?php
		echo paginate_links(array(
			'base'   		  	 => str_replace( 9999999, '%#%', get_pagenum_link(9999999)),
			'format' 			 => '?paged=%#%',
			'current' 			 => max(1, get_query_var('paged')),
			'total' 			 => $query->max_num_pages,
			'show_all'           => false,
			'end_size'           => 1,
			'mid_size'           => 2,
			'prev_next'          => false,
			'prev_text'          => __('« Previous'),
			'next_text'          => __('Next »'),
			'type'               => 'plain',
			'add_args'           => false,
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => ''
		));
	?>
</div><!-- tvds_homes_archive_paginate -->