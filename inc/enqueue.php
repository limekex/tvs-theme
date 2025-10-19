<?php
/** Enqueue theme assets */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'nvs-style', get_stylesheet_uri(), [], filemtime( get_template_directory() . '/style.css' ) );
    $theme = wp_get_theme();

	wp_register_script(
		'tvs-app',
		get_theme_file_uri('assets/tvs-app.js'),
		[ 'wp-element' ], // bruker React fra WP
		$theme->get('Version'),
		true
	);

	// Dev/konfig inn i JS
	wp_localize_script('tvs-app', 'TVS_SETTINGS', [
		'env'      => ( defined('WP_DEBUG') && WP_DEBUG ) ? 'development' : 'production',
		'restRoot' => get_rest_url(),
		'version'  => $theme->get('Version'),
		'user'     => is_user_logged_in() ? wp_get_current_user()->user_login : null,
	]);

	wp_register_style(
		'tvs-app-style',
		get_theme_file_uri('assets/tvs-app.css'),
		[],
		$theme->get('Version')
	);

    // Load tvs-app only on single tvs_route
    if ( is_singular( 'tvs_route' ) ) {
        wp_enqueue_script( 'tvs-app' );
    }
} );
