<?php
global $post_id;

$theme_location = 'primary_navigation';
if ( function_exists( 'rwmb_meta' ) && (int) rwmb_meta( 'wheels_use_one_page_menu', array(), $post_id ) ) {
	$one_page_menu_location = rwmb_meta( 'wheels_one_page_menu_location', array(), $post_id );
	if ( ! empty( $one_page_menu_location ) ) {
		$theme_location = $one_page_menu_location;
	}
}

$defaults = array(
	'theme_location'  => $theme_location,
	'menu_class'      => skilled_class( 'main-menu' ),
	'container_class' => skilled_class( 'main-menu-container' ),
	'depth'           => 3
);
?>

<div id="cbp-menu-main">
	<?php wp_nav_menu( $defaults ); ?>
</div>
