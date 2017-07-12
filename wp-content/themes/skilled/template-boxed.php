<?php
/**
 * @package WordPress
 * @subpackage Wheels
 *
 * Template Name: Boxed
 */
get_header( 'boxed' );
?>
<?php get_template_part( 'templates/title' ); ?>
<div class="<?php echo skilled_class( 'main-wrapper' ) ?>">
	<div class="<?php echo skilled_class( 'container' ) ?>">
		<div class="<?php echo skilled_class( 'content' ) ?>">
			<?php get_template_part( 'templates/content-page' ); ?>
		</div>
		<div class="<?php echo skilled_class( 'sidebar' ) ?>">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer( 'boxed' ); ?>
