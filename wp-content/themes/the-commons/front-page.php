<?php get_header(); ?>

<div class="newsy-container flex-mobile" id="newsy-container">
    <div class="flex-desktop-sidebar" id="flex-desktop-sidebar">
        <div class="grid-item " id="unpaid-video">
            <div class="grid-preview" id="unpaid-video-preview">
                <?php 
                    //Query 3 most recent posts that are published
                    $post_args = array(
                        'posts_per_page'	=> 4,
                        'post_type'		=> 'post',
                        'post_status' => 'publish',
                        'cat' => 31,
                    );
                    $posts_query = new WP_Query( $post_args );
                    $postct = 0;
                    if( $posts_query->have_posts() ) {
                        while($posts_query->have_posts() ) {
                            ++$postct;
                            $posts_query->the_post(); 
                            ?>
                            <div class="post-preview <?php if($postct >= 2) echo "hidden-mobile";?>" data-id="<?php echo get_the_ID(); ?>">
                                <h3 style="text-align: center;"><?php the_title(); ?></h3>
                                <div class="unpaid-video-thumbnail-container"><?php echo the_post_thumbnail($size = 'unpaid-video-thumbnail'); ?></div>
                                <div class="newsy"><?php echo the_excerpt(); ?></div>
                                <div class="read-more">+ open +</div>
                            </div>
                            <?php 
                        }
                    } else { ?>
                        <p>There are no posts to show right now.</p>
                    <?php } ?>
            </div>
            <!-- load content for the unpaid-video popout-->
            <div class="grid-content" id="unpaid-video-content">
                <div class="popout-bar">
                    <div class="popout-title">Media</div>
                    <div class="post-title hidden-mobile"></div>
                    <div class="popout-close" onclick="popOut('unpaid-video',1,1)">Close</div>
                </div>
                <div class="popout-flex-container flex-row">
                    <div class="popout-sidebar">
                        <h4 class="italic" style="padding: 10px;">Up Next</h4>
                        <?php 
                        //Query 3 most recent posts that are published
                        $post_args = array(
                            'posts_per_page'	=> -1,
                            'post_type'		=> 'post',
                            'post_status' => 'publish',
                            'cat' => 31,
                        );
                        $posts_query = new WP_Query( $post_args );
                        $postct = 0;
                        if( $posts_query->have_posts() ) {
                            ++$postct;
                            //Declare an iterator for post-item class
                            $post_item_count = 0;
                            while($posts_query->have_posts() ) {
                                $posts_query->the_post(); 
                                //Incremenent post item count
                                ++$post_item_count; ?>
                                <div class="post-item post-item-<?php echo $post_item_count; ?>" data-id="<?php echo get_the_ID(); ?>">
                                    <h4><?php the_title(); ?></h4>
                                    <div class="newsy"><?php the_excerpt(); ?></div>
                                    <div class="read-more">+ open +</div>
                                </div>
                                <?php 
                            }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php } ?>
                    </div><!-- close sidebar -->
                    <div class="post-single-content" id="post-ajax-container">
                        <div class="post-ajax-loader"></div>
                    </div><!-- close post content-->
                </div>
            </div>
            <!-- close content for the post popout-->
        </div>
    </div>
    <div class="flex-desktop-grid grid-mobile" id="flex-desktop-grid">
        <div class="grid-item" id="about-us">
            <div class="grid-preview" id="about-us-preview"  onclick="popOut('about-us',1,1)">
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
            <div class="grid-content" id="about-us-content">
                <div class="popout-bar">
                    <div class="popout-title">About Us</div>
                    <div class="popout-close" onclick="popOut('about-us',1,1)">Close</div>
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
                <?php } ?>
            </div>
        </div>
        <div class="grid-item " id="paid-video">
            <div class="grid-preview" id="paid-video-preview"  onclick="popOut('paid-video',1,1)">
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
                                <div class="post-preview" data-id="<?php echo get_the_ID(); ?>">
                                    <div class="block-header"><h1 class="block-header-text"><?php the_title(); ?></h1></div>
                                    <?php echo the_post_thumbnail($size = 'paid-video-thumbnail'); ?>
                                    <div class="newsy"><?php echo the_excerpt(); ?></div>
                                    <div class="read-more">+ open +</div>
                                </div>
                                <?php
                            }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php } ?>
            </div>
            <div class="grid-content" id="paid-video-content">
                <div class="popout-bar">
                    <div class="popout-title">Video</div>
                    <div class="post-title hidden-mobile"></div>
                    <div class="popout-close" onclick="popOut('paid-video',1,1)">Close</div>
                </div>
                <div class="popout-flex-container flex-row">
                    <div class="popout-sidebar">
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
                        $postct = 0;
                        if( $posts_query->have_posts() ) {
                            //Declare an iterator for post-item class
                            $post_item_count = 0;
                            while($posts_query->have_posts() ) {
                                $posts_query->the_post(); 
                                //Incremenent post item count
                                ++$post_item_count; 
                                ++$postct; ?>
                                <div class="post-item post-item-<?php echo $post_item_count; ?>" data-id="<?php echo get_the_ID(); ?>">
                                    <h4><?php the_title(); ?></h4>
                                    <?php if($postct <= 999) { ?> <!-- Change this number to make fewer excerpts show up -->
                                        <div class="newsy"><?php the_excerpt(); ?></div>
                                        <div class="read-more">+ open +</div>
                                    <?php } ?>
                                </div>
                                <?php 
                            }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php } ?>
                    </div><!-- close sidebar -->
                    <div class="post-single-content" id="post-ajax-container">
                        <div class="loader"><img src="wp-content\themes\the-commons\img\loader.gif" alt="loader gif" width="200" height="200"></div>
                        
                    </div><!-- close post content-->
                </div>
            </div>
        </div>
        <div class="grid-item" id="get-involved">
            <div class="grid-preview" id="get-involved-preview"  onclick="popOut('get-involved',1,1)">
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
            <div class="grid-content" id="get-involved-content">
            <div class="popout-bar">
                    <div class="popout-title">Get Involved</div>
                    <div class="popout-close" onclick="popOut('get-involved',1,1)">Close</div>
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
                <?php } ?>
            </div>
        </div>
        <div class="grid-item" id="shop-title">
            <div class="shop-title-container">
                <a class="shop-title" href="<?php echo get_bloginfo('url'); ?>/shop" style="text-decoration: none;">
                    <h3 class="shop-title">Shop</h3>
                </a>
            </div>
        </div>
        <div class="grid-item" id="shop">
            <div class="grid-preview" id="shop-preview">
                <?php echo do_shortcode('[products limit="4" columns="4" visibility="featured"]'); ?>
            </div>
            <div class="grid-content" id="shop-content">
                <div class="popout-bar">
                    <div class="popout-title">Shop</div>
                    <div class="popout-close" onclick="popOut('shop',1,1)">Close</div>
                </div>
                <div class="shop-container">
                    <?php echo do_shortcode('[products limit="8" columns="4" category="subscriptions" cat_operator="NOT IN"]'); ?>
                </div>
            </div>
        </div>
        <div class="grid-item" id="events">
            <div class="grid-preview" id="events-preview"  onclick="popOut('events',1,1)">
                <!-- Events -->
            </div>
            <div class="grid-content" id="events-content">
                <div class="popout-bar">
                    <div class="popout-title">Events</div>
                    <div class="popout-close" onclick="popOut('events',1,1)">Close</div>
                </div>
                <?php 
                $post_args = array(
                    'post_type'		=> 'any',
                    'post_status' => 'publish',
                    'p' => 109,
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
                <?php } ?>
            </div>
        </div>
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
                if( $posts_query->have_posts() ) {
                    while($posts_query->have_posts() ) {
                        $posts_query->the_post(); 
                        ?>
                        <div class="post-preview" data-id="<?php echo get_the_ID(); ?>">
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

<div class="popout-shadow" id="popout-shadow" onclick="popOut('',1,1)"></div>

<!-- the div below (popout-container) must be left COMPLETELY empty!!!-->
<div class="popout-container" id="popout-container"></div>

<?php get_footer(); ?>