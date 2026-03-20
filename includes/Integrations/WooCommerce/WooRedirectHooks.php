<?php
namespace Trefik\Integrations\WooCommerce;

use Trefik\Core\Config;
use Trefik\Core\Helper;

class WooRedirectHooks {
    
    public function register_hooks() {
        // Redirect on cancelled payment to checkout with order ID
        add_action('template_redirect', [$this, 'catch_cancelled_orders']);
    }

    // Redirect on cancelled payment to checkout with order ID
    public function catch_cancelled_orders() {
        if ( !is_wc_endpoint_url( 'order-pay' ) && !isset($_GET['key']) ) {
            return;
        }

        $order = Helper::get_order_from_request();

        // Check if order is valid and it's status is failed or cancelled
        if ( !$order || !$order->has_status( ['failed', 'cancelled', 'canceled'] ) )  {
            return;
        }

        // Payment failed, redirect to cart with message
        wp_safe_redirect( wc_get_checkout_url() . '?payment=failed&order=' . $order->id .'&key=' . $order->get_order_key() );
        
        exit;        
    }
}
