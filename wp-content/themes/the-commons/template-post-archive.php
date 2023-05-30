<?php /* Template Name: Posts Archive */ ?>
<?php get_header(); ?>

<div class="newsy-container flex-mobile" id="newsy-container">
    <div class="flex-desktop-sidebar" id="flex-desktop-sidebar">
        <?php get_sidebar(); ?>
    </div>
    <div class="content-single">
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

<div class="popout-shadow" id="popout-shadow" onclick="popOut('',1,1)"></div>

<!-- the div below (popout-container) must be left COMPLETELY empty!!!-->
<div class="popout-container" id="popout-container"></div>

<?php get_footer(); ?>