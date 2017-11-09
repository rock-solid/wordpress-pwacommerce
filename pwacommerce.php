<?php

/**
 * Plugin Name: PWAcommerce
 * Description: Turn your E-commerce site into a Progressive Web App
 * Author: pwacommerce.io
 * Version: 0.1
 */

namespace PWAcommerce;

require_once 'vendor/autoload.php';
require_once 'core/config.php';

global $pwacommerce_options;
$pwacommerce_options = new Core\PWAcommerce();

function PWAcommerce_admin_init() {
	new Admin\Admin_Init();
}

function PWAcommerce_frontend_init() {
	new Frontend\Frontend_Init();
}

register_activation_hook( __FILE__, [ &$pwacommerce, 'activate' ] );
register_deactivation_hook( __FILE__, [ &$pwacommerce, 'deactivate' ] );

if ( is_admin() ) {

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

		$pwacommerce_ajax = new Admin\Admin_Ajax();
		add_action( 'wp_ajax_pwacommerce_settings', [ &$pwacommerce_ajax, 'settings' ] );
		add_action( 'wp_ajax_pwacommerce_subscribe', [ &$pwacommerce_ajax, 'subscribe' ] );
		add_action( 'wp_ajax_pwacommerce_editimages', [ &$pwacommerce_ajax, 'editimages' ] );


	} else {

		add_action( 'plugins_loaded', 'PWAcommerce\pwacommerce_admin_init' );
	}

} else {

	// add_action( 'plugins_loaded', 'PWAcommerce\pwacommerce_frontend_init' );
}

