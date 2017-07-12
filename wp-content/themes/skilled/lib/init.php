<?php

add_action( 'after_setup_theme', 'skilled_setup' );
add_action( 'widgets_init', 'skilled_widgets_init' );
add_filter( 'widget_text', 'do_shortcode' );

add_action('admin_head', 'skilled_custom_fonts');

function skilled_custom_fonts() {
  echo '<style>
    .redux-notice {
        display: none;
    }
  </style>';
}


function skilled_redux_remove_demo_mode_link() {

    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
    }
    // if ( class_exists('ReduxFramework') ) {
    // 	remove_action( 'admin_notices', array( ReduxFramework::$instance, '_admin_notices' ), 99 );
    // }
}
add_action('init', 'skilled_redux_remove_demo_mode_link', 2);

if ( ! function_exists( 'skilled_setup' ) ) {

	function skilled_setup() {

		add_filter('skilled_alt_buttons', 'skilled_add_to_alt_button_list');

		require_once 'redux/redux-settings.php';
		require_once 'redux/options.php';
		require_once 'metaboxes.php';
		require_once get_template_directory() . '/sensei/custom/init.php';

		if ( skilled_is_learnpress_active() ) {
			require_once get_template_directory() . '/learnpress/custom/init.php';
		}

		// Make theme available for translation
		load_theme_textdomain( 'skilled', get_template_directory() . '/languages' );

		// Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
		register_nav_menus( array(
			'primary_navigation' => esc_html__( 'Primary Navigation', 'skilled' ),
		) );
		register_nav_menus( array(
			'secondary_navigation' => esc_html__( 'Secondary Navigation', 'skilled' ),
		) );
		register_nav_menus( array(
			'top_navigation' => esc_html__( 'Top Navigation', 'skilled' ),
		) );
		register_nav_menus( array(
			'one_page_navigation_1' => esc_html__( 'One Page Navigation 1', 'skilled' ),
		) );
		register_nav_menus( array(
			'one_page_navigation_2' => esc_html__( 'One Page Navigation 2', 'skilled' ),
		) );
		register_nav_menus( array(
			'one_page_navigation_3' => esc_html__( 'One Page Navigation 3', 'skilled' ),
		) );

		// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150, false );

		// Add_image_size('wh-medium', 300, 9999); // 300px wide (and unlimited height)
		add_image_size( 'wh-big', 1140, 500, true );
		add_image_size( 'wh-featured-image', 848, 548, true );
		add_image_size( 'wh-medium', 768, 496, true );
		add_image_size( 'wh-square', 768, 768, true );
		add_image_size( 'wh-thumb-third', 296, 216, true );
		add_image_size( 'wh-thumb-fourth', 260, 190, true );
		add_image_size( 'wh-course-search-thumb', 260, 170, true );


		// Add post formats (http://codex.wordpress.org/Post_Formats)
		add_theme_support( 'post-formats', array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat'
		) );
		add_theme_support( 'automatic-feed-links' );

		// Tell the TinyMCE editor to use a custom stylesheet
		// add_editor_style('/assets/css/editor-style.css');

		skilled_register_custom_thumbnail_sizes();

	}
}

function skilled_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Primary', 'skilled' ),
		'id'            => 'wheels-sidebar-primary',
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5><hr />',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'skilled' ),
		'id'            => 'wheels-sidebar-footer',
		'before_widget' => '<div class="widget %1$s %2$s ' . skilled_class( 'widget-footer' ) . '">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Courses', 'skilled' ),
		'id'            => 'wheels-sidebar-courses',
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

}

function skilled_add_to_alt_button_list($alt_button_arr) {

	$alt_button_arr[] = '.yith-wcwl-add-button a';

	return $alt_button_arr;

}
