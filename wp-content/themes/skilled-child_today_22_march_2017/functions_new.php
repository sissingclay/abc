<?php
function register_my_menu() {
  register_nav_menu('language-menu',__( 'Select Language Menu' ));
}
add_action( 'init', 'register_my_menu' );

add_action('wp_ajax_show_week_data', 'show_week_data');
add_action('wp_ajax_nopriv_show_week_data', 'show_week_data');
function show_week_data(){
	global $product;
	$course_id = $_POST['week_id'];
	$response =wc_get_product_terms( $course_id, 'pa_week', array( 'fields' => 'names' ) );
	wp_send_json($response);
	
}

add_action('wp_ajax_show_course_data', 'show_course_data');
add_action('wp_ajax_nopriv_show_course_data', 'show_course_data');
function show_course_data(){
	global $product;
	$course_id = $_POST['productid'];
	$response =wc_get_product_terms( $course_id, 'pa_course_level', array( 'fields' => 'names', 'orderby'=>'names'  ) );
	wp_send_json($response);	
}
add_action('wp_ajax_get_variation_id', 'get_variation_id');
add_action('wp_ajax_nopriv_get_variation_id', 'get_variation_id');
function get_variation_id(){
	global $product;
	$course_week = $_POST['courseweek'];
	$product_id = $_POST['product_id'];
	$response =wc_get_product_terms( $course_id, 'pa_course_level', array( 'fields' => 'names', 'orderby'=>'names'  ) );
	wp_send_json($response);	
}
add_action('wp_ajax_get_acc_week', 'get_acc_week');
add_action('wp_ajax_nopriv_get_acc_week', 'get_acc_week');
function get_acc_week(){
	$acc_week = $_POST['accomodation_week'];
	$start_date = $_POST['selected_date'];
	wp_die(0);
}

?>