<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package brimo
 */
?>

<?php

    if (is_shop() ) {

        $post_ID = wc_get_page_id('shop');

    } elseif( is_home() || is_search() || is_archive() ) {

        $post_ID = get_option('page_for_posts');

    } else {

        $post_ID = get_the_ID();

    }

    $is_hero_carousel = false;
    $is_hero_module = false;

    // Hero Variables
    if( function_exists( 'get_field' ) ) {

        $hero_opts = get_field('hero_additional_options', $post_ID);
        $is_hero_module = is_array($hero_opts) && in_array('is_hero', $hero_opts) ? true : false;
        $is_hero_img = get_field('hero_bg_img', $post_ID) != false;

        $term = get_queried_object();

        // Category hero
        $category_hero = get_field( 'category_hero_enable', $term );
        $is_category_hero_module = is_array($category_hero) && in_array('is_hero', $category_hero) ? true : false;
        $is_category_img = get_field( 'category_hero_image', $term ) != false;

    }
    
    $hero_title = get_the_title();
    $hero_subtitle = '';
    $hero_img = get_header_image();
    $hero_height = 'small';

    if ( $is_hero_module ) {

        $hero_height = get_post_meta($post_ID, 'hero_height', true) ? get_post_meta($post_ID, 'hero_height', true) : 'small';

        $hero_img_class = $is_hero_img || $is_category_img ? '' : 'hero-no-bg';
        $hero_img = $is_hero_img ? wp_get_attachment_url(get_post_meta($post_ID, 'hero_bg_img', true)) : get_header_image();

        if ( function_exists( 'is_shop') && is_shop() ) {

            $hero_title = get_post_meta($post_ID, 'hero_title', true) != '' ? get_post_meta($post_ID, 'hero_title', true) : esc_html__( 'Butikk', 'brimo' );
            $hero_subtitle = get_post_meta($post_ID, 'hero_subtitle', true) != '' ? $hero_subtitle = get_post_meta($post_ID, 'hero_subtitle', true) : esc_html__( 'Velkommen til vår nettbutikk', 'brimo' );

        } else if( function_exists( 'is_product_category' ) && is_product_category() ) {

            $hero_img = $is_category_img ? get_field( 'category_hero_image', $term ) : get_header_image();
            $hero_height = get_field('category_hero_size', $term) ? get_field('category_hero_size', $term) : 'medium';
            $hero_title = single_cat_title( '', false );
            $hero_subtitle = category_description();

        } else if( function_exists( 'is_product' ) && is_product() ) {

            $hero_title = get_the_title();
            $hero_subtitle = sprintf( esc_html__( 'I produktkategorien %s', 'brimo' ), brimo_woocommerce_product_category_title() );

        }

        $hero_button_1_class = get_field( 'hero_button_1_class', $post_ID);
        $hero_button_1_id = get_field( 'hero_button_1_id', $post_ID);
        $hero_button_1_ikon = get_field( 'hero_button_1_ikon', $post_ID);
        $hero_button_1_tekst = get_field( 'hero_button_1_tekst', $post_ID);
        $hero_button_1_url = get_field( 'hero_button_1_url', $post_ID);

        $hero_button_2_class = get_field( 'hero_button_2_class', $post_ID);
        $hero_button_2_id = get_field( 'hero_button_2_id', $post_ID);
        $hero_button_2_ikon = get_field( 'hero_button_2_ikon', $post_ID);
        $hero_button_2_tekst = get_field( 'hero_button_2_tekst', $post_ID);
        $hero_button_2_url = get_field( 'hero_button_2_url', $post_ID);

        $carousel_opts = get_post_meta($post_ID, 'enable_carousel', true);

        $is_hero_carousel = is_array($carousel_opts) && in_array('is_carousel', $carousel_opts) ? true : false;

        if ( $is_hero_carousel ) {

            $carousel_slides = get_post_meta($post_ID, 'enable_slides', true);

            $slide_1_enabled = is_array($carousel_slides) && in_array('slide_1',  $carousel_slides) ? true : false;
            $slide_2_enabled = is_array($carousel_slides) && in_array('slide_2',  $carousel_slides) ? true : false;
            $slide_3_enabled = is_array($carousel_slides) && in_array('slide_3',  $carousel_slides) ? true : false;
            $slide_4_enabled = is_array($carousel_slides) && in_array('slide_4',  $carousel_slides) ? true : false;

            if ( function_exists( 'get_field' ) && $slide_1_enabled ) {

                $slide_1_img = get_field('slide_1_image');
                $slide_1_title = get_field('slide_1_title');
                $slide_1_subtitle = get_field('slide_1_subtitle');
                $slide_1_button_1_class = get_field('slide_1_button_1_class');
                $slide_1_button_1_id = get_field('slide_1_button_1_id');
                $slide_1_button_1_ikon = get_field('slide_1_button_1_ikon');
                $slide_1_button_1_tekst = get_field('slide_1_button_1_tekst');
                $slide_1_button_1_url = get_field('slide_1_button_1_url');
                $slide_1_button_2_class = get_field('slide_1_button_2_class');
                $slide_1_button_2_id = get_field('slide_1_button_2_id');
                $slide_1_button_2_ikon = get_field('slide_1_button_2_ikon');
                $slide_1_button_2_tekst = get_field('slide_1_button_2_tekst');
                $slide_1_button_2_url = get_field('slide_1_button_2_url');

            }

            if ( function_exists( 'get_field' ) && $slide_2_enabled ) {

                $slide_2_img = get_field('slide_2_image');
                $slide_2_title = get_field('slide_2_title');
                $slide_2_subtitle = get_field('slide_2_subtitle');
                $slide_2_button_1_class = get_field('slide_2_button_1_class');
                $slide_2_button_1_id = get_field('slide_2_button_1_id');
                $slide_2_button_1_ikon = get_field('slide_2_button_1_ikon');
                $slide_2_button_1_tekst = get_field('slide_2_button_1_tekst');
                $slide_2_button_1_url = get_field('slide_2_button_1_url');
                $slide_2_button_2_class = get_field('slide_2_button_2_class');
                $slide_2_button_2_id = get_field('slide_2_button_2_id');
                $slide_2_button_2_ikon = get_field('slide_2_button_2_ikon');
                $slide_2_button_2_tekst = get_field('slide_2_button_2_tekst');
                $slide_2_button_2_url = get_field('slide_2_button_2_url');

            }

            if ( function_exists( 'get_field' ) && $slide_3_enabled ) {

                $slide_3_img = get_field('slide_3_image');
                $slide_3_title = get_field('slide_3_title');
                $slide_3_subtitle = get_field('slide_3_subtitle');
                $slide_3_button_1_class = get_field('slide_3_button_1_class');
                $slide_3_button_1_id = get_field('slide_3_button_1_id');
                $slide_3_button_1_ikon = get_field('slide_3_button_1_ikon');
                $slide_3_button_1_tekst = get_field('slide_3_button_1_tekst');
                $slide_3_button_1_url = get_field('slide_3_button_1_url');
                $slide_3_button_2_class = get_field('slide_3_button_2_class');
                $slide_3_button_2_id = get_field('slide_3_button_2_id');
                $slide_3_button_2_ikon = get_field('slide_3_button_2_ikon');
                $slide_3_button_2_tekst = get_field('slide_3_button_2_tekst');
                $slide_3_button_2_url = get_field('slide_3_button_2_url');

            }

            if ( function_exists( 'get_field' ) && $slide_4_enabled ) {

                $slide_4_img = get_field('slide_4_image');
                $slide_4_title = get_field('slide_4_title');
                $slide_4_subtitle = get_field('slide_4_subtitle');
                $slide_4_button_1_class = get_field('slide_4_button_1_class');
                $slide_4_button_1_id = get_field('slide_4_button_1_id');
                $slide_4_button_1_ikon = get_field('slide_4_button_1_ikon');
                $slide_4_button_1_tekst = get_field('slide_4_button_1_tekst');
                $slide_4_button_1_url = get_field('slide_4_button_1_url');
                $slide_4_button_2_class = get_field('slide_4_button_2_class');
                $slide_4_button_2_id = get_field('slide_4_button_2_id');
                $slide_4_button_2_ikon = get_field('slide_4_button_2_ikon');
                $slide_4_button_2_tekst = get_field('slide_4_button_2_tekst');
                $slide_4_button_2_url = get_field('slide_4_button_2_url');

            }
        }
    } else if ( function_exists( 'is_shop') && is_shop() ) {

        $hero_title = esc_html__( 'Butikk', 'brimo' );
        $hero_height = 'xs';
        $hero_subtitle = esc_html__( 'Velkommen til vår nettbutikk', 'brimo' );
        $hero_img = get_header_image();

    } else if( function_exists( 'is_product_category' ) && is_product_category() ) {

        if ( function_exists( 'get_field' ) && $is_category_hero_module ) {

            $hero_img = $is_category_img ? get_field( 'category_hero_image', $term ) : 'blank';
            $hero_height = get_field('category_hero_size', $term) ? get_field('category_hero_size', $term) : 'medium';
            $hero_title = single_cat_title( '', false );
            $hero_subtitle = category_description();

        } else {

            $hero_img = get_header_image();
            $hero_height = 'xs';
            $hero_title = single_cat_title( '', false );
            $hero_subtitle = category_description();

        }

    } else if( function_exists( 'is_product' ) && is_product() ) {

        $hero_img = get_header_image();
        $hero_height = 'xs';
        $hero_title = get_the_title();
        $hero_subtitle = sprintf( esc_html__( 'I produktkategorien %s', 'brimo' ), brimo_woocommerce_product_category_title() );

    } else if ( is_search() ) {

        $hero_height = 'xs';
        $hero_title = esc_html__( 'Søkeresultater', 'brimo' );
        $hero_subtitle = sprintf( esc_html__( 'For teksten "%s"', 'brimo' ), get_search_query() );

    } else if( is_category() ) {

        $hero_height = 'xs';
        $hero_title = esc_html__( 'Kategori', 'brimo' );
        $hero_subtitle = sprintf( esc_html__( 'Innhold i kategorien "%s"', 'brimo' ), single_cat_title( '', false ) );

    } else if( is_tag() ) {

        $hero_height = 'xs';
        $hero_title = esc_html__( 'Tagger', 'brimo' );
        $hero_subtitle = sprintf( esc_html__( 'Innhold tagget med "%s"', 'brimo' ), single_tag_title( '', false ) );

    } else if( is_date() ) {

        $hero_height = 'xs';
        $hero_title = esc_html__( 'Arkiv', 'brimo' );

        if ( is_day() ) {

            $hero_subtitle = sprintf( esc_html__( 'Innhold fra "%s"', 'brimo' ), get_the_date() );

        } else if ( is_month() ) {

            $hero_subtitle = sprintf( esc_html__( 'Innhold fra "%s"', 'brimo' ), get_the_date( 'F Y' ) );

        } else {

            $hero_subtitle = sprintf( esc_html__( 'Innhold fra "%s"', 'brimo' ), get_the_date( 'Y' ) );

        }

    } else if( is_author() ) {

        $hero_height = 'xs';
        $hero_title = esc_html__( 'Forfatter', 'brimo' );
        $hero_subtitle = sprintf( esc_html__( 'Innhold fra "%s"', 'brimo' ), get_search_query() );

    } else if( is_home() ) {
        $hero_subtitle = '';

    } else if( is_page() ) {

        $hero_subtitle = '';

    } else if( is_404() ) {

        $hero_title = '404';
        $hero_height = 'small';
        $hero_subtitle = esc_html__( 'OOPS! Vi kunne ikke finne siden.', 'brimo' );

    } else {

        $hero_title = get_the_title();
        $hero_img = get_header_image();
        $hero_height = 'xs';
        $hero_subtitle = '';

    }

    $hero_class = 'hero-' . $hero_height;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="//gmpg.org/xfn/11" crossorigin>
    <link rel="preconnect" href="//fonts.googleapis.com" crossorigin>
    <link rel="preload" href="//fonts.googleapis.com/css2?family=Open+Sans&family=Passion+One:wght@400;700&display=swap" as="style" crossorigin="anonymous"/>
    <link rel="stylesheet" href="//fonts.googleapis.com/css2?family=Open+Sans&family=Passion+One:wght@400;700&display=swap" crossorigin="anonymous"/>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <!-- <link href="//www.google-analytics.com" rel="dns-prefetch"> -->
    <!-- <link href="//connect.facebook.net" rel="dns-prefetch"> -->
    <?php wp_head(); ?>
</head>
<body <?php body_class( $class=$hero_class ) ; ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="visually-hidden-focusable" href="#content"><?php esc_html_e( 'Hopp til innhold', 'brimo' ); ?></a>
    <header id="masthead" class="site-header">
        <nav id="site-navigation" class="navbar fixed-top navbar-expand-lg navbar-dark navbar-brimo p-md-3">

            <div class="container">
                <button class="brimo-navbar-toggler btn btn-brimo" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-navbar" aria-controls="offcanvas-navbar">
                    <i class="fas fa-bars"></i>
                </button>
                <!-- Top Nav Search Mobile -->
                <div class="top-nav-search-md d-lg-none ms-2">
                    <div class="dropdown">
                        <button class="btn btn-brimo" type="button" id="dropdown-search" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-search"></i>
                        </button>
                        <div class="dropdown-search dropdown-menu position-fixed border-0 bg-dark shadow rounded-0 start-0 end-0" aria-labelledby="dropdown-search">
                            <div class="container">
                                <?php if ( is_active_sidebar( 'top-nav-search' )) : ?>
                                <div class="mb-2">
                                    <?php dynamic_sidebar( 'top-nav-search' ); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php if ( has_custom_logo() ) :
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            ?>
                <a class="navbar-brand d-block" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php brimo_get_logo_white_meta(); ?>
                    <?php brimo_get_logo_color_meta('d-none align-text-top'); ?>
                </a>
            <?php else : ?>
                <h1><a class="navbar-brand d-block" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php endif; ?>

                <div class="order-lg-1 flex-grow-1 flex-lg-grow-0 d-flex justify-content-end">
                    <span class="placeholder">&nbsp;</span>
                </div>

                <div class="offcanvas offcanvas-start" tabindex="-1" data-bs-hideresize="true" id="offcanvas-navbar">
                    <div class="offcanvas-header cursor-pointer hover bg-light text-brimo" data-bs-dismiss="offcanvas">
                        <?php esc_html_e( 'Lukk meny', 'brimo' ) ; ?> <i class="fas fa-chevron-left"></i>
                    </div>
                    <div class="offcanvas-body">
                        <?php
                            wp_nav_menu(array(
                                'theme_location'    => 'primary',
                                'depth'             => 2,
                                'container'         => false,
                                'menu_class'        => 'navbar-nav ms-auto',
                                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                'walker'            => new WP_Bootstrap_Navwalker()
                            ));
                        ?>
                    </div>
                </div>

                <button class="user-toggler right btn btn-brimo ms-2 order-lg-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-user" aria-controls="offcanvas-user">
                    <i class="fas fa-user"></i>
                </button>

                <button class="cart-toggler right btn btn-brimo ms-2 order-lg-3 position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-cart" aria-controls="offcanvas-cart">
                    <i class="fas fa-shopping-bag"></i>
                    <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                        $count = WC()->cart->cart_contents_count;
                    ?>
                    <span class="cart-content">
                        <?php if ( $count > 0 ) { ?>
                        <?php echo esc_html( $count ); ?>
                        <?php
                            }
                        ?></span>
                    <?php } ?>
                </button>

                    <!-- Top Nav Search lg -->
                    <div class="top-nav-search-lg d-none d-lg-block ms-2 order-lg-2">
                        <div class="dropdown">
                            <button class="btn btn-brimo" type="button" id="dropdown-search" data-bs-toggle="dropdown" data-bs-animation="true" aria-expanded="false">
                                <i class="fas fa-search"></i>
                            </button>
                            <div class="dropdown-search dropdown-menu position-fixed border-0 bg-dark shadow rounded-0 start-0 end-0 mt-5" aria-labelledby="dropdown-search">
                                <div class="container">
                                    <?php if ( is_active_sidebar( 'top-nav-search' )) : ?>
                                    <div class="mb-2">
                                        <?php dynamic_sidebar( 'top-nav-search' ); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

            </div><!-- container -->

        </nav><!-- #site-navigation -->

        <!-- offcanvas user -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas-user">
            <div class="offcanvas-header cursor-pointer hover bg-light text-brimo" data-bs-dismiss="offcanvas">
                <?php esc_html_e('Lukk konto' , 'brimo'); ?> <i class="fas fa-chevron-right"></i>
            </div>
            <div class="offcanvas-body">
                <div class="my-offcancas-account">
                    <?php include get_template_directory() . '/woocommerce/myaccount/my-account-offcanvas.php'; ?>
                </div>
            </div>
        </div>

        <!-- offcanvas cart -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-cart">
            <div class="offcanvas-header cursor-pointer hover bg-light text-brimo" data-bs-dismiss="offcanvas">
                <i class="fas fa-chevron-left"></i> <?php esc_html_e('Fortsett handelen' , 'brimo'); ?>
            </div>
            <div class="offcanvas-body p-0">
                <div class="cart-loader bg-white position-absolute end-0 bottom-0 start-0 d-flex align-items-center justify-content-center">
                    <div class="loader-icon ">
                        <div class="spinner-border text-brimo"></div>
                    </div>
                </div>
                <div class="cart-list">
                    <h2 class="p-3"><?php esc_html_e('Handlekurv' , 'brimo'); ?></h2>
                    <div class="widget_shopping_cart_content"><?php woocommerce_mini_cart(); ?></div>
                </div>
            </div>
        </div>

        <!-- Hero image start -->
        <?php if ( !$is_hero_carousel && $is_hero_module ) { ?>

        <div id="hero-image" class="hero-image text-center" style="background-image: url('<?php echo $hero_img; ?>')">
            <div class="hero-mask d-flex justify-content-center align-items-center">
                <div class="container text-center">

            <?php if ( is_front_page() ) :?>

                    <h1 class="site-title mb-3"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php

                    $brimo_description = get_bloginfo( 'description', 'display' );

                    if ( $brimo_description || is_customize_preview() ) :
                ?>
                    <p class="site-description mb-4"><?php esc_html_e( $brimo_description ); ?></p>

                <?php 
                    endif;
                ?>

            <?php else : ?>

                    <h2 class="site-title mb-3"><?php esc_html_e( $hero_title ); ?></h2>
                    <p class="site-description mb-4"><?php esc_html_e( $hero_subtitle ); ?></p>

            <?php endif; ?>

                    <div class="cta-group">
                    <?php if ($hero_button_1_url) : ?>

                        <a class="btn <?php esc_attr_e( $hero_button_1_class ); ?>" id="<?php esc_attr_e($hero_button_1_id); ?>" role="button" href="<?php echo esc_url( $hero_button_1_url['url'] ); ?>" <?php if ( get_field( 'hero_button_1_fancybox' ) ) { echo ' data-fancybox'; } ?>>
                            <i class="<?php esc_attr_e( $hero_button_1_ikon ); ?>"></i> <?php esc_html_e( $hero_button_1_tekst ); ?>
                        </a>

                    <?php endif; ?>

                    <?php if ($hero_button_2_url) : ?>

                        <a class="btn <?php esc_attr_e( $hero_button_2_class ); ?>" id="<?php esc_attr_e( $hero_button_2_id );?>" role="button" href="<?php echo esc_url( $hero_button_2_url['url'] ); ?>" <?php if ( get_field( 'hero_button_2_fancybox' ) ) { echo ' data-fancybox'; } ?>>
                            <i class="<?php esc_attr_e( $hero_button_2_ikon ); ?>"></i> <?php esc_html_e( $hero_button_2_tekst ); ?>
                        </a>

                    <?php endif; ?>
                    </div>
                    <a href="#content" id="scroll-down" class="scroll-down m-3"><i class="scroll-down-icon fa-4x fas fa-chevron-down" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <?php } elseif ( $is_hero_module && $is_hero_carousel ) { ?>

                <div id="hero-image" class="hero-image text-center" style="background-image: url('<?php echo $hero_img; ?>')">
            <div class="hero-mask d-flex justify-content-center align-items-center">
                <div class="container text-center">

            <?php if ( is_front_page() ) :?>

                    <h1 class="site-title mb-3"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php

                    $brimo_description = get_bloginfo( 'description', 'display' );

                    if ( $brimo_description || is_customize_preview() ) :
                ?>
                    <p class="site-description mb-4"><?php esc_html_e( $brimo_description ); ?></p>

                <?php 
                    endif;
                ?>

            <?php else : ?>

                    <h2 class="site-title mb-3"><?php esc_html_e( $hero_title ); ?></h2>
                    <p class="site-description mb-4"><?php esc_html_e( $hero_subtitle ); ?></p>

            <?php endif; ?>

                    <div class="cta-group">
                    <?php if ($hero_button_1_url) : ?>

                        <a class="btn <?php esc_attr_e( $hero_button_1_class ); ?>" id="<?php esc_attr_e($hero_button_1_id); ?>" role="button" href="<?php echo esc_url( $hero_button_1_url['url'] ); ?>" <?php if ( get_field( 'hero_button_1_fancybox' ) ) { echo ' data-fancybox'; } ?>>
                            <i class="<?php esc_attr_e( $hero_button_1_ikon ); ?>"></i> <?php esc_html_e( $hero_button_1_tekst ); ?>
                        </a>

                    <?php endif; ?>

                    <?php if ($hero_button_2_url) : ?>

                        <a class="btn <?php esc_attr_e( $hero_button_2_class ); ?>" id="<?php esc_attr_e( $hero_button_2_id );?>" role="button" href="<?php echo esc_url( $hero_button_2_url['url'] ); ?>" <?php if ( get_field( 'hero_button_2_fancybox' ) ) { echo ' data-fancybox'; } ?>>
                            <i class="<?php esc_attr_e( $hero_button_2_ikon ); ?>"></i> <?php esc_html_e( $hero_button_2_tekst ); ?>
                        </a>

                    <?php endif; ?>
                    </div>
                    <a href="#content" id="scroll-down" class="scroll-down m-3"><i class="scroll-down-icon fa-4x fas fa-chevron-down" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>

        <?php } else { ?>

        <div id="hero-image" class="hero-image text-center" style="background-image: url('<?php echo $hero_img; ?>')">
            <div class="hero-mask d-flex justify-content-center align-items-center">
                <div class="container text-center">
            <?php
                if ( is_front_page() ) :
            ?>
                    <h1 class="site-title mb-3"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php

                    $brimo_description = get_bloginfo( 'description', 'display' );

                    if ( $brimo_description || is_customize_preview() ) :
            ?>
                    <p class="site-description mb-4"><?php echo $brimo_description; ?></p>

                <?php
                    endif;
                ?>

                    <a href="#content" id="scroll-down" class="scroll-down m-3"><i class="scroll-down-icon fa-4x fas fa-chevron-down" aria-hidden="true"></i></a>

            <?php
                else :
            ?>

                    <h2 class="site-title mb-3"><?php echo $hero_title; ?></h2>
                    <p class="site-description mb-4"><?php echo $hero_subtitle; ?></p>
                    <a href="#content" id="scroll-down" class="scroll-down m-3"><i class="scroll-down-icon fa-3x fas fa-chevron-down " aria-hidden="true"></i></a>

            <?php
                endif;
            ?>
                </div>
            </div>
        </div>

    <?php } ?>
    <!-- Hero image end -->

    <?php

    if ( !brimo_is_frontpage()) {

    ?>
        <div class="breadcrumbs border-bottom">

    <?php
        if ( function_exists('yoast_breadcrumb') && !function_exists('woocommerce_breadcrumb') ) {
            yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
        }

        if ( function_exists('woocommerce_breadcrumb') ) {
            $args = array(
                'delimiter' => '<span class="breadcrumb-separator"> &#47 </span>',
                'wrap_before' => '<div class="brimo-breadcrumb"><nav class="woocommerce-breadcrumb ms-3 p-3" itemprop="breadcrumb" aria-label="breadcrumb">',
                'wrap_after' => '</nav></div>',
                'before' => '',
                'after' => '',
                'home' => __( 'Home', 'breadcrumb', 'woocommerce' ),
            );
            woocommerce_breadcrumb($args);
        }
    ?>
        </div>
    </header><!-- #masthead -->
    <?php
    }
    ?>
    <div id="content" class="site-content mt-5">
