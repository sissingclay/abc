<?php
/*
Plugin Name: WooCommerce WorldPay Gateway
Plugin URI: http://woothemes.com/woocommerce/
Description: Extends WooCommerce. Provides a WorldPay gateway for WooCommerce. Includes basic support for Subscriptions. http://www.worldpay.com.
Version: 3.5.3
Author: Add On Enterprises (Andrew Benbow)
Author URI: http://www.addonenterprises.com
*/

/*  Copyright 2011  Andrew Benbow  (email : andrew@chromeorange.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	Test environment:
	https://secure-test.worldpay.com/wcc/iadmin (https://secure-test.worldpay.com/wcc/iadmin)

	Production environment:
	https://secure.worldpay.com/wcc/iadmin (https://secure.worldpay.com/wcc/iadmin)
*/

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), '6bc48c9d12dc0c43add4b099665a80b0', '18646' );

/**
 * Localization
 */
load_plugin_textdomain( 'woocommerce_worlday', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

// Init WorldPay Gateway after WooCommerce has loaded
add_action('plugins_loaded', 'init_worldpay_gateway', 0);

function init_worldpay_gateway() {

	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;

	/**
	 * Include Form Gateway class
	 */
	include('classes/worldpay-form-class.php');

	/**
	 * Add the Gateway to WooCommerce
	 */
	function add_worldpay_form_gateway($methods) {
		$methods[] = 'WC_Gateway_Worldpay_Form';
		return $methods;
	}
	add_filter('woocommerce_payment_gateways', 'add_worldpay_form_gateway' );


} // END init_worldpay_gateway