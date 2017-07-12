<form action="<?php echo site_url( '/' ); ?>" method="get" id="searchform" class="course-searchfrom-small">
	<input type="text" value="<?php if ( skilled_is_search_courses() ) { echo get_search_query(); } ?>" name="s" placeholder="<?php esc_html_e( 'Search Courses', 'skilled' ); ?>"/>
	<input type="hidden" name="search-type" value="courses"/>
	<button type="submit" class="wh-button"><?php esc_html_e( 'Search', 'skilled' ); ?></button>
</form>
