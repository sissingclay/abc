<?php


add_filter( 'rwmb_meta_boxes', 'skilled_register_meta_boxes' );

function skilled_register_meta_boxes( $meta_boxes ) {
	$meta_boxes = array();
	$prefix     = 'wheels_';

	/**
	 * Single Course
	 */

	$meta_boxes[] = array(
		'title'  => 'Course Custom Fields',
		'pages'  => array( 'course' ), // can be used on multiple CPTs
		'fields' => array(
			array(
				'id'   => $prefix . 'course_duration',
				'type' => 'text',
				'name' => esc_html__( 'Course Duration', 'skilled' ),
			),
			array(
				'id'   => $prefix . 'sidebar_text',
				'type' => 'textarea',
				'rows' => '15',
				'name' => esc_html__( 'Sidebar Text', 'skilled' ),
			),
		)
	);


	/**
	 * Single Teacher
	 */

	$meta_boxes[] = array(
		'title'  => 'Teacher Settings',
		'pages'  => array( 'teacher' ), // can be used on multiple CPTs
		'fields' => array(
			array(
				'id'   => $prefix . 'job_title',
				'type' => 'text',
				'name' => esc_html__( 'Job Title', 'skilled' ),
				'desc' => esc_html__( 'This will be printed in Teacher Widget', 'skilled' ),
			),
			array(
				'id'   => $prefix . 'summary',
				'type' => 'wysiwyg',
				'name' => esc_html__( 'Summary', 'skilled' ),
				'desc' => esc_html__( 'This will be printed in Teacher Widget', 'skilled' ),
			),
			array(
				'id'   => $prefix . 'social_meta',
				'type' => 'textarea',
				'name' => esc_html__( 'Social Icon Shortcodes', 'skilled' ),
				'desc' => esc_html__( 'This will be printed in Teacher Widget', 'skilled' ),
			),
		)
	);


	/**
	 * Pages
	 */

	$menus       = get_registered_nav_menus();
	$menus_array = array();

	foreach ( $menus as $location => $description ) {
		$menus_array[ $location ] = $description;
	}


	$meta_boxes[] = array(
		'title'  => 'Page Settings',
		'pages'  => array( 'page' ), // can be used on multiple CPTs
		'fields' => array(
			array(
				'id'   => $prefix . 'use_one_page_menu',
				'type' => 'checkbox',
				'name' => esc_html__( 'Use One Page Menu', 'skilled' ),
				'desc' => esc_html__( 'When using one page menu functionality you need to add an extra class on each vc row you want to link to a menu item. Also you need to create a menu in Appearance/Menus and create custom links where each link url has the same name as the row class prefixed with # sign',
					'skilled' ),
			),
			array(
				'id'          => $prefix . 'one_page_menu_location',
				'type'        => 'select',
				'name'        => esc_html__( 'Select One Page Menu Location', 'skilled' ),
				'desc'        => esc_html__( 'Used only if Use One Page Menu is checked.', 'skilled' ),
				'options'     => $menus_array,
				'placeholder' => 'Select Menu Location',
			),
			array(
				'id'               => $prefix . 'custom_logo',
				'type'             => 'image_advanced',
				'name'             => esc_html__( 'Custom Logo', 'skilled' ),
				'desc'             => esc_html__( 'Used it to override the logo from theme options. This works well when using Transparent Header Template.', 'skilled' ),
				'max_file_uploads' => 1,
			),
		)
	);

	return $meta_boxes;
}
