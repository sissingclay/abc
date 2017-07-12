<?php function is_blog () {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}
//$post_class = get_post_class( array( 'three fourths' ) );
//var_dump( $post_class );
?>
 
<?php while ( have_posts() ) : the_post(); ?>
        <?php // if(is_blog()){?>
        <!--<div <?php post_class($post_class); ?>>-->
        <?php // }else{?>
        <div <?php post_class(); ?>>    
        <?php // }?>
		<?php get_template_part( 'templates/entry-meta' ); ?>
		<div class="thumbnail">
			<?php skilled_get_thumbnail( 'wh-featured-image' ); ?>
		</div>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<div>
			<?php wp_link_pages( array(
				'before' => '<nav class="page-nav"><p>' . __( 'Pages:', 'skilled' ),
				'after'  => '</p></nav>'
			) ); ?>
		</div>
		<?php if ( skilled_get_option( 'archive-single-use-share-this', false ) ): ?>
			<!-- http://simplesharingbuttons.com/ -->
			<ul class="share-buttons">
				<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(site_url()); ?>&t=" target="_blank" title="Share on Facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><i class="fa fa-facebook"></i></a></li>
				<li><a href="https://twitter.com/intent/tweet?source=<?php echo urlencode(site_url()); ?>&text=:%20<?php echo urlencode(site_url()); ?>" target="_blank" title="Tweet" onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20' + encodeURIComponent(document.URL)); return false;"><i class="fa fa-twitter"></i></a></li>
				<li><a href="https://plus.google.com/share?url=<?php echo urlencode(site_url()); ?>" target="_blank" title="Share on Google+" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(document.URL)); return false;"><i class="fa fa-google-plus"></i></a></li>
				<li><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(site_url()); ?>&description=" target="_blank" title="Pin it" onclick="window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(document.URL) + '&description=' +  encodeURIComponent(document.title)); return false;"><i class="fa fa-pinterest"></i></a></li>
				<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(site_url()); ?>&title=&summary=&source=<?php echo urlencode(site_url()); ?>" target="_blank" title="Share on LinkedIn" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><i class="fa fa-linkedin"></i></a></li>
			</ul>
		<?php endif; ?>
		<?php comments_template( '/templates/comments.php' ); ?>
	</div>
        <?php // if(is_blog()){?>
<!--        <div class="one fourths">
            <?php // dynamic_sidebar( 'blog-sidebar' ); ?>
        </div>-->
        <?php // }?>
<?php endwhile; ?>
