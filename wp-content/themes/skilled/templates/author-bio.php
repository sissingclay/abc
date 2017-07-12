<div class="author-info">
	<div class="author-avatar">
	<?php if ( function_exists( 'get_cupp_meta' ) ): ?>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>">
			<img src="<?php echo get_cupp_meta( get_the_author_meta( 'ID' ), 'thumbnail' ); ?>" alt=""/>
		</a>
	<?php else: ?>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'skilled_author_bio_avatar_size', 120 ) ); ?>
		</a>
	<?php endif; ?>
	</div>
	<div class="author-description">
		<h2 class="author-title"><?php printf( esc_html__( 'About %s', 'skilled' ), get_the_author() ); ?></h2>
		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( esc_html__( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'skilled' ), get_the_author() ); ?>
			</a>
		</p>
	</div>
</div>