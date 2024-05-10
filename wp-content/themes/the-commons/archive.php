<?php /* Template Name: Posts Archive */ ?>
<?php get_header(); ?>

<div class="blog-flex-container flex-row">
    <?php 
    $obj = get_queried_object();
    $cat_slug = $obj->slug;
    $category_displays = 'content';
    $show_sidebar = 'hide-sidebar';
    if(function_exists('get_field')) {
        $category_displays = get_field('category_displays',$obj);
        $show_sidebar = get_field('sidebar_display',$obj);
    }
    if($show_sidebar != 'hide-sidebar') { ?>
        <div class="blog-sidebar">
            <?php get_sidebar('post-archive'); ?>
        </div>
    <?php } ?>
    <div class="blog-single-content <?php if($show_sidebar != 'hide-sidebar') { echo 'has-sidebar'; } ?>">
        <?php //Query first post that is published
        if($category_displays == 'links') {
            $posts_per_page = -1;
        } else {
            $posts_per_page = 1;
        }
        $post_args = array(
            'posts_per_page'	=> $posts_per_page,
            'post_type'		=> 'post',
            'post_status' => 'publish',
            'category__in' => array($obj->term_id),
        );
        $posts_query = new WP_Query( $post_args );
        if( $posts_query->have_posts() ) {
            while($posts_query->have_posts() ) {
                $posts_query->the_post();
                if($category_displays == 'links') {
                    echo '<div class="archive-link">';
                        echo '<a href="'.get_bloginfo('url').'?pop='.$cat_slug.'&post_id='.get_the_ID().'" title="'.get_the_title().'">';
                            echo get_the_title();
                        echo '</a>';
                    echo '</div>';
                } else {
                    get_template_part('template-parts/content-single');
                }
            }
        } else { ?>
            <p>There are no posts to show right now.</p>
        <?php } 
        wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>