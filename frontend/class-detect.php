<?php
namespace PWAcommerce\Frontend;


use \PWAcommerce\Includes\Cookie;
use Mobile_Detect;

/**
 *
 * Main class for detecting the user's device and browser.
 *
 */
class Detect {


	/**
	 *
	 * Checks the browser's user agent and return true if the device is a supported smartphone
	 *
	 */
	public function detect_device()
	{

		$is_supported_device = 0;
		$is_supported_os = 0;
		$is_supported_browser = 0;

		$detect = new Mobile_Detect();

		if ( $detect->isMobile() ){
			$is_supported_device = 1;
		}

		if ( $detect->isiOS() || $detect->isAndroidOS() ) {
			$is_supported_os = 1;
		}

		if ( $detect->is( 'WebKit' ) ) {
			$is_supported_browser = 1;
		}

		// set load app variable
		$load_app = false;

		if ( $is_supported_device && $is_supported_os && $is_supported_browser ) {
			$load_app = true;
		}

		// set load app cookie
		$this->set_load_app_cookie( intval( $load_app ) );

		return $load_app;
	}


	/**
	 *
	 * Sets the set_load_app_cookie
	 *
	 */
	protected function set_load_app_cookie( $value )
	{
		$cookie_manager = new Cookie();
		$cookie_manager->set_cookie( 'load_app', $value );
	}
}

