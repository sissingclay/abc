<?php
/**
 */
$is_boxed = skilled_get_option('single-post-is-boxed', false);
if ($is_boxed) {
    get_header('boxed');
} else {
    get_header();
}
?>
<?php get_template_part('templates/title'); ?>
<div class="<?php echo skilled_class('main-wrapper') ?>">
	<div class="<?php echo skilled_class('container'); ?>">
		<div class="<?php echo skilled_class('content-fullwidth') ?>">
			<?php get_template_part('templates/content-single-teacher'); ?>
		</div>
	</div>
</div>
<?php
if ($is_boxed) {
    get_footer('boxed');
} else {
    get_footer();
}
?>
