<?php

namespace PWAcommerce\Core;

use \PWAcommerce\Includes\Options;

/**
 * Main class for the PWAcommerce plugin. This class handles:
 *
 * - activation / deactivation of the plugin
 */
class PWAcommerce {


	/**
	 *
	 * The activate() method is called on the activation of the plugin.
	 */
	public function activate() {

		$pwacommerce_options = new Options();

		// Saves the default settings to the database, if the plugin was previously activated,
		// it does not change the old settings.
		$pwacommerce_options->save_settings( $pwacommerce_options->options );

	}

}
