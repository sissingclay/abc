<?php
/**
 * @package WordPress
 * @subpackage Wheels
 */
get_header();

global $paged, $woothemes_sensei;
if ( empty( $paged ) ) {
	$paged = 1;
}

$per_page = skilled_get_option( 'search-page-items-per-page', 10 );
$offset   = $per_page * ( $paged - 1 );

$search_args = array(
	'post_type'      => 'course',
	'posts_per_page' => $per_page,
	'offset'         => $offset,
);

if ( isset( $_GET['s'] ) && $_GET['s'] ) {
	$search_args['s'] = $_GET['s'];
}


if ( isset( $_GET['course-category'] ) && $_GET['course-category'] ) {
	$search_args['tax_query'] = array(
		array(
			'taxonomy' => 'course-category',
			'field'    => 'ID',
			'terms'    => $_GET['course-category']
		),
	);
}

if ( isset( $_GET['status'] ) ) {

	$meta_key   = null;
	$meta_query = null;
	$compare    = 'IN';

	if ( $_GET['status'] == 'paid' ) {
		$meta_key = '_regular_price';

		$meta_query = array(
			array(
				'key'     => $meta_key,
				'value'   => '0',
				'compare' => '>',
			),
		);

	} elseif ( $_GET['status'] == 'free' ) {
		$meta_key = '_regular_price';

		// look for paid
		$meta_query = array(
			array(
				'key'     => $meta_key,
				'value'   => '0',
				'compare' => '>',
			),
		);

		// but reverse compare
		$compare = 'NOT IN';

	}

	if ( $meta_key && $meta_query ) {

		$args = array(
			'numberposts' => - 1,
			'post_type'   => 'product',
			'fields'      => 'ids',
			'meta_key'    => $meta_key,
			'meta_query'  => $meta_query,
		);
		// get product ids
		$products = new WP_Query( $args );

		// fill product ids
		$product_ids = array();
		if ( $products->have_posts() ) {
			foreach ( $products->posts as $id ) {
				$product_ids[] = $id;
			}
		}

		if ( count( $product_ids ) ) {
			$search_args['meta_key']   = '_course_woocommerce_product';
			$search_args['meta_query'] = array(
				array(
					'key'     => '_course_woocommerce_product',
					'value'   => $product_ids,
					'compare' => $compare,
				),
			);
		} else {
			// if no products are found no courses should be found
			// except if status free
			if ( $_GET['status'] != 'free' ) {
				$search_args = null;
			}
		}
	}
}


//New results loop
$results = new WP_Query( $search_args );

// in order to get all results
unset( $search_args['posts_per_page'] );
unset( $search_args['offset'] );

// just for count
$all_results = new WP_Query( $search_args );

$pages           = ceil( $all_results->post_count / $per_page );
$use_sidebar     = skilled_get_option( 'search-page-use-sidebar', false );
$class_namespace = $use_sidebar ? 'content' : 'content-fullwidth';
?>
<?php get_template_part( 'templates/title' ); ?>
<div class="<?php echo skilled_class( 'main-wrapper' ); ?>">
	<div class="<?php echo skilled_class( 'container' ); ?>">
		<div class="<?php echo skilled_class( $class_namespace ); ?> course-container">

			<?php if ($search_page = skilled_get_option( 'sensei-course-search-page', false ) ): ?>
				<?php $search_page = get_post( $search_page ) ?>
				<div class="search-page-content">
					<?php echo do_shortcode( $search_page->post_content ); ?>
				</div>
			<?php endif ?>
			<div class="search-course-page-search-form-wrap">
				<?php echo get_template_part( 'templates/searchform-courses-big' ); ?>
			</div>
			<?php if ( $results->have_posts() ): ?>
				<?php include_once get_template_directory() . '/sensei/custom/search-loop-items.php'; ?>
			<?php else: ?>
				<?php get_template_part( 'templates/search', 'none' ); ?>
			<?php endif; ?>
			<div class="<?php echo skilled_class( 'pagination' ); ?>">
				<?php skilled_pagination( $pages ); ?>
			</div>
		</div>
		
	</div>
</div>
<?php get_footer(); ?>
