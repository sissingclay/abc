<?php
/**
 * sensei_course_meta hook
 *
 * @hooked sensei_course_meta - 10 (outputs the main course meta information)
 */
?>

<div class="<?php echo skilled_class( 'sensei-single-course-header-purchase-button' ) ?>">
	<?php
	/**
	 * Hook inside the single course post above the content
	 *
	 * @since 1.9.0
	 *
	 * @param integer $course_id
	 *
	 * @hooked Sensei()->frontend->sensei_course_start     -  10
	 * @hooked Sensei_Course::the_title                    -  10
	 * @hooked Sensei()->course->course_image              -  20
	 * @hooked Sensei_WC::course_in_cart_message           -  20
	 * @hooked Sensei_Course::the_course_enrolment_actions -  30
	 * @hooked Sensei()->message->send_message_link        -  35
	 * @hooked Sensei_Course::the_course_video             -  40
	 */
	 do_action( 'sensei_single_course_content_inside_before', get_the_ID() );
	?>
	<?php get_template_part( 'sensei/custom/wishlist-button' ); ?>
</div>
