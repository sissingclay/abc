<?php if ((int) $show_excerpt): ?>
    <p class="course-excerpt"><?php echo wp_trim_words( $post_item->post_excerpt, $number_of_words ); ?></p>
<?php endif ?>
<?php if (0 < $preview_lesson_count && !$is_user_taking_course) : ?>
    <?php $preview_lessons = sprintf(__('(%d preview lessons)', 'woothemes-sensei'), $preview_lesson_count); ?>
    <p class="sensei-free-lessons"><a href="<?php echo get_permalink($post_id); ?>"><?php _e('Preview this course', 'woothemes-sensei') ?></a> - <?php echo $preview_lessons; ?></p>
<?php endif ?>
