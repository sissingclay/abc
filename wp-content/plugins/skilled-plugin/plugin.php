<?php
/**
 * Plugin Name: Skilled
 * Plugin URI:  http://wordpress.org/plugins
 * Description: Skilled theme helper plugin
 * Version:     1.1.2
 * Author:      Aislin Themes
 * Author URI:  http://themeforest.net/user/Aislin/portfolio
 * License:     GPLv2+
 * Text Domain: chp
 * Domain Path: /languages
 */
define( 'SCP_PLUGIN_VERSION', '1.1.2' );
define( 'SCP_PLUGIN_NAME', 'Skilled' );
define( 'SCP_PLUGIN_PREFIX', 'scp_' );
define( 'SCP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SCP_PLUGIN_PATH', dirname( __FILE__ ) . '/' );
define( 'SCP_TEXT_DOMAIN', 'scp_skilled' );

register_activation_hook( __FILE__, 'scp_activate' );
register_deactivation_hook( __FILE__, 'scp_deactivate' );

add_action( 'plugins_loaded', 'scp_init' );
add_action( 'widgets_init', 'scp_register_wp_widgets' );
add_action( 'wp_enqueue_scripts', 'scp_enqueue_scripts', 100 );
add_action( 'admin_init', 'scp_register_wp_widgets' );
add_action( 'admin_init', 'scp_vc_editor_set_post_types', 11 );
add_action( 'wp_head', 'scp_set_js_global_var' );

add_filter( 'pre_get_posts', 'scp_portfolio_posts' );

require_once 'shortcodes.php';

function scp_clean( $item ) {
	$firstClosingPTag = substr( $item, 0, 4 );
	$lastOpeningPTag  = substr( $item, - 3 );

	if ( $firstClosingPTag == '</p>' ) {
		$item = substr( $item, 4 );
	}

	if ( $lastOpeningPTag == '<p>' ) {
		$item = substr( $item, 0, - 3 );
	}

	return $item;
}


function scp_init() {
	scp_add_extensions();
	scp_add_vc_custom_addons();
}

function scp_activate() {
	scp_init();
	flush_rewrite_rules();
}

function scp_deactivate() {

}

function scp_add_vc_custom_addons() {
	require_once 'vc-addons/ribbon/ribbon.php';
	require_once 'vc-addons/events/events.php';
	require_once 'vc-addons/post-list/addon.php';
	require_once 'vc-addons/sensei-courses-carousel/addon.php';
	require_once 'vc-addons/courses-search-form/addon.php';
	require_once 'vc-addons/teachers/addon.php';
	require_once 'vc-addons/our-process/addon.php';
	require_once 'vc-addons/sensei-courses-category/addon.php';
	require_once 'vc-addons/countdown/addon.php';

	// LearnPress
//	require_once 'vc-addons/learnpress-courses-carousel/addon.php';
}

function scp_add_extensions() {
	require_once 'extensions/teacher-post-type/teacher-post-type.php';

	if ( ! scp_is_plugin_activating( 'breadcrumb-trail/breadcrumb-trail.php' ) && ! function_exists( 'breadcrumb_trail_theme_setup' ) ) {
		require_once 'extensions/breadcrumb-trail/breadcrumb-trail.php';
	}
	if ( ! scp_is_plugin_activating( 'timetable/timetable.php' ) && ! function_exists( 'timetable_load_textdomain' ) ) {
		require_once 'extensions/timetable/timetable.php';
	}
	if ( ! scp_is_plugin_activating( 'testimonial-rotator/testimonial-rotator.php' ) && ! function_exists( 'testimonial_rotator_setup' ) ) {
		require_once 'extensions/testimonial-rotator/testimonial-rotator.php';
	}
	if ( ! scp_is_plugin_activating( 'meta-box/meta-box.php' ) && ! defined( 'RWMB_VER' ) ) {
		require_once 'extensions/meta-box/meta-box.php';
	}

	/**
	 * Save Sensei Settings the first time
	 */
	add_option( 'woothemes-sensei-settings', array(
		'course_archive_image_width'     => 260,
		'course_archive_image_height'    => 170,
		'course_archive_image_hard_crop' => true,
		'course_lesson_image_enable'     => true,
		'lesson_archive_image_width'     => 100,
		'lesson_archive_image_height'    => 70,
		'lesson_archive_image_hard_crop' => true,
		'lesson_single_image_enable'     => true,
		'lesson_single_image_width'      => 835,
		'lesson_single_image_height'     => 500,
		'lesson_single_image_hard_crop'  => true,
		'woocommerce_enabled'            => true,
		'course_single_content_display'  => 'full',
	) );

	/**
	 * Events Settings the first time
	 */
	add_option( 'tribe_events_calendar_options', array(
		'tribeEventsTemplate'     => 'template-fullwidth.php',
	) );
}

function scp_get_skilled_option( $option_name, $default = false ) {
	if ( function_exists( 'skilled_get_option' ) ) {
		return skilled_get_option( $option_name, $default );
	}
	return $default;
}

function scp_set_js_global_var() {
	?>
	<script>
		var skilled_plugin = skilled_plugin ||
			{
				data: {
					vcWidgets: {
						ourProcess: {
							breakpoint: 480
						}
					}
				}
			};
	</script>
<?php
}

function scp_register_wp_widgets() {
	require_once 'wp-widgets/SCP_Latest_Posts_Widget.php';
	require_once 'wp-widgets/SCP_Contact_Info_Widget.php';
	require_once 'wp-widgets/SCP_Working_Hours_Widget.php';
	require_once 'wp-widgets/SCP_Teachers_Widget.php';

	if ( function_exists( 'Sensei' ) ) {
		require_once 'wp-widgets/SCP_Sensei_Course_Component_Widget.php';
	}
}

function scp_portfolio_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( is_tax() && isset( $query->tax_query ) && $query->tax_query->queries[0]['taxonomy'] == 'portfolio_category' ) {
		$query->set( 'posts_per_page', 10 );
		return;
	}
}

function scp_vc_editor_set_post_types() {
	$opt_name = 'scp_vc_post_types_set';
	$is_set   = (int) get_option( $opt_name );
	if ( ! $is_set ) {
		if ( function_exists( 'vc_editor_post_types' ) ) {
			$post_types = vc_editor_post_types();
			if ( ! in_array( 'course', $post_types ) ) {
				$post_types[] = 'course';
			}
			if ( ! in_array( 'teacher', $post_types ) ) {
				$post_types[] = 'teacher';
			}
			if ( ! in_array( 'events', $post_types ) ) {
				$post_types[] = 'events';
			}
			if ( ! in_array( 'lpr_course', $post_types ) ) {
				$post_types[] = 'lpr_course';
			}
			vc_editor_set_post_types( $post_types );
			add_option( $opt_name, true );
		}
	}
}

function scp_enqueue_scripts() {
//     wp_enqueue_style('linp-css', SCP_PLUGIN_URL . 'public/css/scp-style.css', false);
	wp_enqueue_script( 'linp-main-js', SCP_PLUGIN_URL . 'public/js/linp-main.js', array( 'jquery' ), false, true );

	wp_deregister_style( 'timetable_sf_style' );
	wp_deregister_style('timetable_style');
	wp_deregister_style('timetable_event_template');
	wp_deregister_style('timetable_responsive_style');
	wp_enqueue_style( 'timetable_merged', SCP_PLUGIN_URL . 'public/css/extensions.css', false );
}

function scp_is_plugin_activating( $plugin ) {
	if ( isset( $_GET['action'] ) && $_GET['action'] == 'activate' && isset( $_GET['plugin'] ) ) {
		if ( $_GET['plugin'] == $plugin ) {
			return true;
		}
	}
	return false;
}

function scp_fpc( $filename, $filecontent ) {
	file_put_contents( $filename, $filecontent );
}

function scp_fgc( $filename ) {
	return file_get_contents( $filename );
}
