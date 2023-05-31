<?php get_header(); ?>
    <div class="blog-flex-container flex-row">
        <?php 
        $category = wp_get_post_categories(get_the_ID());
        $category_count = count($category);
        $show_sidebar = 'show_sidebar';
        if($category_count == 1) {
            if(function_exists('get_field')) {
                $category_id = $category[0];
                $term = get_term_by('id',$category_id,'category');
                $show_sidebar = get_field('sidebar_display',$term);
            }
        }
        if($show_sidebar != 'hide-sidebar') { ?>
            <div class="blog-sidebar">
                <?php get_sidebar('single-post'); ?>
            </div>
        <?php } ?>
        <div class="blog-single-content <?php if($show_sidebar != 'hide-sidebar') { echo 'has-sidebar'; } ?>">
            <?php get_template_part('template-parts/content-single'); ?>
        </div>
    </div>
<?php get_footer(); ?>