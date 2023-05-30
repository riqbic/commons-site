<?php /* Template Name: Posts Archive */ ?>
<?php get_header(); ?>

<div class="blog-flex-container flex-row">
    <div class="blog-sidebar">
        <?php get_sidebar(); ?>
    </div>
    <div class="blog-single-content">
        <?php //Query first post that is published
        $post_args = array(
            'posts_per_page'	=> 1,
            'post_type'		=> 'post',
            'post_status' => 'publish',
            'cat' => 21,
        );
        $posts_query = new WP_Query( $post_args );
        if( $posts_query->have_posts() ) {
            while($posts_query->have_posts() ) {
                $posts_query->the_post();
                get_template_part('template-parts/content-single');
            }
        } else { ?>
            <p>There are no posts to show right now.</p>
        <?php } 
        wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>