<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Linp_Post_List {

	protected $textdomain = SCP_TEXT_DOMAIN;
	protected $namespace = 'linp_post_list';

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
		$thumbnail_sizes = array();
		foreach ( $_wp_additional_image_sizes as $name => $settings ) {
			$thumbnail_sizes[ $name . ' (' . $settings['width'] . 'x' . $settings['height'] . ')' ] = $name;
		}

		$args       = array(
			'orderby' => 'name',
			'parent'  => 0
		);
		$categories = get_categories( $args );
		$cats       = array();
		foreach ( $categories as $category ) {

			$cats[ $category->name ] = $category->term_id;
		}


		/*
		Add your Visual Composer logic here.
		Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

		More info: http://kb.wpbakery.com/index.php?title=Vc_map
		*/
		vc_map( array(
			'name'        => __( 'Post List', $this->textdomain ),
			'description' => __( '', $this->textdomain ),
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
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => __( 'Category', $this->textdomain ),
					'param_name' => 'category',
					'value'      => $cats,
				),
				array(
					'type'       => 'textfield',
					'heading'    => __( 'Number of Posts', $this->textdomain ),
					'param_name' => 'number_of_posts',
					'value'      => '2',
				),
				array(
					'type'       => 'textfield',
					'heading'    => __( 'Post Date Format', $this->textdomain ),
					'param_name' => 'post_date_format',
					'value'      => 'M d, Y',
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Post description word length', $this->textdomain ),
					'param_name'  => 'description_word_length',
					'description' => __( 'Enter number only.', $this->textdomain ),
					'value'       => '15'
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Category Link Text', $this->textdomain ),
					'param_name'  => 'cat_link_text',
					'value'       => 'View All',
					'description' => __( 'If you do not wish to display the Category Link just leave this field blank.', $this->textdomain ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => __( 'Number of rows', $this->textdomain ),
					'param_name' => 'number_of_rows',
					'value'      => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => __( 'Show Comment Count?', $this->textdomain ),
					'param_name' => 'show_comment_count',
					'value'      => array(
						'Yes' => '1',
						'No'  => '0',
					),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => __( 'Thumbnail Dimensions', $this->textdomain ),
					'param_name' => 'thumbnail_dimensions',
					'value'      => $thumbnail_sizes,
				),
                array(
					'type'       => 'colorpicker',
					'class'      => '',
					'heading'    => __( 'Meta Data Color', $this->textdomain ),
					'param_name' => 'meta_data_color',
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
			'category'                => null,
			'number_of_posts'         => 2,
			'cat_link_text'           => '',
			'number_of_rows'          => 1,
			'description_word_length' => '15',
			'thumbnail_dimensions'    => 'thumbnail',
			'post_date_format'        => 'Y-m-d',
			'show_comment_count'      => '1',
			'meta_data_color'         => '',
			'el_class'                => '',
		), $atts ) );

		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

		$args = array(
			'numberposts'      => $number_of_posts,
			'category'         => $category,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'suppress_filters' => false,
		);

		$posts = get_posts( $args );


		// If no posts let's bail
		if ( ! $posts ) {
			return;
		}

		$grid = array(
			'one whole',
			'one half',
			'one third',
			'one fourth',
			'one fifth',
			'one sixth',
		);


		$grid_class = $grid[ (int) $number_of_rows - 1 ];


        $meta_data_style = '';

        if ( $meta_data_color ) {
            $meta_data_style .= 'style="';
            $meta_data_style .= 'color:' . $meta_data_color;
            $meta_data_style .= '"';
        }


		ob_start();

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'linp-post-list ' . $el_class, $this->namespace, $atts );

		?>
		<div class="<?php echo $css_class; ?>">


			<?php foreach ( array_chunk( $posts, $number_of_rows ) as $chunk ): ?>
				<div class="vc_row">
					<?php foreach ( $chunk as $post ): ?>

						<div class="wh-padding item <?php echo $grid_class; ?>">

							<?php $img_url = ''; ?>
							<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
								<?php $img_url = get_the_post_thumbnail( $post->ID, $thumbnail_dimensions, array( 'class' => 'post-list-thumb' ) ); ?>
							<?php endif; ?>
							<?php if ( '' != $img_url ) : ?>
								<div class="img-container">
									<a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ); ?>"><?php echo $img_url; ?></a>
								</div>
							<?php endif; ?>
							<div class="data">

								<h6><a title="<?php echo $post->post_title; ?>" href="<?php echo get_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a></h6>

								<div class="content">
									<?php $text = apply_filters( 'widget_text', strip_shortcodes( $post->post_content ) ); ?>
									<p><?php echo wp_trim_words( strip_shortcodes( $text ), $description_word_length, '&hellip;' ); ?></p>
								</div>

								<hr/>

								<div class="meta-data" <?php echo $meta_data_style; ?>>

				                    <span class="date">
					                    <i class="lnr lnr-clock"></i> <?php echo date_i18n( $post_date_format, strtotime( $post->post_date ) ); ?>
				                    </span>

									<?php if ( (int) $show_comment_count ): ?>
										<span class="comments">
	                                        <i class="lnr lnr-bubble"></i> (<?php echo $post->comment_count; ?>)
	                                    </span>
									<?php endif; ?>
									<span class="author">
				                        <?php _e( 'by', $this->textdomain ); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
											<?php the_author_meta( 'display_name' ); ?>
										</a>
				                    </span>

								</div>
							</div>
						</div>

					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
			<?php if ( $cat_link_text ): ?>
				<?php $category_link = get_category_link( $category ); ?>
				<a class="cbp_widget_link cbp_widget_button" href="<?php echo esc_url( $category_link ); ?>"><?php echo $cat_link_text; ?></a>
			<?php endif; ?>
		</div>

		<?php
		$content = ob_get_clean();

		return $content;
	}

	/*
	Load plugin css and javascript files which you may need on front end of your site
	*/
	public function loadCssAndJs() {
		//wp_register_style( 'linp-post-list', plugins_url( 'assets/post-list.css', __FILE__ ) );
		//wp_enqueue_style( 'linp-post-list' );

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

// Finally initialize code
new Linp_Post_List();
