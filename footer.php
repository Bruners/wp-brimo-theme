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

</div><!-- #page -->
<footer id="colophon" class="footer py-5 mt-5 bg-light site-footer">
    <div class="container">
        <?php get_template_part( 'template-parts/contact-form-large' ); ?>
    </div>
    <div class="container py-4">
        <div class="site-info px-4">
            <div class="row">
                <div class="col col-md-4 mb-3">
                    <?php echo brimo_get_theme_option('contact_form_adresse'); ?>
                </div>
                <div class="col col-md-8">
                    <?php
                        wp_nav_menu(array(
                            'theme_location'    => 'footer-menu',
                            'depth'             => 2,
                            'container'         => 'nav',
                            'container_class'   => 'navbar navbar-expand-lg navbar-light',
                            'menu_class'        => 'navbar-nav',
                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'            => new WP_Bootstrap_Navwalker()
                        ));
                    ?>
                </div>
            </div>
        </div><!-- .site-info -->
    </div>
</footer><!-- #colophon -->
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <?php dynamic_sidebar( 'footer-widgets' ); ?>
        <div class="text-center">
            <span class="small text-muted text-center">
            <span class="copyright d-block">
            <?php
            /* translators: %s: Copyright info */
            printf( esc_html__( 'Copyright &copy; Brimo Fiskeforedling 2020-%s', 'brimo' ), date('Y') );
            ?>
            </span>
            <span class="d-block">
                    <?php
                    /* translators: 1: Developed by. */
                    printf( esc_html__( 'Utviklet av: %1$s', 'brimo' ), '<a class="text-muted" href="http://github.com/bruners/">Lasse Brun</a>' );
                    ?>
            </span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
