<?php
namespace Trefik\Admin;

use Trefik\Integrations\WooCommerce\WooOrderHooks;
use Trefik\Integrations\WooCommerce\WooProductHooks;

use Trefik\Integrations\Wixmo\Api\StudentApi;

class AdminHandler {
    public function init() {
        // Initialize dependencies after WooCommerce is loaded
        add_action( 'woocommerce_loaded', [$this, 'init_dependencies'] );
    }

    public function init_dependencies() {
        // Enqueue assets

        // Shortcodes

        // WooCommerce Hooks
        (new WooOrderHooks())->register_hooks();
        (new WooProductHooks())->register_hooks();

        (new StudentApi())->refresh_access_token();

    }
}