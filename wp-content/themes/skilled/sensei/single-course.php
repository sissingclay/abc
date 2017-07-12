<?php
/**
 * The template for displaying product content in the single-course.php template
 *
 * Override this template by copying it to yourtheme/sensei/content-single-course.php
 *
 * @author 		WooThemes
 * @package 	Sensei/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php  get_sensei_header();  ?>
    	<article <?php post_class( array( 'course', 'post' ) ); ?>>
            <section class="course-content">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
    			<?php the_content(); ?>
			<?php endwhile; ?>
            </section>
			<div class="modules-and-lessons">
            	<?php do_action( 'sensei_single_course_content_inside_after', get_the_ID() ); ?>
			</div>
        </article>
        <?php do_action('sensei_pagination'); ?>
		<?php get_template_part('sensei/custom/similar-courses'); ?>
        <script>
        jQuery(function ($) {
            $('.sensei-single-course-header-purchase-button .single_add_to_cart_button').each(function () {
                $(this).html('<?php esc_html_e('Take this course', 'skilled'); ?>');
            });
            $('.sensei-single-course-header-purchase-button input.course-start').each(function () {
                $(this).val('<?php esc_html_e('Take this course', 'skilled'); ?>');
            });
            $('.sensei-single-course-header-purchase-button .register a').each(function () {
                $(this).html('<?php esc_html_e('Take this course', 'skilled'); ?>');
            });
        });
        </script>
<?php get_sensei_footer(); ?>
