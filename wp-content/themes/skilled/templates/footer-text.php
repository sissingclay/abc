<?php $footer_text = skilled_get_option( 'footer-text', '' ); ?>
<?php if ( $footer_text ): ?>
	<div class="<?php echo skilled_class( 'footer-text' ); ?>">
		<?php echo do_shortcode( $footer_text ); ?>
	</div>
<?php endif; ?>
