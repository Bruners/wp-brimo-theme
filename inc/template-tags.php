<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package brimo
 */

/**
 * Checks to see if we're on the front page or not.
 */
function brimo_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

if ( ! function_exists( 'brimo_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function brimo_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Skrevet %s', 'post date', 'brimo' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'brimo_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function brimo_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'av %s', 'post author', 'brimo' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'brimo_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function brimo_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'brimo' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'I kategorien %1$s', 'wordpress' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'brimo' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagget %1$s', 'brimo' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Legg igjen en kommentar<span class="visually-hidden"> på %s</span>', 'brimo' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="visually-hidden">%s</span>', 'brimo' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'brimo_comments' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function brimo_comments() {


		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo ' | <i class="far fa-comments"></i> <span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Skriv en kommentar', 'brimo' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
	
	}
endif;

if ( ! function_exists( 'brimo_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function brimo_post_thumbnail($classes = '') {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		$class = $classes;

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
			<?php
				the_post_thumbnail('medium_large', ['class' => 'img-fluid ' . $class ]);
			?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'medium_large', array(
				'class' => 'img-fluid ' . $class,
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'brimo_bs_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post with Bootstrap 5 markup.
	 */
	function brimo_bs_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav aria-label="<?php esc_html_e( 'Sidenavigasjon', 'brimo' ); ?>">
			<ul class="pagination pagination-lg">
				<?php
				if ( get_previous_post_link() ) {
					previous_post_link( '<li class="bs-page-item page-item">%link</li>', _x( '<span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>%title', 'Forrige innlegg', 'brimo' ) );
				}
				if ( get_next_post_link() ) {
					next_post_link( '<li class="bs-page-item page-item">%link</li>', _x( '%title <span aria-hidden="true"><i class="fas fa-chevron-right"></i></i></span>', 'Neste innlegg', 'brimo' ) );
				}
				?>
		  	</ul>
		</nav><!-- .pagination -->
		<?php
	}
}
