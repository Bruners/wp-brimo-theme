<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package wp-brimo-theme
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function brimo_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			//'thumbnail_image_width' => 450,
			//'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Add Bootstrap classes to form fields.
	add_filter( 'woocommerce_form_field_args', 'brimo_wc_form_field_args', 10, 3 );
	add_filter( 'woocommerce_quantity_input_classes', 'brimo_quantity_input_classes' );
}
add_action( 'after_setup_theme', 'brimo_woocommerce_setup' );

// First unhook the WooCommerce content wrappers.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'brimo_woocommerce_wrapper_start' ) ) {
	/**
	 * Display the theme specific start of the page wrapper.
	 */
	function brimo_woocommerce_wrapper_start() {
		echo '<div class="mt-3" id="woocommerce-wrapper">';
		echo '<div class="container">';
		echo '<div class="row">';
		echo '<div class="col">';
	}
}

if ( ! function_exists( 'brimo_woocommerce_wrapper_end' ) ) {
	/**
	 * Display the theme specific end of the page wrapper.
	 */
	function brimo_woocommerce_wrapper_end() {
		echo '</div> ';
		echo '</div> ';
		echo '</div> ';
		echo '</div><!-- WooCommerce Wrapper end -->';
	}
}

// Then hook in your own functions to display the wrappers your theme requires.
add_action( 'woocommerce_before_main_content', 'brimo_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'brimo_woocommerce_wrapper_end', 10 );

/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
if ( ! function_exists( 'brimo_wc_form_field_args' ) ) {
	function brimo_wc_form_field_args( $args, $key, $value = null ) {
		// Start field type switch case.
		switch ( $args['type'] ) {
			// Targets all select input type elements, except the country and state select input types.
			case 'select':
				/*
				 * Add a class to the field's html element wrapper - woocommerce
				 * input types (fields) are often wrapped within a <p></p> tag.
				 */
				$args['class'][] = 'mb-3';
				// Add a class to the form input itself.
				$args['input_class'] = array( 'form-select' );
				$args['label_class'] = array( 'form-label' );
				// Add custom data attributes to the form input itself.
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;

			/*
			 * By default WooCommerce will populate a select with the country names - $args
			 * defined for this specific input type targets only the country select element.
			 */
			case 'country':
				$args['class'][] = 'mb-3 single-country';
				$args['input_class'] = array( 'form-select' );
				$args['label_class'] = array( 'form-label' );
				break;

			/*
			 * By default WooCommerce will populate a select with state names - $args defined
			 * for this specific input type targets only the country select element.
			 */
			case 'state':
				$args['class'][] = 'mb-3';
				$args['label_class'] = array( 'form-label' );
				$args['input_class'] = array( 'form-select' );
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;
			case 'password':
				$args['class'][]     = 'mb-3';
				$args['label_class'] = array( 'form-label' );
				$args['input_class'] = array( 'form-control' );
				break;
			case 'text':
				$args['class'][]     = 'mb-3';
				$args['label_class'] = array( 'form-label' );
				$args['input_class'] = array( 'form-control' );
				break;
			case 'email':
				$args['class'][]     = 'mb-3';
				$args['label_class'] = array( 'form-label' );
				$args['input_class'] = array( 'form-control' );
				break;
			case 'tel':
				$args['class'][]     = 'mb-3';
				$args['label_class'] = array( 'form-label' );
				$args['input_class'] = array( 'form-control' );
				break;
			case 'number':
				$args['class'][]     = 'mb-3';
				$args['label_class'] = array( 'form-label' );
				$args['input_class'] = array( 'form-control' );
				break;
			case 'textarea':
				$args['label_class'] = array( 'form-label' );
				$args['input_class'] = array( 'form-control' );
				break;
			case 'checkbox':
				$args['label_class'] = array( 'form-check' );
				$args['input_class'] = array( 'form-check-input' );
				break;
			case 'radio':
				$args['label_class'] = array( 'form-check' );
				$args['input_class'] = array( 'form-check-input' );
				break;
			default:
				$args['class'][]     = 'mb-3';
				$args['label_class'] = array( 'form-label' );
				$args['input_class'] = array( 'form-control' );
				break;
		} // End of switch ( $args ).
		return $args;
	}
}

/**
 * Add Bootstrap class to quantity input field.
 *
 * @param array $classes Array of quantity input classes.
 * @return array
 */
if ( ! function_exists( 'brimo_quantity_input_classes' ) ) {
	function brimo_quantity_input_classes( $classes ) {
		$classes[] = 'form-control';
		return $classes;
	}
}

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function brimo_woocommerce_scripts() {
	wp_enqueue_style( 'brimo-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), BRIMO_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'brimo-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'brimo_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Remove CSS and/or JS for Select2 used by WooCommerce, 
 *
 * @link https://gist.github.com/Willem-Siebe/c6d798ccba249d5bf080/
 */
add_action( 'wp_enqueue_scripts', 'wsis_dequeue_stylesandscripts_select2', 100 );

function wsis_dequeue_stylesandscripts_select2() {
    if ( class_exists( 'woocommerce' ) ) {
        wp_dequeue_style( 'selectWoo' );
        wp_deregister_style( 'selectWoo' );

        wp_dequeue_script( 'selectWoo');
        wp_deregister_script('selectWoo');
    }
}

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function brimo_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'brimo_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function brimo_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'brimo_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'brimo_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function brimo_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'brimo_woocommerce_wrapper_before' );

if ( ! function_exists( 'brimo_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function brimo_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'brimo_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'brimo_woocommerce_header_cart' ) ) {
			brimo_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'brimo_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function brimo_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		brimo_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'brimo_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'brimo_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function brimo_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View cart', 'woocommerce' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'brimo' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'brimo_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function brimo_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart navbar-nav">
			<li class="<?php echo esc_attr( $class ); ?> nav-item">
				<?php brimo_woocommerce_cart_link(); ?>
			</li>
			<li class="nav-item">
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

/**
 * Cart empty message alert
 */
remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );
if ( ! function_exists( 'brimo_woocommerce_empty_cart_message' ) ) {
	function brimo_woocommerce_empty_cart_message() {
	    $html  = '<div class="cart-empty alert alert-info">';
	    $html .= wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'woocommerce' ) ) );
	    echo $html . '</div>';
	}
}

/**
 * Mini cart widget buttons
 */
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

if ( ! function_exists( 'brimo_woocommerce_widget_shopping_cart_button_view_cart' ) ) {
	function brimo_woocommerce_widget_shopping_cart_button_view_cart() {
	    echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-outline-primary d-block mb-2">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
	}
}
if ( ! function_exists( 'brimo_woocommerce_widget_shopping_cart_proceed_to_checkout' ) ) {
	function brimo_woocommerce_widget_shopping_cart_proceed_to_checkout() {
	    echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-primary d-block">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
	}
}
add_action( 'woocommerce_widget_shopping_cart_buttons', 'brimo_woocommerce_widget_shopping_cart_button_view_cart', 10 );
add_action( 'woocommerce_widget_shopping_cart_buttons', 'brimo_woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );


/**
 * Woocommerce product widget
 */
if ( ! function_exists( 'brimo_woocommerce_before_widget_product_list' ) ) {
	/**
	 * Widget product list opening tag
	 *
	 * @param $html defaults to <ul class="product_list_widget">
	 * @return new html
	 */
	function brimo_woocommerce_before_widget_product_list ( $html ) {
    	return '<div class="row product_list_widget">';
	}
}
add_filter( 'woocommerce_before_widget_product_list', 'brimo_woocommerce_before_widget_product_list', 1, 1 );

if ( ! function_exists( 'brimo_woocommerce_after_widget_product_list' ) ) {
	/**
	 * Widget product list ending tag
	 *
	 * @param $html defaults to </ul>
	 * @return new html
	 */
	function brimo_woocommerce_after_widget_product_list ( $html ) {
    	return '</div>';
	}
}
add_filter( 'woocommerce_after_widget_product_list', 'brimo_woocommerce_after_widget_product_list', 1, 1 );

if ( ! function_exists( 'brimo_woocommerce_variable_price_html' ) ) {
	/**
	 * Alter product price output
	 *
	 * @param $price $product
	 * @return Only starting price
	 */
	function brimo_woocommerce_variable_price_html( $price, $product ) {
	    $price = __('Fra ', 'brimo');
	    $price .= wc_price($product->get_variation_price('min'));
	    return $price;
	}
}
add_filter('woocommerce_variable_price_html', 'brimo_woocommerce_variable_price_html', 10, 2);