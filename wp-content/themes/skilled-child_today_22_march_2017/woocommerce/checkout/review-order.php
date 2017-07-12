<?php
// Start the session
session_start();
//error_reporting(E_ALL);
?>
 <?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>
	.checkout-callon {margin-left:25px;margin-top: 40px;color: #454545;font-size: 16px;text-transform: capitalize;font-weight: bold;}
	.product-name {padding: 0 !important;}
	.fee th {padding-left: 25px !important;margin: 0 !important;color: #454545;font-weight: normal !important;font-size: 16px;}
	.order-total{background-color: #d8f2f3;}
	.acc-supplay{padding-left: 20px;color: #454545;font-weight: normal !important;font-size: 16px;}
	.order-total th {
		padding: 25px 45px!important;
		font-size: 22px;
		color: #32a3aa;
		text-transform: uppercase;
		font-weight: 600 !important;
	}
	.order-total .woocommerce-Price-amount.amount {
		font-size: 22px;
		font-weight: normal;
		color: #2d2d2d;
		
	}
	.woocommerce-Price-amount.amount {font-size: 16px;color: #454545;float:right;}
	.variation {padding-left: 25px !important;}
	.check-list li {
		font-size: 16px;
		color: #32a3aa;
		font-weight: normal !important;
		list-style-type: disc;
	}
	.check-list {margin: 2px 0;}
	.acc-supply {color: #454545;padding-left:20px;}
	.product-total {vertical-align: top !important;}
	
	@media(max-width:768px){
		.product-review {padding: 0 0px;margin-top: 14px;}
		.product-review h3 {color: #32a3aa;font-size: 18px;margin-left: 23px;}
		.check-list {margin: 0;padding: 0 0 0 17px;}
	}
	@media(max-width:325px){
	.order-total th {padding: 20px 20px !important;}
}
	@media(max-width:400px){
		.order-total .woocommerce-Price-amount.amount {
			font-size: 19px !important;
			font-weight: normal;
			color: #2d2d2d;
			float: left !important;
		}	
	}
	
	@media(max-width:767px){
		.check-col-pad0 .vc_column-inner {padding:0px;}
	}
</style>
<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
<!--		<tr>
			<th class="product-name"><?php// _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php// _e( 'Total', 'woocommerce' ); ?></th>
		</tr>-->
	</thead>
	<tbody>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );
//                        print_r(WC()->cart);
//                        $courseLevel = $_SESSION[courseLevel];
                        
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                    $term_list = wp_get_post_terms($cart_item['product_id'],'product_cat',array('fields'=>'ids'));
//                                    var_dump($term_list);
                                    $cat_id = (int)$term_list[0];
                                    $cat_name = get_cat_name ($cat_id, 'product_cat');
                                    ?>
                                        <tr>
                                            <?php if($cat_name == 'Accomodation'){?>
                                            <td colspan="2"><div class="checkout-callon"><?php _e( 'Accomodation', 'woocommerce' );?>
                                            </div></td>
                                            <?php }?>
											<?php if($cat_name == 'Visa'){?>
                                            <td colspan="2"><div class="checkout-callon"><?php _e( 'Visa', 'woocommerce' );?>
                                            </div></td>
                                            <?php }?>
											<?php if($cat_name == 'AIRPORT TRANSFER'){?>
                                            <td colspan="2"><div class="checkout-callon"><?php _e( 'AIRPORT TRANSFER', 'woocommerce' );?>
                                            </div></td>
                                            <?php }?>
                                        </tr>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                            
                                            <td>
                                                        <ul class="check-list"><li>
                                                        <?php if($cat_name != 'Duration'){?>
							<div class="acc-supply">
							<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?></div>
                                                        <?php if($cat_name == 'Courses'){
                                                        echo '<tr><td><ul class="check-list"><li><div class="acc-supply"> Course Level: '.ucwords($_SESSION[courseLevel]).'<br/>Course Length: '.ucwords($_SESSION[proc_week]).'<br/>Course Start Date: '.$_SESSION[proc_startdate].'</div></li></ul></td>';}?>
                                                        <?php // echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity"></strong>', $cart_item, $cart_item_key );}?>
                                                        <?php // echo WC()->cart->get_item_data( $cart_item ); }?>
                                                        <?php }else{
															?>
															<div class="acc-supplay"><?php 
                                                        _e( 'Accommodation Supplement (High Season)', 'woocommerce' ); 
                                                         }?></div> 
							</li></ul>							 
						</td>
						<td class="product-total"><div class="amount-mob">
							<?php $matches = 0;
							 preg_match_all('/\d+/', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $matches); 	 
							 if($matches[0][0] > 0){ ?>
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
							<?php } ?>
						</div></td>
					</tr>
                                <?php // print_r(WC()->cart->get_fees());?>
                           		<?php if(isset($_SESSION['fee_charge']) && !empty($_SESSION['fee_charge']) && $_SESSION['fee_charge'] != 'yes'): ?>     
                                         <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                                         <tr class="fee">
                                         <?php 
                                           
                                            if((strpos($fee->id, 'books') && $cat_name == 'Courses') || (strpos($fee->id, 'book') && $cat_name == 'Courses')){
                                                echo '<td><ul class="check-list"><li><div class="acc-supplay">'.esc_html( $fee->name ).'</div></li></ul></td>';?>
                                             <td><div class="amount-mob"><?php echo wc_cart_totals_fee_html( $fee );?></div></td>
                                            <?php }
                                            if($fee->id=='registration-fee' && $cat_name == 'Courses'){
                                                echo '<td><ul class="check-list"><li><div class="acc-supplay">'.esc_html( $fee->name ).'</div></li></ul></td>';?>
                                                <td><div class="amount-mob"><?php echo wc_cart_totals_fee_html( $fee );?></div></td>
                                            <?php }
                                            if($fee->id=='finding-fee' && $cat_name == 'Accomodation'){
                                                
                                                echo '<td><ul class="check-list"><li><div class="acc-supplay">'.esc_html( $fee->name ).'</div></li></ul></td>'; ?>
                                                <td><div class="amount-mob"><?php echo wc_cart_totals_fee_html( $fee );?></div></td>
                                            <?php } 
                                        ?>
                                        </tr>
                                        <?php endforeach; ?>
                                <?php endif; ?>

					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
		<tr><td class="product-name"><br><br></td><td class="product-total"></td></tr>
	</tbody>
	<tfoot>

<!--		<tr class="cart-subtotal">
			<th><?php //_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php //wc_cart_totals_subtotal_html(); ?></td>
		</tr>-->
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>
                            
		<?php //foreach ( WC()->cart->get_fees() as $fee ) : ?>
<!--			<tr class="fee">
				<th><?php// echo esc_html( $fee->name ); ?></th>
				<td><?php //wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>-->
		<?php// endforeach; ?>

		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?><br><br></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
		
		<tr class="order-total">
			<th><?php _e( 'Total', 'woocommerce' ); ?></th>
			<td><div class="pad-mob-ck"><?php wc_cart_totals_order_total_html(); ?></div></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
