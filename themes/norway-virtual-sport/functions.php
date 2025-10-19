<?php
// Minimal theme bootstrap for Norway Virtual Sport

require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/rest.php';

add_action( 'after_setup_theme', function() {
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-font-sizes' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'title-tag' );
    // Other supports can be added as needed
} );
