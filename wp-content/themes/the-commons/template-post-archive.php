<?php /* Template Name: Posts Archive */ ?>
<?php get_header(); ?>

<div class="popout-flex-container flex-row">
    <?php $show_sidebar = 'hide-sidebar';
    if(function_exists('get_field')) {
        $show_sidebar = get_field('sidebar_display');
    }
    if($show_sidebar != 'hide-sidebar') { ?>
        <div class="popout-sidebar">
            <?php get_sidebar('post-archive'); ?>
        </div>
    <?php } ?>
    <div class="post-single-content <?php if($show_sidebar != 'hide-sidebar') { echo 'has-sidebar'; } ?>">
        <?php //Query first post that is published
        $posts_per_page = -1;
        $category = array();
        if(function_exists('get_field')) {
            $posts_per_page = get_field('posts_per_page');
            $category = get_field('category');
        }
        $post_args = array(
            'posts_per_page'	=> 1,
            'post_type'		=> 'post',
            'post_status' => 'publish',
            'category__in' => $category,
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