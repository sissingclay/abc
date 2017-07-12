<?php
/**
 * @package WordPress
 * @subpackage Wheels
 *
 * Template Name: Search Courses
 */

if ( skilled_is_learnpress_active() ) {
	get_template_part( 'search-courses-learnpress' );
} else {
	get_template_part( 'search-courses' );
}
