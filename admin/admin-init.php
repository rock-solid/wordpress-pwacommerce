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

		add_action( 'admin_notices', [ $this, 'pwacommerce_notices' ] );

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
		$settings_link = '<a href="' . get_admin_url() . 'admin.php?page=pwacommerce">' . __( 'Settings' ) . '</a>';

		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			$settings_link = '<a href="' . get_admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term"><span style="color:#b30000">' . __( 'Action Required: Get WooCommerce' ) . '</span></a>';
		}

		array_push( $links, $settings_link );

		return $links;
	}

	/**
	 * Checks if woocommerce plugin is installed and displays notice if not
	 */
	public function pwacommerce_notices(){
		if ( ! is_plugin_active ( 'woocommerce/woocommerce.php' ) ) {
			echo '<div class="notice notice-warning is-dismissible">
						<p><b>PWAcommerce</b> requires that you have the WooCommerce plugin from Automattic active.</p>
						<p>
							Please make sure you have the plugin installed and activated. <a href="' . get_admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term">Download the WooCommerce plugin</a>
						</p>
				  </div>';
			return;
		}
	}

	/**
	 * Used to enqueue scripts for the admin area.
	 */
	public function enqueue_scripts() {

		$pwacommerce_options = new Options();

		wp_enqueue_style( $pwacommerce_options->prefix . 'css_general', plugins_url( PWACOMMERCE_DOMAIN . '/admin/css/general.css' ), [], PWACOMMERCE_VERSION );

		$dependencies = [ 'jquery-core', 'jquery-migrate' ];

		wp_enqueue_script( $pwacommerce_options->prefix . 'js_validate', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Interface/Lib/jquery.validate.min.js' ), $dependencies, '1.11.1' );
		wp_enqueue_script( $pwacommerce_options->prefix . 'js_validate_additional', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Interface/Lib/validate-additional-methods.min.js' ), $dependencies, '1.11.1' );
		wp_enqueue_script( $pwacommerce_options->prefix . 'js_loader', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Interface/Loader.min.js' ), $dependencies, PWACOMMERCE_VERSION );
		wp_enqueue_script( $pwacommerce_options->prefix . 'js_ajax_upload', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Interface/AjaxUpload.min.js' ), $dependencies, PWACOMMERCE_VERSION );
		wp_enqueue_script( $pwacommerce_options->prefix . 'js_interface', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Interface/JSInterface.min.js' ), $dependencies, PWACOMMERCE_VERSION );
		wp_enqueue_script( $pwacommerce_options->prefix . 'js_settings', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Modules/PWAcommerce_Settings.min.js' ), [], PWACOMMERCE_VERSION );
		wp_enqueue_script( $pwacommerce_options->prefix . 'js_subscribe', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Modules/PWAcommerce_Subscribe.min.js' ), [], PWACOMMERCE_VERSION );
		wp_enqueue_script( $pwacommerce_options->prefix . 'js_editimages', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Modules/PWAcommerce_EditImages.min.js' ), [], PWACOMMERCE_VERSION );
		wp_enqueue_script( $pwacommerce_options->prefix . 'js_wookeys', plugins_url( PWACOMMERCE_DOMAIN . '/admin/js/UI.Modules/PWAcommerce_Wookeys.min.js' ), [], PWACOMMERCE_VERSION );
	}

}


