<?php
if ( class_exists( 'YITH_WCWL_UI' ) && class_exists( 'WC_Product_Factory' ) ) {
	global $product, $post, $yith_wcwl;
	// if global $product is not set we need to set it so the wishlist plugin can work properly
	if ( ! $product ) {
		$wc_post_id         = absint( get_post_meta( $post->ID, '_course_woocommerce_product', true ) );
		$wc_product_factory = new WC_Product_Factory();
		$product            = $wc_product_factory->get_product( $wc_post_id );
	}
	echo YITH_WCWL_UI::add_to_wishlist_button( $yith_wcwl->get_wishlist_url(), $product->product_type, $yith_wcwl->is_product_in_wishlist( $product->id ) );
}