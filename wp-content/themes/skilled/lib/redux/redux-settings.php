<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

// This is your option name where all the Redux data is stored.
$opt_name = SKILLED_THEME_OPTION_NAME;




// Compiler hook and demo CSS output.
// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
add_filter( 'redux/options/' . $opt_name . '/compiler', 'class_compiler_action', 10, 3 );

function class_compiler_action( $options, $css, $changed_values ) {

	$upload_dir = wp_upload_dir();
	$filename   = $upload_dir['basedir'] . '/' . SKILLED_THEME_OPTION_NAME . '_style.css';
	$filename = apply_filters('wheels_redux_compiler_filename', $filename);

	$filecontent = "/********* Compiled file/Do not edit *********/\n";
	$filecontent .= $css;

	// Global accent color
	$option_name = 'global-accent-color';
	if (isset($options[$option_name]) && isset($options[$option_name])) {
		$filecontent .= '.lin-vc-separator:before,';
		$filecontent .= '.social .scp-icon,';
		$filecontent .= '.lin-teacher-icons .scp-icon,';
		$filecontent .= '.single-course .modules-and-lessons h2:after';
		$filecontent .= '{background-color:' . $options[$option_name] . ';}';

		$filecontent .= '.scp-teachers .teacher .job-title,';
		$filecontent .= '.linp-featured-courses-carousel .course-title a:hover,';
		$filecontent .= '{color:' . $options[$option_name] . ';}';

		$filecontent .= '.lin-heading-separator .uvc-headings-line';
		$filecontent .= '{border-color:' . $options[$option_name] . ' !important;}';

		$filecontent .= '.wh-footer .widget ul li:before';
		$filecontent .= '{border-color:transparent transparent transparent ' . $options[$option_name] . '}';

		$filecontent .= '.vc_grid-pagination .vc_grid-pagination-list.vc_grid-pagination-color-orange>li>a, .vc_grid-pagination .vc_grid-pagination-list.vc_grid-pagination-color-orange>li>span';
		$filecontent .= '{';
		$filecontent .= 'background-color:' . $options[$option_name] . ' !important;';
		$filecontent .= 'border-color:' . $options[$option_name] . ' !important;';
		$filecontent .= '}';
	}

	// Comment hr color
	$option_name = 'content-hr';
	if (isset($options[$option_name]) && isset($options[$option_name]['border-color'])) {
		$filecontent .= '.comment-list .comment hr{border-top-color:' . $options[$option_name]['border-color'] . ';}';
	}

	// Blockquote border color
	$option_name = 'body-link-color';
	if (isset($options[$option_name]) && isset($options[$option_name]['regular'])) {
		$filecontent .= 'blockquote{border-left-color:' . $options[$option_name]['regular'] . ';}';
		$filecontent .= '.sub-menu{border-top:2px solid ' . $options[$option_name]['regular'] . ';}';
	}

	// Sensei Carousel Ribbon Border
	$option_name = 'linp-featured-courses-item-price-bg-color';
	if (isset($options[$option_name])) {
		$filecontent .= '.linp-featured-courses-carousel .owl-item .price .course-price:before{border-color: ' . $options[$option_name] . ' ' . $options[$option_name] . ' ' . $options[$option_name] . ' transparent;}';
		$filecontent .= '.course-container article.course .course-price:after{border-color: ' . $options[$option_name] . ' transparent ' . $options[$option_name] . ' ' .  $options[$option_name] . ';}';
	}
	// Sensei Carousel Ribbon Back Bg Color
	$option_name = 'linp-featured-courses-item-ribbon-back-bg-color';
	if (isset($options[$option_name])) {
		$filecontent .= '.linp-featured-courses-carousel .owl-item .price .course-price:after{border-color: ' . $options[$option_name] . ' transparent transparent' . $options[$option_name] . ';}';
		$filecontent .= '.course-container article.course .course-price:before{border-color: ' . $options[$option_name] . $options[$option_name] . ' transparent transparent;}';
	}
	// Sensei Carousel Item Border Color
	$option_name = 'linp-featured-courses-item-border-color';
	if (isset($options[$option_name])) {
		$filecontent .= '.linp-featured-courses-carousel .owl-item > div{border:1px solid ' . $options[$option_name] . ';}';
		$filecontent .= '.linp-featured-courses-carousel .owl-item .cbp-row{border-top:1px solid ' . $options[$option_name] . ';}';
	}
	// Other Seettings Vars
	 $option_name = 'other-settings-vars';
	 if (isset($options[$option_name])) {
		$scssphp_filepath = WP_PLUGIN_DIR . '/skilled-plugin/extensions/scssphp/scss.inc.php';
	 	if (version_compare(phpversion(), '5.3.10', '>=') && file_exists( $scssphp_filepath ) ) {

	 		$result = '';

		    $buffer = null;
		    if ( function_exists( 'scp_fgc') ) {
			    $buffer = scp_fgc( get_template_directory() . '/lib/redux/css/other-settings/vars.scss' );
		    }

		    $buffer = skilled_strip_comments( $buffer );
		    $lines = '';
		    if ( $buffer ) {
		        $lines  = explode( ';', $buffer );
		    }

		    $default_vars = array();
		    foreach ( $lines as $line ) {

			    $line = explode( ':', $line );
				$key  = isset( $line[0] ) ? trim( str_replace( '$', '', $line[0] ) ) : false;

			    if ( $key ) {
				    $default_vars[ $key ] = trim( $line[1] );
			    }

		    }

	        require_once $scssphp_filepath;

	 		try {
		        $scss = new Leafo\ScssPhp\Compiler();
		        $scss->setImportPaths(get_template_directory() . '/lib/redux/css');
			    // set default variables
			    $scss->setVariables($default_vars);
		        $scss->setFormatter('Leafo\ScssPhp\Formatter\Crunched');
				// new line is needed at the end of the string to properly remove single line comments
				// because this is a string and not a file
				$data = skilled_strip_comments( $options[$option_name] . "\n" );
		        $data .= '@import "other-settings/main.scss";';
	 			$result =  $scss->compile($data);

	 	    } catch (Exception $e) {

				// if it fails to compile with user settings
				// try with default settings
				try {
			        $scss = new Leafo\ScssPhp\Compiler();
			        $scss->setImportPaths(get_template_directory() . '/lib/redux/css');
			        $scss->setFormatter('Leafo\ScssPhp\Formatter\Crunched');
			        $data = '@import "other-settings/vars.scss";';
			        $data .= '@import "other-settings/main.scss";';
		 			$result =  $scss->compile($data);
		 	    } catch (Exception $e) {

		 	    }
	 	    }
	 		$filecontent .= $result;
	 	}
	 }

	if (is_writable($upload_dir['basedir'])) {
		if ( function_exists( 'scp_fpc')) {
			scp_fpc($filename, $filecontent);
		}

	} else {
		wp_die(__("It looks like your upload folder isn't writable, so PHP couldn't make any changes (CHMOD).", 'skilled'), __('Cannot write to file', 'skilled'), array('back_link' => true));
	}

}

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
	// TYPICAL -> Change these values as you need/desire
	'opt_name'             => $opt_name,
	// This is where your data is stored in the database and also becomes your global variable name.
	'display_name'         => $theme->get( 'Name' ),
	// Name that appears at the top of your panel
	'display_version'      => $theme->get( 'Version' ),
	// Version that appears at the top of your panel
	'menu_type'            => 'menu',
	//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
	'allow_sub_menu'       => true,
	// Show the sections below the admin menu item or not
	'menu_title'           => esc_html__( 'Theme Options', 'skilled' ),
	'page_title'           => esc_html__( 'Theme Options', 'skilled' ),
	// You will need to generate a Google API key to use this feature.
	// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
	'google_api_key'       => 'AIzaSyBETK1Pd_dt2PYIGteFgKS25rp6MmQFErw',
	// Set it you want google fonts to update weekly. A google_api_key value is required.
	'google_update_weekly' => false,
	// Must be defined to add google fonts to the typography module
	'async_typography'     => true,
	// Use a asynchronous font on the front end or font string
	//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
	'admin_bar'            => true,
	// Show the panel pages on the admin bar
	'admin_bar_icon'       => 'dashicons-portfolio',
	// Choose an icon for the admin bar menu
	'admin_bar_priority'   => 50,
	// Choose an priority for the admin bar menu
	'global_variable'      => '',
	// Set a different name for your global variable other than the opt_name
	'dev_mode'             => false,
	// Show the time the page took to load, etc
	'update_notice'        => true,
	// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
	'customizer'           => true,
	// Enable basic customizer support
	//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
	//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

	// OPTIONAL -> Give you extra features
	'page_priority'        => null,
	// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	'page_parent'          => 'themes.php',
	// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	'page_permissions'     => 'manage_options',
	// Permissions needed to access the options panel.
	'menu_icon'            => '',
	// Specify a custom URL to an icon
	'last_tab'             => '',
	// Force your panel to always open to a specific tab (by id)
	'page_icon'            => 'icon-themes',
	// Icon displayed in the admin panel next to your menu_title
	'page_slug'            => '_options',
	// Page slug used to denote the panel
	'save_defaults'        => false,
	// On load save the defaults to DB before user clicks save or not
	'default_show'         => false,
	// If true, shows the default value next to each field that is not the default value.
	'default_mark'         => '*',
	// What to print by the field's title if the value shown is default. Suggested: *
	'show_import_export'   => true,
	// Shows the Import/Export panel when not used as a field.

	// CAREFUL -> These options are for advanced use only
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	'output_tag'           => true,
	// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

	// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	'database'             => '',
	// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

	//'compiler'             => true,

	// HINTS
	'hints'                => array(
		'icon'          => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color'    => 'lightgray',
		'icon_size'     => 'normal',
		'tip_style'     => array(
			'color'   => 'light',
			'shadow'  => true,
			'rounded' => false,
			'style'   => '',
		),
		'tip_position'  => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect'    => array(
			'show' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'mouseover',
			),
			'hide' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'click mouseleave',
			),
		),
	)
);

Redux::setArgs( $opt_name, $args );
