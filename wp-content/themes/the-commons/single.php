<?php get_header(); ?>
    <div class="blog-flex-container flex-row">
        <?php 
        if ( is_singular( 'product' ) ) {
            $terms = wp_get_post_terms( get_the_ID(), 'product_tag' );
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
            $posts_query = new WP_Query( $post_args );
            if( $posts_query->have_posts() ) {
                $show_sidebar = 'show-sidebar';
            } else {
                $show_sidebar = 'hide-sidebar';
            }
            wp_reset_postdata();
        } else {
            $category = wp_get_post_categories(get_the_ID());
            $category_count = count($category);
            $show_sidebar = 'show-sidebar';
            if($category_count == 1) {
                if(function_exists('get_field')) {
                    $category_id = $category[0];
                    $term = get_term_by('id',$category_id,'category');
                    $show_sidebar = get_field('sidebar_display',$term);
                }
            }
        }
        if($show_sidebar != 'hide-sidebar') { ?>
            <div class="blog-sidebar">
                <?php get_sidebar('single-post'); ?>
            </div>
        <?php } ?>
        <div class="blog-single-content <?php if($show_sidebar != 'hide-sidebar') { echo 'has-sidebar'; } else{ echo 'single-view' ; } ?>">
            <?php 
            if ( is_singular( 'product' ) ) {

				wc_get_template_part( 'content', 'single-product' );
				
	
			} else {
                get_template_part('template-parts/content-single'); 
                comments_template('',true); 
            } ?>
        </div>
    </div>
<?php get_footer(); ?>