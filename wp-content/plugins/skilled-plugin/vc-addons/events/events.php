<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Linp_Events {

	protected $textdomain = SCP_TEXT_DOMAIN;
	protected $namespace = 'linp_events';

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
			'name'        => __( 'Tribe Events', $this->textdomain ),
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
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Start Date Format', $this->textdomain ),
					'param_name'  => 'start_date_format',
					'admin_label' => true,
					'value'       => 'M d, Y',
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Nubmer of events to display', $this->textdomain ),
					'param_name'  => 'limit',
					'description' => __( 'Enter number only.', $this->textdomain ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Event description word length', $this->textdomain ),
					'param_name'  => 'description_word_length',
					'description' => __( 'Enter number only.', $this->textdomain ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'View All Events Link Text', $this->textdomain ),
					'param_name'  => 'view_all_events_link_text',
					'description' => __( 'If Left Blank link will not show.', $this->textdomain ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Extra class name', $this->textdomain ),
					'param_name'  => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', $this->textdomain ),
				),
				/**
				 *  Title Typography
				 */

				array(
					"type"             => "ult_param_heading",
					"text"             => __( "Title", $this->textdomain ),
					"param_name"       => "main_heading_typograpy",
					"group"            => "Typography",
					"class"            => "ult-param-heading",
					'edit_field_class' => 'ult-param-heading-wrapper no-top-margin vc_column vc_col-sm-12',
				),
				array(
					"type"        => "ultimate_google_fonts",
					"heading"     => __( "Font Family", $this->textdomain ),
					"param_name"  => "main_heading_font_family",
					"description" => __( "Select the font of your choice.", $this->textdomain ) . " " . __( "You can", $this->textdomain ) . " <a target='_blank' href='" . admin_url( 'admin.php?page=ultimate-font-manager' ) . "'>"
					                 . __( "add new in the collection here", $this->textdomain ) . "</a>.",
					"group"       => "Typography"
				),
				array(
					"type"       => "ultimate_google_fonts_style",
					"heading"    => __( "Font Style", $this->textdomain ),
					"param_name" => "main_heading_style",
					"group"      => "Typography"
				),
				// Responsive Param
				array(
					"type"       => "textfield",
					"class"      => "font-size",
					"heading"    => __( "Font size", 'ultimate_vc' ),
					"param_name" => "main_heading_font_size",
					"group"      => "Typography"
				),
				array(
					"type"       => "colorpicker",
					"class"      => "",
					"heading"    => __( "Font Color", $this->textdomain ),
					"param_name" => "main_heading_color",
					"value"      => "",
					"group"      => "Typography"
				),
				// responsive
				array(
					"type"       => "textfield",
					"class"      => "font-size",
					"heading"    => __( "Line Height", 'ultimate_vc' ),
					"param_name" => "main_heading_line_height",
					"group"      => "Typography"
				),
				/**
				 * Text
				 */
				array(
					"type"             => "ult_param_heading",
					"text"             => __( "Sub Heading Settings", $this->textdomain ),
					"param_name"       => "sub_heading_typograpy",
					"group"            => "Typography",
					"class"            => "ult-param-heading",
					'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
				),
				array(
					"type"        => "ultimate_google_fonts",
					"heading"     => __( "Font Family", $this->textdomain ),
					"param_name"  => "sub_heading_font_family",
					"description" => __( "Select the font of your choice.", $this->textdomain ) . " " . __( "You can", $this->textdomain ) . " <a target='_blank' href='" . admin_url( 'admin.php?page=ultimate-font-manager' ) . "'>"
					                 . __( "add new in the collection here", $this->textdomain ) . "</a>.",
					"group"       => "Typography",
				),
				array(
					"type"       => "ultimate_google_fonts_style",
					"heading"    => __( "Font Style", $this->textdomain ),
					"param_name" => "sub_heading_style",
					"group"      => "Typography",
				),
				// responsive font size
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Font Size", 'ultimate_vc' ),
					"param_name" => "sub_heading_font_size",
					"group"      => "Typography"
				),
				array(
					"type"       => "colorpicker",
					"class"      => "",
					"heading"    => __( "Font Color", $this->textdomain ),
					"param_name" => "sub_heading_color",
					"value"      => "",
					"group"      => "Typography",
				),
				// responsive
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Line Height", $this->textdomain ),
					"param_name" => "sub_heading_line_height",
					"group"      => "Typography"
				),
				/**
				 * Date
				 */
				array(
					"type"             => "ult_param_heading",
					"text"             => __( "Date Settings", $this->textdomain ),
					"param_name"       => "date_heading_typograpy",
					"group"            => "Typography",
					"class"            => "ult-param-heading",
					'edit_field_class' => 'ult-param-heading-wrapper vc_column vc_col-sm-12',
				),
				array(
					"type"        => "ultimate_google_fonts",
					"heading"     => __( "Font Family", $this->textdomain ),
					"param_name"  => "date_heading_font_family",
					"description" => __( "Select the font of your choice.", $this->textdomain ) . " " . __( "You can", $this->textdomain ) . " <a target='_blank' href='" . admin_url( 'admin.php?page=ultimate-font-manager' ) . "'>"
					                 . __( "add new in the collection here", $this->textdomain ) . "</a>.",
					"group"       => "Typography",
				),
				array(
					"type"       => "ultimate_google_fonts_style",
					"heading"    => __( "Font Style", $this->textdomain ),
					"param_name" => "date_heading_style",
					"group"      => "Typography",
				),
				// responsive font size
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Font Size", 'ultimate_vc' ),
					"param_name" => "date_heading_font_size",
					"group"      => "Typography"
				),
				array(
					"type"       => "colorpicker",
					"class"      => "",
					"heading"    => __( "Font Color", $this->textdomain ),
					"param_name" => "date_heading_color",
					"value"      => "",
					"group"      => "Typography",
				),
				// responsive
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Line Height", $this->textdomain ),
					"param_name" => "date_heading_line_height",
					"group"      => "Typography"
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Padding Top", $this->textdomain ),
					"param_name" => "date_heading_padding_top",
					"group"      => "Typography"
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Width", $this->textdomain ),
					"param_name" => "date_heading_width",
					"group"      => "Typography"
				),
				/**
				 * Circles
				 */
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Circle Width", $this->textdomain ),
					"param_name" => "circle_width",
					"group"      => "Circles",
					'value'      => '',
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Circle Margin Right", $this->textdomain ),
					"param_name" => "circle_margin_right",
					"group"      => "Circles",
					'value'      => '',
				),
				array(
					"type"       => "colorpicker",
					"class"      => "",
					"heading"    => __( "Border Color", $this->textdomain ),
					"param_name" => "circle_border_color",
					"value"      => "",
					"group"      => "Circles",
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Border Width", $this->textdomain ),
					"param_name" => "circle_border_width",
					"group"      => "Circles"
				),
				array(
					"type"       => "colorpicker",
					"class"      => "",
					"heading"    => __( "Background Color", $this->textdomain ),
					"param_name" => "circle_background_color",
					"group"      => "Circles"
				),
				// inner circle
				array(
					"type"       => "colorpicker",
					"class"      => "",
					"heading"    => __( "Inner Circle Background Color", $this->textdomain ),
					"param_name" => "inner_circle_background_color",
					"group"      => "Circles"
				),
				array(
					"type"       => "textfield",
					"class"      => "",
					"heading"    => __( "Circle Gap", $this->textdomain ),
					"param_name" => "circle_gap",
					"group"      => "Circles"
				),
			)
		) );
	}

	/*
	Shortcode logic how it should be rendered
	*/
	public function render( $atts, $content = null ) {

		$main_heading_style_inline = $sub_heading_style_inline = $date_style_inline = $date_heading_style_inline = $outer_circle_style = $inner_circle_style = $info_style_inline = '';

		extract( shortcode_atts( array(
			'title'                         => '',
			'limit'                         => '3',
			'description_word_length'       => '20',
			'start_date_format'             => 'M d, Y',
			'textarea_html'                 => '',
			'el_class'                      => '',
			// title
			'main_heading'                  => '',
			'main_heading_font_size'        => '',
			'main_heading_line_height'      => '',
			'main_heading_font_family'      => '',
			'main_heading_style'            => '',
			'main_heading_color'            => '',
			'main_heading_margin'           => '',
			// text
			'sub_heading'                   => '',
			'sub_heading_font_size'         => '',
			'sub_heading_line_height'       => '',
			'sub_heading_font_family'       => '',
			'sub_heading_style'             => '',
			'sub_heading_color'             => '',
			'sub_heading_margin'            => '',
			// date
			'date_heading'                  => '',
			'date_heading_font_size'        => '',
			'date_heading_line_height'      => '',
			'date_heading_font_family'      => '',
			'date_heading_style'            => '',
			'date_heading_color'            => '',
			'date_heading_margin'           => '',
			'date_heading_padding_top'      => '',
			'date_heading_width'            => '50',
			// circles
			'circle_width'                  => '85',
			'circle_margin_right'           => '10',
			'circle_border_color'           => '',
			'circle_border_width'           => '',
			'circle_background_color'       => '',
			// inner circle
			'inner_circle_background_color' => '',
			'circle_gap'                    => '',
		), $atts ) );

		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

		ob_start();

		// Temporarily unset the tribe bar params so they don't apply
		$hold_tribe_bar_args = array();
		foreach ( $_REQUEST as $key => $value ) {
			if ( $value && strpos( $key, 'tribe-bar-' ) === 0 ) {
				$hold_tribe_bar_args[ $key ] = $value;
				unset( $_REQUEST[ $key ] );
			}
		}

		if ( ! function_exists( 'tribe_get_events' ) ) {
			return;
		}

		$posts = tribe_get_events( apply_filters( 'tribe_events_list_widget_query_args', array(
			'eventDisplay'   => 'list',
			'posts_per_page' => $limit
		) ) );

		// If no posts let's bail
		if ( ! $posts ) {
			return;
		}


		/**
		 *  Title
		 */
		if ( $main_heading_font_family != '' ) {
			$mhfont_family = get_ultimate_font_family( $main_heading_font_family );
			if ( $mhfont_family ) {
				$main_heading_style_inline .= 'font-family:\'' . $mhfont_family . '\';';
			}
		}
		// main heading font style
		$main_heading_style_inline .= get_ultimate_font_style( $main_heading_style );
		//attach font size if set

		//attach font color if set
		if ( $main_heading_color != '' ) {
			$main_heading_style_inline .= 'color:' . $main_heading_color . ';';
		}
		if ( $main_heading_margin != '' ) {
			$main_heading_style_inline .= $main_heading_margin;
		}

		if ( $main_heading_font_size != '' ) {
			$main_heading_style_inline .= 'font-size:' . (int) $main_heading_font_size . 'px;';
		}

		if ( $main_heading_line_height != '' ) {
			$main_heading_style_inline .= 'line-height:' . (int) $main_heading_line_height . 'px;';
		}

		/**
		 *  Text
		 */
		if ( $sub_heading_font_family != '' ) {
			$shfont_family = get_ultimate_font_family( $sub_heading_font_family );
			if ( $shfont_family != '' ) {
				$sub_heading_style_inline .= 'font-family:\'' . $shfont_family . '\';';
			}
		}
		//sub heaing font style
		$sub_heading_style_inline .= get_ultimate_font_style( $sub_heading_style );

		//attach font color if set
		if ( $sub_heading_color != '' ) {
			$sub_heading_style_inline .= 'color:' . $sub_heading_color . ';';
		}
		//attach margins for sub heading
		if ( $sub_heading_margin != '' ) {
			$sub_heading_style_inline .= $sub_heading_margin;
		}
		if ( $sub_heading_font_size != '' ) {
			$sub_heading_style_inline .= 'font-size:' . (int) $sub_heading_font_size . 'px;';
		}

		if ( $sub_heading_line_height != '' ) {
			$sub_heading_style_inline .= 'line-height:' . (int) $sub_heading_line_height . 'px;';
		}

		/**
		 *  Date
		 */
		if ( $date_heading_font_family != '' ) {
			$date_font_family = get_ultimate_font_family( $date_heading_font_family );
			if ( $date_font_family != '' ) {
				$date_heading_style_inline .= 'font-family:\'' . $date_font_family . '\';';
			}
		}
		//sub heaing font style
		$date_heading_style_inline .= get_ultimate_font_style( $date_heading_style );

		//attach font color if set
		if ( $date_heading_color != '' ) {
			$date_heading_style_inline .= 'color:' . $date_heading_color . ';';
		}
		//attach margins for sub heading
		if ( $date_heading_margin != '' ) {
			$date_heading_style_inline .= $date_heading_margin;
		}
		if ( $date_heading_font_size != '' ) {
			$date_heading_style_inline .= 'font-size:' . (int) $date_heading_font_size . 'px;';
		}

		if ( $date_heading_line_height != '' ) {
			$date_heading_style_inline .= 'line-height:' . (int) $date_heading_line_height . 'px;';
		}

		if ( $date_heading_padding_top != '' ) {
			$date_heading_style_inline .= 'padding-top:' . (int) $date_heading_padding_top . 'px;';
		}


		if ( $date_heading_width != '' ) {
			$date_heading_style_inline .= 'width:' . (int) $date_heading_width . 'px;';
		}


		/**
		 * Circles
		 */
		if ( $circle_width != '' ) {
			$outer_circle_style .= 'width:' . (int) $circle_width . 'px;';
			$outer_circle_style .= 'height:' . (int) $circle_width . 'px;';
		}

		if ( $circle_background_color != '' ) {
			$outer_circle_style .= 'background-color:' . $circle_background_color . ';';
		}

		if ( $circle_gap != '' ) {
			$outer_circle_style .= 'padding:' . (int) $circle_gap . 'px;';
		}


		if ( $circle_border_color != '' && $circle_border_width ) {

			$circle_border_width = (int) $circle_border_width . 'px';

			$outer_circle_style .= 'border:' . $circle_border_width . ' solid ' . $circle_border_color;
		}

		/**
		 * Inner Circle
		 */
		if ( $inner_circle_background_color != '' ) {
			$inner_circle_style .= 'background-color:' . $inner_circle_background_color . ';';
		}

		/**
		 * Info
		 */

		if ( $circle_width ) {

			$margin = (int) $circle_width;
			if ( $circle_margin_right != '' ) {
				$margin += (int) $circle_margin_right;
			}
			$info_style_inline .= 'margin-left:' . $margin . 'px;';
		}

		//Check if any posts were found
		if ( $posts ) {
			?>
			<div class="linp-tribe-events-wrap">
				<ul class="linp-tribe-events">
					<?php
					foreach ( $posts as $post ) :
						setup_postdata( $post );
						?>
						<li class="event">
							<div class="icon" style="<?php echo $outer_circle_style; ?>">
								<div class="inner-circle" style="<?php echo $inner_circle_style; ?>">

									<div class="date" style="<?php echo $date_heading_style_inline; ?>">
										<?php echo tribe_get_start_date( $post, false, $start_date_format ); ?>
										<!--							--><?php //echo tribe_events_event_schedule_details($post);
										?>
									</div>
								</div>
							</div>
							<div class="info" style="<?php echo $info_style_inline; ?>">
							
								<div class="title">
									<a style="<?php echo $main_heading_style_inline; ?>" href="<?php echo tribe_get_event_link( $post ); ?>" rel="bookmark"><?php echo $post->post_title; ?></a>
								</div>

								<div class="content" style="<?php echo $sub_heading_style_inline; ?>;">
									<?php echo wp_trim_words( strip_shortcodes( $post->post_content ), $description_word_length, '&hellip;' ); ?>
								</div>
							</div>
						</li>
					<?php
					endforeach;
					?>
				</ul>
				<?php if ( ! empty( $view_all_events_link_text ) ) : ?>
					<p class="linp-tribe-events-link">
						<a href="<?php echo tribe_get_events_link(); ?>" rel="bookmark"><?php echo $view_all_events_link_text; ?></a>
					</p>
				<?php endif; ?>
			</div>
			<?php
			//No Events were Found
		} else {
			?>
			<p><?php _e( 'There are no upcoming events at this time.', $this->textdomain ); ?></p>
		<?php
		}

		wp_reset_query();
		$content = ob_get_clean();

		return $content;
	}

	/*
	Load plugin css and javascript files which you may need on front end of your site
	*/
	public function loadCssAndJs() {
//		wp_register_style( 'vc_addon_events', plugins_url( 'assets/main.css', __FILE__ ) );
//		wp_enqueue_style( 'vc_addon_events' );

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

new Linp_Events();