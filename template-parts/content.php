<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package brimo
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card mb-3">
  		<div class="row g-0">
    		<div class="col-md-4">
    			<?php brimo_post_thumbnail('img-fluid rounded-start'); ?>
    		</div>
    		<div class="col-md-8">
      			<div class="card-body">

      				<?php if ( function_exists( 'add_social_share_icons' ) ) {
      					echo '<div class="float-end">';
      					echo add_social_share_icons();
      					echo '</div>';
      				} ?>

        			<?php
	        			if ( is_singular() ) :
							the_title( '<h4 class="card-title entry-header">', '</h4>' );
						else :
							the_title( '<h5 class="card-title entry-header"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
						endif;
					?>
					<?php if ( 'post' === get_post_type() ) : ?>

        			<h6 class="card-subtitle entry-meta mb-0 text-muted">

							<?php
								brimo_posted_on();
								brimo_posted_by();
							?>

        			</h6><!-- .entry-meta -->
        			<span class="card-subtitle entry-footer mt-1 mb-2 text-muted"><?php brimo_entry_footer(); ?></span>

        			<?php endif; ?>

        			<p class="card-text entry-content">

						<?php
						the_content( sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="visually-hidden"> "%s"</span>', 'brimo' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post( get_the_title() )
						) );

						
						?>

        			</p> <!-- .entry-content -->
        		
        		<?php
				  	wp_link_pages( array(
						'before' => '<div class="page-links card-link">' . esc_html__( 'Pages:', 'brimo' ),
						'after'  => '</div>',
					) );
				?>
      			</div>
      			
    		</div>
  		</div>
  	</div>

</article><!-- #post-<?php the_ID(); ?> -->
