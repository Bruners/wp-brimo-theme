<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="shop_table woocommerce-checkout-review-order-table row">
	<div class="col-12 col-md-8">
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title"><?php esc_html_e( 'Product', 'woocommerce' ); ?></h5>
				<ul class="list-group mb-3">
				<?php
				do_action( 'woocommerce_review_order_before_cart_contents' );

				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
						<li class="list-group-item d-flex justify-content-between lh-sm <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							<div>
	          					<h6 class="my-0 product-name"><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h6>
	          					<small class="text-muted"><?php echo $cart_item['data']->get_short_description(); ?></small>
	        				</div>
	        				<span class="product-total text-muted"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						</li>
			<?php
					}
				}

				do_action( 'woocommerce_review_order_after_cart_contents' );
			?>
				</ul>
				<?php
					wc_get_cart_url();
				?>
				<a href="<?php echo $cart_url; ?>" class="btn btn-outline-brimo"><?php echo esc_html_e( 'Til handlekurv', 'brimo' ); ?></a>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="card mb-3">
			<div class="card-body">

				<h5 class="card-title"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></h5>
				<div class="mb-3 card-text border-bottom">
                    <span class="float-start text-muted"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
                    <span class="float-end font-weight-bold"><?php wc_cart_totals_subtotal_html(); ?></span>
                </div>

			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<div class="mb-3 card-text border-bottom cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<span class="float-start text-muted"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
					<span class="float-end font-weight-bold"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
				</div>
			<?php endforeach; ?>
			<div class="pt-2 border-bottom mb-3">

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
				
				<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
				
				<?php wc_cart_totals_shipping_html(); ?>
				

				<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

			<?php endif; ?>
			</div>
			<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<div class="mb-3 card-text border-bottom">
					<span class="float-start text-muted"><?php echo esc_html( $fee->name ); ?></span>
					<span class="float-end font-weight-bold"><?php wc_cart_totals_fee_html( $fee ); ?></span>
				</div>
			<?php endforeach; ?>

			<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
				<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
						<div class="mb-3 card-text border-bottom tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
							<span class="float-start text-muted"><?php echo esc_html( $tax->label ); ?></span>
							<span class="float-end font-weight-bold"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="mb-3 card-text border-bottom tax-total">
						<span class="float-start text-muted"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
						<span class="float-end font-weight-bold"><?php wc_cart_totals_taxes_total_html(); ?></span>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			</div> <!-- card-body -->

			<div class="card-footer">

				<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

				<div class="order-total">
					<span class="float-start text-muted"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
					<span class="float-end font-weight-bold"><?php wc_cart_totals_order_total_html(); ?></span>
				</div>

				<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

			</div> <!-- card-footer -->
		</div> <!-- card -->
	</div>
</div>