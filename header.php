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
        <style>
            /* latin */
            @font-face {
              font-family: 'Oswald';
              font-display: auto;
              font-style: normal;
              font-weight: 400;
              src: url(https://fonts.gstatic.com/s/oswald/v24/TK3_WkUHHAIjg75cFRf3bXL8LICs1_FvsUZiZQ.woff2) format('woff2');
              unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
        </style>
	<?php wp_head(); ?>
</head>
<body <?php body_class( $class=$hero_class ) ; ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Hopp til innhold', 'brimo' ); ?></a>

	<header id="masthead" class="site-header">
		<div id="logo" class="site-branding">
		<?php if ( has_custom_logo() ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php the_custom_logo(); ?></a>
		<?php else : ?>
			<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php endif; ?>
		</div>
		<?php
		wp_nav_menu( array(
			'theme_location' 	=> 'menu-1',
			'menu_id'        	=> 'primary-menu',
			'menu_class'	 	=> 'primary-menu',
			'container'		 	=> 'nav',
			'container_class' 	=> 'nav-menu-container',
			'container_id'		=> 'primary-nav'
		) );
		?>
		<div id="menu-toggle"><i class="fa fa-bars"></i></div>
	</header>
	<section class="hero">
		<div class="hero-inner">
			<div class="hero-overlay"></div>
			<div class="hero-image lazy-img" data-img="<?php echo $hero_img; ?>">
				<div class="hero-container">
					<div class="hero-content">
				<?php
					if ( is_front_page() ) :
				?>
						<h2 class="site-title"><?php bloginfo( 'name' ); ?></h2>
				<?php

						$brimo_description = get_bloginfo( 'description', 'display' );

						if ( $brimo_description || is_customize_preview() ) :
				?>
						<div class="site-description"><div id="gps" class="btn-gps"><div id="gps-lat"><?php echo $brimo_description; ?></div></div></div>
						<a href="#content" class="scroll-down"><i class="scroll-down-icon fa-4x fas fa-chevron-down" aria-hidden="true"></i></a>
				<?php
						endif;

					else :
				?>
						<h3 class="site-title"><?php echo $hero_title; ?></h3>
						<div class="site-description"><?php echo $hero_subtitle; ?></div>
						<a href="#content" class="scroll-down"><i class="scroll-down-icon fa-3x fas fa-chevron-down" aria-hidden="true"></i></a>

				<?php

					endif;

				?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	if ( brimo_is_frontpage()) {
		get_template_part( 'template-parts/tidal' ,'ticker' );
	} else {
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
