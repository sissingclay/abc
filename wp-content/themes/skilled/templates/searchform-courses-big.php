<?php
if ( ! function_exists( 'Sensei' ) ) {
	return;
}

$search_page      = skilled_get_option('sensei-course-search-page', false);
$search_page_link = $search_page ? get_permalink( $search_page ) : site_url( '/' );

$args = array(
	'taxonomy'        => 'course-category',
	'name'            => 'course-category',
	'show_option_all' => esc_html__( 'Category', 'skilled' ),
	'show_count'      => true,
	'hierarchical'    => true
);

if ( skilled_get_option('is-rtl', false) ) {
	$args['show_count'] = false;
}

if ( isset( $_GET['course-category'] ) ) {
	$args['selected'] = $_GET['course-category'];
}
?>
<form action="<?php echo esc_url( $search_page_link ); ?>" method="get" id="searchform" class="search-form-wrap search-for-courses">
	<input type="hidden" name="search-type" value="courses"/>
	<ul>
		<li>
			<?php wp_dropdown_categories( $args ); ?>
		</li>
		<li>
			<select name="status">
				<option value=""><?php _e( 'Course Status', 'skilled' ); ?></option>
				<option
					value="free" <?php echo isset( $_GET['status'] ) && $_GET['status'] == 'free' ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Free', 'skilled' ); ?></option>
				<option
					value="paid" <?php echo isset( $_GET['status'] ) && $_GET['status'] == 'paid' ? 'selected="selected"' : ''; ?>><?php esc_html_e( 'Paid', 'skilled' ); ?></option>
			</select>
		</li>
		<li>
			<input type="text" value="<?php if ( skilled_is_search_courses() ) {
				echo get_search_query();
			} ?>" name="s" placeholder="<?php esc_html_e( 'Type Keyword', 'skilled' ); ?>"/>
		</li>
		<li class="search-courses-button-item">
			<button type="submit" class="wh-button"><?php esc_html_e( 'Search', 'skilled' ); ?></button>
		</li>
	</ul>
</form>
