<?php
/**
 * Wheels includes
 */
$skilled_includes = array(
	'lib/utils.php',            // Utility functions
	'lib/css-classes.php',      // Dynamic CSS Classes
	'lib/init.php',             // Initial theme setup and constants
	'lib/config.php',           // Configuration
	'lib/activation.php',       // Theme activation
	'lib/activate-plugins.php', // Activate plugins
	'lib/titles.php',           // Page titles
	'lib/cleanup.php',          // Cleanup
	'lib/comments.php',         // Custom comments modifications
	'lib/scripts.php',          // Scripts and stylesheets
	'lib/extras.php',           // Custom functions
);
foreach ( $skilled_includes as $file ) {
	$filepath = get_template_directory() . '/' . $file;
	if ( ! file_exists( $filepath ) ) {
		trigger_error( sprintf( esc_html__( 'Error locating %s for inclusion', 'skilled' ), $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
unset( $file, $filepath );
/** exclude posts from search results */
function SearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'page');
}
return $query;
}
add_filter('pre_get_posts','SearchFilter');