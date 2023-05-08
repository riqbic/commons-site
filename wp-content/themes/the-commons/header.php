<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>The Commons Parkour</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="newsy-header hidden-mobile">
    <div class="header-container">
        <p class="header-item-1" style="color: white">
            <?php date_default_timezone_set('America/New York'); echo date("l F j, Y");?>
        </p>
        <div class="header-item-2">
            <a href="<?php echo get_bloginfo('url'); ?>" title="The Commons" style="text-decoration:none;">
                <h2 class="title">The Commons</h2>
            </a>
        </div>
        <p class="header-item-3" style="color: white; font-style: italic;">By the People, For the People.</p>
    </div>
</div>

<div class="header-spacer hidden-mobile"></div>

<div class="header-menu hidden-mobile">
    <div class="menu-container">
        <ul class="menu">
        <li class="menu-item" onclick="menuHandler('shop')">Shop</li>
        <li class="menu-item" onclick="menuHandler('features')">Video</li>
        <li class="menu-item" onclick="menuHandler('blog')">Articles</li>
        <li class="menu-item" onclick="menuHandler('events')">Events</li>
        <li class="menu-item"><a class ="menu-item" href="<?php echo get_bloginfo('url'); ?>/subscriptions">Subscribe</a></li>
        <li class="menu-item"><a class ="menu-item" href="<?php echo get_bloginfo('url'); ?>/my-account">
            <?php if(is_user_logged_in()) {
                echo 'My Account';
                } else {
                echo 'Login/Register';
            }?>
        </a></li>
        </ul>
    </div>
</div>

<div class="newsy-header-mobile hidden-desktop">
    <a id="title-link-mobile" href="<?php echo get_bloginfo('url'); ?>" title="The Commons" style="text-decoration:none;">
        <h2 class="title-mobile">The Commons</h2>
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

        <ul class="menu-box">
            <li class="menu-item-mobile" onclick="menuHandler('shop')"><div class="menu-text-mobile">Shop</div></li>
            <li class="menu-item-mobile" onclick="menuHandler('features')"><div class="menu-text-mobile">Video</div></li>
            <li class="menu-item-mobile" onclick="menuHandler('blog')"><div class="menu-text-mobile">Articles</div></li>
            <li class="menu-item-mobile" onclick="menuHandler('events')"><div class="menu-text-mobile">Events</div></li>
            <li class="menu-item-mobile"><a class ="menu-text-mobile" href="<?php echo get_bloginfo('url'); ?>/subscriptions">Subscribe</a></li>
            <li class="menu-item-mobile"><a class ="menu-text-mobile" href="<?php echo get_bloginfo('url'); ?>/my-account">
            <?php if(is_user_logged_in()) {
                echo 'My Account';
                } else {
                echo 'Login/Register';
            }?>
        </a></li>
        </ul>
    </div>
</div>

<div class="header-spacer-mobile hidden-desktop"></div>