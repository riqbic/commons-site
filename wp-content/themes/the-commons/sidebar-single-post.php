
<?php 
global $post;
$current_post_id = $post->ID;

$post_type = get_post_type($current_post_id);
//Query all posts that are published
if ( is_singular( 'product' ) ) {
    $terms = wp_get_post_terms( $current_post_id, 'product_tag' );
    $term_array = array();
    if( count($terms) > 0 ){
        foreach($terms as $term){
            $term_array[] = $term->term_id;  
        }
    }
    $post_args = array(
        'posts_per_page'	=> -1,
        'post_type'		=> $post_type,
        'post_status' => 'publish',
        'tax_query' => array(
            array (
                'taxonomy' => 'product_tag',
                'field' => 'ID',
                'terms' => $term_array,
                'operator' => 'IN',
            )
        ),
    );
} else {
    $category = wp_get_post_categories($current_post_id);
    $post_args = array(
        'posts_per_page'	=> -1,
        'post_type'		=> $post_type,
        'post_status' => 'publish',
        'category__in' => '31',
    );
}
$posts_query = new WP_Query( $post_args );
if( $posts_query->have_posts() ) {
    while($posts_query->have_posts() ) {
        $posts_query->the_post(); 
        ?>
        <div class="blog-item <?php if(get_the_ID() == $current_post_id) echo 'is-active'; ?>">
            <a class="hide-underline" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                <h4><?php the_title(); ?></h4>
            </a>
            <div class="newsy">
                <a class="hide-underline" href="<?php echo get_permalink(); ?> ">
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
   