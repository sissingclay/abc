<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>


<?php 
    
$args = array(
    'number'     => $number,
    'orderby'    => 'title',
    'order'      => 'ASC',
    'hide_empty' => $hide_empty,
    'include'    => $ids
);
$product_categories = get_terms( 'product_cat', $args );
$count = count($product_categories);
if ( $count > 0 ){
    foreach ( $product_categories as $product_category ) {
        echo '<h4><a href="' . get_term_link( $product_category ) . '">' . $product_category->name . '</a></h4>';
        $args = array(
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    // 'terms' => 'white-wines'
                    'terms' => $product_category->slug
                )
            ),
            'post_type' => 'product',
            'orderby' => 'title,'
        );
        $products = new WP_Query( $args );
      
//        echo "<ul>";
        echo "<select id='productname'>";
        while ( $products->have_posts() ) {
            
            $products->the_post();
            ?>
<!--                <li>-->
                <option>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>      
                </option>
<!--                </li>-->
     <?php

//        echo "</ul>";

//                $productid = get_the_ID();
//                $handle=new WC_Product_Variable($productid);
//                        $variations1=$handle->get_children();
//                       echo "<select>";
//                        foreach ($variations1 as $value) {       
//                        $single_variation=new WC_Product_Variation($value);
//                           foreach($single_variation->get_variation_attributes() as $variationvalue){
//                               echo $variationvalue;
//                               echo "=========";
//                        }    
//                            echo '<option  value="'.$value.'">'.implode(" / ", $single_variation->get_variation_attributes()).'</option>';
////                                   get_woocommerce_currency_symbol().$single_variation->price.
//                          
//                           //   print_r($single_variation->get_variation_attributes());       
//                              
//                }
//                  echo "</select>";
                
            
        }
          echo "</select>";

    }
    
        
        $args = array(
	'post_type'     => 'product_variation',
	'post_status'   => array( 'private', 'publish' ),
	'numberposts'   => -1,
	'orderby'       => 'menu_order',
	'order'         => 'asc',
	'post_parent'   => 15538 // get parent post-ID
);
$variations = get_posts( $args ); 


 $handle=new WC_Product_Variable(15538);
                        $variations1=$handle->get_children();
                    //   echo "<select>";
                        //  echo "<select>";
                        foreach ($variations1 as $value) {       
                        $single_variation=new WC_Product_Variation($value);
                   //     print_r($single_variation->get_variation_attributes());
                      
                        foreach($single_variation->get_variation_attributes() as $variationvalue){
                          //  echo $variationvalue->attribute_pa_week;
                           //    echo '<option>'.$variationvalue->attribute_pa_week['attribute_pa_course_level'].'</option>';                              
                        }
                       
                        }
                      //   echo "</select>";
                      //  print_r($variations);
//foreach ( $variations as $variation ) {
//	
//    
//	// get variation ID
//	echo '========'.$variation_ID = $variation->ID;
// 
//	// get variations meta
//	$product_variation = new WC_Product_Variation( $variation_ID );
// 
//      //  echo "<pre>";
//      //  print_r($product_variation);die;
//        
//	// get variation featured image
//	$variation_image = $product_variation->get_image();
// 
//	// get variation price
//	$variation_price = $product_variation->get_price_html();
//        
//        
//	// to get variation meta, simply use get_post_meta() WP functions and you're done :)
//	// ... do your thing here
// 
//}
    
             
}?> 
  
<?php do_action( 'woocommerce_single_product_summary1' );
   ?>
<!--   <a id="buy" class="single_add_to_cart_button shop-skin-btn shop-flat-btn alt" href="http://wordpress-9522-31986-161247.cloudwaysapps.com/cart/?post_type=product&add-to-cart=' + p_id +'&variation_id='+variation_id'&attribute_pa_course_level='+attribute_pa_course_level'+attribute_pa_week='+attribute_pa_week">ADD MY PRODUCT</a>
 -->


<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>



<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>


<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table shop_table_responsive cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-remove">
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</td>

					<td class="product-thumbnail">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
							}
						?>
					</td>

					<td class="product-name" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
						<?php
							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
							}

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
					</td>

					<td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>

					<td class="product-subtotal" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

   
    
<?php do_action( 'woocommerce_after_cart' ); ?>
   <script>
        jQuery('#buy').click(function(e) {
     
     e.preventDefault(); 
    var myStringArray = 15538;
  //  var arrayLength = myStringArray.length;
  //  alert(arrayLength);
 //   for (var i = 0; i < arrayLength; i++) {
    
     addToCart(myStringArray);
 //   }

    return true;

    //window.location.href = "http://seoexpertiser.ca/glassful/cart/";
    });

    function addToCart(p_id) {
       // variation_id=88&attribute_pa_colour=blue&attribute_pa_size=m
      //  alert(p_id);
      var variation_id = 15555;
      var attribute_pa_course_level='A1';
      var attribute_pa_week = '1 week';
     jQuery.get('http://wordpress-9522-31986-161247.cloudwaysapps.com/cart/?post_type=product&add-to-cart=' + p_id +'&variation_id='+variation_id +'&attribute_pa_course_level='+attribute_pa_course_level+'&attribute_pa_week='+attribute_pa_week, function() {
     // success
    jQuery(".show_success").show();
     });

    }
       </script>