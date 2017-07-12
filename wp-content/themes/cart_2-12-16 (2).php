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
 $handle=new WC_Product_Variable(15538);
$attributes = $handle->get_variation_attributes();
$attribute_keys = array_keys( $attributes );


do_action( 'woocommerce_before_add_to_cart_form' ); 
$_pf = new WC_Product_Factory();  
$product = new WC_product(15538);
$available_variations = $handle->get_available_variations();
//print_r($handle->get_available_variations());
//foreach($available_variations as $available_variation){
//   // echo '===='.print_r($available_variation['attributes']);
//    $arr = $available_variation['attributes'];
//   // echo $arr['attribute_pa_course_level'];
//     if($arr['attribute_pa_course_level']=='a4' &&  $arr['attribute_pa_week']=='4-week'){
//        echo 'id===='.$available_variation['variation_id'];
//    }
//    
//}
?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint(15538); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
						<td class="value">
							<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $handle->get_variation_default_attribute( $attribute_name );
								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $handle, 'selected' => $selected ) );
								echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce' ) . '</a>' ) : '';
							?>
						</td>
					</tr>
				<?php endforeach;?>
                                        </tbody>
		</table>
                <div class="woocommerce-variation-add-to-cart variations_button">
                        <?php if ( ! $handle->is_sold_individually() ) : ?>
                                <?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
                        <?php endif; ?>
                        <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $handle->single_add_to_cart_text() ); ?></button>
                        <input type="text" name="add-to-cart" value="<?php echo absint( $handle->id ); ?>" />
                        <input type="text" name="product_id" value="<?php echo absint( $handle->id ); ?>" />
                        <input type="text" name="variation_id" class="variation_id" value="0" />
                </div>


		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				//do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
?>
                                        

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
      
    
        echo "<select id='productname' onchange='getproductdetails(this)'><option>Select Course</option>";
        while ( $products->have_posts() ) {
            $products->the_post();
            ?>
                <option value="<?php the_id(); ?>">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>      
                </option>
         <?php
        }
        echo "</select>";

    }
    echo "<div id='feedback'>";
    echo "<select disabled><option>Select Course Level</option></select>";
    echo "</div>";
    // imp 
//       $handle=new WC_Product_Variable(15538);
//      //  $attributes = $handle->list_attributes();
//     
//        $attributes = $handle->get_variation_attributes();
//        echo "<pre>";
//        print_r($attributes);
//        foreach ($attributes as $attribute){
//            echo "<pre>";
//            print_r($attribute);
//        }
    //imp
    echo "<div id='courseweek'>";
    echo "<select id='' disabled><option>Select Week</option></select>";
    echo "</div>";    
//     $course_levels = get_the_terms( 15538, 'pa_course_level');
//  // print_r($course_levels);
//       echo "<select>";
//      foreach ( $course_levels as $course_level ) {
//            echo "<option value=".$course_level->term_id.">".$course_level->name."</option>";
//      }
//      echo "</select>";
        
//foreach($attributes as $attr=>$attr_deets){
//
//    $attribute_label = wc_attribute_label($attr);
//
//    if ( isset( $attributes[ $attr ] ) || isset( $attributes[ 'pa_' . $attr ] ) ) {
//
//        $attribute = isset( $attributes[ $attr ] ) ? $attributes[ $attr ] : $attributes[ 'pa_' . $attr ];
//
//        if ( $attribute['is_taxonomy'] ) {
//
//            $formatted_attributes[$attribute_label] = implode( ', ', wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) ) );
//
//        } else {
//
//            $formatted_attributes[$attribute_label] = $attribute['value'];
//        }
//
//    }
//}

//print_r($formatted_attributes);
           
//       // print_r($att);die;
//        $variations1=$handle->get_children();
//       echo "<pre>";
//       print_r($variations1);
//        foreach ($variations1 as $value) {       
//        $single_variation=new WC_Product_Variation($value);   
//     
//        $i = 0; 
//         foreach($single_variation->get_variation_attributes() as $variationvalue){
//             if($i==0){
//             echo '11'.$variationvalue;
//             echo "<br>";
//             }
//             else{
//                 echo "====".$variationvalue;
//                 echo "<br>";
//             }
//             $i++;

           //  echo $variationvalue->attribute_pa_week;
           //   echo '<option>'.$variationvalue->attribute_pa_week['attribute_pa_course_level'].'</option>';                              
       //  }
       // }
}
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

//    function addToCart(p_id) {
//       // variation_id=88&attribute_pa_colour=blue&attribute_pa_size=m
//      //  alert(p_id);
//      var variation_id = 15555;
//      var attribute_pa_course_level='A1';
//      var attribute_pa_week = '1 week';
//     jQuery.get('http://wordpress-9522-31986-161247.cloudwaysapps.com/cart/?post_type=product&add-to-cart=' + p_id +'&variation_id='+variation_id +'&attribute_pa_course_level='+attribute_pa_course_level+'&attribute_pa_week='+attribute_pa_week, function() {
//     // success
//    jQuery(".show_success").show();
//     });
//
//    }
    function addToCart(p_id) {
    //    alert(p_id);
        //  = jQuery( "#course_level" ).attr("name");
         var course_level = jQuery( "#course_level option:selected" ).text();
         var courseweek = jQuery( "#courseweek option:selected" ).text();
         
        jQuery.ajax({
        url: " http://wordpress-9522-31986-161247.cloudwaysapps.com/public_html/wp-content/themes/skilled-child/functions.php",
        type: "POST",
        data: {
            'course_level': course_level
        },
        success:function(result){
            alert(result);
        //    jQuery("#feedback").html(result);
         //   document.getElementById("feedback").disabled = false;
        }
        
     //    alert(courseweek);
  
       // variation_id=88&attribute_pa_colour=blue&attribute_pa_size=m
     //   var p_id = 15538;
      //  var variation_id = 15555;
    //  var attribute_pa_course_level='a1';
    //  var attribute_pa_week = '1-week';
    //  jQuery.get('http://wordpress-9522-31986-161247.cloudwaysapps.com/cart/?post_type=product&add-to-cart=' + p_id +'&variation_id='+variation_id +'&attribute_pa_course_level='+course_level+'&attribute_pa_week='+courseweek, function() {
       //   success
      //     alert("sucessfully");
      
//      var variation_id = 15555;
//      var attribute_pa_course_level='A1';
//      var attribute_pa_week = '1 week';
//     jQuery.get('http://wordpress-9522-31986-161247.cloudwaysapps.com/cart/?post_type=product&add-to-cart=' + p_id +'&variation_id='+variation_id +'&attribute_pa_course_level='+attribute_pa_course_level+'&attribute_pa_week='+attribute_pa_week, function() {
//     // success
//    jQuery(".show_success").show();
     });

    }
    
    function getproductdetails(s){
      var product_id = s[s.selectedIndex].value;      
    //  alert(s);
       jQuery.ajax({
        url: " http://wordpress-9522-31986-161247.cloudwaysapps.com/public_html/wp-content/themes/skilled-child/functions.php",
        type: "POST",
        data: {
            'productid': product_id
        },
        success:function(result){
            jQuery("#feedback").html(result);
         //   document.getElementById("feedback").disabled = false;
        }
       });
    }
    function getcourseweek(id){
       jQuery.ajax({
        url: " http://wordpress-9522-31986-161247.cloudwaysapps.com/public_html/wp-content/themes/skilled-child/functions.php",
        type: "POST",
        data: {
            'week_id': id
        },
        success:function(result){
          //  alert(result);
            jQuery("#courseweek").html(result);
         //   document.getElementById("feedback").disabled = false;
        }
       });
    }
       </script>