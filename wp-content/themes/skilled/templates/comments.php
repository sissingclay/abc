<?php
if ( post_password_required() ) {
	return;
}

if ( have_comments() ) : ?>
	<section id="comments">
		<h3><?php printf( _n( 'One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'skilled' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?></h3>
		<hr class="wh-separator" />
		<ul class="comment-list">
			<?php wp_list_comments( array( 'walker' => new Wheels_Walker_Comment ) ); ?>
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav>
				<ul class="pager">
					<?php if ( get_previous_comments_link() ) : ?>
						<li class="previous"><?php previous_comments_link( esc_html__( '&larr; Older comments', 'skilled' ) ); ?></li>
					<?php endif; ?>
					<?php if ( get_next_comments_link() ) : ?>
						<li class="next"><?php next_comments_link( esc_html__( 'Newer comments &rarr;', 'skilled' ) ); ?></li>
					<?php endif; ?>
				</ul>
			</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<div class="alert alert-warning">
				<?php _e( 'Comments are closed.', 'skilled' ); ?>
			</div>
		<?php endif; ?>
	</section><!-- /#comments -->
<?php endif; ?>

<?php if ( ! have_comments() && ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<section id="comments">
		<div class="alert alert-warning">
			<?php _e( 'Comments are closed.', 'skilled' ); ?>
		</div>
	</section><!-- /#comments -->
<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<section id="respond">
		<h3><?php comment_form_title( esc_html__( 'Leave a Reply', 'skilled' ), esc_html__( 'Leave a Reply to %s', 'skilled' ) ); ?></h3>
		<hr class="wh-separator">
		<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
		<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) : ?>
			<p><?php printf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'skilled' ), wp_login_url( get_permalink() ) ); ?></p>
		<?php else : ?>
			<form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentform">
				<?php if ( is_user_logged_in() ) : ?>
					<p>
						<?php printf( __( 'Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'skilled' ), get_option( 'siteurl' ), $user_identity ); ?>
						<a href="<?php echo wp_logout_url( get_permalink() ); ?>"
						   title="<?php esc_html_e( 'Log out of this account', 'skilled' ); ?>"><?php esc_html_e( 'Log out &raquo;', 'skilled' ); ?></a>
					</p>
				<?php else : ?>
					<div class="form-group">
						<label for="author"><?php esc_html_e( 'Name', 'skilled' );
							if ( $req ) {
								esc_html_e( ' (required)', 'skilled' );
							} ?></label>
						<input type="text" class="form-control" name="author" id="author"
						       value="<?php echo esc_attr( $comment_author ); ?>" size="22" <?php if ( $req ) {
							echo 'aria-required="true"';
						} ?>>
					</div>
					<div class="form-group">
						<label for="email"><?php esc_html_e( 'Email (will not be published)', 'skilled' );
							if ( $req ) {
								esc_html_e( ' (required)', 'skilled' );
							} ?></label>
						<input type="email" class="form-control" name="email" id="email"
						       value="<?php echo esc_attr( $comment_author_email ); ?>" size="22" <?php if ( $req ) {
							echo 'aria-required="true"';
						} ?>>
					</div>
					<div class="form-group">
						<label for="url"><?php esc_html_e( 'Website', 'skilled' ); ?></label>
						<input type="url" class="form-control" name="url" id="url"
						       value="<?php echo esc_attr( $comment_author_url ); ?>" size="22">
					</div>
				<?php endif; ?>
				<div class="form-group">
					<label for="comment"><?php esc_html_e( 'Comment', 'skilled' ); ?></label>
					<textarea name="comment" id="comment" class="form-control" rows="5" aria-required="true"></textarea>
				</div>
				<p><input name="submit" class="btn btn-primary" type="submit" id="submit"
				          value="<?php esc_html_e( 'Submit Comment', 'skilled' ); ?>"></p>
				<?php comment_id_fields(); ?>
				<?php do_action( 'comment_form', $post->ID ); ?>
			</form>
		<?php endif; ?>
	</section><!-- /#respond -->
<?php endif; ?>
