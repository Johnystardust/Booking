<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/27/2016
 * Time: 8:51 PM
 */


get_header();

// Test if there is a search
if($_GET){
    echo 'post';
}

// Create taxonomy array for the search
if(!empty($_POST['type'])){
    $search_taxonomy = array(
        'taxonomy' => 'homes_type',
        'field'    => 'slug',
        'terms'    => $_POST['type'],
    );
}


$search_meta = array(
    array(
        'key'     => 'wifi',
        'value'   => 1,
        'compare' => '='
    ),
    array(
        'key'     => 'pool',
        'value'   => 1,
        'compare' => '='
    )
);

$args = array(
    'post_type' => 'homes',
    'tax_query' => array(
        $search_taxonomy,
    ),
    'orderby'        => 'meta_value',
    'meta_query'  => $search_meta,
);
$query = new WP_Query( $args );
if ( $query->have_posts() ) : ?>

    <!-- pagination here -->

    <!-- the loop -->
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <h2><?php the_title(); ?></h2>

        <ul>
            <li>Type: <?php echo get_post_meta( get_the_ID(), 'type', true ); ?></li>
            <li>Wifi: <?php echo get_post_meta( get_the_ID(), 'wifi', true ); ?></li>
            <li>Pool: <?php echo get_post_meta( get_the_ID(), 'pool', true ); ?></li>
            <li>Animals: <?php echo get_post_meta( get_the_ID(), 'animals', true ); ?></li>
        </ul>
    <?php endwhile; ?>
    <!-- end of the loop -->

    <!-- pagination here -->

    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif;

get_footer();
