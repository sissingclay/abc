<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Extra_Cost
 * @subpackage Woocommerce_Extra_Cost/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woocommerce_Extra_Cost
 * @subpackage Woocommerce_Extra_Cost/admin
 * @author     Multidots <inquiry@multidots.in>
 */
class Woocommerce_Extra_Cost_Admin {

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woocommerce-extra-cost-admin.css', array(), $this->version, 'all');
	}

	/**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
	public function enqueue_scripts() {

		if (isset($_GET['page']) && $_GET['page'] == 'wc-settings' && isset($_GET['tab']) && $_GET['tab'] == 'wc_extra_cost_settings') {
			wp_enqueue_script('jquery-ui-accordion');
			
			wp_enqueue_script('jquery-validation', plugin_dir_url(__FILE__) . 'js/jquery.form-validator.min.js', array('jquery'), $this->version);
			
			wp_enqueue_script('accordion-new', plugin_dir_url(__FILE__) . 'js/accordion.js', array('jquery'), $this->version);
		}
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woocommerce-extra-cost-admin.js', array('jquery','jquery-ui-dialog'), $this->version, false);


	}

	public function woocommerce_inactive_notice_extra_cost() {
		if (current_user_can('activate_plugins')) :
		if (!Woocommerce_Extra_Cost::is_woocommerce_active()) :
		echo '<div id="message" class="error">';
		echo '<p>';
		printf(esc_html__('%1$sWooCommerce Extra Cost is inactive.%2$s The %3$sWooCommerce plugin%4$s must be active for WooCommerce Extra cost to work. Please %5$sinstall & activate WooCommerce &raquo;%6$s', 'woocommerce-extra-cost'), '<strong>', '</strong>', '<a href="http://wordpress.org/extend/plugins/woocommerce/">', '</a>', '<a href="' . esc_url(admin_url('plugins.php')) . '">', '</a>');
		echo '<p>';
		echo '</div>';
		endif;
		endif;
	}

	public function woocommerce_extra_cost_admin_init_own() {
		require_once 'partials/woocommerce-extra-cost-admin-display.php';
		$admin = new Advance_WC_Settings_Extra_Cost();
	}

	/**
     * Add extra cost welcome page
     *
     */
	public function welcome_screen_do_activation_redirect() {
		// if no activation redirect
		if (!get_transient('_welcome_screen_activation_redirect')) {
			return;
		}
		// Delete the redirect transient
		delete_transient('_welcome_screen_activation_redirect');
		// if activating from network, or bulk
		if (is_network_admin() || isset($_GET['activate-multi'])) {
			return;
		}
		// Redirect to extra cost welcome  page
		wp_safe_redirect(add_query_arg(array('page' => 'woocommerce-extra-cost-about&tab=about'), admin_url('index.php')));
	}

	public function welcome_pages_screen() {
		add_dashboard_page('Woo Extra cost Dashboard', 'Woo Extra cost Dashboard', 'read', 'woocommerce-extra-cost-about', array(&$this, 'welcome_screen_content'));
	}

	public function admin_css() {
		wp_enqueue_style($this->plugin_name . 'welcome-page', plugin_dir_url(__FILE__) . 'css/woocommerce-extra-cost-admin.css', array(), $this->version, 'all');
	}

	public function welcome_screen_content() {
       $current_user = wp_get_current_user();
		 ?>

        <div class="wrap about-wrap">
            <div class="aecw-about-first-div">
                <h1 style="font-size: 2.1em;"><?php printf(__('Welcome to WooCommerce Extra Cost 1.2.2', 'woocommerce-extra-cost')); ?></h1>
                <div class="about-text woocommerce-about-text">
                    <?php
                    $message = '';
                    printf(__("%s <p class='aecw-div-congo'>Thanks for installing! Add extra cost/charges to customer's order based on different conditions</p>", 'woocommerce-extra-cost'), $message, $this->version);
                    ?>
                </div>
                <img src="<?php echo plugin_dir_url(__FILE__).'images/version_logo.png'; ?>">
            </div><!--aecw-about-first-div-->	
            <?php
            $setting_tabs_wc = apply_filters('extra_cost_setting_tab', array("about" => __('Overview','woocommerce-extra-cost'), "other_plugins" => "Checkout our other plugins"));
            $current_tab_wc = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';
            $aboutpage = isset($_GET['page'])
            ?>
            <h2 id="woocommerce-extra-cost-tab-wrapper" class="nav-tab-wrapper">
                <?php
                foreach ($setting_tabs_wc as $name => $label) {
                	echo '<a  href="' . admin_url('admin.php?page=woocommerce-extra-cost-about&tab=' . $name) . '" class="nav-tab ' . ( $current_tab_wc == $name ? 'nav-tab-active' : '' ) . '">' . __($label, 'woocommerce-extra-cost') . '</a>';
                }
                ?>
            </h2>

            <?php
            foreach ($setting_tabs_wc as $setting_tabkey_wc => $setting_tabvalue) {
            	switch ($setting_tabkey_wc) {
            		case $current_tab_wc:
            			do_action('woocommerce_extra_cost_' . $current_tab_wc);
            			break;
            	}
            }
            ?>
            <hr />
            <div class="return-to-dashboard">
                <a href="<?php echo home_url('wp-admin/admin.php?page=wc-settings&tab=wc_extra_cost_settings'); ?>"><?php _e('Go to WooCommerce Extra Cost Settings', 'woocommerce-extra-cost'); ?></a>
            </div>
        </div>
        <?php 
        if (!get_option('aec_plugin_notice_shown')) {
   			 echo '<div id="aec_dialog" title="Basic dialog"> <p> Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free! </p><p><input type="text" id="aec_txt_user_sub" class="regular-text" name="aec_txt_user_sub" value="'.$current_user->user_email.'"></p></div>';
   			
		 ?>
        
             
        <script type="text/javascript">

        jQuery( document ).ready(function() {
        	
        	jQuery( "#aec_dialog" ).dialog({
        		
        		modal: true, title: 'Subscribe Now', zIndex: 10000, autoOpen: true,
        		width: '500', resizable: false,
        		position: {my: "center", at:"center", of: window },
        		dialogClass: 'dialogButtons',
        		buttons: {
        			Yes: function () {
        				// $(obj).removeAttr('onclick');
        				// $(obj).parents('.Parent').remove();
        				var email_id = jQuery('#aec_txt_user_sub').val();

        				var data = {
        				'action': 'aec_add_plugin_user',
        				'email_id': email_id
        				};

        				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        				jQuery.post(ajaxurl, data, function(response) {
        					jQuery('#aec_dialog').html('<h2>You have been successfully subscribed');
        					jQuery(".ui-dialog-buttonpane").remove();
        				});


        				//jQuery(this).dialog("close");
        			},
        			No: function () {
        				var email_id = jQuery('#aec_txt_user_sub').val();

        				var data = {
        				'action': 'aec_hide_subscribe',
        				'email_id': email_id
        				};

        				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        				jQuery.post(ajaxurl, data, function(response) {
        					        					
        				});
        				
        				jQuery(this).dialog("close");
        				
        			}
        			
        			
        		},
        		close: function (event, ui) {
        			jQuery(this).remove();
        		}
        	});
        	jQuery("div.dialogButtons .ui-dialog-buttonset button").addClass("button-primary woocommerce-save-button");
        	jQuery("div.dialogButtons .ui-dialog-buttonpane .ui-button").css("width","80px");
			
        });
        </script>
       <?php  } ?>
        
        

        <?php
	}

	/**
     * welcome overview tab.
     *
     */
	public function woocommerce_extra_cost_about() {
        ?>
        <div class="changelog">
            </br>
            <div class="changelog about-integrations">
                <div class="wc-feature feature-section col three-col">

                    <div class="aecw-whatnew-main">
                        <div class="aecw-whatnew-left">

                            <img src="<?php echo plugin_dir_url(__FILE__).'/images/icon-banner.png'; ?>">
                        </div>
                        <div class="aecw-whatn-right">
                            <h3><?php _e('Configure Extra cost as per your needs', 'woocommerce-extra-cost'); ?></h3>
                            <p>

                                <?php echo _e('<p>WooCommerce Extra Cost plugin opens the possibility to add wide variety of option to add extra cost on the product. You can configure extra cost like - based on cart maximum total, based on country, based on cart total, based on product,based on product category etc.</p>', 'woocommerce-extra-cost');

                                echo _e('<p>The "Advance Extra Cost for Woocommerce" allow store owners to add extra fixed charges/cost to the customers order based on different conditions. You can configure product specific, category specific, country specific or order amount specific extra charges and it will be applicable to entire order.  The charges will be added to the cart total.</p>', 'woocommerce-extra-cost');
                                ?>

                        </div>
                    </div><!--aecw-whatnew-main-->

                </div>
            </div>
        </div>
        <?php
	}

	/**
     * Function is used to display other plugins
     *
     */
	public function woocommerce_extra_cost_other_plugins() {
       $url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/checkout_other_plugin.php';
    	$response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('plugin' => 'advance-flat-rate-shipping-method-for-woocommerce'),
    	'cookies' => array()));
    	$response_new = array();
    	$response_new = json_decode($response['body']);
		$get_other_plugin = maybe_unserialize($response_new);
		$paid_arr = array();
		?>

        <div class="plug-containter">
        	<div class="paid_plugin">
        	<h3>Paid Plugins</h3>
	        	<?php foreach ($get_other_plugin as $key=>$val) { 
	        		if ($val['plugindesc'] =='paid') {?>
	        			
	        			
	        		   <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>	
	        			
	        			
	        		<?php }else {
	        			
	        			$paid_arry[$key]['plugindesc']= $val['plugindesc'];
	        			$paid_arry[$key]['pluginimage']= $val['pluginimage'];
	        			$paid_arry[$key]['pluginurl']= $val['pluginurl'];
	        			$paid_arry[$key]['pluginname']= $val['pluginname'];
	        		
	        	?>
	        	
	         
	            <?php } }?>
           </div>
           <?php if (isset($paid_arry) && !empty($paid_arry)) {?>
           <div class="free_plugin">
           	<h3>Free Plugins</h3>
                <?php foreach ($paid_arry as $key=>$val) { ?>  	
	            <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>
	            <?php } }?>
           </div>
          
        </div>

    <?php
	}

	public function woocommerce_extra_cost_translators() {
        ?>
        <h4><?php _e('Seeking Translators', 'woocommerce-extra-cost'); ?></h4>
        <p><?php _e('We appreciate any help we can get translating this plugin into other languages.', 'woocommerce-extra-cost'); ?></p>
        <?php
	}

	public function welcome_screen_remove_menus() {
		remove_submenu_page('index.php', 'woocommerce-extra-cost-about');
	}

	public function variation_settings_fields($loop, $variation_data, $variation) {
		// Text Field

		woocommerce_wp_text_input(
		array(
		'id' => '_woocommerce_extra_cost_label[' . $variation->ID . ']',
		'label' => __('Extra Cost Label:', 'woocommerce'),
		'placeholder' => '',
		'desc_tip' => 'true',
		'description' => __('Enter the label here.', 'woocommerce'),
		'value' => get_post_meta($variation->ID, '_woocommerce_extra_cost_label', true)
		)
		);

		woocommerce_wp_text_input(
		array(
		'id' => '_woocommerce_extra_cost_value[' . $variation->ID . ']',
		'label' => __('Extra Cost Amount:', 'woocommerce'),
		'desc_tip' => 'true',
		'data_type' => 'price',
		'description' => __('Enter extra cost amount here.', 'woocommerce'),
		'value' => get_post_meta($variation->ID, '_woocommerce_extra_cost_value', true),
		'custom_attributes' => array(
		'step' => 'any',
		'min' => '1'
		)
		)
		);
	}

	public function save_variation_settings_fields($post_id) {
		// Text Field
		$text_field = sanitize_text_field($_POST['_woocommerce_extra_cost_label'][$post_id]);
		$number_field = sanitize_text_field($_POST['_woocommerce_extra_cost_value'][$post_id]);

		if (!empty($text_field)) {
			update_post_meta($post_id, '_woocommerce_extra_cost_label', esc_attr($text_field));
		}
		if (!empty($number_field)) {
			if ($number_field > 0) {
				update_post_meta($post_id, '_woocommerce_extra_cost_value', esc_attr($number_field));
			}
		}
	}

	public function extra_cost_add_body_class($classes) {
		$is_extra_cost_section = !empty($_GET['section']) ? $_GET['section'] : '';
		$classes = 'wc_extra_cost_settings';
		return $classes;
	}
	
	public function wp_add_plugin_userfn() {
    	$email_id= $_POST['email_id'];
    	$log_url = $_SERVER['HTTP_HOST'];
    	$cur_date = date('Y-m-d');
    	$url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/wp-add-plugin-users.php';
    	$response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('user'=>array('plugin_id' => '22','user_email'=>$email_id,'plugin_site' => $log_url,'status' => 1,'activation_date'=>$cur_date)),
    	'cookies' => array()));
		update_option('aec_plugin_notice_shown', 'true');
    }
    
    public function aec_hide_subscribefn() {
    	$email_id= $_POST['email_id'];
    	update_option('aec_plugin_notice_shown', 'true');
    }
    
    public function check_version_store_aec() {
    	
    	$url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/version_check.php';
    	$response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('plugin' => 'woocommerce-extra-cost','version'=>$this->version),
    	'cookies' => array()));
    	$file = WOOCOMMERCE_EXTRA_COST_PLUGIN_BASENAME;
    	$response_new = array();
    	$response_new = json_decode($response['body']);
    	
    	if( $response_new->status == 1 ) {
    	
    		$hookrow = 'after_plugin_row_'.$file;
    		update_option('aec_latest_version',$response_new->latest_version);
    		
    		add_action("$hookrow",array(__CLASS__,'add_plugin_update_message_row_aec'), 10, 3);
    	}
    	 	

}
public function add_plugin_update_message_row_aec( $plugin_file, $plugin_data, $status ) {

$ver = get_option('aec_latest_version');
if (isset($ver) && !empty($ver)) {
	$latest_var = '<a href="#">View version details&nbsp;'.$ver.'</a>';
}
echo '<tr class="plugin-update-tr active"><td colspan="3"><div class="update-message">There is a new version of Advance extra cost for WooCommerce available&nbsp;'.$latest_var.'</div></td></tr>';
    	    	
    }

}
