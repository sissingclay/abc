<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Dntp_Sensei_Courses_Category {

	protected $textdomain = SCP_TEXT_DOMAIN;
	protected $namespace = 'dntp_sensei_courses_category';

	function __construct() {
		// We safely integrate with VC with this hook
		add_action( 'init', array( $this, 'integrateWithVC' ), 110 );

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


		$args = array(
			'taxonomy' => 'course-category',
		);

		$course_categories = get_categories( $args );

		$course_category_arr                    = array();
		$course_category_arr['Select Category'] = '';
		$course_category_arr['All']             = 0;
		foreach ( $course_categories as $course_category ) {
			if ( is_object( $course_category ) && $course_category->term_id ) {
				$course_category_arr[ $course_category->name . ' (cat ID = ' . $course_category->term_id . ')' ] = $course_category->term_id;
			}
		}


		/*
		Add your Visual Composer logic here.
		Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

		More info: http://kb.wpbakery.com/index.php?title=Vc_map
		*/
		vc_map( array(
			'name'        => __( 'Courses Category', $this->textdomain ),
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
					'type'       => 'textfield',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Top Title', $this->textdomain ),
					'param_name' => 'top_title',
					'value'      => __( 'Top Title', $this->textdomain ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Title', $this->textdomain ),
					'param_name' => 'title',
					'value'      => __( 'The Title', $this->textdomain ),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Use Categories', $this->textdomain ),
					'description' => __( 'If set to Yes category list will be displayed instead of text.', $this->textdomain ),
					'param_name'  => 'use_categories',
					'value'       => array(
						'No'  => '0',
						'Yes' => '1',
					),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => '',
					'class'       => '',
					'admin_label' => true,
					'heading'     => __( 'Category', $this->textdomain ),
					'param_name'  => 'category_id',
					'value'       => $course_category_arr,
					'description' => __( 'Category IDs are printed next to the category name. You can use this id number if you choose to use category search link shortcode in the editor bellow', $this->textdomain ),
					'dependency'  => array( 'element' => 'use_categories', 'value' => '1' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Number of Subcategories', $this->textdomain ),
					'param_name'  => 'number_of_subcategories',
					'description' => __( 'Number of subcategories to show. Please enter number only (0 means all)', $this->textdomain ),
					'dependency'  => array( 'element' => 'use_categories', 'value' => '1' ),
				),
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Box Height', $this->textdomain ),
					'param_name'  => 'box_height',
					'description' => __( 'Value in px. Enter number only.', $this->textdomain )
				),
				array(
					'type'        => 'attach_image',
					'class'       => '',
					'heading'     => __( 'Background Image', $this->textdomain ),
					'param_name'  => 'bg_image',
					'value'       => '',
					'description' => __( 'Upload background image.', $this->textdomain )
				),
				array(
					'type'        => 'icon_manager',
					'class'       => '',
					'heading'     => __( 'Select Icon ', 'smile' ),
					'param_name'  => 'icon',
					'value'       => '',
					'description' => __( "Click and select icon of your choice. If you can't find the one that suits for your purpose, you can <a href='admin.php?page=font-icon-Manager' target='_blank'>add new here</a>.", 'flip-box' ),
				),
				array(
					'type'       => 'textarea_html',
					'class'      => '',
					'heading'    => __( 'Text', $this->textdomain ),
					'param_name' => 'text',
					'value'      => '',
				),
				array(
					'type'        => 'colorpicker',
					'class'       => '',
					'heading'     => __( 'Background Color', $this->textdomain ),
					'param_name'  => 'bg_color',
					'value'       => '#FF6A6F',
					'description' => __( 'Set background color.', $this->textdomain ),
					'group'       => 'Styling',
				),
				array(
					'type'        => 'colorpicker',
					'class'       => '',
					'heading'     => __( 'Font Color', $this->textdomain ),
					'param_name'  => 'font_color',
					'value'       => '#FFF',
					'group'       => 'Styling',
				),
				array(
					'type'        => 'colorpicker',
					'class'       => '',
					'heading'     => __( 'Top Text Background Color', $this->textdomain ),
					'param_name'  => 'top_text_bg_color',
					'value'       => '#FFF',
					'group'       => 'Styling',
				),
				array(
					'type'        => 'colorpicker',
					'class'       => '',
					'heading'     => __( 'Top Text Font Color', $this->textdomain ),
					'param_name'  => 'top_text_font_color',
					'value'       => '#FF6A6F',
					'group'       => 'Styling',
				),
				// array(
				// 	'type'        => 'ultimate_google_fonts',
				// 	'heading'     => __( 'Font Family', $this->textdomain ),
				// 	'param_name'  => 'font_family',
				// 	'description' => __( "Select the font of your choice. You can <a target='_blank' href='" . admin_url( 'admin.php?page=ultimate-font-manager' ) . "'>add new in the collection here</a>.", $this->textdomain ),
				// 	'group'       => 'Styling'
				// ),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Extra class name', $this->textdomain ),
					'param_name'  => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', $this->textdomain ),
				),
			)
		) );
	}

	public function render( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'bg_image'                => '',
			'top_title'               => '',
			'title'                   => '',
			'use_categories'          => '0',
			'category_id'             => '',
			'number_of_subcategories' => 0,
			'box_height'              => 420,
			'icon'                    => '',
			'text'                    => '',
			'bg_color'                => '#FF6A6F',
			'font_color'              => '#FFF',
			'font_family'             => '',
			'top_text_bg_color'       => '#FFF',
			'top_text_font_color'     => '#FF6A6F',
			'el_class'                => '',
		), $atts ) );

		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

		$img = wp_get_attachment_image_src( $bg_image, 'large' );

		$args = array(
			'parent'   => $category_id, // only direct descendants
			'taxonomy' => 'course-category',
			'number'   => (int) $number_of_subcategories,
		);

		$categories = get_categories( $args );

		ob_start();
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'dntp-sensei-courses-category ' . $el_class, $this->namespace, $atts );
		$uid       = uniqid( 'course-category-widget-' );

		/**
		 * Widget Style
		 */
		$widget_style = '';
		$widget_style .= 'height:' . (int) $box_height . 'px;';
		$widget_style .= 'background-color:' . $bg_color . ';';
		$widget_style .= 'color:' . $font_color . ';';

		if ( $font_family != '' ) {
			$font_family = get_ultimate_font_family( $font_family );
			$widget_style .= 'font-family:' . $font_family . ';';
		}
		$widget_style = 'style="' . $widget_style . '"';

		/**
		 * Link Style
		 */
		$link_style = '';
		$link_style .= 'background-color:' . $top_text_bg_color . ';';
		$link_style .= 'color:' . $top_text_font_color . ';';
		$link_style = 'style="' . $link_style . '"';
		?>

		<div id="<?php echo $uid; ?>" class="<?php echo $css_class; ?>">
			<div class="course-category-widget" <?php echo $widget_style; ?>>
				<?php if ( $top_title ): ?>
					<div class="top-link">
						<span <?php echo $link_style; ?>><?php echo $top_title; ?></span>
					</div>
				<?php endif; ?>
				<div class="icon-wrap">
					<i class="<?php echo $icon; ?>"></i>
				</div>
				<?php if ( $title ): ?>
					<div class="title"><?php echo $title; ?></div>
				<?php endif; ?>
				<div class="text">
					<?php echo do_shortcode( $text ); ?>
					<?php if ( (int) $use_categories && $categories ): ?>
						<?php foreach ( $categories as $category ) : ?>
							<?php if (is_object($category)) : ?>
							<p>
								<a href="<?php echo add_query_arg( array(
									's'               => '',
									'search-type'     => 'courses',
									'course-category' => $category->term_id
								), get_site_url() ); ?>"><?php echo $category->name; ?></a>
							</p>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<?php if ( isset( $img[0] ) ): ?>
					<div class="img-bg-wrap">
						<img class="img-bg" src="<?php echo $img[0]; ?>"/>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php
		/*<style>
			#<?php echo $uid; ?> .course-category-widget {
				height: <?php echo (int) $box_height . 'px'; ?>;
				background-color: <?php echo $bg_color; ?>;
				color: <?php echo $font_color; ?>;

				<?php if ( $font_family != '' ) : ?>
					<?php $font_family = get_ultimate_font_family( $font_family ); ?>
					font-family: <?php echo $font_family; ?>;
				<?php endif; ?>
			}
			#<?php echo $uid; ?> .course-category-widget .top-link span {
				background-color: <?php echo $top_text_bg_color; ?>;
				color: <?php echo $top_text_font_color; ?>;
			}
		</style>*/
		// $args = array(
		// 	$font_family
		// );
		// enquque_ultimate_google_fonts($args);
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
new Dntp_Sensei_Courses_Category();
