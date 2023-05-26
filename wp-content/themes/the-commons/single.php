<?php get_header(); ?>
    <div class="newsy-container flex-mobile" id="newsy-container">
        <div class="flex-desktop-sidebar" id="flex-desktop-sidebar">
            <?php get_sidebar(); ?>
        </div>
        <div class="content-single">
            <?php get_template_part('template-parts/content-single'); ?>
        </div>
    </div>
<?php get_footer(); ?>