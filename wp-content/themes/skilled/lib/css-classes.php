<?php
/**
 * @param string $namespace
 * @param array $options
 *
 * @return mixed|void
 */
function skilled_class( $namespace, $options = array() ) {

	$class           = '';
	$padding_class   = 'wh-padding';
	$row_class       = 'cbp-row';
	$container_class = 'cbp-container';

	/**
	 * Main Wrapper
	 */
	if ( $namespace == 'main-wrapper' ) {
		$use_embellishments = skilled_get_option( 'content-embellishments-enable', false );

		$embellishment_class = '';
		if ( $use_embellishments ) {

			$embellishment_top_img     = skilled_get_option( 'content-embellishment-background-top', array() );
			$embellishment_top_img_url = isset( $embellishment_top_img['background-image'] ) && $embellishment_top_img['background-image'] ? $embellishment_top_img['background-image'] : '';

			$embellishment_bottom_img     = skilled_get_option( 'content-embellishment-background-bottom', array() );
			$embellishment_bottom_img_url = isset( $embellishment_bottom_img['background-image'] ) && $embellishment_bottom_img['background-image'] ? $embellishment_bottom_img['background-image'] : '';

			$embellishment_class = ' wh-has-embellishment';

			if ( $embellishment_top_img_url ) {
				$embellishment_class .= ' wh-embellishment-type-content-top';
			}
			if ( $embellishment_bottom_img_url ) {
				$embellishment_class .= ' wh-embellishment-type-content-bottom';
			}
		}

		$class = $row_class . ' wh-content' . $embellishment_class;

		/**
		 * Row
		 */
	} elseif ( $namespace == 'row' ) {
		$class = $row_class;

		/**
		 * Container
		 */
	} elseif ( $namespace == 'container' ) {
		$class = $container_class;

		/**
		 * Container
		 */
	} elseif ( $namespace == 'container_home_content' ) {
		$class = $container_class . ' ' . $padding_class;

		/**
		 * Strecher
		 */
	} elseif ( $namespace == 'strecher' ) {
		$class = 'cbp-strecher';

		/**
		 * Content
		 */
	} elseif ( $namespace == 'content' ) {
		$content_width       = skilled_get_option( 'content-width', 9 );
		$mapped_grid_classes = skilled_grid_class_map();
		$class               = $mapped_grid_classes[ $content_width - 1 ][0] . ' ' . $padding_class . ' wh-content-inner';

		/**
		 * Content - Fullwidth
		 */
	} elseif ( $namespace == 'content-fullwidth' ) {
		$class = 'entry-content one whole ' . $padding_class;

		/**
		 * Sidebar
		 */
	} elseif ( $namespace == 'sidebar' ) {
		$sidebar_width       = skilled_get_option( 'sidebar-width', 3 );
		$mapped_grid_classes = skilled_grid_class_map();
		$class               = 'wh-sidebar ' . $mapped_grid_classes[ $sidebar_width - 1 ][0] . ' ' . $padding_class;

		/**
		 * Logo Wrapper
		 */
	} elseif ( $namespace == 'logo-wrapper' ) {

		$logo_width          = skilled_get_option( 'logo-width', 3 );
		$mapped_grid_classes = skilled_grid_class_map();
		$class               = 'wh-logo-wrap '  . $mapped_grid_classes[ $logo_width - 1 ][0] . ' ' . $padding_class;

		/**
		 * Logo
		 */
	} elseif ( $namespace == 'logo' ) {
		$logo_alignment = skilled_get_option( 'logo-alignment', 'left' );
		$class          = 'wh-logo';
		switch ( $logo_alignment ) {
			case 'left':
				$class .= ' align-left';
				break;
			case 'right':
				$class .= ' align-right';
				break;
			case 'center':
				$class .= ' align-center';
				break;
		}

		/**
		 * Main Bar Wrapper
		 */
	} elseif ( $namespace == 'main-menu-bar-wrapper' ) {
		$enable_sticky = skilled_get_option( 'main-menu-use-menu-is-sticky', 1 );

		$class = 'wh-main-menu-bar-wrapper';

		if ($enable_sticky) {
			$class .= ' wh-sticky-header-enabled';
		}

		/**
		 * Main Menu Wrapper
		 */
	} elseif ( $namespace == 'main-menu-wrapper' ) {

		$class = 'wh-main-menu ';
		if ( skilled_get_option( 'logo-location', 'main_menu' ) == 'main_menu' ) {
			$logo_width          = skilled_get_option( 'logo-width', 3 );
			$mapped_grid_classes = skilled_grid_class_map();
			$class               .= $mapped_grid_classes[ $logo_width - 1 ][1] . ' ' . $padding_class;
		} else {
			$class               .= 'one whole ' . $padding_class;
		}

		/**
		 * Main Menu Wrapper
		 */
	} elseif ( $namespace == 'mega-main-menu-wrapper' ) {
		$class = 'mega-main-menu-wrapper';

		/**
		 * Main Menu
		 */
	} elseif ( $namespace == 'main-menu' ) {
		$menu_alignment = skilled_get_option( 'main-menu-alignment', 'left' );
		$class          = 'sf-menu wh-menu-main';
		switch ( $menu_alignment ) {
			case 'left':
				$class .= ' pull-left';
				break;
			case 'right':
				$class .= ' pull-right';
				break;
		}

		/**
		 * Main Menu Container
		 */
	} elseif ( $namespace == 'main-menu-container' ) {
		$menu_alignment = skilled_get_option( 'main-menu-alignment' );
		if ( $menu_alignment && $menu_alignment == 'center' ) {
			$class = 'wh-ul-center';
		}

		/**
		 * Footer
		 */
	} elseif ( $namespace == 'footer' ) {
		$class = $row_class . ' wh-footer';

		/**
		 * Footer Bottom
		 */
	} elseif ( $namespace == 'footer-bottom' ) {
		$class = $row_class . ' wh-footer-bottom';

		/**
		 * Footer Widgets Wrap
		 */
	} elseif ( $namespace == 'footer-widgets-wrap' ) {
		$class = $row_class . ' wh-footer-widgets';

		/**
		 * Footer Widgets
		 */
	} elseif ( $namespace == 'widget-footer' ) {
		$widget_width = skilled_get_option( 'footer-widget-width', 3 );
		$class        = skilled_get_grid_class( $widget_width - 1 ) . ' ' . $padding_class;

		/**
		 * Footer Menu Wrap
		 */
	} elseif ( $namespace == 'footer-menu-wrap' ) {
		$widget_width = skilled_get_option( 'footer-elements-grid-menu', 6 );
		$class        = skilled_get_grid_class( $widget_width - 1 ) . ' ' . $padding_class;

		/**
		 * Footer Menu
		 */
	} elseif ( $namespace == 'footer-menu' ) {
		$menu_alignment = skilled_get_option( 'footer-menu-alignment', 'left' );
		$class          = 'sf-menu wh-menu-footer';
		switch ( $menu_alignment ) {
			case 'left':
				$class .= ' pull-left';
				break;
			case 'right':
				$class .= ' pull-right';
				break;
		}

		/**
		 * Footer Menu Container
		 */
	} elseif ( $namespace == 'footer-menu-container' ) {
		$menu_alignment = skilled_get_option( 'footer-menu-alignment' );
		$class          = 'wh-footer-menu-wrap';
		if ( $menu_alignment && $menu_alignment == 'center' ) {
			$class = 'wh-ul-center';
		}

		/**
		 * Footer Text
		 */
	} elseif ( $namespace == 'footer-text' ) {
		$widget_width        = skilled_get_option( 'footer-elements-grid-text', 6 );
		$class               = skilled_get_grid_class( $widget_width - 1 ) . ' ' . $padding_class;
		$menu_alignment      = skilled_get_option( 'footer-text-alignment', 'left' );
		$alignment_class     = '';

		switch ( $menu_alignment ) {
			case 'left':
				$alignment_class = ' align-left';
				break;
			case 'right':
				$alignment_class = ' align-right';
				break;
			case 'center':
				$alignment_class = ' align-center';
				break;
		}
		$class .= $alignment_class;
		/**
		 * Footer Social Links
		 */
	} elseif ( $namespace == 'footer-social-links' ) {

		$class               = 'social-links ';

		$widget_width        = skilled_get_option( 'footer-elements-grid-social-links', 3 );
		$class               .= skilled_get_grid_class( $widget_width - 1 ) . ' ' . $padding_class;
		$menu_alignment      = skilled_get_option( 'footer-social-links-alignment', 'left' );
		$alignment_class     = '';

		switch ( $menu_alignment ) {
			case 'left':
				$alignment_class = ' align-left';
				break;
			case 'right':
				$alignment_class = ' align-right';
				break;
			case 'center':
				$alignment_class = ' align-center';
				break;
		}
		$class .= $alignment_class;

		/**
		 * Footer Separator Container
		 */
	} elseif ( $namespace == 'footer-separator-container' ) {
		$class = $row_class . ' wh-footer-separator-container';

	/**
		 * Footer Separator
		 */
	} elseif ( $namespace == 'footer-separator' ) {
		$class = 'wh-footer-separator';

		/**
		 * Header
		 */
	} elseif ( $namespace == 'header' ) {
		$use_sticky_menu     = skilled_get_option( 'use-sticky-menu', true );
		$use_embellishments  = skilled_get_option( 'header-embellishments-enable', false );
		$embellishment_class = '';

		if ( $use_embellishments ) {

			$embellishment_top_img     = skilled_get_option( 'header-embellishment-background-top', array() );
			$embellishment_top_img_url = isset( $embellishment_top_img['background-image'] ) && $embellishment_top_img['background-image'] ? $embellishment_top_img['background-image'] : '';

			$embellishment_bottom_img     = skilled_get_option( 'header-embellishment-background-bottom', array() );
			$embellishment_bottom_img_url = isset( $embellishment_bottom_img['background-image'] ) && $embellishment_bottom_img['background-image'] ? $embellishment_bottom_img['background-image'] : '';

			$embellishment_class = ' wh-has-embellishment';

			if ( $embellishment_top_img_url ) {
				$embellishment_class .= ' wh-embellishment-type-header-top';
			}
			if ( $embellishment_bottom_img_url ) {
				$embellishment_class .= ' wh-embellishment-type-header-bottom';
			}
		}
		$class = $row_class . ' wh-header wh-header-inner ' . $embellishment_class;

		/**
		 * Pagination
		 */
	} elseif ( $namespace == 'pagination' ) {
		$class = 'double-pad-top';

		/**
		 * Post
		 */
	} elseif ( $namespace == 'post-item' ) {
		$class = 'one whole wh-post-item';

		/**
		 * Post one half
		 */
	} elseif ( $namespace == 'post-item-one-half' ) {
		$class = 'one whole wh-post-item one half';

		/**
		 * Page Title Row
		 */
	} elseif ( $namespace == 'page-title-row' ) {

		$use_embellishments  = skilled_get_option( 'page-title-embellishments-enable', false );
		$embellishment_class = '';

		if ( $use_embellishments ) {

			$embellishment_top_img     = skilled_get_option( 'page-title-embellishment-background-top', array() );
			$embellishment_top_img_url = isset( $embellishment_top_img['background-image'] ) && $embellishment_top_img['background-image'] ? $embellishment_top_img['background-image'] : '';

			$embellishment_bottom_img     = skilled_get_option( 'page-title-embellishment-background-bottom', array() );
			$embellishment_bottom_img_url = isset( $embellishment_bottom_img['background-image'] ) && $embellishment_bottom_img['background-image'] ? $embellishment_bottom_img['background-image'] : '';

			$embellishment_class = ' wh-has-embellishment';

			if ( $embellishment_top_img_url ) {
				$embellishment_class .= ' wh-embellishment-type-page-title-top';
			}
			if ( $embellishment_bottom_img_url ) {
				$embellishment_class .= ' wh-embellishment-type-page-title-bottom';
			}
		}
		$class = $row_class . ' wh-page-title-bar' . $embellishment_class;

		/**
		 * Page Title Grid Wrapper
		 */
	} elseif ( $namespace == 'page-title-grid-wrapper' ) {
		$class = 'one whole ' . $padding_class . ' wh-page-title-wrapper';

		/**
		 * Page Title
		 */
	} elseif ( $namespace == 'page-title' ) {

		$class = 'page-title';

		/**
		 * Breadcrumbs
		 */
	} elseif ( $namespace == 'breadcrumbs' ) {
		$menu_alignment  = skilled_get_option( 'page-title-breadcrumbs-alignment', 'left' );
		$alignment_class = '';
		switch ( $menu_alignment ) {
			case 'left':
				$alignment_class = 'align-left';
				break;
			case 'right':
				$alignment_class = 'align-right';
				break;
			case 'center':
				$alignment_class = 'align-center';
				break;
		}
		$class = 'wh-breadcrumbs ' . $alignment_class;

		/**
		 * Top Bar Menu Wrap
		 */
	} elseif ( $namespace == 'top-bar' ) {
		$class = $row_class . ' wh-top-bar';

		/**
		 * Top Bar Menu Wrap
		 */
	} elseif ( $namespace == 'top-bar-menu-wrap' ) {
		$widget_width        = skilled_get_option( 'top-bar-menu-width', 3 );
		$mapped_grid_classes = skilled_grid_class_map();
		$class               = $mapped_grid_classes[ $widget_width - 1 ][0] . ' ' . $padding_class;

		/**
		 * Top Bar Text
		 */
	} elseif ( $namespace == 'top-bar-text' ) {
		$widget_width        = skilled_get_option( 'top-bar-text-width', 3 );
		$mapped_grid_classes = skilled_grid_class_map();
		$class               = $mapped_grid_classes[ $widget_width - 1 ][0] . ' ' . $padding_class;

		$menu_alignment  = skilled_get_option( 'top-bar-text-alignment', 'left' );
		$alignment_class = '';

		switch ( $menu_alignment ) {
			case 'left':
				$alignment_class = ' align-left';
				break;
			case 'right':
				$alignment_class = ' align-right';
				break;
			case 'center':
				$alignment_class = ' align-center';
				break;
		}
		$class .= ' wh-top-bar-text' . $alignment_class;

		/**
		 * Top Bar Additional
		 */
	} elseif ( $namespace == 'top-bar-additional' ) {
		$class = $row_class . ' wh-top-bar-additional';



		/**
		 * Top Bar Additional Text
		 */
	} elseif ( $namespace == 'top-bar-additional-text' ) {

		if ( skilled_get_option( 'logo-location' ) == 'top_bar_additional' ) {
			$logo_width          = skilled_get_option( 'logo-width', 3 );
			$mapped_grid_classes = skilled_grid_class_map();
			$class               = $mapped_grid_classes[ $logo_width - 1 ][1] . ' ' . $padding_class;

		} else {
			$mapped_grid_classes = skilled_grid_class_map();
			$class               = $mapped_grid_classes[ 12 - 1 ][0] . ' ' . $padding_class;
		}

		$menu_alignment  = skilled_get_option( 'top-bar-additional-text-alignment', 'left' );
		$alignment_class = '';

		switch ( $menu_alignment ) {
			case 'left':
				$alignment_class = ' align-left';
				break;
			case 'right':
				$alignment_class = ' align-right';
				break;
			case 'center':
				$alignment_class = ' align-center';
				break;
		}
		$class .= ' wh-top-bar-additional-text' . $alignment_class;


		/**
		 * Top Menu
		 */
	} elseif ( $namespace == 'top-menu' ) {
		$menu_alignment = skilled_get_option( 'top-bar-menu-alignment', 'left' );
		$class          = 'sf-menu wh-menu-top';

		switch ( $menu_alignment ) {
			case 'left':
				$class .= ' pull-left';
				break;
			case 'right':
				$class .= ' pull-right';
				break;
		}

		/**
		 * Top Menu Container
		 */
	} elseif ( $namespace == 'top-menu-container' ) {
		$menu_alignment = skilled_get_option( 'top-bar-menu-alignment' );
		$class          = 'wh-top-menu-wrap';
		if ( $menu_alignment && $menu_alignment == 'center' ) {
			$class = 'wh-ul-center';
		}

		/**
		 * Top Menu Container
		 */
	} elseif ( $namespace == 'dntp-featured-courses-item-img-is-rounded' ) {
		$is_rounded = skilled_get_option( 'dntp-featured-courses-item-img-is-rounded' );

		if ( $is_rounded ) {
			$class = 'wh-rounded';
		}

		/**
		 * Sensei
		 * Single Course Header
		 */
	} elseif ( $namespace == 'sensei-single-course-header' ) {
		$class = 'cbp-row wh-sensei-single-course-header';

		/**
		 * Sensei
		 * Single Course Header Author
		 */
	} elseif ( $namespace == 'sensei-single-course-header-author' ) {
		$class = 'wh-sensei-header-author one third wh-rounded';

		/**
		 * Sensei
		 * Single Course Header Title Wrap
		 */
	} elseif ( $namespace == 'sensei-single-course-header-title-wrap' ) {
		$class .= 'wh-sensei-title-wrap ' . $padding_class;

		/**
		 * Sensei
		 * Single Course Header Title Wrap
		 */
	} elseif ( $namespace == 'sensei-single-course-header-meta-wrap' ) {
		$class               = 'meta-wrap';

		/**
		 * Sensei
		 * Single Course Sidebar Text Wrap
		 */
	} elseif ( $namespace == 'sensei-course-sidebar-text' ) {
		$class               = 'wh-sensei-course-sidebar-text';

		/**
		 * Sensei
		 * Single Course Header Title Wrap
		 */
	// } elseif ( $namespace == 'sensei-single-course-header-purchase-button' ) {
	// 	$sidebar_width       = skilled_get_option( 'sidebar-width', 3 );
	// 	$mapped_grid_classes = skilled_grid_class_map();
	// 	$class               = 'wh-sidebar ' . $mapped_grid_classes[ $sidebar_width - 1 ][0] . ' ' . $padding_class;
	} else {
		$class = $namespace;
	}

	return apply_filters( 'skilled_filter_class', $class, $namespace );
}
