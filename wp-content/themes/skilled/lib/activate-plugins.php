<?php

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'skilled_register_required_plugins');

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function skilled_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // Include a plugin pre-packaged with a theme
        array(
            'name'               => 'Skilled Plugin', // The plugin name
            'slug'               => 'skilled-plugin', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/extensions/skilled-plugin.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'               => 'WPBakery Visual Composer', // The plugin name
            'slug'               => 'js_composer', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/extensions/js_composer.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'               => 'Ultimate Addons for Visual Composer', // The plugin name
            'slug'               => 'Ultimate_VC_Addons', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/extensions/ultimate_vc_addons.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'               => 'Layer Slider', // The plugin name
            'slug'               => 'LayerSlider', // The plugin slug (typically the folder name)
            'source'             => get_stylesheet_directory() . '/extensions/layersliderwp.zip', // The plugin source
            'required'           => true, // If false, the plugin is only 'recommended' instead of required
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '', // If set, overrides default API URL and points to an external URL
        ),
        // include a plugins from the WordPress Plugin Repository
        array(
            'name'     => 'Redux Framework',
            'slug'     => 'redux-framework',
            'required' => true,
        ),
        array(
            'name'     => 'The Events Calendar',
            'slug'     => 'the-events-calendar',
            'required' => false,
        ),
        array(
            'name'     => 'Woocommerce',
            'slug'     => 'woocommerce',
            'required' => true,
        ),
	    array(
	        'name'     => 'Contact Form 7',
            'slug'     => 'contact-form-7',
            'required' => false,
        ),
    );

	// messages
	$messages = array(
		esc_html__( 'If you are not able to complete plugin installation process due to server issues please install the plugins manually. All required plugins are located in "extensions" folder in your main download from Themeforest.', 'skilled' ),
		sprintf( esc_html__( 'After you finish installing plugins go back to %s page to complete the installation.', 'skilled' ), '<a href="' . admin_url( 'themes.php?page=theme_activation_options' ) . '" title="' . esc_html__( 'Theme Activation', 'skilled' ) . '">' . esc_html__( 'Theme Activation', 'skilled' ) . '</a>' ),
	);
	$final_message = '';
	foreach ( $messages as $message ) {
		$final_message .= sprintf( '<div class="updated fade"><p>%s</p></div>', $message );
	}


	/**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'           => 'skilled', // Text domain - likely want to be the same as your theme.
        'default_path'     => '', // Default absolute path to pre-packaged plugins
        'menu'             => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'      => 'themes.php',
        'has_notices'      => true, // Show admin notices or not
        'is_automatic'     => false, // Automatically activate plugins after installation or not
        'message'          => $final_message, // Message to output right before the plugins table

    );

    tgmpa($plugins, $config);
}
