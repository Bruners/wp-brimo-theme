<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package brimo
 */

if ( ! function_exists( 'brimo_body_classes' ) ) :
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function brimo_body_classes( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Adds a class of no-sidebar when there is no sidebar present.
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}
	add_filter( 'body_class', 'brimo_body_classes' );
endif;

if ( ! function_exists( 'brimo_pingback_header' ) ) :
	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function brimo_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}
	add_action( 'wp_head', 'brimo_pingback_header' );
endif;

if ( ! function_exists( 'brimo_disable_self_ping' ) ) :
	/**
	 * Stop self pingback
	 */
	function brimo_disable_self_ping( &$links ) {
		$home = get_option( 'home' );
		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, $home ) ) {
				unset($links[$l]);	
			}
		}
	}
	add_action( 'pre_ping', 'brimo_disable_self_ping' );
endif;


if ( ! function_exists( 'brimo_trim_words' ) ) :
	/**
	 * Allow links in the_excerpt
	 */
	function brimo_trim_words( $text, $num_words, $more, $original_text ) {
		$text = strip_tags( $original_text, '<a>' );
		// @See wp_trim_words in wp-includes/formatting.php
		if ( strpos( _x( 'words', 'Word count type. Do not translate!' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) ) {
			$text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
			preg_match_all( '/./u', $text, $words_array );
			$words_array = array_slice( $words_array[0], 0, $num_words + 1 );
			$sep = '';
		} else {
			$words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
			$sep = ' ';
		}
		if ( count( $words_array ) > $num_words ) {
			array_pop( $words_array );
			$text = implode( $sep, $words_array );
			$text = $text . $more;
		} else {
			$text = implode( $sep, $words_array );
		}
		// Remove self so we don't affect other functions that use wp_trim_words
		remove_filter( 'wp_trim_words', 'brimo_trim_words' );
		return $text;
	}
endif;

if ( ! function_exists( 'brimo_add_trim_words_filter' ) ) :
	/**
	 * Be sneaky: add our wp_trim_words filter during excerpt_more filter, which is called immediately prior
	 */ 
	function brimo_add_trim_words_filter( $excerpt_length ) {
		add_filter( 'wp_trim_words', 'brimo_trim_words', 10, 4 );
		return $excerpt_length;
	}
	add_filter( 'excerpt_more', 'brimo_add_trim_words_filter', 1 );
endif;

if ( ! function_exists( 'brimo_excerpt_more' ) ) :
	/**
	 * Filter the "read more" excerpt string link to the post.
	 *
	 * @param string $more "Read more" excerpt string.
	 * @return string (Maybe) modified "read more" excerpt string.
	 */
	function brimo_excerpt_more( $more ) {
	    if ( ! is_single() ) {
	        $more = sprintf( '<p class="text-right"><a class="btn btn-brimo" role="button" href="%1$s">%2$s</a></p>',
	            get_permalink( get_the_ID() ),
	            __( 'Les mer', 'brimo' )
	        );
	    }

	    return $more;
	}
	add_filter( 'excerpt_more', 'brimo_excerpt_more' );
endif;

if ( ! function_exists( 'brimo_custom_excerpt_length' ) ) :
	/**
	 * Filter the except length to 34 words.
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	function brimo_custom_excerpt_length( $length ) {
	    return 34;
	}
	add_filter( 'excerpt_length', 'brimo_custom_excerpt_length', 999 );
endif;

if ( ! function_exists( 'brimo_mailpoet_form_widget_post_process' ) ) :
	function brimo_mailpoet_form_widget_post_process( $form ) {
		$form = str_replace('mailpoet', 'brimo"', $form);
	}
	add_filter( 'mailpoet_form_widget_post_process' , 'brimo_mailpoet_form_widget_post_process' );
endif;

if ( ! function_exists( 'brimo_filter_login_head' ) ) :
	/**
	 * Add custom logo to login page
	 */
	function brimo_filter_login_head() {

	    if ( has_custom_logo() ) :

	        $image = wp_get_attachment_image_src( get_theme_mod( 'brimo_logo_color' ), 'thumbnail' );
	        ?>
	        <style type="text/css">
	            .login h1 a {
	                background-image: url(<?php echo esc_url( $image[0] ); ?>);
	                -webkit-background-size: <?php echo absint( $image[1] )?>px <?php echo absint( $image[2] ) ?>px;
	                background-size: <?php echo absint( $image[1] ) ?>px <?php echo absint( $image[2] ) ?>px;
	                height: 56px;
	                width: 130px;
	            }
	        </style>
	        <?php
	    endif;
	}

	add_action( 'login_head', 'brimo_filter_login_head', 100 );
endif;

if ( ! function_exists( 'brimo_new_wp_login_url' ) ) :
	/**
	 * Set login page url to home url
	 */
	function brimo_new_wp_login_url() {
	    return home_url();
	}
	add_filter('login_headerurl', 'brimo_new_wp_login_url');
endif;

if ( ! function_exists( 'brimo_send_contact_form_site_admin' ) ) :
	/**
	 * Send contact form data with ajax
	 */
	function brimo_send_contact_form_site_admin() {
	    try {

	        if (empty($_POST['message_name']) || empty($_POST['message_email']) || empty($_POST['message_text']) || empty($_POST['message_human'])) {
	            throw new Exception('Bad form parameters. Check the markup to make sure you are naming the inputs correctly.');
	        }

	        if (!is_email($_POST['message_email'])) {

	            throw new Exception('Eposten er ikke formatert riktig');

	        }

	        // Get email from theme options or use admin email
	        $email_to = brimo_get_theme_option('contact_form_emailto') != '' ? brimo_get_theme_option('contact_form_emailto') : get_option('admin_email');
	        $site_name = get_option( 'blogname' );
	        $site_url = site_url();
	        $site_domain = str_ireplace('www.', '', parse_url($site_url, PHP_URL_HOST));

	        $subject = "Kontaktskjema " . $site_domain . ": " . $_POST['message_name'];
	        $message = "Melding til: " . $email_to . "\r\nMelding fra: ". $_POST['message_name'] . " - " . $_POST['message_email'] . "\n\n" . $_POST['message_text'] . "\r\n\r\n" . "--" . "\r\n" . "This e-mail was sent from a contact form on " . $site_name  . " (" . $site_url . ")";
	        $headers = "From: ". $_POST['message_name'] . " <kontakt@" . $site_domain . ">" . "\r\n" . "Reply-To: " . $_POST['message_email'] . "\r\n";

	        if (wp_mail($email_to, $subject, $message, $headers)) {

	            echo json_encode(array('status' => 'success', 'message' => 'Contact message sent.'));
	            exit;

	        } else {

	            throw new Exception('Failed to send email. Check AJAX handler.');

	        }

	   	} catch (Exception $e) {

	        echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
	        exit;

	    }
	}
	add_action("wp_ajax_contact_send", "brimo_send_contact_form_site_admin");
	add_action("wp_ajax_nopriv_contact_send", "brimo_send_contact_form_site_admin");
endif;

if ( ! function_exists( 'brimo_comment_form' ) ) :
	/**
	 * Comment Button
	 */
	function brimo_comment_form( $args ) {

	    $args['class_submit'] = 'btn btn-outline-brimo';
	    return $args;

	}
	add_filter( 'comment_form_defaults', 'brimo_comment_form' );
endif;

if ( ! function_exists( 'brimo_comment_links_rel_target' ) ) :
	/**
	 * Apply rel=ugc nofollow on user generated comment links
	 */
    function brimo_comment_links_rel_target($text) {
        return str_replace('<a', '<a rel=”ugc nofollow”', $text);
    }
    add_filter('comment_text', 'brimo_comment_links_rel_target');
endif;



if ( ! function_exists( 'brimo_remove_jquery_migrate' ) ) :
	/**
	 * Remove JQuery migrate
	 */
	function brimo_remove_jquery_migrate( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {

	    	$script = $scripts->registered['jquery'];

	   		if ( $script->deps ) {
				// Check whether the script has any dependencies
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
	 		}
	 	}
	 }
	add_action( 'wp_default_scripts', 'brimo_remove_jquery_migrate' );
endif;
