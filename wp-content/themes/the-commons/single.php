<?php get_header(); ?>
    <div class="blog-flex-container flex-row">
        <div class="blog-sidebar">
            <?php get_sidebar(); ?>
        </div>
        <div class="blog-single-content">
            <?php get_template_part('template-parts/content-single'); ?>
        </div>
    </div>
<?php get_footer(); ?>