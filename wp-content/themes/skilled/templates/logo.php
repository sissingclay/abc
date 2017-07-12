<?php
$logo_url = skilled_get_logo_url();
?>
<?php if ( $logo_url ): ?>
	<div class="<?php echo skilled_class( 'logo' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="logo">
		</a>
	</div>
<?php else: ?>
	<div class="<?php echo skilled_class( 'logo' ); ?>">
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</h1>

		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
	</div>
<?php endif; ?>
