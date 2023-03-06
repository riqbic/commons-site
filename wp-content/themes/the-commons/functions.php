<?php
add_action('wp_enqueue_scripts','commons_theme_assets');
function commons_theme_assets() {
    $version = '1.1'; //For cache busting css/js
    //Theme CSS
    wp_enqueue_style( 'style', get_stylesheet_uri(), false, $version, 'all' );
    //Theme JS
	wp_enqueue_script( 'jquery-scripts', get_template_directory_uri().'/js/commons-js-main.js', array(), $version, true );
    
    //Home js
    wp_register_script( 'commons-home', get_template_directory_uri().'/js/home.js', array('jquery'), $version, true );
    if(is_home() || is_front_page()) {
        wp_enqueue_script( 'commons-home' );
        $localized = array( 
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'blog_url' => get_bloginfo('url'),
        );
        wp_localize_script( 'commons-home', 'home_js', $localized );
    }
}

add_action( 'wp_ajax_nopriv_load_commons_blog_post', 'load_commons_blog_post' );
add_action( 'wp_ajax_load_commons_blog_post', 'load_commons_blog_post' );
function load_commons_blog_post($paged = NULL) {
    $post_id = $_GET['post_id'];
    $title = get_the_title($post_id);
    $content = apply_filters('the_content', get_post_field('post_content', $post_id));
    echo '<h1>'.$title.'</h1><div class="post-conent">'.$content.'</div>';
    wp_die();
} 
?>