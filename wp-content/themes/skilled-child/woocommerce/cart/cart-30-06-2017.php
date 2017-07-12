<?php
// Start the session loginf
session_start(); //echo '<pre>'; print_r($_SESSION); echo '</pre>';
$site_url= get_site_url();
?>

<!--<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">-->
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/css/bootstrap-select.css" />
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/css/sweetalert.css" />
  <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
  <!--<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
<script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/js/moment.min.js"></script>
<script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/js/bootstrap-select.js"></script>
<script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/js/jquery.validate.js"></script>
<script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/js/sweetalert.min.js"></script>

    	  
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
/*  echo '<a href="javascript:void(0)" id="tool">rrrrrrrr</a>';*/
$count = count($product_categories);
if ( $count > 0 ){
    echo '<div id="cart_step1" class="cart-step1">';
    foreach ( $product_categories as $product_category ) {
        if($product_category->slug == '1course' || $product_category->slug == '2accomdation' || $product_category->slug == '3extras' || $product_category->slug == 'visa'){
            if($product_category->name =='Accomodation') {
                    echo '<h4 ><div class="extra-second-section">Accommodation</div></h4>';        
            } else {

            echo '<h4 ><div class="extra-second-section">' . $product_category->name . '</div></h4>';
            }
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
        $args2 = array(
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
            'orderby' => 'ID',
            'order' =>'DESC'
        );
        $products2 = new WP_Query( $args2 );
       
        if($product_category->slug == '1course') { ?>
            <select id="getProductOption" onchange='getProductOption()' name="getProductOption">
                <option value='0' <?php if(empty($_SESSION['course']['back_getProductOption'])) { ?>selected<?php } ?>>Course type</option>
                <option value='1' <?php if($_SESSION['course']['back_getProductOption'] == 1) { ?>selected<?php } ?>>Callan Method</option>
                <option value='2' <?php if($_SESSION['course']['back_getProductOption'] == 2) { ?>selected<?php } ?>>General English</option>
                <option value='3' <?php if($_SESSION['course']['back_getProductOption'] == 3) { ?>selected<?php } ?>>Intensive English</option>
                <option value='5' <?php if($_SESSION['course']['back_getProductOption'] == 5) { ?>selected<?php } ?>>Exam Courses</option>
                <option value='4' <?php if($_SESSION['course']['back_getProductOption'] == 4) { ?>selected<?php } ?>>One-to-one</option>
            </select>
            <div class="radio-ctype" style="display:block;padding:0 0 10px;">
                <?php global $wc_cpdf;
                $icnt = 0; 
                while ( $products->have_posts() ) { $products->the_post(); $icnt++; ?>
                    <span class="prod-radio" id="prod-<?php echo $icnt; ?>" style="display:none;padding-right:10px;"><input type="radio" name="productname" class="productname" value="<?php the_id(); ?>"> <?php echo $wc_cpdf->get_value(get_the_ID(), 'product_radio_title'); ?></span>
                <?php } ?>
            </div>
            <p class="hide_show" style="display: none; color: red;">Please select one course category.</p>

            <?php 
//          echo "<div id='coursestartdate'>";
//          echo "<select disabled><option>Select Start Date</option></select>";
//          echo "</div>";
          
            echo "<div id='coursestartdate' style='display:none'>";
            echo "<input type='text' name='course_date' id='course_date' readonly  autocomplete='off' placeholder='Course start date' >";
            echo "</div>";

            echo "<div id='courseweekdiv' style='display:none'>";
            echo "<select id='courseweek' disabled><option>Course length</option></select>";
            echo "</div>";       
            
            echo "<div id='feedback' style='display:none'>";
            echo "<select disabled><option>I think my level is</option></select>";
            echo "</div>";

            echo "<div id='ex-student' style='display:none'>";
            echo "<select id='you-ex-student' ><option value='' selected='selected'>Are you an ex-student?</option><option value='yes'>YES - no registration fee added</option><option value='no'>NO - registration fee added</option></select>";
            echo "</div>";
            
            echo "<div class='spinner'></div>";
            echo "<input type='hidden' value='' class='slected_val'>";

        }
        
        if($product_category->slug == '2accomdation') { ?>
            <select id='accomdation' name="accomdation" onchange='allowShowAccOption()' disabled>
                <option <?php if(empty($_SESSION['accomodation']['back_accomdation'])) { ?>selected="selected"<?php } ?> value="1">No accommodation required</option>
                <optgroup label="Homestay">
                    <option value="2">Homestay - Single room</option>
                    <option value="3">Homestay - Double (two students arriving together)</option>
                </optgroup>
                <optgroup label="Flatshare">
                    <option value="4">Flatshare - Single room</option>
                    <option value="5">Flatshare - Twin room to share with another student of the same sex</option>
                   <!--  <option value="6">Flatshare - Twin room (2 students)</option> -->
                </optgroup> 
                <optgroup label="Halls of residence">
                    <option value="7">Halls of residence - Single room</option>
                   
                </optgroup>
            </select>

            <div class="radio-ctype" style="display:block;">
                <span class="prod-radio-acco" style="display:none;">
                    <select id="prod-acc-meal-plan"> 
                        <option value="">Select meal plan</option>                                       
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

            echo "<div class='accselovr'><div class='accselct'>";
            echo "<select id='accomodation_week' disabled=''><option>Accommodation Length</option></select>";
            echo "</div>";

            echo "<div id='div_accsupplement'>";
            echo "<select name='acc_supplement' id='acc_supplement'>
					<option value=''>Are you under 18?</option>
                    <option value='yes'>Yes</option>
                    <option value='no'>No</option>
                  </select>";
            echo "</div></div>";
            
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
			echo "<select name='bathroom' id='bathroom' ><option value=''>Do you need private bathroom?</option>
                            <option value='yes'>Yes</option>
                            <option value='no'>No</option>
                    </select>";
            echo '<div class="allergies-left"><input class="css-checkbox" type="checkbox" name="allergies" id="allergies" disabled value="Do you have Allergies?"><label for="allergies" class="css-label">Do you have allergies ?</label></div>';
            
            echo '<div class="allergies-right"><input type="text" style="display:none;" maxlength="100" name="allergiestype" id="allergiestype" disabled placeholder="type allergies here"></div><br>';
            
                    
        }
        if($product_category->slug == '3extras') {  
            echo "<select id='transport_type' disabled=''><option value='' selected>No airport transport required</option>";
            while ( $products2->have_posts() ) {
                $products2->the_post();
                ?>
                    <option value="<?php the_id(); ?>">
                            <?php the_title(); ?>
                    </option>
             <?php
            }
            echo "</select>"; 
            
            echo '<input type="text" name="flightname" id="flightname"  maxlength="20" disabled placeholder="Flight Number"><br>';
            
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
            echo "<select name='visa_require' id='visa_require' disabled><option value='' selected>No visa required</option>";
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
    echo '<a href="javascript:void(0)" class="checkout-button button alt wc-forward cart-next-btn"  id="btn_cart_proceed">Next</a>';
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
        jQuery("#courseweekdiv").html("<select id='courseweek' disabled><option >Course length</option></select>");
		jQuery("#courseweekdiv").show();
        jQuery("#feedback").html("<select disabled><option>I think my level is</option></select>");
		jQuery("#feedback").show();
        jQuery("#ex-student").show();
    }  
    function resetAccData(){
        jQuery("#accomdation").val("1");
        jQuery("#accomdation").prop('disabled', true);
        jQuery("#visa_require").prop('disabled', true);
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
            jQuery("#visa_require").prop('disabled', bool);
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
        jQuery("#prod-acc-meal-plan").children("option[value^=21124]").hide();    

        jQuery("#prod-acc-meal-plan").children("option[value^=19861]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19857]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19851]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19847]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19843]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19839]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19835]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19831]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19829]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19828]").attr("disabled","disabled");
        jQuery("#prod-acc-meal-plan").children("option[value^=19827]").attr("disabled","disabled"); 
        jQuery("#prod-acc-meal-plan").children("option[value^=21124]").attr("disabled","disabled"); 
    }

    function allowShowAccOption(){
        var prod_id = jQuery( "#accomdation option:selected" ).val();
        $('.oned').hide();
        $('.one20').hide();
        $('.one1').hide();
        $('.one2').hide();
        $('.sm_yes').hide();
        $('.sm_no').hide();
        $('.pet_yes').hide();
        $('.pet_no').hide();
        $('.aller').hide();
        $('.aller1').hide();
        $('.aller2').hide();
        $('.aller3').hide();
        $('#petbother').change();
        $('#smoke').change();
        $('#flightname').val('');
		$('#arrivaldate').val('');
		$('#departuredate').val(''); 
        if(prod_id == 0 || prod_id == 1){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();

			jQuery('.prod-radio-acco').hide();
			<?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){ ?>
			<?php } else { ?>
				$("#prod-acc-meal-plan").val('').trigger('change');
				setTimeout(function(){
				$('#transport_type').val('').change();
				$('#course_level').change();

				},300);
			<?php } ?>
            
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

            jQuery("#prod-acc-meal-plan").children("option[value^=19861]").removeAttr("disabled"); 
            jQuery("#prod-acc-meal-plan").children("option[value^=19857]").removeAttr("disabled"); 
            jQuery("#prod-acc-meal-plan").children("option[value^=19851]").removeAttr("disabled"); 
            jQuery("#prod-acc-meal-plan").children("option[value^=19847]").removeAttr("disabled"); 
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

            jQuery("#prod-acc-meal-plan").children("option[value^=19843]").removeAttr("disabled"); 
            jQuery("#prod-acc-meal-plan").children("option[value^=19839]").removeAttr("disabled"); 
            jQuery("#prod-acc-meal-plan").children("option[value^=19835]").removeAttr("disabled"); 
            jQuery("#prod-acc-meal-plan").children("option[value^=19831]").removeAttr("disabled"); 
        }
        if(prod_id == 4){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-9').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').hide();
            jQuery("#prod-acc-meal-plan").children("option[value^=19829]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19829]").removeAttr("disabled");

            jQuery("#prod-acc-meal-plan option[value^=19829]").attr("selected", "selected");
              <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){ ?>
              <?php } else { ?>
				jQuery("#prod-acc-meal-plan").trigger('change');
              <?php } ?>
           
        }
        if(prod_id == 5){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-10').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').hide();
            jQuery("#prod-acc-meal-plan").children("option[value^=19828]").show();    
            jQuery("#prod-acc-meal-plan").children("option[value^=19828]").removeAttr("disabled");

            jQuery("#prod-acc-meal-plan option[value^=19828]").attr("selected", "selected");
			<?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){ ?>
			<?php } else { ?>
				jQuery("#prod-acc-meal-plan").trigger('change');
			<?php } ?>
        }
        if(prod_id == 6){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-11').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').hide();
            jQuery("#prod-acc-meal-plan").children("option[value^=19827]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=19827]").removeAttr("disabled");

            jQuery("#prod-acc-meal-plan option[value^=19827]").attr("selected", "selected");
				<?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){ ?>
                <?php } else { ?>
                    jQuery("#prod-acc-meal-plan").trigger('change');
                <?php } ?>
        } 
        if(prod_id == 7){
            //jQuery('#prod-acco-1, #prod-acco-2, #prod-acco-3, #prod-acco-4, #prod-acco-5, #prod-acco-6, #prod-acco-7, #prod-acco-8, #prod-acco-9, #prod-acco-10, #prod-acco-11, #prod-acco-12').hide();
            //jQuery('#prod-acco-11').show();
            AccMealPlanReset();
            jQuery('.prod-radio-acco').hide();
            jQuery("#prod-acc-meal-plan").children("option[value^=21124]").show();
            jQuery("#prod-acc-meal-plan").children("option[value^=21124]").removeAttr("disabled");

            jQuery("#prod-acc-meal-plan option[value^=21124]").attr("selected", "selected");
				<?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){ ?>
				<?php } else { ?>
					jQuery("#prod-acc-meal-plan").trigger('change');
				<?php } ?>
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
        $('.hide_show').hide();
        $('.oned').hide();
        $('.one20').hide();
        $('.one1').hide();
        $('.one2').hide();
        $('.sm_yes').hide();
        $('.sm_no').hide();
        $('.pet_yes').hide();
        $('.pet_no').hide();
        $('.aller').hide();
        $('.aller1').hide();
        $('.aller2').hide();
        $('.aller3').hide();
        $('#petbother').change();
        $('#smoke').change();

      $('#flightname').val('');
            $('#arrivaldate').val('');
            $('#departuredate').val(''); 
           // $('.prod-radio input').removeAttr('checked');
           <?php 

        if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){  ?>
            //alert('f');
       <?php  } else{ ?>
            $('.prod-radio input').removeAttr('checked');
        <?php }?>
        if(prod_id == 0){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12,#prod-13').hide();
            $('#getProductOption').addClass('red');
        }
        if(prod_id == 1){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12,#prod-13').hide();
            jQuery('#prod-5, #prod-2, #prod-3, #prod-4').show();
            $('#getProductOption').removeClass('red');
            //$("#prod-1 .productname").attr('checked', true).trigger('click');
           // $("input:radio:first").prop("checked", true).trigger("click");
        }
        if(prod_id == 2){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12,#prod-13').hide();
            jQuery('#prod-6').show();
             $('#getProductOption').removeClass('red');
            //$("#prod-5 .productname").attr('checked', true).trigger('click');
             //$("input:radio:first").prop("checked", true).trigger("click");
        }
        if(prod_id == 3){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12,#prod-13').hide();
            jQuery('#prod-9, #prod-7, #prod-8').show();
             $('#getProductOption').removeClass('red');
           // $("#prod-6 .productname").attr('checked', true).trigger('click');
             //$("input:radio:first").prop("checked", true).trigger("click");
        }
        if(prod_id == 4){
            jQuery('#prod-1, #prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12,#prod-13').hide();
            jQuery('#prod-12, #prod-10, #prod-11').show();
             $('#getProductOption').removeClass('red');
           // $("#prod-9 .productname").attr('checked', true).trigger('click');
             //$("input:radio:first").prop("checked", true).trigger("click");
        }
        if(prod_id == 5){
            jQuery('#prod-2, #prod-3, #prod-4, #prod-5, #prod-6, #prod-7, #prod-8, #prod-9, #prod-10, #prod-11, #prod-12,#prod-1,#prod-13').hide();
            jQuery('#prod-1,#prod-13').show();
             $('#getProductOption').removeClass('red');
           // $("#prod-12 .productname").attr('checked', true).trigger('click');
             //$("input:radio:first").prop("checked", true).trigger("click");
        }
       // $('#productname').val(1).change();
        //$('#visa_require').val('').change();
        if($('#visa_require').val()!=''){
             <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){ ?>
                  // $('#visa_require').change();
                <?php } ?>
            
        }
         jQuery("#visa_require").prop('disabled', true);
         jQuery('.prod-radio-acco').hide();
         jQuery('#allow_hide').hide();
         //$('#productname').val(1).change();
    }
   
    jQuery('.cart-step1').on("click",".prod-radio input:radio",function() {
        $('#petbother').change();
        $('#smoke').change();
        $('#flightname').val('');
        $('#arrivaldate').val('');
        $('#departuredate').val(''); 
        $('.hide_show').hide();
        $('body').addClass('show_loader');
        jQuery("#accomdation").prop('disabled', true);
        jQuery("#visa_require").prop('disabled', true);
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
                if($('#getProductOption').val()==0){
                    jQuery("#accomodation_cart").html("");
                   
                }else {
                    var newval ='';
                     valuenew = $.trim($("input[name='productname']:checked").parent('span').text());
                     //console.log(valuenew);
                        if(valuenew=='5 lessons') {
                            newval =' 5 lessons (Callan light)';
                        } else if(valuenew=='10 lessons'){
                             newval =' 10 lessons (Callan essential)';
                        } else if(valuenew=='15 lessons'){
                             newval =' 15 lessons (Callan intensive)';
                        } else if(valuenew=='20 lessons'){
                             newval =' 20 lessons (Callan super intensive)';
                        } else{
                            newval = $("input[name='productname']:checked").parent('span').text() ;
                        }
                     jQuery("#accomodation_cart").html('<div id="accomodation_cart"><table><tbody><tr><td colspan="2"><div class="maincart"><div class="proc_name marbottom20 mob-padtb20"><b style="color:#32a3aa;font-size:18px;font-weight:400;">Shopping cart</b></div></div></td></tr><tr><td colspan="2"><div class="maincart"><div class="proc_name"><b class="product-name">'+ $('#getProductOption option:selected').html() +' &ndash;'+ newval +'</b></div></div></td> <tr  class="accu_r"><td colspan="2"><div class="maincart"><div class="proc_name"><b>Accommodation</b></td></tr><tr class="accu_r2"><td><ul class="check-list"><li><div class="acc-supply">No accommodation required</div></li></ul></td></tr><tr  class="accu_m"><td colspan="2"><div class="maincart"><div class="proc_name"><b>Visa</b></td></tr><tr  class="accu_m2"><td><ul class="check-list"><li><div class="acc-supply">No visa required</div></li></ul></td></tr><tr><td><br></td></tr></tbody></table></div>');
                     $('.accu_r').show();
                     $('.accu_r2').show();
                }

                <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                if(!empty($_SESSION['course']['back_coursestartdate']) && $_SESSION['course']['back_coursestartdate'] != ''){ ?>
                    jQuery("#course_date").val("<?php echo $_SESSION['course']['back_coursestartdate']; ?>");
                    setWeeks();
                <?php } } ?>
                $('body').removeClass('show_loader');
            }
        });
    });

    jQuery('.cart-step1').on("change","#you-ex-student",function() {
        $('body').addClass('show_loader');
            $('.oned').hide();
            $('.one20').hide();
            $('.one1').hide();
            $('.one2').hide();
            $('.sm_yes').hide();
            $('.sm_no').hide();
            $('.pet_yes').hide();
            $('.pet_no').hide();
            $('.aller').hide();
            $('.aller1').hide();
            $('.aller2').hide();
            $('.aller3').hide();
            $('#petbother').change();
            $('#smoke').change();
            $('#flightname').val('');
            $('#arrivaldate').val('');
            $('#departuredate').val(''); 
            $('#petbother').change();
            $('#smoke').change();
        var is_set_charge = ''; 
       // var is_set_charge = 'yes';

        if(jQuery(this).val() == 'yes'){
            is_set_charge = 'yes';
        } else {
            is_set_charge = 'no';
        }
        var is_acc_supplement = '';
        if(jQuery('#acc_supplement').val() == 'yes'){
            is_acc_supplement = 'yes';
        } else {
            is_acc_supplement = 'no';
        }
        //jQuery('.sk-fading-circle').show();

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
                if(back_smoke=='yessmpoke'){
                back_smoke = 'Yes';
                } else if(back_smoke == 'nosmpoke'){
                back_smoke = 'No';
                } else {
                back_smoke = '';
                }if(back_petbother=='yespetbother'){
                back_petbother = 'Yes';
                } else if(back_smoke == 'nopetbother'){
                back_petbother = 'No';
                } else {
                back_petbother = '';
                }
                var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                var back_flightname = jQuery( "#flightname" ).val();
                var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                var back_departuredate = jQuery( "#departuredate" ).val();                                
                var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
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
ex:is_set_charge,
                            under_18: is_acc_supplement,
                            'back_accomdation' : back_accomdation,
                            'back_meal_plan' : back_meal_plan,
                            'back_product_acc_zone' : back_product_acc_zone,
                            'back_accomodation_week' : back_accomodation_week,
                            'back_acc_startdate' : back_acc_startdate,
                            'back_acc_enddate' : back_acc_enddate,
                            'back_productid': back_product_id, 
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
                            setTimeout(function(){
                           /* $('.accu_r').show();
                            $('.accu_r2').show();*/

                            },100);
                        } 
                         if($('#allow_hide').is(":visible")==false){
                                                           $('.one1').hide();
                                                           $('.one2').hide();
                                                           $('.accu_r').show();
                                                           $('.accu_r2').show();
                                                           $('.accu_m').show();
                                                           $('.accu_m2').show();
                                                          
                                                        }  else{
                                                           $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                                        }
                                             var yes = $('#acc_supplement').val();
                                            //alert(yes);
                                            if(yes=='yes'){
                                                $('.one20').hide();
                                                $('.oned').show();
                                                }else if(yes=='no'){
                                                $('.one20').show();
                                                $('.oned').hide();
                                                }else {
                                                $('.oned').hide();
                                                $('.one20').hide();
                                            }
                       $('body').removeClass('show_loader');
                    }
                });
        //    }
        //});

    });

    jQuery('.cart-step1').on("change","#acc_supplement",function() {
        var is_set_charge = '';
		$('body').addClass('show_loader');
        if(jQuery(this).val() == 'yes'){
            is_set_charge = 'yes';
        } else {
            is_set_charge = 'no';
        }
       
        var is_acc_supplement = ''; 
        var is_acc_supplement1 = 'yes';
        if(jQuery('#you-ex-student').val() == 'yes'){
            is_acc_supplement = 'yes';
        } else {
            is_acc_supplement = 'no';
        }
		var product_id = 21195;
		var startdate = $("#acc_startdate").val().split("/");
		var first = new Date(startdate[2]+"-"+startdate[1]+"-"+startdate[0]);
		var enddate = $("#acc_enddate").val().split("/");
		var second = new Date(enddate[2]+"-"+enddate[1]+"-"+enddate[0]);
		var days = Math.round((second-first)/(1000*60*60*24));
		var week_nos = Math.round(days/7);
		
		if(jQuery(this).val() == 'yes'){
			jQuery.get(site_url+'/?add-to-cart=' + product_id +'&quantity='+week_nos, function(){
				show_acc_cart_data();
			});
		}
		
		if(jQuery(this).val() == 'no'){
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					 action : 'remove_under_18'
				},
				success: function(){
					show_acc_cart_data();
				}
			});
		}
	});
    
    function getcourselevel(s){
        //get all course levels
            $('#petbother').change();
            $('#smoke').change();
           $('#flightname').val('');
            $('#arrivaldate').val('');
            $('#departuredate').val(''); 
             $('#petbother').change();
        $('#smoke').change();
        var course_level = jQuery( "#course_level :selected" ).val();
        if(!course_level){
        var product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
        $('body').addClass('show_loader');
        setTimeout(function(){
            $('body').addClass('show_loader');
        jQuery.ajax({
            type: 'post',
            url: site_url+'/wp-admin/admin-ajax.php?action=show_course_data',
            data: {
                    action: 'show_course_data',
                    'productid': product_id
            },
            success: function( result ) {

                jQuery("#feedback").html(result);
               
                <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                if(!empty($_SESSION['course']['back_course_level']) && $_SESSION['course']['back_course_level'] != ''){ ?>
                    jQuery("#course_level option[value=<?php echo $_SESSION['course']['back_course_level']; ?>]").attr('selected','selected');
                    jQuery("#course_level").trigger('change');
                <?php } } ?>

                <?php /*if(!empty($_SESSION['fee_charge']) && $_SESSION['fee_charge'] != ''){ ?>
                    jQuery("#ex-student option[value=<?php echo $_SESSION['fee_charge']; ?>]").attr('selected','selected');                    
                <?php }*/ ?>
               // $('body').removeClass('show_loader');
            } ,  complete: function(){
                 // Handle the complete event
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
                 });
        },500);
        }
        //set accommodation course weeks dropdown
       
              
            
    }
    
    function changeWeek(){
        $('.oned').hide();
        $('.one20').hide();
        //$('.one1').hide();
        //$('.one2').hide();
        if($('#allow_hide').is(":visible")==false){
        $('.sm_yes').hide();
        $('.sm_no').hide();
        $('.pet_yes').hide();
        $('.pet_no').hide();
        } 
      
        $('.aller').hide();
        $('.aller1').hide();
        $('.aller2').hide();
        $('.aller3').hide();
        $('#petbother').change();
        $('#smoke').change();
        $('#flightname').val('');
        $('#arrivaldate').val('');
        $('#departuredate').val(''); 
        $('#petbother').change();
        $('#smoke').change();
        
        $('body').addClass('show_loader');
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
        //var is_set_charge = 'yes';
        if(jQuery('#you-ex-student').val() == 'yes'){
            is_set_charge = 'yes';
        } else {
            is_set_charge = 'no';
        }

        var is_acc_supplement = '';
        if(jQuery('#acc_supplement').val() == 'yes'){
            is_acc_supplement = 'yes';
        } else {
            is_acc_supplement = 'no';
        }

      /*  var is_acc_supplement = '';
        if(jQuery('#acc_supplement').val() == 'yes'){
            is_acc_supplement = 'yes';
        } else {
            is_acc_supplement = 'no';
        }*/

         //jQuery('.sk-fading-circle').show();
         
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
                $('body').addClass('show_loader');
             jQuery.ajax({
                    type: 'post',
                    url: site_url+'/wp-admin/admin-ajax.php?action=remove_acc_cart_data',
                    data: {
                            action: 'remove_acc_cart_data'
                    },
                    success: function( result1 ) {
                        $('body').addClass('show_loader');
                       // if(acczone!=undefined) {
                        setTimeout(function(){
                             var acczone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
                           //  alert(acczone);
                        jQuery.get(site_url+'/cart/?post_type=product&add-to-cart=' + cat_id +'&variation_id='+result +'&quantity='+week_nos+'&attribute_pa_zone='+acczone,
                        function() {});
                        },500);
                        //}
                        jQuery.ajax({
                            url: site_url+"/wp-admin/admin-ajax.php?action=add_transportdata",
                            type: "POST",
                            data: {
                                 action : 'add_transportdata',
                                'acctransportproc_id' : product_id,
                            },
                            success:function(result){
                                 $('body').addClass('show_loader');
                            setTimeout(function(){
                                $('body').addClass('show_loader');
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
                                if(back_smoke=='yessmpoke'){
                                    back_smoke = 'Yes';
                                } else if(back_smoke == 'nosmpoke'){
                                    back_smoke = 'No';
                                } else {
                                     back_smoke = '';
                                }if(back_petbother=='yespetbother'){
                                    back_petbother = 'Yes';
                                } else if(back_smoke == 'nopetbother'){
                                    back_petbother = 'No';
                                } else {
                                     back_petbother = '';
                                }
                                var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                                var back_flightname = jQuery( "#flightname" ).val();
                                var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                                var back_departuredate = jQuery( "#departuredate" ).val();                                
                                var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
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
ex:is_set_charge,
                                                under_18: is_acc_supplement,
                                                'back_accomdation' : back_accomdation,
                                                'back_meal_plan' : back_meal_plan,
                                                'back_product_acc_zone' : back_product_acc_zone,
                                                'back_accomodation_week' : back_accomodation_week,
                                                'back_acc_startdate' : back_acc_startdate,
                                                'back_acc_enddate' : back_acc_enddate,
                                                'back_productid': back_product_id,
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
                                            var i =0;
                                            if(result == '<table>'){
                                                changeWeek();
                                            } else {
                                                jQuery("#accomodation_cart").html(result);  
                                            }	
                                            jQuery('.sk-fading-circle').hide();

                                            <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_acc_supplement']) && $_SESSION['accomodation']['back_acc_supplement'] != ''){ ?>
                                                jQuery("#acc_supplement option[value=<?php echo $_SESSION['accomodation']['back_acc_supplement']; ?>]").attr('selected','selected').change();                                                
                                            <?php } } ?>
                                            <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_smoke']) && $_SESSION['accomodation']['back_smoke'] != ''){ ?>
                                                jQuery("#smoke option[value=<?php echo $_SESSION['accomodation']['back_smoke']; ?>]").attr('selected','selected');                                                
                                            <?php } } ?>
                                            <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_petbother']) && $_SESSION['accomodation']['back_petbother'] != ''){ ?>
                                                jQuery("#petbother option[value=<?php echo $_SESSION['accomodation']['back_petbother']; ?>]").attr('selected','selected');                                                
                                            <?php } } ?>
                                            <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_allergies']) && $_SESSION['accomodation']['back_allergies'] != ''){ ?>
                                                jQuery("#allergies").attr('checked', true);                                          
                                            <?php } } ?>
                                            <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_allergiestype']) && $_SESSION['accomodation']['back_allergiestype'] != ''){ ?>
                                                jQuery("#allergiestype").val("<?php echo $_SESSION['accomodation']['back_allergiestype']; ?>");                                                
                                            <?php } } ?> 
                                             <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){

                                            if(!empty($_SESSION['accomodation']['back_bathroom']) && $_SESSION['accomodation']['back_bathroom'] != ''){ ?>
                                                jQuery("#bathroom").val("<?php echo $_SESSION['accomodation']['back_bathroom']; ?>");
                                                //alert("<?php echo $_SESSION['accomodation']['back_bathroom']; ?>");
                                               // alert(i);
                                                if(i==0){
                                                jQuery("#bathroom").change();
                                                }
                                                i++;
                                            <?php } } ?>

                                            <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_transport_type']) && $_SESSION['accomodation']['back_transport_type'] != ''){ ?>
                                                jQuery("#transport_type option[value=<?php echo $_SESSION['accomodation']['back_transport_type']; ?>]").attr('selected','selected');
                                                setTimeout(function(){
                                                jQuery("#transport_type").trigger('change');
                                                                                                           
                                                },800);
                                            <?php } else if(!empty($_SESSION['accomodation']['back_visa_require']) && $_SESSION['accomodation']['back_visa_require'] != ''){ ?>
                                                jQuery("#visa_require option[value=<?php echo $_SESSION['accomodation']['back_visa_require']; ?>]").attr('selected','selected');
                                                setTimeout(function(){
                                                    jQuery("#visa_require").trigger('change');
                                                },1000);
                                            <?php } } ?>
                                            //alert(123465);
                                            var yes = $('#acc_supplement').val();
                                            //alert(yes);
                                            if(yes=='yes'){
                                                $('.one20').hide();
                                                $('.oned').show();
                                                }else if(yes=='no'){
                                                $('.one20').show();
                                                $('.oned').hide();
                                                }else {
                                                $('.oned').hide();
                                                $('.one20').hide();
                                            }
                                            jQuery("#you-ex-student").val('no').trigger('change');
                                                    $('.accu_r').hide();
                                                    $('.accu_r2').hide();
                                                    $('.accu_m').hide();
                                                    $('.accu_m2').hide();
                                                if($('#allow_hide').is(":visible")==false){
                                                           $('.one1').hide();
                                                           $('.one2').hide();
                                                           $('.accu_r').show();
                                                           $('.accu_r2').show();
                                                           $('.accu_m').show();
                                                           $('.accu_m2').show();
                                                          
                                                        }  else{
                                                           // alert('sdf');
                                                        setTimeout(function(){
                                                           $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                                            jQuery("#petbother").change();
                                                jQuery("#smoke").change();
                                               
                                               jQuery("#allergiestype").keyup();
                                                },400);
                                                        }
                                             /*if($('#allow_hide').is(":visible")==false){
                                               $('.one1') .hide();
                                               $('.one2') .hide();
                                            }  else{
                                                jQuery("#petbother").change();
                                                jQuery("#smoke").change();
                                               
                                               jQuery("#allergiestype").keyup();
                                            }*/

                                           	var selected_week = parseFloat($("#courseweek").val());
											if(selected_week!=undefined) {
					                            setTimeout(function(){
					                            	//alert(selected_week+"jii");
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
												},300);	
												setTimeout(function(){
					                            	//alert(selected_week+"jii");
					                            	//console.log('hihiih'+selected_week);
												 	$('#accomodation_week').val(selected_week);  
												},500);

											}
                                            $('body').removeClass('show_loader');
                                        }
                                });
                        }, 4000);
                        }});
//                    }});
                   
                 }
                });
                }});
    }
    
    function getWeekData(){
        $('body').addClass('show_loader');
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
            $('body').removeClass('show_loader');  
             var newval ='';
                     valuenew = $.trim($("input[name='productname']:checked").parent('span').text());
                     //console.log(valuenew);
                        if(valuenew=='5 lessons') {
                            newval =' 5 lessons (Callan light)';
                        } else if(valuenew=='10 lessons'){
                             newval =' 10 lessons (Callan essential)';
                        } else if(valuenew=='15 lessons'){
                             newval =' 15 lessons (Callan intensive)';
                        } else if(valuenew=='20 lessons'){
                             newval =' 20 lessons (Callan super intensive)';
                        } else{
                            newval = $("input[name='productname']:checked").parent('span').text() ;
                        }
            jQuery("#accomodation_cart").html('<div id="accomodation_cart"><table><tbody><tr><td colspan="2"><div class="maincart"><div class="proc_name marbottom20 mob-padtb20"><b style="color:#32a3aa;font-size:18px;font-weight:400;">Shopping cart</b></div></div></td></tr><tr><td colspan="2"><div class="maincart"><div class="proc_name"><b class="product-name">'+ $('#getProductOption option:selected').html() +' &ndash;'+ newval +'</b></div></div></td></tr><tr><td><ul class="check-list"><li><div class="acc-supply">Course length: '+  $('#courseweek option:selected').html() +'<br>Course start date: '+ $('#course_date').val() +'</div></li></ul></td></tr> <tr  class="accu_r"><td colspan="2"><div class="maincart"><div class="proc_name"><b>Accommodation</b></td></tr><tr class="accu_r2"><td><ul class="check-list"><li><div class="acc-supply">No accommodation required</div></li></ul></td></tr><tr  class="accu_m"><td colspan="2"><div class="maincart"><div class="proc_name"><b>Visa</b></td></tr><tr  class="accu_m2"><td><ul class="check-list"><li><div class="acc-supply">No visa required</div></li></ul></td></tr><tr><td><br></td></tr></tbody></table></div>');  
           
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
        startDate: new Date(),
        autoclose:true,
        daysOfWeekDisabled: [0,6]
    }).on('changeDate', setWeeks);
    
    function setWeeks(){
        $('#petbother').change();
        $('#smoke').change();
        $('#flightname').val('');
        $('#arrivaldate').val('');
        $('#departuredate').val(''); 
        $('body').addClass('show_loader');
        if($('#course_date').val()!=''){
        $('#course_date').removeClass('red');
        }
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
                var newval ='';
                     valuenew = $.trim($("input[name='productname']:checked").parent('span').text());
                     //console.log(valuenew);
                        if(valuenew=='5 lessons') {
                            newval =' 5 lessons (Callan light)';
                        } else if(valuenew=='10 lessons'){
                             newval =' 10 lessons (Callan essential)';
                        } else if(valuenew=='15 lessons'){
                             newval =' 15 lessons (Callan intensive)';
                        } else if(valuenew=='20 lessons'){
                             newval =' 20 lessons (Callan super intensive)';
                        } else{
                            newval = $("input[name='productname']:checked").parent('span').text() ;
                        }
                 jQuery("#accomodation_cart").html('<div id="accomodation_cart"><table><tbody><tr><td colspan="2"><div class="maincart"><div class="proc_name marbottom20 mob-padtb20"><b style="color:#32a3aa;font-size:18px;font-weight:400;">Shopping cart</b></div></div></td></tr><tr><td colspan="2"><div class="maincart"><div class="proc_name"><b class="product-name">'+ $('#getProductOption option:selected').html() +' &ndash;'+ newval +'</b></div></div></td></tr><tr><td><ul class="check-list"><li><div class="acc-supply">Course start date: '+ $('#course_date').val() +'</div></li></ul></td></tr> <tr  class="accu_r"><td colspan="2"><div class="maincart"><div class="proc_name"><b>Accommodation</b></td></tr><tr class="accu_r2"><td><ul class="check-list"><li><div class="acc-supply">No accommodation required</div></li></ul></td></tr><tr  class="accu_m"><td colspan="2"><div class="maincart"><div class="proc_name"><b>Visa</b></td></tr><tr  class="accu_m2"><td><ul class="check-list"><li><div class="acc-supply">No visa required</div></li></ul></td></tr><tr><td><br></td></tr></tbody></table></div>');  
               
                <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                if(!empty($_SESSION['course']['back_courseweek']) && $_SESSION['course']['back_courseweek'] != ''){ ?>
                    jQuery("#courseweek option[value=<?php echo $_SESSION['course']['back_courseweek']; ?>]").attr('selected','selected');
                    jQuery("#courseweek").trigger('change');
                <?php } } ?>	
                $('body').removeClass('show_loader');	
            }
        });
    }
             
//    jQuery('#arrivaldate').datetimepicker({}).change();
    
    $('#arrivaldate').datepicker({
//        autoclose:true
        //format: "dd/mm/yyyy",
        startDate: new Date(),
        autoclose:true,
        daysOfWeekDisabled: [0,6]
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
          $('.oned').hide();
          $('.one20').hide();
            $('.one1').hide();
            $('.one2').hide();
            $('.sm_yes').hide();
            $('.sm_no').hide();
            $('.pet_yes').hide();
            $('.pet_no').hide();
            $('.aller').hide();
            $('.aller1').hide();
            $('.aller2').hide();
            $('.aller3').hide();
            $('#petbother').change();
            $('#smoke').change();
            $('#flightname').val('');
            $('#arrivaldate').val('');
            $('#departuredate').val(''); 
            $('body').addClass('show_loader');
            if($('#courseweek').val()!='empty'){
                $('#courseweek').removeClass('red');
            }
            if($('#course_level').val()!='I think my level is'){
                $('#course_level').removeClass('red');
            } 


            var course_level = jQuery( "#course_level :selected" ).val();
            if(course_level){
            var p_id = jQuery( ".prod-radio input[name=productname]:checked" ).val();
            var courseweek = jQuery( "#courseweek option:selected" ).val();
//            var coursestartdate = jQuery( "#coursestartdate option:selected" ).text();
            var coursestartdate = jQuery( "#course_date").val();
            var extracharges = jQuery( "#extrafees" ).val();

            var is_set_charge = '';
           // var is_set_charge = 'yes';
            if(jQuery('#you-ex-student').val() == 'yes'){
                is_set_charge = 'yes';
            } else {
                is_set_charge = 'no';
            }

            var is_acc_supplement = '';
            if(jQuery('#acc_supplement').val() == 'yes'){
                is_acc_supplement = 'yes';
            } else {
                is_acc_supplement = 'no';
            }
            
            //jQuery('.sk-fading-circle').show();
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
                 $('body').addClass('show_loader');
                jQuery.ajax({
                        type: 'post',
                        url: site_url+'/wp-admin/admin-ajax.php?action=remove_cart_data',
                        data: {
                                action: 'remove_cart_data'
                        },
                        success: function( result1 ) {
                            //add course product to cart
                               $('body').addClass('show_loader');
                            jQuery("#you-ex-student").val("");
                            jQuery("#you-ex-student").prop('disabled', false);

                            <?php if(!empty($_SESSION['fee_charge']) && $_SESSION['fee_charge'] != ''){ ?>
                                jQuery("#ex-student option[value=<?php echo $_SESSION['fee_charge']; ?>]").attr('selected','selected');                    
                            <?php } ?>

                            //jQuery('.sk-fading-circle').show();
                        
                            setTimeout(function(){
                                $('body').addClass('show_loader'); 
                                jQuery.get(site_url+'/cart?post_type=product&add-to-cart=' + p_id +'&variation_id='+result +'&attribute_pa_course_level='+course_level+'&attribute_pa_week='+courseweek+'&attribute_pa_course_startdate='+coursestartdate,
                                /*jQuery.get(site_url+'/?add-to-cart=' + p_id +'&variation_id='+result +'&attribute_pa_course_level='+course_level+'&attribute_pa_week='+courseweek+'&attribute_pa_course_startdate='+coursestartdate,*/
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
                                            //$('body').removeClass('show_loader');
                //                        alert(data);
                                        }
                                    });
                                });
                            },200);

                            setTimeout(function(){

                                var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
                                var back_prod_selected_id = jQuery( "#getProductOption option:selected" ).val();
                                var back_coursestartdate = jQuery( "#course_date").val();
                                var back_courseweek = jQuery( "#courseweek option:selected" ).val();
                                var back_course_level = jQuery( "#course_level option:selected" ).val(); 

                                var back_you_student = jQuery( "#you-ex-student option:selected" ).val(); 
                                 $('body').addClass('show_loader');
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
ex:is_set_charge,
                                                under_18: is_acc_supplement,
                                                'back_getProductOption' : back_prod_selected_id,
                                                'back_productid': back_product_id, 
                                                'back_coursestartdate' : back_coursestartdate,                                               
                                                'back_courseweek' : back_courseweek, 
                                                'back_course_level' : back_course_level,
                                                'back_you_student' : back_you_student,
                                        },
                                        success: function( result ) { console.log(result);
                                            jQuery('.sk-fading-circle').hide();
                                            var valuenew='';
                                             if($('#course_level').val()=='I think my level is'){
                                                var newval ='';
                                                 valuenew = $.trim($("input[name='productname']:checked").parent('span').text());
                                                 //console.log(valuenew);
                                                    if(valuenew=='5 lessons') {
                                                        newval =' 5 lessons (Callan light)';
                                                    } else if(valuenew=='10 lessons'){
                                                         newval =' 10 lessons (Callan essential)';
                                                    } else if(valuenew=='15 lessons'){
                                                         newval =' 15 lessons (Callan intensive)';
                                                    } else if(valuenew=='20 lessons'){
                                                         newval =' 20 lessons (Callan super intensive)';
                                                    } else{
                                                        newval = $("input[name='productname']:checked").parent('span').text() ;
                                                    }
                                              jQuery("#accomodation_cart").html('<div id="accomodation_cart"><table><tbody><tr><td colspan="2"><div class="maincart"><div class="proc_name marbottom20 mob-padtb20"><b style="color:#32a3aa;font-size:18px;font-weight:400;">Shopping cart</b></div></div></td></tr><tr><td colspan="2"><div class="maincart"><div class="proc_name"><b class="product-name">'+ $('#getProductOption option:selected').html() +' &ndash;'+ newval +'</b></div></div></td></tr><tr><td><ul class="check-list"><li><div class="acc-supply">Course length: '+  $('#courseweek option:selected').html() +'<br>Course start date: '+ $('#course_date').val() +'</div></li></ul></td></tr> <tr  class="accu_r"><td colspan="2"><div class="maincart"><div class="proc_name"><b>Accommodation</b></td></tr><tr class="accu_r2"><td><ul class="check-list"><li><div class="acc-supply">No accommodation required</div></li></ul></td></tr><tr  class="accu_m"><td colspan="2"><div class="maincart"><div class="proc_name"><b>Visa</b></td></tr><tr  class="accu_m2"><td><ul class="check-list"><li><div class="acc-supply">No visa required</div></li></ul></td></tr><tr><td><br></td></tr></tbody></table></div>');   
                                              
                                            }  else {
                                                 if(result == '<table>'){
                                                changeWeek();
                                            } else {
                                                jQuery("#accomodation_cart").html(result);  
                                            }    
                                            }                                     
                                            extrasfieldset(0);
                                            jQuery(".checkout-button").attr("href",site_url+"/checkout");
                                            jQuery('.prod-radio-acco').hide();    

                                            <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){ 
                                            if(!empty($_SESSION['accomodation']['back_accomdation']) && $_SESSION['accomodation']['back_accomdation'] != ''){ ?>
                                                jQuery("#accomdation option[value=<?php echo $_SESSION['accomodation']['back_accomdation']; ?>]").attr('selected','selected'); 
                                                jQuery("#accomdation").val("<?php echo $_SESSION['accomodation']['back_accomdation']; ?>").trigger('change');                   
                                                allowShowAccOption();                                                
                                            <?php } }else { ?>// jQuery("#accomdation").val(1).trigger('change'); 
                                                <?php } ?>

                                            <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_meal_plan']) && $_SESSION['accomodation']['back_meal_plan'] != ''){ ?>
                                               // alert('sdf');
                                                jQuery("#prod-acc-meal-plan option[value=<?php echo $_SESSION['accomodation']['back_meal_plan']; ?>]").attr('selected','selected');

                                                //jQuery("#accomdation").val(1).trigger('change');
                                                jQuery("#prod-acc-meal-plan").trigger('change');
                                            <?php } }else { ?>
                                               // jQuery("#accomdation").val(1).trigger('change');
                                            <?php } ?>

                                             $('body').removeClass('show_loader');
                                              $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                             if($('#allow_hide').is(":visible")==false){
                                               $('.one1').hide();
                                               $('.one2').hide();
                                               $('.accu_r') .show();
                                               $('.accu_r2') .show();
                                               $('.accu_m') .show();
                                               $('.accu_m2') .show();
                                            } else {
                                            setTimeout(function(){
                                                 $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                               $('.one1').show();
                                               $('.one2').show();
                                        <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_smoke']) && $_SESSION['accomodation']['back_smoke'] != ''){ ?>
                                               
                                               $('#smoke').val('<?php echo $_SESSION['accomodation']['back_smoke'];?>').change();
                                               
                                            <?php } }else { ?>
                                               // jQuery("#accomdation").val(1).trigger('change');
                                        <?php } ?>
                                          <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                            if(!empty($_SESSION['accomodation']['back_petbother']) && $_SESSION['accomodation']['back_petbother'] != ''){ ?>
                                               
                                               $('#petbother').val('<?php echo $_SESSION['accomodation']['back_petbother'];?>').change();
                                               
                                            <?php } }else { ?>
                                               // jQuery("#accomdation").val(1).trigger('change');
                                        <?php } ?>

                                                },250);
                                            }
                                        }
                                });
                            }, 1800);	
							var selected_week = parseFloat($("#courseweek").val());
							if(selected_week!=undefined) {
	                            setTimeout(function(){
	                            	//alert(selected_week+"jii");
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
								},300);	
								setTimeout(function(){
	                            	//alert(selected_week+"jii");
	                            	//console.log('hihiih'+selected_week);
								 	$('#accomodation_week').val(selected_week);  
								},500);

							}
                            
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
              //  getWeekData();
              $('body').addClass('show_loader');
                //jQuery('.sk-fading-circle').show();
                
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
              //  var is_set_charge = 'yes';
                if(jQuery('#you-ex-student').val() == 'yes'){
                    is_set_charge = 'yes';
                } else {
                    is_set_charge = 'no';
                } 

                var is_acc_supplement = '';
                if(jQuery('#acc_supplement').val() == 'yes'){
                    is_acc_supplement = 'yes';
                } else {
                    is_acc_supplement = 'no';
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
                             var acczone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val();
                                jQuery.get(site_url+'/cart/?post_type=product&add-to-cart=' + cat_id +'&variation_id='+result +'&quantity='+coursesweek_number+'&attribute_pa_zone='+acczone,
                                function() {});
                                },500);
								
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
                                            if(back_smoke=='yessmpoke'){
                                                back_smoke = 'Yes';
                                            } else if(back_smoke == 'nosmpoke'){
                                                back_smoke = 'No';
                                            } else {
                                                 back_smoke = '';
                                            }if(back_petbother=='yespetbother'){
                                                back_petbother = 'Yes';
                                            } else if(back_smoke == 'nopetbother'){
                                                back_petbother = 'No';
                                            } else {
                                                 back_petbother = '';
                                            }
                                        var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                                        var back_flightname = jQuery( "#flightname" ).val();
                                        var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                                        var back_departuredate = jQuery( "#departuredate" ).val();                                
                                         var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
                                        var back_visa_require = jQuery( "#visa_require" ).val(); 
                                         //var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
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
                                                        ex:is_set_charge,
                                                        under_18: is_acc_supplement,
                                                        'back_productid': back_product_id, 
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
                                                        //changeWeek();
                                                    } else {
                                                        jQuery("#accomodation_cart").html(result);  
                                                    }   
                                                     /*if($('#allow_hide').is(":visible")==false){
                                                       $('.one1') .hide();
                                                       $('.one2') .hide();
                                                    }  */
                                                     $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                                     if($('#allow_hide').is(":visible")==false){
                                                           $('.one1') .hide();
                                                           $('.one2') .hide();
                                                           $('.accu_r') .show();
                                                           $('.accu_r2') .show();
                                                           $('.accu_m') .show();
                                                           $('.accu_m2') .show();
                                                        }  else{
                                                            $('.accu_r') .hide();
                                                           $('.accu_r2') .hide();
                                                           $('.accu_m') .hide();
                                                           $('.accu_m2') .hide();
                                                         
                                                        }                                                 	
                                                    jQuery('.sk-fading-circle').hide();
                                                     var yes = $('#acc_supplement').val();
                                            //alert(yes);
                                            if(yes=='yes'){
                                                $('.one20').hide();
                                                $('.oned').show();
                                                }else if(yes=='no'){
                                                $('.one20').show();
                                                $('.oned').hide();
                                                }else {
                                                $('.oned').hide();
                                                $('.one20').hide();
                                            }
                                             setTimeout(function(){
                                             /*if($('#allow_hide').is(":visible")==false){
                                               $('.one1') .hide();
                                               $('.one2') .hide();
                                            }  else{*/
                                                jQuery("#petbother").change();
                                                jQuery("#smoke").change();
                                                jQuery("#allergiestype").keyup();
                                           // }

                                            },200);
                                                    $('body').removeClass('show_loader');
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
		$('.oned').hide();
		$('.one1').hide();
		$('.one2').hide();
		$('.sm_yes').hide();
		$('.sm_no').hide();
		$('.pet_yes').hide();
		$('.pet_no').hide();
		$('.aller').hide();
		$('.aller1').hide();
		$('.aller2').hide();
		$('.aller3').hide();
		$('#petbother').change();
		$('#smoke').change();
		$('#flightname').val('');
		$('#arrivaldate').val('');
		$('#departuredate').val(''); 
		var product_id = jQuery("#prod-acc-meal-plan option:selected").val(); 
		$('body').addClass('show_loader');
		hideOthers();
		if(product_id!='') {
			// $('.oned').show();
			$('.one1').show();
			$('.one2').show();
		}
            
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
					if(product_id!=''){
					 showOthers(); 
					} else {
						hideOthers();
					}
							
				}
				  
			},
			complete:  function(){
				setTimeout(function(){
					changeWeek();
				},200);
				setTimeout(function(){
				//accomChange();
			   
				 },400);
			},
		});
		$('#allergies').attr('checked', false);
		$('#allergiestype').val('');
		
	}
        
		//jQuery(document).on( 'change', '#prod-acc-meal-plan', accomChange);
		jQuery(document).on( 'change', '#acc_zone input:radio', accomChange);
        jQuery(document).on( 'change', '#accomodation_week', accomChange);
        
//	jQuery(document).on( 'change', '#acc_zone', function() {
//                var product_id = jQuery( "#accomdation option:selected" ).val();
//                var zone_slug = jQuery("#acc_zone").val();               
//                var extracharges = jQuery( "#extrafees" ).val();
//                var coursestartdate = jQuery( "#course_date").val();
//                var course_level = jQuery( "#course_level :selected" ).text();
//                //jQuery('.sk-fading-circle').show();
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
             $('body').addClass('show_loader');

            $('#flightname').val('');
            $('#arrivaldate').val('');
            $('#departuredate').val(''); 
                 setTimeout(function(){
                $('#petbother').change();
                $('#smoke').change();
                },200);
                var product_id = jQuery( "#transport_type option:selected" ).val();
                var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());  
                var extracharges = jQuery( "#extrafees" ).val();
                var coursestartdate = jQuery( "#course_date").val();
                var course_level = jQuery( "#course_level :selected" ).text();

              //  var is_set_charge = 'yes'; 
                var is_set_charge = '';
                if(jQuery('#you-ex-student').val() == 'yes'){
                    is_set_charge = 'yes';
                } else {
                    is_set_charge = 'no';
                }

                var is_acc_supplement = '';
                if(jQuery('#acc_supplement').val() == 'yes'){
                    is_acc_supplement = 'yes';
                } else {
                    is_acc_supplement = 'no';
                }
                if(jQuery('#bathroom').val() == 'yes'){
                bath = 'yes';
                } else {
                bath = 'no';            
                }

                //jQuery('.sk-fading-circle').show();
                    jQuery.ajax({
                            url: site_url+"/wp-admin/admin-ajax.php?action=add_transportdata",
                            type: "POST",
                            data: {
                                 action : 'add_transportdata',
                                'acctransportproc_id' : product_id,
                            },
                            success:function(result){
                                setTimeout(function(){
                                        //alert(is_acc_supplement);
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
                                            if(back_smoke=='yessmpoke'){
                                                back_smoke = 'Yes';
                                            } else if(back_smoke == 'nosmpoke'){
                                                back_smoke = 'No';
                                            } else {
                                                 back_smoke = '';
                                            }if(back_petbother=='yespetbother'){
                                                back_petbother = 'Yes';
                                            } else if(back_smoke == 'nopetbother'){
                                                back_petbother = 'No';
                                            } else {
                                                 back_petbother = '';
                                            }
                                            if(jQuery('#bathroom').val() == 'yes'){
                                                bath = 'yes';
                                            } else {
                                                bath = 'no';            
                                            }
                                        var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                                        var back_flightname = jQuery( "#flightname" ).val();
                                        var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                                        var back_departuredate = jQuery( "#departuredate" ).val();                                
                                         var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
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
                                                        ex:is_set_charge,
                                                        under_18: is_acc_supplement,
                                                        'back_productid': back_product_id, 
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
                                                         'back_bathroom' : bath,
                                                        'back_visa_require' : back_visa_require,
                                                },
                                                success: function( result ) {
                                                    if(result == '<table>'){
                                                        changeWeek();
                                                    } else {
                                                        jQuery("#accomodation_cart").html(result);  
                                                    }
                                                    jQuery('.sk-fading-circle').hide();

                                                    <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){ 
                                                    if(!empty($_SESSION['accomodation']['back_flightname']) && $_SESSION['accomodation']['back_flightname'] != ''){ ?>
                                                        jQuery("#flightname").val("<?php echo $_SESSION['accomodation']['back_flightname']; ?>");                                                        
                                                    <?php } } ?>
                                                    <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                                    if(!empty($_SESSION['accomodation']['back_arrivaldate']) && $_SESSION['accomodation']['back_arrivaldate'] != ''){ ?>
                                                        jQuery("#arrivaldate").val("<?php echo $_SESSION['accomodation']['back_arrivaldate']; ?>");                                                        
                                                    <?php } } ?>
                                                    <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                                    if(!empty($_SESSION['accomodation']['back_departuredate']) && $_SESSION['accomodation']['back_departuredate'] != ''){ ?>
                                                        jQuery("#departuredate").val("<?php echo $_SESSION['accomodation']['back_departuredate']; ?>");                                                        
                                                    <?php } } ?>

                                                    <?php if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){
                                                    if(!empty($_SESSION['accomodation']['back_visa_require']) && $_SESSION['accomodation']['back_visa_require'] != ''){ ?>
                                                        jQuery("#visa_require option[value=<?php echo $_SESSION['accomodation']['back_visa_require']; ?>]").attr('selected','selected');
                                                        jQuery("#visa_require").trigger('change');
                                                    <?php } } ?>
                                                        /*if($('#allow_hide').is(":visible")==false){
                                                           $('.one1') .hide();
                                                           $('.one2') .hide();
                                                        }  */
                                                         $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                                         if($('#allow_hide').is(":visible")==false){
                                                           $('.one1') .hide();
                                                           $('.one2') .hide();
                                                           $('.accu_r').show();
                                                           $('.accu_r2').show();
                                                           $('.accu_m').show();
                                                           $('.accu_m2').show();
                                                          
                                                        }  else{
                                                           $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                                            jQuery("#petbother").change();
                                            
                                                        }
                                                         var yes = $('#acc_supplement').val();
                                            //alert(yes);
                                                        if(yes=='yes'){
                                                            $('.one20').hide();
                                                            $('.oned').show();
                                                            }else if(yes=='no'){
                                                            $('.one20').show();
                                                            $('.oned').hide();
                                                            }else {
                                                            $('.oned').hide();
                                                            $('.one20').hide();
                                                        }
                                                         jQuery("#petbother").change();
                                                         jQuery("#smoke").change();

                                                        jQuery("#allergiestype").keyup();
                                                         //jQuery("#allergies").click();
                                                         $('body').removeClass('show_loader');
                                                }
                                        });
                                }, 1000);
                            }   
                        });
	});
	jQuery(document).on( 'change', '#visa_require', function() {
                $('body').addClass('show_loader');
                var product_id = jQuery( "#visa_require option:selected" ).val();
                var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());  
                var extracharges = jQuery( "#extrafees" ).val();
                var coursestartdate = jQuery( "#course_date").val();
                var course_level = jQuery( "#course_level :selected" ).text();

                var is_set_charge = '';
                 //var is_set_charge = 'yes'; 
                if(jQuery('#you-ex-student').val() == 'yes'){
                    is_set_charge = 'yes';
                } else {
                    is_set_charge = 'no';
                }
                  var bath = '';
                if(jQuery('#bathroom').val() == 'yes'){
                    bath = 'yes';
                     product_id_bath = 21133;
                } else {
                     product_id_bath = '';
                    bath = 'no';
                }
                var is_acc_supplement = '';
                if(jQuery('#acc_supplement').val() == 'yes'){
                    is_acc_supplement = 'yes';
                } else {
                    is_acc_supplement = 'no';
                }

                var isvisafee = '';
                if(product_id != ''){
                    isvisafee = 'yes';
                } else {
                    isvisafee = 'no';
                }
        
                //jQuery('.sk-fading-circle').show();
              //  bath();
              // setTimeout(function(){
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
                                            if(back_smoke=='yessmpoke'){
                                                back_smoke = 'Yes';
                                            } else if(back_smoke == 'nosmpoke'){
                                                back_smoke = 'No';
                                            } else {
                                                 back_smoke = '';
                                            }if(back_petbother=='yespetbother'){
                                                back_petbother = 'Yes';
                                            } else if(back_smoke == 'nopetbother'){
                                                back_petbother = 'No';
                                            } else {
                                                 back_petbother = '';
                                            }
                                             if(jQuery('#bathroom').val() == 'yes'){
                                                bath = 'yes';
                                            } else {
                                                bath = 'no';            
                                            }
                                        var back_transport_type = jQuery( "#transport_type option:selected" ).val();
                                        var back_flightname = jQuery( "#flightname" ).val();
                                        var back_arrivaldate = jQuery( "#arrivaldate" ).val();
                                        var back_departuredate = jQuery( "#departuredate" ).val();                                
                                        var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
                                        var back_visa_require = jQuery( "#visa_require" ).val(); 

                                        jQuery.ajax({
                                                type: 'post',
                                                url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
                                                data: {
                                                        action: 'show_acc_cart_data',
                                                        'extracharges' : extracharges,
                                                        'back_productid': back_product_id, 
                                                        acc_week : acc_week,
                                                        coursestartdate :coursestartdate,
                                                        course_level : course_level,
                                                        fee_charge : is_set_charge,
ex:is_set_charge,
                                                        under_18: is_acc_supplement,
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
                                                         'back_bathroom' : bath,
                                                        'back_visa_require' : back_visa_require,
                                                },
                                                success: function( result ) {
                                                    if(result == '<table>'){
                                                        changeWeek();

                                                    } else {
                                                        jQuery("#accomodation_cart").html(result);  
                                                        if(jQuery('#bathroom').val() == 'yes'){
                                                        //bath();
                                                        } 
                                                       
                                                    }
                                                    jQuery('.sk-fading-circle').hide();
                                                     $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                                     if($('#allow_hide').is(":visible")==false){
                                                           $('.one1').hide();
                                                           $('.one2').hide();
                                                           $('.accu_r').show();
                                                           $('.accu_r2').show();
                                                           $('.accu_m').show();
                                                           $('.accu_m2').show();
                                                          
                                                        }  else{
                                                           $('.accu_r').hide();
                                                           $('.accu_r2').hide();
                                                           $('.accu_m').hide();
                                                           $('.accu_m2').hide();
                                                        }
                                                         var yes = $('#acc_supplement').val();
                                                        
                                            //alert(yes);
                                            if(yes=='yes'){
                                                $('.one20').hide();
                                                $('.oned').show();
                                                }else if(yes=='no'){
                                                $('.one20').show();
                                                $('.oned').hide();
                                                }else {
                                                $('.oned').hide();
                                                $('.one20').hide();
                                            }
                                            jQuery("#petbother").change();
                                            jQuery("#smoke").change();

                                            jQuery("#allergiestype").keyup();
                                            jQuery("#flightname").keyup();
                                            jQuery("#arrivaldate").change();
                                            jQuery("#departuredate").click();

                                        $('body').removeClass('show_loader');
                                                }
                                        });
                                }, 1000);
                            }   
                        });

	});

//          //code to add validation on "Add to Cart" button
//         jQuery('#btn_cart_proceed').click(function(){
//             <?php session_start();
//             $_SESSION['is_back'] = ''; ?>
//             //code to add validation, if any
//             //If all values are proper, then send AJAX request
// //            alert('sending ajax request');
//             var product_id = jQuery( "#prod-acc-meal-plan option:selected" ).val();     
//         })
    });
	jQuery(document).on( 'change', '#bathroom', bath);
	function bath(){
    var bath ='';
        $('body').addClass('show_loader');
		var bac_product_id = jQuery( "#visa_require option:selected" ).val();
		var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());  
		var extracharges = jQuery( "#extrafees" ).val();
		var coursestartdate = jQuery( "#course_date").val();
		var course_level = jQuery( "#course_level :selected" ).text();

		var is_set_charge = '';
		
        var startdate= $("#acc_startdate").val().split("/");
        var first= new Date(startdate[2]+"-"+startdate[1]+"-"+startdate[0]);
        var enddate= $("#acc_enddate").val().split("/");
        var second = new Date(enddate[2]+"-"+enddate[1]+"-"+enddate[0]);
        var days = Math.round((second-first)/(1000*60*60*24));
        var week_nos= Math.round(days/7);
        var coursestartdate = jQuery( "#course_date").val();
        var course_level = jQuery( "#course_level :selected" ).text();
        var product_id = '';
        var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());
        var acczone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
        
        if(week_nos >= 2){
			$('#accomodation_week').val(week_nos-1);
        }else{
            $('#accomodation_week').val("1");
			getWeekData();
        }

		var cat_id = '21133'; 
		var extracharges = jQuery( "#extrafees" ).val();

        var is_set_charge = '';
      
        if(jQuery('#you-ex-student').val() == 'yes'){
            is_set_charge = 'yes';
        } else {
            is_set_charge = 'no';
        }

        var is_acc_supplement = '';
        if(jQuery('#acc_supplement').val() == 'yes'){
            is_acc_supplement = 'yes';
        } else {
            is_acc_supplement = 'no';
        }
        var bath = '';
        var product_id = 21133;
        if(jQuery('#bathroom').val() == 'yes'){
            bath = 'yes';
        } else {
            bath = 'no';            
        }
		if(jQuery('#bathroom').val() == 'no'){
			 jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					 action : 'remove_bath',
				},
				success:function(){
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
						if(back_smoke=='yessmpoke'){
							back_smoke = 'Yes';
						} else if(back_smoke == 'nosmpoke'){
							back_smoke = 'No';
						} else {
							 back_smoke = '';
						}if(back_petbother=='yespetbother'){
							back_petbother = 'Yes';
						} else if(back_smoke == 'nopetbother'){
							back_petbother = 'No';
						} else {
							 back_petbother = '';
						}
                        var bath='';
                        if(jQuery('#bathroom').val() == 'yes'){
                        bath = 'yes';
                        } else {
                        bath = 'no';            
                        }
                       // alert(bath);
                       var bac_product_id = jQuery( "#visa_require option:selected" ).val();
					var back_transport_type = jQuery( "#transport_type option:selected" ).val();
					var back_flightname = jQuery( "#flightname" ).val();
					var back_arrivaldate = jQuery( "#arrivaldate" ).val();
					var back_departuredate = jQuery( "#departuredate" ).val();                                
					var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
					var back_visa_require = jQuery( "#visa_require" ).val(); 
                       var isvisafee = '';
                        if(product_id != ''){
                            isvisafee = 'yes';
                        } else {
                            isvisafee = 'no';
                        }
					jQuery.ajax({
						type: 'post',
						url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
						data: {
							action: 'show_acc_cart_data',
							'extracharges' : extracharges,
							'back_productid': back_product_id, 
							acc_week : acc_week,
							coursestartdate :coursestartdate,
							course_level : course_level,
							fee_charge : is_set_charge,
							ex:is_set_charge,
							under_18: is_acc_supplement,
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
                            'back_bathroom' : bath,
							'back_visa_require' : bac_product_id,
						},
						success: function( result ) {
							if(result == '<table>'){
								changeWeek();
							} else {
								jQuery("#accomodation_cart").html(result);  
							}
							jQuery('.sk-fading-circle').hide();
							$('.accu_r').hide();
							$('.accu_r2').hide();
							$('.accu_m').hide();
							$('.accu_m2').hide();
							if($('#allow_hide').is(":visible")==false){
							   $('.one1').hide();
							   $('.one2').hide();
							   $('.accu_r').show();
							   $('.accu_r2').show();
							   $('.accu_m').show();
							   $('.accu_m2').show();
							}else{
							   $('.accu_r').hide();
							   $('.accu_r2').hide();
							   $('.accu_m').hide();
							   $('.accu_m2').hide();
							}
							var yes = $('#acc_supplement').val();
					
							if(yes=='yes'){
								$('.one20').hide();
								$('.oned').show();
							}else if(yes=='no'){
								$('.one20').show();
								$('.oned').hide();
							}else {
								$('.oned').hide();
								$('.one20').hide();
							}
							jQuery("#petbother").change();
							jQuery("#smoke").change();

							jQuery("#allergiestype").keyup();
							jQuery("#flightname").keyup();
							jQuery("#arrivaldate").change();
							jQuery("#departuredate").click();
                            var product_idk = jQuery( "#visa_require option:selected" ).val();
                             if(product_idk!=''){
                                $('#visa_require').change();
                             }
                            $('body').removeClass('show_loader');
							$('body').removeClass('show_loader');
						}
					});
				}
			});
		}
                        
		if(jQuery('#bathroom').val() == 'yes'){
			jQuery.ajax({
				url: site_url+"/public_html/wp-content/themes/skilled-child/functions.php",
				type: "POST",
				data: {
					//'course_level': course_level,
					'acczone' : 'zone-2-3',
					'product_id' : product_id,
				},
				success:function(result){

					$('body').addClass('show_loader');
					setTimeout(function(){
						var acczone = 'zone-2-3'; 
					   //  alert(acczone);
						jQuery.get(site_url+'/?add-to-cart=' + product_id +'&variation_id='+result +'&quantity='+week_nos+'&attribute_pa_zone='+acczone,
						function(){
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
								if(back_smoke=='yessmpoke'){
									back_smoke = 'Yes';
								} else if(back_smoke == 'nosmpoke'){
									back_smoke = 'No';
								} else {
									 back_smoke = '';
								}if(back_petbother=='yespetbother'){
									back_petbother = 'Yes';
								} else if(back_smoke == 'nopetbother'){
									back_petbother = 'No';
								} else {
									 back_petbother = '';
								}
                                 var bath='';
                                if(jQuery('#bathroom').val() == 'yes'){
                                bath = 'yes';
                                } else {
                                bath = 'no';            
                                }
							var back_transport_type = jQuery( "#transport_type option:selected" ).val();
							var back_flightname = jQuery( "#flightname" ).val();
							var back_arrivaldate = jQuery( "#arrivaldate" ).val();
							var back_departuredate = jQuery( "#departuredate" ).val();                                
							var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
							var back_visa_require = jQuery( "#visa_require" ).val(); 
                            var bac_product_id = jQuery( "#visa_require option:selected" ).val();

							jQuery.ajax({
								type: 'post',
								url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
								data: {
									action: 'show_acc_cart_data',
									'extracharges' : extracharges,
									'back_productid': back_product_id, 
									acc_week : acc_week,
									coursestartdate :coursestartdate,
									course_level : course_level,
									fee_charge : is_set_charge,
									ex:is_set_charge,
									under_18: is_acc_supplement,
									// visaextrafee : isvisafee,
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
                                     'back_bathroom' : bath,
									'back_transport_type' : back_transport_type,
									'back_flightname' : back_flightname,
									'back_arrivaldate' : back_arrivaldate,
									'back_departuredate' : back_departuredate,

									'back_visa_require' : bac_product_id,
								},
								success: function( result ) {
									if(result == '<table>'){
										changeWeek();
									} else {
										jQuery("#accomodation_cart").html(result);  
									}
									jQuery('.sk-fading-circle').hide();
									$('.accu_r').hide();
									$('.accu_r2').hide();
									$('.accu_m').hide();
									$('.accu_m2').hide();
									if($('#allow_hide').is(":visible")==false){
									   $('.one1').hide();
									   $('.one2').hide();
									   $('.accu_r').show();
									   $('.accu_r2').show();
									   $('.accu_m').show();
									   $('.accu_m2').show();
									  
									}else{
									   $('.accu_r').hide();
									   $('.accu_r2').hide();
									   $('.accu_m').hide();
									   $('.accu_m2').hide();
									}
									var yes = $('#acc_supplement').val();
									if(yes=='yes'){
										$('.one20').hide();
										$('.oned').show();
										}else if(yes=='no'){
										$('.one20').show();
										$('.oned').hide();
										}else {
										$('.oned').hide();
										$('.one20').hide();
									}
									jQuery("#petbother").change();
									jQuery("#smoke").change();

									jQuery("#allergiestype").keyup();
									jQuery("#flightname").keyup();
									jQuery("#arrivaldate").change();
									jQuery("#departuredate").click();
                                     var product_idk = jQuery( "#visa_require option:selected" ).val();
                                     if(product_idk!=''){
                                        $('#visa_require').change();
                                     }
									$('body').removeClass('show_loader');
								}
							});
						});
					},500);
				}   
			});
		}
   
    }

</script>
        
    
<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<!-- <input type="text" name="cl" value="<?php echo $_SESSION['is_back']; ?>" /> -->
<script>
// Select courses



<?php 

if(!empty($_SESSION['is_back']) && $_SESSION['is_back'] == 'back_click'){  ?>
    //alert($_SESSION['course']['back_productid']);
<?php 
    if( $_SESSION['course']['back_productid']==''){
        $_SESSION['course']['back_productid'] =  $_SESSION['course']['back_productidpop'];
    }
if(!empty($_SESSION['course']['back_productid']) && $_SESSION['course']['back_productid'] != ''){ ?>
    jQuery("input:radio[value^=<?php echo $_SESSION['course']['back_productid'];?>]").prop("checked", true).trigger("click");
    getProductOption();

<?php } } else{ ?>
   //alert('no');
<?php }?>


    jQuery(document).ready(function(){
        //jQuery("#getProductOption").val(0).change();
    jQuery('#btn_cart_proceed').click(function(){
        <?php session_start();
        $_SESSION['is_back'] = ''; ?>
        //code to add validation, if any
        //If all values are proper, then send AJAX request
//            alert('sending ajax request');
        var product_id = jQuery( "#prod-acc-meal-plan option:selected" ).val();     
    });
       // $( "#visa_require" ).sortable();
         var options = $('#visa_require option');
        var arr = options.map(function(_, o) {
            return {
                t: $(o).text(),
                v: o.value
            };
        }).get();
        arr.sort(function(o1, o2) {
            return o1.t < o2.t ? 1 : o1.t > o2.t ? -1 : 0;
        });
        options.each(function(i, o) {
           // console.log(i);
            o.value = arr[i].v;
            $(o).text(arr[i].t);
        });
        $('#getProductOption').removeClass('red');
        $(document).on('click','.checkout-button',function(){
        if($('#getProductOption').val()==0) {
            $('#getProductOption').addClass('red');
            $("#getProductOption").focus();
            return false ;
        } else if($('.productname').is(':checked')==false ){
            //alert('sdf');
            $('.hide_show').show();
            return false ;
           // $(".hide_show").focus();
        }else if($('#course_date').val()==''){
            $('#course_date').addClass('red');
            $("#course_date").focus();
            return false ;
        } else if($('#courseweek').is(':enabled')==true && $('#courseweek').val()=='empty'){
           // if($('#courseweek').val()=='empty') {
            $('#courseweek').addClass('red');
            $("#courseweek").focus();
            return false ;
          //  }
        }else if($('#course_level').val()=='I think my Level is'){
            $('#course_level').addClass('red');
            $("#course_level").focus();
            //return false ;
         }

       
        });
        jQuery("#petbother").change(function(){
            var petval = jQuery(this).val();
            if(petval=='nopetbother'){
                $('.pet_yes').show();
                $('.pet_no').hide();
                localStorage.setItem("petbother", "No");
            }else if (petval=='yespetbother') {
                $('.pet_yes').hide();
                $('.pet_no').show();
                localStorage.setItem("petbother", "Yes");
            } else {
                $('.pet_yes').hide();
                $('.pet_no').hide();
                 localStorage.setItem("petbother", "");
            }
        });
        jQuery("#smoke").change(function(){
            var petval = jQuery(this).val();
            if(petval=='nosmpoke'){
                $('.sm_yes').hide();
                $('.sm_no').show();
                 localStorage.setItem("smoke", "No");
            }else if (petval=='yessmpoke') {
                $('.sm_yes').show();
                $('.sm_no').hide();
                 localStorage.setItem("smoke", "Yes");
            } else {
                $('.sm_yes').hide();
                $('.sm_no').hide();
                 localStorage.setItem("petbother", "");
            }
        });
      /*  jQuery("#acc_supplement").change(function(){
            var petval1 = jQuery(this).val();
            if(petval1==''){
                 $('.oned').hide();
            }else {
                 $('.oned').show();
            }
        });*/
       $('#allergiestype').keyup(function() {
            $('#target').html($(this).val());
            localStorage.setItem("allergiestype", $(this).val());
            if($(this).val()==''){
                  localStorage.setItem("allergiestype", '');
            }
        });
       $('#flightname').keyup(function() {
            $('#target1').html($(this).val());
             localStorage.setItem("flightname", $(this).val());
            if($(this).val()==''){
                  localStorage.setItem("flightname", '');
            }
        });
       $('#arrivaldate').change(function() {
            $('#target2').html($(this).val());

             localStorage.setItem("arrivaldate", $(this).val());
            if($(this).val()==''){
                  localStorage.setItem("arrivaldate", '');
            }
        }); 
      /* $('#acc_supplement').change(function() {
        var yes = jQuery(this).val();
            if(yes=='yes'){
                $('.one20').hide();
                $('.oned').show();
            }else if(yes=='no'){
                 $('.one20').show();
                  $('.oned').hide();
            }else {
                  $('.oned').hide();
                  $('.one20').hide();
            }
          
        });*/
       $('body').click(function(){
          $('#target3').html($('#departuredate').val());
             localStorage.setItem("departuredate", $(this).val());
            if($(this).val()==''){
                  localStorage.setItem("departuredate", '');
            }
       });
       $('#departuredate').click(function() {
            $('#target3').html($(this).val());
              localStorage.setItem("departuredate", $(this).val());
            if($(this).val()==''){
                  localStorage.setItem("departuredate", '');
            }
        }); 
       $('#allergies').click(function() {
            if($("#allergies").is(':checked')) {
                $('#allergiestype').show();    
                $('.aller').show();    
            } else {
                 $('#allergiestype').hide();    
                $('.aller').hide();    
                 localStorage.setItem("allergiestype", '');
            }
            
        });
       /*$('#tool').click(function() {
        jQuery.ajax({
                type: 'post',
                url: site_url+'/wp-admin/admin-ajax.php?action=add_toll',
                data: {
                    action: 'add_toll',
                 
                },
                success: function( result ){
                alert(result);
                }
            });
            
        });*/
        
    });


function show_acc_cart_data(){
	var is_acc_supplement = '';
	if(jQuery('#acc_supplement').val() == 'yes'){
		is_acc_supplement = 'yes';
	} else {
		is_acc_supplement = 'no';
	}
	var bac_product_id = jQuery( "#visa_require option:selected" ).val();
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
    if(jQuery('#bathroom').val() == 'yes'){
            bath = 'yes';
        } else {
            bath = 'no';            
        }
	
	var startdate= $("#acc_startdate").val().split("/");
	var first= new Date(startdate[2]+"-"+startdate[1]+"-"+startdate[0]);
	var enddate= $("#acc_enddate").val().split("/");
	var second = new Date(enddate[2]+"-"+enddate[1]+"-"+enddate[0]);
	var days = Math.round((second-first)/(1000*60*60*24));
	var week_nos= Math.round(days/7);
	var coursestartdate = jQuery( "#course_date").val();
	var course_level = jQuery( "#course_level :selected" ).text();
	var product_id = '';
	var acc_week = parseFloat(jQuery("#accomodation_week :selected").text());
	var acczone = jQuery( "#acc_zone input[name=productacczone]:checked" ).val(); 
	
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
		if(back_smoke=='yessmpoke'){
			back_smoke = 'Yes';
		} else if(back_smoke == 'nosmpoke'){
			back_smoke = 'No';
		} else {
			 back_smoke = '';
		}if(back_petbother=='yespetbother'){
			back_petbother = 'Yes';
		} else if(back_smoke == 'nopetbother'){
			back_petbother = 'No';
		} else {
			 back_petbother = '';
		}
	var back_transport_type = jQuery( "#transport_type option:selected" ).val();
	var back_flightname = jQuery( "#flightname" ).val();
	var back_arrivaldate = jQuery( "#arrivaldate" ).val();
	var back_departuredate = jQuery( "#departuredate" ).val();                                
	var back_product_id = jQuery( ".prod-radio input[name=productname]:checked" ).val(); 
	var back_visa_require = jQuery( "#visa_require" ).val(); 

	jQuery.ajax({
		type: 'post',
		url: site_url+'/wp-admin/admin-ajax.php?action=show_acc_cart_data',
		data: {
			action: 'show_acc_cart_data',
			'extracharges' : extracharges,
			'back_productid': back_product_id, 
			acc_week : acc_week,
			coursestartdate :coursestartdate,
			course_level : course_level,
			fee_charge : is_set_charge,
			ex:is_set_charge,
			under_18: is_acc_supplement,
			// visaextrafee : isvisafee,
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
             'back_bathroom' : bath,
			'back_visa_require' : bac_product_id,
		},
		success: function( result ){
			if(result == '<table>'){
				changeWeek();
			} else {
				jQuery("#accomodation_cart").html(result);  
			}
			jQuery('.sk-fading-circle').hide();
			jQuery('.accu_r').hide();
			jQuery('.accu_r2').hide();
			jQuery('.accu_m').hide();
			jQuery('.accu_m2').hide();
			if($('#allow_hide').is(":visible")==false){
			   jQuery('.one1').hide();
			   jQuery('.one2').hide();
			   jQuery('.accu_r').show();
			   jQuery('.accu_r2').show();
			   jQuery('.accu_m').show();
			   jQuery('.accu_m2').show();
			}else{
			   jQuery('.accu_r').hide();
			   jQuery('.accu_r2').hide();
			   jQuery('.accu_m').hide();
			   jQuery('.accu_m2').hide();
			}
			var yes = jQuery('#acc_supplement').val();
			if(yes=='yes'){
				jQuery('.one20').hide();
				jQuery('.oned').show();
			}else if(yes=='no'){
				jQuery('.one20').show();
				jQuery('.oned').hide();
			}else {
				jQuery('.oned').hide();
				jQuery('.one20').hide();
			}
			jQuery("#petbother").change();
			jQuery("#smoke").change();

			jQuery("#allergiestype").keyup();
			jQuery("#flightname").keyup();
			jQuery("#arrivaldate").change();
			jQuery("#departuredate").click();
            var product_idk = jQuery( "#visa_require option:selected" ).val();
             if(product_idk!=''){
                $('#visa_require').change();
             }
        
			jQuery('body').removeClass('show_loader');
		}
	});
}

</script>

<style type="text/css">
.sweet-alert
{
    left: 50% !important;
    width: 560px !important;
} 
.cart-step1 .red{
    border-color: red !important;
}
.cart-step1 select {
  padding-left: 4px !important;
   
}
</style>

<script>

/*jQuery('#btn_cart_proceed').on('click', function(e){
    e.preventDefault();

    jQuery.ajax({
        type: 'post',
        url: site_url+'/wp-admin/admin-ajax.php?action=wdm_add_user_custom_data_options_callback',
        data: {
            action: 'wdm_add_user_custom_data_options_callback',
            'productid': product_id
        },
        success: function( result ) {
            
        },
        complete:  function(){
            
        },
    });
 
});*/

</script>
<style>
    
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
div#acc_date, .accselovr {
    float: left;
    width: 100%;
}
div#acc_date label{
    width: 100% !important;
}
div#accstartdate, .accselct {
    width: 45%;
    float: left;
    margin-right: 4%;
}
div#accstartdate input, div#accenddate input {
    width: 100%;
}
div#accenddate, div#div_accsupplement {
    width: 50%;
    float: left;
}
#div_accsupplement > select {
    margin-right: 5px;
    width: 100%;
}
.extra-second-section {
    font-weight: bold;
}
div#accomodation_cart ul {
    padding: 0;
    list-style: none;
      margin: 10px;
}
.check-list li{
    line-height: 1.6;
}
.allergies-left .css-label {
    margin-bottom: 22px;
}
</style>
