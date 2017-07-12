<?php
    // Start the session loginf
    session_start(); // echo '<pre>'; print_r($_SESSION); echo '</pre>';
    $site_url= get_site_url();
    $data = json_encode(array(
        'course' => $_SESSION['course'], 
        'accommodation' => $_SESSION['accomodation'],
        'fee_charge' => $_SESSION['fee_charge'],
        'click_back' => $_SESSION['is_back'])
    );

?>

<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/bootstrap/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/css/bootstrap-select.css" />
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/css/sweetalert.css" />
<link rel="stylesheet" href="<?php echo $site_url;?>/wp-content/themes/skilled-child/css/custom-cart.css" />
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>

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
<script>var abc = abc || {}; abc.fees = <?php echo json_encode( $woocommerce->cart->get_fees() ) ?></script>

<?php   
    wc_print_notices();
    do_action( 'woocommerce_before_cart' );

    $handle=new WC_Product_Variable(15538);
    $attributes = $handle->get_variation_attributes();
    $attribute_keys = array_keys( $attributes );

    do_action( 'woocommerce_after_add_to_cart_form' );
    $args = array(
        'number'     => $number,
        'orderby'    => 'slug',
        'hide_empty' => $hide_empty,
        'include'    => $ids,
        'order'      => 'ASC'
    );

    $product_categories = get_terms( 'product_cat', $args );
    $count = count($product_categories);

?>

 <cart-app></cart-app>

 <?php

if ( $count > 0 ){
    foreach ( $product_categories as $product_category ) {
        if($product_category->slug == '1course' || $product_category->slug == '2accomdation' || $product_category->slug == '3extras' || $product_category->slug == 'visa'){
            if($product_category->name =='Accomodation') {
                            
            } else {

            }
        $args = array(
            'posts_per_page' => -1,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
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
                    'terms' => $product_category->slug
                )
            ),
            'post_type' => 'product',
            'orderby' => 'ID',
            'order' =>'DESC'
        );
        $products2 = new WP_Query( $args2 );
        
        if($product_category->slug == '1course') {
                global $wc_cpdf;
                $icnt = 0; 
                $info = array();
                while ( $products->have_posts() ) { $products->the_post(); $icnt++; 
                    $info[] = array(
                        'index' => $icnt,
                        'the_id' => get_the_ID(),
                        'title' => get_the_title(get_the_ID()),
                        'product_radio_title' => $wc_cpdf->get_value(get_the_ID(), 'product_radio_title')
                    );

                }
                // <script>var abc = abc || {}; abc.viewInfo = { course: { radio: <?php echo json_encode($info) ?> } }</script>
    <?php
        }
        
        if($product_category->slug == '2accomdation') { ?>                                     
                        <?php global $wc_cpdf;
                        $icnt = 0; 
                        while ( $products->have_posts() ) { $products->the_post(); $icnt++;?>
                        
                            // <option value='<?php the_id(); ?>'><?php echo $wc_cpdf->get_value(get_the_ID(), 'product_radio_title'); ?></span></option>

                        <?php } ?>

            }
        if($product_category->slug == '3extras') {
            while ( $products2->have_posts() ) {
                $products2->the_post();
                ?>
                    // <option value="<?php the_id(); ?>">
                    //         <?php the_title(); ?>
                    // </option>
             <?php
            }
        }

        if($product_category->slug == 'visa') {
            while ( $products->have_posts() ) {
                $products->the_post();
                ?>
                    // <option value="<?php the_id(); ?>">
                    //     <a href="<?php the_permalink(); ?>">
                    //         <?php the_title(); ?>
                    //     </a>      
                    // </option>
             <?php
				
			}
            echo "</select>";
			
        }

    }
    
    }

    ?> 

}
?>

<?php do_action( 'woocommerce_after_cart_table' ); ?>


    
<?php do_action( 'woocommerce_after_cart' ); ?>

<script>
    var site_url = '<?php echo $site_url; ?>'
    var abc = abc || {}
    abc.cart = <?php echo $data; ?>
</script>

<script src="<?php echo $site_url;?>/wp-content/themes/skilled-child/js/abc-cart.min.js?<?php echo time() ?>"></script>
