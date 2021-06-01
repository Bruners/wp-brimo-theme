<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="row"><!-- End in orderby.php -->
    <div class="col-md-6 col-lg-8 col-xxl-9">
        <p class="woocommerce-result-count">
            <?php
	if ( 1 === $total ) {
		_e( 'Viser resultatet', 'brimo' );
	} elseif ( $total <= $per_page || -1 === $per_page ) {
		/* translators: %d: total results */
		printf( _n( 'Viser alle resultatene (%d)', 'Viser alle resultatene (%d)', $total, 'brimo' ), $total );
	} else {
		$first = ( $per_page * $current ) - $per_page + 1;
		$last  = min( $total, $per_page * $current );
		/* translators: 1: first result 2: last result 3: total results */
		printf( _nx( 'Viser %1$d&ndash;%2$d av %3$d resultater', 'Viser %1$d&ndash;%2$d av %3$d resultater', $total, 'med første og siste resultat', 'brimo' ), $first, $last, $total );
	}
	?>
        </p>

    </div><!-- col -->
