<?php /* Template Name: Likes */ ?>

<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1><?= get_the_title();?></h1>
            <h4>Displays the post with most likes.</h4>
            
            <?php 
            /** 
             * Get most liked post in query.
             *
             * @param integer $numberposts		The number of items
             * @param array|string $post_type	Select post type
             * @param string $method			keep this as default value (post, comment, activity, topic)
             * @param string $period			Date peroid (all|today|yeterday|week|month|year)
             * @param string $status			Log status (like|unlike|dislike|undislike)
             * @return WP_Post[]|int[] 			Array of post objects or post IDs.
             */
            $the_query = wp_ulike_get_most_liked_posts( 10, array( 'post' ), 'post', 'all', 'like' );

            echo '<ul>';
            if($the_query) {
                foreach($the_query as $post) {
                    echo '<li>' . $post->post_title . ' - ' . $post->post_date . '</li>';
                    echo '<p>' . $post->post_content . '</p>';
                }
            echo '</ul>';
            } else {
                echo '<p>No liked posts.</p>';
            }
            ?>

            <h4>Displays all posts as list.</h4>

            <?php
            /** The Query
             * $args parameter can be customized for more complex db queries, ex:
             * category, post type, number of posts etc. can pe included.
            **/
            $args = array(
                'post_type'  => 'post'
            );
            $the_query = new WP_Query( $args );
            
            // The Loop
            if ( $the_query->have_posts() ) {
                echo '<ul>';
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    echo '<li>' . get_the_title() . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No posts found.</p>';
            }

            /* Restore original Post Data */
            wp_reset_postdata();
            ?>
    </div>
</div>

<?php get_footer(); ?>