<?php //echo '<pre>'; print_r($_SESSION['is_back']); echo '</pre>';
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
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
 * @version 2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

?>
<style>
	 .stud-details h3{color:#32a3aa;font-size:18px;text-transform:uppercase;}
	 .stud-details input, .state_select, .country_select { float:left;border: 1px solid #E9E9E9 !important;    height: 40px;    background-color: #fff;    border-radius: 6px;}

	 .stud-details .select2-container .select2-choice{border:none !important;background-color: #fff; height: 100% !important;}
	 .select2-search {border: 1px solid #d0cece !important;}
	 .stud-details .select2-container .select2-choice{
		 background: transparent;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		background: url(http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2016/12/dropdown-arrow.png) 96% / 3% no-repeat #fff;
	 }
	 .select2-container .select2-choice .select2-arrow b::after{border:none;}
	 #billing_gender_field label{
		margin-top: -15px !important;
		margin-left: 19px !important;
		margin-right: 22px !important;
	}
	#billing_howtohear_field label{
		margin-top: -15px !important;
		margin-left: 19px !important;
		margin-right: 22px !important;
	}
	
	#billing_gender_Male, #billing_gender_Female{margin-top:-22px;}
</style>
<div class="woocommerce-billing-fields stud-details">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php _e( 'Student Details', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<?php foreach ( $checkout->checkout_fields['billing'] as $key => $field ) : ?>

		<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

	<?php endforeach; ?>

	<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>
	<?php wc_get_template( 'checkout/terms.php' ); ?>
         <div class="form-row place-order">
        <?php $order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) );?>
        
        <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

        <?php echo '<a href="javascript:;" id="back_button_checkout" class="button cart-next-btn" style="background-color:gray;border:none;float:left;margin-top:23px !important;padding:14px 60px !important;">Back</a>'; ?>

        <?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' ); ?>

        <?php do_action( 'woocommerce_review_order_after_submit' ); ?>
         </div>     
	<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

		<?php if ( $checkout->enable_guest_checkout ) : ?>

			<p class="form-row form-row-wide create-account">
				<input class="input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'woocommerce' ); ?></label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>

			<div class="create-account">

				<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>

				<?php foreach ( $checkout->checkout_fields['account'] as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

				<?php endforeach; ?>

				<div class="clear"></div>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	<?php endif; ?>
</div>

<script>
jQuery('#7-emergency-other_field').hide();
jQuery('.woocommerce-billing-fields').on("change","#6-how-this-person-relates-to-you",function() {
	var selected_emergency = jQuery(this).val();
	if(selected_emergency == 'Other'){
		jQuery('#7-emergency-other_field').show();
	} else {
		jQuery('#7-emergency-other_field').hide();
	}
});

jQuery('#back_button_checkout').click(function(){ 
	<?php session_start();
    $_SESSION['is_back'] = 'back_click'; ?>
	window.location.href = "<?php echo get_site_url().'/cart'; ?>";
});
</script>