<?php get_header(); ?>

<div class="newsy-container" id="newsy-container">
    <div class="flex-desktop-sidebar">
        <div class="grid-item bottom-border" id="blog">
            <div class="grid-preview" id="blog-preview"  onclick="popOut('blog',1,1)">
                <?php 
                    //Query 3 most recent posts that are published
                    $post_args = array(
                        'posts_per_page'	=> 1,
                        'post_type'		=> 'post',
                        'post_status' => 'publish',
                        'cat' => 21,
                    );
                    $posts_query = new WP_Query( $post_args );
                    if( $posts_query->have_posts() ) {
                        while($posts_query->have_posts() ) {
                            $posts_query->the_post(); 
                            ?>
                            <div class="blog-preview blog-item-1;" data-id="<?php echo get_the_ID(); ?>">
                            <h3><?php the_title(); ?></h3>
                            <?php echo the_post_thumbnail($size = 'post-thumbnail'); ?>
                                <div class="newsy-small">
                                    <?php the_excerpt(); ?>
                                    <!--<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Read More</a>-->
                                    READ MORE
                                </div>
                            </div>
                            <?php 
                        }
                    } else { ?>
                        <p>There are no posts to show right now.</p>
                    <?php } ?>
            </div>
            <div class="grid-content" id="blog-content">
                <img src="close_icon.png" alt="close_icon" id="close-icon" width="40" height="40" onclick="popOut('blog',1,1)">
                <div class="blog-flex-container flex-row">
                    <div class="blog-sidebar">
                        <?php 
                        //Query 3 most recent posts that are published
                        $post_args = array(
                            'posts_per_page'	=> -1,
                            'post_type'		=> 'post',
                            'post_status' => 'publish',
                            'cat' => 21,
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
                                    <h3><?php the_title(); ?></h3>
                                    <div class="newsy-small">
                                        <?php the_excerpt(); ?>
                                        <!--<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Read More</a>-->
                                        READ MORE
                                    </div>
                                </div>
                                <?php 
                            }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php } ?>
                    </div><!-- close sidebar -->
                    <div class="blog-single-content" id="blog-ajax-container">
                        
                    </div><!-- close blog content-->
                </div>
            </div>
        </div>
        <div class="grid-item bottom-border" id="blog-alt">
            <div class="grid-preview" id="blog-alt-preview"  onclick="popOut('blog-alt',1,1)">
                <?php 
                        //Query 3 most recent posts that are published
                        $post_args = array(
                            'posts_per_page'	=> 1,
                            'post_type'		=> 'post',
                            'post_status' => 'publish',
                            'cat' => 21,
                            'offset' => 1, 
                        );
                        $posts_query = new WP_Query( $post_args );
                        if( $posts_query->have_posts() ) {
                            while($posts_query->have_posts() ) {
                                $posts_query->the_post(); 
                                ?>
                                <div class="blog-preview blog-item-2;" data-id="<?php echo get_the_ID(); ?>">
                                <h3><?php the_title(); ?></h3>
                                    <div class="newsy-small">
                                        <?php the_excerpt(); ?>
                                        <!--<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Read More</a>-->
                                        READ MORE
                                    </div>
                                </div>
                                <?php 
                            }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php } ?>
            </div>
            <div class="grid-content" id="blog-alt-content">
                <img src="close_icon.png" alt="close_icon" id="close-icon" width="40" height="40" onclick="popOut('blog-alt',1,1)">
                <div class="blog-flex-container flex-row">
                    <div class="blog-sidebar">
                    <?php 
                        //Query 3 most recent posts that are published
                        $post_args = array(
                            'posts_per_page'	=> -1,
                            'post_type'		=> 'post',
                            'post_status' => 'publish',
                            'cat' => 21,
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
                                    <h3><?php the_title(); ?></h3>
                                    <div class="newsy-small">
                                        <?php the_excerpt(); ?>
                                        <!--<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Read More</a>-->
                                        READ MORE
                                    </div>
                                </div>
                                <?php 
                            }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php } ?>
                    </div><!-- close sidebar -->
                    <div class="blog-single-content" id="blog-ajax-container">
                        
                    </div><!-- close blog content-->
                </div>
            </div>
        </div>
    </div>
    <div class="flex-desktop-grid">
        <div class="grid-item" id="about-us">
            <div class="grid-preview" id="about-us-preview"  onclick="popOut('about-us',1,1)">
            </div>
            <div class="grid-content" id="about-us-content">
                    <img src="close_icon.png" alt="close_icon" id="close-icon" width="40" height="40" onclick="popOut('about-us',1,1)">
                <div class="about-us-container">
                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="placeholder.jpg" alt="placeholder image" width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis arcu euismod, scelerisque mi sed, lacinia orci. Sed ultrices ex dolor, in dapibus odio congue et. Donec et turpis purus.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>

                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="placeholder.jpg" alt="placeholder image" width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis arcu euismod, scelerisque mi sed, lacinia orci. Sed ultrices ex dolor, in dapibus odio congue et. Donec et turpis purus.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>

                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="placeholder.jpg" alt="placeholder image"  width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis arcu euismod, scelerisque mi sed, lacinia orci. Sed ultrices ex dolor, in dapibus odio congue et. Donec et turpis purus.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>

                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="placeholder.jpg" alt="placeholder image"  width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis arcu euismod, scelerisque mi sed, lacinia orci. Sed ultrices ex dolor, in dapibus odio congue et. Donec et turpis purus.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-item" id="features">
            <div class="grid-preview" id="features-preview"  onclick="popOut('features',1,1)">
                <h2>Feature</h2>
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
                                <h3><?php the_title(); ?></h3>
                                    <div class="newsy-small">
                                        <?php the_excerpt(); ?>
                                        <!--<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Read More</a>-->
                                        READ MORE
                                    </div>
                                </div>
                                <?php 
                            }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php } ?>
            </div>
            <div class="grid-content" id="features-content">
                <img src="close_icon.png" alt="close_icon" id="close-icon" width="40" height="40" onclick="popOut('features',1,1)">
                <h2 style="flex-grow: 1">Feature</h2>
                <div class="blog-flex-container flex-row">
                    <div class="blog-sidebar">
                    <?php 
                        //Query 3 most recent posts that are published
                        $post_args = array(
                            'posts_per_page'	=> -1,
                            'post_type'		=> 'post',
                            'post_status' => 'publish',
                            'cat' => 28,
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
                                    <h3><?php the_title(); ?></h3>
                                    <?php if($blogct <= 3) { ?>
                                        <div class="newsy-small">
                                            <?php the_excerpt(); ?>
                                            <!--<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Read More</a>-->
                                            READ MORE
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php 
                            }
                        } else { ?>
                            <p>There are no posts to show right now.</p>
                        <?php } ?>
                    </div><!-- close sidebar -->
                    <div class="blog-single-content" id="blog-ajax-container">
                        
                    </div><!-- close blog content-->
                </div>
            </div>
        </div>
        <div class="grid-item" id="get-involved">
            <div class="grid-preview" id="get-involved-preview"  onclick="popOut('get-involved',1,1)">
            </div>
            <div class="grid-content" id="get-involved-content">
                <img src="close_icon.png" alt="close_icon" id="close-icon" width="40" height="40" onclick="popOut('get-involved',1,1)">
                <p class="newsy">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus sapiente iusto dolore nihil. Iure ullam eaque temporibus ea expedita impedit atque, vitae velit voluptates tempore odio excepturi labore, modi reiciendis cumque id consectetur consequuntur sunt asperiores itaque. Sunt atque, a incidunt id neque non doloremque veritatis! Nam delectus dolorem pariatur.
                </p>
            </div>
        </div>
        <div class="grid-item" id="shop">
            <div class="grid-preview" id="shop-preview"  onclick="popOut('shop',1,1)">
            </div>
            <div class="grid-content" id="shop-content">
                <img src="close_icon.png" alt="close_icon" id="close-icon" width="40" height="40" onclick="popOut('shop',1,1)">
                <p class="newsy">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus sapiente iusto dolore nihil. Iure ullam eaque temporibus ea expedita impedit atque, vitae velit voluptates tempore odio excepturi labore, modi reiciendis cumque id consectetur consequuntur sunt asperiores itaque. Sunt atque, a incidunt id neque non doloremque veritatis! Nam delectus dolorem pariatur.
                </p>
            </div>
        </div>
        <div class="grid-item" id="events">
            <div class="grid-preview" id="events-preview"  onclick="popOut('events',1,1)">
            </div>
            <div class="grid-content" id="events-content">
                <img src="close_icon.png" alt="close_icon" id="close-icon" width="40" height="40" onclick="popOut('events',1,1)">
                <p class="newsy">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus sapiente iusto dolore nihil. Iure ullam eaque temporibus ea expedita impedit atque, vitae velit voluptates tempore odio excepturi labore, modi reiciendis cumque id consectetur consequuntur sunt asperiores itaque. Sunt atque, a incidunt id neque non doloremque veritatis! Nam delectus dolorem pariatur.
                </p>
            </div>
        </div>
        <div class="grid-item" id="promo-space-1">
            <p>promo-space-1</p>
        </div>
        <div class="grid-item" id="promo-space-2">
            <p>promo-space-2</p>
        </div>
    </div>
</div>

<!-- the div below (popout-container) must be left COMPLETELY empty!!!-->
<div class="popout-container" id="popout-container"></div>

<?php get_footer(); ?>