<?php get_header(); ?>

<div class="newsy-container grid-mobile" id="newsy-container">
    <div class="grid-item grid-item-1" id="about-us">
        <div class="grid-preview" id="about-us-preview"  onclick="popOut('about-us',1,1)">
            <h2>About us</h2>
        </div>
        <div class="grid-content" id="about-us-content"  onclick="popOut('about-us',1,1)">
            <h2>About us</h2>
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
    <div class="grid-item grid-item-2" id="features">
        <div class="grid-preview" id="features-preview"  onclick="popOut('features',1,1)">
            <h2>Features</h2>
        </div>
        <div class="grid-content" id="features-content"  onclick="popOut('features',1,1)">
            <h2>Features</h2>
            <img src="<?php echo get_template_directory_uri(); ?>/img/group_pallets_crop.png" alt="group pallets" id="group-pallets" width="300" height="200">
            <p class="newsy">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum nostrum in quis debitis qui unde iusto adipisci corrupti animi! Molestiae porro iusto sapiente, nisi inventore illum sint at itaque quae, nemo aut enim eius eaque, fugiat explicabo omnis perferendis? Quo placeat corporis laudantium magni beatae earum dolorem iste sequi velit.
            </p>
        </div>
    </div>
    <div class="grid-item grid-item-3" id="blog">
        <div class="grid-preview" id="blog-preview"  onclick="popOut('blog',1,1)">
            <h2>Blog</h2>
        </div>
        <div class="grid-content" id="blog-content"  onclick="popOut('blog',1,1)">
            <h2>Blog</h2>
            <div class="blog-flex-container">
                <?php 
                //Query 3 most recent posts that are published
                $post_args = array(
                    'posts_per_page'	=> 3,
                    'post_type'		=> 'post',
                    'post_status' => 'publish',
                );
                $posts_query = new WP_Query( $post_args );
                if( $posts_query->have_posts() ) {
                    //Declare an iterator for blog-item class
                    $blog_item_count = 0;
                    while($posts_query->have_posts() ) {
                        $posts_query->the_post(); 
                        //Incremenent blog item count
                        ++$blog_item_count; ?>
                        <div class="blog-item-<?php echo $blog_item_count; ?>">
                            <h3><?php the_title(); ?></h3>
                            <div class="newsy-small">
                                <?php the_excerpt(); ?>
                                <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Read More</a>
                            </div>
                        </div>
                        <?php 
                    }
                } else { ?>
                    <p>There are no posts to show right now.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="grid-item grid-item-4" id="get-involved">
        <div class="grid-preview" id="get-involved-preview"  onclick="popOut('get-involved',1,1)">
            <h2>Get Involved</h2>
        </div>
        <div class="grid-content" id="get-involved-content"  onclick="popOut('get-involved',1,1)">
            <h2>Get Involved</h2>
            <p class="newsy">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus sapiente iusto dolore nihil. Iure ullam eaque temporibus ea expedita impedit atque, vitae velit voluptates tempore odio excepturi labore, modi reiciendis cumque id consectetur consequuntur sunt asperiores itaque. Sunt atque, a incidunt id neque non doloremque veritatis! Nam delectus dolorem pariatur.
            </p>
        </div>
    </div>
    <div class="grid-item grid-item-5" id="market">
        <div class="grid-preview" id="market-preview"  onclick="popOut('market',1,1)">
            <h2>Market</h2>
        </div>
        <div class="grid-content" id="market-content"  onclick="popOut('market',1,1)">
            <h2>Market</h2>
            <p class="newsy">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus sapiente iusto dolore nihil. Iure ullam eaque temporibus ea expedita impedit atque, vitae velit voluptates tempore odio excepturi labore, modi reiciendis cumque id consectetur consequuntur sunt asperiores itaque. Sunt atque, a incidunt id neque non doloremque veritatis! Nam delectus dolorem pariatur.
            </p>
        </div>
    </div>
</div>

<!-- the div below (popout-container) must be left COMPLETELY empty!!!-->
<div class="popout-container" id="popout-container"></div>

<script>resize();</script>

<?php get_footer(); ?>