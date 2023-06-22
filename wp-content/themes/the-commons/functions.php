<?php
add_action('wp_enqueue_scripts','commons_theme_assets');
function commons_theme_assets() {
    $version = '1.2'; //For cache busting css/js
    //Theme CSS
    wp_enqueue_style( 'style', get_stylesheet_uri(), false, $version, 'all' );
    //Theme JS
	wp_enqueue_script( 'commons-main', get_template_directory_uri().'/js/commons-js-main.js', array(), $version, true );
    $is_home = false;
    if(is_home() || is_front_page()) {
        $is_home = true;
    }
    $commons_main_args = array( 
        'blog_url' => home_url('/'),
        'current_url' => get_permalink(),
        'is_home' => $is_home
    );
    wp_localize_script( 'commons-main', 'commons_main', $commons_main_args );
    
    //Home js
    wp_register_script( 'commons-home', get_template_directory_uri().'/js/home.js', array('jquery'), $version, true );
    if(is_home() || is_front_page()) {
        wp_enqueue_script( 'commons-home' );
        $localized = array( 
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        );
        wp_localize_script( 'commons-home', 'home_js', $localized );
    }

    //Comic
    wp_register_script( 'commons-comic', get_template_directory_uri().'/js/commons-comic.js', array('jquery'), $version, true );

    //Slick slider
    wp_register_script( 'slick-js', get_template_directory_uri().'/includes/slick/slick.js', array('jquery'), '1.8.1', true );
    wp_register_style( 'slick-css', get_template_directory_uri().'/includes/slick/slick.css', array(), '1.8.1' );
}

/**
 * Remove related products output
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'wp_ajax_nopriv_load_commons_blog_post', 'load_commons_blog_post' );
add_action( 'wp_ajax_load_commons_blog_post', 'load_commons_blog_post' );
function load_commons_blog_post($paged = NULL) {
    $post_id = $_GET['post_id'];
    $title = get_the_title($post_id);
    $author_id = get_post_field( 'post_author', $post_id );
    $author_name = get_the_author_meta( 'display_name', $author_id );
    $date = get_the_date("l F j, Y", $post_id);
    $content = apply_filters('the_content', get_post_field('post_content', $post_id));

    //only display author and date for articles
    if( in_category(31, $post_id) ){
        $content = '<h3>'.$title.'</h3>'.'<div class="post-author">'.$author_name.'</div>'.'<div class="post-date">'.$date.'</div>'.'<div class="post-content">'.$content.'</div>';
    }
    else{
        $content = '<h3>'.$title.'</h3>'.'</div>'.'<div class="post-content">'.$content.'</div>';
    }
    echo json_encode(
        array(
            'post_content'  =>  $content,
            'post_title'    =>  $title,
            'post_author'   =>  $author_name,
            'post_date'     =>  $date
        )
    );
    wp_die();
}

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
    register_block_type( __DIR__ . '/blocks/blog-caption' );
}

//Remove admin bar for all users
add_filter('show_admin_bar', '__return_false');

//Add responsive videos in gutenberg
add_theme_support( 'responsive-embeds' );

//Add post thumbnails
add_theme_support( 'post-thumbnails' );

//Add ACF Options page 
if(function_exists('get_field')) {
    require( get_template_directory() .'/includes/acf.php' );
}

function get_latest_post_link(){
    global $post;
    $placeholder = $post;
    $args = array(
        'numberposts'     => 1,
        'offset'          => 0,
        'orderby'         => 'post_date',
        'order'           => 'DESC',
        'post_status'     => 'publish'
        'cat'        => '31'  );
    $sorted_posts = get_posts( $args );
    $permalink = get_permalink($sorted_posts[0]->ID);
    $post = $placeholder;
    return $permalink;
}

//Add blocks category to Gutenberg
//Traditionally, you'd specify a priority like 10,20,30 but Genesis uses PHP_INT_MAX so we're using that
//If you want to put it below Genesis blocks, just change it to 99 or something
add_filter( 'block_categories_all','tcb_block_categories',PHP_INT_MAX);
function tcb_block_categories( $categories ) {
    //Create a new array for the category. 
    //We could append to the existing $categories array by entering $categories[] = array... but using array merge will make this the first category in the block selector, ie at the top
	$tcb_blocks[] = array(
		'slug'  => 'tcb-blocks',
		'title' => 'The Commons Boston'
	);
    $categories = array_merge($tcb_blocks,$categories);

	return $categories;
}

/**
 * Filter the default woocommerce memberships message
 */
function cb_memberships_thank_you_override(){
	//Change the message
    /*$thank_you_message = "My custom thank you message here." ;
	return $thank_you_message;*/
    //Stop the message entirely
    return false;
}
add_filter( 'woocommerce_memberships_thank_you_message', 'cb_memberships_thank_you_override' );

/**
 * Add extra links defined in the products
 */
add_filter('woocommerce_thankyou_order_received_text','cb_thank_you_product_links',10,2);
function cb_thank_you_product_links( $thank_you_message, $order ) {
    //If you want to change the message entirely, uncomment the next line...
    //$thank_you_message = 'Thanks for purchasing!';

    //Make sure acf is active
    if(function_exists('get_field')) {
        // Get and Loop Over Order Items
        foreach ( $order->get_items() as $item_id => $item ) {
            $product_id = $item->get_product_id();
            if(have_rows('checkout_links',$product_id)) {
                $thank_you_message .= ' Your purchase gives you access to ';
                while(have_rows('checkout_links',$product_id)) {
                    the_row();
                    $link_id = get_sub_field('link');
                    //Open to single post
                    $thank_you_message .= '<a href="'.get_permalink( $link_id ).'" title="'.get_the_title($link_id).'">'.get_the_title($link_id).'</a>';
                    //Open to popup 
                    //$thank_you_message .= '<a href="'.get_bloginfo('url').'?pop=features&post_id='.$link_id.'" title="'.get_the_title($link_id).'">'.get_the_title($link_id).'</a>';
                    $thank_you_message .= ', ';
                }
                $thank_you_message = substr($thank_you_message, 0, -2);
                $thank_you_message .= '.';
            }
        }
    }
    return $thank_you_message;
}
?>