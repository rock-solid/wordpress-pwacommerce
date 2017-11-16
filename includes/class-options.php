<?php
namespace PWAcommerce\Includes;

/**
 * Overall Option Management class.
 * Instantiates all the options and offers a number of utility methods to work with the options.
 */
class Options {


	public $prefix = 'pwacommerce_';

	public $options = [
		'icon' => '',
		'analytics_id' => '',
		'joined_subscriber_list' => 0,
		'service_worker_installed' => 0,
		'consumer_key' => '',
		'consumer_secret' => '',
	];


	/**
	 * The get_setting method is used to read an option value (or options) from the database.
	 *
	 * If the $option param is an array, the method will return an array with the values,
	 * otherwise it will return only the requested option value.
	 *
	 * @param $option - array / string.
	 * @return mixed.
	 */
	public function get_setting( $option ) {

		// If the passed param is an array, return an array with all the settings.
		if ( is_array( $option ) ) {

			$settings = [];

			foreach ( $option as $option_name => $option_value ) {

				if ( get_option( $this->prefix . $option_name ) == '' ) {

					$settings[ $option_name ] = $this->options[ $option_name ];

				} else {

					$settings[ $option_name ] = get_option( $this->prefix . $option_name );
				}
			}

			return $settings;

		} elseif ( is_string( $option ) ) { // If option is a string, return the value of the option.

			// Check if the option is added in the db.
			if ( get_option( $this->prefix . $option ) === false ) {

				$setting = $this->options[ $option ];

			} else {

				$setting = get_option( $this->prefix . $option );
			}

			return $setting;
		}

	}


	/**
	 * The save_settings method is used to save an option value (or options) in the database.
	 *
	 * @param $option - array / string.
	 * @param $option_value - optional, mandatory only when $option is a string.
	 *
	 * @return bool.
	 */
	public function save_settings( $option, $option_value = '' ) {

		if ( current_user_can( 'manage_options' ) ) {

			if ( is_array( $option ) && ! empty( $option ) ) {

				// Set option not saved variable.
				$option_not_saved = false;

				foreach ( $option as $option_name => $option_value ) {

					if ( array_key_exists( $option_name, $this->options ) ) {

						add_option( $this->prefix . $option_name, $option_value );

					} else {

						$option_not_saved = true; // There is at least one option not in the default list.

					}
				}

				if ( ! $option_not_saved ) {

					return true;

				} else {

					return false; // There was an error.

				}

			} elseif ( is_string( $option ) && '' != $option_value ) {

				if ( array_key_exists( $option, $this->options ) ) {

					return add_option( $this->prefix . $option, $option_value );

				}
			} // End if().
		} // End if().

		return false;

	}


	/**
	 *
	 * The update_settings method is used to update the setting/settings of the plugin in options table in the database.
	 *
	 * @param $option - array / string.
	 * @param $option_value - optional, mandatory only when $option is a string.
	 *
	 * @return bool.
	 */
	public function update_settings( $option, $option_value = null ) {

		if ( current_user_can( 'manage_options' ) ) {

			if ( is_array( $option ) && ! empty( $option ) ) {

				$option_not_updated = false;

				foreach ( $option as $option_name => $option_value ) {

					// Set option not saved variable.
					if ( array_key_exists( $option_name, $this->options ) ) {

						update_option( $this->prefix . $option_name, $option_value );

					} else {

						$option_not_updated = true; // There is at least one option not in the default list.

					}
				}

				if ( ! $option_not_updated ) {

					return true;

				} else {

					return false; // There was an error.

				}

			} elseif ( is_string( $option ) && null !== $option_value ) {

				if ( array_key_exists( $option, $this->options ) ) {

					return update_option( $this->prefix . $option, $option_value );

				}
			} // End if().
		} // End if().

		return false;
	}


	/**
	 * The delete_settings method is used to delete the setting/settings of the plugin from the options table in the database.
	 *
	 * @param $option - array / string.
	 *
	 * @return bool.
	 */
	public function delete_settings( $option ) {

		if ( current_user_can( 'manage_options' ) ) {

			if ( is_array( $option ) && ! empty( $option ) ) {

				foreach ( $option as $option_name => $option_value ) {

					if ( array_key_exists( $option_name, $this->options ) ) {

						delete_option( $this->prefix . $option_name );
					}
				}

				return true;

			} elseif ( is_string( $option ) ) {

				if ( array_key_exists( $option, $this->options ) || $option === 'customize' ) {

					return delete_option( $this->prefix . $option );

				}
			}
		}
	}
}
