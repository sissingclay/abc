<?php

function get_accommodation_zones ($data) {
    $zones = array();

    if (isset($data->product_id) && isset($data->product_id) != '') {
        $zones_arr = wp_get_object_terms( $data->product_id, 'pa_zone');
        
		if(!empty($zones_arr)) {
            function cmp($a, $b)
            {
                return strcmp($a->term_id, $b->term_id);
            }

            usort($zones_arr, "cmp");

            foreach ( $zones_arr as $zone ) {
                $zones[] = array(
                    'slug' => $zone->slug,
                    'name' => $zone->name
                );
            }
		}
    }

    return $zones;
}

add_action( 'wp_ajax_get_accommodation_variation_id', 'get_accommodation_variation_id' );
add_action( 'wp_ajax_nopriv_get_accommodation_variation_id', 'get_accommodation_variation_id' );

function get_accommodation_variation_id () {
    // Retrieve JSON payload
    $data = json_decode(file_get_contents('php://input'));
    global $wpdb;
    $variation_id = array();

    if (isset($data->acczone) && isset($data->product_id) && !isset($data->variation_id)) {
        $query = "SELECT wp_posts.ID,wp_posts.post_parent,wp_postmeta.meta_key,wp_postmeta.meta_value 
                FROM wp_postmeta LEFT JOIN wp_posts  ON wp_posts.ID = wp_postmeta.post_id 
                WHERE wp_posts.post_parent='".$data->product_id."' AND wp_posts.ID = wp_postmeta.post_id  AND wp_postmeta.meta_value='".$data->acczone."'";
        $result = $wpdb->get_results($query);
        $variation_id['variation_id'] =  intval($result[0]->ID);
    }

    wp_send_json($variation_id);
}

function get_accommodation_weeks ($data) {
    $dates = array();
    $week = $data->course->back_courseweek;
    $date = $data->course->back_coursestartdate;
    $weekNumber = explode('-', $week)[0];

    $newdate = date('d/m/Y', strtotime('last Saturday', strtotime(str_replace('/', '-', $date))));
    $nxtdate = date('d/m/Y', strtotime(''.$weekNumber.' week', strtotime(str_replace('/', '-', $newdate))));
    $date = '';

    for($i = 1; $i <= $weekNumber; $i++) {
        $date[$i] = date('d/m/Y', strtotime(''.$i.' week', strtotime(str_replace('/', '-', $newdate))));
    }

    $dates = array(
        'start' => $newdate,
        'end' => $nxtdate
    );
    
    return $dates;
}

add_action( 'wp_ajax_get_accommodation_data', 'get_accommodation_data' );
add_action( 'wp_ajax_nopriv_get_accommodation_data', 'get_accommodation_data' );

function get_accommodation_data () {
    $data = json_decode(file_get_contents('php://input'));

    $accommodation = array(
        'zones' => get_accommodation_zones($data),
        'dates' => get_accommodation_weeks($data)
    );

    wp_send_json($accommodation);
}

add_action( 'wp_ajax_get_accommodation_cart_data', 'get_accommodation_cart_data' );
add_action( 'wp_ajax_nopriv_get_accommodation_cart_data', 'get_accommodation_cart_data' );

function get_accommodation_cart_data () {
    global $woocommerce;
    $data = json_decode(file_get_contents('php://input'));

    $hello = array(
        'cart' => $woocommerce->cart->get_cart(),
        'total' => $woocommerce->cart->cart_contents_total,
        'fees' =>  extraCost($data),
        'count' => $woocommerce->cart->get_cart_contents_count(),
        'accommodationFees' => get_accommodation_extra_cart_data($data)
    );

    wp_send_json($hello);
}


add_action( 'wp_ajax_add_transportation', 'add_transportation' );
add_action( 'wp_ajax_nopriv_add_transportation', 'add_transportation' );

function add_transportation () {
    global $woocommerce;
    $data = json_decode(file_get_contents('php://input'));
    $cart = $woocommerce->cart;  
  
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
        $term_list = wp_get_post_terms($cart_item['product_id'], 'product_cat');
        $cat_slug = (int)$term_list[0]->slug;
        if ($cat_slug == '3extras') {         
            // Remove product in the cart using  cart_item_key.
            $cart->remove_cart_item($cart_item_key);
        }
    }
    
    if(woo_in_cart($data->acctransportproc_id)) {
       // echo 'inif';
	} else {
       $cart->add_to_cart($data->acctransportproc_id);
	}
}

add_action( 'wp_ajax_add_visa', 'add_visa' );
add_action( 'wp_ajax_nopriv_add_visa', 'add_visa' );

function add_visa () {
    session_start();
    global $woocommerce;
    $data = json_decode(file_get_contents('php://input'));

    $_SESSION['course']['back_productid'] = $data->course->back_productid;
    $cart = $woocommerce->cart;    
    
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
        $term_list = wp_get_post_terms($cart_item['product_id'],'product_cat');

        $cat_slug = (int)$term_list[0]->slug;
        if ($cart_item['product_id'] == '19870' || $cart_item['product_id'] == '19871') {
            $cart->remove_cart_item($cart_item_key);
        }
    }

    if (woo_in_cart($data->accvisaproc_id)) {
    } else {
        $cart->add_to_cart($data->accvisaproc_id);
   }
}


function accommodationSession () {
    session_start();
    global $session;

    $sessionInfo = array(
        'accomodation' => array(
            'back_accomdation',
            'back_meal_plan',
            'back_product_acc_zone',
            'back_accomodation_week',
            'back_acc_startdate',
            'back_acc_enddate',
            'back_acc_supplement',
            'back_smoke',
            'back_petbother',
            'back_allergies',
            'back_allergiestype',
            'back_bathroom',
            'back_transport_type',
            'back_flightname',
            'back_departuredate',
            'back_arrivaldate',
            'back_visa_require'
        ),
        'ex_no',
        'zone',
        'findingfee',
        'acc_startdate',
        'acc_enddate',
        'under_182',
        'visaextrafee'
    );

    foreach ($sessionInfo as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $k => $val) {
                pr($value);
                pr($val);
                pr($_SESSION[$value][$val]);
                $_SESSION[$value][$val] = (isset($data[$val]) && $data[$val] !== '') ? $data[$val] : '';
            }
            $_SESSION[$value] = (isset($data[$value]) && $data[$value] !== '') ? $data[$value] : '';
        }
    }
    // pr($_SESSION);
}


function get_accommodation_extra_cart_data ($data) {
    global $woocommerce, $session;
    $data = $data->accommodation;
    $items = $woocommerce->cart->get_cart();
    $accommodation = array();

    accommodationSession();
//------------------------------

    // $_SESSION['accomodation']['back_accomdation'] = $data->back_accomdation;
    // $_SESSION['accomodation']['back_meal_plan'] = $data->back_meal_plan;
    // $_SESSION['accomodation']['back_product_acc_zone'] = $data->back_product_acc_zone;
    // $_SESSION['accomodation']['back_accomodation_week'] = $data->back_accomodation_week;
    // $_SESSION['accomodation']['back_acc_startdate'] = $data->back_acc_startdate;
    // $_SESSION['accomodation']['back_acc_enddate'] = $data->back_acc_enddate;

    // // Other
    // $_SESSION['accomodation']['back_acc_supplement'] = $data->back_acc_supplement;
        
    // // }
    // $_SESSION['accomodation']['back_smoke'] = $data->back_smoke;
    // $_SESSION['accomodation']['back_petbother'] = $data->back_petbother;
    // $_SESSION['accomodation']['back_allergies'] = $data->back_allergies;
    // $_SESSION['accomodation']['back_allergiestype'] = $data->back_allergiestype;

    // // Transport
    // $_SESSION['accomodation']['back_transport_type'] = $data->back_transport_type;
    // $_SESSION['accomodation']['back_flightname'] = $data->back_flightname;
    // $_SESSION['accomodation']['back_arrivaldate'] = $data->back_arrivaldate;
    // $_SESSION['accomodation']['back_departuredate'] = $data->back_departuredate;
    // $_SESSION['visaextrafee'] = $data->visaextrafee;
    // // Visa
    // $_SESSION['accomodation']['back_visa_require'] = $data->back_visa_require;
    // $_SESSION['accomodation']['back_bathroom'] = $data->back_bathroom;

    // $_SESSION['ex_no'] = $data->ex;
    // $_SESSION['zone'] = $data->back_product_acc_zone;
    // $_SESSION['acc_startdate'] = $data->back_acc_startdate; 
    // $_SESSION['acc_enddate'] = $data->back_acc_enddate; 
    // $_SESSION['under_182'] = $data->under_18;


    //error_reporting(E_ALL);
    if (isset($data->extracharges) && isset($data->extracharges) != '') {
		$extracharges = $data->extracharges;

		if ($extracharges[0]->amount != '') {
			$_SESSION['findingfee'] = $extracharges[0]->amount;
		} else {
			$_SESSION['findingfee'] = '';
		}
        
        $getAccFees = '';
        $getAccUnder18Fees = '';
        
        /* Bh Code Starts */
        foreach($items as $cart_item_key => $values) {
			if ($values['product_id'] == '21126' || $values['product_id'] == '21194') {
				$woocommerce->cart->remove_cart_item($cart_item_key); 
                break;
			}
		}
			
        if ($data->back_accomdation == 2 || $data->back_accomdation == 3) {
			$sel_val = explode('/', $data->back_acc_startdate);
			$d = $sel_val[2] + '-12-21';
			$date = date_create($d);
			$check_date = date_format($date, 'd/m/Y');
			
			//end
			$d1 = $sel_val[2] + '-01-01';
			$date1 = date_create($d1);
			$check_date1 = date_format($date1, 'd/m/Y');
			
			$suplProdId = 21126; // For Jun, July and August
			if($data->back_acc_startdate >= $check_date && $data->back_acc_startdate <= $check_date1 ) {
				$suplProdId = 21194;
			}
			
			$suplProdQty = isset($data->acc_week) ? $data->acc_week : 1;						
			$woocommerce->cart->add_to_cart($suplProdId, $suplProdQty);
		}
        /* Bh Code ends */
        
        
        foreach($items as $item => $values) {
            $term_list = wp_get_post_terms($values['product_id'], 'product_cat', array('fields'=>'ids'));
            $cat_id = (int)$term_list[0];
            $cat_name = get_cat_name($cat_id, 'product_cat');
      
            $variation_id = $values['variation_id'];
       
            if ($variation_id) {
                $variation = wc_get_product($variation_id);
                $variation_title_pre = $variation->get_formatted_name();

                if ($cat_name == 'Accomodation') {
                    $vt = explode("&ndash;", $variation_title_pre);
       
                    $variable_product1= new WC_Product_Variation($variation_id);
                    $meta1 = get_post_meta($variation_id, 'attribute_pa_zone', true);
                    $term1 = get_term_by('slug', $meta1, 'pa_zone');
                    $proc_week = $term1->name;
                    $acc_week = $data->acc_week;
                    
                    $product_name = $vt[1];

                    $_product = new WC_Product( $values['product_id'] );
                    $proc_price = $variable_product1->regular_price;
                    $proc_price = $proc_price * $acc_week;

                    $accommodation['complex'] = array(
                        'name' => $product_name,
                        'amount' => number_format($proc_price, 2),
                        'back_product_acc_zone' => $data->back_product_acc_zone
                    );

                    $cat_name = get_cat_name ($cat_id, 'product_cat');

                    // Start custom code
                    $wc_extra_cost_based_on_category_acc = get_option('wc_extra_cost_based_on_category');
                    $wc_extra_cost_based_on_category_acc = maybe_unserialize($wc_extra_cost_based_on_category_acc);
                    $sel_val = explode('/', $data->back_acc_startdate);
                  
                    //start
                    $d = $sel_val[2] + "-12-21";
                    $date = date_create($d);
                    $check_date = date_format($date, "d/m/Y");
                    //end

                    $d1 = $sel_val[2] + "-01-01";
                    $date1 = date_create($d1);
                    $check_date1 = date_format($date1, "d/m/Y");
                    $new_arr = array();
                    $acc_week = $data->acc_week;
                        
                    if ($getAccFees != 'yes') {
                        foreach ($wc_extra_cost_based_on_category_acc as $keyCatCostAcc) { 
                            if ($keyCatCostAcc['extra_cost_based_product_category_name'] == $cat_id && $cat_name == 'Accomodation') {
                                $reg_display_amount_acc = $keyCatCostAcc['extra_cost_based_product_category_amount']; 

                                if (isset($data->visaextrafee) && !empty($data->visaextrafee) && $data->visaextrafee == 'yes' &&
                                    $keyCatCost['extra_cost_based_product_category_title'] == 'Registration fee') {
                                        $arr_extrasum += 25;
                                        $reg_display_amount_acc = $keyCatCostAcc['extra_cost_based_product_category_amount'] + 25; 
                                }

                                $accommodation['extra_cost_based_product_category_title'] = array(
                                    'name' => $keyCatCostAcc['extra_cost_based_product_category_title'],
                                    'amount' => number_format($reg_display_amount_acc, 2),
                                );
                                 
                                $arr_extrasum += $keyCatCostAcc['extra_cost_based_product_category_amount'];
                                $woocommerce->cart->add_fee($keyCatCostAcc['extra_cost_based_product_category_title'], $keyCatCostAcc['extra_cost_based_product_category_amount'], false, '');
                                $getAccFees = 'yes';
                            }
                        }
                    }

                    if (isset($data->under_18) && !empty($data->under_18) && $data->under_18 == 'yes') {
                        $_SESSION['under_18'] = "yes";
                    }  else {
                        $_SESSION['under_18'] = "no";
                    }
                }
                   
            } elseif ($cat_name == 'Duration') {
                $_product = new WC_Product( $values['product_id'] );
                $accommodation['supplement'][] = array(
                    'name' => 'Accommodation Supplement (High Season)',
                    'amount' => $woocommerce->cart->get_product_subtotal($_product, $values['quantity']),
                    'product' => $_product,
                    'quantity' => $values['quantity']
                );
            }
            
            if ($values['product_id'] == 21195) {
                $_product = new WC_Product( $values['product_id'] );
                $acc_week = $data->acc_week;
                $accommodation['supplement'][] = array(
                    'name' => 'Under 18 supplement',
                    'amount' => $woocommerce->cart->get_product_subtotal($_product, $acc_week),
                    'quantity' => $acc_week
                );
            }

			if ($values['product_id'] == 21126) {
                $_product = new WC_Product( $values['product_id'] );
                $acc_week = $data->acc_week;
                $accommodation['supplement'][] = array(
                    'name' => 'Summer supplement',
                    'amount' => $woocommerce->cart->get_product_subtotal($_product, $acc_week),
                    'quantity' => $acc_week
                );
            }
            
            if ($values['product_id'] == 21194) {
                $_product = new WC_Product( $values['product_id'] );
                $acc_week = $data->acc_week;
                $accommodation['supplement'][] = array(
                    'name' => 'Summer supplement',
                    'amount' => $woocommerce->cart->get_product_subtotal($_product, $acc_week),
                    'quantity' => $acc_week
                );
            }
            
            if ($values['product_id'] == 21133) {
                $_product = new WC_Product( $values['product_id'] );
                $acc_week = $data->acc_week;
                $accommodation['supplement'][] = array(
                    'name' => 'Private Bathroom',
                    'amount' => $woocommerce->cart->get_product_subtotal($_product, $acc_week),
                    'quantity' => $acc_week
                );
            }
        }
    }

    $i = 0;
    $price = '';

    foreach($items as $item => $values) {
        $term_list = wp_get_post_terms($values['product_id'], 'product_cat', array('fields'=>'ids'));
        $cat_id = (int)$term_list[0];
        $cat_name = get_cat_name($cat_id, 'product_cat');
        $variation_id = $values['variation_id'];

        if (!$variation_id) {
            $term_list = wp_get_post_terms($values['product_id'], 'product_cat', array('fields'=>'ids'));
            $cat_id = (int)$term_list[0];
            $cat_name = get_cat_name($cat_id, 'product_cat');

            if ($cat_name == 'Zone') {
                $_product = new WC_Product( $values['product_id'] );
                $price[$i] = $_product->get_price();
                $i++;
            } 

            // If it is Flatshare product
            if($values['data']->product_type == 'simple' && $cat_name == 'Accomodation') {
                $accommodation['simple'] = array(
                    'name' => $values['data']->post->post_title,
                    'amount' => number_format($values['line_subtotal'], 2)
                );

                // Start custom code
                $wc_extra_cost_based_on_category_acc = get_option('wc_extra_cost_based_on_category');
                $wc_extra_cost_based_on_category_acc = maybe_unserialize($wc_extra_cost_based_on_category_acc);

                foreach ($wc_extra_cost_based_on_category_acc as $keyCatCostAcc) { 
                    if($keyCatCostAcc['extra_cost_based_product_category_name'] == $cat_id && $cat_name== 'Accomodation') {
                        $reg_display_amount_acc = $keyCatCostAcc['extra_cost_based_product_category_amount'];
                        if (isset($data->visaextrafee) && !empty($data->visaextrafee) && $data->visaextrafee == 'yes' &&
                           $keyCatCost['extra_cost_based_product_category_title'] == 'Registration fee') {
                                $arr_extrasum += 25;
                                $reg_display_amount_acc = $keyCatCostAcc['extra_cost_based_product_category_amount'] + 25; 
                        }
                        
                        $accommodation['supplement'][] = array(
                            'name' => $keyCatCostAcc['extra_cost_based_product_category_title'],
                            'amount' => number_format($reg_display_amount_acc, 2)
                        );

                        $arr_extrasum += $keyCatCostAcc['extra_cost_based_product_category_amount'];
                        $woocommerce->cart->add_fee($keyCatCostAcc['extra_cost_based_product_category_title'], $keyCatCostAcc['extra_cost_based_product_category_amount'], false, '');
                    }
                }
            }
        }
    }

    if (array_sum($price) != 0) {
        $accommodation['upgrades'] = array(
            'name' => 'Accommodation Upgrades',
            'amount' => number_format(array_sum($price), 2)
        );
    }
        
    foreach($items as $item => $values) {
        $term_list = wp_get_post_terms($values['product_id'],'product_cat');
        $cat_slug = (int)$term_list[0]->slug;
        $variation_id = $values['variation_id'];

        if (!$variation_id) {
			if($cat_slug == '3extras') {
				$_product = new WC_Product( $values['product_id'] );
                $accommodation['extras'] = array(
                    'name' => $values[data]->post->post_title,
                    'amount' => number_format($_product->get_price(), 2)
                );
			}

		    if ($values['product_id'] == 19870 || $values['product_id'] == 19871) {
                if (isset($data->visaextrafee) && !empty($data->visaextrafee) && $data->visaextrafee == 'yes') {
                    $_product = new WC_Product($values['product_id']);
                    $accommodation['visa'] = array(
                        'name' => $values[data]->post->post_title,
                        'amount' => number_format($_product->get_price(), 2)
                    );
                    if ($_product->get_price() > 0) {
                        $accommodation['visa'] = array(
                            'name' => $values[data]->post->post_title,
                            'amount' => number_format($_product->get_price(), 2)
                        );
                    }
                }
            }
        }
    }

    if (!isset($data->visaextrafee) || $data->visaextrafee == 'no' || $data->visaextrafee == '') {
		$accommodation['visa'] = array();
	}

    $amount2 = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
    $amount2= $amount2 + $arr_extrasum;

    $accommodation['total'] = number_format($amount2, 2, '.', '');
    
    return $accommodation;
}
