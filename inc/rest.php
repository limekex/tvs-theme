<?php
/** Development REST endpoints for theme/plugin integration. For production, move to plugin. */

add_action( 'rest_api_init', function () {
    // If the real plugin is active (TVS_REST class exists), don't register theme mock endpoints
    if ( class_exists( 'TVS_REST' ) ) {
        return;
    }

    register_rest_route( 'tvs/v1', '/activities/me', array(
        'methods' => 'GET',
        'callback' => function( $request ) {
            // Mocked response for development (only used when plugin is inactive)
            return rest_ensure_response( array(
                'activities' => array(),
                'paging' => array( 'page' => 1 )
            ) );
        },
        'permission_callback' => '__return_true'
    ) );

    register_rest_route( 'tvs/v1', '/strava-status', array(
        'methods' => 'GET',
        'callback' => function() {
            return rest_ensure_response( array(
                'connected' => false,
                'athlete' => null
            ) );
        },
        'permission_callback' => '__return_true'
    ) );
} );
