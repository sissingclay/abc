<?php
$logo     = skilled_get_option( 'logo-sticky', array() );
$logo_url = isset( $logo['url'] ) && $logo['url'] ? $logo['url'] : '';

if ( ! $logo_url ) {
	$logo     = skilled_get_option( 'logo', array() );
	$logo_url = isset( $logo['url'] ) && $logo['url'] ? $logo['url'] : '';
}
?>
<?php if ( $logo_url ): ?>
	<div class="<?php echo skilled_class( 'logo-sticky' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="logo">
		</a>
	</div>
<?php else: ?>
	<div class="<?php echo skilled_class( 'logo-sticky' ); ?>">
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</h1>

		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
	</div>
<?php endif; ?>
