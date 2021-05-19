<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package brimo
 */

?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container text-center">
            <div class="site-info">
                <a href="<?php echo esc_url( __( 'https://www.brimo.as', 'brimo' ) ); ?>">
                <?php
                /* translators: %s: Copyright info */
                    printf( esc_html__( 'Copyright &copy; Brimo Fiskeforedling 2020-%s', 'brimo' ), date('Y') );
                ?>
                </a>
                <span class="sep"> | </span>
                    <?php
                    /* translators: 1: Developed by. */
                    printf( esc_html__( 'Utviklet av: %1$s', 'brimo' ), '<a href="http://github.com/bruners/">Lasse Brun</a>' );
                    ?>
            </div><!-- .site-info -->
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
