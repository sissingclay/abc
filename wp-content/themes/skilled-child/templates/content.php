<?php global $post_id; ?>
<?php $post_class = skilled_class( 'post-item' ); ?>
 <?php $type = get_post_type($post_id);
        if($type != "product"){
 ?>
<div <?php echo post_class( $post_class ) ?>>
       
  
       
	<div class="one whole">
	<div class="thumbnail">
			<?php skilled_get_thumbnail( 'wh-featured-image' ); ?>
		</div>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      
	</div>
	<div class="item one whole">
		
		<div class="entry-summary"><?php echo strip_shortcodes( get_the_excerpt() ); ?></div>
		<a style="background-color: #a444ac; border: 1px solid #a444ac;" class="wh-button read-more" href="<?php the_permalink(); ?>"><?php _e( 'read more', 'skilled' ); ?></a>
	</div>
</div>
        <?php }?>