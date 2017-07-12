<?php get_template_part( 'templates/head' ); ?>
<?php $rtl = skilled_get_option( 'is-rtl', false ); ?>
<body <?php body_class(); ?><?php if ($rtl): ?> dir="<?php echo esc_attr('rtl'); ?>"<?php endif; ?>>
	<div class="wh-main-wrap">
		<?php get_template_part( 'templates/header' ); ?>
