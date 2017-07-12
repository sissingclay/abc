<div class="cbp-row">
	<div class="one whole">
		<div class="course-lesson-count">			
			<i class="lnr lnr-book"></i>
        	<?php echo $woothemes_sensei->post_types->course->course_lesson_count( $post_id ) . '&nbsp;' . apply_filters( 'sensei_lessons_text', __( 'Lessons', 'woothemes-sensei' ) ); ?>
		</div>
        <div class="course-lesson-count author">
        <i class="lnr lnr-users"></i>
        	<?php echo get_the_author(); ?>
        </div>
	</div>
</div>