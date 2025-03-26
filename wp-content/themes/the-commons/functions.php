<?php
add_action('wp_enqueue_scripts','commons_theme_assets');
function commons_theme_assets() {
    $version = '1.55'; //For cache busting css/js
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
            'blog_url' => home_url('/'),
        );
        wp_localize_script( 'commons-home', 'home_js', $localized );
    }
    if(is_home() || is_front_page() || is_single()) {
        wp_enqueue_script( 'comment-reply' );
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
    $the_content = apply_filters('the_content', get_post_field('post_content', $post_id));

    //only display author and date for articles
    /*if( in_category(31, $post_id) ){
        $content = '<h3>'.$title.'</h3>'.'<div class="post-content">'.$content.'</div>'.'<div class="post-author italic">'.$author_name.'</div>'.'<div class="post-date italic">'.$date.'</div>';
    }
    else{
        $content = '<h3>'.$title.'</h3>'.'</div>'.'<div class="post-content">'.$content.'</div>';
    }*/
    
    //Start capturing output using output buffer. The comments template doesn't have a get_X equivalent so we output it and capture the output instead
    ob_start();
    $post_args = array(
        'p'	=> $post_id,
        'post_type'	=> 'post',
        'post_status' => 'publish',
    );
    $posts_query = new WP_Query( $post_args );
    if( $posts_query->have_posts() ) {
        while($posts_query->have_posts() ) {
            $posts_query->the_post(); 
            echo '<h3>'.$title.'</h3>';
            echo '<div class="post-content">'.$the_content.'</div>';
            if( in_category(31, $post_id) ){
                echo '<div class="post-author italic">'.$author_name.'</div>';
                echo '<div class="post-date italic">'.$date.'</div>';
            }
            //Require comments, which can only be used on single and page tpl, https://stackoverflow.com/questions/4299093/wordpress-comments-template-not-working-on-ajax-call
            global $withcomments;
            $withcomments = true; 
            echo comments_template('',true);
        }
    } 
    //Reset query
    wp_reset_query();
  
    //Capture buffered content
    $content = ob_get_clean();
    
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
        'post_status'     => 'publish',
        'cat'             => 31  );
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

 //FIVERR HERE
add_action('woocommerce_thankyou', 'custom_thankyou_page', 5);
function custom_thankyou_page($order_id) {
    // Get the order object
    $order = wc_get_order($order_id);

    // Initialize an empty array to store product links
    $product_links = array();

    // Loop through order items
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
        $checkout_links = get_field('checkout_links', $product_id);

        if ($checkout_links) {
            foreach ($checkout_links as $link) {
                $title = esc_html($link['title']);
                $link_url = esc_url($link['link']);
                $product_links[] = '<a href="' . $link_url . '" title="' . $title . '">' . $title . '</a>';
                $product_urls[] = $link_url;
            }
        }
    }

    // Output the HTML for product links and the "Watch Now" button
    if (!empty($product_links)) {
        echo '<p class="thank-you-message-text">Your purchase gives you access to ' . implode(', ', $product_links) . '.</p>';
        echo '<button class="watch-now-button"><a href="' . $product_urls[0] . '" title="Watch Now">Watch Now</a></button>';
    }
}

//auto complete virtual and downloadable orders
add_action('woocommerce_thankyou', 'wpd_autocomplete_virtual_orders', 10, 1 );
function wpd_autocomplete_virtual_orders( $order_id ) {
  
    if( ! $order_id ) return;
  
    // Get order
    $order = wc_get_order( $order_id );
  
    // get order items = each product in the order
    $items = $order->get_items();
  
    // Set variable
    $only_virtual = true;
  
    foreach ( $items as $item ) {
          
        // Get product object
        if ( isset($item['variation_id']) && ! empty($item['variation_id']) ) {
 
            $product = wc_get_product( $item['variation_id'] );
 
        } else {
 
            $product = wc_get_product( $item['product_id'] );
 
        }
 
        // Safety check
        if ( ! is_object($product) ) {
 
            return false;
 
        }
                 
        // Is virtual
        $is_virtual = $product->is_virtual();
  
        // Is_downloadable
        $is_downloadable = $product->is_downloadable();
  
        if ( ! $is_virtual && ! $is_downloadable  ) {
  
            $only_virtual = false;
  
        }
  
    }
  
    // true
    if ( $only_virtual ) {
  
        $order->update_status( 'completed' );
  
    }
 
}

/** Change comments heading */
add_filter( 'comment_form_defaults', 'commons_comment_form_title_reply' );
function commons_comment_form_title_reply( $defaults ) {  
    $defaults['title_reply'] = __( 'Leave a note!' );  
    return $defaults;
}

/** Ajax for comments, adapted from https://rudrastyh.com/wordpress/ajax-comments.html */
add_action( 'wp_ajax_commons_ajaxcomments', 'commons_submit_ajax_comment' ); // wp_ajax_{action} for registered user
add_action( 'wp_ajax_nopriv_commons_ajaxcomments', 'commons_submit_ajax_comment' ); // wp_ajax_nopriv_{action} for not registered users
function commons_submit_ajax_comment(){
	/*
	 * Wow, this cool function appeared in WordPress 4.4.0, before that my code was muuuuch mooore longer
	 *
	 * @since 4.4.0
	 */
	$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
	if ( is_wp_error( $comment ) ) {
		$error_data = intval( $comment->get_error_data() );
		if ( ! empty( $error_data ) ) {
			wp_die( '<p>' . $comment->get_error_message() . '</p>', __( 'Comment Submission Failure' ), array( 'response' => $error_data, 'back_link' => true ) );
		} else {
			wp_die( 'Unknown error' );
		}
	}
 
	/*
	 * Set Cookies
	 */
	$user = wp_get_current_user();
	do_action('set_comment_cookies', $comment, $user);
 
	/*
	 * If you do not like this loop, pass the comment depth from JavaScript code
	 */
	$comment_depth = 1;
	$comment_parent = $comment->comment_parent;
	while( $comment_parent ){
		$comment_depth++;
		$parent_comment = get_comment( $comment_parent );
		$comment_parent = $parent_comment->comment_parent;
	}
 
 	/*
 	 * Set the globals, so our comment functions below will work correctly
 	 */
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $comment_depth;
	
	/*
	 * Here is the comment template, you can configure it for your website
	 * or you can try to find a ready function in your theme files
	 */
	$comment_html = '<li ' . comment_class('', null, null, false ) . ' id="comment-' . get_comment_ID() . '">
		<article class="comment-body" id="div-comment-' . get_comment_ID() . '">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					' . get_avatar( $comment, 100 ) . '
					<b class="fn">' . get_comment_author_link() . '</b> <span class="says">says:</span>
				</div>
				<div class="comment-metadata">
					<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">' . sprintf('%1$s at %2$s', get_comment_date(),  get_comment_time() ) . '</a>';
					
					if( $edit_link = get_edit_comment_link() )
						$comment_html .= '<span class="edit-link"><a class="comment-edit-link" href="' . $edit_link . '">Edit</a></span>';
					
				$comment_html .= '</div>';
				if ( $comment->comment_approved == '0' )
					$comment_html .= '<p class="comment-awaiting-moderation">Your comment is awaiting moderation.</p>';

			$comment_html .= '</footer>
			<div class="comment-content">' . apply_filters( 'comment_text', get_comment_text( $comment ), $comment ) . '</div>
		</article>
	</li>';
	echo $comment_html;

	die();
	
}

add_filter('comment_form_logged_in','commons_comment_form_logged_in');
function commons_comment_form_logged_in($args_logged_in) {
    $args_logged_in = 'Gregg';
    global $current_user;
    wp_get_current_user();
    $args_logged_in = 'Logged in as '. $current_user->display_name.'.';
    $args_logged_in .= ' <a href="'.wp_logout_url().'">Log out?</a>';
    return $args_logged_in;
}

//facebook feature image set

// function add_open_graph_tags() {
//     echo '<meta property="og:title" content="' . get_the_title() . '" />' . "\n";
//     echo '<meta property="og:description" content="' . get_the_excerpt() . '" />' . "\n";

//     // Check if a featured image is set, otherwise, use the default image
//     if (has_post_thumbnail()) {
//         $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
//         echo '<meta property="og:image" content="' . esc_url($thumbnail[0]) . '" />' . "\n";
//     } else {
//         // Use your default image URL
//         echo '<meta property="og:image" content="https://thecommons.boston/wp-content/uploads/2023/06/JOD_group_pallets-scaled-e1686195668487.jpg" />' . "\n";
//     }
// }

// add_action('wp_head', 'add_open_graph_tags');

function add_open_graph_tags() {
    echo '<meta property="og:title" content="The Commons" />' . "\n";
    echo '<meta property="og:description" content="By the People, for the People." />' . "\n";
    echo '<meta property="og:image" content="https://thecommons.boston/wp-content/uploads/2023/06/JOD_group_pallets-scaled-e1686195668487.jpg" />' . "\n";
}
add_action('wp_head', 'add_open_graph_tags');

add_action( 'init', 'wk_custom_endpoint' );
function wk_custom_endpoint() {
    add_rewrite_endpoint( 'my-videos', EP_ROOT | EP_PAGES );
}

add_action( "woocommerce_account_my-videos_endpoint", 'my_courses_tab_content');
function my_courses_tab_content() {
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $customer_orders = wc_get_orders(
        array(
            'type'        => 'shop_order',
            'limit'       => - 1,
            'customer_id' => $user_id,
            'status'      => 'completed',
        )
    );
    if(empty($customer_orders)) {
        echo 'You have not purchased any videos.';
    } else {
        echo '<ul class="my-videos-list">';
        $purchased_products = array();
        foreach($customer_orders as $order) {
            foreach ( $order->get_items() as $item_id => $item ) {
                $product_id = $item->get_product_id();
                if(!in_array($product_id,$purchased_products)) {
                    $purchased_products[] = $product_id;
                    $checkout_links = get_field('checkout_links', $product_id);
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
                    if ($checkout_links) {
                        foreach ($checkout_links as $link) {
                            $title = esc_html($link['title']);
                            $link_url = esc_url($link['link']);
                            echo '<li class="my-videos-item"><a href="' . $link_url . '" title="' . $title . '">' . '<img src="' . $image[0] . '">' . '</a></li>';
                        }
                    }
                }
            }
        }
        echo '</ul>';
    }
}


add_filter( 'woocommerce_account_menu_items', 'wk_new_menu_items' );
function wk_new_menu_items( $items ) {
    $items[ 'my-videos' ] = __( 'My Videos', 'webkul' );
    return $items;
}

add_action('woocommerce_before_cart', 'common_open_grid');
add_action('woocommerce_checkout_before_customer_details','common_open_grid', 10);
function common_open_grid() {
    echo '<div class="common-2-col-grid">';
}

add_action('woocommerce_checkout_before_customer_details','common_open_group_div', 11);
add_action('woocommerce_checkout_before_order_review_heading','common_open_group_div', 11);
add_action('woocommerce_checkout_before_order_review_heading','common_open_group_div', 11);
function common_open_group_div() {
    echo '<div>';
}

add_action('woocommerce_after_cart', 'common_close_grid');
add_action('woocommerce_after_checkout_form','common_close_grid');
add_action('woocommerce_checkout_after_customer_details','common_close_grid', 30);
add_action('woocommerce_checkout_after_order_review','common_close_grid');
function common_close_grid() {
    echo '</div>';
}
?>