<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-billing-fields">
    <div class="card mb-3">
        <div class="card-body">
        <?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

            <h5 class="card-title"><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h5>

            <?php else : ?>

            <h5 class="card-title"><?php esc_html_e( 'Billing details', 'woocommerce' ); ?></h5>

            <?php endif; ?>

            <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

            <div class="woocommerce-billing-fields__field-wrapper mb-3">
                <?php
                $fields = $checkout->get_checkout_fields( 'billing' );

                foreach ( $fields as $key => $field ) {
                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                }
                ?>
            </div>
            <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
        </div>
    </div>
</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
    <div class="woocommerce-account-fields">
        <?php if ( ! $checkout->is_registration_required() ) : ?>
        <div class="card mb-3">
            <div class="card-body">
                <p class="form-row form-row-wide create-account">
                    <div class="form-check mb-2">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox form-check-input" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" />
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox form-check-label">
                            <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
                        </label>
                    </div>
                </p>
            </div>
        </div>
        <?php endif; ?>

        <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

        <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="create-account mb-3">
                    <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                    <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                    <?php endforeach; ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <?php endif; ?>

        <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

    </div>
<?php endif; ?>