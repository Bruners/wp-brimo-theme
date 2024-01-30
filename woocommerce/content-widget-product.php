<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
    return;
}

?>
<div class="col-sm-12 col-md-6 col-md-4 col-lg-3 mb-4">

    <div class="card mb-3">

    <?php
        //$image_src = brimo_woocommerce_get_product_thumbnail(); 
        //$image_src = wp_get_attachment_image_src( $product->get_image_id(), 'woocommerce-widget-thumb' ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>
        <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?php echo esc_url( $product->get_permalink() ); ?>">
            <?php brimo_woocommerce_get_product_thumbnail(); ?>
            <div class="card-body">
                <?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>
                <a class="card-title text-decoration-none" href="<?php echo esc_url( $product->get_permalink() ); ?>">
                    <h6 class="product-title"><?php echo wp_kses_post( $product->get_name() ); ?></h6>
                </a>
                <div class="card-text">
                <?php if ( ! empty( $show_rating ) ) : ?>
                    <?php echo wc_get_rating_html( $product->get_average_rating() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php endif; ?>
                </div>
                <div class="card-text">
                    <?php echo $product->get_price_html(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
                <div class="card-text mt-3">
                    <a class="btn btn-outline-brimo" href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->add_to_cart_text() ) ?></a>
                </div>
                <?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>

            </div>
        </a>
    </div>

</div>