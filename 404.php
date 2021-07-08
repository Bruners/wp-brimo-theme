<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package brimo
 */

get_header();
?>


	<main id="main" class="site-main">
		<div class="container">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! Siden finnes ikke', 'brimo' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'Siden du leter etter er enten flyttet eller eksisterer ikke lenger. Prøv et søk, eller sjekk ut linkene under', 'brimo' ); ?></p>

					<section class="section widget widget-search" aria-label="<?php esc_html__( 'Search', 'woocommerce' ); ?>">	
					<?php
					if ( brimo_is_woocommerce_activated() ) {
						the_widget( 'WC_Widget_Product_Search' );
					} else {
						get_search_form();
					}

					?>
					</section>

					<section class="section widget widget-categories" aria-label="<?php esc_html__( 'Kategorier', 'brimo' ); ?>">

					<?php
					if ( brimo_is_woocommerce_activated() ) { 
					?>
						<nav aria-label="<?php esc_html__( 'Produktkategorier', 'brimo' ); ?>">
							<h2 class="widget-title"><?php esc_html__( 'Produktkategorier', 'brimo' ); ?></h2>
							<?php
								the_widget(
									'WC_Widget_Product_Categories',
									array(
										'count' => 1,
									)
								);
							?>

						</nav>

					<?php } else {	?>

						<nav aria-label="<?php esc_html__( 'Mest brukte kategorier', 'brimo' ); ?>">
							<h2 class="widget-title"><?php esc_html_e( 'Mest brukte kategorier', 'brimo' ); ?></h2>
							<ul class="list-unstyled">
								<?php
								wp_list_categories( array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								) );
								?>
							</ul>
						</nav>

					<?php } ?>
					</section><!-- .widget-categories -->
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</div>
	</main><!-- #main -->


<?php
get_footer();
