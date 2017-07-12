<?php
add_filter( 'template_redirect', 'skilled_search_template', 20 );
add_filter( 'pre_get_posts', 'skilled_add_custom_types' );
add_filter( 'sensei_login_logout_menu_title', 'skilled_filter_login_menu_item_label' );

add_action( 'sensei_wc_single_add_to_cart_button_text', 'skilled_single_add_to_cart_text' );
add_action( 'sensei_start_course_text', 'skilled_single_add_to_cart_text' );

remove_action( 'sensei_single_course_content_inside_before', array( 'Sensei_Course', 'the_title' ), 10 );
remove_action( 'sensei_single_course_content_inside_before', array( 'Sensei_Course', 'the_course_video' ), 40 );

if ( function_exists( 'Sensei' ) ) {
	remove_action( 'sensei_single_course_content_inside_before', array(
		Sensei()->post_types->course,
		'the_progress_statement'
	), 15 );
	remove_action( 'sensei_single_course_content_inside_before', array(
		Sensei()->post_types->course,
		'the_progress_meter'
	), 16 );
	add_action( 'sensei_single_course_content_inside_before', array(
		Sensei()->post_types->course,
		'the_progress_statement'
	), 35 );
	add_action( 'sensei_single_course_content_inside_before', array(
		Sensei()->post_types->course,
		'the_progress_meter'
	), 36 );
}


function skilled_single_add_to_cart_text( $text ) {

	if ( is_single() && get_post_type() == 'course' ) {
		return 'Take this course';
	}

	return $text;
}

/**
 * This is used only if a search page is not set in Theme Options
 * If it is set then the url of the page is set as form action
 */
function skilled_search_template() {
	if ( skilled_is_search_courses() ) {

		if ( is_plugin_active( 'learnpress/learnpress.php' )  || is_plugin_active( 'LearnPress/learnpress.php' )) {
			require_once get_template_directory() . '/search-courses-learnpress.php';
			exit;
		}

		include_once get_template_directory() . '/search-courses.php';
		exit;
	}
}

function skilled_is_search_courses() {
	return isset( $_GET['s'] ) && isset( $_GET['search-type'] ) && $_GET['search-type'] == 'courses';
}

/**
 * This enables Courses to turn up in post by author listing
 */
function skilled_add_custom_types( $query ) {

	if ( is_author() ) {

		$query->set( 'post_type', array(
			'post',
			'nav_menu_item',
			'course'
		) );

		return $query;
	}
}

function skilled_filter_login_menu_item_label( $menu_title ) {

	if ( $menu_title == 'Login' ) {
		$menu_title = esc_html__( 'Sign In/Sign Up', 'skilled' );
	}

	return $menu_title;

}

function skilled_course_print_stars( $id = "", $permalink = false, $newwindow = true, $alttext = "" ) {

	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) && get_option('woocommerce_enable_review_rating') == 'yes' ) {

		global $wpdb;
		global $post;

		if ( empty( $id ) ) {
			$id = $post->ID;
		}

		if ( empty( $alttext ) ) {
			$alttext = "Be the first to rate " . get_the_title( $id );
		}

		if ( is_bool( $permalink ) ) {
			if ( $permalink ) {
				$link = get_permalink( $id );
			}
		} else {
			$link = $permalink;
			$permalink = true;
		}

		$target = "";
		if ( $newwindow ) {
			$target = "target='_blank' ";
		}


		if ( get_post_type( $id ) == 'product' ) {
			$count = $wpdb->get_var( "
			SELECT COUNT(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = $id
			AND comment_approved = '1'
			AND meta_value > 0
		" );

			$rating = $wpdb->get_var( "
			SELECT SUM(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = $id
			AND comment_approved = '1'
		" );

			if ( $permalink ) {
				echo "<a href='{$link}'  {$target} >";
			}

			echo '<span style="display:inline-block;float:none;" class="starwrapper" itemscope itemtype="http://schema.org/AggregateRating">';

			if ( $count > 0 ) {
				$average = number_format( $rating / $count, 2 );

				echo '<span class="star-rating" title="' . sprintf( __( 'Rated %s out of 5', 'skilled' ), $average ) . '"><span style="width:' . ( $average * 16 ) . 'px"><span itemprop="ratingValue" class="rating">' . $average
				     . '</span> </span></span>';

			} else {
				echo '<span class="star-rating-alt-text">' . $alttext . '</span>';
			}

			echo '</span>';

			if ( $permalink ) {
				echo "</a>";
			}

		}

	}
}

function skilled_get_teacher_thumb( $user_id = 0 ) {
	if ( $user_id ) {

		$meta_key = 'sensei-teacher';
		$args     = array(
			'numberposts' => 1,
			'post_type'   => 'teacher',
			'author'      => $user_id,
		);
		// get product ids
		$teachers = new WP_Query( $args );
		$teacher = null;

		if ( $teachers->posts && count( $teachers->posts ) ) {

			$teacher = $teachers->posts[0];
		}

		if ($teacher) {

			$img_url = '';
			if ( has_post_thumbnail( $teacher->ID ) ) {
				$img_url = get_the_post_thumbnail( $teacher->ID, 'thumbnail' );
			}
			if ( '' != $img_url ) {
				return '<a href="' . get_permalink( $teacher->ID ) . '" title="' . esc_attr( get_post_field( 'post_title', $teacher->ID ) ) . '">' . $img_url . '</a>';
			}
		}
	}

	return false;
}


function skilled_sensei_simple_course_price( $post_id ) {

	if ( function_exists( 'sensei_simple_course_price' ) ) {

		ob_start();

		sensei_simple_course_price( $post_id );

		$content = ob_get_clean();

		if ( $content ) {
			return $content;
		}
	}

	return false;
}
