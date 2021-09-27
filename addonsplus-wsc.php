<?php
/**
 * @package  WooCart
 */
/*
Plugin Name: Sticky Add To Cart Bar For WooCommerce
Plugin URI: https://addonsplus.com/downloads/woocommerce-sticky-add-to-cart-bar-pro/
Description: Plugin that add sticky Add To Cart Bar on product page. It supports variable product with ajax add to cart feature. Grab visitors attention and increase the conversion using Sticky Add To Cart Bar For WooCommerce.
Version: 1.4.3
Author: addonsplus
Requires at least: 4.8
Tested up to: 5.8
WC requires at least: 3.2
WC tested up to: 5.5
Author URI: https://addonsplus.com/
Text Domain: addonsplus-wsc
*/

// If this file is called Directly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, You can not access...' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_woocart_plugin() {
  // check dependency of other plugins
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
     include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
 }
 if ( current_user_can( 'activate_plugins' ) && ! class_exists( 'WooCommerce' ) ) {
    // Custom Error Message
    add_action( 'admin_notices', 'wsc_woo_admin_notice__error' );
}

WscInc\Base\Activate::activate();
}

// Hook to activate the plugin
register_activation_hook( __FILE__, 'activate_woocart_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_woocart_plugin() {
	WscInc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_woocart_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'WscInc\\Init' ) ) {
	WscInc\Init::registerServices();
}

// Check status of Any depended plugin (Ex. WooCommerce) when dashboard is loaded and it will automatically deactivate the plugin if that plugin is not available

add_action( 'admin_init' , 'check_plugin' );

function check_plugin(){
    // Check woocommerce is active or not
	if(! class_exists( 'WooCommerce' )){
    add_action( 'admin_notices', 'wsc_woo_admin_notice__error' );
	}
}

function wsc_woo_admin_notice__error() {
  echo '<div class="notice notice-error"><p>Sticky Add To Cart Bar For WooCommerce is enabled but not effective. It requires WooCommerce in order to work.</p></div>';
}