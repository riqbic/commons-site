
<?php 
global $post;
$current_post_id = $post->ID;
//Query all posts that are published
$post_args = array(
    'posts_per_page'	=> -1,
    'post_type'		=> 'post',
    'post_status' => 'publish',
    'cat' => 21,
);
$posts_query = new WP_Query( $post_args );
if( $posts_query->have_posts() ) {
    while($posts_query->have_posts() ) {
        $posts_query->the_post(); 
        ?>
        <div class="blog-preview sidebar-item <?php if(get_the_ID() == $current_post_id) echo 'current-sidebar-item'; ?>">
            <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                <h4><?php the_title(); ?></h4>
            </a>
            <div class="newsy">
                <a href="<?php echo get_permalink(); ?> ">
                    <?php echo the_excerpt(); ?>
                </a>
            </div>
        </div>
        <?php 
    }
} else { ?>
    <p>There are no posts to show right now.</p>
<?php }
wp_reset_postdata(); ?>
   