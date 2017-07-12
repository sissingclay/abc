<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode {

    }
}

class Scp_Ribbon extends WPBakeryShortCode {

	/**
	 * Defines fields names for google_fonts, font_container and etc
	 * @since 4.4
	 * @var array
	 */
	protected $fields = array(
		//key(read only) => 'value'(changeable)
		'google_fonts' => 'google_fonts',
		'font_container' => 'font_container',
		'el_class' => 'el_class',
		'css' => 'css',
		'text' => 'text',
	);


	protected $textdomain = SCP_TEXT_DOMAIN;
	protected $namespace = 'scp_ribbon';

	function __construct() {
		// We safely integrate with VC with this hook
		add_action( 'init', array( $this, 'integrateWithVC' ) );

		// Use this when creating a shortcode addon
		add_shortcode( $this->namespace, array( $this, 'render' ) );

		// Register CSS and JS
		add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
	}

	public function integrateWithVC() {
		// Check if Visual Composer is installed
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			// Display notice that Visual Compser is required
			add_action( 'admin_notices', array( $this, 'showVcVersionNotice' ) );

			return;
		}

		/*
		Add your Visual Composer logic here.
		Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

		More info: http://kb.wpbakery.com/index.php?title=Vc_map
		*/
		vc_map( array(
			'name'        => __( 'Ribbon', $this->textdomain ),
			'description' => __( '', $this->textdomain ),
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ), // or css class name which you can reffer in your css file later. Example: 'vc_extend_my_class'
			'category'    => __( 'Aislin', 'js_composer' ),
			//'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
			//'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
			'params'      => array(
				array(
					'type'        => 'colorpicker',
					'heading'     => __( 'Background Color', 'js_composer' ),
					'param_name'  => 'ribbon_bg_color',
					'save_always' => 'true',
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Ribbon Depth', $this->textdomain ),
					'description' => __( 'Enter value in px.', $this->textdomain ),
					'param_name'  => 'ribbon_depth',
					'save_always' => 'true',
				),
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => __( 'Title', $this->textdomain ),
					'param_name'  => 'title',
					'value'       => __( 'Title', $this->textdomain ),
					'description' => __( 'Widget title.', $this->textdomain ),
					'save_always' => 'true',
					'group'       => __( 'Text Settings', 'js_composer' ),
				),
				array(
					'type'        => 'font_container',
					'param_name'  => 'font_container',
					'value'       => '',
					'settings'    => array(
						'fields' => array(
							'tag'                     => 'h2', // default value h2
							'text_align',
							'font_size',
							'line_height',
							'color',
							//'font_style_italic'
							//'font_style_bold'
							//'font_family'

							'tag_description'         => __( 'Select element tag.', 'js_composer' ),
							'text_align_description'  => __( 'Select text alignment.', 'js_composer' ),
							'font_size_description'   => __( 'Enter font size.', 'js_composer' ),
							'line_height_description' => __( 'Enter line height.', 'js_composer' ),
							'color_description'       => __( 'Select heading color.', 'js_composer' ),
							//'font_style_description' => __('Put your description here','js_composer'),
							//'font_family_description' => __('Put your description here','js_composer'),
						),
					),
					// 'description' => __( '', 'js_composer' ),
					'save_always' => 'true',
					'group'       => __( 'Text Settings', 'js_composer' ),
				),
				array(
					'type'        => 'google_fonts',
					'param_name'  => 'google_fonts',
					'value'       => 'font_family:Abril%20Fatface%3A400|font_style:400%20regular%3A400%3Anormal',
					// default
					//'font_family:'.rawurlencode('Abril Fatface:400').'|font_style:'.rawurlencode('400 regular:400:normal')
					// this will override 'settings'. 'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900 bold italic:900:italic'),
					'settings'    => array(
						//'no_font_style' // Method 1: To disable font style
						//'no_font_style'=>true // Method 2: To disable font style
						'fields' => array(
							//'font_family' => 'Abril Fatface:regular',
							//'Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic',// Default font family and all available styles to fetch
							//'font_style' => '400 regular:400:normal',
							// Default font style. Name:weight:style, example: "800 bold regular:800:normal"
							'font_family_description' => __( 'Select font family.', 'js_composer' ),
							'font_style_description'  => __( 'Select font styling.', 'js_composer' )
						)
					),
					// 'description' => __( '', 'js_composer' ),
					//'save_always' => 'true',
					'group'       => __( 'Text Settings', 'js_composer' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Extra class name', $this->textdomain ),
					'param_name'  => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', $this->textdomain ),
					'save_always' => 'true',
				),
				array(
					'type'        => 'css_editor',
					'heading'     => __( 'CSS box', 'js_composer' ),
					'param_name'  => 'css',
					// 'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
					'group'       => __( 'Design Options', 'js_composer' ),
					'save_always' => 'true',
				)
			)
		) );
	}

	/*
	Shortcode logic how it should be rendered
	*/
	public function render( $atts, $content = null ) {

		$output = $text = $google_fonts = $font_container = $el_class = $css = $google_fonts_data = $font_container_data = '';
		extract( $this->getAttributes( $atts ) );
		extract( $this->getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) );
		$settings = get_option( 'wpb_js_google_fonts_subsets' );
		$subsets = '';
		if ( is_array( $settings ) && ! empty( $settings ) ) {
			$subsets = '&subset=' . implode( ',', $settings );
		}
		if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values']['font_family'] ) ) {
			// wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
		}

		extract( shortcode_atts( array(
			'title'           => 'The Title',
			'ribbon_bg_color' => '#999',
			'height'          => '50px',
			'ribbon_depth'    => '50px',
			'el_class'        => '',
		), $atts ) );

		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content


		$ribbon_depth = (int) $ribbon_depth . 'px';
		$half_height  = (int) $height / 2 . 'px';


		/**
		 * Ribbon style
		 */
		$ribbon_style = '';

		$ribbon_style .= 'style="';
		$ribbon_style .= 'width:100%;';
		$ribbon_style .= 'height:100%;';
		$ribbon_style .= 'border-width: ' . $half_height . ' ' . $ribbon_depth . ';';
		$ribbon_style .= 'border-style: solid;';
		$ribbon_style .= 'border-color: ' . $ribbon_bg_color . ' rgba(0, 0, 0, 0) ' . $ribbon_bg_color . ' rgba(0, 0, 0, 0);';
		$ribbon_style .= 'position: absolute;';
		$ribbon_style .= 'top: 0;';
		$ribbon_style .= 'left: 0;';

		$ribbon_style .= '"';


		/**
		 * Wrapper style
		 */
		$wrapper_style = '';

		$wrapper_style .= 'style="';
		$wrapper_style .= 'width:100%;';
		$wrapper_style .= 'height:' . $height . ';';
		$wrapper_style .= esc_attr( implode( ';', $styles ) );

		$wrapper_style .= '"';


		ob_start();
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'scp-ribbon-wrapper ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		?>


		<div class="<?php echo $css_class; ?>" <?php echo $wrapper_style; ?>>
			<div class="scp-shortcode-ribbon" <?php echo $ribbon_style; ?>></div>
			<div class="scp-ribbon-text">
				<?php echo $title; ?>
			</div>
		</div>

		<?php
		$content = ob_get_clean();

		return $content;
	}

	/*
	Load plugin css and javascript files which you may need on front end of your site
	*/
	public function loadCssAndJs() {
//		wp_register_style( 'vc_extend_style', plugins_url( 'assets/vc_extend.css', __FILE__ ) );
//		wp_enqueue_style( 'vc_extend_style' );

		// If you need any javascript files on front end, here is how you can load them.
		//wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
	}

	/*
	Show notice if your plugin is activated but Visual Composer is not
	*/
	public function showVcVersionNotice() {
		$plugin_data = get_plugin_data( __FILE__ );
		echo '
        <div class="updated">
          <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', $this->textdomain ), $plugin_data['Name'] ) . '</p>
        </div>';
	}


	/**
	 * This bottom part was copied form WPBakeryShortCode_VC_Custom_heading
	 */

	/**
	 * Used to get field name in vc_map function for google_fonts, font_container and etc..
	 *
	 * @param $key
	 *
	 * @since 4.4
	 * @return bool
	 */
	protected function getField( $key ) {
		return isset( $this->fields[ $key ] ) ? $this->fields[ $key ] : false;
	}

	/**
	 * Get param value by providing key
	 *
	 * @param $key
	 *
	 * @since 4.4
	 * @return array|bool
	 */
	protected function getParamData( $key ) {
//		return WPBMap::getParam( $this->shortcode, $this->getField( $key ) );
		return WPBMap::getParam( $this->namespace, $this->getField( $key ) );
	}

	/**
	 * Parses shortcode attributes and set defaults based on vc_map function relative to shortcode and fields names
	 *
	 * @param $atts
	 *
	 * @since 4.3
	 * @return array
	 */
	public function getAttributes( $atts ) {
		$text = $google_fonts = $font_container = $el_class = $css = '';
		/**
		 * Get default values from VC_MAP.
		 **/
		$google_fonts_field = $this->getParamData( 'google_fonts' );
		$font_container_field = $this->getParamData( 'font_container' );
		$el_class_field = $this->getParamData( 'el_class' );
		$css_field = $this->getParamData( 'css' );
		$text_field = $this->getParamData( 'text' );

		extract( shortcode_atts( array(
			'text' => $text_field && isset( $text_field['value'] ) ? $text_field['value'] : '',
			'google_fonts' => $google_fonts_field && isset( $google_fonts_field['value'] ) ? $google_fonts_field['value'] : '',
			'font_container' => $font_container_field && isset( $font_container_field['value'] ) ? $font_container_field['value'] : '',
			'el_class' => $el_class_field && isset( $el_class_field['value'] ) ? $el_class_field['value'] : '',
			'css' => $css_field && isset( $css_field['value'] ) ? $css_field['value'] : ''
		), $atts ) );
		$el_class = $this->getExtraClass( $el_class );
		$font_container_obj = new Vc_Font_Container();
		$google_fonts_obj = new Vc_Google_Fonts();
		$font_container_field_settings = isset( $font_container_field['settings'], $font_container_field['settings']['fields'] ) ? $font_container_field['settings']['fields'] : array();
		$google_fonts_field_settings = isset( $google_fonts_field['settings'], $google_fonts_field['settings']['fields'] ) ? $google_fonts_field['settings']['fields'] : array();
		$font_container_data = $font_container_obj->_vc_font_container_parse_attributes( $font_container_field_settings, $font_container );
		$google_fonts_data = strlen( $google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings, $google_fonts ) : '';

		return array(
			'text' => $text,
			'google_fonts' => $google_fonts,
			'font_container' => $font_container,
			'el_class' => $el_class,
			'css' => $css,
			'font_container_data' => $font_container_data,
			'google_fonts_data' => $google_fonts_data
		);
	}

	/**
	 * Parses google_fonts_data and font_container_data to get needed css styles to markup
	 *
	 * @param $el_class
	 * @param $css
	 * @param $google_fonts_data
	 * @param $font_container_data
	 * @param $atts
	 *
	 * @since 4.3
	 * @return array
	 */
	public function getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) {
		$styles = array();
		if ( ! empty( $font_container_data ) && isset( $font_container_data['values'] ) ) {
			foreach ( $font_container_data['values'] as $key => $value ) {
				if ( $key != 'tag' && strlen( $value ) > 0 ) {
					if ( preg_match( '/description/', $key ) ) {
						continue;
					}
					if ( $key == 'font_size' || $key == 'line_height' ) {
						$value = preg_replace( '/\s+/', '', $value );
					}
					if ( $key == 'font_size' ) {
						$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
						// allowed metrics: http://www.w3schools.com/cssref/css_units.asp
						$regexr = preg_match( $pattern, $value, $matches );
						$value = isset( $matches[1] ) ? (float) $matches[1] : (float) $value;
						$unit = isset( $matches[2] ) ? $matches[2] : 'px';
						$value = $value . $unit;
					}
					if ( strlen( $value ) > 0 ) {
						$styles[] = str_replace( '_', '-', $key ) . ': ' . $value;
					}
				}
			}
		}
		if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
			$google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
			$styles[] = "font-family:" . $google_fonts_family[0];
			$google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
			$styles[] = "font-weight:" . $google_fonts_styles[1];
			$styles[] = "font-style:" . $google_fonts_styles[2];
		}

		/**
		 * Filter 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' to change vc_custom_heading class
		 *
		 * @param string - filter_name
		 * @param string - element_class
		 * @param string - shortcode_name
		 * @param array - shortcode_attributes
		 *
		 * @since 4.3
		 */
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_custom_heading' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

		return array(
			'css_class' => $css_class,
			'styles' => $styles
		);
	}
}

// Finally initialize code
new Scp_Ribbon();
