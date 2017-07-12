<?php
/**
 * Page titles
 */
function skilled_title() {

	$post_id = get_the_ID();

	if ( is_home() ) {
		if ( get_option( 'page_for_posts', true ) ) {
			return get_the_title( get_option( 'page_for_posts', true ) );
		} else {
			return esc_html__( 'Latest Posts', 'skilled' );
		}
	} elseif ( is_archive() ) {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if ( $term ) {
			return apply_filters( 'single_term_title', $term->name, $post_id );
		} elseif ( is_post_type_archive() ) {
			return apply_filters( 'the_title', get_queried_object()->labels->name, $post_id );
		} elseif ( is_day() ) {
			return sprintf( esc_html__( 'Daily Archives: %s', 'skilled' ), get_the_date() );
		} elseif ( is_month() ) {
			return sprintf( esc_html__( 'Monthly Archives: %s', 'skilled' ), get_the_date( 'F Y' ) );
		} elseif ( is_year() ) {
			return sprintf( esc_html__( 'Yearly Archives: %s', 'skilled' ), get_the_date( 'Y' ) );
		} elseif ( is_author() ) {
			$author = get_queried_object();
			return sprintf( esc_html__( 'Author: %s', 'skilled' ), $author->display_name );
		} elseif ( function_exists( 'skilled_is_search_courses' ) && skilled_is_search_courses() ) {
			return esc_html__( 'Search Courses', 'skilled' );
		} else {
			return single_cat_title( '', false );
		}
	} elseif ( is_search() ) {
		return sprintf( esc_html__( 'Search Results for %s', 'skilled' ), get_search_query() );
	} elseif ( function_exists( 'skilled_is_search_courses' ) && skilled_is_search_courses() ) {
		return esc_html__( 'Search Courses', 'skilled' );
	} elseif ( is_404() ) {
		return esc_html__( 'Not Found', 'skilled' );
	} elseif ( get_post_type() == 'tribe_events' && !is_single() ) {
		return tribe_get_events_title();
	} else {
		return get_the_title();
	}
}
