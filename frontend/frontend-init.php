<?php
namespace PWAcommerce\Frontend;

use \PWAcommerce\Includes\Cookie;
use \PWAcommerce\Frontend\Detect;
use \PWAcommerce\Includes\Options;

/**
 *
 * Frontend_Init
 *
 * Main class for managing frontend apps
 *
 */
class Frontend_Init {


	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->check_load();
	}


	/**
	 *
	 * Method that checks if we can load the mobile web application theme.
	 *
	 */
	public function check_load()
	{

		// Assume the app will not be loaded
		$load_app = false;

		// Check if the load app cookie is 1 or the user came from a mobile device
		$cookie_manager = new Cookie();
		$load_app_cookie = $cookie_manager->get_cookie( 'load_app' );

		// If the load_app cookie is not set, verify the device
		if ( $load_app_cookie === null ) {
			$detect = new Detect();
			$load_app = $detect->detect_device();

		} elseif ( $load_app_cookie == 1 ) {

			// The cookie was already set for the device, so we can load the app
			$load_app = true;
		}

		// We have a mobile device and the app is visible, so we can load the app
		if ( $load_app ) {
			$this->load_app();
		}

	}



	/**
	 *
	 * Method that loads the mobile web application theme.
	 *
	 */
	public function load_app()
	{
		add_filter( 'stylesheet', [ $this, 'app_theme' ], 11 );
		add_filter( 'template', [ $this, 'app_theme' ], 11);

		add_filter( 'theme_root', [ $this, 'app_theme_root' ], 11 );
		add_filter( 'theme_root_uri', [ $this, 'app_theme_root' ], 11 );
	}


	/**
	 * Return the theme name
	 */
	public function app_theme($desktop_theme)
	{

		if ( $this->is_checkout_url() ) {
			return $desktop_theme;
		}

		return 'app';
	}

	public function is_checkout_url()
	{
		$site_url = get_site_url();
		$checkout_url = wc_get_checkout_url();
		$request_uri = $_SERVER['REQUEST_URI'];

		$checkout_uri = str_replace($site_url, '', $checkout_url);
		return strpos( $request_uri, $checkout_uri );
	}


	/**
	 * Return path to the mobile themes folder
	 */
	public function app_theme_root($destkop_theme_root)
	{

		if ( $this->is_checkout_url() ) {
			return $destkop_theme_root;
		}

		return PWACOMMERCE_PLUGIN_PATH . 'frontend/themes';
	}




	/**
	 * Returns an array with all the application's frontend settings
	 *
	 * @return array
	 */
	public function load_app_settings()
	{

		$options = new Options();

		// load basic settings
		$frontend_options = [
			'analytics_id',
			'service_worker_installed',
		];

		$settings = [];

		foreach ( $frontend_options as $option_name ){

			$settings[$option_name] = $options->get_setting( $option_name );
		}

		$file_path = $options->get_setting( 'icon' );

		if ( $file_path == '' || !file_exists( PWACOMMERCE_FILES_UPLOADS_DIR . $file_path ) ) {
			$settings['icon'] = '';

		} else {

			$settings['icon'] = PWACOMMERCE_FILES_UPLOADS_URL . $file_path;
		}

		return $settings;
	}
}

