<?php
/** Enqueue theme assets */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'nvs-style', get_stylesheet_uri(), [], filemtime( get_template_directory() . '/style.css' ) );
    wp_register_script( 'tvs-app', get_theme_file_uri( '/assets/tvs-app.js' ), [], false, true );

    // Load tvs-app only on single tvs_route
    if ( is_singular( 'tvs_route' ) ) {
        wp_enqueue_script( 'tvs-app' );
    }
} );
