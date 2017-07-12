<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>
<style>
	.woocommerce table.shop_table, .woocommerce table.shop_table td, .woocommerce table.shop_table tbody th, .woocommerce table.shop_table tfoot th{border:none !important;}
	.checkout-pad .vc_column-inner {padding:0px}
	.woocommerce table.shop_table td{padding-top:0px;padding-bottom:0px;}
	
	#customer_details{margin-top:-15px;}
	#product-review{margin-top:-15px;}
	#customer_details select {
		border: 1px solid #e3e3e3 !important;
		border-radius:6px;
		text-indent: 7px;
	}
	
	.stud-details h3{text-transform:uppercase;font-weight:600;}
	#billing_first_name, #billing_last_name, #billing_dateofbirth, #billing_passportnumber, #billing_ememail, #billing_emphone{border-radius:0px !important}
	#billing_address_1_field label{
		color: #32a3aa;
		font-size: 18px;
		text-transform: uppercase;
		font-weight:bold;
		margin-bottom: 20px;
		margin-top: 11px;
	}
	#billing_emperson_relation_field label{
		color: #32a3aa;
		font-size: 18px;
		text-transform: uppercase;
		font-weight:bold;
		margin-bottom: 20px;
		margin-top: 11px;
	}
	#billing_howtohear_field label{
		color: #32a3aa;
		font-size: 18px;
		text-transform: uppercase;
		font-weight:bold;
		margin-bottom: 20px;
		margin-top: 11px;
	}
	#billing_title {
		width:130px;
		background: transparent;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		background: url(http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2016/12/dropdown-arrow.png) 91% / 10% no-repeat #fff;
		border: 1px solid #e3e3e3 !important;
		border-radius:6px;
	}
	
	#billing_nationality, #billing_emperson_relation {
		background: transparent;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		background: url(http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2016/12/dropdown-arrow.png) 96% / 3% no-repeat #fff;
		border: 1px solid #e3e3e3 !important;
		border-radius:6px;
	}
	#billing_liketoapply, #billing_howtohear{
		background: transparent;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		background: url(http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2016/12/dropdown-arrow.png) 96% / 3% no-repeat #fff;
		border: 1px solid #e3e3e3 !important;
		border-radius:6px;
	}
	.woocommerce form .form-row {
		padding: 3px;
		margin: 0 0 8px;
	}
	#billing_accepttemsandcon_field {
		border: 1px solid #ececec;
		background-color: #fff;
		padding: 15px 15px 15px 22px;
		color: #454545;
		margin: 15px 5px;
	}
	.g-recaptcha{float:right;}
	#place_order {height: 50px;float:right;margin-top: 18px;background-color: #2abfd4;border-radius: 26px;}
	
	
	
 
		#customer_details {
			float: left;
			width: 50%;
			margin-right: 0px;
			background-color: #fafafa;
			padding: 65px;
            min-height: 900px;
		}
		.product-review {
			float: left;
			width: 50%;
			padding:65px;
			background-color: #e0f8f8;
			margin-top:-15px;
		}
 
	@media(max-width:767px){
		#customer_details {width: 100%;margin-right:0px;padding:2px 18px}
		.product-review {float: left;width: 100% !important;}
		.product-review{padding:0 50px;}
		#billing_title, #billing_first_name_field, #billing_last_name_field, #billing_dateofbirth_field, #billing_passportnumber_field, #billing_city_field, #billing_postcode_bill_field{width: 100% ;}
		#billing_email_field, #billing_phone_field, #billing_emfirst_name_field, #billing_emlast_name_field, #billing_emcity_field, #billing_empostcode_field, #billing_ememail_field, #billing_emphone_field{width:100%;}
		#billing_title{background: url(http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2016/12/dropdown-arrow.png) 91% / 4% no-repeat #fff;}
		#billing_postcode_1_field, #billing_title_field {width: 100%;}
		#billing_title {
				background: url(http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2016/12/dropdown-arrow.png) 96% / 3% no-repeat #fff;
		}
	
	}
	
	.checkout woocommerce-checkout{float:left;width:40%;}
	.product-review h3{color:#32a3aa;font-size:18px;margin-left:45px;}
	@media(min-width:768px) and (max-width:991px){
		.stud-details{padding:0 100px;}
		.product-review{padding:0 100px;}
		.stud-details {padding: 0 7px;}
		
	}
	 
	
	@media(min-width:768px) and (max-width:991px){
		#customer_details {float: left;width: 50%;margin-right: 0px;background-color: #fafafa;padding: 16px;min-height: 900px;}
		.stud-details {padding: 0 5px;}
		.product-review {padding: 0 8px;}
	}
</style>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<!-- <div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div> -->
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	<div class="product-review">
	<h3 id="order_review_heading"><?php _e( 'SHOPPING CART', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
 </div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
