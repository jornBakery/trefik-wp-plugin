<?php
namespace Trefik\Shortcodes;

class ShortcodeManager {
    public function register_hooks() {
        add_shortcode('trefik_cart_product_list', [new CartProductListShortcode() , 'render'] );
        // add more shortcodes here
    }
}