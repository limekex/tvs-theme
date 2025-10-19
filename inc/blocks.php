<?php
/**
 * Auto-register all blocks under /blocks
 */
add_action('init', function () {
	$base = get_theme_file_path('blocks');
	foreach (glob($base . '/*/block.json') as $json) {
		register_block_type(dirname($json));
	}
});
