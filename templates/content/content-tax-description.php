<?php
	// This gets the title and description for the taxonomy 
	
	$term_id = get_queried_object()->term_id;
	$term = get_term($term_id);

	if(!empty($term->name) && !empty($term->description)){
		?>
		<div class="tvds_homes_archive_taxonomy_description col-md-12">
			<h4><?php echo $term->name; ?></h4>
			<p><?php echo $term->description; ?></p>
		</div>
		<?php
	}