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
$text             = get_field( 'caption' ) ?: 'Your caption here...';
$label           = get_field( 'caption-label' ) ?: 'Caption Label';
$image_id            = get_field( 'figure' ) ?: 295;

// Build a valid style attribute for background and text colors.
$styles = array( 'background-color: ' . $background_color, 'color: ' . $text_color );
$style  = implode( '; ', $styles );

?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>" style="<?php echo esc_attr( $style ); ?>">
        <div class="caption-text"><?php echo esc_html( $text ); ?></div>
        <div class="caption-label"><?php echo esc_html( $label ); ?></div>
        <img class="caption-image" src="<?php echo esc_html( $image_id ); ?>" >
</div>