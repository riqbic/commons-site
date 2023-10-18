
<?php 
global $post;
$current_post_id = $post->ID;
$posts_per_page = -1;
$category = array();
if(function_exists('get_field')) {
    $posts_per_page = get_field('posts_per_page');
    $category = get_field('category');
}
//Query all posts that are published
$post_args = array(
    'posts_per_page'	=> $posts_per_page,
    'post_type'		=> 'post',
    'post_status' => 'publish',
    'category__in' => $category,
);
$posts_query = new WP_Query( $post_args );
if( $posts_query->have_posts() ) {
    while($posts_query->have_posts() ) {
        $posts_query->the_post(); 
        ?>
        <div class="blog-item <?php if(get_the_ID() == $current_post_id) echo 'is-active'; ?>">
            <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                <p><?php the_title(); ?></p>
            </a>
        </div>
        <?php 
    }
} else { ?>
    <p>There are no posts to show right now.</p>
<?php }
wp_reset_postdata(); ?>
   