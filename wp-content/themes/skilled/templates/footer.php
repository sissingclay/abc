<div class="<?php echo skilled_class( 'footer' ); ?>">
	<?php if ( is_active_sidebar( 'wheels-sidebar-footer' ) ) : ?>
		<div class="<?php echo skilled_class( 'footer-widgets-wrap' ); ?>">
			<div class="<?php echo skilled_class( 'container' ); ?>">
				<?php dynamic_sidebar( 'wheels-sidebar-footer' ); ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if ( skilled_get_option( 'footer-bottom-separator-use', false ) ) : ?>
		<div class="<?php echo skilled_class( 'container' ); ?>">
			<div class="<?php echo skilled_class( 'footer-separator-container' ); ?>">
				<div class="<?php echo skilled_class( 'footer-separator' ); ?>"></div>
			</div>
		</div>
	<?php endif; ?>
	<div class="<?php echo skilled_class( 'footer-bottom' ); ?>">
		<div class="<?php echo skilled_class( 'container' ); ?>">
			<?php
			$footer_layout = skilled_get_option( 'footer-layout', array() );
			$sections      = isset( $footer_layout['enabled'] ) ? $footer_layout['enabled'] : false;

			if ( $sections ) {
				foreach ( $sections as $key => $value ) {
					switch ( $key ) {
						case 'menu':
							get_template_part( 'templates/footer-menu' );
							break;
						case 'text':
							get_template_part( 'templates/footer-text' );
							break;
						case 'social_links':
							get_template_part( 'templates/footer-social-links' );
							break;
					}
				}
			}
			?>
		</div>
	</div>
</div>

