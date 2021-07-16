<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists('Brimo_Theme_Options')) {
    class Brimo_Theme_Options
    {
        /**
         * Start up
         */
        public function __construct()
        {
            if ( is_admin() ) {
                add_action( 'admin_menu', array( 'Brimo_Theme_Options', 'brimo_theme_menu_items' ) );
                add_action( 'admin_init', array( 'Brimo_Theme_Options', 'brimo_theme_settings' ) );

                // Register and Enqueue Backend CSS
                add_action('admin_enqueue_scripts', 'brimo_backend_styles');
            }
        }

        /**
         * Get All theme options
         */
        public static function get_theme_options() {
            return get_option( 'theme_options' );
        }

        /**
         * Returns single theme option
         */
        public static function get_theme_option( $id ) {
            $options = self::get_theme_options();
            if ( isset( $options[$id] ) ) {
                return $options[$id];
            }
        }

        /**
         * Add options page
         */
        public static function brimo_theme_menu_items() {
            add_menu_page(
                esc_html__( 'Theme-Instillinger', 'brimo' ),
                esc_html__( 'Theme-Instillinger', 'brimo' ),
                'manage_options',
                'theme-settings',
                array( 'Brimo_Theme_Options', 'settings_page' )
            );
        }

        /**
         * Register a setting and its sanitization callback.
         *
         * We are only registering 1 setting so we can store all options in a single option as
         * an array. You could, however, register a new setting for each option
         */
        public static function brimo_theme_settings() {
            register_setting( 'theme_options', 'theme_options', array( 'Brimo_Theme_Options', 'sanitize' ) );
        }

        /**
         * Sanitization callback
         */
        public static function sanitize( $options ) {

            // If we have options lets sanitize them
            if ( $options ) {

                // social_share_buttons
                if ( ! empty( $options['social_share_buttons'] ) ) {
                    $options['social_share_buttons'] = 'on';
                } else {
                    unset( $options['social_share_buttons'] ); // Remove from options if not checked
                }

                // social_share_facebook_button
                if ( ! empty( $options['social_share_facebook_button'] ) ) {
                    $options['social_share_facebook_button'] = 'on';
                } else {
                    unset( $options['social_share_facebook_button'] ); // Remove from options if not checked
                }

                // social_share_twitter_button
                if ( ! empty( $options['social_share_twitter_button'] ) ) {
                    $options['social_share_twitter_button'] = 'on';
                } else {
                    unset( $options['social_share_twitter_button'] ); // Remove from options if not checked
                }

                // social_share_facebook_profile
                if ( ! empty( $options['social_share_facebook_profile'] ) ) {
                    $options['social_share_facebook_profile'] = sanitize_text_field( $options['social_share_facebook_profile'] );
                } else {
                    unset( $options['social_share_facebook_profile'] ); // Remove from options if empty
                }

                // social_share_youtube_profile
                if ( ! empty( $options['social_share_youtube_profile'] ) ) {
                    $options['social_share_youtube_profile'] = sanitize_text_field( $options['social_share_youtube_profile'] );
                } else {
                    unset( $options['social_share_youtube_profile'] ); // Remove from options if empty
                }

                // social_share_instagram_profile
                if ( ! empty( $options['social_share_instagram_profile'] ) ) {
                    $options['social_share_instagram_profile'] = sanitize_text_field( $options['social_share_instagram_profile'] );
                } else {
                    unset( $options['social_share_instagram_profile'] ); // Remove from options if empty
                }

                // social_share_twitter_profile
                if ( ! empty( $options['social_share_twitter_profile'] ) ) {
                    $options['social_share_twitter_profile'] = sanitize_text_field( $options['social_share_twitter_profile'] );
                } else {
                    unset( $options['social_share_twitter_profile'] ); // Remove from options if empty
                }

                // google_maps_lonlat
                if ( ! empty( $options['google_maps_lonlat'] ) ) {
                    $options['google_maps_lonlat'] = sanitize_text_field( $options['google_maps_lonlat'] );
                } else {
                    unset( $options['google_maps_lonlat'] ); // Remove from options if empty
                }

                // google_maps_zoom
                if ( ! empty( $options['google_maps_zoom'] ) ) {
                    $options['google_maps_zoom'] = sanitize_text_field( $options['google_maps_zoom'] );
                } else {
                    unset( $options['google_maps_zoom'] ); // Remove from options if empty
                }

                // google_maps_api_key
                if ( ! empty( $options['google_maps_api_key'] ) ) {
                    $options['google_maps_api_key'] = sanitize_text_field( $options['google_maps_api_key'] );
                } else {
                    unset( $options['google_maps_api_key'] ); // Remove from options if empty
                }


                // contact_form_emailto
                if ( ! empty( $options['contact_form_emailto'] ) ) {
                    $options['contact_form_emailto'] = sanitize_email( $options['contact_form_emailto'] );
                } else {
                    unset( $options['contact_form_emailto'] ); // Remove from options if empty
                }

                // contact_widget_placement
                if ( ! empty( $options['contact_widget_placement'] ) ) {
                    $options['contact_widget_placement'] = sanitize_text_field( $options['contact_widget_placement'] );
                }

                // contact_form_logo
                if ( ! empty( $options['contact_form_logo'] ) ) {
                    $options['contact_form_logo'] = sanitize_text_field( $options['contact_form_logo'] );
                } else {
                    unset( $options['contact_form_logo'] ); // Remove from options if empty
                }

                // contact_form_adresse
                if ( ! empty( $options['contact_form_adresse'] ) ) {
                    $options['contact_form_adresse'] = wp_kses_post( $options['contact_form_adresse'] );
                } else {
                    unset( $options['contact_form_adresse'] ); // Remove from options if empty
                }

                // gdpr_facebook_pixel
                if ( ! empty( $options['gdpr_facebook_pixel'] ) ) {
                    $options['gdpr_facebook_pixel'] = sanitize_text_field( $options['gdpr_facebook_pixel'] );
                } else {
                    unset( $options['gdpr_facebook_pixel'] ); // Remove from options if empty
                }

                // gdpr_google_analytics
                if ( ! empty( $options['gdpr_google_analytics'] ) ) {
                    $options['gdpr_google_analytics'] = sanitize_text_field( $options['gdpr_google_analytics'] );
                } else {
                    unset( $options['gdpr_google_analytics'] ); // Remove from options if empty
                }

                // google_display_features
                if ( ! empty( $options['google_display_features'] ) ) {
                    $options['google_display_features'] = 'on';
                } else {
                    unset( $options['google_display_features'] ); // Remove from options if not checked
                }

                // google_anonymize_ip_addresses
                if ( ! empty( $options['google_anonymize_ip_addresses'] ) ) {
                    $options['google_anonymize_ip_addresses'] = 'on';
                } else {
                    unset( $options['google_anonymize_ip_addresses'] ); // Remove from options if not checked
                }

            }

            // Return sanitized options
            return $options;

        }

        /**
         * Options page callback
         */
        public static function settings_page() { ?>

            <div class="wrap">

                <h1><?php esc_html_e( 'Instillinger Brimo Fiskeforedling wordpress theme', 'brimo' ) ?></h1>

                <form method="post" action="options.php">

                    <?php settings_fields( 'theme_options' ); ?>

                    <h2><?php esc_html_e( 'Deleknapper', 'brimo' ); ?></h2>
                    <p><?php esc_html_e( 'Aktiver deleknapper for sosiale medier vist i poster og på sider:', 'brimo' ); ?></p>

                    <div class="sb-social-icon">
                        <h5 class="sb-title"><?php esc_html_e( 'Del dette:', 'brimo' ); ?></h5>
                        <div class="sb-content">
                            <ul>
                                <li><a href="http://www.facebook.com/sharer.php?u=<?php esc_html_e(site_url()); ?>" rel="nofollow" class="fab fa-facebook" target="_blank" title="' . $text_facebook . '"><span class="visually-hidden-focusable"><?php esc_html_e('Klikk for å dele på Facebook', 'brimo' ); ?></span></a></li>
                                <li><a href="https://twitter.com/share?url=<?php esc_html_e(site_url()); ?>" rel="nofollow" class="fab fa-twitter" target="_blank" title="' . $text_twitter . '"><span class="visually-hidden-focusable"><?php esc_html_e( 'Klikk for å dele på Twitter', 'brimo' ); ?></span></a></li><li class="share-end"></li>
                            </ul>
                        </div>
                    </div>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e( 'Aktiver deleknapper?', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'social_share_buttons' ); ?>
                                <input type="checkbox" id="socialShareButtons" name="theme_options[social_share_buttons]" <?php checked( $value, 'on' ); ?>>
                            </td>
                        </tr>

                        <tr>
                            <th><?php esc_html_e( 'Vis deleknapp for Facebook?', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'social_share_facebook_button' ); ?>
                                <input type="checkbox" id="socialShareFacebookButton" name="theme_options[social_share_facebook_button]" <?php checked( $value, 'on' ); ?>>
                            </td>
                        </tr>

                        <tr>
                            <th><?php esc_html_e( 'Vis deleknapp for Twitter?', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'social_share_twitter_button' ); ?>
                                <input type="checkbox" id="socialShareTwitterButton" name="theme_options[social_share_twitter_button]" <?php checked( $value, 'on' ); ?>>
                            </td>
                        </tr>
                    </table>

                    <h2><?php esc_html_e( 'Profiler' ); ?></h2>
                    <p><?php esc_html_e( 'Profiler på sosial medier som skal vises på siden, tomme felt blir deaktivert:', 'brimo' ); ?></p>
                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e( 'Facebook profil:', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'social_share_facebook_profile' ); ?>
                                <input class="form-control" type="text" id="socialShareFacebookProfile" name="theme_options[social_share_facebook_profile]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Youtube profil:', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'social_share_youtube_profile' ); ?>
                                <input class="form-control" type="text" id="socialShareYoutubeProfile" name="theme_options[social_share_youtube_profile]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Instagram profil:', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'social_share_instagram_profile' ); ?>
                                <input class="form-control" type="text" id="socialShareInstagramProfile" name="theme_options[social_share_instagram_profile]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Twitter profil:', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'social_share_twitter_profile' ); ?>
                                <input class="form-control" type="text" id="socialShareTwitterProfile" name="theme_options[social_share_twitter_profile]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                    </table>

                    <h2><?php esc_html_e( 'Goole Maps' ); ?></h2>
                    <p><?php esc_html_e( 'Metadata til google maps: 66.908926, 13.604680', 'brimo' ); ?></p>

                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e( 'Longitude og Latitude:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'google_maps_lonlat' ); ?>
                                <input class="form-control" type="text" id="googleMapsLonLat" name="theme_options[google_maps_lonlat]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Map zoom:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'google_maps_zoom' ); ?>
                                <input class="form-control" type="text" id="googleMapsZoom" name="theme_options[google_maps_zoom]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Google Maps Api Key:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'google_maps_api_key' ); ?>
                                <input class="form-control" type="text" id="googleMapsApiKey" name="theme_options[google_maps_api_key]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                    </table>

                    <h2><?php esc_html_e( 'Kontaktskjema' ); ?></h2>
                    <p><?php esc_html_e( 'Metadata til kontakskjema', 'brimo' ); ?></p>

                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e( 'Send epost til:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'contact_form_emailto' ); ?>
                                <input class="form-control" type="text" id="contactFormEmailTo" name="theme_options[contact_form_emailto]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Widget plassering ved kontakskjema:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'contact_widget_placement' ); ?>
                                <select class="form-select" id="contactWidgePlacement" name="theme_options[contact_widget_placement]" aria-label="<?php esc_html_e( 'Widget plassering', 'brimo' ); ?>">
                                    <?php
                                    $options = array(
                                        '1' => esc_html__( 'Sist', 'brimo' ),
                                        '2' => esc_html__( 'Først', 'brimo' ),
                                    );

                                    foreach ( $options as $id => $label ) { ?>

                                        <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
                                            <?php echo strip_tags( $label ); ?>
                                        </option>

                                    <?php } ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th><?php esc_html_e( 'Logo til kontaktskjema:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'contact_form_logo' ); ?>
                                <input class="form-control" type="text" id="contactFormLogo" name="theme_options[contact_form_logo]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Adresse kontakskjema:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'contact_form_adresse' ); ?>
                                <textarea class="form-control" id="contacFormAdresse" name="theme_options[contact_form_adresse]" rows="5"><?php echo esc_attr( $value ); ?></textarea>
                            </td>
                        </tr>
                    </table>

                    <h2><?php esc_html_e( 'GDPR' ); ?></h2>
                    <p><?php esc_html_e( 'ID for Google Analytics og Facebook pixel', 'brimo' ); ?></p>

                    <table class="form-table">
                        <tr>
                            <th><?php esc_html_e( 'Facebook Pixel ID:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'gdpr_facebook_pixel' ); ?>
                                <input class="form-control" type="text" id="gdprFacebookPixel" name="theme_options[gdpr_facebook_pixel]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Google Analytics ID:', 'brimo' ); ?>
                            <td>
                                <?php $value = self::get_theme_option( 'gdpr_google_analytics' ); ?>
                                <input class="form-control" type="text" id="gdrpGoogleAnalytics" name="theme_options[gdpr_google_analytics]" value="<?php echo esc_attr( $value ); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Aktiver demografi- og interesserapporter for remarketing og annonsering', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'google_display_features' ); ?>
                                <input type="checkbox" id="googleDisplayFeatures" name="theme_options[google_display_features]" <?php checked( $value, 'on' ); ?>> <?php echo __( '<a href="https://support.google.com/analytics/answer/2444872?hl=en_US" target="_blank">Read More</a>', 'brimo' ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Anonymize IP Addresses', 'brimo' ); ?></th>
                            <td>
                                <?php $value = self::get_theme_option( 'google_anonymize_ip_addresses' ); ?>
                                <input type="checkbox" id="googleAnonymizeIpAddresses" name="theme_options[google_anonymize_ip_addresses]" <?php checked( $value, 'on' ); ?>> <?php echo __( '<a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/ip-anonymization" target="_blank">Read More</a>', 'brimo' ); ?>
                            </td>
                        </tr>
                    </table>

                    <?php submit_button(); ?>

                </form>
            </div>
        <?php
        }
    }
}
new Brimo_Theme_Options();

function brimo_get_theme_option( $id = '' ) {
    return Brimo_Theme_Options::get_theme_option( $id );
}

// Function to display share icons
function add_social_share_icons()
{
    $buttons = brimo_get_theme_option('social_share_buttons');
    $facebook = brimo_get_theme_option('social_share_facebook_button');
    $twitter = brimo_get_theme_option('social_share_twitter_button');

    $text_share = __('Del dette:', 'brimo');
    $text_facebook = __(  'Klikk for å dele på Facebook', 'brimo' );
    $text_googleplus = __(  'Klikk for å dele på Google+', 'brimo' );
    $text_twitter = __(  'Klikk for å dele på Twitter', 'brimo' );

    if ($buttons == 'on') {
        $html = "<div class='sb-social-icon'><h5 class='sb-title'>" . $text_share . "</h5><div class='sb-content'><ul>";

        global $post;

        $url = get_permalink($post->ID);
        $url = esc_url($url);

        if($facebook == 'on')
        {
            $html = $html . "<li><a href='http://www.facebook.com/sharer.php?u=" . $url . "' rel='nofollow' class='fab fa-facebook' target='_blank' title='" . $text_facebook . "'><span class='visually-hidden-focusable'>" . $text_facebook . "</span></a></li>";
        }

        if($twitter == 'on')
        {
            $html = $html . "<li><a href='https://twitter.com/share?url=" . $url . "' rel='nofollow' class='fab fa-twitter' target='_blank' title='" . $text_twitter . "'><span class='visually-hidden-focusable'>" . $text_twitter . "</span></a></li>";
        }


        $html = $html . "<li class='share-end'></li></ul></div></div>";

        echo $html;
    }
}
