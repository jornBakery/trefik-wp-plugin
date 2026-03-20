<?php
namespace Trefik\Frontend;

use Trefik\Core\Config;
use Trefik\Shortcodes\ShortcodeManager;

use Trefik\Integrations\WooCommerce\WooCheckoutHooks;
use Trefik\Integrations\WooCommerce\WooCartHooks;
use Trefik\Integrations\WooCommerce\WooOrderHooks;
use Trefik\Integrations\WooCommerce\WooRedirectHooks;
use Trefik\Ajax\CartAjaxHandler;


class FrontendHandler {
    public function init() {
        // Initialize dependencies after WooCommerce is loaded
        add_action( 'woocommerce_loaded', [$this, 'init_dependencies'] );
    }

    public function init_dependencies() {
        // Enqueue assets
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);

        // Shortcodes
        (new ShortcodeManager())->register_hooks();

        // WooCommerce Hooks
        
        (new WooCheckoutHooks())->register_hooks();
        (new WooCartHooks())->register_hooks();
        (new WooOrderHooks())->register_hooks();
        (new WooRedirectHooks())->register_hooks();

        
    }

    public function enqueue_assets() {

        if (is_checkout() || is_cart()) {
            wp_enqueue_style(
                'trefik-frontend-style',
                Config::url() . 'assets/css/frontend.css',
                [],
                Config::version()
            );

            wp_enqueue_script(
                'trefik-frontend-script',
                Config::url() . 'assets/js/frontend.js',
                ['jquery'],
                Config::version(),
                true
            );

            wp_localize_script('trefik-frontend-script', 'TREFIK', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('switch_variation_nonce'),
                'cart_strings' => [
                    'addToCartError' => __( 'Er is iets misgegaan bij het toevoegen van het product.', TREFIK_TEXT_DOMAIN ),
                    'removeFromCartConfirmation' => __( 'Weet je zeker dat je dit item wilt verwijderen?', TREFIK_TEXT_DOMAIN ),
                    'removeFromCartError' => __( 'Er is iets misgegaan bij het verwijderen van het item.', TREFIK_TEXT_DOMAIN ),
                    'genericError' => __( 'Er is iets misgegaan.', TREFIK_TEXT_DOMAIN ),
                ],
            ]);
        }
    }
}