<?php /* Template Name: Liked */ ?>

<?php get_header(); ?>

<?php // The Query
    $args = array( 
        'post_type' => 'post',
        'posts_per_page' => -1,
        // 'post_parent' => '0',
        // 'orderby' => 'menu_order',
        // 'meta_query' => array(
        //     array(
        //         'key' => 'first_item_key', 
        //         'value' => 'false',
        //         'compare' => '='
        //     )
        // ),
    );

    $the_query = new WP_Query( $args );
    
    // The Loop
    if ( $the_query->have_posts() ) {
        echo '<ul>';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            echo '<li>' . '<a href ' . get_the_permalink() . '</a>' . get_the_title() . '</li>';
        }
        echo '</ul>';
    } else {
        // no posts found
    }

    /* Restore original Post Data */
    wp_reset_postdata(); 
?>
 
<?php get_footer(); ?>