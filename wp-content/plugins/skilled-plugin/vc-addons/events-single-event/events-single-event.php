<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Dntp_Events_Single_Event {

	protected $textdomain = DNTP_TEXT_DOMAIN;
	protected $namespace = 'dntp_events_calendar';

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

		// this is a fix for get_posts on tribe_events
		require_once( ABSPATH . 'wp-admin/includes/screen.php' );

		$events = get_posts( array(
			'post_type'      => 'tribe_events',
			'posts_per_page' => - 1,
			'orderby'        => 'title',
			'order'          => 'ASC'
		) );

		$eventsArr                 = array();
		$eventsArr['Select Block'] = '';
		foreach ( $events as $event ) {
			$eventsArr[ $event->post_title ] = $event->ID;
		}

		/*
		Add your Visual Composer logic here.
		Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

		More info: http://kb.wpbakery.com/index.php?title=Vc_map
		*/
		vc_map( array(
			'name'        => __( 'Single Event', $this->textdomain ),
			'description' => __( '', $this->textdomain ),
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ), // or css class name which you can reffer in your css file later. Example: 'vc_extend_my_class'
			'category'    => __( 'Content', 'js_composer' ),
			//'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
			//'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
			'params'      => array(
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Title', $this->textdomain ),
					'param_name'  => 'title',
					'admin_label' => true,
					'value'       => '',
				),
				array(
					'type'        => 'dropdown',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Event', $this->textdomain ),
					'param_name'  => 'event_id',
					'value'       => $eventsArr,
					'description' => __( 'Select an event.', $this->textdomain )
				),
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Start Date Format', $this->textdomain ),
					'param_name'  => 'start_date_format',
					'admin_label' => true,
					'value'       => 'M d, Y',
				),
				array(
					'type'       => 'textarea_html',
					'class'      => '',
					'heading'    => __( 'Descripion', $this->textdomain ),
					'param_name' => 'content',
					'value'      => '',
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
			'title'             => '',
			'event_id'          => '',
			'start_date_format' => 'M d, Y',
			'textarea_html'     => '',
			'el_class'          => '',
		), $atts ) );

		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

		ob_start();

		$event_post = $event_id ? get_post( $event_id ) : null;

		$start_date = get_post_meta( $event_post->ID, '_EventStartDate', true );
		$start_date = date_i18n($start_date_format, strtotime($start_date));




		if ( $event_post ) {
			echo '<pre>';
			echo $title;
			echo $start_date;
			echo $event_post->post_title;
			echo wp_trim_words($event_post->post_content, 10);
			echo '</pre>';

		}

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
          <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', $this->textdomain ), $plugin_data['Name'] ) . '</p>
        </div>';
	}
}

new Dntp_Events_Single_Event();
