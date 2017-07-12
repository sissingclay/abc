<div class="<?php echo skilled_class( 'footer-menu-wrap' ); ?>">
	<?php
	$menu_options = array(
		'theme_location'  => 'secondary_navigation',
		'menu_class'      => skilled_class( 'footer-menu' ),
		'container_class' => skilled_class( 'footer-menu-container' ),
		'depth'           => 1
	);
	?>
	<?php wp_nav_menu( $menu_options ); ?>
</div>