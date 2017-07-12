<?php


global $post, $woothemes_sensei;

$user_info             = get_userdata( absint( $post->post_author ) );
$author_link           = get_author_posts_url( absint( $post->post_author ) );
$author_display_name   = $user_info->display_name;
$author_id             = $post->post_author;
$category_output       = get_the_term_list( $post->ID, 'course-category', '', ', ', '' );
$preview_lesson_count  = intval( $woothemes_sensei->post_types->course->course_lesson_preview_count( $post->ID ) );


$categories = get_the_terms( $post, 'course-category' );
$cat_ids    = array();
foreach ( $categories as $category ) {
	$cat_ids[] = $category->term_id;
}

$search_args = array(
	'post_type'      => 'course',
	'posts_per_page' => 3,
	'offset'         => 0,
	'orderby'        => 'rand',
	'post__not_in'   => array( $post->ID ),
	'tax_query'      =>
		array(
			'taxonomy' => 'course-category',
			'field'    => 'ID',
			'terms'    => $cat_ids,
		),

);
$results     = new WP_Query( $search_args );
$image_size  = 'wh-medium';
?>

<?php if ( $results->have_posts() ): ?>
	<div class="vc_row linp-featured-courses-carousel">
		<div class="<?php echo skilled_class( 'container' ) ?>">
			<div class="<?php echo skilled_class( 'strecher' ) ?>">
				<?php while ( $results->have_posts() ) : $results->the_post(); ?>
					<div class="one third wh-padding owl-item">
						<div>
							<?php $img = ''; ?>
	                        <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
	                            <?php $img = get_the_post_thumbnail( $post->ID, $image_size, array( 'class' => 'featured-course-thumb') ); ?>
	                        <?php endif; ?>
	                        <?php if ( '' != $img ) : ?>
	                            <div class="img-container">
	                                <a href="<?php echo get_permalink( $post->ID ) ?>" title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ); ?>"><?php echo '' . $img; ?></a>
	                            </div>
	                        <?php endif; ?>
							<div class="item-inner-wrap">
								<div class="price">
									<?php $course_price = skilled_sensei_simple_course_price( $post->ID ); ?>
									<?php if ( $course_price ): ?>
										<?php echo '' . $course_price; ?>
									<?php else: ?>
										<span class="course-price free-course"><span class="amount"><?php esc_html_e( 'Free', 'skilled' ); ?></span></span>
									<?php endif; ?>
								</div>
								<h3 class="course-title">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h3>
								<?php if ( function_exists( 'skilled_course_print_stars') ) {
									// product id
									$wc_post_id = get_post_meta( intval( $post->ID ), '_course_woocommerce_product', true );
									skilled_course_print_stars($wc_post_id, true);
								} ?>
							</div>
							<div class="cbp-row">
								<div class="one whole">
									<div class="course-lesson-count">
										<i class="lnr lnr-book"></i>
							        	<?php echo (int) $woothemes_sensei->post_types->course->course_lesson_count( $post->ID ) . '&nbsp;' . apply_filters( 'sensei_lessons_text', __( 'Lessons', 'skilled' ) ); ?>
									</div>
							        <div class="course-lesson-count author">
							        <i class="lnr lnr-users"></i>
							        	<?php echo get_the_author(); ?>
							        </div>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>
