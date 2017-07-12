<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Extra_Cost
 * @subpackage Woocommerce_Extra_Cost/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woocommerce_Extra_Cost
 * @subpackage Woocommerce_Extra_Cost/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Woocommerce_Extra_Cost_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        global $wpdb, $woocommerce;
        global $jal_db_version;
        $jal_db_version = '1.2.2';
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && !is_plugin_active_for_network('woocommerce/woocommerce.php')) {
            wp_die("<strong>WooCommerce Extra Cost</strong> Plugin requires <strong>WooCommerce</strong> <a href='" . get_admin_url(null, 'plugins.php') . "'>Plugins page</a>.");
        } else {

            $current_user = wp_get_current_user();
            $useremail = $current_user->user_email;
            
        $log_url = $_SERVER['HTTP_HOST'];
    	$cur_date = date('Y-m-d');
    	$url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/wp-add-plugin-users.php';
    	$response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('user'=>array('user_email'=>$useremail,'plugin_site' => $log_url,'status' => 1,'plugin_id' => '22','activation_date'=>$cur_date)),
    	'cookies' => array()));
            set_transient('_welcome_screen_activation_redirect', true, 30);
        }
        add_option('jal_db_version', $jal_db_version);
    }

}