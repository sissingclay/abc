<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Linp_Countdown {

	protected $name = 'Countdown';
	protected $namespace = 'linp_countdown';
	protected $textdomain = SCP_TEXT_DOMAIN;

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
			'name'        => esc_html( $this->name, $this->textdomain ),
			'description' => '',
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			// or css class name which you can reffer in your css file later. Example: 'vc_extend_my_class'
			'category'    => __( 'Aislin', $this->textdomain ),
			//'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
			//'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
			'params'      => array(

				array(
					'type'        => 'textfield',
					'heading'     => __( 'Target Date', $this->textdomain ),
					'description' => __( 'Enter date in this format: 2020/10/10 12:00:00.', $this->textdomain ),
					'param_name'  => 'target_date',
					'value'       => '2020/10/10 12:00:00',
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Labels', $this->textdomain ),
					'description' => __( 'Comma separated list of labels (weeks, days, hours, minutes, seconds).', $this->textdomain ),
					'param_name'  => 'labels',
					'value'       => 'weeks, days, hours, minutes, seconds',
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
			'target_date' => '2020/10/10 12:00:00',
			'labels'      => 'weeks, days, hours, minutes, seconds',
			'el_class'    => '',

		), $atts ) );

		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

		$id        = uniqid( 'countdown-' );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'linp-countdown ' . $el_class, $this->namespace, $atts );


		ob_start();


		?>
		<div class="<?php echo $css_class; ?>">
			<div id="<?php echo $id; ?>"></div>
		</div>
		<script type="text/javascript">

			var skilled_plugin = skilled_plugin || {};
			skilled_plugin.data = skilled_plugin.data || {};
			skilled_plugin.data.vcWidgets = skilled_plugin.data.vcWidgets || {};
			skilled_plugin.data.vcWidgets.countdown = skilled_plugin.data.vcWidgets.countdown || {};
			skilled_plugin.data.vcWidgets.countdown.items = skilled_plugin.data.vcWidgets.countdown.items || [];

			(function () {

				var countdown = {
					id: '<?php echo $id; ?>',
					options: {
						targetDate: '<?php echo $target_date; ?>',
						labels: '<?php echo $labels; ?>'
					}
				};

				skilled_plugin.data.vcWidgets.countdown.items.push(countdown);
			})();

		</script>

		<?php
		$content = ob_get_clean();

		return $content;
	}

	/*
	Load plugin css and javascript files which you may need on front end of your site
	*/
	public function loadCssAndJs() {
		//wp_register_style( 'linp-countdown', plugins_url( 'assets/linp-countdown.css', __FILE__ ) );
		//wp_enqueue_style( 'linp-countdown' );

		// If you need any javascript files on front end, here is how you can load them.
		wp_enqueue_script( 'jquery-countdown', plugins_url( 'assets/jquery.countdown.min.js', __FILE__ ), array( 'jquery', 'underscore' ) );
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
}

// Finally initialize code
new Linp_Countdown();
