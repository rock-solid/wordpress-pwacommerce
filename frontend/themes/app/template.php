<?php
use  PWAcommerce\Frontend\Frontend_Init;

global $woocommerce;

$api_url = get_site_url( null, '/wp-json/pwacommerce/' );

$theme_path = plugins_url() . '/' . PWACOMMERCE_DOMAIN . '/frontend/themes/app/';

$config = [
	'API_CATEGORIES_URL' => $api_url . 'categories/',
	'API_PRODUCTS_URL' => $api_url . 'products/',
	'API_PRODUCT_URL' => $api_url . 'product/',
	'API_REVIEWS_URL' => $api_url . 'reviews/',
	'API_VARIATIONS_URL' => $api_url . 'product-variations/',
	'API_CHECKOUT_URL' => $api_url . 'proceed-checkout/',
	'CURRENCY' => get_woocommerce_currency_symbol(),
];

$config_json = wp_json_encode($config);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="theme-color" content="#a333c8">
    <link rel="manifest" href="<?php echo  $api_url . 'export-manifest/' ?>">
    <link rel="shortcut icon" href="/favicon.ico">
    <title>pwa-theme-woocommerce</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.12/semantic.min.css">
    <script type="text/javascript" pagespeed_no_defer="">
        window.appticles = {
            config: <?php echo $config_json ?>
        }
    </script>
    <link href="<?php echo $theme_path;?>css/app.css" rel="stylesheet">
</head>

<body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root" style="height:100%"></div>
    <script type="text/javascript" src="<?php echo $theme_path;?>js/app.js"></script>
</body>

</html>
