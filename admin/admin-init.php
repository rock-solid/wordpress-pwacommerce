<?php
namespace PWAcommerce\Admin;

use \PWAcommerce\Includes\Options;

/**
 * Admin_Init class for initializing the admin area of the PWAcommerce plugin.
 *
 * Displays menu & loads static files for the admin page.
 */
class Admin_Init {

	private static $menu_title = PWACOMMERCE_PLUGIN_NAME;
	private static $label = PWACOMMERCE_SHORT_NAME;


	/**
	 * Constructor functions that adds all the admin hooks.
	 */
	function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );

		add_filter( 'plugin_action_links_' . plugin_basename( PWACOMMERCE_PLUGIN_PATH . '/pwacommerce.php' ), [ $this, 'add_settings_link' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

	}

	/**
	 * Function that adds the plugin settings button to the wordpress menu side bar.
	 */
	public function admin_menu() {
		add_menu_page( self::$menu_title, self::$label, 'manage_options', 'pwacommerce', [ $this, 'settings' ], WP_PLUGIN_URL . '/' . PWACOMMERCE_DOMAIN . '/admin/images/pwacommerce.png' );
	}

	/**
	 * Load settings page.
	 */
	public function settings() {
		include( PWACOMMERCE_PLUGIN_PATH . 'admin/pages/settings.php' );
	}

	/**
	 * Adds a settings link to the plugin in the plugin list.
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="' . get_admin_url() . 'admin.php?page=PWAcommerce">' . __( 'Settings' ) . '</a>';

		array_push( $links, $settings_link );

		return $links;
	}

	/**
	 * Used to enqueue scripts for the admin area.
	 */
	public function enqueue_scripts() {


	}

}


