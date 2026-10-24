<?php
/**
 * The template for displaying comments
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ( '1' === $comments_number ) {
                printf( _x( 'One Response to &ldquo;%s&rdquo;', 'comments title', 'textdomain' ), get_the_title() );
            } else {
                printf(
                    _nx(
                        '%1$s Response to &ldquo;%2$s&rdquo;',
                        '%1$s Responses to &ldquo;%2$s&rdquo;',
                        $comments_number,
                        'comments title',
                        'textdomain'
                    ),
                    number_format_i18n( $comments_number ),
                    get_the_title()
                );
            }
            ?>
        </h2>

        <ol class="commentlist">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 0,
                'callback'    => 'custom_comment_format',
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation();
        
        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
            <p class="no-comments"><?php _e( 'Comments are closed.', 'textdomain' ); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php comment_form(); ?>

</div>
