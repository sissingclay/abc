<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


class Linp_VC_Learnpress_Courses_Carousel {

	protected $textdomain = SCP_TEXT_DOMAIN;
	protected $namespace = 'linp_learnpress_courses_carousel';

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

		global $_wp_additional_image_sizes;
		$thumbs_dimensions_array = array( 'thumbnail' );

		if ( $_wp_additional_image_sizes ) {
			foreach ( $_wp_additional_image_sizes as $imageSizeName => $image_size ) {
				$thumbs_dimensions_array[ $imageSizeName . ' | ' . $image_size['width'] . 'px, ' . $image_size['height'] . 'px' ] = $imageSizeName;
			}
		}
		$thumbs_dimensions_array[] = 'full-width';

		/*
		  Add your Visual Composer logic here.
		  Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

		  More info: http://kb.wpbakery.com/index.php?title=Vc_map
		 */
		vc_map( array(
			'name'        => __( 'LearnPress - Courses Carousel', $this->textdomain ),
			'description' => __( 'Display courses', $this->textdomain ),
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			// or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
			'category'    => __( 'Aislin', $this->textdomain ),
			//'admin_enqueue_js' => array(plugins_url('assets/vc_extend.js', __FILE__)), // This will load js file in the VC backend editor
			//'admin_enqueue_css' => array(plugins_url('assets/vc_extend_admin.css', __FILE__)), // This will load css file in the VC backend editor
			'params'      => array(
				array(
					'type'        => 'textfield',
					'holder'      => 'div',
					'class'       => '',
					'heading'     => __( 'Title', $this->textdomain ),
					'param_name'  => 'title',
					'value'       => '',
					'description' => __( 'Title to display on front.', $this->textdomain )
				),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Course Type', $this->textdomain ),
					'param_name' => 'course_type',
					'value'      => array(
						'All'              => 'usercourses',
						'Free Courses'     => 'freecourses',
						'Paid Courses'     => 'paidcourses',
						'Featured Courses' => 'featuredcourses',
					),
				),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Image Size', $this->textdomain ),
					'param_name' => 'image_size',
					'value'      => $thumbs_dimensions_array,
				),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Show Ratings?', $this->textdomain ),
					'param_name' => 'show_ratings',
					'value'      => array(
						'Yes' => '1',
						'No'  => '0',
					),
				),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Show Separator?', $this->textdomain ),
					'param_name' => 'show_separator',
					'value'      => array(
						'Yes' => '1',
						'No'  => '0',
					),
				),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Show Category?', $this->textdomain ),
					'param_name' => 'show_category',
					'value'      => array(
						'Yes' => '1',
						'No'  => '0',
					),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Image takes the full width', $this->textdomain ),
					'description' => __( 'Inner padding won\'t affect the image', $this->textdomain ),
					'param_name'  => 'image_is_full_width',
					'value'       => array(
						'Yes' => '1',
						'No'  => '0',
					),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Image is rounded?', $this->textdomain ),
					'param_name'  => 'image_is_rounded',
					'value'       => array(
						'No'  => '0',
						'Yes' => '1',
					),
				),
				// array(
				// 	'type'       => 'dropdown',
				// 	'holder'     => '',
				// 	'class'      => '',
				// 	'heading'    => __( 'Show Author Avatar?', $this->textdomain ),
				// 	'param_name' => 'show_avatar',
				// 	'value'      => array(
				// 		'Yes' => '1',
				// 		'No'  => '0',
				// 	),
				// ),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Show Excerpt?', $this->textdomain ),
					'param_name' => 'show_excerpt',
					'value'      => array(
						'Yes' => '1',
						'No'  => '0',
					),
				),
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Number of Words', $this->textdomain ),
					'param_name'  => 'number_of_words',
					'value'       => '10',
					'description' => __( 'Number of words of the excerpt.', $this->textdomain ),
					'group'       => '',
				),
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Number of Items', $this->textdomain ),
					'param_name'  => 'number_of_items',
					'value'       => '8',
					'description' => __( 'Number of items to show.', $this->textdomain ),
					'group'       => 'Slider Settings',
				),
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Number of Items per Slide', $this->textdomain ),
					'param_name'  => 'number_of_items_per_slide',
					'value'       => '4',
					'description' => __( 'Number of items per slide.', $this->textdomain ),
					'group'       => 'Slider Settings',
				),
				array(
					'type'       => 'textfield',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Slide Speed', $this->textdomain ),
					'param_name' => 'slide_speed',
					'value'      => '500',
					'group'      => 'Slider Settings',
				),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Auto Play', $this->textdomain ),
					'param_name' => 'autoplay',
					'value'      => array(
						'No'  => '0',
						'Yes' => '1',
					),
					'group'      => 'Slider Settings',
				),
				// array(
				// 	'type'       => 'dropdown',
				// 	'holder'     => '',
				// 	'class'      => '',
				// 	'heading'    => __( 'Show Navigation', $this->textdomain ),
				// 	'param_name' => 'show_navigation',
				// 	'value'      => array(
				// 		'Yes' => '1',
				// 		'No'  => '0',
				// 	),
				// 	'group'      => 'Slider Settings',
				// ),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Show Bullets', $this->textdomain ),
					'param_name' => 'show_bullets',
					'value'      => array(
						'No'  => '0',
						'Yes' => '1',
					),
					'group'      => 'Slider Settings',
				),
				// array(
				// 	'type'       => 'dropdown',
				// 	'holder'     => '',
				// 	'class'      => '',
				// 	'heading'    => __( 'Controls Position', $this->textdomain ),
				// 	'param_name' => 'controls_position',
				// 	'value'      => array(
				// 		// written with dashes instead to be used as css classes
				// 		'Bottom Center' => 'bottom-center',
				// 		'Bottom Right'  => 'bottom-right',
				// 		'Bottom Left'   => 'bottom-left',
				// 		'Top Center'    => 'top-center',
				// 		'Top Right'     => 'top-right',
				// 		'Top Left'      => 'top-left',
				// 	),
				// 	'group'      => 'Slider Settings',
				// ),
				array(
					'type'        => 'dropdown',
					'holder'      => '',
					'class'       => '',
					'heading'     => __( 'Adaptive Height', $this->textdomain ),
					'param_name'  => 'adaptive_height',
					'description' => 'Use it only for one item per page setting.',
					'value'       => array(
						'No'  => '0',
						'Yes' => '1',
					),
					'group'       => 'Slider Settings',
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

	public function render( $atts, $content = null ) {
		$uid = uniqid( 'vc-addon-featured-courses' );

		extract( shortcode_atts( array(
			'title'                     => '',
			'course_type'               => 'usercourses',
			'includes'                  => '',
			'number_of_items'           => '8',
			'number_of_items_per_slide' => '4',
			'slide_speed'               => '500',
			'autoplay'                  => '0',
			// 'show_navigation'           => '1',
			// 'controls_position'         => 'bottom-center',
			'show_bullets'              => '0',
			'show_ratings'              => '1',
			'show_separator'            => '1',
			'show_category'             => '1',
			'image_is_full_width'       => '1',
			'image_is_rounded'          => '0',
			// 'show_avatar'               => '1',
			'show_excerpt'              => '1',
			'number_of_words'           => '10',
			'adaptive_height'           => 'true',
			'image_size'                => 'thumbnail',
			'el_class'                  => '',
		), $atts ) );


		if ( function_exists( 'LP' ) ) {

			ob_start();


			// adapted from woothemes-sensei/inc/woothemes-sensei-template.php shortcode_featured_courses()

			global $woothemes_sensei, $post, $wp_query, $current_user;

			$query_type = $course_type;

			$amount          = $number_of_items;
			$course_includes = array();
			$course_excludes = array();
//			$posts_array     = $woothemes_sensei->post_types->course->course_query( $amount, $query_type, $course_includes, $course_excludes );
			$posts_array     = get_posts(array('post_type' => LP()->course_post_type));

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'learnpress linp-featured-courses-carousel ' . $el_class, $this->namespace, $atts );
			if ( count( $posts_array ) > 0 ) {
				?>

				<?php if ( $title ): ?>
					<h2><?php echo $title; ?></h2>
				<?php endif ?>
				<div id="<?php echo $uid; ?>" class="<?php echo $css_class; ?>">

					<?php
					foreach ( $posts_array as $post_item ) {
						// Make sure the other loops dont include the same post twice!
						array_push( $course_excludes, $post_item->ID );
						// Get meta data
						$post_id               = absint( $post_item->ID );
						$post_title            = $post_item->post_title;
						$user_info             = get_userdata( absint( $post_item->post_author ) );
						$author_link           = get_author_posts_url( absint( $post_item->post_author ) );
						$author_display_name   = $user_info->display_name;
						$author_id             = $post_item->post_author;
						$category_output       = get_the_term_list( $post_id, 'course-category', '', ', ', '' );
						$preview_lesson_count  = 1;
						$is_user_taking_course = 0;


						?>

						<div>
							<?php
							if ( $image_is_full_width ) {
								include 'partials/image.php';
							}

							?>

							<div class="item-inner-wrap">
								<?php
								if ( ! $image_is_full_width ) {
									include 'partials/image.php';
								}
								include 'partials/price.php';
//								include 'partials/categories.php';
								include 'partials/title.php';
//								include 'partials/separator.php';
								include 'partials/excerpt.php';
								include 'partials/ratings.php';

								?>
							</div>
							<?php include 'partials/lesson-count.php';; ?>
						</div>
					<?php
					} // End For Loop
					?>
				</div>

				<script>
					var dntp_vc_addons = dntp_vc_addons || {};
					dntp_vc_addons.data = dntp_vc_addons.data || {};

					if (!dntp_vc_addons.data.sliders_owl) {
						dntp_vc_addons.data.sliders_owl = [];
					}

					dntp_vc_addons.data.sliders_owl.push({
						id: '<?php echo $uid; ?>',
						options: {
							items: <?php echo (int) $number_of_items_per_slide; ?>,
							itemsCustom: false,
							itemsDesktop: [1199, <?php echo (int) $number_of_items_per_slide; ?>],
							itemsDesktopSmall: [980, <?php echo (int) $number_of_items_per_slide; ?>],
							itemsTablet: [768, 2],
							itemsTabletSmall: false,
							itemsMobile: [479, 1],
							singleItem: false,
							itemsScaleUp: false,

							//Basic Speeds
							slideSpeed: <?php echo (int) $slide_speed; ?>,
							paginationSpeed: 800,
							rewindSpeed: 1000,

							//Autoplay
							autoPlay: <?php echo (int) $autoplay ? 'true' : 'false'; ?>,
							stopOnHover: false,

							// Navigation
							//navigation: <?php //echo (int) $show_navigation ? 'true' : 'false'; ?>,
							//navigationText: ['<', '>'],
							rewindNav: true,
							scrollPerPage: false,

							//Pagination
							pagination: <?php echo (int) $show_bullets ? 'true' : 'false'; ?>,
							paginationNumbers: <?php echo (int) $show_bullets ? 'false' : 'true'; ?>, // this has to be reversed to use bullets

							// Responsive
							responsive: true,
							responsiveRefreshRate: 200,
							responsiveBaseWidth: window,

							// CSS Styles
							baseClass: 'owl-carousel',
							theme: 'owl-theme',
							//theme: 'owl-theme controls-<?php //echo $controls_position; ?>',

							//Lazy load
							lazyLoad: true,
							lazyFollow: true,
							lazyEffect: 'fade',

							//Auto height
							autoHeight: <?php echo (int) $adaptive_height ? 'true' : 'false'; ?>
						}
					});
				</script>
			<?php
			}

			$content = ob_get_clean();

			return $content;
		}
	}

	/*
	  Load plugin css and javascript files which you may need on front end of your site
	 */

	public function loadCssAndJs() {
		//wp_register_style( 'owl.carousel', plugins_url( 'assets/owl.carousel.css', __FILE__ ) );
		//wp_enqueue_style( 'owl.carousel' );
		//wp_register_style( 'owl.theme', plugins_url( 'assets/owl.theme.css', __FILE__ ) );
		//wp_enqueue_style( 'owl.theme' );
		//wp_register_style( 'owl.transitions', plugins_url( 'assets/owl.transitions.css', __FILE__ ) );
		//wp_enqueue_style( 'owl.transitions' );
		//wp_enqueue_style( 'sensei-courses-carousel', plugins_url( 'assets/sensei-courses-carousel.css', __FILE__ ) );

		// If you need any javascript files on front end, here is how you can load them.
		wp_enqueue_script( 'owl.carousel', plugins_url( 'assets/owl.carousel.min.js', __FILE__ ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'sensei-courses-carousel', plugins_url( 'assets/sensei-courses-carousel.js', __FILE__ ), array( 'jquery' ), false, true );
	}

	/*
	  Show notice if your plugin is activated but Visual Composer is not
	 */

	public function showVcVersionNotice() {
		$plugin_data = get_plugin_data( __FILE__ );
		echo '
        <div class="updated">
          <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend' ), $plugin_data['Name'] ) . '</p>
        </div>';
	}

}

new Linp_VC_Learnpress_Courses_Carousel();
