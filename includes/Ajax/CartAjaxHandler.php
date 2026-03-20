<?php
namespace Trefik\Ajax;

use WC;
use WC_Data_Store;
use Trefik\Shortcodes\CartProductListShortcode;

class CartAjaxHandler {

    public function register_hooks() {
        // Handle custom add to cart with category check override
        add_action('wp_ajax_add_to_cart_override', [$this, 'handle_add_to_cart_override']);
        add_action('wp_ajax_nopriv_add_to_cart_override', [$this, 'handle_add_to_cart_override']);

        // Handle switch cart variation
        add_action('wp_ajax_switch_cart_variation', [$this, 'handle_switch_cart_variation']);
        add_action('wp_ajax_nopriv_switch_cart_variation', [$this, 'handle_switch_cart_variation']);
        
        // AJAX handler for refreshing the cart product list
        add_action('wp_ajax_refresh_cart_product_list', [$this, 'refresh_cart_product_list_ajax']);
        add_action('wp_ajax_nopriv_refresh_cart_product_list', [$this, 'refresh_cart_product_list_ajax']);
        
        // Handle remove item from cart
        add_action('wp_ajax_remove_cart_item', [$this, 'handle_remove_cart_item']);
        add_action('wp_ajax_nopriv_remove_cart_item', [$this, 'handle_remove_cart_item']);
    }

    // Handle custom add to cart with category check override
    public function handle_add_to_cart_override() {
        check_ajax_referer('switch_variation_nonce', 'nonce');
        
        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount(sanitize_text_field($_POST['quantity']));
        $variation_id = empty($_POST['variation_id']) ? 0 : absint($_POST['variation_id']);
        $variations = empty($_POST['variations']) ? array() : (array) $_POST['variations'];
        $override_category_check = isset($_POST['override_category_check']) && $_POST['override_category_check'] === 'true';
        
        // Standardize variation data
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        
        // If we're overriding the category check, we'll bypass it
        if (!$passed_validation && !$override_category_check) {
            wp_send_json_error(__('Validatie mislukt', TREFIK_TEXT_DOMAIN));
            return;
        }
        
        // Format variation data
        $variation_data = array();
        foreach ($variations as $key => $value) {
            $variation_data[sanitize_text_field($key)] = sanitize_text_field($value);
        }
        
        // Add to cart
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation_data);
        
        if ($cart_item_key) {
            wp_send_json_success([
                'message' => __('Product toegevoegd aan winkelwagen.', TREFIK_TEXT_DOMAIN)
            ]);
        } else {
            wp_send_json_error(__('Fout bij toevoegen aan winkelwagen.', TREFIK_TEXT_DOMAIN));
        }
    }

    // Handle switch cart variation
    public function handle_switch_cart_variation() {
        check_ajax_referer('switch_variation_nonce', 'nonce');
    
        $cart_item_key = sanitize_text_field($_POST['cart_item_key'] ?? '');
        $product_id    = absint($_POST['product_id'] ?? 0);
        $attributes_in = $_POST['attributes'] ?? [];
    
        if (!$cart_item_key || !$product_id || empty($attributes_in)) {
            wp_send_json_error(__('Ongeldige gegevens ontvangen.', TREFIK_TEXT_DOMAIN));
        }
    
        $attributes = [];
        foreach ($attributes_in as $key => $value) {
            $key_clean = wc_sanitize_taxonomy_name(str_replace('attribute_', '', $key));
            $attributes['attribute_' . $key_clean] = sanitize_text_field($value);
        }
    
        $variation_id = $this->find_matching_variation($product_id, $attributes);
    
        if (!$variation_id) {
            wp_send_json_error(__('Geen geldige variatie gevonden.', TREFIK_TEXT_DOMAIN));
        }
    
        $cart = WC()->cart->get_cart();
    
        if (!isset($cart[$cart_item_key])) {
            wp_send_json_error(__('Cart item niet gevonden.', TREFIK_TEXT_DOMAIN));
        }
    
        $original_item = $cart[$cart_item_key];
        $quantity = $original_item['quantity'];
    
        $new_key = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $attributes);
    
        if ($new_key) {
            WC()->cart->remove_cart_item($cart_item_key);
            wp_send_json_success([
                'message' => __('Variatie aangepast.', TREFIK_TEXT_DOMAIN), 
                'html' => (new CartProductListShortcode())->render(),
            ]);
        } else {
            wp_send_json_error(__('Fout bij toevoegen nieuwe variatie.', TREFIK_TEXT_DOMAIN));
        }
    }

    // !!!!! @TODO add nonce check !!!!!!
    // AJAX handler for refreshing the cart product list
    public function refresh_cart_product_list_ajax() {
        // Voer de shortcode opnieuw uit
        $shortcode_output = do_shortcode('[trefik_cart_product_list]');
    
        wp_send_json_success([
            'html' => $shortcode_output,
        ]);
    }    

    // Handle remove item from cart
    public function handle_remove_cart_item() {
        
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'switch_variation_nonce')) {
            wp_send_json_error(__('Beveiligingscontrole mislukt', TREFIK_TEXT_DOMAIN));
        }

        if (!isset($_POST['cart_item_key'])) {
            wp_send_json_error(__('Geen item opgegeven om te verwijderen', TREFIK_TEXT_DOMAIN));
        }

        $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
        
        // Remove the item from the cart
        WC()->cart->remove_cart_item($cart_item_key);

        // Return updated cart product list HTML
        $html = (new CartProductListShortcode())->render();
        wp_send_json_success([
            'html' => $html,
            'is_cart_empty' => WC()->cart->is_empty(),
        ]);
    }

    // Helper function to find matching variation
    private function find_matching_variation($product_id, $attributes) {
        $product = wc_get_product($product_id);
        if (!$product || !$product->is_type('variable')) return false;
    
        $data_store = WC_Data_Store::load('product');
        return $data_store->find_matching_product_variation($product, $attributes);
    }
}
