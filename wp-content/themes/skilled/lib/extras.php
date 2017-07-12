<?php
/**
 * Custom functions
 */

add_action( 'wp_head', 'skilled_custom_css' );
add_action( 'wp_head', 'skilled_custom_js_code' );
add_action( 'wp_head', 'skilled_google_analytics_code' );
add_action( 'wp_head', 'skilled_responsive_menu_scripts' );
add_filter( 'wp_nav_menu_items', 'skilled_wcmenucart', 10, 2 );

// add_filter( 'wp_page_menu_args', 'skilled_filter_wp_page_menu_args' );

function skilled_filter_wp_page_menu_args( $args ) {

	// $args['menu_class']      = skilled_class( 'main-menu' );
	// $args['container_class'] = skilled_class( 'main-menu-container' );

	return $args;
}


function skilled_is_learnpress_active() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'learnpress/learnpress.php' )  || is_plugin_active( 'LearnPress/learnpress.php' )) {
		return true;
	}

	return false;
}

/**
 * Place a cart icon with number of items and total cost in the menu bar.
 *
 * Source: http://wordpress.org/plugins/woocommerce-menu-bar-cart/
 */
function skilled_wcmenucart($menu, $args) {

	// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'primary_navigation' !== $args->theme_location )
		return $menu;

	ob_start();
	global $woocommerce;
	$viewing_cart = esc_html__('View your shopping cart', 'skilled');
	$start_shopping = esc_html__('Start shopping', 'skilled');
	$cart_url = $woocommerce->cart->get_cart_url();
	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
	$cart_contents_count = $woocommerce->cart->cart_contents_count;
//	$cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'wheels'), $cart_contents_count);
	$cart_contents = sprintf(_n('%d', '%d', $cart_contents_count, 'skilled'), $cart_contents_count);
	$cart_total = $woocommerce->cart->get_cart_total();
	$menu_item = '';
	// Uncomment the line below to hide nav menu cart item when there are no items in the cart
	 if ( $cart_contents_count > 0 ) {
		if ($cart_contents_count == 0) {
			$menu_item = '<li class="menu-item"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
		} else {
			$menu_item = '<li class="menu-item"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
		}

		$menu_item .= '<i class="fa fa-shopping-cart"></i> ';

		$menu_item .= $cart_contents.' - '. $cart_total;
		$menu_item .= '</a></li>';
	// Uncomment the line below to hide nav menu cart item when there are no items in the cart
	 }
	echo '' . $menu_item;
	$social = ob_get_clean();
	return $menu . $social;

}


function skilled_register_custom_thumbnail_sizes() {
	$string = skilled_get_option( 'custom-thumbnail-sizes' );

	if ( $string ) {

		$pattern     = '/[^a-zA-Z0-9\-\|\:]/';
		$replacement = '';
		$string      = preg_replace( $pattern, $replacement, $string );

		$resArr = explode( '|', $string );
		$thumbs = array();

		foreach ( $resArr as $thumbString ) {
			if ( ! empty( $thumbString ) ) {
				$parts               = explode( ':', trim( $thumbString ) );
				$thumbs[ $parts[0] ] = explode( 'x', $parts[1] );
			}
		}

		foreach ( $thumbs as $name => $sizes ) {
			add_image_size( $name, (int) $sizes[0], (int) $sizes[1], true );
		}
	}
}


if ( ! function_exists( 'skilled_entry_meta' ) ) {

	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * @return void
	 */
	function skilled_entry_meta() {
		if ( is_sticky() && is_home() && ! is_paged() ) {
			echo '<span class="featured-post">' . esc_html__( 'Sticky', 'skilled' ) . '</span>';
		}

		if ( ! has_post_format( 'link' ) && 'post' == get_post_type() ) {
			skilled_entry_date();
		}

		// Post author
		if ( 'post' == get_post_type() ) {
			printf( '<i class="lnr lnr-user"></i><span class="author vcard">%1$s <a class="url fn n" href="%2$s" title="%3$s" rel="author">%4$s</a></span>', esc_html__( 'Posted by', 'skilled' ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'skilled' ), get_the_author() ) ), get_the_author() );

			$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

			if ( $num_comments == 0 ) {

			} else {

				if ( $num_comments > 1 ) {
					$comments = $num_comments . __( ' Comments', 'skilled' );
				} else {
					$comments = __( '1 Comment', 'skilled' );
				}
				echo '<span class="comments-count"><i class="fa fa-comment-o"></i><a href="' . get_comments_link() . '">' . get_comments_number() . '</a></span>';
			}

		}

		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'skilled' ) );
		if ( $categories_list ) {
			echo '<i class="lnr lnr-flag"></i><span class="categories-links">' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'skilled' ) );
		if ( $tag_list ) {
			echo '<i class="fa fa-tag"></i><span class="tags-links">' . $tag_list . '</span>';
		}


	}
}

if ( ! function_exists( 'skilled_entry_date' ) ) {

	/**
	 * Prints HTML with date information for current post.
	 *
	 * @param boolean $echo Whether to echo the date. Default true.
	 *
	 * @return string The HTML-formatted post date.
	 */
	function skilled_entry_date( $echo = true ) {
		if ( has_post_format( array( 'chat', 'status' ) ) ) {
			$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'skilled' );
		} else {
			$format_prefix = '%2$s';
		}

		$date = sprintf( '<span class="date"><i class="lnr lnr-clock"></i><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>', esc_url( get_permalink() ),
			esc_attr( sprintf( esc_html__( 'Permalink to %s', 'skilled' ), the_title_attribute( 'echo=0' ) ) ), esc_attr( get_the_date( 'c' ) ), esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) ) );

		if ( $echo ) {
			echo $date;
		}

		return $date;
	}

}
