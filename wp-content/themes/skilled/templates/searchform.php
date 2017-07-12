<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url( '/' ); ?>">
	<input type="search" value="<?php if ( is_search() ) { echo get_search_query(); } ?>" name="s" class="search-field" placeholder="<?php esc_html_e( 'Search', 'skilled' ); ?> <?php bloginfo( 'name' ); ?>">
	<label class="hidden"><?php esc_html_e( 'Search for:', 'skilled' ); ?></label>
	<button type="submit" class="search-submit"><?php esc_html_e( 'Search', 'skilled' ); ?></button>
</form>
