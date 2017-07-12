<?php
/**
 * @package WordPress
 * @subpackage Wheels
 */
$is_boxed = skilled_get_option( 'single-post-is-boxed', false );
if ( $is_boxed ) {
	get_header( 'boxed' );
} else {
	get_header();
}
?>
<?php get_template_part( 'templates/title' ); ?>
<div class="<?php echo skilled_class( 'main-wrapper' ) ?>">

<div class="vc_row wpb_row vc_row-fluid blog_post_header vc_row-has-fill"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="uvc-heading ult-adjust-bottom-margin abt_heading-blog" style="text-align:center"><div class="uvc-heading-spacer no_spacer" style="top"></div><div class="uvc-sub-heading ult-responsive" .uvc-sub-heading '  style="font-weight:normal;"></p>
<div class="blog-header" style="color: #fff !important; font-family: 'Raleway'; font-size: 40px !important;font-weight: 600;">
BLOG
</div>
<p></div></div></div></div></div></div><div class="vc_row-full-width vc_clearfix"></div><div class="vc_row wpb_row vc_row-fluid breadcrums breadcrums-res-blog breadcrums-res-blog-post vc_row-has-fill"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
	<div class="wpb_text_column wpb_content_element ">
		<div class="wpb_wrapper">
			<p style="text-align: center; color: #fff; font-size: 18px; margin-top: -4px;"><strong>ABC School of English &gt; </strong> Blog</p>

		</div>
	</div>
</div></div></div></div>

	<div class="<?php echo skilled_class( 'container' ); ?>">
		<?php if ( skilled_get_option( 'single-post-sidebar-left', false ) ): ?>
			<div class="<?php echo skilled_class( 'sidebar' ) ?>">
				<?php get_sidebar(); ?>
			</div>




			<div class="<?php echo skilled_class( 'content' ) ?>">
				<?php get_template_part( 'templates/content-single' ); ?>
			</div>
		<?php else: ?>
			<div class="<?php echo skilled_class( 'content' ) ?>">
				<?php get_template_part( 'templates/content-single' ); ?>
			</div>
			<div class="<?php echo skilled_class( 'sidebar' ) ?>">
				<?php get_sidebar(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php
if ( $is_boxed ) {
	get_footer( 'boxed' );
} else {
	get_footer();
}
?>
