<?php

/**
 * Plugin Name:       Advance Extra Cost for WooCommerce
 * Plugin URI:        http://www.multidots.com
 * Description:       Using WooCommerce Extra Cost plugin, you can add a wide variety of option to add extra cost. Using this plugin you can configure different parameters on which a particular extra cost becomes available to the customers at the time of checking out.You can configure extra cost like - based on cart maximum total, based on country, based on cart total, based on product,based on product category etc.
 * Version:           1.2.2
 * Author:            Multidots
 * Author URI:        http://www.multidots.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-extra-cost
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * define plugin basename
 */
if (!defined('WOOCOMMERCE_EXTRA_COST_PLUGIN_BASENAME')) {
    define('WOOCOMMERCE_EXTRA_COST_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-extra-cost-activator.php
 */
function activate_woocommerce_extra_cost() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-extra-cost-activator.php';
    Woocommerce_Extra_Cost_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-extra-cost-deactivator.php
 */
function deactivate_woocommerce_extra_cost() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-extra-cost-deactivator.php';
    Woocommerce_Extra_Cost_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woocommerce_extra_cost');
register_deactivation_hook(__FILE__, 'deactivate_woocommerce_extra_cost');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woocommerce-extra-cost.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_extra_cost() {

    $plugin = new Woocommerce_Extra_Cost();
    $plugin->run();
}

run_woocommerce_extra_cost();
