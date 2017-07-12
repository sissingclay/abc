<?php

add_filter( 'language_attributes', 'skilled_language_attributes' );
// add_filter( 'wp_title', 'skilled_wp_title', 10 );
add_filter( 'excerpt_length', 'skilled_excerpt_length' );
add_filter( 'excerpt_more', 'skilled_excerpt_more' );
add_filter( 'request', 'skilled_request_filter' );
add_filter( 'get_search_form', 'skilled_get_search_form' );

/**
 * Clean up language_attributes() used in <html> tag
 *
 * Remove dir="ltr"
 */
function skilled_language_attributes() {
	$attributes = array();
	$output     = '';

	if ( is_rtl() ) {
		$attributes[] = 'dir="rtl"';
	}

	$lang = get_bloginfo( 'language' );

	if ( $lang ) {
		$attributes[] = "lang=\"$lang\"";
	}

	$output = implode( ' ', $attributes );
	$output = apply_filters( 'skilled_language_attributes', $output );

	return $output;
}

/**
 * Manage output of wp_title()
 */
function skilled_wp_title( $title ) {
	if ( is_feed() ) {
		return $title;
	}

	$title .= get_bloginfo( 'name' );

	return $title;
}

/**
 * Clean up the_excerpt()
 */
function skilled_excerpt_length( $length ) {
	$post_excerpt_length = skilled_get_option('post-excerpt-length', POST_EXCERPT_LENGTH);
	return $post_excerpt_length;
}

function skilled_excerpt_more( $more ) {
	return '&nbsp;<a href="' . get_permalink() . '">[&hellip;]</a>';
}


/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function skilled_request_filter( $query_vars ) {
	if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) && ! is_admin() ) {
		$query_vars['s'] = ' ';
	}

	return $query_vars;
}


/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function skilled_get_search_form( $form ) {
	$form = '';
	include_once get_template_directory() . '/templates/searchform.php';

	return $form;
}

