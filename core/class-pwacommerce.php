<?php

namespace PWAcommerce\Core;

use \PWAcommerce\Includes\Options;
use \PWAcommerce\Includes\PWAcommerce_Uploads;

/**
 * Main class for the PWAcommerce plugin. This class handles:
 *
 * - activation / deactivation of the plugin
 */
class PWAcommerce {

	public function __construct()
	{
		// create uploads folder and define constants
		if ( !defined( 'PWACOMMERCE_FILES_UPLOADS_DIR' ) && !defined( 'PWACOMMERCE_FILES_UPLOADS_URL' ) ){
			$PWAcommerce_Uploads = new PWAcommerce_Uploads();
			$PWAcommerce_Uploads->define_uploads_dir();
		}
	}

	/**
	 *
	 * The activate() method is called on the activation of the plugin.
	 */
	public function activate() {

		$pwacommerce_options = new Options();

		// Saves the default settings to the database, if the plugin was previously activated,
		// it does not change the old settings.
		$pwacommerce_options->save_settings( $pwacommerce_options->options );

		$PWAcommerce_Uploads = new PWAcommerce_Uploads();
		$PWAcommerce_Uploads->create_uploads_dir();

	}

}
