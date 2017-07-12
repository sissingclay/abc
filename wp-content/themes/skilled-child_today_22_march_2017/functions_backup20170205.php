<?php
session_start();

function my_frontend_script() {
//wp_enqueue_script( 'my_script', get_template_directory_uri() . '/js/my_script.js', array( 'jquery' ), '1.0.0', true );
//wp_enqueue_script( 'function', plugins_url( '/js/synchandler.js',__FILE__),         array('jquery'));
wp_localize_script( 'function', 'my_ajax_script', array( 'ajaxurl' => admin_url(  'admin-ajax.php' ) ) );
}

add_action( 'wp_enqueue_scripts', 'my_frontend_script' );
add_action( 'wp_nopriv_enqueue_scripts', 'my_frontend_script' );

 	
wp_localize_script( 'my_script', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
// load your My_WC_Cart class

function print_menu_shortcode($atts, $content = null) {
    extract(shortcode_atts(array( 'name' => null, ), $atts));
    return wp_nav_menu( array( 'menu' => $name, 'echo' => false ) );
}
add_shortcode('menu', 'print_menu_shortcode');

function print_post_data($attrs){
        $uri= $_SERVER["REQUEST_URI"];
	$pieces = explode("/", $uri);
	$my_postid=$pieces[2];
	$content_post = get_post($my_postid);
	
	if($attrs["get"] == "post_name"){
	return $content_post->post_title;	
	}
	if($attrs["get"] == "post_date"){
	$date = get_the_date( "F j, Y", $my_postid );
	return $date;	
	}
	if($attrs["get"] == "post_author"){
	$author_id=$content_post->post_author;
	the_author_meta( 'user_nicename' , $author_id );
	}
	if($attrs["get"] == "post_thumbnail"){
	$arr_size = array(700,400);
	$thumbnail= get_the_post_thumbnail($my_postid, $arr_size);
	return $thumbnail;
	}
	if($attrs["get"] == "post_content"){
	$content = $content_post->post_content;
	return $content;
	}
	if($attrs["get"] == "post_category"){
	$cat_data=get_the_category($my_postid);
	return $cat_data[0]->name;
	}
	if($attrs["get"] == "recent_posts"){
	$recent_posts = wp_get_recent_posts(4);
	foreach( $recent_posts as $recent ){
		echo '<li><a href="'.site_url().'/blog-details/'.$recent["ID"].'">' .$recent["post_title"].'</a> </li> ';
	}
	}
}

add_shortcode('mypost_data', 'print_post_data');

function print_cat_data(){
	$cat_data = get_categories(array(
   	 'orderby' => 'cat_ID',
    	 'order'   => 'DESC',
	 'number'  => 4
	));
	foreach( $cat_data as $recent ){
		echo '<li><a href="'.site_url().'/category/'.$recent->cat_ID.'">' .$recent->name.'</a> </li> ';
	}
}
add_shortcode('mycategory', 'print_cat_data');
function print_posts($attrs){
        $uri= $_SERVER["REQUEST_URI"];
	$pieces = explode("/", $uri);
	$my_catid=$pieces[2];
	if($my_catid){
		$cat= $my_catid;
	}else{
		$cat= "";
	}
	$args = array( 'posts_per_page' => 12, 'offset'=> 0, 'category' => $cat );
	$myposts = get_posts( $args );
        $arr_size = array(400,200);
        $count=0;
        echo '<div class="container"><div class="row bottom30">';
        if(!(empty($myposts))){
        foreach ( $myposts as $post){
            echo '<div class="col"><div class="blog">';
            $img=get_the_post_thumbnail($post->ID, $arr_size);
            echo $img;
            if(strlen($post->post_title)>65){
            echo '<div class="blog-desc"><p>'.substr($post->post_title,0,65).'...</p><a href="'.site_url().'/blog-details/'.$post->ID.'"><button>read more</button></a></div>';
            }else{
            echo '<div class="blog-desc"><p>'.$post->post_title.'</p><a href="'.site_url().'/blog-details/'.$post->ID.'"><button>read more</button></a></div>';    
            }
            echo '</div></div>';
            $count++;
            if($count % 4 == 0){
                echo '</div>';
                echo '<div class="row bottom30">';
            }
        }}else{
            echo "No Blog Posts Available Here..";
        }
        
        echo do_shortcode('</div></div>');
        
}

add_shortcode('get_all_posts', 'print_posts');

function abcschool_change_cart_empty_button_url(){
    return site_url();
}
add_action( 'wp_ajax_show_startdate_data', 'show_startdate_data' );
add_action( 'wp_ajax_nopriv_show_startdate_data', 'show_startdate_data' );

function show_startdate_data(){
//    error_reporting(E_ALL);
//    ini_set("display_errors","1");
    global $woocommerce;
    $woocommerce->cart->empty_cart();
//    if (isset($_POST["productid"]) && isset($_POST["productid"]) != '') { 
//        $start_dates = wp_get_object_terms( $_POST["productid"], 'pa_course_startdate');
//        $datetime2 = new DateTime("now");
//        
//        echo "<select id='course_date' onchange='getcourseweek(".$_POST['productid'].")'><option>Select Start Date</option>";
//        foreach ( $start_dates as $start_date ) {
//                $date= date_parse_from_format("d/m/Y", $start_date->name);
//                $date_txt = $date[year]."-".$date[month]."-".$date[day];
//                $datetime1 = new DateTime($date_txt);
//                if($datetime1 >= $datetime2){
//                     echo "<option value=".$start_date->slug.">".$start_date->name."</option>";
//                }
//        }
//        echo "</select>";
        
        die;
//    }
}

add_action( 'wp_ajax_show_acc_zones', 'show_acc_zones' );
add_action( 'wp_ajax_nopriv_show_acc_zones', 'show_acc_zones' );

function show_acc_zones(){
    error_reporting(E_ALL);
    ini_set("display_errors","1");
    
//    print_r($_POST["productid"]);
    if (isset($_POST["productid"]) && isset($_POST["productid"]) != '') { 
        $zones_arr = wp_get_object_terms( $_POST["productid"], 'pa_zone');
       
        echo "<select id='acc_zone' name='acc_zone'><option>Accommodation Zone</option>";
        foreach ( $zones_arr as $zone ) {
               echo "<option value=".$zone->slug.">".$zone->name."</option>";
        }
        echo "</select>";
        
        die;
    }
}

add_action( 'wp_ajax_show_course_data', 'show_course_data' );
add_action( 'wp_ajax_nopriv_show_course_data', 'show_course_data' );

function show_course_data(){
    if (isset($_POST["productid"]) && isset($_POST["productid"]) != '') { 
        $course_levels = wp_get_object_terms( $_POST["productid"], 'pa_course_level');

        echo "<select id='course_level'><option>Course Level</option>";
        foreach ( $course_levels as $course_level ) {
              echo "<option value=".$course_level->slug.">".$course_level->name."</option>";
        }
        echo "</select>";
        die;
    }
}

add_action( 'wp_ajax_show_week_data', 'show_week_data' );
add_action( 'wp_ajax_nopriv_show_week_data', 'show_week_data' );

function show_week_data() {
    if (isset($_POST["week_id"]) && isset($_POST["week_id"]) != '') {
        $args = array('orderby' => 'term_id', 'order' => 'ASC', 'fields' => 'all');
        $weeks = wp_get_object_terms( $_POST["week_id"], 'pa_week', $args);
        echo "<select id='courseweek' onchange='getcourselevel(".$_POST['week_id'].")'><option>Course Length</option>";
        foreach ( $weeks as $week ) {
              echo "<option value=".$week->slug.">".$week->name."</option>";
        }
        echo "</select>";
        die;
    }
}
 
if (isset($_POST["courseweek"]) && isset($_POST["product_id"]) && !isset($_POST['variation_id'])) {
    $query = "SELECT wp_posts.ID,wp_posts.post_parent,wp_postmeta.meta_key,wp_postmeta.meta_value FROM wp_postmeta LEFT JOIN wp_posts  ON wp_posts.ID = wp_postmeta.post_id 
    WHERE wp_posts.post_parent='".$_POST['product_id']."' AND wp_posts.ID = wp_postmeta.post_id  AND wp_postmeta.meta_value='".$_POST['courseweek']."'";
    $result = $wpdb->get_results($query);
//    print_r($result);
    echo $variation_id = $result[0]->ID;
//    $arr = [];
//    $i = 0; 
//    foreach ($result as $res){
//        $arr[$i] = $res->ID;
//        $i++;
//    }
    
//    $query1 = "SELECT wp_posts.ID,wp_posts.post_parent,wp_postmeta.meta_key,wp_postmeta.meta_value FROM wp_postmeta LEFT JOIN wp_posts  ON wp_posts.ID = wp_postmeta.post_id 
//    WHERE wp_posts.post_parent='".$_POST['product_id']."' AND wp_posts.ID = wp_postmeta.post_id  AND wp_postmeta.meta_value='".$_POST['course_level']."'";
//    $results1 = $wpdb->get_results($query1);
//    
//    foreach($results1 as $result1){
//        if(in_array($result1->ID, $arr)){
//               echo $variation_id = $result1->ID;           
//        }
//    }
 die;
}

if (isset($_POST["acczone"]) && isset($_POST["product_id"]) && !isset($_POST['variation_id'])) {
    $query = "SELECT wp_posts.ID,wp_posts.post_parent,wp_postmeta.meta_key,wp_postmeta.meta_value FROM wp_postmeta LEFT JOIN wp_posts  ON wp_posts.ID = wp_postmeta.post_id 
    WHERE wp_posts.post_parent='".$_POST['product_id']."' AND wp_posts.ID = wp_postmeta.post_id  AND wp_postmeta.meta_value='".$_POST['acczone']."'";
    $result = $wpdb->get_results($query);
    echo $variation_id = $result[0]->ID;
 die;
}

add_action( 'wp_ajax_show_cart_data', 'show_cart_data' );
add_action( 'wp_ajax_nopriv_show_cart_data', 'show_cart_data' );

function show_cart_data(){
    global $woocommerce;
        $items = $woocommerce->cart->get_cart();

    if (isset($_POST["extracharges"]) && isset($_POST["extracharges"]) != '') {      
        $arr = urldecode(str_replace("\\","",$_POST['extracharges']));
        $extracharges = json_decode($arr);
        
        echo '<table>';
        foreach($items as $item => $values) { 
            $term_list = wp_get_post_terms($values['product_id'],'product_cat',array('fields'=>'ids'));
            $cat_id = (int)$term_list[0];
            $cat_name = get_cat_name ($cat_id, 'product_cat');
            $variation_id = $values['variation_id'];
            $variation = wc_get_product($variation_id);
            $variation_title_pre = $variation->get_formatted_name();
            $vt = explode("&ndash;",$variation_title_pre);
//           $meta = get_post_meta($variation_id, 'attribute_pa_course_level', true);
//           $term = get_term_by('slug', $meta, 'pa_course_level');
//           $proc_level =$term->name;
           $proc_level =$_POST["course_level"];
           $meta1 = get_post_meta($variation_id, 'attribute_pa_week', true);
           $term1 = get_term_by('slug', $meta1, 'pa_week');
           $proc_week =$term1->name;
           $proc_startdate =$_POST["start_date"];
//           $product_name = $vt[1];
           $product_name = $vt[1];
           $proc_price = $vt[3] ;
               $_SESSION['courseLevel'] = $proc_level;
               $_SESSION['proc_week'] = $proc_week;
               $_SESSION['proc_startdate'] = $proc_startdate;
            echo '<tr><td colspan="2"><div class="maincart"><div class="proc_name marbottom20 mob-padtb20"><b style="color:#32a3aa;font-size:18px;font-weight:400;">SHOPPING CART</b></td></tr>';
            echo '<tr><td colspan="2"><div class="maincart"><div class="proc_name"><b class="product-name">'.$product_name.'</b></td></tr>';
            echo '<tr><td><ul class="check-list"><li><div class="acc-supply"> Course Level: '.ucwords($proc_level).'<br/>Course Length: '.ucwords($proc_week).'<br/>Course Start Date: '.$proc_startdate.'</div></li></ul></td>';
            echo '<td class="priceright">'.$proc_price.'</td></tr>';
         
           foreach($extracharges as $extracharge){
                $p_name = explode(": ",$extracharge->name);
                $vt = explode("&ndash;",$variation_title_pre);
                $product_name = $vt[1];
                
               if($extracharge->id=='2-texts-books' && $cat_name== 'Courses'){
                   echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$extracharge->name.'&nbsp;&nbsp;</li></ul></div></td><td class="priceright" style="vertical-align:top">'.get_woocommerce_currency_symbol().''.number_format($extracharge->amount, 2, '.', '').'</td></tr>'; 
                   $arr_extrasum += $extracharge->amount;
               }
               if($extracharge->id=='registration-fee' && $cat_name== 'Courses'){
                    echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$extracharge->name.'&nbsp;&nbsp;</div></li></ul></td><td class="priceright" style="vertical-align:top">'.get_woocommerce_currency_symbol().''.number_format($extracharge->amount, 2, '.', '').'</td></tr>'; 
                    $arr_extrasum += $extracharge->amount;
               }
            }
            $amount2 = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
            $amount2= $amount2 + $arr_extrasum;
            echo '<tr><td><br></td></tr><tr class="cart-total"><td class="cart-total-padding padtb20"><b class="cart-total-custom">Total</td><td style="vertical-align:middle"><b class="cart-total-custom-amount">'.get_woocommerce_currency_symbol().''.number_format($amount2, 2, '.', '').'</b></td</tr>';
             echo '</table>';
//             echo '<img src="http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2017/01/payment-methods.png" class="pay-methods">
//		<div class="gateway">
//			<img src="http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2017/01/paypal1.png" class="">
//			<img src="http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2017/01/worldpay-1.png" class="">
//		</div>';
        }
    }
    die();
}
add_action( 'wp_ajax_remove_cart_data', 'remove_cart_data' );
add_action( 'wp_ajax_nopriv_remove_cart_data', 'remove_cart_data' );

function remove_cart_data(){
    global $woocommerce;
    $cart = $woocommerce->cart;    
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
        echo $cart_item['product_id'];
        $term_list = wp_get_post_terms($cart_item['product_id'],'product_cat',array('fields'=>'ids'));
        $cat_id = (int)$term_list[0];
        $cat_name = get_cat_name ($cat_id, 'product_cat');
        //if($cat_name == 'Courses') {         
            // Remove product in the cart using  cart_item_key.
            $cart->remove_cart_item($cart_item_key);
       // }
    }
    
}     
add_action( 'wp_ajax_remove_acc_cart_data', 'remove_acc_cart_data' );
add_action( 'wp_ajax_nopriv_remove_acc_cart_data', 'remove_acc_cart_data' );

function remove_acc_cart_data(){
    global $woocommerce;
    $cart = $woocommerce->cart;    
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
        echo $cart_item['product_id'];
//        remove_allzone_products();
        $term_list = wp_get_post_terms($cart_item['product_id'],'product_cat');
        $cat_slug = (int)$term_list[0]->slug;
//        $cat_name = get_cat_name ($cat_id, 'product_cat');
        if($cat_slug == '2accomdation' || $cat_slug == '3extras') {         
            // Remove product in the cart using  cart_item_key.
            $cart->remove_cart_item($cart_item_key);
        }
    }        
}     
add_action( 'wp_ajax_getacczone', 'getacczone' );
add_action( 'wp_ajax_nopriv_getacczone', 'getacczone' );

function getacczone() {
    if (isset($_POST["cat_id"]) && isset($_POST["cat_id"]) != '') { 
        
        global $product, $woocommerce_loop, $wc_cpdf;
        $recommended_zone = $wc_cpdf->get_value($_POST["cat_id"], 'recommended_zone');      
//        echo "<select id='acc_zone' class='selectpicker' multiple><option value=''>Accommodation Upgrades</option>";
            foreach($recommended_zone as $rem_zone){
                echo "<option value=".$rem_zone.">".get_the_title($rem_zone)."</option>";
            }
//        echo "</select>";
                 
        die;
    }
}


if (isset($_POST["product_id"]) && isset($_POST["zone_slug"]) && isset($_POST["accweek_slug"])) {
    $query = "SELECT wp_posts.ID,wp_posts.post_parent,wp_postmeta.meta_key,wp_postmeta.meta_value FROM wp_postmeta LEFT JOIN wp_posts  ON wp_posts.ID = wp_postmeta.post_id 
    WHERE wp_posts.post_parent='".$_POST['product_id']."' AND wp_posts.ID = wp_postmeta.post_id  AND wp_postmeta.meta_value='".$_POST['zone_slug']."'";
    $result = $wpdb->get_results($query);
    $arr = [];
    $i = 0; 
    foreach ($result as $res){
        $arr[$i] = $res->ID;
        $i++;
    }
    
    $query1 = "SELECT wp_posts.ID,wp_posts.post_parent,wp_postmeta.meta_key,wp_postmeta.meta_value FROM wp_postmeta LEFT JOIN wp_posts  ON wp_posts.ID = wp_postmeta.post_id 
    WHERE wp_posts.post_parent='".$_POST['product_id']."' AND wp_posts.ID = wp_postmeta.post_id  AND wp_postmeta.meta_value='".$_POST['accweek_slug']."'";
    $results1 = $wpdb->get_results($query1);
    
    foreach($results1 as $result1){
        if(in_array($result1->ID, $arr)){
               echo $variation_id = $result1->ID;           
        }
    }
 die;
}

add_action( 'wp_ajax_remove_accomadationcart_data', 'remove_accomadationcart_data' );
add_action( 'wp_ajax_nopriv_remove_accomadationcart_data', 'remove_accomadationcart_data' );

function remove_accomadationcart_data(){
       global $woocommerce;
       $cart = $woocommerce->cart;   
//       remove all zone products
//       remove_allzone_products();
       $products_ids=$_POST['add_product_id'];
//       print_r($products_ids);
       foreach ($products_ids as $value) {
           if($value!=""){
           if(woo_in_cart($value)) {
//                echo 'do nothing';
            } else {
//                echo 'Add product to cart';
                $cart->add_to_cart($value);
            } 
       }}
}    

//function remove_allzone_products(){
//    global $woocommerce;
// 
//    foreach($woocommerce->cart->get_cart() as $key => $val ) {
//        $_product = $val['data'];
//        $term_list = wp_get_post_terms($_product->id,'product_cat',array('fields'=>'ids'));
//        $cat_id = (int)$term_list[0];
//        $cat_name = get_cat_name ($cat_id, 'product_cat');
//        if($cat_name == 'Zone'){
//            // Remove product in the cart using  cart_item_key.
//            $woocommerce->cart->remove_cart_item($key);
////            echo "All zone products removed";
//        }
//    }
//}

function woo_in_cart($product_id) {
    global $woocommerce;
    foreach($woocommerce->cart->get_cart() as $key => $val ) {
        $_product = $val['data'];
 
        if($product_id == $_product->id ) {
            return true;
        }
    }
 
    return false;
}
add_action( 'wp_ajax_add_accdata', 'add_accdata' );
add_action( 'wp_ajax_nopriv_add_accdata', 'add_accdata' );

function add_accdata(){
    if(isset($_POST['accproc_id']) && isset($_POST['week_id']) && $_POST['accproc_id']!= ""){
        global $woocommerce;
        $cart = $woocommerce->cart;  
        $cart->add_to_cart($_POST['accproc_id'],$_POST['week_id']);
//        if($_POST['week_id']>=2){
//            $cart->add_to_cart(16976,2);
//        } else {
//            $cart->add_to_cart(16976);
//        }
    }
}
add_action( 'wp_ajax_add_transportdata', 'add_transportdata' );
add_action( 'wp_ajax_nopriv_add_transportdata', 'add_transportdata' );

function add_transportdata(){
    global $woocommerce;
    $cart = $woocommerce->cart;    
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
//        echo $cart_item['product_id'];
        $term_list = wp_get_post_terms($cart_item['product_id'],'product_cat');
//        print_r($term_list);
        $cat_slug = (int)$term_list[0]->slug;
//        $cat_name = get_cat_name ($cat_slug, 'product_cat');
//        echo $cat_slug;
        if($cat_slug == '3extras') {         
            // Remove product in the cart using  cart_item_key.
//            echo "in if";
            $cart->remove_cart_item($cart_item_key);
        }
    }  
    if(woo_in_cart($_POST['acctransportproc_id'])) {
       // echo 'inif';
   } else {
       //   echo 'inelse';
       $cart->add_to_cart($_POST['acctransportproc_id']);
   }
}
add_action( 'wp_ajax_remove_extracart_data', 'remove_extracart_data' );
add_action( 'wp_ajax_nopriv_remove_extracart_data', 'remove_extracart_data' );

function remove_extracart_data(){
    global $woocommerce;
    $cart = $woocommerce->cart;    
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item){
        echo $cart_item['product_id'];
        $term_list = wp_get_post_terms($cart_item['product_id'],'product_cat',array('fields'=>'ids'));
        $cat_id = (int)$term_list[0];
        echo 'cat_name'.$cat_name = get_cat_name ($cat_id, 'product_cat');
        if($cat_name == 'Extras') {         
            // Remove product in the cart using  cart_item_key.
            $cart->remove_cart_item($cart_item_key);
        }
    }        
}    

add_action( 'wp_ajax_show_acc_cart_data', 'show_acc_cart_data' );
add_action( 'wp_ajax_nopriv_show_acc_cart_data', 'show_acc_cart_data' );

function show_acc_cart_data(){
    global $woocommerce;
    error_reporting(E_ALL);
    if (isset($_POST["extracharges"]) && isset($_POST["extracharges"]) != '') {      
     
        $arr = urldecode(str_replace("\\","",$_POST['extracharges']));
        $extracharges = json_decode($arr);
    
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        
        echo '<table>';
        foreach($items as $item => $values) { 
            
        $term_list = wp_get_post_terms($values['product_id'],'product_cat',array('fields'=>'ids'));
        $cat_id = (int)$term_list[0];
        $cat_name = get_cat_name ($cat_id, 'product_cat');
      
            $variation_id = $values['variation_id'];
            if($variation_id){
                $variation = wc_get_product($variation_id);
                $variation_title_pre = $variation->get_formatted_name();
                
                if($cat_name=="Courses"){
                $vt = explode("&ndash;",$variation_title_pre);
//               $meta = get_post_meta($variation_id, 'attribute_pa_course_level', true);
//               $term = get_term_by('slug', $meta, 'pa_course_level');
//               $proc_level =$term->name;
               $proc_level =$_POST["course_level"];
               $meta1 = get_post_meta($variation_id, 'attribute_pa_week', true);
               $term1 = get_term_by('slug', $meta1, 'pa_week');
               $proc_week =$term1->name;
               
               $proc_startdate =$_POST["coursestartdate"];
               $product_name = $vt[1];
               $proc_price = $vt[3] ;
               
               
               
                echo '<tr><td colspan="2"><div class="maincart"><div class="proc_name marbottom20 mob-padtb20"><h3 style="color:#32a3aa;font-size:18px;">SHOPPING CART</h3></td></tr>';
                echo '<tr><td colspan="2"><div class="maincart"><div class="proc_name"><b>'.$product_name.'</b></td></tr>';
                echo '<tr><td><ul class="check-list"><li><div class="acc-supply"> Course Level: '.ucwords($proc_level).'<br/>Course Length: '.ucwords($proc_week).'<br/>Course Start Date: '.$proc_startdate.'</div></li></ul></td>';
                echo '<td class="priceright">'.$proc_price.'</td></tr>';
                
                $cat_name = get_cat_name ($cat_id, 'product_cat');
                    foreach($extracharges as $extracharge){
                         $p_name = explode(": ",$extracharge->name);
                         $vt = explode("&ndash;",$variation_title_pre);
                         $product_name = $vt[1];
                         
                        if($extracharge->id=='2-texts-books' && $cat_name == 'Courses'){
                            $arr_extrasum += $extracharge->amount;
//                         echo " ==>".$arr_extrasum;
                            echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$extracharge->name.'&nbsp;&nbsp;</li></ul></div></td><td class="priceright">'.get_woocommerce_currency_symbol().''.number_format($extracharge->amount, 2, '.', '').'</td></tr>'; 
                        }
                        if($extracharge->id=='registration-fee' && $cat_name == 'Courses'){
                            $arr_extrasum += $extracharge->amount;
//                         echo " ==>".$arr_extrasum;
                            echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$extracharge->name.'&nbsp;&nbsp;</div></li></ul></td><td class="priceright">'.get_woocommerce_currency_symbol().''.number_format($extracharge->amount, 2, '.', '').'</td></tr>'; 
                        }
                        
                    }
                }
                if($cat_name == 'Accomodation'){
                    $vt = explode("&ndash;",$variation_title_pre);
        //               $meta = get_post_meta($variation_id, 'attribute_pa_course_level', true);
        //               $term = get_term_by('slug', $meta, 'pa_course_level');
        //               $proc_level =$term->name;
//                       $proc_level =$_POST["course_level"];
                       $variable_product1= new WC_Product_Variation( $variation_id );
                       $meta1 = get_post_meta($variation_id, 'attribute_pa_zone', true);
                       $term1 = get_term_by('slug', $meta1, 'pa_zone');
                       $proc_week =$term1->name;
//                       print_r($vt);
                       $acc_week =$_POST["acc_week"];
                       $product_name = $vt[1];
//                       $proc_price = $vt[3];
                       $_product = new WC_Product( $values['product_id'] );
                       $proc_price = $variable_product1->regular_price;
                       $proc_price = $proc_price * $acc_week;
                        echo '<tr><td colspan="2"><div class="maincart"><div class="proc_name"><b>Accommodation</b></td></tr>';
                        echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$product_name.'</div></li></ul></td>';
//                        echo '<tr><td><ul class="check-list"><li><div class="acc-supply"> Course Level: '.ucwords($proc_level).'<br/>Course Length: '.ucwords($proc_week).'<br/>Course Start Date: '.$proc_startdate.'</div></li></ul></td>';
                        echo '<td class="priceright">'.get_woocommerce_currency_symbol().''.$proc_price.'</td></tr>';
                        $cat_name = get_cat_name ($cat_id, 'product_cat');
                    foreach($extracharges as $extracharge){
                         $p_name = explode(": ",$extracharge->name);
                         $vt = explode("&ndash;",$variation_title_pre);
                         $product_name = $vt[1];
                         
                        
                        if($extracharge->id=='finding-fee' && $cat_name== 'Accomodation'){
                            $arr_extrasum += $extracharge->amount;
//                            echo " ==>".$arr_extrasum;
                            echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$extracharge->name.'&nbsp;&nbsp;</div></li></ul></td><td class="priceright">'.get_woocommerce_currency_symbol().''.number_format($extracharge->amount, 2, '.', '').'</td></tr>'; 
                        }
                    }
                }
                
                   
            }
//            else{
//                
//                $term_list = wp_get_post_terms($values['product_id'],'product_cat',array('fields'=>'ids'));
//                $cat_id = (int)$term_list[0];
//                $cat_name = get_cat_name ($cat_id, 'product_cat');
//                if($cat_name == 'Accomodation'){
//                
//                    $_product = new WC_Product( $values['product_id'] );                           
//                    echo '<tr><td><div class="maincart"><div class="proc_name martop-acc"><b>Accommodation</b></div></td></tr>';
//                    echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$_product->post->post_title.'</div></li></ul></td>';
//                    echo '<td class="priceright" style="vertical-align:top">'.WC()->cart->get_product_subtotal( $_product, $values['quantity']).'</td></tr>';
//                    
//                    foreach($extracharges as $extracharge){
//                         $p_name = explode(": ",$extracharge->name);                       
//                        if($extracharge->id=='finding-fee' && $cat_name== 'Accomodation'){
//                            echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$extracharge->name.'&nbsp;&nbsp;</div></li></ul></td><td class="priceright">'.get_woocommerce_currency_symbol().''.number_format($extracharge->amount, 2, '.', '').'</td></tr>'; 
//                        }
//                    }
//                }
                elseif($cat_name == 'Duration'){
                    $_product = new WC_Product( $values['product_id'] );
                    echo '<tr><td><ul class="check-list"><li><div class="acc-supply">Accommodation Supplement (High Season)</div></li></ul></td>';
                    echo '<td class="priceright" style="vertical-align:top">'.WC()->cart->get_product_subtotal( $_product, $values['quantity']).'</td></tr>';
                }
            }
        }
        $i=0;
        $price='';
        foreach($items as $item => $values) { 
        $term_list = wp_get_post_terms($values['product_id'],'product_cat',array('fields'=>'ids'));
        $cat_id = (int)$term_list[0];
        $cat_name = get_cat_name ($cat_id, 'product_cat');
            $variation_id = $values['variation_id'];
             if(!$variation_id){
                $term_list = wp_get_post_terms($values['product_id'],'product_cat',array('fields'=>'ids'));
                $cat_id = (int)$term_list[0];
                $cat_name = get_cat_name ($cat_id, 'product_cat');
                if($cat_name == 'Zone'){
                    $_product = new WC_Product( $values['product_id'] );
                    $price[$i]= $_product->get_price();
                     $i++;
                } 
            }   
        }
      
        if(array_sum($price) != 0){
          echo '<tr><td><ul class="check-list"><li><div class="acc-supply">Accommodation Upgrades</div></li></ul></td>';
          echo '<td class="priceright" style="vertical-align:top">'.get_woocommerce_currency_symbol().''.number_format(array_sum($price), 2, '.', '').'</td></tr>';
        }
        
        foreach($items as $item => $values) { 
        $term_list = wp_get_post_terms($values['product_id'],'product_cat');
        $cat_slug = (int)$term_list[0]->slug;
//        $cat_name = get_cat_name ($cat_id, 'product_cat');
        $variation_id = $values['variation_id'];
             if(!$variation_id){
                 if($cat_slug == '3extras'){
                     $_product = new WC_Product( $values['product_id'] );
//                     echo "<pre>";
//                     print_r($values[data]->post->post_title);
                    echo '<tr><td><div class="maincart"><div class="proc_name martop-acc"><b>Extras</b></div></td>';
                    echo '<tr><td><ul class="check-list"><li><div class="acc-supply">'.$values[data]->post->post_title.'</div></li></ul></td>';
                    echo '<td class="priceright" style="vertical-align:top">'.get_woocommerce_currency_symbol().''.number_format($_product->get_price(), 2, '.', '').'</td></tr>';
                  }  
            }  
        }
         $amount2 = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
//         echo " amount".$amount2;
         $amount2= $amount2 + $arr_extrasum;
//         echo " extra cost ".$amount2;
		
         echo '<tr><td><br></td></tr><tr class="cart-total"><td class="cart-total-padding padtb20"><b class="cart-total-custom">Total</td><td style="vertical-align:middle"><b class="cart-total-custom-amount">'.get_woocommerce_currency_symbol().''.number_format($amount2, 2, '.', '').'</b></td</tr>';
         echo '</table>';
		
//		echo '<img src="http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2017/01/payment-methods.png" class="pay-methods">
//		<div class="gateway">
//			<img src="http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2017/01/paypal1.png" class="">
//			<img src="http://wordpress-9522-31986-161247.cloudwaysapps.com/wp-content/uploads/2017/01/worldpay-1.png" class="">
//		</div>';
        
    
    die();
}



// To add custom data above add to cart button in woocommerce
// step 1

add_action('wp_ajax_wdm_add_user_custom_data_options', 'wdm_add_user_custom_data_options_callback');
add_action('wp_ajax_nopriv_wdm_add_user_custom_data_options', 'wdm_add_user_custom_data_options_callback');

function wdm_add_user_custom_data_options_callback()
{  
    //Custom data - Sent Via AJAX post method
//    print_r($_POST);
    $product_id = $_POST['product_id']; //This is product ID
    $flightname = $_POST['flightname']; //This is User custom value sent via AJAX
    $arrivaldate = $_POST['arrivaldate'];
    $departuredate = $_POST['departuredate'];
    $smoke = $_POST['smoke'];
    $petbother = $_POST['petbother'];
    $allergiestype = $_POST['allergiestype'];
    
    session_start();
    $_SESSION['product_id'] = $product_id;
    $_SESSION['flightname'] = $flightname;
    $_SESSION['arrivaldate'] = $arrivaldate;
    $_SESSION['departuredate'] = $departuredate;
    $_SESSION['smoke'] = $smoke;
    $_SESSION['petbother'] = $petbother;
    $_SESSION['allergiestype'] = $allergiestype;

    die();
}
function get_product_category_by_id( $product_id ) {
    $term_list = wp_get_post_terms($product_id, 'product_cat');
//    print_r($term_list[0]->name);die;
    return $term_list[0]->name;
}
// step 2
add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',1,2);
if(!function_exists('wdm_add_item_data'))
{
//    error_reporting(E_ALL);
   
    function wdm_add_item_data($cart_item_data,$product_id)
    {
        /*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/
        global $woocommerce;
        session_start();
        
        $cat = get_product_category_by_id($product_id);
        if($cat == "Courses"){
        $new_value = array();
        
        if (isset($_SESSION['product_id'])) {
            $option1 = $_SESSION['product_id'];
            $new_value['product_id'] =  $option1;
        }
        if (isset($_SESSION['flightname'])) {
            $option2 = $_SESSION['flightname'];
            $new_value['flightname'] =  $option2;
        }
        if (isset($_SESSION['arrivaldate'])) {
            $option3 = $_SESSION['arrivaldate'];
            $new_value['arrivaldate'] =  $option3;
        }
        if (isset($_SESSION['departuredate'])) {
            $option4 = $_SESSION['departuredate'];
            $new_value['departuredate'] =  $option4;
        }
        if (isset($_SESSION['smoke'])) {
            $option5 = $_SESSION['smoke'];
            $new_value['smoke'] =  $option5;
        }
        if (isset($_SESSION['petbother'])) {
            $option6 = $_SESSION['petbother'];
            $new_value['petbother'] =  $option6;
        }
  
        if (isset($_SESSION['allergiestype'])) {
            $option7 = $_SESSION['allergiestype'];
            $new_value['allergiestype'] =  $option7;
        }
        
//        print_r($_SESSION);
        if( empty($option1) && empty($option2) && empty($option3) && empty($option4) && empty($option5) && empty($option6))
        { 
        return $cart_item_data;}
        else
        {    
            if(empty($cart_item_data))
            {
                return $new_value;}
            else{
            return array_merge($cart_item_data,$new_value);}
        }
//        die();
        unset($_SESSION['product_id']);
        unset($_SESSION['flightname']);
        unset($_SESSION['arrivaldate']);
        unset($_SESSION['departuredate']);
        unset($_SESSION['smoke']);
        unset($_SESSION['petbother']);
        unset($_SESSION['allergiestype']);
        //Unset our custom session variable, as it is no longer needed.
    }
    
}
}
// step 3
add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 1, 3 );
if(!function_exists('wdm_get_cart_items_from_session'))
{
    function wdm_get_cart_items_from_session($item,$values,$key)
    { 
        if (array_key_exists( 'product_id', $values ) )
        {
            $item['product_id'] = $values['product_id'];
        }
        if (array_key_exists( 'flightname', $values ) )
        {
            $item['flightname'] = $values['flightname'];
        }
        if (array_key_exists( 'arrivaldate', $values ) )
        {
            $item['arrivaldate'] = $values['arrivaldate'];
        }
        if (array_key_exists( 'departuredate', $values ) )
        {
            $item['departuredate'] = $values['departuredate'];
        }
        if (array_key_exists( 'smoke', $values ) )
        {
            $item['smoke'] = $values['smoke'];
        }
        if (array_key_exists( 'allergiestype', $values ) )
        {
            $item['allergiestype'] = $values['allergiestype'];
        }
        
        return $item;
    }
}

// step 4
add_filter('woocommerce_checkout_cart_item_quantity','wdm_add_user_custom_option_from_session_into_cart',1,3);
add_filter('woocommerce_cart_item_price','wdm_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('wdm_add_user_custom_option_from_session_into_cart'))
{
    function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {
        /*code to add custom data on Cart & checkout Page*/
//        error_reporting(E_ALL);
//        echo "<pre>==>";
//                print_r($values);
        $cat = get_product_category_by_id($values['product_id']);
//        echo "cat==>".$cat;
        if(count($values['product_id']) > 0 && $cat == "Courses")
        {
            $return_string = $product_name . "</a><dl class='variation'>";
            $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
            $return_string .= "<tr><td> flightname : " . $values['flightname'] . "</td></tr>";
            $return_string .= "<tr><td> arrivaldate : " . $values['arrivaldate'] . "</td></tr>";
            $return_string .= "<tr><td> departuredate : " . $values['departuredate'] . "</td></tr>";
            $return_string .= "<tr><td> smoke : " . $values['smoke'] . "</td></tr>";
            $return_string .= "<tr><td> allergiestype : " . $values['allergiestype'] . "</td></tr>";
            $return_string .= "</table></dl>";
            
            return $return_string;
        }
        else
        {
            return $product_name;
        }
    }
}

// step 5
add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
add_action('woocommerce_nopriv_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta'))
{
    function wdm_add_values_to_order_item_meta($item_id, $values)
    {
        global $woocommerce,$wpdb;
        
        $user_custom_values = $values['wdm_user_custom_data_value'];
        if(!empty($user_custom_values))
        {
            wc_add_order_item_meta($item_id,'wdm_user_custom_data',$user_custom_values);
        }
        
        $product_id = $values['product_id'];
        if(!empty($product_id))
        {
            wc_add_order_item_meta($item_id,'product_id',$product_id);
        }
        
        $flightname= $values['flightname'];
        if(!empty($flightname))
        {
            wc_add_order_item_meta($item_id,'flightname',$flightname);
        }
        
        $arrivaldate = $values['arrivaldate'];
        if(!empty($arrivaldate))
        {
            wc_add_order_item_meta($item_id,'arrivaldate',$arrivaldate);
        }
        
        $departuredate = $values['departuredate'];
        if(!empty($departuredate))
        {
            wc_add_order_item_meta($item_id,'departuredate',$departuredate);
        }
        
        $smoke = $values['smoke'];
        if(!empty($smoke))
        {
            wc_add_order_item_meta($item_id,'smoke',$smoke);
        }
        
        $allergiestype = $values['allergiestype'];
        if(!empty($allergiestype))
        {
            wc_add_order_item_meta($item_id,'allergiestype',$allergiestype);
        }
        
        
    }
}
// step 6
add_action('woocommerce_before_cart_item_quantity_zero','wdm_remove_user_custom_data_options_from_cart',1,1);
add_action('woocommerce_nopriv_before_cart_item_quantity_zero','wdm_remove_user_custom_data_options_from_cart',1,1);

if(!function_exists('wdm_remove_user_custom_data_options_from_cart'))
{
    function wdm_remove_user_custom_data_options_from_cart($cart_item_key)
    {
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values)
        {
            if ( $values['wdm_user_custom_data_value'] == $cart_item_key )
                unset( $woocommerce->cart->cart_contents[ $key ] );
        }
    }
}

 // Hook in
//add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields');
// Our hooked in function – $fields is passed via the filter!
//function custom_override_checkout_fields( $fields ) {
//$fields['billing']['billing_first_name']['placeholder'] = '* First Name';
//$fields['billing']['billing_first_name']['label'] = '';
//
//$fields['billing']['billing_last_name']['placeholder'] = '* Last Name';
//$fields['billing']['billing_last_name']['label'] = '';
//
//$fields['billing']['billing_email']['placeholder'] = '* Email Address';
//$fields['billing']['billing_email']['label'] = '';
//
//$fields['billing']['billing_phone']['placeholder'] = '* Phone Number';
//$fields['billing']['billing_phone']['label'] = '';
//
//$fields['billing']['billing_country']['placeholder'] = '* Nationality';
//$fields['billing']['billing_country']['label'] = '';
//
//$fields['billing']['billing_city']['placeholder'] = '* billing_city';
//$fields['billing']['billing_city']['label'] = '';
//$fields['billing']['billing_city']['class'] = array('form-row-first');
//
//return $fields;
//}
//
////global array to reposition the elements to display as you want (e.g. kept 'title' before 'first_name' )
//    $wdm_address_fields = array( 
//            'title', //new field
//            'first_name',
//            'last_name',
//            'gender',
//            'nationality',
//            'dateofbirth',
//            'passportnumber',         
//            'address_1',
//            'address_2',
//            'city',
//           // 'state',
//            //postcode
//            'postcode_bill',
//            'country',
//            'email',
//            'phone',
//           //'company',
//            'emperson_relation',
//            'emfirst_name',
//            'emlast_name',
//            'emaddress_1',
//            'emaddress_2',
//            'emcity',
//            'empostcode',
//            'ememail',
//            'emphone',
//            'howtohear',
//            'liketoapply',
//            'accepttemsandcon'
//           );
//
///*global array only for extra fields
//    $wdm_ext_fields = array('title',
//            'address_3',
//            'address_4');*/
//    
//    
//     add_filter( 'woocommerce_default_address_fields' , 'wdm_override_default_address_fields' );
//
//     function wdm_override_default_address_fields( $address_fields ){
//    
//     $temp_fields = array();
//
//    $address_fields['title'] = array(
//    'label'     => __('', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-wide'),
//    'type'  => 'select',
//    'options'   => array('' => __('* Title', 'woocommerce'),'Mr' => __('Mr', 'woocommerce'), 'Mrs' => __('Mrs', 'woocommerce'), 'Miss' => __('Miss', 'woocommerce'))
//     );
//    
//    $address_fields['gender'] = array(
//    'label'     => __('', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-wide'),
//    'type'  => 'radio',
//    'options'   => array('Male' => __('Male', 'woocommerce'), 'Female' => __('Female', 'woocommerce'))
//     );
//    
//    $address_fields['nationality'] = array(
//    'label'     => __('', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-wide'),
//    'type'  => 'select',
//    'options'   => array('' => __('* Nationality', 'woocommerce'),'Indian' => __('Indian', 'woocommerce'), 'US' => __('US', 'woocommerce'), 'China' => __('China', 'woocommerce'))
//     );
//    
//    $address_fields['dateofbirth'] = array(
//    'label'     => __('', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-first'),
//    'type'  => 'text',
//    'placeholder'=> '* Date of Birth',
//     );
//    
//    $address_fields['passportnumber'] = array(
//    'label'     => __('', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-last'),
//    'type'  => 'text',
//    'placeholder'=> '* Passport Number',
//     );   
//    
//    $address_fields['postcode_bill'] = array(
//    'label'     => __('', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-last'),
//    'type'  => 'text',
//    'placeholder'=> '* Postcode',
//     ); 
//    
//    $address_fields['address_1'] = array(
//    'label'     => __('CONTACT DETAILS', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-wide'),
//    'type'  => 'text',
//    'placeholder'=> '* Address Line 1',
//     );
//      
//    $address_fields['address_2'] = array(
//    'label'     => __('', 'woocommerce'),
////    'required'  => false,
//    'class'     => array('form-row-wide'),
//    'type'  => 'text',
//    'placeholder'=> '* Address Line 2',
//     );    
//    
//    $address_fields['emperson_relation'] = array(
//    'label'     => __('EMERGENCY CONTACT DETAILS', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-wide'),
//    'type'  => 'select',
//    'options'   => array('' => __('* How is this person related to you?', 'woocommerce'),'Friend' => __('Friend', 'woocommerce'), 'Family' => __('Family', 'woocommerce'))
//     );
//       
//    $address_fields['emfirst_name'] = array(
//    'label' => __('', 'woocommerce'),
//    'placeholder'=> '* First Name',
////    'required'  => true,
//    'class'     => array('form-row-first', 'address-field'),
//    'type'  => 'text'
//     );
//    
//    $address_fields['emlast_name'] = array(
//    'label' => __('', 'woocommerce'),
//    'placeholder'=> '* Last Name',
////    'required'  => true,
//    'class'     => array('form-row-last', 'address-field'),
//    'type'  => 'text'
//     );
//           
//    $address_fields['emaddress_1']['placeholder'] = '* Address Line 1';
//    $address_fields['emaddress_1']['label'] = __('', 'woocommerce');
//    
//    $address_fields['emaddress_2']['placeholder'] = 'Address Line 2';
//    $address_fields['emaddress_2']['label'] = __('', 'woocommerce');
//    
//    $address_fields['emcity'] = array(
//    'label' => __('', 'woocommerce'),
//    'placeholder'=> '* City',
////    'required'  => true,
//    'class'     => array('form-row-first', 'address-field'),
//    'type'  => 'text'
//     );
//    
//    $address_fields['empostcode'] = array(
//    'label' => __('', 'woocommerce'),
//    'placeholder'=> '* Postcode',
////    'required'  => true,
//    'class'     => array('form-row-last', 'address-field'),
//    'type'  => 'text'
//     );
//    $address_fields['ememail'] = array(
//    'label' => __('', 'woocommerce'),
//    'placeholder'=> '* Email',
////    'required'  => true,
//    'class'     => array('form-row-first', 'address-field'),
//    'type'  => 'text'
//     );
//    
//    $address_fields['emphone'] = array(
//    'label' => __('', 'woocommerce'),
//    'placeholder'=> '* Phone Number;',
////    'required'  => true,
//    'class'     => array('form-row-last', 'address-field'),
//    'type'  => 'text'
//     );
//    
//    $address_fields['howtohear'] = array(
//    'label'     => __('EXTRAS', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-wide'),
//    'type'  => 'select',
//    'options'   => array('' => __('* How did you hear about us?', 'woocommerce'),'Friend' => __('Friend', 'woocommerce'), 'Family' => __('Family', 'woocommerce'))
//     );
//    
//    
//    $address_fields['liketoapply'] = array(
//    'label'     => __('', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-wide'),
//    'type'  => 'select',
//    'options'   => array('' => __('* I woult like to apply for...?', 'woocommerce'),'Friend' => __('Friend', 'woocommerce'), 'Family' => __('Family', 'woocommerce'))
//     );
//    
//    $address_fields['accepttemsandcon'] = array(
//    'label'     => __('I have read,understand and accept the <a style="color:#32a3aa;" href="'.site_url().'/terms-conditions" target="_blank">Terms and Conditions</a> of ABC School of English.', 'woocommerce'),
////    'required'  => true,
//    'class'     => array('form-row-wide'),
//    'type'  => 'checkbox',
//     );
//    
//    global $wdm_address_fields;
//
//    foreach($wdm_address_fields as $fky){       
//    $temp_fields[$fky] = $address_fields[$fky];
//    }
//    
//    $address_fields = $temp_fields;
//    
//    return $address_fields;
//}

//Concatenate Fields for order page
//add_filter('woocommerce_formatted_address_replacements', 'wdm_formatted_address_replacements', 99, 2);
//
//    function wdm_formatted_address_replacements( $address, $args ){
//
//    $address['{name}'] = $args['title']." ".$args['first_name']." ".$args['last_name']; //show title along with name
//    $address['{address_1}'] = $args['address_1']."\r\n".$args['address_2']; //reposition to display as it should be
////    $address['{address_2}'] = $args['address_3']."\r\n".$args['address_4']; //reposition to display as it should be
//    
//    return $address;
//} 
//
////Display Custom Fields on Order Page
//add_filter( 'woocommerce_order_formatted_billing_address', 'wdm_update_formatted_billing_address', 99, 2);
//
//function wdm_update_formatted_billing_address( $address, $obj ){
//
//    global $wdm_address_fields;
//         
//    if(is_array($wdm_address_fields)){
//        
//        foreach($wdm_address_fields as $waf){
//            $address[$waf] = $obj->{'billing_'.$waf};
//        }
//    }
//         
//    return $address;    
//}
//
//add_filter( 'woocommerce_order_formatted_shipping_address', 'wdm_update_formatted_shipping_address', 99, 2);
//
//function wdm_update_formatted_shipping_address( $address, $obj ){
//
//    global $wdm_address_fields;
//         
//    if(is_array($wdm_address_fields)){
//        
//        foreach($wdm_address_fields as $waf){
//            $address[$waf] = $obj->{'shipping_'.$waf};
//        }
//    }   
//    
//    return $address;    
//}
//
//
////Display fields on Account Page
//add_filter('woocommerce_my_account_my_address_formatted_address', 'wdm_my_account_address_formatted_address', 99, 3);
//
//function wdm_my_account_address_formatted_address( $address, $customer_id, $name ){
//    
//    global $wdm_address_fields;
//    
//    if(is_array($wdm_address_fields)){
//        
//        foreach($wdm_address_fields as $waf){
//            $address[$waf] = get_user_meta( $customer_id, $name.'_'.$waf, true );
//        }
//    }
//    
//    return $address;
//}


// alter the subscriptions error
//add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');
//add_action('woocommerce_nopriv_checkout_process', 'my_custom_checkout_field_process');
//
//function my_custom_checkout_field_process() {
//    // Check if set, if its not set add an error.
//    if ( ! $_POST['billing_title'] )
//        wc_add_notice( __( 'Title is required field' ), 'error' );
//    if ( ! $_POST['billing_first_name'] )
//        wc_add_notice( __( 'First Name is required field' ), 'error' );
//    if ( ! $_POST['billing_last_name'] )
//        wc_add_notice( __( 'Last Name is required field' ), 'error');
//    if ( ! $_POST['billing_gender'] )
//        wc_add_notice( __( 'Billing Gender is required field'), 'error');
//    if ( ! $_POST['billing_nationality'] )
//        wc_add_notice( __( 'Billing Nationality is required field'), 'error');
//    if ( ! $_POST['billing_last_name'] )
//        wc_add_notice( __( 'Last Name is required field' ), 'error');
//    if ( ! $_POST['billing_dateofbirth'] )
//        wc_add_notice( __( 'Date Of Birth is required field' ), 'error');
//    if ( ! $_POST['billing_passportnumber'] )
//        wc_add_notice( __( 'Passport Number is required field' ), 'error');
//    if ( ! $_POST['billing_address_1'] )
//        wc_add_notice( __( 'Address Line 1 is required field' ), 'error');
//    if ( ! $_POST['billing_city'] )
//        wc_add_notice( __( 'Billing City is required field' ), 'error');
//    if ( ! $_POST['billing_postcode_bill'] )
//        wc_add_notice( __( 'Postcode is required field' ), 'error');
//    if ( ! $_POST['billing_email'] )
//        wc_add_notice( __( 'Email Address is required field' ), 'error');
//    if ( ! $_POST['billing_phone'] )
//        wc_add_notice( __( 'Phone Number is required field ' ), 'error');
//    if ( ! $_POST['billing_emperson_relation'] )
//        wc_add_notice( __( 'Person Relation is required field ' ), 'error');
//    if ( ! $_POST['billing_emfirst_name'] )
//        wc_add_notice( __( 'Emergancy First Name is required field ' ), 'error');
//    if ( ! $_POST['billing_emlast_name'] )
//        wc_add_notice( __( 'Emergancy Last Name is required field ' ), 'error');
//    if ( ! $_POST['billing_emaddress_1'] )
//        wc_add_notice( __( 'Emergancy  Address Line 1 is required field ' ), 'error');
//    if ( ! $_POST['billing_emcity'] )
//        wc_add_notice( __( 'Emergancy City is required field' ), 'error');
//    if ( ! $_POST['billing_empostcode'] )
//        wc_add_notice( __( 'Emergancy Postcode is required field' ), 'error');
//    if ( ! $_POST['billing_ememail'] )
//        wc_add_notice( __( 'Emergancy Email Address is required field' ), 'error');
//    if ( ! $_POST['billing_emphone'] )
//        wc_add_notice( __( 'Emergancy Phone Number is required field' ), 'error');
//    if ( ! $_POST['billing_howtohear'] )
//        wc_add_notice( __( 'Please select how you hear about us' ), 'error');
//    if ( ! $_POST['billing_liketoapply'] )
//        wc_add_notice( __( 'Please select apply for option' ), 'error');
//    if ( ! $_POST['billing_accepttemsandcon'] )
//        wc_add_notice( __( 'Please check Terms & Conditions' ), 'error');
//}



function print_coursesproducts($attrs){
    echo "<ul style='color: #fff;' type='square' class='courses_footer'>";
        ?>
    <?php
        $args = array( 'post_type' => 'product', 'product_cat' => 'course' );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
               
                <li><strong><?php the_title(); ?></strong></li>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
    </ul>
    <?php
}

add_shortcode('get_course_products', 'print_coursesproducts');


//add  Accomodation Admin option

add_action('wc_cpdf_init', 'prefix_custom_product_data', 10, 0);
add_action('wc_nopriv_cpdf_init', 'prefix_custom_product_data', 10, 0);
if(!function_exists('prefix_custom_product_data')) :
 
   function prefix_custom_product_data(){
            // get cat name
            $term_list = wp_get_post_terms($_GET['post'],'product_cat',array('fields'=>'ids'));
            $cat_id = (int)$term_list[0];
            $cat_name = get_cat_name ($cat_id, 'product_cat');
            
		$current_prod = null;
		if((isset($_GET['post']) && !empty($_GET['post'])) && $cat_name == 'Accomdation'){
                    
                    $current_prod = $_GET['post'];		 
                }
                    $custom_product_data_fields = array();
 
				$get_products = get_posts(array(
					'post_type' 	 => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'post__not_in'   => array( $current_prod ),
                                        'product_cat' => 'duration'
				));
 
				$prods = array();
 
				if ( ! empty( $get_products ) ) :
					foreach ($get_products as $key => $value) {
						$prods[$value] = get_the_title($value);
					}
				endif;
                                
                                
                                $get_products_zone = get_posts(array(
					'post_type' 	 => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'post__not_in'   => array( $current_prod ),
                                        'product_cat' => 'zone'
				));
 
				$prods_zone = array();
 
				if ( ! empty( $get_products_zone ) ) :
					foreach ($get_products_zone as $key => $value) {
						$prods_zone[$value] = get_the_title($value);
					}
				endif;
                                
 
				$custom_product_data_fields['recommended'] = array(
 
					 array(
						 'tab_name' => __('Recommended', 'textdomain')
					 ),
					 array(
						 'id'	        => 'c_label',
						 'type'		  => 'text',
						 'placeholder'  => __('Type here', 'textdomain'),
						 'label'        => __('Heading text', 'textdomain')
					 ),
					 array(
					       'id'          => 'c_recommended',
					       'type'        => 'multiselect',
					       'label'       => __('Select Week(s)', 'textdomain'),
					       'placeholder' => __('Type a product name', 'textdomain'),
					       'options'     => $prods,
					       'description' => __('You can select more than once product.', 'textdomain'),
					       'desc_tip'    => true,
					       'class'       => 'medium'
					 ),
                                         array(
					       'id'          => 'recommended_zone',
					       'type'        => 'multiselect',
					       'label'       => __('Select Zone(s)', 'textdomain'),
					       'placeholder' => __('Type a product name', 'textdomain'),
					       'options'     => $prods_zone,
					       'description' => __('You can select more than once product.', 'textdomain'),
					       'desc_tip'    => true,
					       'class'       => 'medium'
					 ),
 
				);
 
				return $custom_product_data_fields;
              
   }
 
endif;


/**
 * Display recommended products 
 */
 
add_action( 'woocommerce_after_single_product_summary', 'prefix_display_custom_recommended_products', 19 );
add_action( 'woocommerce_nopriv_after_single_product_summary', 'prefix_display_custom_recommended_products', 19 );
function prefix_display_custom_recommended_products(){
 
 
 
	global $product, $woocommerce_loop, $wc_cpdf;
 
	$recommended = $wc_cpdf->get_value(get_the_ID(), 'c_recommended');
 
	if(empty($recommended)){
		return;
	}
 
	$args = array(
		'post_type'            => 'product',
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => -1,
		'orderby'              => 'rand',
		'post__in'             => $recommended,
		'post__not_in'         => array( $product->id ),
	);
 
	$products                    = new WP_Query( $args );
	$woocommerce_loop['columns'] = 4;
 
	if ( $products->have_posts() ) : ?>
 
		<div class="related products">
 
			<?php
			$label 		 = __( 'Recommended Products', 'textdomain' );
			$get_label = $wc_cpdf->get_value(get_the_ID(), 'c_label');
 
			if(!empty($get_label)){
				$label = $get_label;
			}
			?>
 
			<h2><?php echo $label; ?></h2>
 
			<?php woocommerce_product_loop_start(); ?>
 
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
 
					<?php wc_get_template_part( 'content', 'product' ); ?>
 
				<?php endwhile; ?>
 
			<?php woocommerce_product_loop_end(); ?>
 
		</div>
 
	<?php endif;
 
        
        $recommended_zone = $wc_cpdf->get_value(get_the_ID(), 'recommended_zone');
 
	if(empty($recommended_zone)){
		return;
	}
 
	$args_zone = array(
		'post_type'            => 'product',
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => -1,
		'orderby'              => 'rand',
		'post__in'             => $recommended_zone,
		'post__not_in'         => array( $product->id ),
	);
 
	$products_zone                    = new WP_Query( $args_zone );
	$woocommerce_loop['columns'] = 4;
 
	if ( $products_zone->have_posts() ) : ?>
 
		<div class="related products">
 
			<?php
			$label 		 = __( 'Recommended Products', 'textdomain' );
			$get_label = $wc_cpdf->get_value(get_the_ID(), 'c_label');
 
			if(!empty($get_label)){
				$label = $get_label;
			}
			?>
 
			<h2><?php echo $label; ?></h2>
 
			<?php woocommerce_product_loop_start(); ?>
 
				<?php while ( $products_zone->have_posts() ) : $products_zone->the_post(); ?>
 
					<?php wc_get_template_part( 'content', 'product' ); ?>
 
				<?php endwhile; ?>
 
			<?php woocommerce_product_loop_end(); ?>
 
		</div>
 
	<?php endif;
        
	wp_reset_postdata();
 
 
}




add_action( 'wp_ajax_getaccweek', 'getaccweek' );
add_action( 'wp_ajax_nopriv_getaccweek', 'getaccweek' );

function getaccweek(){
    $week = $_POST['accomodation_week'];
    $_POST['selected_date'];
    $week = $week ;
    $date = "$_POST[selected_date]";
  
    //    error_reporting(E_ALL);
    //    ini_set("display_errors","1");
         $newdate = date('d/m/Y', strtotime('last Saturday', strtotime(str_replace('/', '-', $date))));
         $nxtdate = date('d/m/Y', strtotime(''.$week.' week', strtotime(str_replace('/', '-', $newdate))));
         $date = '';
         for($i=1;$i<=$week;$i++){
            $date[$i] = date('d/m/Y', strtotime(''.$i.' week', strtotime(str_replace('/', '-', $newdate))));
         }

            echo "<div id='accstartdate'>";
            echo "<input type='text' name='acc_startdate' id='acc_startdate' value=".$newdate." readonly>";
            echo "</div>";
            
            echo "<div id='accenddate'>";
            echo "<input type='text' name='acc_enddate' id='acc_enddate' value=".$nxtdate." readonly>";
            echo "</div>";
            
    die();

}   
add_action( 'wp_ajax_get_week_range', 'get_week_range' );
add_action( 'wp_ajax_nopriv_get_week_range', 'get_week_range' );
function get_week_range(){
    $week = $_POST['course_week'];
    $_POST['selected_date'];
    $date = "$_POST[selected_date]";
         $newdate = date('Y-m-d', strtotime('next Saturday', strtotime(str_replace('/', '-', $date))));
         $nxtdate = date('Y-m-d', strtotime(''.$week.' week', strtotime(str_replace('/', '-', $newdate))));
         $date = "";
         for($i=1;$i<=$week;$i++){
            $date[$i] = date('Y-m-d', strtotime(''.$i.' week', strtotime(str_replace('/', '-', $newdate))));
         }
         print_r($date);
}

add_filter( 'wc_add_to_cart_message', '__return_empty_string' );

add_filter( 'gettext', 'custom_paypal_button_text', 20, 3 );
function custom_paypal_button_text( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Proceed to PayPal' :
			$translated_text = __( 'NEXT', 'woocommerce' );
			break;
	}
	return $translated_text;
}

function print_reset_password(){
    $login=$_GET['login'];
    $key= $_GET['key'];
    $user =check_password_reset_key($key, $login);
    $arr=(array)$user;
    if(empty($arr[errors])){
      $user_id = $user->data->ID;
        if(isset($_POST['new_pass']) && $_POST['new_pass']!=""){
            wp_set_password( $_POST['new_pass'], $user_id );
            echo '<p class="woocommerce-FormRow form-row" style="color:green;text-align: center;">Your password has been changed successfully</p>';
    }else{
        echo '<p class="woocommerce-FormRow form-row" style="color:red;text-align: center;">Please enter password</p>';
    }}
    else{
        echo "<p style='color:red;text-align: center;'>Your Activation key is not valid</p>";
    }
        echo "<form id='frm_reset_pass' name='frm_reset_pass' action='' method='post' class='woocommerce-ResetPassword lost_reset_password'>";
        echo "<p>Lost your password? Please enter new password</p>";
        echo "<p class='woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first'>";
        echo "<label for='user_reset_pass'>New Password:</label> ";
	echo "<input type='password' id='new_pass' name='new_pass' class=''></p>";
        echo "<div class='clear'></div>";
        echo "<p class='woocommerce-FormRow form-row'>";
        echo "<input type='submit' id='btn_restpass' name='btn_restpass' value='change Password' class='woocommerce-Button button'></p></form>";
}
add_shortcode('resetpassword', 'print_reset_password');
	
    function set_custom_post_types_admin_order($wp_query) {  
      if (is_admin()) {  
      
        // Get the post type from the query  
        $post_type = $wp_query->query['post_type'];  
      
        if ( $post_type == 'POST_TYPE') {  
      
          // 'orderby' value can be any column name  
          $wp_query->set('orderby', 'title');  
      
          // 'order' value can be ASC or DESC  
          $wp_query->set('order', 'DESC');  
        }  
      }  
    }  
    add_filter('pre_get_posts', 'set_custom_post_types_admin_order');  
    
    add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields');
// Our hooked in function – $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
$fields['billing']['billing_postcode']['placeholder'] = '* Postcode';
$fields['billing']['billing_postcode']['label'] = '';


return $fields;
}

add_action( 'woocommerce_before_order_itemmeta', 'so_32457241)before_order_itemmeta', 10, 3 );
function so_32457241_before_order_itemmeta( $item_id, $item, $_product ){
    echo '<p>bacon</p>';
}


add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Blog Sidebar', 'skilled-child' ),
        'id' => 'blog-sidebar',
        'description' => __( 'Widgets in this area will be shown on blog posts and pages.', 'skilled-child' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>',
    ) );
}