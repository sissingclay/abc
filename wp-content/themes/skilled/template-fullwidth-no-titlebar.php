<?php
/**
 * @package WordPress
 * @subpackage Wheels
 *
 * Template Name: Full Width No Title Bar
 */
get_header();
?>
<?php ?>
	<div class="<?php echo skilled_class( 'main-wrapper' ) ?>">
		<div class="<?php echo skilled_class( 'container' ) ?>">
			<div class="<?php echo skilled_class( 'content-fullwidth' ) ?>">
				<?php get_template_part( 'templates/content-page' ); ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>