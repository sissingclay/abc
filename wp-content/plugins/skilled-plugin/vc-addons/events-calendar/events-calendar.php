<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

class scp_Events_Calendar {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );

        // Use this when creating a shortcode addon
        add_shortcode( 'scp_events_calendar', array( $this, 'render' ) );

        // Register CSS and JS
        add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }

    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }


        $categories                           = eme_get_categories();
        $option_categories                    = array();
        $option_categories['Select Category'] = '';

        foreach ($categories as $cat) {
            $option_categories[$cat['category_name']] = $cat['category_id'];
        }

        /*
        Add your Visual Composer logic here.
        Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map( array(
            'name' => __('EME Events Calendar', SCP_TEXT_DOMAIN),
            'description' => __('', SCP_TEXT_DOMAIN),
            'base' => 'scp_events_calendar',
            'class' => '',
            'controls' => 'full',
            'icon' => plugins_url('assets/aislin-vc-icon.png', __FILE__), // or css class name which you can reffer in your css file later. Example: 'vc_extend_my_class'
            'category' => __('Content', 'js_composer'),
            //'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
            //'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
            'params' => array(
                array(
                    'type'        => 'textfield',
                    'holder'      => 'div',
                    'class'       => '',
                    'heading'     => __('Title', SCP_TEXT_DOMAIN),
                    'param_name'  => 'title',
                    'value'       => __('Calendar', SCP_TEXT_DOMAIN),
                    'description' => __('Widget title.', SCP_TEXT_DOMAIN),
                ),
                array(
                    'type'        => 'dropdown',
                    'holder'      => '',
                    'class'       => '',
                    'heading'     => __('Title Tag', SCP_TEXT_DOMAIN),
                    'param_name'  => 'title_tag',
                    'value'       => array(
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h4' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6',
                    ),
                ),
                array(
                    'type'        => 'dropdown',
                    'holder'      => '',
                    'class'       => '',
                    'heading'     => __('Category', SCP_TEXT_DOMAIN),
                    'param_name'  => 'category',
                    'value'       => $option_categories,
                    'description' => __('If no category is selected all events will be shown.', SCP_TEXT_DOMAIN)
                ),
                array(
	                'type'        => 'textfield',
	                'heading'     => __( 'Extra class name', $this->textdomain ),
	                'param_name'  => 'el_class',
	                'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', $this->textdomain ),
                ),
            )
        ));
    }

    /*
    Shortcode logic how it should be rendered
    */
    public function render( $atts, $content = null ) {

        extract( shortcode_atts( array(
          'title'     => 'Calendar',
          'title_tag' => 'h2',
          'category'  => '',
          'el_class'  => '',
        ), $atts ) );

        // $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

        ob_start();

        $instance = array(
            'title' => $title,
            'authorid' => 1,
        );

        if ($category) {
           $instance['category'] = (int) $category;
        }
        $args = array(
            'before_widget' => '<div class="dntp-calendar-widget ' . $el_class . '">',
            'after_widget'  => '</div>',
            'before_title'  => '<' . $title_tag . ' class="title">',
            'after_title'   => '</' . $title_tag . '>',
        );

        the_widget('WP_Widget_eme_calendar', $instance, $args);
        $content = ob_get_clean();
        return $content;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    public function loadCssAndJs() {
      //wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
      //wp_enqueue_style( 'vc_extend_style' );

      // If you need any javascript files on front end, here is how you can load them.
      //wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
    }

    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', SCP_TEXT_DOMAIN), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new scp_Events_Calendar();
