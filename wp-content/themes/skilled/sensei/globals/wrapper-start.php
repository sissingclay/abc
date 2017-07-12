<?php
/**
 * Content wrappers.
 *
 * @author 		WooThemes
 *
 * @version     1.0.0
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
    <div class="<?php echo skilled_class( 'page-title-row' ); ?>">
    	<div class="<?php echo skilled_class( 'container' ); ?>">
    		<div class="<?php echo skilled_class( 'page-title-grid-wrapper' ); ?>">
				<?php get_template_part( 'templates/breadcrumbs' ); ?>
    		</div>
    	</div>
    </div>
	<?php $enable_header = skilled_get_option('sensei-single-course-header-image-show', true); ?>
	<?php if ($enable_header) : ?>
		<div class="course-header-image"></div>
	<?php endif; ?>

	<?php if (is_single() && get_post_type() == 'course') : ?>
		<?php get_template_part('sensei/custom/single-course-header'); ?>

		<div class="wh-course-purchase-button-mobile hide-on-desktop">
			<?php get_template_part('sensei/custom/purchase-button'); ?>
		</div>
	<?php endif; ?>



    <div class="<?php echo skilled_class('main-wrapper'); ?>">
        <div class="<?php echo skilled_class('container'); ?>">
            <div class="<?php echo skilled_class('content'); ?>">

            <?php if (is_single() && get_post_type() == 'course') : ?>
                <?php get_template_part('sensei/custom/single-course-header-meta'); ?>
            <?php endif; ?>
