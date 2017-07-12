<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Linp_Courses_Search_Form {

	protected $textdomain = SCP_TEXT_DOMAIN;
	protected $namespace = 'dntp_courses_search_form';

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
			'name'        => __( 'Course Search Form', $this->textdomain ),
			'description' => __( '', $this->textdomain ),
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			// or css class name which you can reffer in your css file later. Example: 'vc_extend_my_class'
			'category'    => __( 'Aislin', 'js_composer' ),
			//'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
			//'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
			'params'      => array(
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Search Form Type', $this->textdomain ),
					'param_name' => 'form_type',
					'value'      => array(
						'Small' => 'small',
						'Big'   => 'big',

					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Extra class name', $this->textdomain ),
					'param_name'  => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', $this->textdomain ),
				),
			)
		) );
	}

	/*
	Shortcode logic how it should be rendered
	*/
	public function render( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'form_type' => 'small',
			'position'  => '',
			'el_class'  => '',
		), $atts ) );

		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

		ob_start();
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'dntp-search-courses-form ' . $el_class, $this->namespace, $atts );
		?>

		<div class="<?php echo $css_class; ?>">
			<?php
			if ( $form_type == 'big' ) {
				$template = locate_template( 'templates/searchform-courses-big.php' );
				if ( file_exists( $template ) ) {
					include locate_template( 'templates/searchform-courses-big.php' );
				}
			} else {
				$template = locate_template( 'templates/searchform-courses-small.php' );
				if ( file_exists( $template ) ) {
					include locate_template( 'templates/searchform-courses-small.php' );
				}
			}
			?>
		</div>
		<?php
		$content = ob_get_clean();

		return $content;
	}

	/*
	Load plugin css and javascript files which you may need on front end of your site
	*/
	public function loadCssAndJs() {
		//wp_register_style( 'vc_extend_style', plugins_url( 'assets/vc_extend.css', __FILE__ ) );
		//wp_enqueue_style( 'vc_extend_style' );

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
          <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', DNTP_TEXT_DOMAIN ), $plugin_data['Name'] ) . '</p>
        </div>';
	}
}

// Finally initialize code
new Linp_Courses_Search_Form();
