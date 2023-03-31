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
    <svg width="100%" height="100%">
        <rect width="100%" height="1" y="50%"
        style="fill:rgb(0,0,0);stroke-width:1;stroke:rgb(0,0,0)" />
        <rect width="1" height="25" x="100%" y="50%"
        style="fill:rgb(0,0,0);stroke-width:1;stroke:rgb(0,0,0);position:relative;transform: translate(-10px,-20px);" />
    </svg>
    <div class="header-item-2">
        <a href="<?php echo get_bloginfo('url'); ?>" title="The Commons" style="text-decoration:none;">
            <div class="title">The Commons</div>
        </a>
    </div>
    <svg width="100%" height="100%">
        <rect width="100%" height="1" y="50%"
        style="fill:rgb(0,0,0);stroke-width:1;stroke:rgb(0,0,0)" />
        <rect width="1" height="40" x="0" y="50%"
        style="fill:rgb(0,0,0);stroke-width:1;stroke:rgb(0,0,0);position:relative;transform: translate(40px,-5px);" />
    </svg>
</div>

<div class="header-spacer hidden-mobile"></div>

<div class="header-menu hidden-mobile">
    <div class="menu-container">
        <ul class="menu">
        <li class="menu-item"><a class ="menu-item" href="https://thecommons.boston/">Home</a></li>
        <li class="menu-item"><a class ="menu-item" href="https://thecommons.boston/?page_id=8">Market</a></li>
        <li class="menu-item"><a class ="menu-item" href="https://thecommons.boston/?pop=features">Features</a></li>
        <li class="menu-item"><a class ="menu-item" href="https://thecommons.boston/?pop=blog">Blog</a></li>
        <li class="menu-item"><a class ="menu-item" href="https://thecommons.boston/?pop=events">Events</a></li>
        <li class="menu-item"><a class ="menu-item" href="https://thecommons.boston/?page_id=56">Subscribe</a></li>
        <li class="menu-spacer"></li>
        <li class="account menu-item"><a class ="menu-item" href="https://thecommons.boston/?page_id=11">My Account</a></li>
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
            <li><a class ="menu__item" href="https://thecommons.boston/">Home</a></li>
            <li><a class ="menu__item" href="https://thecommons.boston/?pop=shop">Market</a></li>
            <li><a class ="menu__item" href="https://thecommons.boston/?pop=features">Features</a></li>
            <li><a class ="menu__item" href="https://thecommons.boston/?pop=blog">Blog</a></li>
            <li><a class ="menu__item" href="https://thecommons.boston/?pop=events">Events</a></li>
            <li><a class ="menu__item" href="https://thecommons.boston/?page_id=56">
                <?php if(is_user_logged_in()) {
                echo 'check';
                } else {
                echo 'Login/Register';
                }?>
            </a></li>
        </ul>
    </div>
    <a class="account-icon" href="https://thecommons.boston/?page_id=11">
        <img src="account_icon.png" alt="My Account" style="width:42px;height:42px;">
    </a>
</div>

<div class="header-spacer-mobile hidden-desktop"></div>