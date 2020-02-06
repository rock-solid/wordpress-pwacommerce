<?php

 /**
 * Plugin Name: PWAcommerce
 * Plugin URI:  http://wordpress.org/plugins/pwacommerce/
 * Description: WooCommerce mobile plugin to package your online store into a Progressive Web App.
 * Author: PWAcommerce.com
 * Author URI: http://pwacommerce.com
 * Version: 0.5.1
 * Copyright (c) 2020 PWAcommerce.com
 * License: The PWAcommerce plugin is Licensed under the Apache License, Version 3.0
 * Text Domain: pwacommerce
 */

namespace PWAcommerce;

require_once 'vendor/autoload.php';
require_once 'core/config.php';
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

global $pwacommerce_options;
$pwacommerce_options = new Core\PWAcommerce();

function PWAcommerce_admin_init() {
	new Admin\Admin_Init();
}

function PWAcommerce_frontend_init() {
	new Frontend\Frontend_Init();
}


global $pwacommerce;
$pwacommerce  = new Core\PWAcommerce();

global $pwacommerce_api;
$pwacommerce_api = new Includes\PWAcommerce_API();

add_action('rest_api_init', [ $pwacommerce_api, 'register_pwacommerce_routes' ]);

register_activation_hook( __FILE__, [ $pwacommerce, 'activate' ] );

if ( is_admin() ) {

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

		$pwacommerce_ajax = new Admin\Admin_Ajax();
		add_action( 'wp_ajax_pwacommerce_settings', [ $pwacommerce_ajax, 'settings' ] );
		add_action( 'wp_ajax_pwacommerce_subscribe', [ $pwacommerce_ajax, 'subscribe' ] );
		add_action( 'wp_ajax_pwacommerce_editimages', [ $pwacommerce_ajax, 'editimages' ] );
		add_action( 'wp_ajax_pwacommerce_wookeys', [ $pwacommerce_ajax, 'wookeys' ] );


	} else {

		add_action( 'plugins_loaded', 'PWAcommerce\pwacommerce_admin_init' );
	}

} else {

	if ( is_plugin_active ( 'woocommerce/woocommerce.php' ) ) {

		add_action( 'plugins_loaded', 'PWAcommerce\pwacommerce_frontend_init' );
	}
}
