<?php
namespace Trefik\Integrations\WooCommerce;

use WC;
use Trefik\Core\Helper;

class WooCartHooks {

    public function register_hooks() {
        /** @TODO: THIS HOOK DOESN'T WORK */
        // Check if product is in the cart
        add_filter('woocommerce_add_to_cart_validation', [$this, 'check_product_category_in_cart'], 10, 3);

        // Show notice and "Retry Payment" button in the cart
        add_filter('woocommerce_before_cart', [$this, 'offer_payment_retry']);
    }

    // Check if product is in the cart
    public function check_product_category_in_cart($passed, $product_id, $quantity) {
        // Skip validation if the product didn't pass previous validations
        if (!$passed) {
            return $passed;
        }
        
        // Get the product being added
        $product = wc_get_product($product_id);
        if (!$product) {
            return $passed;
        }
        
        // Get the product's categories
        $product_cats = [];
        
        // If it's a variation, get the parent product's categories
        if ($product->is_type('variation')) {
            $parent_id = $product->get_parent_id();
            $parent_product = wc_get_product($parent_id);
            if ($parent_product) {
                $product_cats = wc_get_product_cat_ids($parent_id);
            }
        } else {
            $product_cats = wc_get_product_cat_ids($product_id);
        }
        
        // If no categories, allow adding to cart
        if (empty($product_cats)) {
            return $passed;
        }
        
        // Check each item in the cart
        foreach (WC()->cart->get_cart() as $cart_item) {
            $cart_product = $cart_item['data'];
            $cart_product_id = $cart_product->get_id();
            
            // Skip if it's the same product
            if ($cart_product_id === $product_id) {
                continue;
            }
            
            // Get the cart item's categories
            $cart_product_cats = [];
            
            // If it's a variation, get the parent product's categories
            if ($cart_product->is_type('variation')) {
                $parent_id = $cart_product->get_parent_id();
                $cart_product_cats = wc_get_product_cat_ids($parent_id);
            } else {
                $cart_product_cats = wc_get_product_cat_ids($cart_product_id);
            }
            
            // Check if there's any category overlap
            $common_cats = array_intersect($product_cats, $cart_product_cats);
            
            if (!empty($common_cats)) {
                // Get the category name for the message
                $cat_id = reset($common_cats);
                $category = get_term_by('id', $cat_id, 'product_cat');
                $cat_name = $category ? $category->name : 'dezelfde categorie';
                
                $message = sprintf(
                    __('Je hebt al een product uit de categorie "%s" in je winkelwagen. Wil je dit product toch toevoegen?', TREFIK_TEXT_DOMAIN),
                    $cat_name
                );
                
                // For AJAX requests
                if (wp_doing_ajax()) {
                    wp_send_json([
                        'success' => false,
                        'data' => [
                            'message' => $message,
                            'category_warning' => true,
                            'product_id' => $product_id,
                            'quantity' => $quantity
                        ]
                    ]);
                    exit;
                } else {
                    // For non-AJAX requests, show a notice but still allow adding to cart
                    wc_add_notice($message, 'notice');
                }
                
                // We still return true to allow adding to cart, but the AJAX handler will show a confirmation dialog
                return true;
            }
        }
        
        return $passed;
    }

    // Show notice and "Retry Payment" button in the cart
    public function offer_payment_retry() {
        if ( !isset($_GET['payment']) || $_GET['payment'] !== 'failed' || !isset($_GET['order']) ) {
            return;
        }
        $order = Helper::get_order_from_request();

        if ( !$order || !$order->has_status( ['failed', 'pending', 'cancelled'] ) ) {
            return;
        }
        $pay_url = $order->get_checkout_payment_url();

        wc_print_notice(__('Je betaling is mislukt. Je kunt hieronder opnieuw proberen te betalen.', TREFIK_TEXT_DOMAIN), 'error');

        echo '<p><a href="' . esc_url($pay_url) . '" class="button alt wc-forward" style="margin-top: 10px;">'.esc_html__('Opnieuw Betalen', TREFIK_TEXT_DOMAIN).'</a></p>';
    }
}