<?php
/*

Template Name: Brimo front

*/

// Latest news string
$news_header = esc_html__('Siste nytt', 'brimo');
// Number of posts to display on front page
$news_posts = 3;

get_header();
?>

<main id="main" class="site-main">
	<div class="container">
		<header class="news-header">
				<h2><?php echo $news_header; ?></h2>
		</header><!-- .entry-header -->

		<div class="last-posts mb-5">
			<div class="row row-cols-1 row-cols-md-3 g-4">
		<?php
			// Define our WP Query Parameters
			$the_query = new WP_Query( 'posts_per_page=' . $news_posts );

			// Start our WP Query
			while ($the_query -> have_posts()) : $the_query -> the_post();

			// Display the Post Title with Hyperlink
			?>

  				<div class="col mb-2">
    				<div class="card">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail('
							woocommerce_thumbnail',
							[
								'class' => 'card-img-top img-fluid',
								'loading' => 'lazy'
							]
						);
					} 
					?>
      					<div class="card-body">
        					<h5 class="card-title"><?php the_title(); ?></h5>
        					<p class="card-text"><?php the_excerpt(__('Les mer...')); ?></p>
      					</div>
    				</div>
  				</div>


		<?php
			// Repeat the process and reset once it hits the limit
			endwhile;
			wp_reset_postdata();
		?>
			</div>
		</div>

		<div class="produkter-pop mb-5">
			<?php dynamic_sidebar( 'product-widget' ); ?>
		</div>
	<?php
	while ( have_posts() ) :
		the_post();
	?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php brimo_post_thumbnail(); ?>

			<div class="entry-content">
				<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'brimo' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php
				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'brimo' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
				?>
				<?php if ( function_exists( 'add_social_share_icons' ) ) { echo add_social_share_icons(); } ?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
		</article><!-- #post-<?php the_ID(); ?> -->

	<?php

	endwhile; // End of the loop.
	wp_reset_postdata();
	?>
	<?php get_sidebar(); ?>
	</div><!-- .container -->
</main><!-- #main -->

<?php
get_sidebar();
get_footer();


