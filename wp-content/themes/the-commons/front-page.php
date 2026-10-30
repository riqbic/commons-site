<?php get_header(); ?>

<div class="newsy-container flex-mobile" id="newsy-container">
    <div class="flex-desktop-sidebar" id="flex-desktop-sidebar">
        <div class="grid-item " id="unpaid-videos">
            <div class="grid-preview" id="unpaid-videos-preview">
                <?php 
                    //Query 3 most recent posts that are published
                    $post_args = array(
                        'posts_per_page'	=> 3,
                        'post_type'		=> 'post',
                        'post_status' => 'publish',
                        'category_name' => 'articles',
                    );
                    $posts_query = new WP_Query( $post_args );
                    $blogct = 0;
                    if( $posts_query->have_posts() ) {
                        while($posts_query->have_posts() ) {
                            ++$blogct;
                            $posts_query->the_post(); 
                            ?>
                            <div class="blog-preview blog-item-1 <?php if($blogct >= 2) echo "hidden-mobile";?>" data-id="<?php echo get_the_ID(); ?>">
                                <h2><?php the_title(); ?></h2>
                                <div class="blog-thumbnail-container"><?php echo the_post_thumbnail($size = 'blog-thumbnail'); ?></div>
                                <div class="newsy"><?php echo the_excerpt(); ?></div>
                                <div class="read-more">+ open +</div>
                            </div>
                            <?php 
                        }
                    } else { ?>
                        <p>There are no posts to show right now.</p>
                    <?php } ?>
                </div>
            </div>
            <!-- <div class="grid-item" id="comic-strip">
                <?php if(function_exists('commons_get_comic')) {
                    echo commons_get_comic(); 
                } ?>
            </div> -->

    </div>
    <div class="flex-desktop-grid grid-mobile" id="flex-desktop-grid">
        <div class="grid-item" id="about-us">
            <div class="grid-preview opens-popup" id="about-us-preview" data-popup="about-us">
                <?php 
                    $post_args = array(
                        'posts_per_page'	=> 1,
                        'post_type'		=> 'any',
                        'post_status' => 'publish',
                        'p' => 127,
                    );
                    $posts_query = new WP_Query( $post_args );
                    if( $posts_query->have_posts() ) {
                        while($posts_query->have_posts() ) {
                            $posts_query->the_post(); 
                            ?>
                            <h1><?php the_title(); ?></h1>
                            <div class="newsy"><?php echo the_excerpt(); ?></div>
                            <div class="read-more">+ open +</div>
                            <?php 
                        }
                    } else { ?>
                        <p>There are no posts to show right now.</p>
                <?php } ?>
            </div>
        </div>
        <div class="grid-item " id="paid-videos">
            <div class="grid-preview" id="paid-videos-preview">
                <div class="block-header">
                    <h1 class="block-header-text">Video Feature</h1>
                    <svg class="block-header-play-icon" viewBox="0 0 36 24" aria-hidden="true">
                        <rect x="1" y="1" width="34" height="22" rx="5" />
                        <polygon points="15,7.5 23,12 15,16.5" />
                    </svg>
                </div>
                <?php 
                        //Query 5 most recent videos for the carousel
                        $post_args = array(
                            'posts_per_page'	=> 5,
                            'post_type'		=> 'post',
                            'post_status' => 'publish',
                            'category_name' => 'videos',
                        );
                        $posts_query = new WP_Query( $post_args );
                        if( $posts_query->have_posts() ) {
                            $slide_count = $posts_query->post_count; ?>
                            <div class="video-carousel">
                                <div class="video-carousel-track">
                                <?php while($posts_query->have_posts() ) {
                                    $posts_query->the_post(); ?>
                                    <div class="blog-preview video-slide" data-id="<?php echo get_the_ID(); ?>">
                                        <?php the_post_thumbnail('paid-videos-thumbnail'); ?>
                                        <?php //Excerpt and read more: mobile only ?>
                                        <div class="newsy hidden-desktop"><?php the_excerpt(); ?></div>
                                        <div class="read-more hidden-desktop">+ open +</div>
                                    </div>
                                <?php } ?>
                                </div>
                                <?php if($slide_count > 1) { ?>
                                    <div class="carousel-dots">
                                        <?php for($i = 0; $i < $slide_count; $i++) { ?>
                                            <button type="button" class="carousel-dot<?php if($i === 0) echo ' is-active'; ?>" data-index="<?php echo $i; ?>" aria-label="Go to video <?php echo $i + 1; ?>"></button>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if($slide_count > 1) {
                                //Arrows sit outside .video-carousel so they center on the header + carousel together
                                //Filled 90-degree chevron (an L-shape rotated 45deg, so the arm ends are square); the prev arrow is mirrored in CSS
                                $chevron = '<svg viewBox="0 0 16 25" aria-hidden="true"><polygon points="3.83,1 15.14,12.31 3.83,23.62 1,20.8 9.49,12.31 1,3.83" /></svg>'; ?>
                                <button type="button" class="carousel-arrow carousel-prev" aria-label="Previous video"><?php echo $chevron; ?></button>
                                <button type="button" class="carousel-arrow carousel-next" aria-label="Next video"><?php echo $chevron; ?></button>
                            <?php }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php }
                        wp_reset_postdata(); ?>
            </div>
        </div>
        <div class="grid-item" id="get-involved">
            <div class="grid-preview opens-popup" id="get-involved-preview" data-popup="get-involved">
            <?php 
                $post_args = array(
                    'post_type'		=> 'any',
                    'post_status' => 'publish',
                    'p' => 128,
                );
                $posts_query = new WP_Query( $post_args );
                if( $posts_query->have_posts() ) {
                    while($posts_query->have_posts() ) {
                        $posts_query->the_post(); 
                        ?>
                        <h1><?php the_title(); ?></h1>
                        <div class="newsy"><?php echo the_excerpt(); ?></div>
                        <div class="read-more">+ open +</div>
                        <?php 
                    }
                } else { ?>
                    <p>There are no posts to show right now.</p>
                <?php } ?>
            </div>
        </div>
        <div class="grid-item" id="shop">
            <a href="<?php echo get_bloginfo('url'); ?>/shop" class="shop-background-link"></a>
            <div class="shop-title-container">
                <h1 class="shop-title">Shop</h1>
            </div>
            <div class="grid-preview" id="shop-preview">
                <?php echo do_shortcode('[products limit="4" columns="4" visibility="featured"]'); ?>
            </div>
        </div>
        <?php /* EVENTS SECTION — commented out, re-enable when needed
        <div class="grid-item" id="events">
            <div class="grid-preview opens-popup" id="events-preview" data-popup="events">
            <?php 
            $post_args = array(
            'post_type'		=> 'any',
            'post_status' => 'publish',
            'p' => 9847,
            );
            $posts_query = new WP_Query( $post_args );
            if( $posts_query->have_posts() ) {
                while($posts_query->have_posts() ) {
                    $posts_query->the_post(); 
                    ?>
                    <div class="event-container">
                        <img src="https://thecommons.boston/wp-content/uploads/2024/07/JOD_logo.png" style="display:block; border:none; margin:auto;" width="250px">
                        <p>Join or Die returns for a glorious eigth iteration. Spot mod, street comps, live music, community bazaar, film screening, workshops, discussion circles. JOD is the premiere USA parkour event, and this one is bigger than ever.
                        </p>
                    </div>
                    <?php 
                }
            } else { ?>
                <p>There are no posts to show right now.</p>
            <?php } 
            wp_reset_query(); ?>
            </div>
        </div>
        */ ?>
        <!--alternate method to load the blog content popout-->
        <!-- ARTICLES PREVIEW — commented out, about-us and get-involved are now side by side
        <div class="grid-item" id="articles">
            <div class="grid-preview" id="articles-preview">
                <?php 
                //Query 3 most recent posts that are published
                $post_args = array(
                    'posts_per_page'	=> 3,
                    'post_type'		=> 'post',
                    'post_status' => 'publish',
                    'cat' => 34,
                );
                $posts_query = new WP_Query( $post_args );
                $blogct = 0;
                if( $posts_query->have_posts() ) {
                    while($posts_query->have_posts() ) {
                        $posts_query->the_post();
                        ++$blogct;
                        ?>
                        <div class="blog-preview blog-item-2 <?php if($blogct >= 2) echo "hidden-mobile";?>" data-id="<?php echo get_the_ID(); ?>">
                            <h3><?php the_title(); ?></h3>
                            <div class="newsy"><?php the_excerpt(); ?></div>
                            <div class="read-more">+ open +</div>
                        </div>
                        <?php 
                    }
                } else { ?>
                    <p>There are no posts to show right now.</p>
                <?php } ?>
            </div>
        </div>
        -->
    </div>
</div>

<div class="popout-shadow force-close-popout" id="popout-shadow"></div>

<!-- the div below (popout-container) must be left COMPLETELY empty!!!-->
<div class="popout-container" id="popout-container"></div>


<!-- data needed for popups -->
<div id="preview-content" style="display: none;">

    <?php /* EVENTS POPOUT — commented out, re-enable when needed
    <div class="grid-content" id="events-html">
        <div class="popout-bar">
            <div class="popout-title">JOD</div>
            <div class="popout-close force-close-popout">Close</div>
        </div>
        <?php 
        $post_args = array(
            'post_type'		=> 'any',
            'post_status' => 'publish',
            'p' => 9847,
        );
        $posts_query = new WP_Query( $post_args );
        if( $posts_query->have_posts() ) {
            while($posts_query->have_posts() ) {
                $posts_query->the_post(); 
                ?>
                <div class="event-container">
                    <h3><?php the_title(); ?></h3>
                    <?php echo the_content(); ?>
                </div>
                <?php 
            }
        } else { ?>
            <p>There are no posts to show right now.</p>
        <?php } 
        wp_reset_query(); ?>
    </div>
    */ ?>

    <div class="grid-content" id="get-involved-html">
        <div class="popout-bar">
            <div class="popout-title">Get Involved</div>
            <div class="popout-close force-close-popout">Close</div>
        </div>
        <?php 
            $post_args = array(
                'post_type'		=> 'any',
                'post_status' => 'publish',
                'p' => 128,
            );
            $posts_query = new WP_Query( $post_args );
            if( $posts_query->have_posts() ) {
                while($posts_query->have_posts() ) {
                    $posts_query->the_post(); 
                    ?>
                    <div class ="get-involved-container">
                        <h3><?php the_title(); ?></h3>
                        <div class="newsy get-involved-content-wrapper"><?php echo the_content(); ?></div>
                    </div>
                    <?php 
                }
            } else { ?>
                <p>There are no posts to show right now.</p>
        <?php }
        wp_reset_query(); ?>
    </div>

    <div class="grid-content" id="about-us-html">
        <div class="popout-bar">
            <div class="popout-title">About Us</div>
            <div class="popout-close force-close-popout">Close</div>
        </div>
        <?php 
        $post_args = array(
            'post_type'		=> 'any',
            'post_status' => 'publish',
            'p' => 127,
        );
        $posts_query = new WP_Query( $post_args );
        if( $posts_query->have_posts() ) {
            while($posts_query->have_posts() ) {
                $posts_query->the_post(); 
                ?>
                <div class ="about-us-container">
                    <h3><?php the_title(); ?></h3>
                    <div class="newsy about-us-content-wrapper"><?php echo the_content(); ?></div>
                </div>
                <?php 
            }
        } else { ?>
            <p>There are no posts to show right now.</p>
        <?php }
        wp_reset_query(); ?>
    </div>
    
    <div class="grid-content" id="articles-html">
        <div class="popout-bar">
            <div class="popout-title">Articles</div>
            <div class="post-title hidden-mobile"></div>
            <div class="popout-close force-close-popout">Close</div>
        </div>
        <div class="blog-flex-container flex-row">
            <div class="blog-sidebar hidden-mobile">
            <h5 class="italic" style="padding: 10px;">You might like...</h5>
            <?php commons_popout_sidebar_items(); ?>
            </div><!-- close sidebar -->
            <div class="blog-single-content" id="blog-ajax-container">
                <div class="loader"><img src="wp-content\themes\the-commons\img\loader.gif" alt="loader gif" width="200" height="200"></div>
                
            </div><!-- close blog content-->
        </div>
    </div>

    <!-- load content for the blog popout-->
    <div class="grid-content" id="videos-html">
        <div class="popout-bar">
            <div class="popout-title">Videos</div>
            <div class="post-title hidden-mobile"></div>
            <div class="popout-close force-close-popout">Close</div>
        </div>
        <div class="blog-flex-container flex-row">
            <div class="blog-sidebar hidden-mobile">
                <h5 class="italic" style="padding: 10px;">You might like...</h5>
                <?php commons_popout_sidebar_items(); ?>
            </div><!-- close sidebar -->
            <div class="blog-single-content" id="blog-ajax-container">
                <div class="post-ajax-loader"></div>
            </div><!-- close blog content-->
        </div>
    </div>
    
</div>
<?php get_footer(); ?>