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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/js/jquery.validate.js"></script>
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
		/*//font-weight:bold;*/
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
		background: url(/wp-content/uploads/2016/12/dropdown-arrow.png) 91% / 10% no-repeat #fff;
		border: 1px solid #e3e3e3 !important;
		border-radius:6px;
	}
	
	#billing_nationality, #billing_emperson_relation {
		background: transparent;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		background: url(/wp-content/uploads/2016/12/dropdown-arrow.png) 96% / 3% no-repeat #fff;
		border: 1px solid #e3e3e3 !important;
		border-radius:6px;
	}
	#billing_liketoapply, #billing_howtohear{
		background: transparent;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		background: url(/wp-content/uploads/2016/12/dropdown-arrow.png) 96% / 3% no-repeat #fff;
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
		#billing_title{background: url(/wp-content/uploads/2016/12/dropdown-arrow.png) 91% / 4% no-repeat #fff;}
		#billing_postcode_1_field, #billing_title_field {width: 100%;}
		#billing_title {
				background: url(/wp-content/uploads/2016/12/dropdown-arrow.png) 96% / 3% no-repeat #fff;
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
<?php $site_url= get_site_url(); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<form name="checkout" id="chk" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

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
	<div id="accomodation_cart"><table><tbody><tr><td colspan="2"><div class="maincart"><div class="proc_name marbottom20 mob-padtb20"><b style="color:#32a3aa;font-size:18px;font-weight:400;">Student Details</b></div></div></td></tr><tr class="d_one" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Title : <span id="in_1"></span></div></li></ul></td></tr><tr class="d_2" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">First name : <span id="in_2"></span></div></li></ul></td></tr><tr class="d_3" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Last Name : <span id="in_3"></span></div></li></ul></td></tr><tr class="d_4" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Gender: <span id="in_4"></span></div></li></ul></td></tr><tr class="d_5" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Nationality: <span id="in_5"></span></div></li></ul></td></tr><tr class="d_6" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Date of birth: <span id="in_6"></span></div></li></ul></td></tr><tr class="d_7" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Passport number: <span id="in_7"></span></div></li></ul></td></tr><tr class="d_8" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Address line 1: <span id="in_8"></span></div></li></ul></td></tr>
<tr class="d_9" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Address line 2: <span id="in_9"></span></div></li></ul></td></tr>
<tr class="d_10" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">City: <span id="in_10"></span></div></li></ul></td></tr>
<tr class="d_11" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Postcode: <span id="in_11"></span></div></li></ul></td></tr>
<tr class="d_12" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Country: <span id="in_12"></span></div></li></ul></td></tr>
<tr class="d_13" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Email<span id="in_13"></span></div></li></ul></td></tr>
<tr class="d_14" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Phone number: <span id="in_14"></span></div></li></ul></td></tr>
	<tr><td><br></td></tr></tbody></table>
	<table><tbody><tr><td colspan="2"><div class="maincart"><div class="proc_name marbottom20 mob-padtb20"><b style="color:#32a3aa;font-size:18px;font-weight:400;">Emergency Details</b></div></div></td></tr>

<tr class="d_15" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Person relation: <span id="in_15"></span></div></li></ul></td></tr>
<tr class="d_16" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Fist name: <span id="in_16"></span></div></li></ul></td></tr>
<tr class="d_17" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Last name: <span id="in_17"></span></div></li></ul></td></tr>
<tr class="d_18" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Address line 1: <span id="in_18"></span></div></li></ul></td></tr>
<tr class="d_19" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Address line 2: <span id="in_19"></span></div></li></ul></td></tr>
<tr class="d_20" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">City: <span id="in_20"></span></div></li></ul></td></tr>
<tr class="d_21" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Postcode: <span id="in_21"></span></div></li></ul></td></tr>
<tr class="d_22" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Email: <span id="in_22"></span></div></li></ul></td></tr>
<tr class="d_23" style="display: none;"><td><ul class="check-list"><li><div class="acc-supply">Phone number: <span id="in_23"></span></div></li></ul></td></tr></tbody></table></div>

	<h3 id="order_review_heading"><?php _e( 'SHOPPING CART', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		
	</div>
	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
 </div>

</form>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
<script type="text/javascript">
jQuery(document).ready(function() {
	 reset();
	 jQuery( "#3-user-dob" ).datepicker({
	 	maxDate: 0,
	 	changeMonth: true, 
	    changeYear: true, 
	    dateFormat: "dd-mm-yy",
	    yearRange: "-90:+00"
	 });

	  jQuery("#billing_title").change(function(){
            var petval = jQuery(this).val();
            if(petval=='Title'){
                jQuery('.d_one').hide();
            } else {
                jQuery('.d_one').show();
                jQuery('#in_1').html(petval);
            }
        });
	  jQuery("#billing_first_name").keyup(function($){
            var petval1 = jQuery(this).val();
            if(petval1==''){
                jQuery('.d_2').hide();
            } else {
                jQuery('.d_2').show();
                jQuery('#in_2').html(petval1);
            }
        }); jQuery("#billing_last_name").keyup(function(){
            var petval2 = jQuery(this).val();
            if(petval2==''){
                jQuery('.d_3').hide();
            } else {
                jQuery('.d_3').show();
                jQuery('#in_3').html(petval2);
            }
        });jQuery("#1_user_gender").change(function(){
            var petval3 = jQuery(this).val();
            if(petval3=='Gender'){
                jQuery('.d_4').hide();
            } else {
                jQuery('.d_4').show();
                jQuery('#in_4').html(petval3);
            }
        });jQuery("#2-user-nationality").change(function(){
            var petval4 = jQuery(this).val();
            if(petval4=='Select your nationality'){
                jQuery('.d_5').hide();
            } else {
                jQuery('.d_5').show();
                jQuery('#in_5').html(petval4);
            }
        });jQuery("#3-user-dob").change(function(){
            var petval5 = jQuery(this).val();
            if(petval5==''){
                jQuery('.d_6').hide();
            } else {
                jQuery('.d_6').show();
                jQuery('#in_6').html(petval5);
            }
        });jQuery("#4-user-passport-no").keyup(function(){
            var petval6 = jQuery(this).val();
            if(petval6==''){
                jQuery('.d_7').hide();
            } else {
                jQuery('.d_7').show();
                jQuery('#in_7').html(petval6);
            }
        });jQuery("#billing_address_1").keyup(function(){
            var petval7 = jQuery(this).val();
            if(petval7==''){
                jQuery('.d_8').hide();
            } else {
                jQuery('.d_8').show();
                jQuery('#in_8').html(petval7);
            }
        });jQuery("#billing_address_2").keyup(function(){
            var petval8 = jQuery(this).val();
            if(petval8==''){
                jQuery('.d_9').hide();
            } else {
                jQuery('.d_9').show();
                jQuery('#in_9').html(petval8);
            }
        });jQuery("#billing_city").keyup(function(){
            var petval9 = jQuery(this).val();
            if(petval9==''){
                jQuery('.d_10').hide();
            } else {
                jQuery('.d_10').show();
                jQuery('#in_10').html(petval9);
            }
        });jQuery("#billing_postcode").keyup(function(){
            var petval10 = jQuery(this).val();
            if(petval10==''){
                jQuery('.d_11').hide();
            } else {
                jQuery('.d_11').show();
                jQuery('#in_11').html(petval10);
            }
        });jQuery("#billing_country").change(function(){
            var petval11 = jQuery(this).val();
            if(petval11==''){
                jQuery('.d_12').hide();
            } else {
                jQuery('.d_12').show();
                jQuery('#in_12').html(petval11);
            }
        });jQuery("#billing_email").keyup(function(){
            var petval12 = jQuery(this).val();
            if(petval12==''){
                jQuery('.d_13').hide();
            } else {
                jQuery('.d_13').show();
                jQuery('#in_13').html(petval12);
            }
        });jQuery("#billing_phone").keyup(function(){
            var petval13 = jQuery(this).val();
            if(petval13==''){
                jQuery('.d_14').hide();
            } else {
                jQuery('.d_14').show();
                jQuery('#in_14').html(petval13);
            }
        });jQuery("#6-how-this-person-relates-to-you").change(function(){
            var petval14 = jQuery(this).val();
            if(petval14==''){
                jQuery('.d_15').hide();
            } else {
                jQuery('.d_15').show();
                jQuery('#in_15').html(petval14);
            }
        });jQuery("#7-emergency-firstname").keyup(function(){
            var petval15 = jQuery(this).val();
            if(petval15==''){
                jQuery('.d_16').hide();
            } else {
                jQuery('.d_16').show();
                jQuery('#in_16').html(petval15);
            }
        });jQuery("#8-emergency-lastname").keyup(function(){
            var petval16 = jQuery(this).val();
            if(petval16==''){
                jQuery('.d_17').hide();
            } else {
                jQuery('.d_17').show();
                jQuery('#in_17').html(petval16);
            }
        });jQuery("#9-emergency-address-line1").keyup(function(){
            var petval17 = jQuery(this).val();
            if(petval17==''){
                jQuery('.d_18').hide();
            } else {
                jQuery('.d_18').show();
                jQuery('#in_18').html(petval17);
            }
        });jQuery("#9-emergency-address-line-2").keyup(function(){
            var petval18 = jQuery(this).val();
            if(petval18==''){
                jQuery('.d_19').hide();
            } else {
                jQuery('.d_19').show();
                jQuery('#in_19').html(petval18);
            }
        });jQuery("#9-emergency-city").keyup(function(){
            var petval19 = jQuery(this).val();
            if(petval19==''){
                jQuery('.d_20').hide();
            } else {
                jQuery('.d_20').show();
                jQuery('#in_20').html(petval19);
            }
        });jQuery("#9-emergency-postcode").keyup(function(){
            var petval20 = jQuery(this).val();
            if(petval20==''){
                jQuery('.d_21').hide();
            } else {
                jQuery('.d_21').show();
                jQuery('#in_21').html(petval20);
            }
        });jQuery("#9-emergency-email-address").keyup(function(){
            var petval21 = jQuery(this).val();
            if(petval21==''){
                jQuery('.d_22').hide();
            } else {
                jQuery('.d_22').show();
                jQuery('#in_22').html(petval21);
            }
        });jQuery("#9-emergency-phoneno").keyup(function(){
            var petval22 = jQuery(this).val();
            if(petval22==''){
                jQuery('.d_23').hide();
            } else {
                jQuery('.d_23').show();
                jQuery('#in_23').html(petval22);
            }
        });

});
function reset() {
	 jQuery('.one').hide();
}
</script>
<style type="text/css">
.sweet-alert
{
    left: 50% !important;
    width: 560px !important;
} 
#customer_details .stud-details .error , #customer_details .stud-details .error {
  border-color: red !important;
}

select{
outline: none !important;
cursor: pointer !important;

}
@-moz-document url-prefix() {
select{
	text-shadow: 0 0 0 #141412 !important;
	color: transparent !important;

}
}
    div#accomodation_cart table td:first-child {
    width: 280px;
}
td.priceright div {
    max-width: 150px;
    word-wrap: break-word;
    line-height: 1.2;
}
.allergies-left {
    margin-top: 10px;
    margin-bottom: 10px;
}
#billing_postcode {
    display: none;
}
 .new_arr > label{
 	color: #32a3aa;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
 }
</style>

