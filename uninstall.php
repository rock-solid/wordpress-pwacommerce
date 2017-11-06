<?php
namespace PWAcommerce;

if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit ();
}

require_once( 'vendor/autoload.php' );

$pwacommerce_options = new Includes\Options();

$pwacommerce_options->delete_settings($pwacommerce_options->options);

?>
