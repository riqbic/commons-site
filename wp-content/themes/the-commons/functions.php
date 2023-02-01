<?php
add_action('wp_enqueue_scripts','commons_theme_assets');
function commons_theme_assets() {
    $version = '1.0'; //For cache busting css/js
    //Theme CSS
    wp_enqueue_style( 'style', get_stylesheet_uri(), false, $version, 'all' );
    //Theme JS
	wp_enqueue_script( 'jquery-scripts', get_template_directory_uri().'/js/commons-js-main.js', array(), $version, true );
}