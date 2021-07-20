<?php
/**
 * brimo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package brimo
 */

if ( ! defined( 'BRIMO_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'BRIMO_VERSION', '1.0.2' );
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

if ( ! function_exists( 'brimo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function brimo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on brimo, use a find and replace
		 * to change 'brimo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'brimo', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Hovedmeny', 'brimo' ),
				'footer-menu' => esc_html__( 'Footer-meny', 'brimo' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for Block Styles.
		 */
		add_theme_support( 'wp-block-styles' );

		/**
		 * Add support for full and wide align images.
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Add support for responsive embedded content.
		 */
		add_theme_support( 'responsive-embeds' );

		/**
		 * Bootstrap 5 navbar walker menu
		 * https://github.com/wp-bootstrap/wp-bootstrap-navwalker
		 */
		require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';


		add_filter( 'nav_menu_link_attributes', 'prefix_bs5_dropdown_data_attribute', 20, 3 );
		/**
		 * Use namespaced data attribute for Bootstrap's dropdown toggles.
		 *
		 * @param array    $atts HTML attributes applied to the item's `<a>` element.
		 * @param WP_Post  $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @return array
		 */
		function prefix_bs5_dropdown_data_attribute( $atts, $item, $args ) {
		    if ( is_a( $args->walker, 'WP_Bootstrap_Navwalker' ) ) {
		        if ( array_key_exists( 'data-toggle', $atts ) ) {
		            unset( $atts['data-toggle'] );
		            $atts['data-bs-toggle'] = 'dropdown';
		        }
		    }
		    return $atts;
		}
	}
endif;
add_action( 'after_setup_theme', 'brimo_setup' );

if ( ! function_exists( 'brimo_add_wpsc_cookie_banner' ) ) :
	/**
	 * Tell WP Super Cache to cache requests with the cookie "seopress-user-consent-accept" separately
	 * from other visitors.
	 */
	function brimo_add_wpsc_cookie_banner() {
	    do_action( 'wpsc_add_cookie', 'seopress-user-consent-accept' );
	}
endif;
add_action( 'init', 'brimo_add_wpsc_cookie_banner' );

if ( ! function_exists( 'brimo_disable_emojis_scripts' ) ) :
	/**
	 * Disable the emoji's
	 */
	function brimo_disable_emojis_scripts() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'tiny_mce_plugins', 'brimo_disable_emojis_tinymce' );
		add_filter( 'wp_resource_hints', 'brimo_disable_emojis_remove_dns_prefetch', 10, 2 );
	}
endif;
add_action( 'init', 'brimo_disable_emojis_scripts' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function brimo_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
 		return array_diff( $plugins, array( 'wpemoji' ) );
 	} else {
 	return array();
 	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function brimo_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
 	}

	return $urls;
}

/**
 * Remove wpautop filter from category description
 */
remove_filter('term_description','wpautop');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function brimo_widgets_init() {

	if ( function_exists('register_sidebar') )
	{
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'brimo' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'brimo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

        register_sidebar( array(
            'name' => esc_html__('Search bar top', 'brimo' ),
            'id' => 'top-nav-search',
            'description' => esc_html__('Add widgets here.', 'brimo' ),
            'before_widget' => '<div class="top-nav-search">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title d-none">',
            'after_title' => '</div>'
        ));

		register_sidebars( 1, array(
	        'name' => 'product-widget',
	        'id' => 'product-widgets',
	        'description'   => esc_html__( 'Add widgets here.', 'brimo' ),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget' => '</section>',
	        'before_title' => '<h2 class="widget-title">',
	        'after_title' => '</h2>'
	    ));

		register_sidebars( 1, array(
	        'name' => 'Widgets in the contact area',
	        'id' => 'contact-widgets',
	        'description'   => esc_html__( 'Add widgets here.', 'brimo' ),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget' => '</section>',
	        'before_title' => '<h2 class="widget-title">',
	        'after_title' => '</h2>'
	    ));

	    register_sidebars( 1, array(
	        'name' => 'footer-widgets',
	        'id' => 'footer-widgets',
	        'description'   => esc_html__( 'Derp widgets here.', 'brimo' ),
	        'before_widget' => '<section id="%1$s" class="widget %2$s">',
	        'after_widget' => '</section>',
	        'before_title' => '<h2 class="widget-title">',
	        'after_title' => '</h2>'
	    ));
	}
}
add_action( 'widgets_init', 'brimo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function brimo_scripts() {
	wp_enqueue_style( 'brimo-style', get_stylesheet_uri() , array(), BRIMO_VERSION );
	wp_style_add_data( 'brimo-style', 'rtl', 'replace' );

	//wp_deregister_script('jquery');

	wp_enqueue_script( 'brimo-scripts', get_template_directory_uri() . '/js/scripts.min.js', array(), BRIMO_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'brimo_scripts' );

function brimo_backend_styles($hook) {
	// Only load styles on theme settings page
	if ('toplevel_page_theme-settings' != $hook) {
		return;
	}
    wp_enqueue_style( 'brimo-style', get_stylesheet_uri() , array(), BRIMO_VERSION );
    wp_enqueue_style( 'brimo-backend-style', get_template_directory_uri() . '/admin/style.css');
}

/**
 *	Add theme settings
 */
require get_template_directory() . '/admin/theme-settings.php';

/**
 *	Add ACF meta fields
 */
require get_template_directory() . '/admin/acf-meta.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement Custom Logo feature.
 */
require get_template_directory() . '/inc/custom-logo.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 *  Register Comment List
 */
require get_template_directory() . ('/inc/comment-list.php');

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if ( ! function_exists( 'brimo_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function brimo_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}
/**
 * Load WooCommerce compatibility file.
 */
if ( brimo_is_woocommerce_activated() ) {
	require get_template_directory() . '/inc/woocommerce.php';

	// Add custom woocommerce cart thumbnale size
	if ( function_exists( 'add_image_size' ) ) {
    	add_image_size( 'woocommerce-cart-thumb', 40, 60, true );
	}
}

add_filter('mailpoet_display_custom_fonts', function () {
    return false;
});


/**
 * Disable WooCommerce block styles (front-end).
 */
function slug_disable_woocommerce_block_styles() {
  wp_dequeue_style( 'wc-block-style' );
}
add_action( 'wp_enqueue_scripts', 'slug_disable_woocommerce_block_styles' );