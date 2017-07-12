<div class="<?php echo skilled_class( 'top-bar' ); ?>">
	<div class="<?php echo skilled_class( 'container' ); ?>">
		<?php
		$top_bar_layout = skilled_get_option( 'top-bar-layout', array() );
		$sections       = isset( $top_bar_layout['enabled'] ) ? $top_bar_layout['enabled'] : false;

		if ( $sections ) {
			foreach ( $sections as $key => $value ) {
				switch ( $key ) {
					case 'menu':
						get_template_part( 'templates/top-bar-menu' );
						break;
					case 'text':
						get_template_part( 'templates/top-bar-text' );
						break;
					case 'login_button':
						get_template_part( 'templates/top-bar-login-button' );
						break;
				}
			}
		}
		?>
	</div>
</div>