<?php
/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$id = 'caption-' . $block['id'];

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'caption-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$text             = get_field( 'caption' ) ?: '';
$label           = get_field( 'caption-label' ) ?: '';
$image_id            = get_field( 'figure' ) ?: "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="; //inserts a blank 26 byte gif if no image specified

?>
<div class="<?php echo esc_attr( $class_name )?>" id="anchor-<?php echo $id?>">
    <div class="caption-container" id="<?php echo $id?>">
        <img class="caption-image" src="<?php echo esc_html( $image_id ); ?>" width="15%" height="auto">?>
        <div class="caption-label"><?php echo esc_html( $label ); ?></div>
        <div class="caption-text"><?php echo esc_html( $text ); ?></div>
    </div>
</div>