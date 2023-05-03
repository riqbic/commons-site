<?php get_header(); ?>

<div class="newsy-container flex-mobile" id="newsy-container">
    <div class="flex-desktop-sidebar" id="flex-desktop-sidebar">
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
                                <div class="blog-thumbnail-container"><?php echo the_post_thumbnail($size = 'blog-thumbnail'); ?></div>
                                <div class="newsy-small"><?php echo the_excerpt(); ?>
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
                <span class="close blog-close" id="close-icon" onclick="popOut('blog',1,1)"></span>
                <div class="blog-flex-container flex-row">
                    <div class="hidden-desktop more-posts-toggle">
                        <span class="chevron"></span>
                        <span class="toggle-text">Show More Posts</span><!-- this text is toggle in home.js line 8-->
                    </div>
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
                                    <div class="newsy-small hidden-mobile">
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
                        <div class="loader"><img src="wp-content\themes\the-commons\img\loader.gif" alt="loader gif" width="60" height="60"></div>
                        
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
            <span class="close blog-close" id="close-icon" onclick="popOut('blog-alt',1,1)"></span>
                <div class="blog-flex-container flex-row">
                    <div class="hidden-desktop more-posts-toggle">
                        <span class="chevron"></span>
                        <span class="toggle-text">Show More Posts</span><!-- this text is toggle in home.js line 8-->
                    </div>
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
                                    <div class="newsy-small hidden-mobile">
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
                        <div class="loader"><img src="wp-content\themes\the-commons\img\loader.gif" alt="loader gif" width="60" height="60"></div>
                        
                    </div><!-- close blog content-->
                </div>
            </div>
        </div>
        <div class="grid-item" id="comic-strip">
            <?php if(function_exists('commons_get_comic')) {
                echo commons_get_comic(); 
            } ?>
        </div>
    </div>
    <div class="flex-desktop-grid grid-mobile" id="flex-desktop-grid">
        <div class="grid-item" id="about-us">
            <div class="grid-preview" id="about-us-preview"  onclick="popOut('about-us',1,1)">
            <p>about us</p>
            </div>
            <div class="grid-content" id="about-us-content">
            <span class="close blog-close" id="close-icon" onclick="popOut('about-us',1,1)"></span>
                <div class="about-us-container">
                    <h3>About Us</h3>
                    <p class="newsy-centered">Born in Boston, The Commons is a parkour org that invests in North American parkour culture. Through hosting events, uplifting local communities, and providing opportunities for athletes and artists, we are working to put America on the map.</p>
                    <p class="newsy-centered">Being a community project means that anybody and everybody can contribute to the cause, but here are some of the people that keep the wheels turning:</p>

                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="placeholder.jpg" alt="placeholder image" width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p class="newsy">Everybody loves David. David Ehrlich is the founder, heart, and soul of The Commons. He preaches radical inclusivity, and has a special gift for bringing people together. As our primary community and event coordinator, David’s job is to create community events, do outreach, and make sure that The Commons provides safe and fun spaces for all.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>

                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="wp-content\themes\the-commons\img\alec_portrait.jpg" alt="placeholder image" width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p class="newsy">Joining The Commons soon after it’s inception; Alec is the guy who makes things happen. He’s the creative director by day, web developer by night, park builder by the next day, and event coordinator after that… Alec seems to be everywhere all at once.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>

                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="wp-content\themes\the-commons\img\noah_portrait.JPG" alt="placeholder image"  width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p class="newsy">We are constantly honored that Noah chooses to work with us and believes in our vision. He is a filmmaker, visionary, and critic. He holds The Commons to a high standard, and always has something insightful to say.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>

                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="placeholder.jpg" alt="placeholder image"  width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p class="newsy">Connor is far and away the most talented mover out of any of us, and is also a genius photographer, videographer, and graphic designer. Connor has a hand in almost every piece of content that The Commons puts out in one way or another.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>

                    <div class="about-us-flexbox">
                        <div class="about-us-image">
                            <img src="placeholder.jpg" alt="placeholder image"  width="100%" height="auto">
                        </div>
                        <div class="about-us-text">
                            <p class="newsy">Before The Commons, before Instagram, and maybe before you were born, Dylan Polin was putting Boston on the map in the parkour scene. Dylan is a pillar of the North American parkour community, a lifelong friend, a valued advisor, and eager contributor to The Commons.</p>
                        </div>
                        <div class="about-us-fill"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-item bottom-border" id="features">
            <div class="grid-preview" id="features-preview"  onclick="popOut('features',1,1)">
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
                                    <h4>FEATURED</h4>
                                    <div class="features-thumbnail-container">
                                        <?php echo the_post_thumbnail($size = 'features-thumbnail'); ?>
                                        <h3 class="features-title" style="color: f2f3ed;"><?php the_title(); ?></h3>
                                    </div>
                                    <div class="newsy-small"><?php echo the_excerpt(); ?>
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
                <span class="close blog-close" id="close-icon" onclick="popOut('features',1,1)"></span>
                <div class="blog-flex-container flex-row">
                    <div class="hidden-desktop more-posts-toggle">
                        <span class="chevron"></span>
                        <span class="toggle-text">Show More Posts</span><!-- this text is toggle in home.js line 8-->
                    </div>
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
                        <div class="loader"><img src="wp-content\themes\the-commons\img\loader.gif" alt="loader gif" width="60" height="60"></div>
                        
                    </div><!-- close blog content-->
                </div>
            </div>
        </div>
        <div class="grid-item" id="get-involved">
            <div class="grid-preview" id="get-involved-preview"  onclick="popOut('get-involved',1,1)">
            <p> get involved </p>
            </div>
            <div class="grid-content" id="get-involved-content">
                <span class="close blog-close" id="close-icon" onclick="popOut('get-involved',1,1)"></span>
                <h3>Come Train!</h3>
                <p class="newsy-centered">
                    The best way to get involved is to come out and train! We try to host community sessions every week and mini-jams regularly. Follow our instagram page <a href="https://www.instagram.com/thecommons.sessions/">@thecommons.sessions</a> or <a href="https://discord.com/invite/6wzh8Gbqxt">join our Discord</a> to get the when and where.
                </p>
                <h3>Volunteer</h3>
                <p class="newsy-centered">
                    As a community based project, we include anybody who wants to help. We always need people to help organize community sessions, scout spots, and film. When it comes to jam time, there are an infinite amount of tasks to do, and our large events couldn’t happen without our amazing volunteer team.
                </p>
                <h3>Sponsor</h3>
                <p class="newsy-centered">
                    Any financial contributions are deeply appreciated, and go right back into the parkour community by improving our events, paying our team, or paying artists that display at our events. Our brand has deep connections in the parkour scene, and our content reaches all across the globe. We are mainly looking to partner with local small businesses, but are open to other options.
                </p>
                <h3>Work With Us</h3>
                <p class="newsy-centered">
                    The Commons is always looking for new athletes and artists to work with us. Got a project that fits on our site? Send us a line at collab@thecommons.boston or shoot us a DM on socials.
                </p>
            </div>
        </div>
        <div class="grid-item" id="shop">
            <div class="grid-preview" id="shop-preview"  onclick="popOut('shop',1,1)">
            <?php echo do_shortcode('[products limit="4" columns="2" visibility="featured"]'); ?>
            </div>
            <div class="grid-content" id="shop-content">
            <span class="close blog-close" id="close-icon" onclick="popOut('shop',1,1)"></span>
                <?php echo do_shortcode('[products limit="8" columns="4" category="subscriptions" cat_operator="NOT IN"]'); ?>
            </div>
        </div>
        <div class="grid-item" id="events">
            <div class="grid-preview" id="events-preview"  onclick="popOut('events',1,1)">
            <p>events</p>
            </div>
            <div class="grid-content" id="events-content">
                <span class="close blog-close" id="close-icon" onclick="popOut('events',1,1)"></span>
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

<div class="popout-shadow" id="popout-shadow" onclick="popOut('',1,1)></div>

<!-- the div below (popout-container) must be left COMPLETELY empty!!!-->
<div class="popout-container" id="popout-container"></div>

<?php get_footer(); ?>