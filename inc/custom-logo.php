<?php

/**
 * Implementation of a custom logo
 * @package brimo
 */

//adding setting for copyright text
add_action('customize_register', 'brimo_custom_logo_setup');

function brimo_custom_logo_setup($wp_customize) {
    //adding section in wordpress customizer   
    $wp_customize->add_section(
        'brimo_logo_section',
        array(
            'title'    => __( 'Theme logo', 'brimo' ),
            'priority' => 30
        )
    );

    //adding setting for copyright text
    $wp_customize->add_setting(
        'brimo_logo_white',
        array(
            'default' => '',
        )
    );

    $wp_customize->add_setting(
        'brimo_logo_color',
        array(
            'default' => '',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            'brimo_logo_white',
            array(
                'label'    => __( 'Last opp logo i hvit', 'brimo' ),
                'section'  => 'brimo_logo_section',
                'width'    => 130,
                'height'   => 55
            )
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            'brimo_logo_color',
            array(
                'label'    => __( 'Last opp logo med farger', 'brimo' ),
                'section'  => 'brimo_logo_section',
                'width'    => 130,
                'height'   => 55
            )
        )
    );
}


if ( ! function_exists( 'brimo_get_logo_white_url' ) ) :

    function brimo_get_logo_white_url() {
        $white_logo_id = get_theme_mod('brimo_logo_white');

        if ($white_logo_id != 0)  {
            $url = wp_get_attachment_url($white_logo_id);

            return $url;
        }
    }

endif;

if ( ! function_exists( 'brimo_get_logo_white_meta' ) ) :

    function brimo_get_logo_white_meta($class_names = "d-inline-block align-text-top") {
        $white_logo_id = get_theme_mod('brimo_logo_white');
        $class = $class_names;

        if ($white_logo_id != 0) {
            $url = wp_get_attachment_url($white_logo_id);
            $image = wp_get_attachment_image_src( $white_logo_id, 'full');
            echo '<img id="logo_white" src="' . $image[0] . '" alt="logo" width="' . $image[1] . '" height="' . $image[2] . '" class="' . $class . '">';
        }
    }
endif;

if ( ! function_exists( 'brimo_get_logo_color_url' ) ) :

    function brimo_get_logo_color_url() {
        $color_logo_id = get_theme_mod('brimo_logo_color');

        if ($color_logo_id != 0)  {
            $url = wp_get_attachment_url($color_logo_id);

            return $url;
        }
    }

endif;

if ( ! function_exists( 'brimo_get_logo_color_meta' ) ) :

    function brimo_get_logo_color_meta($class_names = "d-inline-block align-text-top") {
        $color_logo_id = get_theme_mod('brimo_logo_color');
        $class = $class_names;

        if ($color_logo_id != 0) {
            $url = wp_get_attachment_url($color_logo_id);
            $image = wp_get_attachment_image_src( $color_logo_id, 'full');
            echo '<img id="logo_color" src="' . $image[0] . '" alt="logo" width="' . $image[1] . '" height="' . $image[2] . '" class="' . $class . '">';
        }
    }

endif;

