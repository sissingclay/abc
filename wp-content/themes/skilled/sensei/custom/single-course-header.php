<?php
global $post, $woothemes_sensei;
$author_id              = $post->post_author;
$teacher_id             = get_post_meta( $post->ID, 'sensei-teacher', true );
$author_id              = $teacher_id ? $teacher_id : $author_id;
$show_participant_count = skilled_get_option( 'sensei-single-course-show-participant-count', true );
?>
<div class="<?php echo skilled_class( 'sensei-single-course-header' ) ?>">
	<div class="<?php echo skilled_class( 'container' ) ?>">
		<div class="<?php echo skilled_class( 'sensei-single-course-header-title-wrap' ) ?>">
			<h1><?php echo get_the_title( $post->ID ); ?></h1>
			<hr/>
			<?php if ( function_exists( 'skilled_course_print_stars' ) ) {
				// product id
				$wc_post_id = get_post_meta( intval( $post->ID ), '_course_woocommerce_product', true );
				skilled_course_print_stars( $wc_post_id, true );
			} ?>

			<div class="course-excerpt">
				<?php echo '' . $post->post_excerpt; ?>
			</div>

		</div>

	</div>
</div>
