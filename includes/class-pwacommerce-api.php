<?php
namespace PWAcommerce\Includes;

use Automattic\WooCommerce\Client;
use \PWAcommerce\Includes\Options;



class PWAcommerce_API
{
	protected function get_client() {

		$pwacommerce_options = new Options();

		return new Client(
			get_site_url(),
			$pwacommerce_options->get_setting('consumer_key'),
			$pwacommerce_options->get_setting('consumer_secret'),
			[
				'wp_api' => true,
				'version' => 'wc/v2',
			]
		);
	}

	public function register_woocommerce_routes() {
		register_rest_route( 'pwacommerce', '/categories', array(
			'methods' => 'GET',
			'callback' => array( $this, 'view_categories' )
		));

		register_rest_route( 'pwacommerce', '/product/(?P<id>\d+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'view_product' )
		));

		register_rest_route( 'pwacommerce', '/reviews/(?P<id>\d+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'view_reviews' )
		));

		register_rest_route( 'pwacommerce', '/products', array(
			'methods' => 'GET',
			'callback' => array( $this, 'view_products' ),
			'args' => array(
				'categId' => array(
					'required' => false,
					'type' => 'integer',
				),
			),
		));

		register_rest_route( 'pwacommerce', '/product-variations/(?P<id>\d+)', array(
			'methods' => 'GET',
			'callback' => array( $this, 'view_product_variations' ),
		));

		register_rest_route('pwacommerce', '/proceed-checkout', array(
			'methods' => 'POST',
			'callback' => array( $this, 'checkout_redirect' ),
		));

	}

	public function checkout_redirect ( \WP_REST_Request $request ) {


		$products = json_decode($request['items'], true);

		do_action( 'woocommerce_set_cart_cookies', TRUE );
		global $woocommerce;

		foreach( $products as $product ) {

			if  ( isset( $product['id'] ) && isset( $product['quantity'] ) && is_numeric( $product['id']) && is_numeric( $product['quantity'] ) )  {

				if ( isset( $product['variationId']) && is_numeric( $product['variationId'] ) ) {
					$woocommerce->cart->add_to_cart($product['id'], $product['quantity'], $product['variationId'] );
				} else {
					$woocommerce->cart->add_to_cart($product['id'], $product['quantity']);
				}

			}
		}


		wp_redirect($woocommerce->cart->get_checkout_url());
		exit();

	}

	public function view_categories( \WP_REST_Request $request ) {
		$woocommerce = $this->get_client();
		return $woocommerce->get( 'products/categories' );

	}

	public function view_reviews( \WP_REST_Request $request ) {
		$woocommerce = $this->get_client();
		$id = $request->get_param('id');
		return $woocommerce->get( "products/$id/reviews" );
	}

	public function view_product( \WP_REST_Request $request ){
		$woocommerce = $this->get_client();
		$id = $request->get_param('id');
		return $woocommerce->get( "products/$id" );
	}

	public function view_products( \WP_REST_Request $request ) {
		$woocommerce = $this->get_client();

		if ( isset( $request['categId'] ) )  {
			return $woocommerce->get('products', array('category' => $request['categId'] ) );
		}

		$featured = $woocommerce->get('products', array('featured' => true));

		if ( !empty( $featured ) ) {
			return $featured;
		}

		return $woocommerce->get('products', array('per_page' => 10, 'orderby' => 'date'));

	}

	public function view_product_variations( \WP_REST_Request $request ) {
		$woocommerce = $this->get_client();
		$id = $request->get_param('id');
		return $woocommerce->get("products/$id/variations", array('per_page' => 100));
	}
}

