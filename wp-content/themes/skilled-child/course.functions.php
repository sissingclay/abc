<?php

function setCourseSession ($data) {
  $_SESSION['courseLevel'] = $data->sessionData->back_course_level;
  $_SESSION['proc_week'] = $data->sessionData->back_courseweek;
  $_SESSION['proc_startdate'] = $data->sessionData->back_coursestartdate;

  $_SESSION['fee_charge'] = '';

  // ------------------------------

  $_SESSION['course']['back_getProductOption'] = $data->sessionData->back_getProductOption;
  $_SESSION['course']['back_productid'] = $data->sessionData->back_productid; 
  $_SESSION['course']['back_productidpop'] = $data->sessionData->back_productid;
  $_SESSION['course']['back_coursestartdate'] = $data->sessionData->back_coursestartdate;
  $_SESSION['course']['back_courseweek'] = $data->sessionData->back_courseweek;
  $_SESSION['course']['back_course_level'] = $data->sessionData->back_course_level;

  $_SESSION['ex_no'] = $data->sessionData->back_ex_student;
}

function unsetCourseSession () {
  $course = ['courseLevel', 'proc_week', 'proc_startdate', 'course', 'ex_no'];
  foreach ($course as $key) {
    unset($_SESSION[$key]);
  }
}

add_action( 'wp_ajax_get_cart_data', 'get_cart_data' );
add_action( 'wp_ajax_nopriv_get_cart_data', 'get_cart_data' );

function get_cart_data () {
  // Retrieve JSON payload
  $data = json_decode(file_get_contents('php://input'));
  wp_send_json(cart_data($data));
}

function clearWooCart ($hasProducts) {
    ini_set('html_errors', 0);
    define('SHORTINIT', true);
    global $woocommerce;
    $cart = $woocommerce->cart;
    unsetCourseSession();

    if (empty($hasProducts)) {
        $cart->empty_cart();
    } else {
        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] === intval($hasProducts)) {
                $cart->remove_cart_item($cart_item_key);
            }
        }
    }
}

function extraCost ($data) {
  global $woocommerce;
  session_start();
  
  $items = $woocommerce->cart->get_cart();
  $extraCost = array();

  foreach($items as $item => $values) {
      $term_list = wp_get_post_terms($values['product_id'], 'product_cat', array('fields'=>'ids'));
      $cat_id = (int)$term_list[0];
      $cat_name = get_cat_name ($cat_id, 'product_cat');
      $wc_extra_cost_based_on_product = get_option('wc_extra_cost_based_on_product');
      $wc_extra_cost_based_on_product = maybe_unserialize($wc_extra_cost_based_on_product);

      foreach ($wc_extra_cost_based_on_product as $key => $valProdCost) {
          if($valProdCost['extra_cost_based_product_name'] == $values['product_id'] && $cat_name == 'Courses') {
              $extraCost['courseExtras'][] = array(
                  'amount' => number_format($valProdCost['extra_cost_based_product_amount'], 2),
                  'label' => $valProdCost['extra_cost_based_product_cost_title'],
                  'prod_id' => $valProdCost['extra_cost_based_product_name']
              );
              $woocommerce->cart->add_fee($valProdCost['extra_cost_based_product_cost_title'], $valProdCost['extra_cost_based_product_amount'], false, '');
          }
      }

      $wc_extra_cost_based_on_category = get_option('wc_extra_cost_based_on_category');
      $wc_extra_cost_based_on_category = maybe_unserialize($wc_extra_cost_based_on_category);

      foreach ($wc_extra_cost_based_on_category as $keyCatCost) {
          if($keyCatCost['extra_cost_based_product_category_name'] == $cat_id && $cat_name == 'Courses') {
            if (($data->back_ex_student === 'yes' && (intval($keyCatCost['extra_cost_based_product_category_name']) !== 13)) || $data->back_ex_student === 'no' || !isset($data->back_ex_student)) {
              $extraCost['courseExtras'][] = array(
                  'amount' => number_format($keyCatCost['extra_cost_based_product_category_amount'], 2),
                  'label' => $keyCatCost['extra_cost_based_product_category_title'],
                  'cat_id' => $keyCatCost['extra_cost_based_product_category_name']
              );
              // $woocommerce->cart->add_fee($keyCatCost['extra_cost_based_product_category_title'], $keyCatCost['extra_cost_based_product_category_amount'], false, '');
            }
          }
      }
  }

  return $extraCost;
}

add_action( 'wp_ajax_set_cart_data', 'set_cart_data' );
add_action( 'wp_ajax_nopriv_set_cart_data', 'set_cart_data' );

function set_cart_data () {
    // Retrieve JSON payload
    $data = json_decode(file_get_contents('php://input'));
    session_start();

    global $woocommerce;
    // clearWooCart($data->current_course_product_id);
    setCourseSession($data);

    $product_id = $data->product_id;
	$variation_id = $data->variation_id;
	$quantity = $data->quantity;

	if ($variation_id) {
		$woocommerce->cart->add_to_cart( $product_id, $quantity, $variation_id );
	} else {
		$woocommerce->cart->add_to_cart( $product_id, $quantity);
	}

    wp_send_json( cart_data($data) );
}

function cart_data ($data) {
	ini_set('html_errors', 0);
	define('SHORTINIT', true);

    global $woocommerce;

    $info = array(
        'cart' => $woocommerce->cart->get_cart(),
        'total' => $woocommerce->cart->cart_contents_total,
        'fees' =>  extraCost($data),
        'count' => $woocommerce->cart->get_cart_contents_count(),
        'accommodationFees' => get_accommodation_extra_cart_data($data)
    );

    return $info;
}

add_action( 'wp_ajax_get_course_data', 'get_course_data' );
add_action( 'wp_ajax_nopriv_get_course_data', 'get_course_data' );

function get_course_data () {
    // Retrieve JSON payload
    $data = json_decode(file_get_contents('php://input'));
	
    ini_set('html_errors', 0);
    define('SHORTINIT', true);

    global $woocommerce;
    // $woocommerce->cart->empty_cart();

    if (!($data->get_course_data)) clearWooCart($data->get_course_data);

    $info = array(
        'weeks' => array(),
        'levels' => array(),
        'extraFess' => $woocommerce->cart->get_fees()
    );

    if ($data->product_id && $data->product_id != '') {
        $args = array('orderby' => 'term_id', 'order' => 'ASC', 'fields' => 'all');
        $weeks = wp_get_object_terms( $data->product_id, 'pa_week', $args);

        // Sort array by name
        $sortarray = array();
        foreach ($weeks as $key => $row)
        {
            $sortarray[$key] = floatval($row->slug);
        }
        array_multisort($sortarray, SORT_ASC, $weeks);
        // end

        foreach ( $weeks as $week ) {
            $info['weeks'][] = array(
                'slug' => $week->slug,
                'name' => $week->name
            );
        }


        $course_levels = wp_get_object_terms($data->product_id, 'pa_course_level');

        if(count($course_levels) >= 4){
            $tmp = $course_levels[3];
            $course_levels[3] = $course_levels[2];
            $course_levels[2] = $tmp;
        }

        foreach ( $course_levels as $course_level ) {
            $info['levels'][] = array(
                'slug' => $course_level->slug,
                'name' => $course_level->name
            );
        }
        
        wp_send_json( $info );
    }
    die;
}