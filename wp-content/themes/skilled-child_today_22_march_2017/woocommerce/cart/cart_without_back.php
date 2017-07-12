<?php
// Start the session login
session_start();
$site_url= get_site_url();
?>

<!--<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">-->
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/css/bootstrap-select.css" />
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
      <!--<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
    <script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/js/moment.min.js"></script>
    <script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/js/bootstrap-select.js"></script>
    
    

	  
<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}



    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    
    
 
     ?>
<input type="hidden" name="extrafees" id="extrafees" value="<?php echo htmlspecialchars( json_encode( $woocommerce->cart->get_fees() ) ) ?>">

    <?php
    
wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<?php 

$handle=new WC_Product_Variable(15538);
$attributes = $handle->get_variation_attributes();
$attribute_keys = array_keys( $attributes );
?>



<?php
do_action( 'woocommerce_after_add_to_cart_form' );
?>
                                        

<?php 
$args = array(
    'number'     => $number,
    'orderby'    => 'slug',
  //  'order'      => 'ASC',
    'hide_empty' => $hide_empty,
    'include'    => $ids,
//    'orderby'             => 'date', // date is primary
    'order'               => 'ASC' // not required because it's the default value
);
$product_categories = get_terms( 'product_cat', $args );


$count = count($product_categories);
if ( $count > 0 ){
    echo '<div class="cart-step1">';
    foreach ( $product_categories as $product_category ) {
        if($product_category->slug == '1course' || $product_category->slug == '2accomdation' || $product_category->slug == '3extras' || $product_category->slug == 'visa'){
        echo '<h4 ><div class="extra-second-section">' . $product_category->name . '</div></h4>';
        $args = array(
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    // 'terms' => 'white-wines'
                    'terms' => $product_category->slug
                )
            ),
            'post_type' => 'product',
            'orderby' => 'title,'
        );
        $products = new WP_Query( $args );
       
        if($product_category->slug == '1course') { ?>
            <select id="getProductOption" onchange='getProductOption()'>
                <option value='0' selected>Course Type</option>
                <option value='1'>Callan Method</option>
                <option value='2'>General English</option>
                <option value='3'>Intensive English</option>
                <option value='4'>One to One</option>
                <option value='5'>Exam Course</option>
            </select>

            <div class="radio-ctype" style="display:block;padding:0 0 10px;">
                <?php global $wc_cpdf;
                $icnt = 0; 
                while ( $products->have_posts() ) { $products->the_post(); $icnt++; ?>
                    <span class="prod-radio" id="prod-<?php echo $icnt; ?>" style="display:none;padding-right:10px;"><input type="radio" name="productname" class="productname" value="<?php the_id(); ?>"> <?php echo $wc_cpdf->get_value(get_the_ID(), 'product_radio_title'); ?></span>
                <?php } ?>
            </div>

            <?php 
//          echo "<div id='coursestartdate'>";
//          echo "<select disabled><option>Select Start Date</option></select>";
//          echo "</div>";
          
            echo "<div id='coursestartdate' style='display:none'>";
            echo "<input type='text' name='course_date' id='course_date'  autocomplete='off' placeholder='Course Start Date' >";
            echo "</div>";

            echo "<div id='courseweekdiv' style='display:none'>";
            echo "<select id='' disabled><option>Course Length</option></select>";
            echo "</div>";       
            
            echo "<div id='feedback' style='display:none'>";
            echo "<select disabled><option>I think my Level is</option></select>";
            echo "</div>";

            echo "<div id='ex-student' style='display:none'>";
            echo "<select id='you-ex-student'><option value='' selected='selected'>Are you an ex-student?</option><option value='yes'>Yes</option><option value='no'>No</option></select>";
            echo "</div>";
            
            echo "<div class='spinner'></div>";

        }
        
        if($product_category->slug == '2accomdation') { ?>
            <select id='accomdation' name="accomdation" onchange='allowShowAccOption()' disabled>
                <option selected="selected" value="1">No Accommodation Required</option>
                <optgroup label="Homestay">
                    <option value="2">Homestay - Single</option>
                    <option value="3">Homestay - Double (two students coming together)</option>
                </optgroup>
                <optgroup label="Flatshare">
                    <option value="4">Flatshare - Single</option>
                    <option value="5">Flatshare - Twin room to share with another student of the same sex</option>
                    <option value="6">Flatshare - Twin room (2 students)</option>
                </optgroup>
            </select>

            <div class="radio-ctype" style="display:block;">
                <span class="prod-radio-acco" style="display:none;">
                    <select id="prod-acc-meal-plan"> 
                        <option value="">Select Meal plan</option>                                       
                        <?php global $wc_cpdf;
                        $icnt = 0; 
                        while ( $products->have_posts() ) { $products->the_post(); $icnt++;?>
                        
                            <option value='<?php the_id(); ?>'><?php echo $wc_cpdf->get_value(get_the_ID(), 'product_radio_title'); ?></span></option>
                                                
                        <?php } ?>
                    </select>
                </span>
            </div>
            
            <?php /* <div class="radio-ctype" style="display:block;padding:0 0 10px;">
                <?php global $wc_cpdf;
                $icnt = 0; 
                while ( $products->have_posts() ) { $products->the_post(); $icnt++; ?>
                    <span class="prod-radio-acco" id="prod-acco-<?php echo $icnt; ?>" style="display:none;padding-right:10px;"><input type="radio" name="productname" class="accomdation" value="<?php the_id(); ?>"> <?php echo $wc_cpdf->get_value(get_the_ID(), 'product_radio_title'); ?></span>
                <?php } ?>
            </div> */ ?>
            
            <?php /*$icnt=0;

            echo "<select id='accomdation' onchange='allowShowOthers()' disabled><option value='' selected='selected'>No Accommodation Required</option>";
            while ( $products->have_posts() ) { $icnt++;
                $products->the_post();
                if($icnt == 1){ echo '<optgroup label="Homestay">'; }
                if($icnt == 9){ echo '<optgroup label="Flatshare">'; }
                ?>
                    <option value="<?php the_id(); ?>">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>      
                    </option>
                <?php
                if($icnt == 8){ echo '</optgroup>'; }
                if($icnt == 11){ echo '</optgroup>'; }
            }
            echo "</select>"; */


            echo "<div id='allow_hide' style='display:none'>";
            
            echo "<div id='div_acczones' style='padding:10px;width:100%;display:block;float:left;'>";
                // echo "<select name='acc_zone' id='acc_zone' disabled=''>
                //         <option value=''>Accommodation Zone</option>
                //       </select>"; ?>

                <div class="acc_zone" style="display:block;padding:0 0 10px;"></div>

            <?php echo "</div>";

            echo "<div style='float:left;margin-right:19px;width:45%;'>";
            echo "<select id='accomodation_week' disabled=''><option>Accommodation Length</option></select>";
            echo "</div>";

            echo "<div id='div_accsupplement'>";
            echo "<select name='acc_supplement' id='acc_supplement'>
                    <option value=''>Are you under 18?</option>
                    <option value='yes'>Yes</option>
                    <option value='no'>No</option>
                  </select>";
            echo "</div>";
            
            echo '<div id="acc_date">';
            echo "<div id='accstartdate'>";
            echo "<input type='text' name='acc_startdate' id='acc_startdate'  autocomplete='off' placeholder='Start Date for Accommodation'>";
            echo "</div>";
            
            echo "<div id='accenddate'>";
            echo "<input type='text' name='acc_enddate' id='acc_enddate' placeholder='End Date for Accommodation'>";
            echo "</div>";
            echo "</div>";
//            echo "<select name='roomtype' id='roomtype' disabled=''><option value=''>RoomType</option>
//                  <option value='superiorroom'>Superior Room</option>
//                  </select>";
            
//            echo "<div id='accomodation_zone'>";
//            echo "<select id='acc_zone' class='selectpicker' multiple><option>Accommodation Zone</option></select>";
//            echo "</div>"; 
            
             echo "<select name='smoke' id='smoke' disabled=''><option value=''>Do you smoke?</option>
                            <option value='yessmpoke'>Yes</option>
                            <option value='nosmpoke'>No</option>
                    </select>";
            
            echo "<select name='petbother' id='petbother' disabled=''><option value=''>Do pets bother you?</option>
                            <option value='nopetbother'>Yes</option>
                            <option value='yespetbother'>No</option>
                    </select>";
                    
            echo '<div class="allergies-left"><input class="css-checkbox" type="checkbox" name="allergies" id="allergies" disabled value="Do you have Allergies?"><label for="allergies" class="css-label">Do you have Allergies?</label></div>';
            
            echo '<div class="allergies-right"><input type="text" name="allergiestype" id="allergiestype" disabled placeholder="type allergies here"></div><br>';
                    
        }
        if($product_category->slug == '3extras') {  
            echo "<select id='transport_type' disabled=''><option value='' selected>Airport Transfer</option>";
            while ( $products->have_posts() ) {
                $products->the_post();
                ?>
                    <option value="<?php the_id(); ?>">
                            <?php the_title(); ?>
                    </option>
             <?php
            }
            echo "</select>"; 
            
            echo '<input type="text" name="flightname" id="flightname" disabled placeholder="Flight Number"><br>';
            
            echo '<input type="text" name="arrivaldate" id="arrivaldate" disabled placeholder="Arrival Date" >';
//            echo "<div class='input-group date' id='arrivaldate' name='arrivaldate'><input type='text' class='form-control'/>                   <span class='input-group-addon'>
//                        <span class='glyphicon glyphicon-calendar'></span>
//                    </span>
//                </div>";
            
            echo '<input type="text" name="departuredate" id="departuredate" disabled placeholder="Arrival Time"><br>';
            echo "</div>";
           

            
//            echo "<div class='input-group date' id='datetimepicker4'>
//                <input type='text' class='form-control'/>
//                <span class='input-group-addon'><span class='glyphicon glyphicon-time'></span>
//                </span>
//            </div>";
        }
//        echo $product_category->slug;
        if($product_category->slug == 'visa') {
//			echo '<h4 ><div class="extra-second-section">' . $product_category->name . '</div></h4>';
             echo "<select name='visa_require' id='visa_require' '><option value='' selected>No Visa Required</option>";
            while ( $products->have_posts() ) {
                $products->the_post();
                ?>
                    <option value="<?php the_id(); ?>">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>      
                    </option>
             <?php
				
			}
            echo "</select>";
			
        }

    }
    
    }
    //echo '<a href="javascript: void(0)" class="button cart-next-btn" style="background-color:gray;border:none;float:left;">Back</a>';
    echo '<a href="javascript: void(0)" class="checkout-button button alt wc-forward cart-next-btn" disabled="" id="btn_cart_proceed">Next</a>';
    echo '</div>';
    
    echo '<div id="custom_data">';
    ?>
                    
                    <?php
                    
     echo '<div class="sk-fading-circle" style="display:none">
            <div class="sk-circle1 sk-circle"></div>
            <div class="sk-circle2 sk-circle"></div>
            <div class="sk-circle3 sk-circle"></div>
            <div class="sk-circle4 sk-circle"></div>
            <div class="sk-circle5 sk-circle"></div>
            <div class="sk-circle6 sk-circle"></div>
            <div class="sk-circle7 sk-circle"></div>
            <div class="sk-circle8 sk-circle"></div>
            <div class="sk-circle9 sk-circle"></div>
            <div class="sk-circle10 sk-circle"></div>
            <div class="sk-circle11 sk-circle"></div>
            <div class="sk-circle12 sk-circle"></div>
          </div>';
     echo "<div id='accomodation_cart'></div>";
     
     

}
?> 

<?php do_action( 'woocommerce_after_cart_table' ); ?>


    
<?php do_action( 'woocommerce_after_cart' ); ?>

   <script>
       
    var site_url = '<?php echo $site_url; ?>'; 
    function hideOthers(){
		jQuery("#allow_hide").hide();
	}
	function showOthers(){
		jQuery("#allow_hide").show();
	}	
    function allowShowOthers(){
        if(jQuery("#accomdation").val()){
            showOthers();
        }
        else hideOthers();
    }
        
    function resetCourseData(){
		jQuery("#coursestartdate").show();
        jQuery("#courseweekdiv").html("<select id='' disabled><option>Course Length</option></select>");
		jQuery("#courseweekdiv").show();
        jQuery("#feedback").html("<select disabled><option>Course Level</option></select>");
		jQuery("#feedback").show();
        jQuery("#ex-student").show();
    }  
    function resetAccData(){
        jQuery("#accomdation").val("1");
        jQuery("#accomdation").prop('disabled', true);
        jQuery("#accomodation_week").empty().append('<option value="">Accommodation Length of stay</option>');
        jQuery("#acc_startdate").val("");
        jQuery("#acc_enddate").val("");
//        jQuery("#acc_zone").html("");
    }
    function resetExtras(){
        jQuery("#transport_type").prop('disabled', true);
        jQuery("#roomtype").val("");
        jQuery("#roomtype").prop('disabled', true);
        jQuery("#smoke").val("");
        jQuery("#smoke").prop('disabled', true);
        jQuery("#petbother").val("");
        jQuery("#petbother").prop('disabled', true);

        jQuery("#you-ex-student").val("");
        jQuery("#you-ex-student").prop('disabled', true);

        jQuery( "#course_date").val("");
    }
    function accfieldsset(bool){
            jQuery("#roomtype").prop('disabled', bool);
            jQuery("#accomodation_week").prop('disabled', bool);
            jQuery("#acc_startdate").prop('disabled', bool);
            jQuery("#acc_enddate").prop('disabled', bool);
            jQuery("#transport_type").val("");
        }
        
        function extrasfieldset(bool){
            jQuery("#accomdation").prop('disabled', bool);
            jQuery("#smoke").prop('disabled', bool);
            jQuery("#petbother").prop('disabled', bool);
            jQuery("#transport_type").prop('disabled', bool);
            jQuery("#allergiestype").prop('disabled', bool);
            jQuery("#arrivaldate").prop('disabled', bool);
            jQuery("#departuredate").prop('disabled', bool);
            jQuery("#flightname").prop('disabled', bool);
            jQuery("#allergies").prop('disabled', bool);
            jQuery('#accomdation').val('1');
            hideOthers();
        }

    function AccMealPlanReset(){        
        jQuery("#prod-acc-meal-plan").children("option[value^=19861]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19857]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19851]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19847]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19843]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19839]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19835]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19831]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19829]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19828]").hide();
        jQuery("#prod-acc-meal-plan").children("option[value^=19827]").hide();        
    }

    function allowShowAccOption(){
        var prod_id = jQuery( "#accomdation option:selected" ).val();
        if(prod_id == 0 || prod_id == 1){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            jQuery('.prod-radio-acco').hide();            
        }
        if(prod_id == 2){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19861]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19857]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19851]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19847]").show();
        }
        if(prod_id == 3){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19843]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19839]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19835]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19831]").show();
        }
        if(prod_id == 4){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-9').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').hide();
            jQuery("#prod-acc-meal-plan").children("option[value^=19829]").show();

            jQuery("#prod-acc-meal-plan option[value^=19829]").attr("selected", "selected");
            jQuery("#prod-acc-meal-plan").trigger('change');
        }
        if(prod_id == 5){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-10').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').hide();
            jQuery("#prod-acc-meal-plan").children("option[value^=19828]").show();    

            jQuery("#prod-acc-meal-plan option[value^=19828]").attr("selected", "selected");
            jQuery("#prod-acc-meal-plan").trigger('change');
        }
        if(prod_id == 6){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-11').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').hide();
            jQuery("#prod-acc-meal-plan").children("option[value^=19827]").show();

            jQuery("#prod-acc-meal-plan option[value^=19827]").attr("selected", "selected");
            jQuery("#prod-acc-meal-plan").trigger('change');
        }
    }

    // jQuery('.cart-step1').on("click","#prod-acc-meal-plan",function() {
    //     if(jQuery("#prod-acc-meal-plan option:selected").val()){ 
    //         showOthers();
    //     }
    //     else hideOthers();
    // });
    
    function getProductOption(){ 
        var prod_id = jQuery( "#getProductOption option:selected" ).val();
        if(prod_id == 0){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12').hide();
        }
        if(prod_id == 1){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12').hide();
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4').show();
        }
        if(prod_id == 2){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12').hide();
            jQuery('#prod-5').show();
        }
        if(prod_id == 3){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12').hide();
            jQuery('#prod-6, #prod-7, #prod-8').show();
        }
        if(prod_id == 4){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12').hide();
            jQuery('#prod-9, #prod-10, #prod-11').show();
        }
        if(prod_id == 5){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12').hide();
            jQuery('#prod-12').show();
        }
    }
   
    jQuery('.cart-step1').on("click",".prod-radio input:radio",function() {
        jQuery("#accomdation").prop('disabled', true);
        var product_id = jQuery(this).val();
        //alert(product_id);
        jQuery.ajax({
            type: 'post',
            url: site_url+'/wp-admin/admin-ajax.php?action=show_startdate_data',
            data: {
                    action: 'show_startdate_data',
					'productid': product_id
            },
            success: function( result ) {
//              jQuery("#coursestartdate").html(result);
                resetCourseData();
                resetAccData();
                resetExtras();
                jQuery("#accomodation_cart").html("");
            }
        });
    });

    jQuery('.cart-step1').on("change","#you-ex-student",function() {

        var is_set_charge = '';
        if(jQuery(this).val() == 'yes'){
            is_set_charge = 'yes';
        } else {
            is_set_charge = 'no';
        }

        jQuery('.sk-fading-circle').show();

        // jQuery.ajax({
        //     type: 'post',
        //     url: site_url+'/wp-admin/admin-ajax.php?action=fee_based_on_product_category',
        //     data: {
        //         action: 'fee_based_on_product_category',
        //         get_remove_option_id: is_set_charge            
        //     },
        //     success: function( result ) {

                var extracharges = jQuery( "#extrafees" ).val();

                var startdate = $("#acc_startdate").val().split("/");
                var first = new Date(startdate[2]+"-"+startdate[1]+"-"+startdate[0]);
                var enddate = $("#acc_enddate").val().split("/");
                var second = new Date(enddate[2]+"-"+enddate[1]+"-"+enddate[0]);
                var days = Math.round((second-first)/(1000*60*60*24));
                var week_nos = Math.round(days/7);
                var coursestartdate = jQuery( "#course_date").val();
                var course_level = jQuery( "#course_level :selected" ).val();

                var back_accomdation = jQuery( "#accomdation option:selected" ).val();
                var back_meal_plan = jQuery( "#prod-acc-meal-plan option:selected" ).val();
                var back_product_acc_zone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
                var back_accomodation_week = jQuery( "#accomodation_week option:selected" ).val();
                var back_acc_startdate = jQuery( "#acc_startdate" ).val();
                var back_acc_enddate = jQuery( "#acc_enddate" ).val();

                var back_acc_supplement = jQuery( "#acc_supplement option:selected" ).val();
                var back_smoke = jQuery( "#smoke option:selected" ).val();
                var back_petbother = jQuery( "#petbother option:selected" ).val();
                var back_allergies = jQuery( "#allergies" ).val();
                var back_allergiestype = jQuery( "#allergiestype" ).val();

                var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                var back_flightname = jQuery( "#flightname" ).val();
                var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                var back_departuredate = jQuery( "#departuredate" ).val();                                

                var back_visa_require = jQuery( "#visa_require" ).val(); 

                jQuery.ajax({
                    type: 'post',
                    url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
                    data: {
                            action: 'show_acc_cart_data',
                            'extracharges' : extracharges,
                            'coursesweek_number': week_nos,
                            coursestartdate :coursestartdate,
                            acc_week : week_nos,
                            course_level : course_level,
                            fee_charge : is_set_charge,
                            'back_accomdation' : back_accomdation,
                            'back_meal_plan' : back_meal_plan,
                            'back_product_acc_zone' : back_product_acc_zone,
                            'back_accomodation_week' : back_accomodation_week,
                            'back_acc_startdate' : back_acc_startdate,
                            'back_acc_enddate' : back_acc_enddate,

                            'back_acc_supplement' : back_acc_supplement,
                            'back_smoke' : back_smoke,
                            'back_petbother' : back_petbother,
                            'back_allergies' : back_allergies,
                            'back_allergiestype' : back_allergiestype,

                            'back_transport_type' : back_transport_type,
                            'back_flightname' : back_flightname,
                            'back_arrivaldate' : back_arrivaldate,
                            'back_departuredate' : back_departuredate,

                            'back_visa_require' : back_visa_require,
                    },
                    success: function( result ) {
                        if(result == '<table>'){
                            changeWeek();
                        } else {
                            jQuery("#accomodation_cart").html(result);  
                        } 
                        jQuery('.sk-fading-circle').hide();
                    }
                });
        //    }
        //});

    });
    
    function getcourselevel(s){
        //get all course levels
        
        var course_level = jQuery( "#course_level :selected" ).val();
        if(!course_level){
        var product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
        jQuery.ajax({
            type: 'post',
            url: site_url+'/wp-admin/admin-ajax.php?action=show_course_data',
            data: {
                    action: 'show_course_data',
                    'productid': product_id
            },
            success: function( result ) {
                jQuery("#feedback").html(result);
               
            }
        });
        }
        //set accommodation course weeks dropdown
        var selected_week = parseFloat($("#courseweek").val());
        var i,text = [];
        var x=1;
        for (i = 2; i <= selected_week + 1 ; i++) {
            text[x] = i + " weeks";
            x++;
        }
        $('#accomodation_week').html('');
        $.each(text, function(key, value) {  
            if(key >= 1){
             $('#accomodation_week').append($("<option></option>")
                        .attr("value",key)
                        .text(value)); }
             });
             $('#accomodation_week').val(selected_week);   
                getWeekData();
            
    }
    
    function changeWeek(){
        var startdate= $("#acc_startdate").val().split("/");
        var first= new Date(startdate[2]+"-"+startdate[1]+"-"+startdate[0]);
        var enddate= $("#acc_enddate").val().split("/");
        var second = new Date(enddate[2]+"-"+enddate[1]+"-"+enddate[0]);
        var days = Math.round((second-first)/(1000*60*60*24));
        var week_nos= Math.round(days/7);
        var coursestartdate = jQuery( "#course_date").val();
        var course_level = jQuery( "#course_level :selected" ).text();
        var product_id = jQuery( "#transport_type option:selected" ).val();
        var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());
        var acczone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
        console.log("start Date: "+startdate);
        console.log("end Date: "+enddate);
        console.log("week nos: "+week_nos);
        if(week_nos >= 2){
        $('#accomodation_week').val(week_nos-1);
        console.log("in if");
        }else{
            console.log("in else");
             $('#accomodation_week').val("1");
             getWeekData();
        }
//    }else{        }
//        change cart data after selecting datepicker
         var cat_id = jQuery( "#prod-acc-meal-plan option:selected" ).val(); 
         var extracharges = jQuery( "#extrafees" ).val();

        var is_set_charge = '';
        if(jQuery('#you-ex-student').val() == 'yes'){
            is_set_charge = 'yes';
        } else {
            is_set_charge = 'no';
        }

         jQuery('.sk-fading-circle').show();
         
     jQuery.ajax({
            //get variation product id
            url: site_url+"/public_html/wp-content/themes/skilled-child/functions.php",
            type: "POST",
            data: {
//                'course_level': course_level,
                'acczone' : acczone,
                'product_id' : cat_id
            },
            success:function(result){
             jQuery.ajax({
                    type: 'post',
                    url: site_url+'/wp-admin/admin-ajax.php?action=remove_cart_data',
                    data: {
                            action: 'remove_acc_cart_data'
                    },
                    success: function( result1 ) {
                    setTimeout(function(){
                                jQuery.get(site_url+'/cart/?post_type=product&add-to-cart=' + cat_id +'&variation_id='+result +'&quantity='+week_nos+'&attribute_pa_zone='+acczone,
                                function() {});
                                },100);
                        jQuery.ajax({
                            url: site_url+"/wp-admin/admin-ajax.php?action=add_transportdata",
                            type: "POST",
                            data: {
                                 action : 'add_transportdata',
                                'acctransportproc_id' : product_id,
                            },
                            success:function(result){
                        setTimeout(function(){

                                var back_accomdation = jQuery( "#accomdation option:selected" ).val();
                                var back_meal_plan = jQuery( "#prod-acc-meal-plan option:selected" ).val();
                                var back_product_acc_zone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
                                var back_accomodation_week = jQuery( "#accomodation_week option:selected" ).val();
                                var back_acc_startdate = jQuery( "#acc_startdate" ).val();
                                var back_acc_enddate = jQuery( "#acc_enddate" ).val();

                                var back_acc_supplement = jQuery( "#acc_supplement option:selected" ).val();
                                var back_smoke = jQuery( "#smoke option:selected" ).val();
                                var back_petbother = jQuery( "#petbother option:selected" ).val();
                                var back_allergies = jQuery( "#allergies" ).val();
                                var back_allergiestype = jQuery( "#allergiestype" ).val();

                                var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                                var back_flightname = jQuery( "#flightname" ).val();
                                var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                                var back_departuredate = jQuery( "#departuredate" ).val();                                

                                var back_visa_require = jQuery( "#visa_require" ).val();                                

                                jQuery.ajax({
                                        type: 'post',
                                        url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
                                        data: {
                                                action: 'show_acc_cart_data',
                                                'extracharges' : extracharges,
                                                'coursesweek_number': week_nos,
                                                coursestartdate :coursestartdate,
                                                acc_week : week_nos,
                                                course_level : course_level,
                                                fee_charge : is_set_charge,
                                                'back_accomdation' : back_accomdation,
                                                'back_meal_plan' : back_meal_plan,
                                                'back_product_acc_zone' : back_product_acc_zone,
                                                'back_accomodation_week' : back_accomodation_week,
                                                'back_acc_startdate' : back_acc_startdate,
                                                'back_acc_enddate' : back_acc_enddate,

                                                'back_acc_supplement' : back_acc_supplement,
                                                'back_smoke' : back_smoke,
                                                'back_petbother' : back_petbother,
                                                'back_allergies' : back_allergies,
                                                'back_allergiestype' : back_allergiestype,

                                                'back_transport_type' : back_transport_type,
                                                'back_flightname' : back_flightname,
                                                'back_arrivaldate' : back_arrivaldate,
                                                'back_departuredate' : back_departuredate,

                                                'back_visa_require' : back_visa_require,
                                        },
                                        success: function( result ) {
                                            if(result == '<table>'){
                                                changeWeek();
                                            } else {
                                                jQuery("#accomodation_cart").html(result);  
                                            }	
                                            jQuery('.sk-fading-circle').hide();
                                        }
                                });
                        }, 5000);
                        }});
//                    }});
                 }
                });
                }});
    }
    
    function getWeekData(){
        //Calculate accomodation week start and end date
        var min = new Date($("#acc_startdate").val());
        var accomodation_week = parseFloat(jQuery( "#accomodation_week option:selected" ).text());
//        var coursestartdate = jQuery( "#coursestartdate option:selected" ).text();   
        var coursestartdate = jQuery( "#course_date").val();
        jQuery.ajax({
        type: 'post',
        url: site_url+'/wp-admin/admin-ajax.php?action=getaccweek',
        data: {
                action: 'getaccweek',
                'accomodation_week': accomodation_week,
                'selected_date' : coursestartdate
        },
        success: function( result ) {
            jQuery("#acc_date").html(result);       
            setTimeout(function(){
            jQuery('#acc_startdate').datepicker({
                        format: "dd/mm/yyyy",
                        autoclose:true,
                        beforeShowDay: available,
//                        onSelect: function(dateText) {
//                        changeWeek(dateText);
//                        }
                    }).on('changeDate', changeWeek);
        },1000);

        function available(currentdate) {
            //enable and disable calculation
            var start_date = $("#acc_startdate").val();
            var date_arr = start_date.split("/");
            var min_date = date_arr[2]+"-"+date_arr[1]+"-"+date_arr[0];
            var min = new Date(min_date);
            var enddate= $("#acc_enddate").val().split("/");
            var max = new Date(enddate[2]+"-"+enddate[1]+"-"+enddate[0]);
            var availableDates=[];
//            debugger;
            while (min.getTime()<=max.getTime()) {
                if(min.getDay()===6 || min.getDay()===0){
                    availableDates.push(min.getDate() + "-" + (min.getMonth()+1) + "-" + min.getFullYear());
                }
                min.setDate(min.getDate()+1);
            } 
          dmy = currentdate.getDate() + "-" + (currentdate.getMonth()+1) + "-" + currentdate.getFullYear();
//          if ($.inArray(dmy, availableDates) != -1) {
//            return [true, "","Available"];
//          } else {
//            return [false,"","unAvailable"];
//          }
          if ($.inArray(dmy, availableDates) != -1) {
//              console.log("Inside true Current Date"+dmy);
                        return {
                            enabled : true
                         };
                      } else {
//                          console.log("Inside false Current Date"+dmy);
                        return {
                            enabled : false
                         };
                      }
        } }
    });
    }
    
    
    
    jQuery('#course_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose:true,
        daysOfWeekDisabled: [0,6]
    }).on('changeDate', setWeeks);
    
    function setWeeks(){
        var id = jQuery( ".prod-radio input[name=productname]:checked" ).val();
        jQuery.ajax({
            type: 'post',
            url: site_url+'/wp-admin/admin-ajax.php?action=show_week_data',
            data: {
                    action: 'show_week_data',
                    'week_id': id
            },
            success: function( result ) {
                jQuery("#courseweekdiv").html(result);			
            }
        });
    }
             
//    jQuery('#arrivaldate').datetimepicker({}).change();
    
    $('#arrivaldate').datepicker({
//        autoclose:true
    });
    $('#departuredate').datetimepicker({
        format: 'hh:mm A',  
        //autoclose:true,      
        //useCurrent: false //Important! See issue #1075
    //            autoclose:true
    });
    $("#arrivaldate").on("dp.change", function (e) {
        $('#departuredate').data("DateTimePicker").minDate(e.date);
    });
   
                    
    jQuery( document ).ready( function(jQuery) {
        jQuery('.selectpicker').selectpicker({ });
        
       function courseUpdate() {
            var course_level = jQuery( "#course_level :selected" ).text();
            if(course_level){
            var p_id = jQuery( ".prod-radio input[name=productname]:checked" ).val();
            var courseweek = jQuery( "#courseweek option:selected" ).val();
//            var coursestartdate = jQuery( "#coursestartdate option:selected" ).text();
            var coursestartdate = jQuery( "#course_date").val();
            var extracharges = jQuery( "#extrafees" ).val();

            var is_set_charge = '';
            if(jQuery('#you-ex-student').val() == 'yes'){
                is_set_charge = 'yes';
            } else {
                is_set_charge = 'no';
            }
            
            jQuery('.sk-fading-circle').show();
            jQuery.ajax({
                //get variation product id
            url: site_url+"/public_html/wp-content/themes/skilled-child/functions.php",
            type: "POST",
            data: {
//                'course_level': course_level,
                'courseweek' : courseweek,
                'product_id' : p_id,
            },
            success:function(result){   
                //remove all cart items
                jQuery.ajax({
                        type: 'post',
                        url: site_url+'/wp-admin/admin-ajax.php?action=remove_cart_data',
                        data: {
                                action: 'remove_cart_data'
                        },
                        success: function( result1 ) {
                            //add course product to cart

                            jQuery("#you-ex-student").val("");
                            jQuery("#you-ex-student").prop('disabled', false);

                            jQuery('.sk-fading-circle').show();
                        
                            setTimeout(function(){
                                jQuery.get(site_url+'/cart?post_type=product&add-to-cart=' + p_id +'&variation_id='+result +'&attribute_pa_course_level='+course_level+'&attribute_pa_week='+courseweek+'&attribute_pa_course_startdate='+coursestartdate,
                                function() {
                                        var flightname = jQuery("#flightname").val();
                                    var arrivaldate = jQuery( "#arrivaldate" ).val();
                                    var departuredate = jQuery( "#departuredate" ).val();
                                    var smoke = jQuery( "#smoke option:selected" ).text();
                                    var petbother = jQuery( "#petbother option:selected" ).text();
                                    var allergiestype = jQuery( "#allergiestype" ).val();
                        //            debugger;
                                    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                                    jQuery.ajax({
                                        url: ajaxurl, //AJAX file path - admin_url('admin-ajax.php')
                                        type: "POST",
                                        data: {
                                            //action name
                                            action:'wdm_add_user_custom_data_options',
                                            product_id : p_id,
                                            flightname : flightname,
                                            arrivaldate : arrivaldate,
                                            departuredate : departuredate,
                                            smoke : smoke,
                                            petbother : petbother,
                                            allergiestype : allergiestype
                                        },
                                        async : false,
                                        success: function(data){                                            
                                            //Code, that need to be executed when data arrives after
                                            // successful AJAX request execution
                                            jQuery(".checkout-button").attr("href",site_url+"/checkout");
                //                        alert(data);
                                        }
                                    });
                                });
                            },100);

                            setTimeout(function(){

                                var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
                                var back_prod_selected_id = jQuery( "#getProductOption option:selected" ).val();
                                var back_coursestartdate = jQuery( "#course_date").val();
                                var back_courseweek = jQuery( "#courseweek option:selected" ).val();
                                var back_course_level = jQuery( "#course_level option:selected" ).val(); 

                                var back_you_student = jQuery( "#you-ex-student option:selected" ).val(); 

                                //Show cart data for course
                                jQuery.ajax({
                                        type: 'post',
                                        url: site_url+'/wp-admin/admin-ajax.php?action=show_cart_data',
                                        data: {
                                                action: 'show_cart_data',
                                                'extracharges' : extracharges,
                                                start_date: coursestartdate,
                                                course_level : course_level,
                                                fee_charge : is_set_charge,
                                                'back_getProductOption' : back_prod_selected_id,
                                                'back_productid': back_product_id, 
                                                'back_coursestartdate' : back_coursestartdate,                                               
                                                'back_courseweek' : back_courseweek, 
                                                'back_course_level' : back_course_level,
                                                'back_you_student' : back_you_student,
                                        },
                                        success: function( result ) { console.log(result);
                                            jQuery('.sk-fading-circle').hide();
                                            if(result == '<table>'){
                                                changeWeek();
                                            } else {
                                                jQuery("#accomodation_cart").html(result);  
                                            }                                            
                                            extrasfieldset(0);
                                            jQuery(".checkout-button").attr("href",site_url+"/checkout");
                                        }
                                });
                            }, 1000);		
                        },
                        error: function(jq,status,message) {
                            alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
                        }

                });
            }
            });

	}}
        jQuery(document).on( 'change', '#courseweek', courseUpdate);
        jQuery(document).on( 'change', '#course_level', courseUpdate);
        
        function accomChange() {
                getWeekData();
                jQuery('.sk-fading-circle').show();
                
                var cat_id = jQuery( "#prod-acc-meal-plan option:selected" ).val(); 
//                var courseweek =  jQuery( "#accomodation_week" ).val();
                var coursesweek_number = parseFloat(jQuery( "#accomodation_week option:selected" ).text());
                var extracharges = jQuery( "#extrafees" ).val();
//                var coursestartdate = jQuery( "#coursestartdate option:selected" ).text();
                var coursestartdate = jQuery( "#course_date").val();
                var course_level = jQuery( "#course_level :selected" ).text();
                var acczone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val();
                var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());
//                jQuery.ajax({
//                    url: site_url+"/wp-admin/admin-ajax.php?action=getacczone",
//                    type: "POST",
//                    data: {
//                        'cat_id' : cat_id,
//                    },
//                    success:function(result){ 
////                        jQuery("#acc_zone").html("");
////                        jQuery("#acc_zone").append(result); 
//                        $('.selectpicker').selectpicker('refresh');
//                    }
//                });

                var is_set_charge = '';
                if(jQuery('#you-ex-student').val() == 'yes'){
                    is_set_charge = 'yes';
                } else {
                    is_set_charge = 'no';
                } 

                jQuery.ajax({
                //get variation product id
                url: site_url+"/public_html/wp-content/themes/skilled-child/functions.php",
                type: "POST",
                data: {
    //                'course_level': course_level,
                    'acczone' : acczone,
                    'product_id' : cat_id
                },
                success:function(result){
                jQuery.ajax({
                    type: 'post',
//                    url: site_url+'/wp-admin/admin-ajax.php?action=remove_cart_data',
                    url: site_url+'/wp-admin/admin-ajax.php',
                    data: {
                            action: 'remove_acc_cart_data'
                    },
                    success: function( result1 ) {
						
                        setTimeout(function(){
                                jQuery.get(site_url+'/cart/?post_type=product&add-to-cart=' + cat_id +'&variation_id='+result +'&quantity='+coursesweek_number+'&attribute_pa_zone='+acczone,
                                function() {});
                                },100);
								
                                setTimeout(function(){

                                        var back_accomdation = jQuery( "#accomdation option:selected" ).val();
                                        var back_meal_plan = jQuery( "#prod-acc-meal-plan option:selected" ).val();
                                        var back_product_acc_zone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
                                        var back_accomodation_week = jQuery( "#accomodation_week option:selected" ).val();
                                        var back_acc_startdate = jQuery( "#acc_startdate" ).val();
                                        var back_acc_enddate = jQuery( "#acc_enddate" ).val();

                                        var back_acc_supplement = jQuery( "#acc_supplement option:selected" ).val();
                                        var back_smoke = jQuery( "#smoke option:selected" ).val();
                                        var back_petbother = jQuery( "#petbother option:selected" ).val();
                                        var back_allergies = jQuery( "#allergies" ).val();
                                        var back_allergiestype = jQuery( "#allergiestype" ).val();

                                        var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                                        var back_flightname = jQuery( "#flightname" ).val();
                                        var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                                        var back_departuredate = jQuery( "#departuredate" ).val();                                

                                        var back_visa_require = jQuery( "#visa_require" ).val(); 

                                        jQuery.ajax({
                                                type: 'post',
                                                url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
                                                data: {
                                                        action: 'show_acc_cart_data',
                                                        'extracharges' : extracharges,
//                                                        'coursesweek_number': coursesweek_number,
                                                        acc_week : acc_week,
                                                        coursestartdate :coursestartdate,
                                                        course_level : course_level,
                                                        fee_charge : is_set_charge,
                                                        'back_accomdation' : back_accomdation,
                                                        'back_meal_plan' : back_meal_plan,
                                                        'back_product_acc_zone' : back_product_acc_zone,
                                                        'back_accomodation_week' : back_accomodation_week,
                                                        'back_acc_startdate' : back_acc_startdate,
                                                        'back_acc_enddate' : back_acc_enddate,

                                                        'back_acc_supplement' : back_acc_supplement,
                                                        'back_smoke' : back_smoke,
                                                        'back_petbother' : back_petbother,
                                                        'back_allergies' : back_allergies,
                                                        'back_allergiestype' : back_allergiestype,

                                                        'back_transport_type' : back_transport_type,
                                                        'back_flightname' : back_flightname,
                                                        'back_arrivaldate' : back_arrivaldate,
                                                        'back_departuredate' : back_departuredate,

                                                        'back_visa_require' : back_visa_require,
                                                },
                                                success: function( result ) {
													console.log("accomodation cart:" + result);
                                                    if(result == '<table>'){
                                                        changeWeek();
                                                    } else {
                                                        jQuery("#accomodation_cart").html(result);  
                                                    }                                                    	
                                                    jQuery('.sk-fading-circle').hide();
                                                }
                                        });
                                }, 3000);
                        
                    }
                });
                }
                });
                if(cat_id == ""){
                    accfieldsset(1);
                }else{
                    accfieldsset(0);
                }
	}
        jQuery(document).on( 'change', '#prod-acc-meal-plan', get_acczones);
        
        function get_acczones(){ 
            var product_id = jQuery("#prod-acc-meal-plan option:selected").val(); 

            //jQuery('#allow_hide').hide();
            hideOthers();

            jQuery.ajax({
                type: 'post',
                url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_zones',
                data: {
                        action: 'show_acc_zones',
                        'productid': product_id
                },
                success: function( result ) {
                    jQuery("#div_acczones").html(result);

                    //jQuery('#allow_hide').show();
                    var product_acc_flatshare = jQuery( "#accomdation option:selected" ).val();
                    if(product_acc_flatshare != 4 && product_acc_flatshare != 5 && product_acc_flatshare != 6){
                        showOthers();                    
                    }

                    changeWeek();
                }
            });
        }
        
		jQuery(document).on( 'change', '#prod-acc-meal-plan', accomChange);
		jQuery(document).on( 'change', '#acc_zone input:radio', accomChange);
        jQuery(document).on( 'change', '#accomodation_week', accomChange);
        
//	jQuery(document).on( 'change', '#acc_zone', function() {
//                var product_id = jQuery( "#accomdation option:selected" ).val();
//                var zone_slug = jQuery("#acc_zone").val();               
//                var extracharges = jQuery( "#extrafees" ).val();
//                var coursestartdate = jQuery( "#course_date").val();
//                var course_level = jQuery( "#course_level :selected" ).text();
//                jQuery('.sk-fading-circle').show();
//                                   
//                        jQuery.ajax({
//                        type: 'post',
//                        url: site_url+'/wp-admin/admin-ajax.php',
//                        data: {
//                                action: 'remove_accomadationcart_data',
//				'add_product_id' :zone_slug,
//                        },
//                        success: function( ) {  }  });
//
//                        setTimeout(function(){
//                                jQuery.ajax({
//                                        type: 'post',
//                                        url: site_url+'/wp-admin/admin-ajax.php',
//                                        data: {
//                                                action: 'show_acc_cart_data',
//                                                'extracharges' : extracharges,
//                                                coursestartdate :coursestartdate,
//                                                course_level : course_level
//                                        },
//                                        success: function( result ) {
//                                            jQuery("#accomodation_cart").html(result);	
//                                            jQuery('.sk-fading-circle').hide();
//                                        }
//                                });
//                            }, 1000);	 
//	});
        
        
        jQuery(document).on( 'change', '#transport_type', function() {
                var product_id = jQuery( "#transport_type option:selected" ).val();
                var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());  
                var extracharges = jQuery( "#extrafees" ).val();
                var coursestartdate = jQuery( "#course_date").val();
                var course_level = jQuery( "#course_level :selected" ).text();

                var is_set_charge = '';
                if(jQuery('#you-ex-student').val() == 'yes'){
                    is_set_charge = 'yes';
                } else {
                    is_set_charge = 'no';
                }

                jQuery('.sk-fading-circle').show();
                    jQuery.ajax({
                            url: site_url+"/wp-admin/admin-ajax.php?action=add_transportdata",
                            type: "POST",
                            data: {
                                 action : 'add_transportdata',
                                'acctransportproc_id' : product_id,
                            },
                            success:function(result){
                                setTimeout(function(){

                                        var back_accomdation = jQuery( "#accomdation option:selected" ).val();
                                        var back_meal_plan = jQuery( "#prod-acc-meal-plan option:selected" ).val();
                                        var back_product_acc_zone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
                                        var back_accomodation_week = jQuery( "#accomodation_week option:selected" ).val();
                                        var back_acc_startdate = jQuery( "#acc_startdate" ).val();
                                        var back_acc_enddate = jQuery( "#acc_enddate" ).val();

                                        var back_acc_supplement = jQuery( "#acc_supplement option:selected" ).val();
                                        var back_smoke = jQuery( "#smoke option:selected" ).val();
                                        var back_petbother = jQuery( "#petbother option:selected" ).val();
                                        var back_allergies = jQuery( "#allergies" ).val();
                                        var back_allergiestype = jQuery( "#allergiestype" ).val();

                                        var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                                        var back_flightname = jQuery( "#flightname" ).val();
                                        var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                                        var back_departuredate = jQuery( "#departuredate" ).val();                                

                                        var back_visa_require = jQuery( "#visa_require" ).val(); 

                                        jQuery.ajax({
                                                type: 'post',
                                                url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
                                                data: {
                                                        action: 'show_acc_cart_data',
                                                        'extracharges' : extracharges,
                                                        acc_week : acc_week,
                                                        coursestartdate :coursestartdate,
                                                        course_level : course_level,
                                                        fee_charge : is_set_charge,
                                                        'back_accomdation' : back_accomdation,
                                                        'back_meal_plan' : back_meal_plan,
                                                        'back_product_acc_zone' : back_product_acc_zone,
                                                        'back_accomodation_week' : back_accomodation_week,
                                                        'back_acc_startdate' : back_acc_startdate,
                                                        'back_acc_enddate' : back_acc_enddate,

                                                        'back_acc_supplement' : back_acc_supplement,
                                                        'back_smoke' : back_smoke,
                                                        'back_petbother' : back_petbother,
                                                        'back_allergies' : back_allergies,
                                                        'back_allergiestype' : back_allergiestype,

                                                        'back_transport_type' : back_transport_type,
                                                        'back_flightname' : back_flightname,
                                                        'back_arrivaldate' : back_arrivaldate,
                                                        'back_departuredate' : back_departuredate,

                                                        'back_visa_require' : back_visa_require,
                                                },
                                                success: function( result ) {
                                                    if(result == '<table>'){
                                                        changeWeek();
                                                    } else {
                                                        jQuery("#accomodation_cart").html(result);  
                                                    }
                                                    jQuery('.sk-fading-circle').hide();
                                                }
                                        });
                                }, 1000);
                            }   
                        });
	});
	jQuery(document).on( 'change', '#visa_require', function() {
                var product_id = jQuery( "#visa_require option:selected" ).val();
                var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());  
                var extracharges = jQuery( "#extrafees" ).val();
                var coursestartdate = jQuery( "#course_date").val();
                var course_level = jQuery( "#course_level :selected" ).text();

                var is_set_charge = '';
                if(jQuery('#you-ex-student').val() == 'yes'){
                    is_set_charge = 'yes';
                } else {
                    is_set_charge = 'no';
                }

                var isvisafee = '';
                if(product_id != ''){
                    isvisafee = 'yes';
                } else {
                    isvisafee = 'no';
                }
        
                jQuery('.sk-fading-circle').show();
                    jQuery.ajax({
                            url: site_url+"/wp-admin/admin-ajax.php?action=add_visadata",
                            type: "POST",
                            data: {
                                 action : 'add_visadata',
                                'accvisaproc_id' : product_id,
                            },
                            success:function(result){
                                setTimeout(function(){

                                        var back_accomdation = jQuery( "#accomdation option:selected" ).val();
                                        var back_meal_plan = jQuery( "#prod-acc-meal-plan option:selected" ).val();
                                        var back_product_acc_zone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
                                        var back_accomodation_week = jQuery( "#accomodation_week option:selected" ).val();
                                        var back_acc_startdate = jQuery( "#acc_startdate" ).val();
                                        var back_acc_enddate = jQuery( "#acc_enddate" ).val();

                                        var back_acc_supplement = jQuery( "#acc_supplement option:selected" ).val();
                                        var back_smoke = jQuery( "#smoke option:selected" ).val();
                                        var back_petbother = jQuery( "#petbother option:selected" ).val();
                                        var back_allergies = jQuery( "#allergies" ).val();
                                        var back_allergiestype = jQuery( "#allergiestype" ).val();

                                        var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                                        var back_flightname = jQuery( "#flightname" ).val();
                                        var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                                        var back_departuredate = jQuery( "#departuredate" ).val();                                

                                        var back_visa_require = jQuery( "#visa_require" ).val(); 

                                        jQuery.ajax({
                                                type: 'post',
                                                url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
                                                data: {
                                                        action: 'show_acc_cart_data',
                                                        'extracharges' : extracharges,
                                                        acc_week : acc_week,
                                                        coursestartdate :coursestartdate,
                                                        course_level : course_level,
                                                        fee_charge : is_set_charge,
                                                        visaextrafee : isvisafee,
                                                        'back_accomdation' : back_accomdation,
                                                        'back_meal_plan' : back_meal_plan,
                                                        'back_product_acc_zone' : back_product_acc_zone,
                                                        'back_accomodation_week' : back_accomodation_week,
                                                        'back_acc_startdate' : back_acc_startdate,
                                                        'back_acc_enddate' : back_acc_enddate,

                                                        'back_acc_supplement' : back_acc_supplement,
                                                        'back_smoke' : back_smoke,
                                                        'back_petbother' : back_petbother,
                                                        'back_allergies' : back_allergies,
                                                        'back_allergiestype' : back_allergiestype,

                                                        'back_transport_type' : back_transport_type,
                                                        'back_flightname' : back_flightname,
                                                        'back_arrivaldate' : back_arrivaldate,
                                                        'back_departuredate' : back_departuredate,

                                                        'back_visa_require' : back_visa_require,
                                                },
                                                success: function( result ) {
                                                    if(result == '<table>'){
                                                        changeWeek();
                                                    } else {
                                                        jQuery("#accomodation_cart").html(result);  
                                                    }
                                                    jQuery('.sk-fading-circle').hide();
                                                }
                                        });
                                }, 1000);
                            }   
                        });
	});
         //code to add validation on "Add to Cart" button
        jQuery('#btn_cart_proceed').click(function(){
            //code to add validation, if any
            //If all values are proper, then send AJAX request
//            alert('sending ajax request');
            var product_id = jQuery( "#prod-acc-meal-plan option:selected" ).val();     
        })
    });
</script>
        
        
        <form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>
