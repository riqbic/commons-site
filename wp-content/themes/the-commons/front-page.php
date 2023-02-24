<?php get_header(); ?>

<div class="newsy-container grid-off-mobile" id="newsy-container">
    <div class="grid-item grid-item-1" id="about-us">
        <div class="grid-content" id="about-us-content"  onclick="popOut('about-us',1,1)">
            <h2>About us</h2>
            <div class="about-us-flexbox">
                <div class="about-us-flex-item">
                    <p class="newsy">
                        Born in Boston, The Commons is a parkour org that invests in North American parkour culture. Through hosting events, uplifting local communities, and providing opportunities for athletes and artists, we are working to put American parkour on the map.
                    </p>
                </div>
                <div class="about-us-content-full about-us-flex-item">
                    <p class="newsy">
                        Being a community project means that anybody and everybody can contribute to the cause, but here are some of the people that keep the wheels turning:
                    </p>
                </div>
                <div class="about-us-content-full about-us-flex-item">
                    <p class="newsy">
                        Everybody loves David. David Ehrlich is the founder, heart, and soul of The Commons. He preaches radical inclusivity, and has a special gift for bringing people together. As our primary community and event coordinator, David’s job is to create community events, do outreach, and make sure that The Commons provides safe and fun spaces for all.
                    </p>
                </div>
                <div class="about-us-content-full about-us-flex-item">
                    <p class="newsy">
                        Joining The Commons soon after it’s inception; Alec is the guy who makes things happen. He’s the creative director by day, web developer by night, park builder by the next day, and event coordinator after that… Alec seems to be everywhere all at once.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-item grid-item-2" id="features">
        <div class="grid-content" id="features-content"  onclick="popOut('features',1,1)">
            <h2>Features</h2>
            <img src="<?php echo get_template_directory_uri(); ?>/img/group_pallets_crop.png" alt="group pallets" id="group-pallets" width="300" height="200">
            <p class="newsy">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum nostrum in quis debitis qui unde iusto adipisci corrupti animi! Molestiae porro iusto sapiente, nisi inventore illum sint at itaque quae, nemo aut enim eius eaque, fugiat explicabo omnis perferendis? Quo placeat corporis laudantium magni beatae earum dolorem iste sequi velit.
            </p>
        </div>
    </div>
    <div class="grid-item grid-item-3" id="blog">
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
        <div class="grid-content" id="get-involved-content"  onclick="popOut('get-involved',1,1)">
            <h2>Get Involved</h2>
            <p class="newsy">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus sapiente iusto dolore nihil. Iure ullam eaque temporibus ea expedita impedit atque, vitae velit voluptates tempore odio excepturi labore, modi reiciendis cumque id consectetur consequuntur sunt asperiores itaque. Sunt atque, a incidunt id neque non doloremque veritatis! Nam delectus dolorem pariatur.
            </p>
        </div>
    </div>
    <div class="grid-item grid-item-5" id="market">
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

<?php get_footer(); ?>