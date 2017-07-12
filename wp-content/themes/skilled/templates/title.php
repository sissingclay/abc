<?php $enable_breadcrumbs = skilled_get_option( 'page-title-breadcrumbs-enable', true ); ?>
<?php $breadcrumbs_position = skilled_get_option( 'page-title-breadcrumbs-position', 'bellow_title' ); ?>
<?php if (!is_single()){ ?>
<div class="<?php echo skilled_class( 'page-title-row' ); ?>">
	<div class="<?php echo skilled_class( 'container' ); ?>">
		<div class="<?php echo skilled_class( 'page-title-grid-wrapper' ); ?>">
			<?php if ( $enable_breadcrumbs && $breadcrumbs_position == 'above_title' ): ?>
				<?php get_template_part( 'templates/breadcrumbs' ); ?>
			<?php endif ?>
			<h1 class="<?php echo skilled_class( 'page-title' ); ?>"><?php echo skilled_title(); ?></h1>
			<?php if ( $enable_breadcrumbs && $breadcrumbs_position == 'bellow_title' ): ?>
				<?php get_template_part( 'templates/breadcrumbs' ); ?>
			<?php endif ?>
		</div>
	</div>
</div>
<?php }?>