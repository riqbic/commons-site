<?php
/**
 * Product Box block template.
 *
 * Shows a product the same way the shop does (WooCommerce's product loop: image, title, price,
 * including the theme's hover image and sold-out treatment), then its short description and
 * the single-product add to cart form (with variation dropdowns for variable products).
 *
 * @param array $block      The block settings and attributes.
 * @param bool  $is_preview True when rendering the preview in the editor.
 */

$class_name = 'commons-product-box woocommerce';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $is_preview ) ) {
    $class_name .= ' is-preview';
}

$product_id   = get_field( 'product' );
$box_product  = ( $product_id && function_exists( 'wc_get_product' ) ) ? wc_get_product( $product_id ) : null;

if ( ! $box_product ) {
    if ( ! empty( $is_preview ) ) {
        echo '<div class="' . esc_attr( $class_name ) . ' is-empty">Choose a product in the block settings.</div>';
    }
    return;
}

// WooCommerce's templates read the global $post and $product, so point them at this product,
// then put back whatever was there before (the article being shown).
global $post;
$previous_post    = $post;
$previous_product = isset( $GLOBALS['product'] ) ? $GLOBALS['product'] : null;

$post = get_post( $box_product->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
setup_postdata( $post );
$GLOBALS['product'] = $box_product;

// Lets the theme's "SOLD OUT" price swap apply here too (see replace_price_with_sold_out in functions.php)
$GLOBALS['commons_rendering_product_box'] = true;

$short_description = $box_product->get_short_description();
?>
<div class="<?php echo esc_attr( $class_name ); ?>">
    <ul class="products columns-1">
        <li <?php wc_product_class( '', $box_product ); ?>>
            <?php
            // Same hooks as WooCommerce's content-product.php (the shop and home page product cards)
            do_action( 'woocommerce_before_shop_loop_item' );
            do_action( 'woocommerce_before_shop_loop_item_title' );
            do_action( 'woocommerce_shop_loop_item_title' );
            do_action( 'woocommerce_after_shop_loop_item_title' );
            do_action( 'woocommerce_after_shop_loop_item' );
            ?>
        </li>
    </ul>

    <?php if ( $short_description ) : ?>
        <div class="commons-product-box-description">
            <?php echo apply_filters( 'woocommerce_short_description', $short_description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
    <?php endif; ?>

    <div class="commons-product-box-cart">
        <?php woocommerce_template_single_add_to_cart(); ?>
    </div>
</div>
<?php
$GLOBALS['commons_rendering_product_box'] = false;

$post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
if ( $post ) {
    setup_postdata( $post );
}
$GLOBALS['product'] = $previous_product;
