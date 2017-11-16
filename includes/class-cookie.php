<?php
namespace PWAcommerce\Includes;


/**
 * Overall Cookie Management class
 *
 * Instantiates all the cookies and offers a number of utility methods to work with the cookies
 */
class Cookie
{


	public static $prefix = 'pwacommerce_';

	/**
	 *
	 * Gets cookie value
	 *
	 * @param $cookie_name
	 * @return null
	 *
	 */
	public function get_cookie( $cookie_name )
	{

		if ( isset( $_COOKIE[self::$prefix.$cookie_name] ) ) {
			return $_COOKIE[self::$prefix.$cookie_name];
		}

		return null;
	}

	/**
	 * Sets cookie value
	 *
	 * @param $cookie_name
	 * @param $cookie_value
	 * @param $duration - After how many seconds the cookie will expire. Default value is 2 days
	 */
	public function set_cookie( $cookie_name, $cookie_value, $duration = 172800 )
	{
		setcookie( self::$prefix.$cookie_name, $cookie_value, time() + $duration, '/' );
	}

}
