<?php
/** Enqueue theme assets */
add_action( 'wp_enqueue_scripts', function() {
    $style_path = get_template_directory() . '/style.css';
    $style_uri  = get_stylesheet_uri();
    $style_ver  = file_exists( $style_path ) ? filemtime( $style_path ) : null;

    wp_enqueue_style( 'nvs-style', $style_uri, array(), $style_ver );

    $tvs_asset_path = get_template_directory() . '/assets/tvs-app.js';
    $tvs_asset_uri  = get_theme_file_uri( '/assets/tvs-app.js' );
    $tvs_version    = file_exists( $tvs_asset_path ) ? filemtime( $tvs_asset_path ) : null;

    if ( file_exists( $tvs_asset_path ) ) {
        wp_register_script( 'tvs-app', $tvs_asset_uri, array(), $tvs_version, true );

        // Load tvs-app only on single tvs_route (ensure CPT slug matches)
        if ( is_singular( 'tvs_route' ) ) {
            wp_enqueue_script( 'tvs-app' );
        }
    }
} );
