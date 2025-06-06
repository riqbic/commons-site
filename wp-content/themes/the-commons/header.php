<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-C92R5GZ5JV"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-C92R5GZ5JV');
    </script>
    <meta charset="UTF-8">
    <title>The Commons Parkour</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="tcb-content">
<div class="newsy-header hidden-mobile">
    <div class="header-container">
        <p class="header-item-1" style="color: white">
            <?php date_default_timezone_set('America/New York'); echo date("l F j, Y");?>
        </p>
        <div class="header-item-2">
            <a href="<?php echo get_bloginfo('url'); ?>" title="The Commons" style="text-decoration:none;">
                <h1 class="site-title">The Commons</h1>
            </a>
        </div>
        <p class="header-item-3" style="color: white; font-style: italic;">By the People, For the People.</p>
    </div>
</div>

<!--<div class="header-spacer hidden-mobile"></div>-->

<div class="header-menu hidden-mobile">
    <div class="menu-container">
        <ul class="menu">
            <li class="menu-item"><a class ="menu-item" href="<?php echo get_bloginfo('url'); ?>/shop">Shop</a></li>
            <li class="menu-item"><a class ="menu-item" href="<?php echo get_bloginfo('url'); ?>/?pop=events&post_id=1">JOD 7</a></li>
            <li class="menu-item has-children" id="articles-menu-item">
                <a class="menu-item" href="<?php echo get_bloginfo('url'); ?>/articles/">Articles</a>
                <ul class="has-image-placeholder">
                    <li class="image-placeholder"></li>
                    <?php 
                    $post_args = array(
                        'posts_per_page'	=> 4,
                        'post_type'		=> 'post',
                        'post_status' => 'publish',
                        'category__in' => array(34,31)
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
                            <li class="pop-item blog-item blog-item-<?php echo $blog_item_count; ?> has-hover-thumbnail" data-id="<?php echo get_the_ID(); ?>" data-image="<?php echo get_the_post_thumbnail_url(); ?>">
                                <a href="<?php echo get_bloginfo('url'); ?>?pop=articles&post_id=<?php echo get_the_ID(); ?>" class="load-from-url" data-category="articles"><?php the_title(); ?></a>
                            </li>
                            <?php 
                        }
                    } 
                    wp_reset_query(); ?>
                    <li class="blog-item"><a class="posts-archive-text" href="<?php echo get_bloginfo('url'); ?>/articles/">+ archive +</a></li>
                   
                </ul>
            </li>
            <li class="menu-item has-children" id="videos-menu-item">
                <a class="menu-item" href="<?php echo get_bloginfo('url'); ?>/videos/">Video Features</a>
                <ul class="has-image-placeholder">
                    <li class="image-placeholder"></li>
                    <?php 
                    $post_args = array(
                        'posts_per_page'	=> 4,
                        'post_type'		=> 'post',
                        'post_status' => 'publish',
                        'category__in' => array(28)
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
                            <li class="pop-item blog-item blog-item-<?php echo $blog_item_count; ?> has-hover-thumbnail" data-id="<?php echo get_the_ID(); ?>" data-image="<?php echo get_the_post_thumbnail_url(); ?>">
                                <a href="<?php echo get_bloginfo('url'); ?>?pop=videos&post_id=<?php echo get_the_ID(); ?>" class="load-from-url" data-category="paid-videos"><?php the_title(); ?></a>
                            </li>
                            <?php 
                        }
                    } 
                    wp_reset_query(); ?>
                    <li class="blog-item"><a class="posts-archive-text " href="<?php echo get_bloginfo('url'); ?>/videos/">+ archive +</a></li>
                   
                    
                </ul>
            </li>
            <li class="menu-item"><a class ="menu-item" href="<?php echo get_bloginfo('url'); ?>/cart">Cart</a></li>
            <?php if(is_user_logged_in()) {
                echo '<li class="menu-item has children sub-right"><a href="'.get_bloginfo('url').'/my-account/my-videos/" class="menu-item">My Account</a>
                        <ul>
                            
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/my-videos/">My Videos</a>
                            </li>    
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/orders/">Orders</a>
                            </li>
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/edit-address/">Address</a>
                            </li>
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/payment-methods/">Payment Methods</a>
                            </li>
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/edit-account/">Account Details</a>
                            </li>
                            <li class="blog-item">
                                <a href="'.wp_logout_url(get_bloginfo('url')).'">Logout</a>
                            </li>

                        </ul>
                    </li>';
                } else {
                echo '<li class="menu-item"><a class ="menu-item" href="',get_bloginfo('url'),'/my-account">Login/Register</a></li>';
            }?>
        </ul>
    </div>
</div>

<div class="newsy-header-mobile hidden-desktop">
    <a id="title-link-mobile" href="<?php echo get_bloginfo('url'); ?>" title="The Commons" style="text-decoration:none;">
        <h2 class="site-title-mobile">The Commons</h2>
    </a>
    <div class="menu-extras-mobile">
        <p class="header-item-mobile-1" style="color: white; font-size: 12px;">
            <?php date_default_timezone_set('America/New York'); echo date("l F j, Y");?>
        </p>
        <p class="header-item-mobile-2" style="color: white; font-style: italic; font-size: 12px;">By the People, For the People.</p>
    </div>
    <div class="hamburger-menu" >
        <input id="menu-toggle" type="checkbox" />
        <label class="menu-btn" for="menu-toggle">
        <span></span>
        </label>

        <ul class="menu-mobile">
            <li class="menu-item-mobile"><a class ="menu-text-mobile" href="<?php echo get_bloginfo('url'); ?>/shop">Shop</a></li>
            <li class="menu-item-mobile"><a class ="menu-text-mobile" href="<?php echo get_bloginfo('url'); ?>/?pop=events&post_id=1">JOD 7</a></li>
            <li class="menu-item-mobile has-children" id="articles-menu-item-mobile"><div class="menu-text-mobile">Articles</div>
                <ul>
                <?php 
                $post_args = array(
                    'posts_per_page'	=> 9,
                    'post_type'		=> 'post',
                    'post_status' => 'publish',
                    'category__in' => array(34,31)
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
                        <li class="pop-item blog-item blog-item-<?php echo $blog_item_count; ?>" data-id="<?php echo get_the_ID(); ?>">
                        <a href="<?php echo get_bloginfo('url'); ?>?pop=articles&post_id=<?php echo get_the_ID(); ?>" class="load-from-url" data-category="articles"><?php the_title(); ?></a>
                        </li>
                        <?php 
                    }
                } 
                wp_reset_query(); ?>
                <li><a class="posts-archive-text" href="<?php echo get_bloginfo('url'); ?>/articles/">+ archive +</a></li>
                </ul>
            </li>
            <li class="menu-item-mobile has-children" id="videos-menu-item-mobile"><div class="menu-text-mobile">Video Features</div>
                <ul>
                <?php 
                $post_args = array(
                    'posts_per_page'	=> 9,
                    'post_type'		=> 'post',
                    'post_status' => 'publish',
                    'category__in' => array(28)
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
                        <li class="pop-item blog-item blog-item-<?php echo $blog_item_count; ?>" data-id="<?php echo get_the_ID(); ?>">
                            <a href="<?php echo get_bloginfo('url'); ?>?pop=videos&post_id=<?php echo get_the_ID(); ?>" class="load-from-url" data-category="paid-videos"><?php the_title(); ?></a>
                        </li>
                        <?php 
                    }
                } 
                wp_reset_query(); ?>
                <li><a class="posts-archive-text" href="<?php echo get_bloginfo('url'); ?>/videos/">+ archive +</a></li>
                </ul>
            </li>
            <!-- <li class="menu-item-mobile" onclick="menuHandler('events')"><div class="menu-text-mobile">Events</div></li> -->
            <li class="menu-item-mobile"><a class ="menu-text-mobile" href="<?php echo get_bloginfo('url'); ?>/cart">Cart</a></li>
            <?php if(is_user_logged_in()) {
                echo '<li class="menu-item-mobile has-children"><div class="menu-text-mobile">My Account</div>
                        <ul>
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/my-videos/">My Videos</a>
                            </li>  
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/orders/">Orders</a>
                            </li>
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/edit-address/">Address</a>
                            </li>
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/payment-methods/">Payment Methods</a>
                            </li>
                            <li class="blog-item">
                                <a href="'.get_bloginfo('url').'/my-account/edit-account/">Account Details</a>
                            </li>
                            <li class="blog-item">
                                <a href="',wp_logout_url(get_permalink()),'">Logout</a>
                            </li>
                        </ul>
                    </li>';
                } else {
                echo '<li class="menu-item-mobile"><a class="menu-text-mobile" href="',get_bloginfo('url'),'/my-account">Login/Register</a></li>';
            }?>
        </a></li>
        </ul>
    </div>
</div>

<div class="header-spacer-mobile hidden-desktop"></div>