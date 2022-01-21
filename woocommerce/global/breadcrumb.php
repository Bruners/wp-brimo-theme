<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$shop = wc_get_page_id( 'shop' );
$shop_url = get_permalink( $shop );
$shop_page = get_post($shop);

if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

        if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {

            if (0==$key){

                //Display Home icon, with text on desktop
                echo '<a class="breadcrumb-item text-decoration-none" href="' . esc_url( $crumb[1] ) . '">' . '<span class="d-none d-lg-inline">' . esc_html('Hjem', 'brimo') . '</span></a>';

            } else {

                // Display shop icon, with text on desktop
                if ( $crumb[1] == $shop_url ) {

                    echo '<a class="breadcrumb-item breadcrumb-shop text-decoration-none" href="' . esc_url( $crumb[1] ) . '">' . '<span class="d-none d-lg-inline">' . $shop_page->post_title . '</span></a>';

                } else {

                    echo '<a class="breadcrumb-item text-decoration-none" href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';

                }
            }

        } else{

            echo '<span class="breadcrumb-item breadcrumb-item-text">' . esc_html($crumb[0]) . '</span>';

        }

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;

}
