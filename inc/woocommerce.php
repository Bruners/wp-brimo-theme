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
            'thumbnail_image_width' => 324,
            'single_image_width'    => 416,
            'product_grid'          => array(
                'default_rows'    => 3,
                'default_columns' => 4,
                'min_columns'     => 1,
                'max_columns'     => 6,
                'min_rows'        => 1,
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


/**
 * Add new user role for commercial kitchen customers
 */
function brimo_add_wholesale_customer_role() {
    if ( get_option( 'brimo_customer_roles_version' ) < 2 ) {
        add_role( 'kitchen', __( 'Storkjøkken', 'brimo' ), get_role( 'customer' )->capabilities );
        add_role( 'grocerystore', __( 'Matbutikk', 'brimo' ), get_role( 'customer' )->capabilities );
        update_option( 'brimo_customer_roles_version', 2 );
    }
}
add_action( 'init', 'brimo_add_wholesale_customer_role' );


/**
 * Remove default cross sell display hook from cart collaterals, inserted manually in cart template
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

/**
 * Remove the breadcrumbs
 */
add_action( 'init', 'brimo_remove_woocommerce_breadcrumbs' );
function brimo_remove_woocommerce_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

/**
 * Enable ajax add to cart for WooCommerce products
 */
function brimo_woocommerce_ajax_add_to_cart(){

    if ( function_exists('is_product') && is_product() ) {

        wp_enqueue_script( 'brimo-woocommerce-add-to-cart', get_template_directory_uri() . '/woocommerce/js/woocommerce.js', array('jquery'), BRIMO_VERSION, true);

    }
}
add_action('wp_enqueue_scripts', 'brimo_woocommerce_ajax_add_to_cart');

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

if ( ! function_exists( 'brimo_mini_cart' ) ) :
    /**
     * Change mini cart header and update on ajax
     *
     */
    function brimo_mini_cart( $fragments ) {

        ob_start();
        $count = WC()->cart->cart_contents_count;
        ?><span class="cart-content"><?php
        if ( $count > 0 ) {
            ?>
        <span class="cart-content-count badge bg-info"><?php echo esc_html( $count ); ?></span><span class="cart-total ms-1 d-none d-md-inline"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
        <?php
        }
            ?></span><?php

        $fragments['span.cart-content'] = ob_get_clean();

        return $fragments;
    }
    add_filter( 'woocommerce_add_to_cart_fragments', 'brimo_mini_cart' );

endif;

/**
 * Change Added to cart message.
 */
function brimo_add_to_cart_message_html( $message, $products ) {

    $count = 0;
    $titles = array();
    foreach ( $products as $product_id => $qty ) {
        $titles[] = ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ) . sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'woocommerce' ), strip_tags( get_the_title( $product_id ) ) );
        $count += $qty;
    }

    $titles     = array_filter( $titles );
    $added_text = sprintf( _n(
        '%s ble lagt til i handlekurven.', // Singular
        '%s ble lagt til i handlekurven.', // Plural
        $count,
        'brimo'
    ), wc_format_list_of_items( $titles ) );
    $message    = sprintf( '%s <a href="%s" class="btn btn-outline-brimo">%s</a>', esc_html( $added_text ), esc_url( wc_get_checkout_url() ), esc_html__( 'Til kassen', 'brimo' ) );

    return $message;
}
add_filter( 'wc_add_to_cart_message_html', 'brimo_add_to_cart_message_html', 10, 2 );

/**
 * Cart empty message alert
 */
remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'brimo_woocommerce_empty_cart_message', 10 );
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
        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-outline-brimo d-block mb-2">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
    }
}
if ( ! function_exists( 'brimo_woocommerce_widget_shopping_cart_proceed_to_checkout' ) ) {
    function brimo_woocommerce_widget_shopping_cart_proceed_to_checkout() {
        echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="btn btn-brimo d-block">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
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

if ( ! function_exists( ' brimo_add_per_kg_to_price' ) ) {
    /**
     * Add "per kg" to price field
     *
     * @param $price $product
     * @return Price with added per kg string
     */
    function brimo_add_per_kg_to_price( $price, $product ) {

        $terms = array(
            'kveite',
            'torsk',
            'sei',
            'uer',
            'flekksteinbit',
            'kvitlange',
            'brosme',
            'breiflabb',
        );
        if( has_term($terms, 'product_cat', $product->get_id() ) ) {
            $price = $price . "&nbsp;pr/kg";
        }

        return $price;
    }
}

add_filter( 'woocommerce_get_price_html', 'brimo_add_per_kg_to_price', 10, 2 );
add_filter( 'woocommerce_get_variation_price_html', 'brimo_add_per_kg_to_price', 10, 2 );

if ( ! function_exists( 'brimo_get_availability_text' ) ) {
    /**
     * Add extra notification for items on backorder and not in stock.
     */
    function brimo_get_availability_text( $text, $product ){
        if ( $product->is_on_backorder( 1 ) ) {
            $text = '<div class="alert alert-warning" role="alert">' . __( 'Ikke på lager akkurat nå, kan kjøpes og leveres ut ved første anledning', 'brimo' ) . '</div>';
        }

        if ( !$product->is_in_stock() ) {
            $text = '<div class="alert alert-danger" role="alert">' . __( 'Det er desverre tomt på lager', 'brimo' ) . '</div>';
        }

        return $text;
    }

}
add_filter( 'woocommerce_get_availability_text', 'brimo_get_availability_text', 99, 2 );

remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);

if ( ! function_exists( 'brimo_woocommerce_subcategory_thumbnail' ) ) {

    /**
     * Show subcategory thumbnails.
     *
     * @param mixed $category Category.
     */
    function brimo_woocommerce_subcategory_thumbnail( $category ) {

        $default_dimensions = array(
            'width' => '300',
            'height' => '300',
            'crop' => 1,
        );
        $small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
        $dimensions           = wc_get_image_size( $small_thumbnail_size ) ? wc_get_image_size( $small_thumbnail_size ) : $default_dimensions;
        $thumbnail_id         = get_term_meta( $category->term_id, 'thumbnail_id', true );
        $image_class          = "card-img-top img-fluid lazy";

        if ( $thumbnail_id ) {

            $image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
            $image        = $image[0];
            $image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, 'medium' ) : false;
            $image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, 'medium' ) : false;

            $image_alt    = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            $image_title  = get_post( $thumbnail_id )->post_content;

        } else {

            $image        = wc_placeholder_img_src();
            $image_srcset = false;
            $image_sizes  = false;
            $image_alt    = "placeholder";

        }

        if ( $image ) {

            // Add responsive image markup if available.
            if ( $image_srcset && $image_sizes ) {
                echo '<img class="' . esc_attr( $image_class ) . '" data-src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" data-srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" title="' . esc_attr( $image_title ) . '" alt="' . esc_attr( $image_alt ) . '" loading="lazy" />';

            } else {

                echo '<img class="' . esc_attr( $image_class ) . '" data-src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" alt="' . esc_attr( $image_alt ) . '" loading="lazy" />';

            }
        }
    }
}

add_action( 'woocommerce_before_subcategory_title', 'brimo_woocommerce_subcategory_thumbnail', 10);

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
if ( ! function_exists( 'brimo_woocommerce_template_loop_product_thumbnail' ) ) {
    function brimo_woocommerce_template_loop_product_thumbnail() {
        echo brimo_woocommerce_get_product_thumbnail();
    }
}
add_action( 'woocommerce_before_shop_loop_item_title', 'brimo_woocommerce_template_loop_product_thumbnail', 10);

if ( ! function_exists( 'brimo_woocommerce_get_product_thumbnail' ) ) {
    function brimo_woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail', $placeholder_width = 0, $placeholder_height = 0  ) {

        global $post, $woocommerce, $product;

        // If the WC_product Object is not defined globally
        if ( ! is_a( $product, 'WC_Product' ) ) {
            $product = wc_get_product( get_the_id() );
        }

        $default_dimensions = array(
            'width' => '300',
            'height' => '300',
            'crop' => 1,
        );
        $small_thumbnail_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

        $dimensions   = wc_get_image_size( $small_thumbnail_size ) ? wc_get_image_size( $small_thumbnail_size ) : $default_dimensions;

        if ( has_post_thumbnail() ) {

            $props        = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
            $thumbnail_id = get_post_thumbnail_id( $post->ID, $small_thumbnail_size );

            $image_alt    = $props['alt'] ? $props['alt'] : 'image';
            $image_title  = $props['alt'] ? $props['alt'] : 'image-title';

            $image        = wp_get_attachment_image_src( $thumbnail_id, $size );
            $image        = $image[0];
            $image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
            $image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;

        } else {

            $image        = wc_placeholder_img_src();
            $image_srcset = false;
            $image_sizes  = false;

        }

        if ( $image ) {

            $image_class = "attachment-woocommerce_thumbnail size-woocommerce_thumbnail card-img-top img-fluid lazy";

            brimo_get_product_meta_icon( get_the_id() );

            // Add responsive image markup if available.
            if ( $image_srcset && $image_sizes ) {

                echo '<img class="' . esc_attr( $image_class ) . '" data-src="' . esc_url( $image ) . '" title="' . esc_attr($image_title) . '" alt="' . esc_attr( $image_alt ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" data-srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" loading="lazy" />';

            } else {

                echo '<img class="' . esc_attr( $image_class ) . '" data-src="' . esc_url( $image ) . '" title="placeholder image" alt="placeholder image" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" loading="lazy" />';

            }
        }
    }
}

if ( ! function_exists( brimo_get_product_meta_icon ) ) {
    /**
     * Add meta icons on product cards to show availability ++
     */
    function brimo_get_product_meta_icon( $product_id = '') {

        $product = wc_get_product( $product_id );
        $product_tag = get_the_terms( $product_id, 'product_tag' );

        $meta_header = '<div class="position-absolute top-0 end-0 pt-3 pe-3">';
        $meta_body = '';
        $meta_footer = '</div>';

        if ( $product->is_on_backorder( 1 ) ) {
            $meta_body = $meta_body . '<span class="fa-stack fa-1x" title="' . __( 'Ikke på lager, men kan bestilles', 'brimo' ) . '"><i class="fas fa-circle fa-stack-2x text-light"></i><i class="fas fa-shipping-fast fa-stack-1x text-warning"></i></span>';
        }

        if ( !$product->is_in_stock() ) {
            $meta_body = $meta_body . '<span class="fa-stack fa-1x" title="' . __( 'Ikke på lager', 'brimo' ) . '"><i class="fas fa-circle fa-stack-2x text-light"></i><i class="fas fa-shipping-fast fa-stack-1x text-error"></i></span>';
        }

        if ( $product->is_in_stock() && !$product->is_on_backorder( 1 ) ) {
            $meta_body = $meta_body . '<span class="fa-stack fa-1x" title="' . __( 'På lager, hurtig levering', 'brimo' ) . '"><i class="fas fa-circle fa-stack-2x text-light"></i><i class="fas fa-shipping-fast fa-stack-1x medium"></i></span>';
        }

        if ( $product_tag != null ) {
            foreach( $product_tag as $tag) :
                if ( $tag->slug === 'fryst' ) :
                    $meta_body = $meta_body . '<span class="fa-stack fa-1x text-info" title="' . __( 'Frysevare', 'brimo' ) . '"><i class="fas fa-circle fa-stack-2x"></i><i class="fas fa-snowflake fa-stack-1x text-frozen"></i></span>';
                endif;
            endforeach;
        }

        echo $meta_header .  $meta_body . $meta_footer;
    }
}

remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);
if ( ! function_exists( 'brimo_woocommerce_template_loop_category_title' ) ) {

    /**
     * Show the subcategory title in the product loop.
     *
     * @param object $category Category object.
     */
    function brimo_woocommerce_template_loop_category_title( $category ) {
        ?>
    <div class="card-body">
        <h4 class="woocommerce-loop-category__title card-title">
            <?php
            echo esc_html( $category->name );
            ?>
        </h4>
        <p><?php echo esc_html( $category->description ); ?></p>
    </div>
    <div class="card-footer text-muted">
        <?php
        if ( $category->count > 0 ) {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo apply_filters( 'woocommerce_subcategory_count_html', '<div class="small">' . esc_html( $category->count ) . "&nbsp" . __('Produkt i kategorien', 'brimo') . '</div>', $category );
        }
        elseif ( $category->count > 1 ) {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo apply_filters( 'woocommerce_subcategory_count_html', ' <div class="small">' . esc_html( $category->count ) . "&nbsp" . __('Produkter i kategorien', 'brimo') . '</div>', $category );
        }
        ?>
    </div>
        <?php
    }
}

add_action( 'woocommerce_shop_loop_subcategory_title', 'brimo_woocommerce_template_loop_category_title', 10 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
if ( ! function_exists( 'brimo_woocommerce_template_loop_product_link_open' ) ) {
    /**
     * Insert the opening anchor tag for products in the loop.
     */
    function brimo_woocommerce_template_loop_product_link_open() {
        global $product;

        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

        echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link text-decoration-none">';
    }
}
add_action( 'woocommerce_before_shop_loop_item', 'brimo_woocommerce_template_loop_product_link_open', 10 );

function brimo_change_account_order() {
    $items = array(
      'dashboard' => __( 'Dashboard', 'woocommerce' ),
      'orders' => __( 'Orders', 'woocommerce' ),
      //'downloads' => __( 'Downloads', 'woocommerce' ),
      'edit-address' => __( 'Addresses', 'woocommerce' ),
      'payment-methods' => __( 'Payment methods', 'woocommerce' ),
      'edit-account' => __( 'Account details', 'woocommerce' ),
      'customer-logout' => __( 'Logout', 'woocommerce' ),
    );

    return $items;
}
add_filter ( 'woocommerce_account_menu_items', 'brimo_change_account_order' );

if ( ! function_exists( 'brimo_woocommerce_product_category_title' ) ) :
    /**
     * Get product categories
     */
    function brimo_woocommerce_product_category_title() {
        global $post;
        $terms = get_the_terms( $post->ID, 'product_cat' );
        $title = '';

        foreach ($terms as $term) {
            $title = $term->name .' ';
        }

        return $title;
    }
endif;

/**
 * Add decimal quantity on products
 */
// Add min value to the quantity field (default = 1)
add_filter( 'woocommerce_quantity_input_min', 'brimo_quantity_input_min' );
//add_filter( 'woocommerce_quantity_input_min_admin', 'brimo_quantity_input_min' );
function brimo_quantity_input_min($val) {
    return 0.1;
}

// Add step value to the quantity field (default = 1)
add_filter( 'woocommerce_quantity_input_step', 'brimo_quantity_input_step' );
//add_filter( 'woocommerce_quantity_input_step_admin', 'brimo_quantity_input_step' );
function brimo_quantity_input_step($val) {
    return 0.1;
}

// Removes the WooCommerce filter, that is validating the quantity to be an int
remove_filter( 'woocommerce_stock_amount', 'intval' );
// Add a filter, that validates the quantity to be a float
add_filter( 'woocommerce_stock_amount', 'floatval' );

// Add unit price fix when showing the unit price on processed orders
add_filter( 'woocommerce_order_amount_item_total', 'brimo_unit_price_fix', 10, 5 );
function brimo_unit_price_fix($price, $order, $item, $inc_tax = false, $round = true) {
    $qty = (!empty($item['qty']) && $item['qty'] != 0) ? $item['qty'] : 1;
    if($inc_tax) {
        $price = ($item['line_total'] + $item['line_tax']) / $qty;
    } else {
        $price = $item['line_total'] / $qty;
    }
    $price = $round ? round( $price, 2 ) : $price;
    return $price;
}
