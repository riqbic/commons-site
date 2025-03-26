<?php get_header(); ?>
<div class="subpage-container">
    <?php 
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post(); ?>
            <?php 
            the_content();
        } // end while
    } // end if
    ?>
</div>
<?php get_footer(); ?>