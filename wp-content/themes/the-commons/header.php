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
        <p class="header-item-1" style="color: #f2f3ed">
            <?php echo date("l F j, Y")?>
        </p>
        <div class="header-item-2">
            <a href="<?php echo get_bloginfo('url'); ?>" title="The Commons" style="text-decoration:none;">
                <div class="title">The Commons</div>
            </a>
        </div>
        <p class="header-item-3" style="color: #f2f3ed; font-style: italic;">By the People, For the People.</p>
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
        <div class="title-mobile">The Commons</div>
    </a>
    <div class="hamburger-menu" >
        <input id="menu__toggle" type="checkbox" />
        <label class="menu__btn" for="menu__toggle">
        <span></span>
        </label>

        <ul class="menu__box">
            <li class="menu__item" onclick="menuHandler('shop')">Shop</li>
            <li class="menu__item" onclick="menuHandler('features')">Video</li>
            <li class="menu__item" onclick="menuHandler('blog')">Articles</li>
            <li class="menu__item" onclick="menuHandler('events')">Events</li>
            <li class="menu__item"><a class ="menu__item" style="padding: 0px;" href="<?php echo get_bloginfo('url'); ?>/subscriptions">Subscribe</a></li>
            <li class="menu__item"><a class ="menu__item" href="<?php echo get_bloginfo('url'); ?>/my-account">
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