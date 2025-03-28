
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
        'category__in' => array(28,31,34)
    );
}
$posts_query = new WP_Query( $post_args );
$blogct = 0;
if( $posts_query->have_posts() ) {
    while($posts_query->have_posts() ) {
        $posts_query->the_post();
        ++$blogct;
        ?>
        <!-- The PHP below just says "add a margin to the first blog-item unless it's hidden, then add it to the second" -->
            <div class="blog-item <?php if(get_the_ID() == $current_post_id){ --$blogct; echo 'is-active';} ?> " style="padding: 0px 5px 5px 0px; border:none;<?php if($blogct == 1) echo "margin-top:20px;"?>">
            <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                <p style="color:blue; margin:0;"><?php the_title(); ?></p>
            </a>
        </div>
        <?php 
    }
} else { ?>
    <p>There are no posts to show right now.</p>
<?php }
wp_reset_postdata(); ?>
   