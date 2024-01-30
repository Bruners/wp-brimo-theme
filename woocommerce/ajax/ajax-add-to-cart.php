<?php

/*
   https://aceplugins.com/ajax-add-to-cart-button-on-the-product-page-woocommerce/
*/
// JS for AJAX Add to Cart handling
function bootscore_product_page_ajax_add_to_cart_js() {
    ?><script type="text/javascript" charset="UTF-8">
    jQuery(function($) {

        $('form.cart').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            form.block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            var formData = new FormData(form[0]);
            formData.append('add-to-cart', form.find('[name=add-to-cart]').val());

            // Ajax action.
            $.ajax({
                url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'ace_add_to_cart'),
                data: formData,
                type: 'POST',
                processData: false,
                contentType: false,
                complete: function(response) {
                    response = response.responseJSON;

                    if (!response) {
                        return;
                    }

                    if (response.error && response.product_url) {
                        window.location = response.product_url;
                        return;
                    }

                    // Redirect to cart option
                    if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
                        window.location = wc_add_to_cart_params.cart_url;
                        return;
                    }

                    var $thisbutton = form.find('.single_add_to_cart_button'); //

                    // Trigger event so themes can refresh other areas.
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);

                    // Remove existing notices
                    $('.woocommerce-error, .woocommerce-message, .woocommerce-info').remove();

                    // Add new notices
                    form.closest('.product').before(response.fragments.notices_html);

                    form.unblock();
                }
            });
        });
    });

</script><?php
}
add_action( 'wp_footer', 'bootscore_product_page_ajax_add_to_cart_js' );
