<div class="cbp-row">
	<div class="one whole">
		<?php $course = LP_Course::get_course( $post_id );?>
		<?php if ( $count = $course->count_users_enrolled() ) : ?>
			<div class="course-users-enrolled">
				<i class="lnr lnr-users"></i>
				<span><?php echo '' . $count; ?></span>
			</div>
		<?php endif; ?>
		<?php $course_duration = get_post_meta( $post_id, '_lp_duration', true ); ?>
		<?php if ( ! empty( $course_duration ) ) : ?>
			<div class="course-duration">
				<i class="lnr lnr-clock"></i>
				<span
					class="course-category"><?php echo esc_html( $course_duration ); ?> <?php esc_html_e( 'weeks', 'skilled' ) ?></span>
			</div>
		<?php endif; ?>
        <div class="course-lesson-count author">
        <i class="lnr lnr-user"></i>
        	<?php echo get_the_author(); ?>
        </div>
	</div>
</div>