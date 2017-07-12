<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Extra_Cost
 * @subpackage Woocommerce_Extra_Cost/public
 * @author     Multidots <wordpress@multidots.com>
 */
class Woocommerce_Extra_Cost_Public {

	/**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
	private $plugin_name;

	/**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
	private $version;

	/**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->ace_charge_type = get_option('aec_charge_type');
		$this->ser_aec_charge_type = maybe_unserialize($this->ace_charge_type);
		$this->aec_charge_type_country = $this->ser_aec_charge_type['country'];
		$this->aec_charge_type_user_role= $this->ser_aec_charge_type['user_role'];
		$this->aec_charge_type_shipping= $this->ser_aec_charge_type['shipping'];
		$this->aec_charge_type_cart_total= $this->ser_aec_charge_type['cart_total'];
		$this->aec_charge_type_cart_quantity= $this->ser_aec_charge_type['cart_quantity'];
		$this->aec_charge_type_cart_weight= $this->ser_aec_charge_type['cart_weight'];
		$this->aec_charge_type_product= $this->ser_aec_charge_type['product'];
		$this->aec_charge_variabl_product= $this->ser_aec_charge_type['variabl_product'];
		$this->aec_charge_cat_product= $this->ser_aec_charge_type['cat_product'];
		$this->aec_charge_tag_product = $this->ser_aec_charge_type['tag_product'];
		$this->aec_charge_coupon_product = $this->ser_aec_charge_type['coupon_product'];
		$this->aec_charge_based_paymentgateway = $this->ser_aec_charge_type['based_paymentgateway'];
	}

	/**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
	public function enqueue_styles() {

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woocommerce-extra-cost-public.css', array(), $this->version, 'all');
	}

	/**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
	public function enqueue_scripts() {

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woocommerce-extra-cost-public.js', array('jquery'), $this->version, false);
	}

	/**
     * WooCommerce Extra Feature
     * --------------------------
     *
     * Add custom fee to cart automatically
     *
     */
	function woo_add_cart_fee() {

		global $woocommerce, $post;
		if (is_admin() && !defined('DOING_AJAX'))
		return;

		foreach ($woocommerce->cart->cart_contents as $key => $values) {
			$is_enable_extra_cost = get_post_meta($values['product_id'], '_extra_cost_enable', true);
			$is_extra_cost_enable_qty = get_post_meta($values['product_id'], '_extra_cost_enable_qty', true);
			$is_extra_cost_disable_qty = get_post_meta($values['product_id'], '_extra_cost_amount_quatity', true);

			if ((isset($is_enable_extra_cost) && !empty($is_enable_extra_cost)) && (isset($is_extra_cost_enable_qty) && !empty($is_extra_cost_enable_qty))) {
				$extra_cost_price = get_post_meta($values['product_id'], '_extra_cost_amount', true);
				$extra_cost = $extra_cost_price * $values['quantity'];
			}
			if ((isset($is_enable_extra_cost) && !empty($is_enable_extra_cost)) && (isset($is_extra_cost_enable_qty) && empty($is_extra_cost_enable_qty) )) {
				$extra_cost_price = get_post_meta($values['product_id'], '_extra_cost_amount', true);
				$extra_cost = $extra_cost_price;
			}

			if ((isset($is_extra_cost_disable_qty) && !empty($is_extra_cost_disable_qty)) && empty($is_extra_cost_enable_qty) && $values['quantity'] > 1) {
				$extra_cost_price = get_post_meta($values['product_id'], '_extra_cost_amount', true);
				$extra_cost_quantity_prise = get_post_meta($values['product_id'], '_extra_cost_amount_quatity', true);
				$quantity = $values['quantity'] - 1;
				$extra_cost_data = $extra_cost_quantity_prise * $quantity;
				$extra_cost = $extra_cost_price + $extra_cost_data;
			}

			if (isset($is_enable_extra_cost) && $is_enable_extra_cost != '' && !empty($is_enable_extra_cost)) {
				$extra_cost_lable = get_post_meta($values['product_id'], '_extra_cost_label', true);
				$woocommerce->cart->add_fee(apply_filters('extra_feature_extra_cost_name', $extra_cost_lable . ': ' . get_the_title($values['product_id'])), $extra_cost, false, 'standard');
			}
		}
	}

	/**
     * Function is resonsible for add extra cost based on variable product
     * 
     */
	public function woo_add_cart_fee_based_on_variable_product() {
		global $woocommerce, $post;
		if (is_admin() && !defined('DOING_AJAX'))
		return;

		$cart_sub_total = $woocommerce->cart->subtotal;
		$country_extra_cost_cart_max_total = get_option('wc_extra_cost_max_total');
		$max_total_option_val = get_option('wc_extra_cost_max_total');
		$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');
		foreach ($woocommerce->cart->cart_contents as $key => $values) {

			$extra_value_own = get_post_meta($values['variation_id'], '_woocommerce_extra_cost_value', true);

			if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
				if ($this->aec_charge_variabl_product =='per') {
					$extra_value = ($cart_sub_total * $extra_value_own) / 100;
				}else if ($this->aec_charge_variabl_product  =='fix') {
					$extra_value = $extra_value_own;
				}
			}else {
				$extra_value = $extra_value_own;
			}




			$extra_label = get_post_meta($values['variation_id'], '_woocommerce_extra_cost_label', true);
			//	$woocommerce->cart->add_fee(apply_filters('extra_feature_extra_cost_name', 'TestTeesting'), $test, true, 'standard');
			if (isset($extra_label) && !empty($extra_label) && isset($extra_value) && !empty($extra_value)) {
				$product_title = get_the_title($values['product_id']);
				$cost_label = $extra_label . '(' . $product_title . ')';

				if (isset($country_extra_cost_cart_max_total) && !empty($country_extra_cost_cart_max_total) && $country_extra_cost_cart_max_total == 'yes') {

					if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
						$woocommerce->cart->add_fee($cost_label, $extra_value, false, '');
					}
				} else if (isset($country_extra_cost_cart_max_total) && !empty($country_extra_cost_cart_max_total) && $country_extra_cost_cart_max_total == 'no') {
					$woocommerce->cart->add_fee($cost_label, $extra_value, false, '');
				}
			}
		}
	}

	/**
     * WooCommerce Extra Feature
     * Extra Cost Based on Country
     * --------------------------
     *
     * Add custom fee to cart automatically
     *
     */
	function woo_add_cart_fee_based_on_country() {
		global $woocommerce, $post, $wpdb;
		if (is_admin() && !defined('DOING_AJAX'))
		return;
		$country_extra_cost = get_option('wc_extra_cost_country');
		//$country_aec_charge_type = get_option('aec_charge_type');

		if (isset($country_extra_cost) && !empty($country_extra_cost) && $country_extra_cost == 'yes') {
			$cart_sub_total = $woocommerce->cart->subtotal;
			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');

			$get_wc_extra_cost_based_on_country = get_option('wc_extra_cost_based_on_country');
			$get_wc_extra_cost_based_on_country = maybe_unserialize($get_wc_extra_cost_based_on_country);
			$selected_country = $woocommerce->customer->get_shipping_country();
			foreach ($get_wc_extra_cost_based_on_country as $key) {
				if (strtoupper($key['extra_cost_based_country_code']) == $selected_country) {
					$extraCostLabel = $key['extra_cost_based_country_cost_title'];
					//get Extra cost

					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_country =='per') {
							$surcharge = ($cart_sub_total * $key['extra_cost_based_country_amount']) / 100;
						}else if ($this->aec_charge_type_country  =='fix') {
							$surcharge = $key['extra_cost_based_country_amount'];
						}
					}else {
						$surcharge = $key['extra_cost_based_country_amount'];
					}


					//Add Extra fee in cart page.

					if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {

						if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
							$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
						}
					} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
						$woocommerce->cart->add_fee($extraCostLabel , $surcharge, false, '');
					}
				}
			}
		} else {

		}
	}

	/**
     * Extra Cost Based on User Role
     * ------------------------------
     * 
     * Create function woo_add_cart_fee_based_on_user_role
     */
	function woo_add_cart_fee_based_on_user_role() {
		global $woocommerce, $post, $wpdb;
		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * check user loggedin or not
         */
		if (!is_user_logged_in()) {
			return false;
		}

		$cart_sub_total = $woocommerce->cart->subtotal;
		$cart_product_extra_cost_user = get_option('wc_extra_cost_role_user');

		if (isset($cart_product_extra_cost_user) && !empty($cart_product_extra_cost_user) && $cart_product_extra_cost_user == 'yes') {
			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');
			$country_extra_cost_cart_max_total = get_option('wc_extra_cost_max_total');
			$get_wc_extra_cost_based_on_user_role = get_option('wc_extra_cost_based_on_user_role');
			$get_wc_extra_cost_based_on_user_role = maybe_unserialize($get_wc_extra_cost_based_on_user_role);


			global $current_user;
			$user_role = $current_user->roles[0];
			foreach ($get_wc_extra_cost_based_on_user_role as $key) {
				if (strtolower($key['extra_cost_based_user_role_name']) == $user_role) {
					$extraCostLabel = $key['extra_cost_based_user_role_title'];
					//get Extra cost

					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_user_role =='per') {
							$surcharge = ($cart_sub_total * $key['extra_cost_based_user_role_amount']) / 100;
						}else if ($this->aec_charge_type_user_role =='fix') {
							$surcharge = $key['extra_cost_based_user_role_amount'];
						}
					}else {
						$surcharge = $key['extra_cost_based_user_role_amount'];
					}


					//Add Extra fee in cart page.

					if (isset($country_extra_cost_cart_max_total) && !empty($country_extra_cost_cart_max_total) && $country_extra_cost_cart_max_total == 'yes') {

						if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
							$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
						}
					} else if (isset($country_extra_cost_cart_max_total) && !empty($country_extra_cost_cart_max_total) && $country_extra_cost_cart_max_total == 'no') {
						$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
					}
				}
			}
		}
	}

	/**
     * Extra Cost Based on Sipping Class
     * ----------------------------------
     *
     * Create Function woo_add_cart_fee_based_on_shipping_class
     */
	function woo_add_cart_fee_based_on_shipping_class() {
		global $woocommerce, $post, $wpdb;

		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * get wc_settings_extra_cost_shipping_class option
         */
		$cart_shipping_extra_cost = get_option('wc_extra_cost_cart_shipping_class');

		/**
         * check wc_settings_extra_cost_shipping_class option
         */
		if ($cart_shipping_extra_cost == 'yes') {
			/**
             * get cart sub Total
             */
			$cart_sub_total = $woocommerce->cart->subtotal;
			/**
             * get wc_extra_cost_max_total
             * get wc_ec_max_cart_total 
             */
			$country_extra_cost_cart_max_total = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');
			/**
             * check wc_extra_cost_max_total enable or not
             */
			if (isset($country_extra_cost_cart_max_total) && !empty($country_extra_cost_cart_max_total) && $country_extra_cost_cart_max_total == 'yes') {
				/**
                 * check cart total with wc_ec_max_cart_total
                 */
				if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
					$shipping_class_arr = array();
					$shipping_class_value_arr = array();
					$cart_shipping_charge = '';
					/**
                     * get ec_shipping_charge_ shipping charge
                     */
					$cart_shipping_sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}options WHERE `option_name` LIKE 'wc_ec_shipping_class_%'");
					foreach ($cart_shipping_sql as $cart_shipping_value) {
						$shipping_class = substr($cart_shipping_value->option_name, 21);
						$shipping_class_arr[] = $shipping_class;
						$shipping_class_value_arr[$shipping_class] = $cart_shipping_value->option_value;
					}
					/**
                     * check cart available product shipping charge
                     */
					foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
						$shipping_class_value = get_the_terms($values['product_id'], 'product_shipping_class');
						if (!empty($shipping_class_value) && $shipping_class_value != '') {
							foreach ($shipping_class_value as $shipping_class_key => $shipping_class_values) {
								if (in_array($shipping_class_values->name, $shipping_class_arr)) {

									if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
										if ($this->aec_charge_type_shipping =='per') {
											$cart_shipping_charge =  ($cart_sub_total * $shipping_class_value_arr[$shipping_class_values->name]) / 100;
										}else if ($this->aec_charge_type_shipping =='fix') {
											$cart_shipping_charge = $shipping_class_value_arr[$shipping_class_values->name];
										}
									}else {
										$cart_shipping_charge = $shipping_class_value_arr[$shipping_class_values->name];
									}

									if ($cart_shipping_charge != '') {
										$product_title = get_the_title($values['product_id']);
										/**
                                         * add Extra cost based on product shipping class
                                         */
										$woocommerce->cart->add_fee(apply_filters('extra_feature_extra_cost_name', apply_filters('extra_cost_change_title', 'Extra cost Based on shipping class:' . $product_title)), $cart_shipping_charge, false, 'standard');
									}
								}
							}
						}
					}
				}
			} else {
				$shipping_class_arr = array();
				$shipping_class_value_arr = array();
				$cart_shipping_charge = '';
				/**
                 * get ec_shipping_charge_ shipping charge
                 */
				$cart_shipping_sql = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}options WHERE `option_name` LIKE 'wc_ec_shipping_class_%'");
				foreach ($cart_shipping_sql as $cart_shipping_value) {
					$shipping_class = substr($cart_shipping_value->option_name, 21);
					$shipping_class_arr[] = $shipping_class;
					$shipping_class_value_arr[$shipping_class] = $cart_shipping_value->option_value;
				}
				/**
                 * check cart available product shipping charge
                 */
				foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
					$shipping_class_value = get_the_terms($values['product_id'], 'product_shipping_class');
					if (!empty($shipping_class_value) && $shipping_class_value != '') {
						foreach ($shipping_class_value as $shipping_class_key => $shipping_class_values) {
							if (in_array($shipping_class_values->name, $shipping_class_arr)) {

								if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
									if ($this->aec_charge_type_shipping =='per') {
										$cart_shipping_charge =  ($cart_sub_total * $shipping_class_value_arr[$shipping_class_values->name]) / 100;
									}else if ($this->aec_charge_type_shipping =='fix') {
										$cart_shipping_charge = $shipping_class_value_arr[$shipping_class_values->name];
									}
								}else {
									$cart_shipping_charge = $shipping_class_value_arr[$shipping_class_values->name];
								}

								//$cart_shipping_charge = $shipping_class_value_arr[$shipping_class_values->name];
								if ($cart_shipping_charge != '') {
									$product_title = get_the_title($values['product_id']);
									/**
                                     * add Extra cost based on product shipping class
                                     */
									$woocommerce->cart->add_fee(apply_filters('extra_feature_extra_cost_name', apply_filters('extra_cost_change_title', 'Extra cost Based on shipping class:' . $product_title)), $cart_shipping_charge, false, 'standard');
								}
							}
						}
					}
				}
			}
		}
	}

	/**
     * Extra Cost Based on Cart Total
     * -------------------------------
     * 
     * create function woo_add_cart_fee_based_on_cart_total
     *
     */
	function woo_add_cart_fee_based_on_cart_total() {
		global $woocommerce, $post, $wpdb;
		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * check Extra cost based on cart total method enable or not
         * get cart_total_extra_cost values
         */


		$cart_total_extra_cost = get_option('wc_extra_cost_cart_total');
		$cart_sub_total = $woocommerce->cart->subtotal;
		$wc_extra_cost_based_on_cart_total = get_option('wc_extra_cost_based_on_cart_total');





		if (isset($cart_total_extra_cost) && !empty($cart_total_extra_cost) && $cart_total_extra_cost == 'yes') {
			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');
			$key_tmp = array();
			$wc_extra_cost_based_on_cart_total = get_option('wc_extra_cost_based_on_cart_total');
			$wc_extra_cost_based_on_cart_total = maybe_unserialize($wc_extra_cost_based_on_cart_total);
			$key_tmp = $wc_extra_cost_based_on_cart_total;
			if (isset($key_tmp['total_greater_than']['extra_cost_based_cart_total_cart_total']) && !empty($key_tmp['total_greater_than']['extra_cost_based_cart_total_cart_total'])) {
				if ($cart_sub_total >= $key_tmp['total_greater_than']['extra_cost_based_cart_total_cart_total']) {
					$extraCostLabel_greater = $key_tmp['total_greater_than']['extra_cost_based_cart_total_cost_title'];


					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_cart_total =='per') {
							$surcharge_greater = ($cart_sub_total * $key_tmp['total_greater_than']['extra_cost_based_cart_total_amount']) / 100 ;
						}else if ($this->aec_charge_type_cart_total =='fix') {
							$surcharge_greater = $key_tmp['total_greater_than']['extra_cost_based_cart_total_amount'];
						}
					}else {
						$surcharge_greater = $key_tmp['total_greater_than']['extra_cost_based_cart_total_amount'];
					}
					//$surcharge_greater = $key_tmp['total_greater_than']['extra_cost_based_cart_total_amount'];



					//Add Extra fee in cart page.
					if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
						if (!($cart_sub_total >= $extra_cost_cart_max_total)) {

							$woocommerce->cart->add_fee($extraCostLabel_greater, $surcharge_greater, false, '');
						}
					} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
						$woocommerce->cart->add_fee($extraCostLabel_greater, $surcharge_greater, false, '');
					}

				}
			}
			if (isset($key_tmp['total_less_than']['extra_cost_based_cart_total_cart_total']) && !empty($key_tmp['total_less_than']['extra_cost_based_cart_total_cart_total'])) {
				if ($cart_sub_total <= $key_tmp['total_less_than']['extra_cost_based_cart_total_cart_total']) {
					$extraCostLabel_less = $key_tmp['total_less_than']['extra_cost_based_cart_total_cost_title'];

					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_cart_total =='per') {
							$surcharge_less = ($cart_sub_total * $key_tmp['total_less_than']['extra_cost_based_cart_total_amount']) / 100 ;
						}else if ($this->aec_charge_type_cart_total =='fix') {
							$surcharge_less = $key_tmp['total_less_than']['extra_cost_based_cart_total_amount'];
						}
					}else {
						$surcharge_less = $key_tmp['total_less_than']['extra_cost_based_cart_total_amount'];
					}

					//$surcharge_less = $key_tmp['total_less_than']['extra_cost_based_cart_total_amount'];
					//Add Extra fee in cart page.
					if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
						if (!($cart_sub_total >= $extra_cost_cart_max_total)) {

							$woocommerce->cart->add_fee($extraCostLabel_less, $surcharge_less, false, '');
						}
					} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
						$woocommerce->cart->add_fee($extraCostLabel_less, $surcharge_less, false, '');
					}

				}
			}

		}
	}

	/**
     * Extra Cost Base on Cart Item
     * -----------------------------
     * 
     * create function woo_add_cart_fee_based_on_cart_item
     *
     */
	function woo_add_cart_fee_based_on_cart_item() {
		global $woocommerce, $post, $wpdb;

		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * check Extra cost based on cart item method enable or not
         * get $cart_item_extra_cost values
         */
		$cart_item_extra_cost = get_option('wc_extra_cost_cart_quantity');
		$cart_sub_total = $woocommerce->cart->subtotal;
		$wc_extra_cost_based_on_cart_quantity = get_option('wc_extra_cost_based_on_cart_quantity');
		$key_tmp = array();


		if (isset($cart_item_extra_cost) && !empty($cart_item_extra_cost) && $cart_item_extra_cost == 'yes') {
			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');

			$wc_extra_cost_based_on_cart_quantity = get_option('wc_extra_cost_based_on_cart_quantity');
			$wc_extra_cost_based_on_cart_quantity = maybe_unserialize($wc_extra_cost_based_on_cart_quantity);
			$key_tmp  = $wc_extra_cost_based_on_cart_quantity;



			if (isset($key_tmp['qty_greater_than']['extra_cost_based_cart_quantity_amount']) && !empty($key_tmp['qty_greater_than']['extra_cost_based_cart_quantity_amount'])) {
				if ($woocommerce->cart->cart_contents_count >= $key_tmp['qty_greater_than']['extra_cost_based_cart_quantity_qty']) {
					$extraCostLabel_greater = $key_tmp['qty_greater_than']['extra_cost_based_cart_quantity_cost_title'];




					//$surcharge_greater = $key_tmp['qty_greater_than']['extra_cost_based_cart_quantity_amount'];

					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_cart_quantity =='per') {
							$surcharge_greater = ($cart_sub_total * $key_tmp['qty_greater_than']['extra_cost_based_cart_quantity_amount']) / 100 ;
						}else if ($this->aec_charge_type_cart_quantity =='fix') {
							$surcharge_greater = $key_tmp['qty_greater_than']['extra_cost_based_cart_quantity_amount'];
						}
					}else {
						$surcharge_greater = $key_tmp['qty_greater_than']['extra_cost_based_cart_quantity_amount'];
					}





					//Add Extra fee in cart page.
					if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
						if (!($cart_sub_total >= $extra_cost_cart_max_total)) {

							$woocommerce->cart->add_fee($extraCostLabel_greater, $surcharge_greater, false, '');
						}
					} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
						$woocommerce->cart->add_fee($extraCostLabel_greater, $surcharge_greater, false, '');
					}

				}
			}

			if (isset($key_tmp['qty_less_than']['extra_cost_based_cart_quantity_amount']) && !empty($key_tmp['qty_less_than']['extra_cost_based_cart_quantity_amount'])) {
				if ($woocommerce->cart->cart_contents_count <= $key_tmp['qty_less_than']['extra_cost_based_cart_quantity_qty']) {
					$extraCostLabel_less = $key_tmp['qty_less_than']['extra_cost_based_cart_quantity_cost_title'];
					$surcharge_less = $key_tmp['qty_less_than']['extra_cost_based_cart_quantity_amount'];

					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_cart_quantity =='per') {
							$surcharge_less = ($cart_sub_total * $key_tmp['qty_less_than']['extra_cost_based_cart_quantity_amount']) / 100 ;
						}else if ($this->aec_charge_type_cart_quantity =='fix') {
							$surcharge_less = $key_tmp['qty_less_than']['extra_cost_based_cart_quantity_amount'];
						}
					}else {
						$surcharge_less = $key_tmp['qty_less_than']['extra_cost_based_cart_quantity_amount'];
					}



					//Add Extra fee in cart page.
					if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
						if (!($cart_sub_total >= $extra_cost_cart_max_total)) {

							$woocommerce->cart->add_fee($extraCostLabel_less, $surcharge_less, false, '');
						}
					} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
						$woocommerce->cart->add_fee($extraCostLabel_less, $surcharge_less, false, '');
					}

				}
			}


		}
	}

	/**
     * Extra Cost Based on Product Weight
     * -----------------------------------
     * 
     * Create Function woo_add_cart_fee_based_on_weight
     */
	function woo_add_cart_fee_based_on_weight() {
		global $woocommerce, $post, $wpdb;

		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * check Extra cost based on cart weight method enable or not
         * get $cart_weight_extra_cost values
         */
		$cart_weight_extra_cost = get_option('wc_extra_cost_cart_weight');
		$cart_sub_total = $woocommerce->cart->subtotal;
		if (isset($cart_weight_extra_cost) && !empty($cart_weight_extra_cost) && $cart_weight_extra_cost == 'yes') {
			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');


			$wc_extra_cost_based_on_cart_weight = get_option('wc_extra_cost_based_on_cart_weight');
			$wc_extra_cost_based_on_cart_weight = maybe_unserialize($wc_extra_cost_based_on_cart_weight);
			$total_weight = $woocommerce->cart->cart_contents_weight;
			$key_tmp  = $wc_extra_cost_based_on_cart_weight;


			if (isset($key_tmp['wt_greater_than']['extra_cost_based_cart_weight_total_weight']) && !empty($key_tmp['wt_greater_than']['extra_cost_based_cart_weight_total_weight'])) {
				if ($total_weight >= $key_tmp['wt_greater_than']['extra_cost_based_cart_weight_total_weight']) {
					$extraCostLabel_greater = $key_tmp['wt_greater_than']['extra_cost_based_cart_weight_title'];
					//$surcharge_greater = $key_tmp['wt_greater_than']['extra_cost_based_cart_weight_amount'];

					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_cart_weight =='per') {
							$surcharge_greater = ($cart_sub_total * $key_tmp['wt_greater_than']['extra_cost_based_cart_weight_amount']) / 100 ;
						}else if ($this->aec_charge_type_cart_weight =='fix') {
							$surcharge_greater = $key_tmp['wt_greater_than']['extra_cost_based_cart_weight_amount'];
						}
					}else {
						$surcharge_greater = $key_tmp['wt_greater_than']['extra_cost_based_cart_weight_amount'];
					}

					//Add Extra fee in cart page.
					if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
						if (!($cart_sub_total >= $extra_cost_cart_max_total)) {

							$woocommerce->cart->add_fee($extraCostLabel_greater, $surcharge_greater, false, '');
						}
					} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
						$woocommerce->cart->add_fee($extraCostLabel_greater, $surcharge_greater, false, '');
					}

				}
			}

			if (isset($key_tmp['wt_less_than']['extra_cost_based_cart_weight_total_weight']) && !empty($key_tmp['wt_less_than']['extra_cost_based_cart_weight_total_weight'])) {
				if ($total_weight <= $key_tmp['wt_less_than']['extra_cost_based_cart_weight_total_weight']) {
					$extraCostLabel_less = $key_tmp['wt_less_than']['extra_cost_based_cart_weight_title'];
					//$surcharge_less = $key_tmp['wt_less_than']['extra_cost_based_cart_weight_amount'];

					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_cart_weight =='per') {
							$surcharge_less = ($cart_sub_total * $key_tmp['wt_less_than']['extra_cost_based_cart_weight_amount']) / 100 ;
						}else if ($this->aec_charge_type_cart_weight =='fix') {
							$surcharge_less = $key_tmp['wt_less_than']['extra_cost_based_cart_weight_amount'];
						}
					}else {
						$surcharge_less = $key_tmp['wt_less_than']['extra_cost_based_cart_weight_amount'];
					}



					//Add Extra fee in cart page.
					if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
						if (!($cart_sub_total >= $extra_cost_cart_max_total)) {

							$woocommerce->cart->add_fee($extraCostLabel_less, $surcharge_less, false, '');
						}
					} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
						$woocommerce->cart->add_fee($extraCostLabel_less, $surcharge_less, false, '');
					}

				}
			}


		}
	}

	/**
     * Extra Cost Based On Product
     * ---------------------------
     * 
     * Create function woo_add_cart_fee_based_on_product
     */
	function woo_add_cart_fee_based_on_product() {
		global $woocommerce, $post, $wpdb;
		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * get wc_settings_extra_cost_product option 
         */
		$cart_product_extra_cost = get_option('wc_extra_cost_cart_product');
		$cart_sub_total = $woocommerce->cart->subtotal;
		if (isset($cart_product_extra_cost) && !empty($cart_product_extra_cost) && $cart_product_extra_cost == 'yes') {

			$product_array = array();


			$wc_extra_cost_based_on_product = get_option('wc_extra_cost_based_on_product');
			$wc_extra_cost_based_on_product = maybe_unserialize($wc_extra_cost_based_on_product);

			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');

			foreach ($wc_extra_cost_based_on_product as $key =>$val) {
				$product_array[$key] = $val['extra_cost_based_product_name'];
			}

			$cart_product_array = $woocommerce->cart->get_cart();
			$product_title = '';
			foreach ($cart_product_array as $item => $values) {
				$cart_product_id = $values['data']->post;
				$product_title = $cart_product_id->post_title;
				if (in_array($cart_product_id->ID, $product_array)) {
					$key = array_search($cart_product_id->ID, $product_array);
					$find_value = $wc_extra_cost_based_on_product[$key];
					$extraCostLabel = $find_value['extra_cost_based_product_cost_title'];
					//get Extra cost
					//$surcharge = $find_value['extra_cost_based_product_amount'];

					if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
						if ($this->aec_charge_type_product =='per') {
							$surcharge = ($cart_sub_total * $find_value['extra_cost_based_product_amount']) / 100 ;
						}else if ($this->aec_charge_type_product =='fix') {
							$surcharge = $find_value['extra_cost_based_product_amount'];
						}
					}else {
						$surcharge = $find_value['extra_cost_based_product_amount'];
					}


					//Add Extra fee in cart page.
					if(isset($_SESSION['fee_charge']) && !empty($_SESSION['fee_charge']) && $_SESSION['fee_charge'] != 'yes'){

						if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
							if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
								$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
							}
						} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
							$woocommerce->cart->add_fee($extraCostLabel , $surcharge, false, '');
						}

					} else {

						if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
							if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
								$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
							}
						} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
							$woocommerce->cart->add_fee($extraCostLabel , $surcharge, false, '');
						}

					}					

				}
			}
		}
	}

	/**
     * Extra Cost Based On Product Category
     * -------------------------------------
     * 
     * Create Function woo_add_cart_fee_based_on_product_category
     */
	function woo_add_cart_fee_based_on_product_category() {
		global $woocommerce, $post, $wpdb;
		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * get wc_settings_extra_cost_product_cat
         */
		$cart_product_extra_cost_cat = get_option('wc_extra_cost_cart_category_product');

		if (isset($cart_product_extra_cost_cat) && !empty($cart_product_extra_cost_cat) && $cart_product_extra_cost_cat == 'yes') {

			$product_cat_array = array();

			$wc_extra_cost_based_on_category = get_option('wc_extra_cost_based_on_category');
			$wc_extra_cost_based_on_category = maybe_unserialize($wc_extra_cost_based_on_category);

			foreach ($wc_extra_cost_based_on_category as $key) {
				$product_cat_array[] = $key['extra_cost_based_product_category_name'];
			}

			$cart_product_array = $woocommerce->cart->get_cart();
			$product_title = '';
			$cart_sub_total = $woocommerce->cart->subtotal;
			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');


			foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
				$_product = $values['data'];
				$terms = get_the_terms($_product->id, 'product_cat');

				// second level loop search, in case some items have several categories

				$_categoryid = array();
				if (isset($terms) && !empty($terms)) {
					foreach ($terms as $term) {
						$_categoryid[] = $term->term_id;
					}
				}
				if (isset($_categoryid) && !empty($_categoryid)) {
					foreach ($_categoryid as $keycatid) {
						if (in_array($keycatid, $product_cat_array)) {
							$key = array_search($keycatid, $product_cat_array);
							$find_value = $wc_extra_cost_based_on_category[$key];
							$extraCostLabel = $find_value['extra_cost_based_product_category_title'];
							//get Extra cost
							//$surcharge = $find_value['extra_cost_based_product_category_amount'];


							if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
								if ($this->aec_charge_cat_product =='per') {
									$surcharge = ($cart_sub_total * $find_value['extra_cost_based_product_category_amount']) / 100 ;
								}else if ($this->aec_charge_cat_product =='fix') {
									$surcharge = $find_value['extra_cost_based_product_category_amount'];
								}
							}else {
								$surcharge = $find_value['extra_cost_based_product_amount'];
							}

							//Add Extra fee in cart page.
							if(isset($_SESSION['fee_charge']) && !empty($_SESSION['fee_charge']) && $_SESSION['fee_charge'] != 'yes'){

								if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
									if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
										$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
									}
								} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
									$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
								}

							} else {

								if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
									if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
										$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
									}
								} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
									$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
								}

							}

						}
					}//
				}
			}
		}
	}
	
	/**
     * Extra Cost Based on Product Tag
     * -------------------------------
     * 
     * Creat Function woo_add_cart_fee_based_on_product_tag
     */
	function woo_add_cart_fee_based_on_product_tag() {
		global $woocommerce, $post, $wpdb;
		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * get wc_settings_extra_cost_product_tag option
         */
		$cart_product_extra_cost_tag = get_option('wc_extra_cost_cart_tag_product');

		if (isset($cart_product_extra_cost_tag) && !empty($cart_product_extra_cost_tag) && $cart_product_extra_cost_tag == 'yes') {

			$product_tag_array = array();

			$wc_extra_cost_based_on_product_tag = get_option('wc_extra_cost_based_on_product_tag');
			$wc_extra_cost_based_on_product_tag = maybe_unserialize($wc_extra_cost_based_on_product_tag);

			$cart_sub_total = $woocommerce->cart->subtotal;
			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');


			foreach ($wc_extra_cost_based_on_product_tag as $key) {
				$product_tag_array[] = $key['extra_cost_based_product_tag_name'];
			}

			$cart_product_array = $woocommerce->cart->get_cart();
			$product_title = '';

			$_tagid = array();
			foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
				$_product = $values['data'];
				$terms = get_the_terms($_product->id, 'product_tag');
				if (isset($terms) && !empty($terms)) {
					// second level loop search, in case some items have several categories
					foreach ($terms as $term) {
						$_tagid[] = $term->term_id;
					}
				}

				if (isset($_tagid) && !empty($_tagid)) {
					foreach ($_tagid as $keytag) {
						if (in_array($keytag, $product_tag_array)) {
							$key = array_search($keytag, $product_tag_array);
							$find_value = $wc_extra_cost_based_on_product_tag[$key];
							$extraCostLabel = $find_value['extra_cost_based_product_tag_title'];
							//get Extra cost
							//$surcharge = $find_value['extra_cost_based_product_tag_amount'];

							if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
								if ($this->aec_charge_tag_product =='per') {
									$surcharge = ($cart_sub_total * $find_value['extra_cost_based_product_tag_amount']) / 100 ;
								}else if ($this->aec_charge_tag_product =='fix') {
									$surcharge = $find_value['extra_cost_based_product_tag_amount'];
								}
							}else {
								$surcharge = $find_value['extra_cost_based_product_tag_amount'];
							}



							//Add Extra fee in cart page.
							if(isset($_SESSION['under_18']) && !empty($_SESSION['under_18']) && $_SESSION['under_18'] == 'yes'){

								//Add Extra fee in cart page.
								if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
									if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
										$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
									}
								} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
									$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
								}
							}

						}
					}//
				}
			}
		}
	}

	/**
     * Extra Cost Based On Product Coupon
     * ----------------------------------
     * 
     * create function woo_add_cart_fee_based_on_product_coupon
     */
	function woo_add_cart_fee_based_on_product_coupon() {
		global $woocommerce, $post, $wpdb;
		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * get wc_settings_extra_cost_product_coupon enable or disable
         */
		$cart_product_extra_cost_coupon = get_option('wc_extra_cost_cart_coupon_product');

		$cart_sub_total = $woocommerce->cart->subtotal;
		$max_total_option_val = get_option('wc_extra_cost_max_total');
		$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');

		if (isset($cart_product_extra_cost_coupon) && !empty($cart_product_extra_cost_coupon) && $cart_product_extra_cost_coupon == 'yes') {

			$product_coupon_array = array();
			$coupon_array = isset($woocommerce->cart->coupons) ? $woocommerce->cart->coupons : array();


			$wc_extra_cost_based_on_product_coupon = get_option('wc_extra_cost_based_on_product_coupon');
			$wc_extra_cost_based_on_product_coupon = maybe_unserialize($wc_extra_cost_based_on_product_coupon);

			if (isset($wc_extra_cost_based_on_product_coupon) && !empty($wc_extra_cost_based_on_product_coupon)) {
				foreach ($wc_extra_cost_based_on_product_coupon as $key) {
					$product_coupon_array[] = $key['extra_cost_based_product_coupon_name'];
				}

				foreach ($coupon_array as $key) {
					if (in_array($key->id, $product_coupon_array)) {
						$key = array_search($key->id, $product_coupon_array);
						$find_value = $wc_extra_cost_based_on_product_coupon[$key];
						$extraCostLabel = $find_value['extra_cost_based_product_coupon_cost_title'];
						//get Extra cost
						//$surcharge = $find_value['extra_cost_based_product_coupon_amount'];


						if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
							if ($this->aec_charge_coupon_product =='per') {
								$surcharge = ($cart_sub_total * $find_value['extra_cost_based_product_coupon_amount']) / 100 ;
							}else if ($this->aec_charge_coupon_product =='fix') {
								$surcharge = $find_value['extra_cost_based_product_coupon_amount'];
							}
						}else {
							$surcharge = $find_value['extra_cost_based_product_coupon_amount'];
						}


						//Add Extra fee in cart page.
						if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
							if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
								$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
							}
						} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
							$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
						}
					}
				}
			}
		}
	}


	// Based on payment gateway
	public function woo_add_cart_fee_based_on_paymentgateway() {
		global $woocommerce, $post, $wpdb;
		if (is_admin() && !defined('DOING_AJAX'))
		return;
		/**
         * get wc_settings_extra_cost_product_tag option
         */
		$paymentgeteway_option_val = get_option('wc_extra_cost_paymentgateway');

		if (isset($paymentgeteway_option_val) && !empty($paymentgeteway_option_val) && $paymentgeteway_option_val == 'yes') {

			$wc_extra_cost_based_on_paymentgateway = array();

			$wc_extra_cost_based_on_paymentgateway = get_option('wc_extra_cost_based_on_paymentgateway');
			$wc_extra_cost_based_on_paymentgateway = maybe_unserialize($wc_extra_cost_based_on_paymentgateway);

			$cart_sub_total = $woocommerce->cart->subtotal;
			$max_total_option_val = get_option('wc_extra_cost_max_total');
			$extra_cost_cart_max_total = get_option('wc_ec_max_cart_total');
			$payment_gateway = array();

			foreach ($wc_extra_cost_based_on_paymentgateway as $key) {
				$payment_gateway[] = $key['extra_cost_based_paymentgateway_name'];
			}

			$cart_product_array = $woocommerce->cart->get_cart();
			$product_title = '';
			global $woocommerce;
			$available_gateways = $woocommerce->payment_gateways->get_available_payment_gateways();
			$current_gateway = '';
			if ( ! empty( $available_gateways ) ) {
				// Chosen Method
				if ( isset( $woocommerce->session->chosen_payment_method ) && isset( $available_gateways[ $woocommerce->session->chosen_payment_method ] ) ) {
					$current_gateway = $woocommerce->session->chosen_payment_method;
				}
			}


			if (in_array($current_gateway, $payment_gateway)) {
				$key = array_search($current_gateway, $payment_gateway);
				$find_value = $wc_extra_cost_based_on_paymentgateway[$key];
				$extraCostLabel = $find_value['extra_cost_based_paymentgateway_title'];
				//get Extra cost
				//$surcharge = $find_value['extra_cost_based_paymentgateway_amount'];

				if (isset($this->ser_aec_charge_type) && !empty($this->ser_aec_charge_type)) {
					if ($this->aec_charge_based_paymentgateway =='per') {
						$surcharge = ($cart_sub_total * $find_value['extra_cost_based_paymentgateway_amount']) / 100 ;
					}else if ($this->aec_charge_based_paymentgateway =='fix') {
						$surcharge = $find_value['extra_cost_based_paymentgateway_amount'];
					}
				}else {
					$surcharge = $find_value['extra_cost_based_paymentgateway_amount'];
				}



				//Add Extra fee in cart page.
				if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'yes') {
					if (!($cart_sub_total >= $extra_cost_cart_max_total)) {
						$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
					}
				} else if (isset($max_total_option_val) && !empty($max_total_option_val) && $max_total_option_val == 'no') {
					$woocommerce->cart->add_fee($extraCostLabel, $surcharge, false, '');
				}
			}

		}
	}
	// Based on Master setting
	public function woo_add_cart_fee_based_on_master_setting(){
		global $woocommerce, $post, $wpdb;
		$extra_cost_master_sertting = get_option('extra_cost_master_setting');
		$master_single_unit_label = get_option('extra_cost_master_single_unit_label_setting',true);
		$single_unit_label = isset($master_single_unit_label) && $master_single_unit_label != ' ' ? $master_single_unit_label : 'Extra Fee';
		if(isset($extra_cost_master_sertting) && $extra_cost_master_sertting == 'single_unit'){
			$get_fees = $woocommerce->cart->fees;
			if(!empty($get_fees)){
				$mastersum = 0;
				foreach($get_fees as $num => $values) {
				    $mastersum += $values->amount;
				     unset($woocommerce->cart->fees[$num]);
				}
			$woocommerce->cart->add_fee($single_unit_label, $mastersum, false, '');
			}
		}
		
	}	

	/**
     * BN code added
     */
	function paypal_bn_code_filter($paypal_args) {
		$paypal_args['bn'] = 'Multidots_SP';
		return $paypal_args;
	}

	public function payment_gateway_disable_country( $available_gateways) {
		global $woocommerce;

		//unset(  $available_gateways['cod'] );

		return $available_gateways;


	}



}
