<?php while ( have_posts() ) : the_post(); ?>
	<div <?php post_class(); ?>>
		<?php the_content(); ?>
		<?php //comments_template( '/templates/comments.php' ); ?>
	</div>
<?php endwhile; ?>
