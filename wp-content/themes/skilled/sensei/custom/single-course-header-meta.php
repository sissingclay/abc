<?php
global $post, $woothemes_sensei;
$author_id              = $post->post_author;
$teacher_id             = get_post_meta( $post->ID, 'sensei-teacher', true );
$author_id              = $teacher_id ? $teacher_id : $author_id;
$show_participant_count = skilled_get_option( 'sensei-single-course-show-participant-count', true );
?>
<div class="<?php echo skilled_class( 'sensei-single-course-header-meta-wrap' ) ?>">
	<div class="<?php echo skilled_class( 'sensei-single-course-header-author' ) ?>">
		<?php $teacher_thumb = skilled_get_teacher_thumb( $author_id ); ?>
		<?php if ( $teacher_thumb ) : ?>
			<?php echo '' . $teacher_thumb; ?>
		<?php elseif ( function_exists( 'get_cupp_meta' ) ): ?>
			<?php $author_thumb = get_cupp_meta( $author_id, 'thumbnail' ); ?>
			<?php if ( ! empty( $author_thumb ) ): ?>
				<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
					<img src="<?php echo '' . $author_thumb; ?>" alt=""/>
				</a>
			<?php endif; ?>

		<?php else: ?>
			<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
				<?php echo get_avatar( get_the_author_meta( 'user_email', $author_id ), apply_filters( 'skilled_author_bio_avatar_size', 60 ) ); ?>
			</a>
		<?php endif; ?>
		<div class="<?php echo skilled_class( 'sensei-single-course-header-author-name' ) ?>">
			<?php _e( 'by', 'skilled' ); ?> <?php the_author_meta( 'user_nicename', $author_id ); ?>
		</div>
	</div>
	<?php //$category_output = get_the_term_list( $post->ID, 'course-category', '', ', ', '' ); ?>
	<div class="sensei-course-meta">
		<div class="meta-item meta-item-price">
			<?php $course_price = skilled_sensei_simple_course_price( $post->ID ); ?>
			<?php if ( $course_price ): ?>
				<span class="price-label"><?php _e( 'Price', 'skilled' ); ?>:</span>
				<?php echo '' . $course_price; ?>
			<?php else: ?>
				<span class="course-price free-course"><span class="amount"><?php esc_html_e( 'Free', 'skilled' ); ?></span></span>
			<?php endif; ?>
		</div>
		<?php if ( function_exists( 'rwmb_meta' ) && (int) rwmb_meta( 'wheels_course_duration', array(), $post->ID ) ) : ?>
			<?php $course_duration = rwmb_meta( 'wheels_course_duration', array(), $post->ID ); ?>
			<?php if ( ! empty( $course_duration ) ) : ?>
				<div class="meta-item">
					<i class="lnr lnr-clock"></i>
					<span class="course-category"><?php echo esc_html( $course_duration ); ?></span>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="meta-item">
			<i class="lnr lnr-book"></i>
            <span class="course-lesson-count">
                <?php echo (int) $woothemes_sensei->post_types->course->course_lesson_count( $post->ID ) . '&nbsp;' .  __( 'Lessons', 'skilled' ) ; ?>
            </span>
		</div>

		<?php if ( $show_participant_count && class_exists( 'WooThemes_Sensei_Utils' ) ) : ?>
			<?php
			$course_learners = WooThemes_Sensei_Utils::sensei_check_for_activity( apply_filters( 'sensei_learners_course_learners', array( 'post_id' => $post->ID, 'type' => 'sensei_course_status', 'status' => 'any' ) ) );

			$course_learners = intval( $course_learners );
			?>
			<div class="meta-item">
				<i class="lnr lnr-users"></i>
				<span><?php echo '' . $course_learners; ?> <?php esc_html_e( 'Students', 'skilled' ); ?></span>
			</div>
		<?php endif; ?>
	</div>
	<hr/>
</div>
