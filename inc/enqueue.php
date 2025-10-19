<?php
/** Enqueue theme assets */
add_action( 'wp_enqueue_scripts', function() {
<<<<<<< HEAD
    $style_path = get_template_directory() . '/style.css';
    $style_uri  = get_stylesheet_uri();
    $style_ver  = file_exists( $style_path ) ? filemtime( $style_path ) : null;
=======
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
>>>>>>> 0e10b98fd6e9583b3f2708a15c5c4f219f768602

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
