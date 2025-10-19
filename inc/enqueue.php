<?php
/** Enqueue theme assets */
add_action( 'wp_enqueue_scripts', function() {
    // 1) Hoved-stylesheet (style.css) – versjoneres med filemtime
    $style_path = get_template_directory() . '/style.css';
    $style_ver  = file_exists( $style_path ) ? filemtime( $style_path ) : wp_get_theme()->get( 'Version' );
    wp_enqueue_style( 'nvs-style', get_stylesheet_uri(), [], $style_ver );

    // 2) Registrer app-ressurser (JS/CSS) – lastes kun der vi trenger dem
    $theme      = wp_get_theme();
    $app_js_rel = 'assets/tvs-app.js';
    $app_css_rel= 'assets/tvs-app.css';
    $app_js_abs = get_template_directory() . '/' . $app_js_rel;
    $app_css_abs= get_template_directory() . '/' . $app_css_rel;

    if ( file_exists( $app_js_abs ) ) {
        // Registrer med korrekt avhengighet slik at React fra WP lastes (wp-element)
        wp_register_script(
            'tvs-app',
            get_theme_file_uri( $app_js_rel ),
            [ 'wp-element' ],
            filemtime( $app_js_abs ),
            true
        );

        // Dev/konfig inn i JS (gjør dette etter register, før enqueue)
        wp_localize_script( 'tvs-app', 'TVS_SETTINGS', [
            'env'      => ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? 'development' : 'production',
            'restRoot' => get_rest_url(),
            'version'  => $theme->get( 'Version' ),
            'user'     => is_user_logged_in() ? wp_get_current_user()->user_login : null,
        ] );
    }

    if ( file_exists( $app_css_abs ) ) {
        wp_register_style(
            'tvs-app-style',
            get_theme_file_uri( $app_css_rel ),
            [],
            filemtime( $app_css_abs )
        );
    }

    // 3) Last app bare på single tvs_route
    if ( is_singular( 'tvs_route' ) ) {
        if ( wp_script_is( 'tvs-app', 'registered' ) ) {
            wp_enqueue_script( 'tvs-app' );
        }
        if ( wp_style_is( 'tvs-app-style', 'registered' ) ) {
            wp_enqueue_style( 'tvs-app-style' );
        }
    }
} );
