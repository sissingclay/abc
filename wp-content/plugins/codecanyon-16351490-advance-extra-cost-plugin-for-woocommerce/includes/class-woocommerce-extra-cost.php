<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woocommerce_Extra_Cost
 * @subpackage Woocommerce_Extra_Cost/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_Extra_Cost
 * @subpackage Woocommerce_Extra_Cost/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Woocommerce_Extra_Cost {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Woocommerce_Extra_Cost_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;
    private static $active_plugins;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'woocommerce-extra-cost';
        $this->version = '1.2.2';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

        $prefix = is_network_admin() ? 'network_admin_' : '';
        add_filter("{$prefix}plugin_action_links_" . WOOCOMMERCE_EXTRA_COST_PLUGIN_BASENAME, array($this, 'plugin_action_links'), 10, 4);
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Woocommerce_Extra_Cost_Loader. Orchestrates the hooks of the plugin.
     * - Woocommerce_Extra_Cost_i18n. Defines internationalization functionality.
     * - Woocommerce_Extra_Cost_Admin. Defines all hooks for the admin area.
     * - Woocommerce_Extra_Cost_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woocommerce-extra-cost-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woocommerce-extra-cost-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-woocommerce-extra-cost-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woocommerce-extra-cost-public.php';

        $this->loader = new Woocommerce_Extra_Cost_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Woocommerce_Extra_Cost_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Woocommerce_Extra_Cost_i18n();
		
        $plugin_i18n->set_domain( $this->get_plugin_name() );
        
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Return the plugin action links.  This will only be called if the plugin
     * is active.
     *
     * @since 1.0.0
     * @param array $actions associative array of action names to anchor tags
     * @return array associative array of plugin action links
     */
    public function plugin_action_links($actions, $plugin_file, $plugin_data, $context) {
        $custom_actions = array(
            'configure' => sprintf('<a href="%s">%s</a>', admin_url('/admin.php?page=wc-settings&tab=wc_extra_cost_settings'), __('Settings', 'woocommerce-extra-cost')),
            'docs' => sprintf('<a href="%s" target="_blank">%s</a>', 'https://www.dropbox.com/s/4rfu5wa5vfwq3l2/Advance%20Extra%20Cost%20plugin%20for%20WooCommerce.pdf?dl=0', __('Docs', 'woocommerce-extra-cost')),
            'support' => sprintf('<a href="%s" target="_blank">%s</a>', 'http://codecanyon.net/item/advance-extra-cost-plugin-for-woocommerce/16351490/support', __('Support', 'woocommerce-extra-cost')),
        );

        // add the links to the front of the actions list
        return array_merge($custom_actions, $actions);
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Woocommerce_Extra_Cost_Admin($this->get_plugin_name(), $this->get_version());
        if (!Woocommerce_Extra_Cost::is_woocommerce_active()) {
            $this->loader->add_action('admin_notices', $plugin_admin, 'woocommerce_inactive_notice_extra_cost');
            return;
        }

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        global $pagenow;
        if (isset($_GET['tab']) && $_GET['tab'] == 'wc_extra_cost_settings') {
            $this->loader->add_action('admin_body_class', $plugin_admin, 'extra_cost_add_body_class', 10, 1);
        }
        $this->loader->add_action('admin_init', $plugin_admin, 'woocommerce_extra_cost_admin_init_own');
        $this->loader->add_action('admin_init', $plugin_admin, 'welcome_screen_do_activation_redirect');
        $this->loader->add_action('admin_menu', $plugin_admin, 'welcome_pages_screen');
        $this->loader->add_action('admin_head', $plugin_admin, 'welcome_screen_remove_menus');
        $this->loader->add_action('woocommerce_extra_cost_about', $plugin_admin, 'woocommerce_extra_cost_about');
        $this->loader->add_action('woocommerce_extra_cost_translators', $plugin_admin, 'woocommerce_extra_cost_translators');
        $this->loader->add_action('woocommerce_extra_cost_other_plugins', $plugin_admin, 'woocommerce_extra_cost_other_plugins');
        $varible_product_option_val = get_option('wc_extra_cost_variable_product');
        if (isset($varible_product_option_val) && !empty($varible_product_option_val) && $varible_product_option_val == 'yes') {
            $this->loader->add_action('woocommerce_product_after_variable_attributes', $plugin_admin, 'variation_settings_fields', 10, 3);
            $this->loader->add_action('woocommerce_save_product_variation', $plugin_admin, 'save_variation_settings_fields', 10, 2);
        }
        $this->loader->add_action( 'wp_ajax_aec_add_plugin_user', $plugin_admin, 'wp_add_plugin_userfn' );
        $this->loader->add_action( 'wp_ajax_aec_hide_subscribe', $plugin_admin, 'aec_hide_subscribefn' );
        
        $this->loader->add_action( 'admin_init', $plugin_admin, 'check_version_store_aec');

        /**
         * extra cost based on product callback function
         * remove selected product charge.
         */
        $this->loader->add_action('wp_ajax_remove_extra_cost_product_charge', $plugin_admin, 'remove_extra_cost_product_charge');
        $this->loader->add_action('wp_ajax_nopriv_remove_extra_cost_product_charge', $plugin_admin, 'remove_extra_cost_product_charge');

        /**
         * ajax callback function
         * get option values
         */
        $this->loader->add_action('wp_ajax_get_option_values', $plugin_admin, 'get_option_values');
        $this->loader->add_action('wp_ajax_nopriv_get_option_values', $plugin_admin, 'get_option_values');

        /**
         * ajax callback function
         * get custom table records
         */
        $this->loader->add_action('wp_ajax_get_custom_table_values', $plugin_admin, 'get_custom_table_values');
        $this->loader->add_action('wp_ajax_nopriv_get_custom_table_values', $plugin_admin, 'get_custom_table_values');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $active_plugins = get_option('active_plugins');
        $plugin_path = WOOCOMMERCE_EXTRA_COST_PLUGIN_BASENAME;//'woocommerce-extra-cost/woocommerce-extra-cost.php';
        if (in_array($plugin_path, $active_plugins)) {

            $plugin_public = new Woocommerce_Extra_Cost_Public($this->get_plugin_name(), $this->get_version());

            $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
            $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

            $based_on_country = get_option('wc_extra_cost_country');
            if (isset($based_on_country) && !empty($based_on_country) && $based_on_country == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_country');
            }

            $based_on_cart_total = get_option('wc_extra_cost_cart_total');
            if (isset($based_on_cart_total) && !empty($based_on_cart_total) && $based_on_cart_total == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_cart_total');
            }

            $based_on_quantity = get_option('wc_extra_cost_cart_quantity');
            if (isset($based_on_quantity) && !empty($based_on_quantity) && $based_on_quantity == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_cart_item');
            }

            $based_on_weight = get_option('wc_extra_cost_cart_weight');
            if (isset($based_on_weight) && !empty($based_on_weight) && $based_on_weight == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_weight');
            }

            $based_on_shipping_class = get_option('wc_extra_cost_cart_shipping_class');
            if (isset($based_on_shipping_class) && !empty($based_on_shipping_class) && $based_on_shipping_class == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_shipping_class');
            }

            $based_on_product = get_option('wc_extra_cost_cart_product');
            if (isset($based_on_product) && !empty($based_on_product) && $based_on_product == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_product');
            }

            $based_on_category = get_option('wc_extra_cost_cart_category_product');
            if (isset($based_on_category) && !empty($based_on_category) && $based_on_category == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_product_category');
            }

            $based_on_product_tag = get_option('wc_extra_cost_cart_tag_product');
            if (isset($based_on_product_tag) && !empty($based_on_product_tag) && $based_on_product_tag == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_product_tag');
            }
			
            $based_on_sku = get_option('wc_extra_cost_cart_sku_product');
            if (isset($based_on_sku) && !empty($based_on_sku) && $based_on_sku == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_product_sku');
            }

            $based_on_coupon = get_option('wc_extra_cost_cart_coupon_product');
            if (isset($based_on_coupon) && !empty($based_on_coupon) && $based_on_coupon == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_product_coupon');
            }

            $based_on_user = get_option('wc_extra_cost_user');
            if (isset($based_on_user_role) && !empty($based_on_user_role) && $based_on_user_role == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_user');
            }

            $based_on_user_role = get_option('wc_extra_cost_role_user');
            if (isset($based_on_user_role) && !empty($based_on_user_role) && $based_on_user_role == 'yes') {
                $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_user_role');
            }

            $this->loader->add_filter('woocommerce_paypal_args', $plugin_public, 'paypal_bn_code_filter', 99, 1);
            $varible_product_option_val = get_option('wc_extra_cost_variable_product');
            if (isset($varible_product_option_val) && !empty($varible_product_option_val) && $varible_product_option_val == 'yes') {
                $this->loader->add_filter('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_variable_product');
            }
            
            $based_on_payment_gateway = get_option('wc_extra_cost_paymentgateway');
            if (isset($based_on_payment_gateway) && !empty($based_on_payment_gateway) && $based_on_payment_gateway == 'yes') {
            	
               $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_paymentgateway');
            }
            $this->loader->add_action('woocommerce_cart_calculate_fees', $plugin_public, 'woo_add_cart_fee_based_on_master_setting');
        }
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Woocommerce_Extra_Cost_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    public static function init() {

        Woocommerce_Extra_Cost::$active_plugins = (array) get_option('active_plugins', array());

        if (is_multisite())
            Woocommerce_Extra_Cost::$active_plugins = array_merge(Woocommerce_Extra_Cost::$active_plugins, get_site_option('active_sitewide_plugins', array()));
    }

    public static function is_woocommerce_active() {
        return Woocommerce_Extra_Cost::woocommerce_active_check_extra_cost();
    }

    public static function woocommerce_active_check_extra_cost() {
        if (!Woocommerce_Extra_Cost::$active_plugins)
            Woocommerce_Extra_Cost ::init();
        return in_array('woocommerce/woocommerce.php', Woocommerce_Extra_Cost::$active_plugins) || array_key_exists('woocommerce/woocommerce.php', Woocommerce_Extra_Cost::$active_plugins);
    }

}