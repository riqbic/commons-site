<?php get_header(); ?>

<div class="newsy-container flex-mobile" id="newsy-container">
    <div class="flex-desktop-sidebar" id="flex-desktop-sidebar">
        <div class="grid-item " id="unpaid-videos">
            <div class="grid-preview" id="unpaid-videos-preview">
                <?php 
                    //Query 3 most recent posts that are published
                    $post_args = array(
                        'posts_per_page'	=> 4,
                        'post_type'		=> 'post',
                        'post_status' => 'publish',
                        'cat' => 31,
                    );
                    $posts_query = new WP_Query( $post_args );
                    $blogct = 0;
                    if( $posts_query->have_posts() ) {
                        while($posts_query->have_posts() ) {
                            ++$blogct;
                            $posts_query->the_post(); 
                            ?>
                            <div class="blog-preview blog-item-1 <?php if($blogct >= 2) echo "hidden-mobile";?>" data-id="<?php echo get_the_ID(); ?>">
                                <h3 style="text-align: center;"><?php the_title(); ?></h3>
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
                            <h3 style="text-align: center;"><?php the_title(); ?></h3>
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
                <?php 
                        //Query 3 most recent posts that are published
                        $post_args = array(
                            'posts_per_page'	=> 1,
                            'post_type'		=> 'post',
                            'post_status' => 'publish',
                            'cat' => 28,
                        );
                        $posts_query = new WP_Query( $post_args );
                        if( $posts_query->have_posts() ) {
                            while($posts_query->have_posts() ) {
                                $posts_query->the_post(); 
                                ?>
                                <div class="blog-preview blog-item-1;" data-id="<?php echo get_the_ID(); ?>">
                                    <div class="block-header"><h1 class="block-header-text"><?php the_title(); ?></h1></div>
                                    <?php echo the_post_thumbnail($size = 'paid-videos-thumbnail'); ?>
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
                        <h3 style="text-align: center;"><?php the_title(); ?></h3>
                        <div class="newsy"><?php echo the_excerpt(); ?></div>
                        <div class="read-more">+ open +</div>
                        <?php 
                    }
                } else { ?>
                    <p>There are no posts to show right now.</p>
                <?php } ?>
            </div>
        </div>
        <div class="grid-item" id="shop-title">
            <div class="shop-title-container">
                <a class="shop-title" href="<?php echo get_bloginfo('url'); ?>/shop" style="text-decoration: none;"> <!--  data-popup="shop" -->
                    <h3 class="shop-title">Shop</h3>
                </a>
            </div>
        </div>
        <div class="grid-item" id="shop">
            <div class="grid-preview" id="shop-preview">
                <?php echo do_shortcode('[products limit="4" columns="4" visibility="featured"]'); ?>
            </div>
        </div>
        <div class="grid-item" id="events">
            <div class="grid-preview opens-popup" id="events-preview" data-popup="events">
            <?php 
            $post_args = array(
            'post_type'		=> 'any',
            'post_status' => 'publish',
            'p' => 6516,
            );
            $posts_query = new WP_Query( $post_args );
            if( $posts_query->have_posts() ) {
                while($posts_query->have_posts() ) {
                    $posts_query->the_post(); 
                    ?>
                    <div class="event-container">
                        <img src="https://thecommons.boston/wp-content/uploads/2024/07/JOD_logo.png" style="display:block; border:none; margin:auto;" width="250px">
                        <p>Join or Die returns for a glorious seventh iteration. Spot mod, street comps, live music, community bazaar, film screening, workshops, discussion circles. JOD is the premiere USA parkour event, and this one is bigger than ever.
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
        <!--alternate method to load the blog content popout-->
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
                            <h3 style="text-align: center;"><?php the_title(); ?></h3>
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
    </div>
</div>

<div class="popout-shadow force-close-popout" id="popout-shadow"></div>

<!-- the div below (popout-container) must be left COMPLETELY empty!!!-->
<div class="popout-container" id="popout-container"></div>


<!-- data needed for popups -->
<div id="preview-content" style="display: none;">

    <div class="grid-content" id="events-html">
        <div class="popout-bar">
            <div class="popout-title">Events</div>
            <div class="popout-close force-close-popout">Close</div>
        </div>
        <?php 
        $post_args = array(
            'post_type'		=> 'any',
            'post_status' => 'publish',
            'p' => 6516,
        );
        $posts_query = new WP_Query( $post_args );
        if( $posts_query->have_posts() ) {
            while($posts_query->have_posts() ) {
                $posts_query->the_post(); 
                ?>
                <div class="event-container">
                    <h3 style="text-align: center;"><?php the_title(); ?></h3>
                    <?php echo the_content(); ?>
                </div>
                <?php 
            }
        } else { ?>
            <p>There are no posts to show right now.</p>
        <?php } 
        wp_reset_query(); ?>
    </div>

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
                        <h3 style="text-align: center;"><?php the_title(); ?></h3>
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
                    <h3 style="text-align: center;"><?php the_title(); ?></h3>
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
            <h4 class="italic" style="padding: 10px;">Up Next</h4>
            <?php 
                //Query 3 most recent posts that are published
                $post_args = array(
                    'posts_per_page'	=> -1,
                    'post_type'		=> 'post',
                    'post_status' => 'publish',
                    'category__in' => array(34)
                );
                $posts_query = new WP_Query( $post_args );
                $blogct = 0;
                if( $posts_query->have_posts() ) {
                    //Declare an iterator for blog-item class
                    $blog_item_count = 0;
                    while($posts_query->have_posts() ) {
                        $posts_query->the_post(); 
                        //Incremenent blog item count
                        ++$blog_item_count; 
                        ++$blogct; ?>
                        <div class="blog-item blog-item-<?php echo $blog_item_count; ?>" data-id="<?php echo get_the_ID(); ?>">
                            <h4><?php the_title(); ?></h4>
                            <div class="blog-thumbnail-container"><?php echo the_post_thumbnail($size = 'blog-thumbnail'); ?></div>
                            <?php if($blogct <= 999) { ?> <!-- Change this number to make fewer excerpts show up -->
                                <div class="newsy"><?php the_excerpt(); ?></div>
                                <div class="read-more">+ open +</div>
                            <?php } ?>
                        </div>
                        <?php 
                    }
                } else { ?>
                    <p>There are no posts to show right now.</p>
                <?php }
                wp_reset_query(); ?>
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
                <h4 class="italic" style="padding: 10px;">Up Next</h4>
                <?php 
                //Query 3 most recent posts that are published
                $post_args = array(
                    'posts_per_page'	=> -1,
                    'post_type'		=> 'post',
                    'post_status' => 'publish',
                    'category__in' => array(28,31)
                );
                $posts_query = new WP_Query( $post_args );
                $blogct = 0;
                if( $posts_query->have_posts() ) {
                    ++$blogct;
                    //Declare an iterator for blog-item class
                    $blog_item_count = 0;
                    while($posts_query->have_posts() ) {
                        $posts_query->the_post(); 
                        //Incremenent blog item count
                        ++$blog_item_count; ?>
                        <div class="blog-item blog-item-<?php echo $blog_item_count; ?>" data-id="<?php echo get_the_ID(); ?>">
                            <h4><?php the_title(); ?></h4>
                            <div class="blog-thumbnail-container"><?php echo the_post_thumbnail($size = 'blog-thumbnail'); ?></div>
                            <div class="newsy"><?php the_excerpt(); ?></div>
                            <div class="read-more">+ open +</div>
                        </div>
                        <?php 
                    }
                } else { ?>
                    <p>There are no posts to show right now.</p>
                <?php } 
                wp_reset_query(); ?>
            </div><!-- close sidebar -->
            <div class="blog-single-content" id="blog-ajax-container">
                <div class="post-ajax-loader"></div>
            </div><!-- close blog content-->
        </div>
    </div>
    
</div>
<?php get_footer(); ?>