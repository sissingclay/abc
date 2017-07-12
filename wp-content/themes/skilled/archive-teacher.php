<?php
/**
 * @package WordPress
 * @subpackage Wheels
 */
get_header();
?>
<?php get_template_part( 'templates/title' ); ?>
<div class="<?php echo skilled_class( 'main-wrapper' ) ?>">
	<div class="<?php echo skilled_class( 'container' ) ?>">
		<div class="<?php echo skilled_class( 'content' ) ?>">
			<?php if ( have_posts() ): ?>
				<div class="<?php echo skilled_class( 'teachers' ) ?>">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'templates/content', 'teacher' ); ?>
					<?php endwhile; ?>
				</div>
			<?php else: ?>
				<?php get_template_part( 'templates/content', 'none' ); ?>
			<?php endif; ?>
			<div class="<?php echo skilled_class( 'pagination' ) ?>">
				<?php skilled_pagination(); ?>
			</div>
		</div>
		<div class="<?php echo skilled_class( 'sidebar' ) ?>">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
