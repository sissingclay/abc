<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	Sensei/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $post;
?>
    </div>
        <div class="<?php echo skilled_class( 'sidebar' ) ?>">
			<?php if ( is_single() && get_post_type() == 'course' ) : ?>
				<div class="hide-on-small-tablet">
					<?php get_template_part('sensei/custom/purchase-button'); ?>
				</div>
            <?php endif; ?>
            <?php if ($post && function_exists('rwmb_meta')): ?>
				<div class="<?php echo skilled_class( 'sensei-course-sidebar-text' ); ?>">
                    <?php echo do_shortcode(rwmb_meta( 'wheels_sidebar_text', array(), $post->ID)); ?>
				</div>
            <?php endif; ?>
            <?php get_sidebar('courses'); ?>
        </div>
    </div>
</div>
