<h3 style="text-align: center;"><?php the_title(); ?></h3>
<div class="blog-thumbnail-container">
    <?php echo the_post_thumbnail($size = 'blog-thumbnail'); ?>
</div>
<div class="newsy">
    <?php the_content(); ?>
</div>