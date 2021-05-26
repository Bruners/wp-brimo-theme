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
	// Hero Variables

	$hero_title = get_the_title();
	$hero_subtitle = '';
	$hero_img = get_header_image();



	if ( is_front_page() ) {

		$hero_height = 'full';

	} elseif ( is_search() ) {

		$hero_height = 'medium';
        $hero_title = esc_html__( 'Søkeresultater', 'brimo' );
        $hero_subtitle = sprintf( esc_html__( 'For teksten "%s"', 'brimo' ), get_search_query() );

    } else if( is_category() ) {

    	$hero_height = 'medium';
        $hero_title = esc_html__( 'Kategori', 'brimo' );
        $hero_subtitle = sprintf( esc_html__( 'Innhold i kategorien "%s"', 'brimo' ), single_cat_title( '', false ) );

    } else if( is_tag() ) {

    	$hero_height = 'medium';
        $hero_title = esc_html__( 'Tag', 'brimo' );
        $hero_subtitle = sprintf( esc_html__( 'Innhold tagget med "%s"', 'brimo' ), single_tag_title( '', false ) );

    } else if( is_date() ) {

    	$hero_height = 'medium';
        $hero_title = esc_html__( 'Arkiv', 'brimo' );

        if ( is_day() ) {

            $hero_subtitle = sprintf( esc_html__( 'Innhold fra "%s"', 'brimo' ), get_the_date() );

        } else if ( is_month() ) {

            $hero_subtitle = sprintf( esc_html__( 'Innhold fra "%s"', 'brimo' ), get_the_date( 'F Y' ) );

        } else {

            $hero_subtitle = sprintf( esc_html__( 'Innhold fra "%s"', 'brimo' ), get_the_date( 'Y' ) );

        }

    } else if( is_author() ) {

    	$hero_height = 'medium';
        $hero_title = esc_html__( 'Forfatter', 'brimo' );
        $hero_subtitle = sprintf( esc_html__( 'Innhold fra "%s"', 'brimo' ), get_search_query() );

    } else if( is_home() ) {

		$hero_height = 'small';
        $hero_subtitle = '';

    } else if( is_single() ) {

        $hero_title = get_the_title();
        $hero_height = 'small';
		$hero_subtitle = '';


    } else if( is_page() ) {

        $hero_title = get_the_title();
        $hero_height = 'small';
        $hero_subtitle = '';

    } else if( is_404() ) {

    	$hero_title = '404';
        $hero_height = 'small';
        $hero_subtitle = 'OOPS! THAT PAGE CAN’T BE FOUND.';

   	}




	$hero_class = 'hero-' . $hero_height;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Passion+One:wght@400;700&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php body_class( $class=$hero_class ) ; ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="visually-hidden-focusable" href="#content"><?php esc_html_e( 'Hopp til innhold', 'brimo' ); ?></a>
    	<nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3">
    		<div class="container">
    		<?php if ( has_custom_logo() ) : ?>
    			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php the_custom_logo(); ?></a>
    		<?php else : ?>
    			<h1><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
    		<?php endif; ?>
    			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?php esc_html_e( 'Åpne meny', 'brimo' ) ; ?>">
    				<span class="navbar-toggler-icon"></span>
    			</button>
    			<div class="collapse navbar-collapse" id="main-menu">
                <div class="mx-auto"></div>
    			<?php
                    wp_nav_menu(array(
                        'theme_location' => 'main-menu',
                        'container' => false,
                        'menu_class' => '',
                        'fallback_cb' => '__return_false',
                        'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
                        'depth' => 2,
                        'walker' => new bootstrap_5_wp_nav_menu_walker()
                    ));
                ?>
                </div>
            </div>
        </nav>

        <div id="hero-image" class="hero-image d-flex justify-content-center align-items-center lazy-img" data-img="<?php echo $hero_img; ?>">
            <div class="container text-center">
        <?php
            if ( is_front_page() ) :
        ?>
                <h1 class="site-title text-white"><?php bloginfo( 'name' ); ?></h1>
        <?php

                $brimo_description = get_bloginfo( 'description', 'display' );

                if ( $brimo_description || is_customize_preview() ) :
        ?>
                <div class="site-description text-white"><div id="gps" class="btn-gps"><div id="gps-lat"><?php echo $brimo_description; ?></div></div></div>

            <?php
                endif;
            ?>

                <a href="#content" class="scroll-down"><i class="scroll-down-icon fa-4x fas fa-chevron-down" aria-hidden="true"></i></a>

        <?php
            else :
        ?>

                <h3 class="site-title text-white"><?php echo $hero_title; ?></h3>
                <div class="site-description text-white"><?php echo $hero_subtitle; ?></div>
                <a href="#content" class="scroll-down"><i class="scroll-down-icon fa-3x fas fa-chevron-down " aria-hidden="true"></i></a>

        <?php
            endif;
        ?>
            </div>
        </div>
	<?php
	if ( !brimo_is_frontpage()) {
	?>
		<div class="breadcrumbs border-bottom">
    <?php
    	if ( function_exists('yoast_breadcrumb') ) {
        	yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
    	}
    ?>
    	</div>
    <?php
	}
	?>
	<div id="content" class="site-content mt-5">
