<?php
/**
 * Theme options page
 */
if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'The Commons',
        'menu_title'    => 'The Commons',
        'menu_slug'     => 'commons-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'position' => 2,
    ));
    
    //Example subpage, for example a subpage just for the comic
    /*acf_add_options_sub_page(array(
        'page_title'    => 'Comic Settings',
        'menu_title'    => 'Comic Settings',
        'parent_slug'   => 'commons-settings',
    ));*/
}

/** 
 * ACF Local JSON
 * This saves the files locally so they can be easily migrated between environments and versioned in the repo
 */
add_filter('acf/settings/save_json', 'commons_acf_json_save_dir');
function commons_acf_json_save_dir( $path ) {
    $path = get_stylesheet_directory() . '/acf';
    return $path;
}

/**
 * Load Local ACF JSON
 */
add_filter('acf/settings/load_json', 'commons_acf_json_load_dir');
function commons_acf_json_load_dir( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/acf';
    return $paths;
}

/**
 * Get Commons Comic
 */
function commons_get_comic($is_slider = true) {
    $comic_html = '';
    $comic_class = '';
    $images = get_field('comic_strip_images','option');
    $size = 'thumbnail'; // (thumbnail, medium, large, full or custom size)
    if( $images ): 
        //Enable Slick Slider. To disable slider, change the default option in the function or change the argument in the commons_get_comic call
        if($is_slider) {
            wp_enqueue_style('slick-css');
            wp_enqueue_script('slick-js');
            wp_enqueue_script('commons-comic');
            $comic_class = ' is-slider';
        }
        $comic_html .= '<ul class="commons-comic'.$comic_class.'">';
            foreach( $images as $image_id ):
                $comic_html .= '<li>';
                    $comic_html .= wp_get_attachment_image( $image_id, $size );
                $comic_html .= '</li>';
            endforeach;
        $comic_html .= '</ul>';
    endif; 
    return $comic_html;
}