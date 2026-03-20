<?php
namespace Trefik\Core;

use Trefik\Admin\AdminPage;
use Trefik\Admin\AdminHandler;
use Trefik\Frontend\FrontendHandler;
use Trefik\Integrations\WooCommerce\WooEmailHooks;
// use Trefik\Intergrations\Wixmo\Api\StudentCreate;
// use Trefik\Wixmo\Api\Base_Api;

class Plugin {
    public function run() {
        // add_action('init', [$this, 'load_textdomain']);
        add_action('init', [$this, 'register_ajax_handlers']);

        if (is_admin()) {
            (new AdminPage())->init();
            (new AdminHandler())->init();
        } else {
            (new FrontendHandler())->init();
        }
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            TREFIK_TEXT_DOMAIN,
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }
    
    public function register_ajax_handlers() {
        (new WooEmailHooks())->register_hooks();
        if (defined('DOING_AJAX') && DOING_AJAX) {
            (new \Trefik\Ajax\CartAjaxHandler())->register_hooks();
            (new \Trefik\Integrations\Elementor\LicenseRecoveryFormHandler())->register_hooks();
        }
    }
}
