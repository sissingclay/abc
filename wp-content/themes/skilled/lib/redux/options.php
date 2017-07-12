<?php

$opt_name = SKILLED_THEME_OPTION_NAME;

if ( ! class_exists('Redux')) {
	return;
}

$other_settings = '';
if ( function_exists( 'scp_fgc') ) {
	$other_settings = scp_fgc( get_template_directory() . '/lib/redux/css/other-settings/vars.scss' );
}
// ----------------------------------
// -> General
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-general',
	'title'  => __( 'General Settings', 'skilled' ),
	'icon'   => 'el-icon-home',
	// 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'google-analytics-code',
			'type'     => 'ace_editor',
			'title'    => __( 'Tracking Code', 'skilled' ),
			'subtitle' => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the head of your theme.',
				'skilled' ),
			'mode'     => 'plain_text',
			'theme'    => 'monokai',
		),
		array(
			'id'       => 'custom-js-code',
			'type'     => 'ace_editor',
			'title'    => __( 'JS Code', 'skilled' ),
			'subtitle' => __( 'Paste your JS code here.', 'skilled' ),
			'mode'     => 'javascript',
			'theme'    => 'monokai',
			'default'  => "jQuery(document).ready(function(){\n\n});"
		),
		array(
			'id'          => 'custom-thumbnail-sizes',
			'type'        => 'ace_editor',
			'title'       => __( 'Custom Thumbnail Sizes', 'skilled' ),
			'subtitle'    => __( 'Pipe separated list of custom thumbnail size names and sizes.', 'skilled' ),
			'description' => __( 'Please use this format: <br><strong>custom-thumbnail-size:500x500|another-custom-thumbnail-size:320x150</strong>. <br>No spaces allowed. Thumnail Sizes you register here will only be applied to any new image from now on. If you wish to apply them on any of the old images we recomend using <a href="http://wordpress.org/plugins/regenerate-thumbnails/">Regenerate Thumbnails Plugin</a>',
				'skilled' ),
			'mode'        => 'text',
			'theme'       => 'monokai',
			'default'     => ""
		),
	),
) );
// -> End General


// ----------------------------------
// -> Styling
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-styling',
	'icon'   => 'el-icon-website',
	'title'  => __( 'Styling', 'skilled' ),
	'fields' => array(
		array(
		    'id'       => 'global-accent-color',
		    'type'     => 'color',
		    'title'    => __('Global Accent Color', 'skilled'),
		    'desc'     => __('This color will be used accross the site.', 'skilled'),
			'compiler' => 'true',
		    'default'  => '#ffc000',
		    'validate' => 'color',
		),
		// array(
		// 	'id'      => 'color-scheme',
		// 	'type'    => 'image_select',
		// 	'presets' => true,
		// 	'title'   => __( 'Color Scheme', 'wheels' ),
		// 	'desc'    => __( 'Choose one color scheme preset below. You are free to alter the preset to your liking. Whenever you wish to return to original preset colors just click on one of the preset icons again. Beware that all settings will be reset to preset colors selected (excerpt for logo and any textarea content).',
		// 		'wheels' ),
		// 	'options' => $presets,
		// 	'default' => '1'
		// ),
		// array(
		// 	'id'      => 'color-scheme-stylesheet',
		// 	'type'    => 'select',
		// 	'title'   => __( 'Stylesheet', 'wheels' ),
		// 	'desc'    => __( 'Select which stylesheet you want to include.', 'wheels' ),
		// 	'options' => $color_scheme_stylesheets,
		// 	'default' => $default_color_scheme_stylesheet,
		// ),
		array(
			'id'       => 'custom-css',
			'type'     => 'ace_editor',
			'title'    => __( 'Custom CSS Code', 'skilled' ),
			'subtitle' => __( 'Paste your CSS code here.', 'skilled' ),
			'compiler' => 'true',
			'mode'     => 'css',
			'theme'    => 'monokai',
			'default'  => '',
			'options'  => array(
				'minLines'=> 50
			),
		),
	)
) );
// -> End Styling

// ----------------------------------
// -> Body
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-body',
	'title'  => __( 'Body', 'skilled' ),
	'icon'   => 'el-icon-check-empty',
	'fields' => array(
		array(
			'id'       => 'container-width',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'title'    => __( 'Container Width', 'skilled' ),
			'compiler' => array( '.cbp-container', '#tribe-events-pg-template' ),
			'height'   => false,
			'mode'     => 'max-width',
			'default'  => array(
				'width' => '980',
				'units' => 'px',
			),
		),
		array(
			'id'       => 'boxed-outer-container-width',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'title'    => __( 'Boxed Outer Container Width', 'skilled' ),
			'subtitle' => __( 'This is only applicable when "Boxed" page template is used.', 'skilled' ),
			'compiler' => array( '.wh-main-wrap' ),
			'height'   => false,
			'mode'     => 'max-width',
			'default'  => array(
				'width' => '1100',
				'units' => 'px',
			),
		),
		array(
			'id'       => 'body-background',
			'type'     => 'background',
			'compiler' => array( 'body' ),
			'title'    => __( 'Background', 'skilled' ),
		),
		array(
			'id'         => 'body-typography',
			'type'       => 'typography',
			'title'      => __( 'Font', 'skilled' ),
			'subtitle'   => __( 'Specify the body font properties.', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'body' ),
			'default'    => array(
				'color'       => '#333',
				'font-size'   => '14px',
				'line-height' => '20px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'       => 'body-link-color',
			'type'     => 'link_color',
			'title'    => __( 'Link Color', 'skilled' ),
			'compiler' => array( 'a' ),
			'default'  => array(
				'regular' => '#353434',
				'hover'   => '#585757',
				'active'  => '#353434',
			)
		),
		array(
		    'id'       => 'body-hr',
		    'type'     => 'border',
		    'title'    => __('HR', 'skilled'),
		    'subtitle' => __('Style body HR element', 'skilled'),
		    'compiler' => array(
			    'hr',
			    '.wh-sidebar .widget hr',
			    '.linp-post-list hr',
			    '.wh-content .linp-post-list hr',
                '.wh-separator',
                '.wh-content hr.wh-separator',
		    ),
		    'bottom' => false,
		    'right' => false,
		    'left' => false,
		    'default'  => array(
		        'border-color'  => '#1e73be',
		        'border-style'  => 'solid',
		        'border-top'    => '5px',
		    )
		),
		array(
		    'id'       => 'body-hr-width',
		    'type'     => 'dimensions',
		    'units'    => array('em','px','%'),
		    'title'    => __('HR Width', 'skilled'),
		    'height'    => false,
		    'compiler' => array(
			    'hr',
			    '.wh-sidebar .widget hr',
			    '.linp-post-list hr',
                '.wh-content .linp-post-list hr',
                '.wh-separator',
                '.wh-content hr.wh-separator',
		    ),
		    'default'  => array(
		        'width'   => '70',
		        'units'  => 'px'
		    ),
		),
		array(
		    'id'             => 'body-hr-spacing',
		    'type'           => 'spacing',
		    'compiler' => array(
			    'hr',
			    '.wh-sidebar .widget hr',
			    '.linp-post-list hr',
                '.wh-content .linp-post-list hr',
                '.wh-separator',
                '.wh-content hr.wh-separator',
		    ),
		    'mode'           => 'margin',
		    'units'          => array('em', 'px'),
		    'units_extended' => 'false',
		    'title'          => __('HR Margin', 'skilled'),
		    'default'            => array(
		        'margin-top'     => '15px',
		        'margin-right'   => '0px',
		        'margin-bottom'  => '15px',
		        'margin-left'    => '0px',
		        'units'          => 'px',
		    )
		),
		array(
			'id'             => 'main-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-padding' , '#tribe-events-pg-template'),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Padding', 'skilled' ),
			'desc'    => __( 'This is where you select a padding for all layout elements. For widgets compiled from a page you need to set the padding on each widget.',
				'skilled' ),
			'default'        => array(
				'padding-top'    => '20px',
				'padding-right'  => '20px',
				'padding-bottom' => '20px',
				'padding-left'   => '20px',
				'units'          => 'px',
			)
		),
	)
) );



Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-body-headings',
	'title'      => __( 'Headings', 'skilled' ),
	'fields'     => array(
		array(
			'id'         => 'headings-typography-h1',
			'type'       => 'typography',
			'title'      => __( 'H1', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h1', 'h1 a' ),
			'default'    => array(
				'font-size'   => '48px',
				'line-height' => '52px',
			),
		),
		array(
			'id'             => 'headings-margin-h1',
			'type'           => 'spacing',
			'compiler'       => array( 'h1', 'h1 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'H1 Margin', 'skilled' ),
			'default'        => array(
				'margin-top'    => '33px',
				'margin-right'  => 0,
				'margin-bottom' => '33px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h2',
			'type'       => 'typography',
			'title'      => __( 'H2', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h2', 'h2 a' ),
			'default'    => array(
				'font-size'   => '30px',
				'line-height' => '34px',
			),
		),
		array(
			'id'             => 'headings-margin-h2',
			'type'           => 'spacing',
			'compiler'       => array( 'h2', 'h2 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'H2 Margin', 'skilled' ),
			'default'        => array(
				'margin-top'    => '25px',
				'margin-right'  => 0,
				'margin-bottom' => '25px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h3',
			'type'       => 'typography',
			'title'      => __( 'H3', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h3', 'h3 a' ),
			'default'    => array(
				'font-size'   => '22px',
				'line-height' => '24px',
			),
		),
		array(
			'id'             => 'headings-margin-h3',
			'type'           => 'spacing',
			'compiler'       => array( 'h3', 'h3 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'H3 Margin', 'skilled' ),
			'default'        => array(
				'margin-top'    => '22px',
				'margin-right'  => 0,
				'margin-bottom' => '22px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h4',
			'type'       => 'typography',
			'title'      => __( 'H4', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h4', 'h4 a' ),
			'default'    => array(
				'font-size'   => '20px',
				'line-height' => '24px',
			),
		),
		array(
			'id'             => 'headings-margin-h4',
			'type'           => 'spacing',
			'compiler'       => array( 'h4', 'h4 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'H4 Margin', 'skilled' ),
			'default'        => array(
				'margin-top'    => '25px',
				'margin-right'  => 0,
				'margin-bottom' => '25px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h5',
			'type'       => 'typography',
			'title'      => __( 'H5', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h5', 'h5 a' ),
			'default'    => array(
				'font-size'   => '18px',
				'line-height' => '22px',
			),
		),
		array(
			'id'             => 'headings-margin-h5',
			'type'           => 'spacing',
			'compiler'       => array( 'h5', 'h5 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'H5 Margin', 'skilled' ),
			'default'        => array(
				'margin-top'    => '30px',
				'margin-right'  => 0,
				'margin-bottom' => '30px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h6',
			'type'       => 'typography',
			'title'      => __( 'H6', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h6', 'h6 a' ),
			'default'    => array(
				'font-size'   => '16px',
				'line-height' => '20px',
			),
		),
		array(
			'id'             => 'headings-margin-h6',
			'type'           => 'spacing',
			'compiler'       => array( 'h6', 'h6 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'H6 Margin', 'skilled' ),
			'default'        => array(
				'margin-top'    => '36px',
				'margin-right'  => 0,
				'margin-bottom' => '36px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
	)
) );
// -> End Body

// ----------------------------------
// -> Header
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'header',
	'title'  => __( 'Header', 'skilled' ),
	'icon'   => 'el-icon-delicious',
	'fields' => array(
		array(
			'id'       => 'header-background',
			'type'     => 'background',
			'compiler' => array( '.wh-header, .respmenu-wrap' ),
			'title'    => __( 'Background', 'skilled' ),
			'subtitle' => __( 'Pick a background color for the header', 'skilled' ),
			'default'  => array(
				'background-color' => '#bfbfbf'
			),
		),
		array(
			'id'       => 'logo',
			'type'     => 'media',
			'title'    => __( 'Logo', 'skilled' ),
			'url'      => true,
			'mode'     => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __( 'Upload logo', 'skilled' ),

		),
		array(
			'id'       => 'logo-sticky',
			'type'     => 'media',
			'title'    => __( 'Sticky Menu Logo', 'skilled' ),
			'url'      => true,
			'mode'     => false, // Can be set to false to allow any media type, or can also be set to any mime type.
			'subtitle' => __( 'If not set Logo will be used in sticky menu.', 'skilled' ),

		),
		array(
		    'id'       => 'logo-location',
		    'type'     => 'select',
		    'title'    => __('Logo Location', 'skilled'),
		    'options'  => array(
		        'main_menu' => 'Main Menu',
		        'top_bar_additional' => 'Top Bar Additional',
			),
		    'default'  => array('main_menu'),
		),
		array(
			'id'            => 'logo-width',
			'type'          => 'slider',
			'title'         => __( 'Logo Width/ Menu Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change logo width.', 'skilled' ),
			'desc'          => __( 'The grid has 12 steps. If Logo location is set to Main Menu, the menu will take what is left up to 12. If logo is set to 12 menu will also take up 12 and will be put bellow it.',
				'skilled' ),
			'default'       => 3,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label',
		),
		array(
			'id'             => 'logo-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-logo' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'right'          => false,
			'left'           => false,
			'bottom'         => false,
			'title'          => __( 'Logo Margin Top', 'skilled' ),
			'default'        => array(
				'units'          => 'px',
			),

		),
		array(
			'id'       => 'logo-alignment',
			'type'     => 'button_set',
			'title'    => __( 'Logo Alignment', 'skilled' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'left',
		),
		array(
			'id'       => 'main-menu-alignment',
			'type'     => 'button_set',
			'title'    => __( 'Menu Alignment', 'skilled' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'right',
		),
		array(
			'id'      => 'header-padding-override',
			'type'    => 'switch',
			'title'   => __( 'Override Header Padding', 'skilled' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'             => 'header-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-main-menu-bar-wrapper > .cbp-container > div' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Header Padding', 'skilled' ),
			'default'        => array(
				'padding-top'    => '5px',
				'padding-right'  => '20px',
				'padding-bottom' => '5px',
				'padding-left'   => '20px',
				'units'          => 'px',
			),
			'required'       => array(
				array( 'header-padding-override', 'equals', '1' ),
			),

		),
	)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-header-top-bar',
	'title'      => __( 'Top Bar', 'skilled' ),
	'fields'     => array(
		array(
			'id'       => 'top-bar-use',
			'type'     => 'switch',
			'title'    => __( 'Use Top Bar', 'skilled' ),
			'default'  => false,
			'compiler' => 'true',
			'on'       => 'Yes',
			'off'      => 'No',
		),
		array(
			'id'       => 'top-bar-background',
			'type'     => 'background',
			'compiler' => array( '.wh-top-bar' ),
			'title'    => __( 'Background', 'skilled' ),
			'subtitle' => __( 'Pick a background color for the top bar', 'skilled' ),
			'default'  => array(),
			'required' => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'         => 'top-bar-typography',
			'type'       => 'typography',
			'title'      => __( 'Font', 'skilled' ),
			'subtitle'   => __( 'Specify font properties.', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( '.wh-top-bar' ),
			'default'    => array(
				'color'       => '#333',
				'font-size'   => '14px',
				'line-height' => '22px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
			'required'   => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'top-bar-menu-typography',
			'type'           => 'typography',
			'title'          => __( 'Menu Font', 'skilled' ),
			'subtitle'       => __( 'Specify the top bar menu font properties.', 'skilled' ),
			'google'         => true,
			'text-align'     => false,
			'color'          => false,
			'text-transform' => true,
			'compiler'       => array( '.wh-top-bar a' ),
			'default'        => array(
				'font-size'   => '14px',
				'line-height' => '22px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
			'required'       => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-menu-alignment',
			'type'     => 'button_set',
			'title'    => __( 'Menu Alignment', 'skilled' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'right',
			'required' => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-link-color',
			'type'     => 'link_color',
			'title'    => __( 'Link Color', 'skilled' ),
			'compiler' => array( '.wh-top-bar a' ),
			'default'  => array(
				'regular' => '#000',
				'hover'   => '#bbb',
				'active'  => '#ccc',
			),
			'required' => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-text',
			'type'     => 'editor',
			'title'    => __( 'Text Block', 'skilled' ),
			'default'  => 'Demo Top Bar Text',
			'args'     => array(
				'teeny'         => false,
				'media_buttons' => false
			),
			'required' => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-text-alignment',
			'type'     => 'button_set',
			'title'    => __( 'Text Block Alignment', 'skilled' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'left',
			'required' => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-layout',
			'type'     => 'sorter',
			'title'    => 'Layout Manager',
			'desc'     => 'Organize how you want the elements to appear in the top bar.',
			'options'  => array(
				'enabled'  => array(
					'text' => 'Top Bar Text',
					'menu' => 'Menu',
				),
				'disabled' => array(
				),
			),
			'required' => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'            => 'top-bar-menu-width',
			'type'          => 'slider',
			'title'         => __( 'Menu Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change menu width grid steps.', 'skilled' ),
			'desc'          => __( 'The grid has 12 steps.', 'skilled' ),
			'default'       => 6,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label',
			'required'      => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'            => 'top-bar-text-width',
			'type'          => 'slider',
			'title'         => __( 'Text Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change text width grid steps.', 'skilled' ),
			'desc'          => __( 'The grid has 12 steps.', 'skilled' ),
			'default'       => 6,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label',
			'required'      => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-padding-override',
			'type'     => 'switch',
			'title'    => __( 'Override Top Bar Padding', 'skilled' ),
			'default'  => false,
			'on'       => 'Yes',
			'off'      => 'No',
			'required' => array(
				array( 'top-bar-use', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'top-bar-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-top-bar > .cbp-container > div' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Top Bar Padding', 'skilled' ),
			'default'        => array(
				'padding-top'    => '5px',
				'padding-right'  => '20px',
				'padding-bottom' => '5px',
				'padding-left'   => '20px',
				'units'          => 'px',
			),
			'required'       => array(
				array( 'top-bar-use', 'equals', '1' ),
				array( 'top-bar-padding-override', 'equals', '1' ),
			),

		),
	)
) );


Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-header-top-bar-additional',
	'title'      => __( 'Top Bar Additional', 'skilled' ),
	'fields'     => array(
		array(
			'id'       => 'top-bar-additional-use',
			'type'     => 'switch',
			'title'    => __( 'Use Top Bar Additional', 'skilled' ),
			'default'  => false,
			'compiler' => 'true',
			'on'       => 'Yes',
			'off'      => 'No',
		),
		array(
			'id'       => 'top-bar-additional-show-on-mobile',
			'type'     => 'switch',
			'title'    => __( 'Show on Mobile Devices', 'skilled' ),
			'default'  => false,
			'compiler' => 'true',
			'on'       => 'Yes',
			'off'      => 'No',
		),
		array(
			'id'       => 'top-bar-additional-background',
			'type'     => 'background',
			'compiler' => array( '.wh-top-bar-additional' ),
			'title'    => __( 'Background', 'skilled' ),
			'subtitle' => __( 'Pick a background color for the top bar', 'skilled' ),
			'default'  => array(),
			'required' => array(
				array( 'top-bar-additional-use', 'equals', '1' ),
			),
		),
		array(
			'id'         => 'top-bar-additional-typography',
			'type'       => 'typography',
			'title'      => __( 'Font', 'skilled' ),
			'subtitle'   => __( 'Specify font properties.', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( '.wh-top-bar-additional' ),
			'default'    => array(
				'color'       => '#333',
				'font-size'   => '14px',
				'line-height' => '22px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
			'required'   => array(
				array( 'top-bar-additional-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-additional-link-color',
			'type'     => 'link_color',
			'title'    => __( 'Link Color', 'skilled' ),
			'compiler' => array( '.wh-top-bar-additional a' ),
			'default'  => array(
				'regular' => '#000',
				'hover'   => '#bbb',
				'active'  => '#ccc',
			),
			'required' => array(
				array( 'top-bar-additional-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-additional-text',
			'type'     => 'editor',
			'title'    => __( 'Text Block', 'skilled' ),
			'default'  => 'Demo Top Bar Additional Text',
			'args'     => array(
				'teeny'         => false,
				'media_buttons' => false
			),
			'required' => array(
				array( 'top-bar-additional-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-additional-text-alignment',
			'type'     => 'button_set',
			'title'    => __( 'Text Block Alignment', 'skilled' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'left',
			'required' => array(
				array( 'top-bar-additional-use', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'top-bar-additional-padding-override',
			'type'     => 'switch',
			'title'    => __( 'Override Top Bar Padding', 'skilled' ),
			'default'  => false,
			'on'       => 'Yes',
			'off'      => 'No',
			'required' => array(
				array( 'top-bar-additional-use', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'top-bar-additional-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-top-bar-additional > .cbp-container > div' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Top Bar Padding', 'skilled' ),
			'default'        => array(
				'padding-top'    => '5px',
				'padding-right'  => '20px',
				'padding-bottom' => '5px',
				'padding-left'   => '20px',
				'units'          => 'px',
			),
			'required'       => array(
				array( 'top-bar-additional-use', 'equals', '1' ),
				array( 'top-bar-additional-padding-override', 'equals', '1' ),
			),

		),
		array(
			'id'       => 'top-bar-additional-border',
			'type'     => 'border',
			'title'    => __('Border', 'skilled'),
			'compiler' => array('.wh-top-bar-additional'),
			'all'      => false,
			'top'      => false,
			'right'    => false,
			'left'     => false,
			'default'  => array(
				'border-color'  => '#ccc',
				'border-style'  => 'solid',
				'border-top'    => '1px',
			)
		)
	)
) );



Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-header-main-menu',
	'title'      => __( 'Main Menu', 'skilled' ),
		'fields'     => array(
			array(
			    'id'             => 'menu-main-top-level-typography',
			    'type'           => 'typography',
			    'title'          => __('Top Level Items Typography', 'skilled'),
			    'google'         => true,    // Disable google fonts. Won't work if you haven't defined your google api key
			    'font-backup'    => true,    // Select a backup non-google font in addition to a google font
			    'color'          => false,
			    'text-transform' => true,
			    'all_styles'     => true,    // Enable all Google Font style/weight variations to be added to the page
			    'compiler'         => array('.sf-menu.wh-menu-main a, .respmenu li a'), // An array of CSS selectors to apply this font style to dynamically
			    'units'          => 'px', // Defaults to px
			    'default'        => array(
			        'font-style'    => '700',
			        'font-family'   => 'Abel',
			        'google'        => true,
			        'font-size'     => '18px',
			        'line-height'   => '24px'
			    ),
			),
			array(
			    'id'             => 'menu-main-sub-items-typography',
			    'type'           => 'typography',
			    'title'          => __('Subitems Typography', 'skilled'),
			    'google'         => true,    // Disable google fonts. Won't work if you haven't defined your google api key
			    'font-backup'    => true,    // Select a backup non-google font in addition to a google font
			    'color'          => false,
			    'text-transform' => true,
			    'all_styles'     => true,    // Enable all Google Font style/weight variations to be added to the page
			    'compiler'         => array('.sf-menu.wh-menu-main ul li a'), // An array of CSS selectors to apply this font style to dynamically
			    'units'          => 'px', // Defaults to px
			    'default'        => array(
			        'font-style'    => '700',
			        'font-family'   => 'Abel',
			        'google'        => true,
			        'font-size'     => '16px',
			        'line-height'   => '24px'
			    ),
			),
			array(
			    'id'        => 'main-menu-link-color',
			    'type'      => 'link_color',
			    'title'     => __('Menu Item Link Color', 'skilled'),
			    'active'    => false, // Disable Active Color
			    'compiler'     => array('.sf-menu.wh-menu-main a', '.respmenu li a', '.cbp-respmenu-more'),
			    'default'   => array(
			        'regular'   => '#000',
			        'hover'     => '#333',
			    ),
			),
			array(
			    'id'        => 'main-menu-menu-item-hover-background',
			    'type'      => 'background',
			    'compiler'    => array('.sf-menu.wh-menu-main > li:hover, .sf-menu.wh-menu-main > li.sfHover'),
			    'title'     => __('Menu Item Hover Background', 'skilled'),
			    'subtitle'  => __('Pick a background color for the menu item on hover.', 'skilled'),
			),
			array(
			    'id'        => 'main-menu-current-item-background',
			    'type'      => 'background',
			    'compiler'    => array(
				    '.sf-menu.wh-menu-main .current-menu-item',
				    '.respmenu_current'
			    ),
			    'title'     => __('Current Menu Item Background', 'skilled'),
			    'subtitle'  => __('Pick a background color for the current menu item.', 'skilled'),
			),
			array(
			    'id'        => 'main-menu-current-item-link-color',
			    'type'      => 'link_color',
			    'title'     => __('Current Menu Item Link Color', 'skilled'),
			    'active'    => false, // Disable Active Color
			    'compiler'     => array('.sf-menu.wh-menu-main .current-menu-item a'),
			    'default'   => array(
			        'regular'   => '#000',
			        'hover'     => '#333',
			    ),
			),
			array(
			    'id'        => 'main-menu-submenu-item-background',
			    'type'      => 'background',
			    'compiler'    => array(
					'.sf-menu.wh-menu-main ul li',
					'.sf-menu.wh-menu-main .sub-menu',
				),
			    'title'     => __('Submenu Menu Item Background', 'skilled'),
			    'default'   => array(
			        'background-color'   => '#fff',
			    ),
			),
			array(
			    'id'        => 'main-menu-submenu-item-hover-background',
			    'type'      => 'background',
			    'compiler'    => array('.sf-menu.wh-menu-main ul li:hover, .sf-menu.wh-menu-main ul ul li:hover'),
			    'title'     => __('Subenu Item Hover Background', 'skilled'),
			    'subtitle'  => __('Pick a background color for the menu item on hover.', 'skilled'),
			),
			array(
			    'id'        => 'main-menu-submenu-item-link-color',
			    'type'      => 'link_color',
			    'title'     => __('Submenu Item Link Color', 'skilled'),
			    'active'    => false, // Disable Active Color
			    'compiler'     => array('.sf-menu.wh-menu-main ul li a'),
			    'default'   => array(
			        'regular'   => '#000',
			        'hover'     => '#333',
			    ),
			),
			array(
			    'id'             => 'main-menu-padding',
			    'type'           => 'spacing',
			    'compiler'         => array('.wh-menu-main'),
			    'mode'           => 'padding',
			    'units'          => array('px'),
			    'units_extended' => 'false',
			    'title'          => __('Padding Top', 'skilled'),
			    'description'    => __('Use it to better vertical align the menu', 'skilled'),
			    'left' => false,
			    'right' => false,
			    'default'            => array(
			        'padding-top'    => '0',
			        'padding-bottom' => '0',
			        'units'          => 'px',
			    ),
			),
			array(
			    'id'        => 'main-menu-use-menu-is-sticky',
			    'type'      => 'switch',
			    'title'     => __('Enable Sticky Menu', 'skilled'),
			    'default'   => 1,
			),
			array(
				'id'       => 'main-menu-sticky-background',
				'type'     => 'background',
				'title'    => __('Sticky Menu Background', 'skilled'),
				'compiler'         => array('.wh-sticky-header .wh-main-menu-bar-wrapper'),
				'default'  => array(
				   'background-color' => '#999',
				),
			    'required' => array(
					array( 'main-menu-use-menu-is-sticky', 'equals', '1' ),
				),
			),
			array(
				'id'             => 'main-menu-sticky-padding',
				'type'           => 'spacing',
				'compiler'         => array('.wh-sticky-header .wh-menu-main'),
				'mode'           => 'padding',
				'units'          => array('px'),
				'units_extended' => 'false',
				'title'          => __('Sticky Menu Padding', 'skilled'),
				'description'    => __('Use it to better vertical align the menu', 'skilled'),
				'left' => false,
				'right' => false,
				'default'            => array(
					'padding-top'    => '0',
					'padding-bottom' => '0',
					'units'          => 'px',
				),
				'required' => array(
					array( 'main-menu-use-menu-is-sticky', 'equals', '1' ),
				)
			),
			array(
			    'id'       => 'main-menu-sticky-border',
			    'type'     => 'border',
			    'title'    => __('Sticky Menu Border', 'skilled'),
			    'compiler' => array('.wh-sticky-header .wh-main-menu-bar-wrapper'),
			    'all'      => false,
			    'bottom'   => true,
			    'top'      => false,
			    'left'     => false,
			    'right'    => false,
			    'default'  => array(
			        'border-color'  => '#f5f5f5',
			        'border-style'  => 'solid',
			        'border-bottom' => '1px',
			    )
			),
			array(
			    'id'          => 'main-menu-initial-waypoint-compensation',
			    'type'        => 'text',
			    'title'       => __('Initial Waypoint Scroll Compensation', 'skilled'),
			    'description' => __('Enter number only.', 'skilled'),
			    'validate'    => 'number',
			    'default'     => 120
			),

		)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-header-responsive-menu',
	'title'      => __('Responsive Menu', 'skilled'),
    'fields'    => array(
        array(
            'id'        => 'respmenu-use',
            'type'      => 'switch',
            'compiler'  => 'true',
            'title'     => __('Use Responsive Menu?', 'skilled'),
            'default'   => true,
        ),
        array(
            'id'        => 'respmenu-show-start',
            'type'      => 'spinner',
            'title'     => __('Display bellow', 'skilled'),
            'desc'      => __('Set the width of the screen in px bellow which the menu is shown.', 'skilled'),
            'default'   => '767',
            'min'   => '50',
            'max'   => '2000',
            'step'     => '1',
            'required' => array(
                array('respmenu-use','equals','1'),
            ),
        ),
        array(
            'id'        => 'respmenu-logo',
            'type'      => 'media',
            'title'     => __('Logo', 'skilled'),
            'url'       => true,
            'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'subtitle'  => __('Set logo image', 'skilled'),
            'required' => array(
                array('respmenu-use','equals','1'),
            ),
        ),
        array(
            'id'       => 'respmenu-logo-dimensions',
            'type'     => 'dimensions',
            'units'    => array('em','px','%'),
            'title'    => __('Logo Dimensions (Width/Height)', 'skilled'),
            'compiler' => array('.respmenu-header .respmenu-header-logo-link'),
            'required' => array(
                array('respmenu-use','equals','1'),
            ),
        ),
		array(
			'id'          => 'respmenu-display-switch-color',
			'type'        => 'color',
			'mode'        => 'border-color',
			'title'       => __( 'Display Toggle Color', 'skilled' ),
			'compiler'    => array('.respmenu-open hr'),
			'transparent' => false,
			'default'     => '#000',
			'validate'    => 'color',
		),
        array(
			'id'          => 'respmenu-display-switch-color-hover',
			'type'        => 'color',
			'mode'        => 'border-color',
			'title'       => __( 'Display Toggle Hover Color', 'skilled' ),
			'compiler'    => array('.respmenu-open:hover hr'),
			'transparent' => false,
			'default'     => '#999',
			'validate'    => 'color',
		),
        array(
            'id'        => 'respmenu-display-switch-img',
            'type'      => 'media',
            'title'     => __('Display Toggle Image', 'skilled'),
            'url'       => true,
            'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'subtitle'  => __('Set the image to replace default 3 lines for menu toggle button.', 'skilled'),
            'required' => array(
                array('respmenu-use','equals','1'),
            ),
        ),
        array(
            'id'       => 'respmenu-display-switch-img-dimensions',
            'type'     => 'dimensions',
            'units'    => array('em','px','%'),
            'title'    => __('Display Toggle Image Dimensions (Width/Height)', 'skilled'),
            'compiler' => array('.respmenu-header .respmenu-open img'),
            'required' => array(
                array('respmenu-use','equals','1'),
            ),
        ),
    )
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-header-embellishments',
	'title'      => __( 'Embellishments', 'skilled' ),
	'fields'     => array(
		array(
			'id'      => 'header-embellishments-enable',
			'type'    => 'switch',
			'title'   => __( 'Enable', 'skilled' ),
			'default' => false,
		),
		array(
			'id'       => 'header-embellishment-background-top',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-header-top' ),
			'title'    => __( 'Embellishment Top Background', 'skilled' ),
			'required' => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'header-embellishment-background-top-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => __( 'Embellishment Top Container Height', 'skilled' ),
			'compiler' => array( '.wh-embellishment-header-top' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'header-embellishment-background-top-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-header-top' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Embellishment Top Container Margin', 'skilled' ),
			'desc'           => __( 'Use negative top margin to pull it up.', 'skilled' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'header-embellishment-background-bottom',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-header-bottom' ),
			'title'    => __( 'Embellishment Bottom Background', 'skilled' ),
			'required' => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'header-embellishment-background-bottom-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => __( 'Embellishment Bottom Container Height', 'skilled' ),
			'compiler' => array( '.wh-embellishment-header-bottom' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'header-embellishment-background-bottom-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-header-bottom' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Embellishment Bottom Container Margin', 'skilled' ),
			'desc'           => __( 'Use negative bottom margin to pull it down.', 'skilled' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),

	)
) );
// -> End Header

// ----------------------------------
// -> Page Title
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-page-title',
	'title'  => __( 'Page Title', 'skilled' ),
	'icon'   => 'el-icon-font',
	'fields' => array(
		array(
			'id'       => 'page-title-background',
			'type'     => 'background',
			'compiler' => array( '.wh-page-title-bar' ),
			'title'    => __( 'Background', 'skilled' ),
			'subtitle' => __( 'Pick a background color for the page title.', 'skilled' ),
			'default'  => array(
				'background-color' => '#bfbfbf'
			),
		),
		array(
			'id'             => 'page-title-typography',
			'type'           => 'typography',
			'title'          => __( 'Page Title Font', 'skilled' ),
			'subtitle'       => __( 'Specify the page title font properties.', 'skilled' ),
			'google'         => true,
			'text-align'     => true,
			'text-transform' => true,
			'compiler'       => array( 'h1.page-title' ),
			'default'        => array(
				'color'       => '#333',
				'font-size'   => '48px',
				'line-height' => '48px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'             => 'page-title-spacing',
			'type'           => 'spacing',
			'compiler'       => array( '.page-title' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Page Title Margin', 'skilled' ),
			'default'        => array(
				'margin-top'    => '33px',
				'margin-right'  => '0px',
				'margin-bottom' => '33px',
				'margin-left'   => '0px',
				'units'         => 'px',
			),

		),
		array(
			'id'       => 'page-title-wrapper-padding-override',
			'type'     => 'switch',
			'title'    => __( 'Override Top Bar Padding', 'skilled' ),
			'default'  => false,
			'on'       => 'Yes',
			'off'      => 'No',
			'required' => array(
				array( 'top-bar-additional-use', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'page-title-wrapper-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-page-title-wrapper' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Page Title Wrapper Padding', 'skilled' ),
			'default'        => array(
				'padding-top'    => '5px',
				'padding-right'  => '20px',
				'padding-bottom' => '5px',
				'padding-left'   => '20px',
				'units'          => 'px',
			),
			'required'       => array(
				array( 'page-title-wrapper-padding-override', 'equals', '1' ),
			),

		),
	),
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-page-title-breadcrumbs',
	'title'      => __( 'Breadcrumbs', 'skilled' ),
	'fields'     => array(
		array(
			'id'      => 'page-title-breadcrumbs-enable',
			'type'    => 'switch',
			'title'   => __( 'Enable', 'skilled' ),
			'default' => true,
		),
		array(
			'id'       => 'page-title-breadcrumbs-position',
			'type'     => 'button_set',
			'title'    => __( 'Position', 'skilled' ),
			'options'  => array(
				'above_title'  => 'Above the title',
				'bellow_title' => 'Bellow the title',
			),
			'default'  => 'bellow_title',
			'required' => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'page-title-breadcrumbs-typography',
			'type'           => 'typography',
			'title'          => __( 'Font', 'skilled' ),
			'google'         => true,
			'font-backup'    => true,
			'text-transform' => true,
			'compiler'       => array( '.wh-breadcrumbs' ),
			'units'          => 'px',
			'default'        => array(
				'color'       => '#333',
				'font-style'  => '700',
				'font-family' => 'Abel',
				'google'      => true,
				'font-size'   => '14px',
				'line-height' => '10px'
			),
			'required'       => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-breadcrumbs-link-color',
			'type'     => 'link_color',
			'title'    => __( 'Links Color', 'skilled' ),
			'active'   => false,
			'compiler' => array( '.wh-breadcrumbs a' ),
			'default'  => array(
				'regular' => '#333',
				'hover'   => '#999',
			),
			'required' => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-breadcrumbs-alignment',
			'type'     => 'button_set',
			'title'    => __( 'Alignment', 'skilled' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'left',
			'required' => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
	)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-page-title-embellishments',
	'title'      => __( 'Embellishments', 'skilled' ),
	'fields'     => array(
		array(
			'id'      => 'page-title-embellishments-enable',
			'type'    => 'switch',
			'title'   => __( 'Enable', 'skilled' ),
			'default' => false,
		),
		array(
			'id'       => 'page-title-embellishment-background-top',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-page-title-top' ),
			'title'    => __( 'Embellishment Top Background', 'skilled' ),
			'required' => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-embellishment-background-top-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => __( 'Embellishment Top Container Height', 'skilled' ),
			'compiler' => array( '.wh-embellishment-page-title-top' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'page-title-embellishment-background-top-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-page-title-top' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Embellishment Top Container Margin', 'skilled' ),
			'desc'           => __( 'Use negative top margin to pull it up.', 'skilled' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-embellishment-background-bottom',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-page-title-bottom' ),
			'title'    => __( 'Embellishment Bottom Background', 'skilled' ),
			'required' => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-embellishment-background-bottom-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => __( 'Embellishment Bottom Container Height', 'skilled' ),
			'compiler' => array( '.wh-embellishment-page-title-bottom' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'page-title-embellishment-background-bottom-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-page-title-bottom' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Embellishment Bottom Container Margin', 'skilled' ),
			'desc'           => __( 'Use negative bottom margin to pull it down.', 'skilled' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),

	)
) );
// -> End Page Title

// ----------------------------------
// -> Content
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-content',
	'title'  => __( 'Content', 'skilled' ),
	'icon'   => 'el-icon-file-edit',
	'fields' => array(
		array(
			'id'       => 'content-background',
			'type'     => 'background',
			'compiler' => array( '.wh-content' ),
			'title'    => __( 'Background', 'skilled' ),
			'subtitle' => __( 'Pick a background color for the content', 'skilled' ),
		),
		array(
			'id'             => 'content-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-content' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Padding', 'skilled' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'padding-top'    => '20',
				'padding-bottom' => '20',
				'units'       => 'px',
			)
		),
		array(
			'id'            => 'content-width',
			'type'          => 'slider',
			'title'         => __( 'Content Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change menu width grid steps.', 'skilled' ),
			'desc'          => __( 'The grid has 12 steps.', 'skilled' ),
			'default'       => 9,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label'
		),
		array(
			'id'            => 'sidebar-width',
			'type'          => 'slider',
			'title'         => __( 'Sidebar Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change menu width grid steps.', 'skilled' ),
			'desc'          => __( 'The grid has 12 steps.', 'skilled' ),
			'default'       => 3,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label'
		),
		array(
		    'id'       => 'content-hr',
		    'type'     => 'border',
		    'title'    => __('HR', 'skilled'),
		    'subtitle' => __('Style content HR element', 'skilled'),
		    'compiler' => array( '.wh-content hr' ),
		    'bottom' => false,
		    'right' => false,
		    'left' => false,
		    'default'  => array(
		        'border-color'  => '#000',
		        'border-style'  => 'solid',
		        'border-top'    => '1px',
		    )
		),
		array(
		    'id'       => 'content-hr-width',
		    'type'     => 'dimensions',
		    'units'    => array('em','px','%'),
		    'title'    => __('HR Width', 'skilled'),
		    'height'    => false,
		    'compiler' => array( '.wh-content hr' ),
		    'default'  => array(
		        'width'   => '100',
		        'units'  => '%'
		    ),
		),
		array(
		    'id'             => 'content-hr-spacing',
		    'type'           => 'spacing',
		    'compiler' => array( '.wh-content hr' ),
		    'mode'           => 'margin',
		    'units'          => array('em', 'px'),
		    'units_extended' => 'false',
		    'title'          => __('HR Margin', 'skilled'),
		    'default'            => array(
		        'margin-top'     => '3px',
		        'margin-right'   => '0px',
		        'margin-bottom'  => '3px',
		        'margin-left'    => '0px',
		        'units'          => 'px',
		    )
		),

	),
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-content-embellishments',
	'title'      => __( 'Embellishments', 'skilled' ),
	'fields'     => array(
		array(
			'id'      => 'content-embellishments-enable',
			'type'    => 'switch',
			'title'   => __( 'Enable', 'skilled' ),
			'default' => false,
		),
		array(
			'id'       => 'content-embellishment-background-top',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-content-top' ),
			'title'    => __( 'Embellishment Top Background', 'skilled' ),
			'required' => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'content-embellishment-background-top-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => __( 'Embellishment Top Container Height', 'skilled' ),
			'compiler' => array( '.wh-embellishment-content-top' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'content-embellishment-background-top-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-content-top' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Embellishment Top Container Margin', 'skilled' ),
			'desc'           => __( 'Use negative top margin to pull it up.', 'skilled' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'content-embellishment-background-bottom',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-content-bottom' ),
			'title'    => __( 'Embellishment Bottom Background', 'skilled' ),
			'required' => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'content-embellishment-background-bottom-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => __( 'Embellishment Bottom Container Height', 'skilled' ),
			'compiler' => array( '.wh-embellishment-content-bottom' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'content-embellishment-background-bottom-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-content-bottom' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Embellishment Bottom Container Margin', 'skilled' ),
			'desc'           => __( 'Use negative bottom margin to pull it up.', 'skilled' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),

	)
) );
// -> End Content

// ----------------------------------
// -> Blog Archive
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-blog-archive',
	'title'  => __( 'Blog/Archive', 'skilled' ),
	'icon'   => 'el-icon-file',
	'fields' => array(
		array(
			'id'       => 'post-excerpt-length',
			'type'     => 'text',
			'title'    => __('Post Excerpt Length', 'skilled'),
			'subtitle' => __('This setting will be applied to any section using post excerpt','skilled'),
			'validate' => 'numeric',
			'msg'      => 'You must enter a number.',
			'default'  => 20
		),
	)
) );

Redux::setSection( $opt_name, array(
	'id'     => 'section-blog-archive-single',
	'title'  => __( 'Blog/Archive Single', 'skilled' ),
	'subsection'   => true,
	'fields' => array(
		array(
			'id'      => 'single-post-is-boxed',
			'type'    => 'switch',
			'title'   => __( 'Is Boxed?', 'skilled' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'      => 'single-post-sidebar-left',
			'type'    => 'switch',
			'title'   => __( 'Sidebar on the Left?', 'skilled' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'      => 'archive-single-use-share-this',
			'type'    => 'switch',
			'title'   => __( 'Use Share This buttons?', 'skilled' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),

	)
) );
// -> End Blog Archive


// ----------------------------------
// -> Sensei
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-sensei',
	'title'  => __( 'Sensei', 'skilled' ),
	'icon'   => 'el-icon-laptop',
	'fields' => array(
		array(
			'id'       => 'sensei-single-course-show-participant-count',
			'type'     => 'switch',
			'title'    => __( 'Show Participant Count?', 'skilled' ),
			'subtitle' => __( 'This will be applied on all single course pages', 'skilled' ),
			'default'  => true,
		),
		array(
			'id'      => 'sensei-single-course-header-image-show',
			'type'    => 'switch',
			'title'   => __( 'Enable Header Image', 'skilled' ),
			'default' => true,
		),
		array(
			'id'       => 'sensei-single-course-header-image',
			'type'     => 'background',
			'compiler' => array( '.course-header-image' ),
			'title'    => __( 'Header Image', 'skilled' ),
			'default'  => array(
				'background-color' => '#e5e5e5'
			),
			'required' => array(
				array( 'sensei-single-course-header-image-show', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'sensei-single-course-header-image-height',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => __( 'Header Image Height', 'skilled' ),
			'width'    => false,
			'compiler' => array( '.course-header-image' ),
			'default'  => array(
				'height' => '100px'
			),
		)
	),
) );


Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'section-course',
	'title'      => __( 'Course', 'skilled' ),
	'fields'     => array(
		array(
			'id'       => 'sensei-single-course-header-background',
			'type'     => 'background',
			'compiler' => array( '.wh-sensei-single-course-header' ),
			'title'    => __( 'Course Header Background', 'skilled' ),
			'default'  => array(
				'background-color' => '#e5e5e5'
			),
		),
		array(
			'id'       => 'sensei-single-course-header-border',
			'type'     => 'border',
			'title'    => __( 'Header Border Bottom', 'skilled' ),
			'compiler' => array( '.wh-sensei-single-course-header' ),
			'all'      => false,
			'left'     => false,
			'right'    => false,
			'top'      => false,
			'default'  => array(
				'border-color'  => '#1e73be',
				'border-style'  => 'solid',
				'border-bottom' => '1px',
			)
		),
		array(
			'id'          => 'sensei-single-course-title-typography',
			'type'        => 'typography',
			'title'       => __( 'Title Typography', 'skilled' ),
			'google'      => true,
			'font-backup' => true,
			'compiler'    => array( '.wh-sensei-title-wrap h1, .course-title' ),
			'units'       => 'px',
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '700',
				'font-family' => 'Roboto',
				'google'      => true,
				'font-size'   => '33px',
				'line-height' => '40px'
			),
		),
        array(
            'id'       => 'sensei-single-course-meta-item-color',
            'type'     => 'color',
            'title'       => __( 'Meta Data Text  Color', 'skilled' ),
            'compiler'    => array(
                '.single-course .sensei-course-meta .meta-item',
                '.single-lp_course .sensei-course-meta .meta-item',
                '.sensei-single-course-header-author-name',
            ),
            'default'  => '#000',
            'validate' => 'color',
        ),
		array(
		    'id'       => 'sensei-single-course-meta-hr',
		    'type'     => 'border',
		    'title'    => __('Course Meta HR', 'skilled'),
		    'compiler'   => array(
			    '.single-course .meta-wrap hr',
			    '.single-lp_course .meta-wrap hr'
		    ),
		    'left' => false,
		    'bottom' => false,
		    'right' => false,
		    'all' => false,
		    'default'  => array(
		        'border-color'  => '#333',
		        'border-style'  => 'solid',
		        'border-top'    => '1px',
		    )
		),
		array(
			'id'       => 'sensei-single-course-module-title-bg-color',
			'type'     => 'color',
			'mode'     => 'background-color',
			'compiler' => array( '.module header', '.module .module-lessons header' ),
			'title'    => __( 'Module Title Background Color', 'skilled' ),
			'default'  => '#F2F2F2',
			'validate' => 'color',
		),
		array(
			'id'       => 'sensei-single-course-lesson-icon-color',
			'type'     => 'color',
			'compiler' => array(
				'.module .module-lessons ul li a:hover:before',
				'.module .module-lessons ul li.completed a:before',
			 ),
			'title'    => __( 'Lesson Icon Color', 'skilled' ),
			'default'  => '#F2F2F2',
			'validate' => 'color',
		),
		array(
			'id'       => 'sensei-single-course-lesson-completed-bg-color',
			'type'     => 'color',
			'mode'     => 'background-color',
			'compiler' => array(
				'.course .status, .course-lessons .status, .course-container .status',
			 ),
			'title'    => __( 'Lesson Completed Background Color', 'skilled' ),
			'default'  => '#F2F2F2',
			'validate' => 'color',
		),
	)
));

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'section-lesson',
	'title'      => __( 'Courses Carousel', 'skilled' ),
	'fields'     => array(
		array(
			'id'          => 'linp-featured-courses-item-title-typography',
			'type'        => 'typography',
			'title'       => __( 'Title Typography', 'skilled' ),
			'google'      => true,
			'font-backup' => true,
			'text-transform' => true,
			'compiler'    => array( '.linp-featured-courses-carousel .course-title, .linp-featured-courses-carousel .course-title a' ),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'skilled' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '700',
				'font-family' => 'Abel',
				'google'      => true,
				'font-size'   => '33px',
				'line-height' => '40px'
			),
		),
		array(
			'id'          => 'linp-featured-courses-item-meta-typography',
			'type'        => 'typography',
			'title'       => __( 'Meta Typography', 'skilled' ),
			'google'      => true,
			'font-backup' => true,
			'text-transform' => true,
			'compiler'    => array(
				'.linp-featured-courses-carousel .sensei-course-meta',
				'.linp-featured-courses-carousel .sensei-course-meta a',
				'.linp-featured-courses-carousel .course-lesson-count',
			),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'skilled' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '700',
				'font-family' => 'Abel',
				'google'      => true,
				'font-size'   => '15px',
				'line-height' => '20px'
			),
		),
		array(
			'id'          => 'linp-featured-courses-item-text-typography',
			'type'        => 'typography',
			'title'       => __( 'Text Typography', 'skilled' ),
			'google'      => true,
			'font-backup' => true,
			'text-transform' => true,
			'compiler'    => array(
				'.linp-featured-courses-carousel .course-excerpt',
				'.linp-featured-courses-carousel .post-ratings',
				'.owl-theme .owl-controls .owl-buttons div',
				'.owl-theme .owl-controls .owl-page span',
			),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'skilled' ),
			'default'     => array(
				'color'       => '#333',
				'font-style'  => '700',
				'font-family' => 'Abel',
				'google'      => true,
				'font-size'   => '15px',
				'line-height' => '20px'
			),
		),
		array(
			'id'          => 'linp-featured-courses-item-price-regular-typography',
			'type'        => 'typography',
			'title'       => __( 'Regular Price Typography', 'skilled' ),
			'google'      => true,
			'font-backup' => true,
			'compiler'    => array(
				'.linp-featured-courses-carousel .owl-item .course-price .amount',
				'.linp-featured-courses-carousel .owl-item .course-price del .amount',
				'.wh-course-list-item .img-container .course-price .amount',
			),
			'units'       => 'px',
			'subtitle'    => __( 'Typography option with each property can be called individually.', 'skilled' ),
			'default'     => array(),
		),
		array(
			'id'       => 'linp-featured-courses-item-border-color',
			'type'     => 'color',
			'compiler' => 'true',
		    'title'    => __('Border Color', 'skilled'),
		    'default'  => '#E4E4E4',
		    'validate' => 'color',
		),
		array(
			'id'       => 'linp-featured-courses-item-wrapper-bg-color-inner',
			'type'     => 'color',
			'mode'     => 'background-color',
			'title'    => __( 'Inner Wrapper Background Color', 'skilled' ),
			'compiler' => array(
				'.linp-featured-courses-carousel .owl-item .item-inner-wrap',
				'.owl-theme .owl-controls .owl-buttons div',
				'.owl-theme .owl-controls .owl-page span',
			),
			'default'  => '',
			'validate' => 'color',
		),
		array(
			'id'       => 'linp-featured-courses-item-price-bg-color',
			'type'     => 'color',
			'mode'     => 'background-color',
			'title'    => __( 'Price Wrapper Background Color', 'skilled' ),
			'compiler' => array(
				'.linp-featured-courses-carousel .owl-item .course-price',
				'.wh-course-list-item .img-container .course-price',
				'.course-container article.course .course-price',
			),
			'default'  => '',
			'validate' => 'color',
		),
		array(
			'id'       => 'linp-featured-courses-item-ribbon-back-bg-color',
			'type'     => 'color',
			'compiler' => 'true',
		    'title'    => __('Ribbon Back Background Color', 'skilled'),
		    'default'  => '#333',
		    'validate' => 'color',
		),
		array(
			'id'       => 'linp-featured-courses-ratings-color',
			'type'     => 'link_color',
			'title'    => __( 'Rating Color', 'skilled' ),
			'compiler' => array(
				'.linp-featured-courses-carousel .star-rating',
			),
			'visited'  => false,
			'active'   => false,
			'default'  => array(
				'regular' => '#1e73be', // blue
				'hover'   => '#dd3333', // red
			)
		),
	)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'section-sensei-course-search',
	'title'      => __( 'Courses Search', 'skilled' ),
	'fields'     => array(
		array(
			'id'    => 'sensei-course-search-page',
			'type'  => 'select',
			'title' => __('Select Courses Search Page', 'skilled'),
			'data'  => 'pages'
		),
	)
) );
// -> End Sensei


// ----------------------------------
// -> Search Page
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-search-page',
	'title'  => __( 'Search Page', 'skilled' ),
	'icon'   => 'el-icon-search',
	'fields' => array(
		array(
			'id'      => 'search-page-use-sidebar',
			'type'    => 'switch',
			'title'   => __( 'Use Sidebar?', 'skilled' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'       => 'search-page-items-per-page',
			'type'     => 'text',
			'title'    => __( 'Items Per Page', 'skilled' ),
			'validate' => 'numeric',
			'msg'      => 'You must enter a number.',
			'default'  => 10
		),

	)
) );
// -> End Search Page


// ----------------------------------
// -> Footer
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-footer',
	'title'  => __( 'Footer', 'skilled' ),
	'icon'   => 'el-icon-credit-card',
	'fields' => array(
		array(
			'id'       => 'footer-background',
			'type'     => 'background',
			'compiler' => array( '.wh-footer-bottom' ),
			'title'    => __( 'Background', 'skilled' ),
			'subtitle' => __( 'Pick a background color for the footer.', 'skilled' ),
			'default'  => array(
				'background-color' => '#9e9e9e'
			),
		),
		array(
			'id'         => 'footer-typography',
			'type'       => 'typography',
			'title'      => __( 'Font', 'skilled' ),
			'subtitle'   => __( 'Specify the footer font properties.', 'skilled' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( '.wh-footer-bottom' ),
			'default'    => array(
				'color'       => '#333',
				'font-size'   => '14px',
				'line-height' => '22px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'             => 'footer-menu-typography',
			'type'           => 'typography',
			'title'          => __( 'Menu Font', 'skilled' ),
			'subtitle'       => __( 'Specify the footer menu font properties.', 'skilled' ),
			'google'         => true,
			'text-align'     => false,
			'color'          => false,
			'text-transform' => false,
			'compiler'       => array( '.wh-footer-bottom a' ),
			'default'        => array(
				'font-size'   => '14px',
				'line-height' => '22px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'      => 'footer-menu-alignment',
			'type'    => 'button_set',
			'title'   => __( 'Menu Alignment', 'skilled' ),
			'options' => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default' => 'left'
		),
		array(
			'id'       => 'footer-link-color',
			'type'     => 'link_color',
			'title'    => __( 'Link Color', 'skilled' ),
			'compiler' => array( '.wh-footer .wh-footer-bottom a' ),
			'default'  => array(
				'regular' => '#000',
				'hover'   => '#bbb',
				'active'  => '#ccc',
			)
		),
		array(
			'id'      => 'footer-text',
			'type'    => 'editor',
			'title'   => __( 'Text Block', 'skilled' ),
			'default' => 'Demo Footer Text',
			'args'    => array(
				'teeny'         => false,
				'media_buttons' => false
			),
		),
		array(
			'id'      => 'footer-text-alignment',
			'type'    => 'button_set',
			'title'   => __( 'Text Block Alignment', 'skilled' ),
			'options' => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default' => 'right'
		),
		array(
			'id'      => 'footer-layout',
			'type'    => 'sorter',
			'title'   => 'Layout Manager',
			'desc'    => 'Organize how you want the elements to appear in the footer.',
			'options' => array(
				'enabled'  => array(
					'menu'         => 'Menu',
					'text'         => 'Footer Text',
					'social_links' => 'Social Links',
				),
				'disabled' => array(),
			),
		),
		array(
			'id'            => 'footer-elements-grid-menu',
			'type'          => 'slider',
			'title'         => __( 'Menu Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change width grid steps.', 'skilled' ),
			'default'       => 4,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label'
		),
		array(
			'id'            => 'footer-elements-grid-text',
			'type'          => 'slider',
			'title'         => __( 'Text Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change width grid steps.', 'skilled' ),
			'default'       => 4,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label'
		),
		array(
			'id'            => 'footer-elements-grid-social-links',
			'type'          => 'slider',
			'title'         => __( 'Social Links Box Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change width grid steps.', 'skilled' ),
			'default'       => 4,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label'
		),
		array(
			'id'      => 'footer-social-links-alignment',
			'type'    => 'button_set',
			'title'   => __( 'Social Links Block Alignment', 'skilled' ),
			'options' => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default' => 'right'
		),
		array(
			'id'      => 'footer-bottom-padding-override',
			'type'    => 'switch',
			'title'   => __( 'Override Footer Bottom Padding', 'skilled' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'             => 'footer-bottom-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-footer-bottom > .cbp-container > div' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Footer Bottom Padding', 'skilled' ),
			'default'        => array(
				'padding-top'    => '0',
				'padding-right'  => '0',
				'padding-bottom' => '0',
				'padding-left'   => '0px',
				'units'          => 'px',
			),
			'required'       => array(
				array( 'footer-bottom-padding-override', 'equals', '1' ),
			),

		),
		array(
			'id'      => 'footer-bottom-separator-use',
			'type'    => 'switch',
			'title'   => __( 'Use Footer Bottom Separator', 'skilled' ),
			'desc'     => __('Enable the separator between Footer Widgets and Footer Bottom.', 'skilled'),
			'compiler' => 'true',
			'default' => true,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
		    'id'       => 'footer-bottom-separator',
		    'type'     => 'border',
		    'title'    => __('Footer Bottom Separator', 'skilled'),
		    'compiler'   => array('.wh-footer-separator'),
		    'right'    => false,
		    'bottom'   => false,
		    'left'     => false,
		    'default'  => array(
		        'border-color'  => '#333',
		        'border-style'  => 'solid',
		        'border-top'    => '1px',
		    ),
		    'required'       => array(
				array( 'footer-bottom-separator-use', 'equals', '1' ),
			),
		),
		array(
		    'id'             => 'footer-bottom-separator-padding',
		    'type'           => 'spacing',
		    'compiler'       => array('.wh-footer-separator-container'),
		    'mode'           => 'padding',
		    'units'          => array('em', 'px'),
		    'units_extended' => 'false',
		    'title'          => __('Footer Bottom Separator Padding', 'skilled'),
		    'default'            => array(
		        'padding-top'     => '0px',
		        'padding-right'   => '15px',
		        'padding-bottom'  => '0px',
		        'padding-left'    => '15px',
		        'units'          => 'px',
		    ),
		    'required'       => array(
				array( 'footer-bottom-separator-use', 'equals', '1' ),
			),
		),
		array(
		    'id' => 'footer-social-links',
		    'type' => 'multi_text',
		    'title' => __('Social Links', 'skilled'),
		    'desc' => __('Use this form: fa fa-twitter|http://google.com|20. First segment is icon name. The second is the link and the third is font size.', 'skilled'),
			'default' => array(
				'fa fa-twitter|http://google.com|20',
				'fa fa-google-plus|http://google.com|20',
				'fa fa-linkedin|http://google.com|20',
			),
		),
	)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-footer-widgets',
	'title'      => __( 'Footer Widgets', 'skilled' ),
	'fields'     => array(
		array(
			'id'       => 'footer-widget-background',
			'type'     => 'background',
			'compiler' => array( '.wh-footer' ),
			'title'    => __( 'Background', 'skilled' ),
			'default'  => array(
				'background-color' => '#bfbfbf'
			),
		),
		array(
			'id'       => 'footer-widget-title-typography',
			'type'     => 'typography',
			'title'    => __( 'Title Font', 'skilled' ),
			'subtitle' => __( 'Specify the widget title font properties.', 'skilled' ),
			'google'   => true,
			'compiler' => array( '.wh-footer h3' ),
			'default'  => array(
				'color'       => '#333',
				'font-size'   => '20px',
				'line-height' => '22px',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'       => 'footer-widget-subtitle-typography',
			'type'     => 'typography',
			'title'    => __( 'Subtitle Font', 'skilled' ),
			'subtitle' => __( 'Specify the widget link font properties.', 'skilled' ),
			'google'   => true,
			'color'    => false,
			'compiler' => array(
				'.wh-footer h4',
				'.wh-footer h5',
				'.wh-footer h4 a',
				'.wh-footer h5 a'
			),
			'default'  => array(
				'color'       => '#333',
				'font-size'   => '14px',
				'line-height' => '22px',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'       => 'footer-widget-subtitle-color',
			'type'     => 'link_color',
			'title'    => __( 'Link Color', 'skilled' ),
			'active'   => false,
			'compiler' => array(
				'.wh-footer a',
				'.wh-footer .widget ul li:before',
			 ),
			'default'  => array(
				'regular' => '#1e73be', // blue
				'hover'   => '#dd3333', // red
			)
		),
		array(
			'id'       => 'footer-widget-text-typography',
			'type'     => 'typography',
			'title'    => __( 'Font', 'skilled' ),
			'subtitle' => __( 'Specify the widget font properties.', 'skilled' ),
			'google'   => true,
			'compiler' => array( '.wh-footer', '.wh-footer p', '.wh-footer span' ),
			'default'  => array(
				'color'       => '#333',
				'font-size'   => '14px',
				'line-height' => '22px',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'            => 'footer-widget-width',
			'type'          => 'slider',
			'title'         => __( 'Footer Widget Width', 'skilled' ),
			'subtitle'      => __( 'Drag the slider to change widget width grid steps.', 'skilled' ),
			'desc'          => __( 'The grid has 12 steps.', 'skilled' ),
			'default'       => 3,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label'
		),
		array(
			'id'       => 'footer-widget-min-height',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'title'    => __( 'Min Height', 'skilled' ),
			'compiler' => array( '.wh-footer .widget' ),
			'height'   => false,
			'mode'     => 'min-height',
			'default'  => array(
				'width' => '250',
				'units' => 'px',
			),
		),
		array(
			'id'      => 'footer-widget-padding-override',
			'type'    => 'switch',
			'title'   => __( 'Override Footer Widget Padding', 'skilled' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'             => 'footer-widget-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-footer > .cbp-container > div' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => __( 'Footer Widget Padding', 'skilled' ),
			'default'        => array(
				'padding-top'    => '5px',
				'padding-right'  => '20px',
				'padding-bottom' => '5px',
				'padding-left'   => '20px',
				'units'          => 'px',
			),
			'required'       => array(
				array( 'footer-widget-padding-override', 'equals', '1' ),
			),

		),
	)
) );
// -> End Footer

// ----------------------------------
// -> Misc
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-misc',
	'title'  => __( 'Misc', 'skilled' ),
	'icon'   => 'el-icon-website',
	'fields' => array()
));

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-misc-scroll-to-top-button',
	'title'      => __( 'Scroll to Top Button', 'skilled' ),
	'fields'     => array(
		array(
			'id'      => 'use-scroll-to-top',
			'type'    => 'switch',
			'title'   => __( 'Use Scroll to Top Button?', 'skilled' ),
			'default' => true,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'      => 'scroll-to-top-text',
			'type'    => 'text',
			'title'   => __( 'Scroll to Top Text', 'skilled' ),
			'default' => '',
			'required' => array(
				array( 'use-scroll-to-top', 'equals', '1' ),
			),
		),
		array(
			'id'      => 'scroll-to-top-button-override',
			'type'    => 'switch',
			'title'   => __( 'Override Scroll to Top Button?', 'skilled' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
			'required' => array(
				array( 'use-scroll-to-top', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'scroll-to-top-button',
			'type'     => 'background',
			'compiler' => array( '#scrollUp' ),
			'title'    => __( 'Scroll to Top Button', 'skilled' ),
			'required' => array(
				array( 'use-scroll-to-top', 'equals', '1' ),
				array( 'scroll-to-top-button-override', 'equals', '1' ),
			),

		),
		array(
			'id'       => 'scroll-to-top-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'compiler' => array( '#scrollUp' ),
			'title'    => __( 'Dimensions (Width/Height)', 'skilled' ),
			'default'  => array(
				'width'  => '70',
				'height' => '70'
			),
			'required' => array(
				array( 'use-scroll-to-top', 'equals', '1' ),
				array( 'scroll-to-top-button-override', 'equals', '1' ),
			),
		),
	)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-misc-text-direction',
	'title'      => __( 'Text Direction', 'skilled' ),
	'fields'     => array(
		array(
			'id'      => 'is-rtl',
			'type'    => 'switch',
			'title'   => __( 'Enable RTL?', 'skilled' ),
			'default' => false,
		),
	)
) );
// -> End Misc


// ----------------------------------
// -> Other Settings
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-other-settings',
	'title'  => __( 'Other Settings', 'skilled' ),
	'icon'   => 'el-icon-website',
	'fields' => array(
		array(
		    'id'   => 'other-settings-info',
		    'type' => 'info',
			'desc' => __('If you have made edits to the code and wish to see the original code click on the link bellow. If you wish to completely restore the original code either copy this reference code to the editor bellow or reset the section.', 'skilled'),
		),
		array(
		    'id'   => 'other-settings-info-link',
		    'type' => 'info',
		    'desc' => '<a href="'.get_template_directory_uri().'/lib/redux/css/other-settings/vars.scss" target="_blank">Click here to see a refrence of original code</a>'
		),
		array(
			'id'       => 'other-settings-vars',
			'type'     => 'ace_editor',
			'title'    => __( 'Settings', 'skilled' ),
			'mode'     => 'scss',
			'compiler' => 'true',
			'theme'    => 'monokai',
			'default'  => $other_settings,
			'options'  => array(
				'minLines'=> 100
			),
		),
	)
) );
// -> End Other Settings
