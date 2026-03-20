<?php
namespace Trefik\Shortcodes;

class CartProductListShortcode {

    // Handle Cart Prodcut List Shortcode
    public function render($atts = [], $content = null) {
        if ( !WC()->cart || WC()->cart->is_empty() ) {
            return '<p>'.esc_html__('Je winkelwagen is leeg.', TREFIK_TEXT_DOMAIN).'</p>';
        }

        ob_start();

        $sorted_cart = $this->sort_cart_items_by_product_id();
    
        foreach ($sorted_cart as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
        }

        echo '<div class="custom-cart-product-list">';
    
        foreach ( $sorted_cart as $cart_item_key => $cart_item ) {
            $product   = $cart_item['data'];
            $product_id = $cart_item['product_id'];
            
            if ( $product && $product->exists() ) {
                $product_name = $product->get_name();
                $product_link = $product->is_visible() ? $product->get_permalink() : '';
                $product_price = wc_price($product->get_price());
                $quantity = $cart_item['quantity'];
                $thumbnail = $product->get_image('thumbnail');
    
                echo '<div class="cart-item">';
                echo $thumbnail;
                echo '<div class="cart-item-details">';
                echo '<div class="remove-cart-item" data-cart-key="' . esc_attr($cart_item_key) . '"><span class="dashicons dashicons-no-alt"></span></div>';
                echo $product_link ? '<a href="' . esc_url( $product_link ) . '">' . esc_html( $product_name ) . '</a>' : esc_html( $product_name );
    
                if (!$product->is_type('variation')) {
                    echo '<span>'.esc_html__('Prijs', TREFIK_TEXT_DOMAIN).': ' . $product_price . '</span>';
                    echo '<span class="qty-display">'.esc_html__('Aantal', TREFIK_TEXT_DOMAIN).': ' . esc_html( $quantity ) . '</span>';
                    echo '</div>';
                    echo '</div>';
                    continue; // Skip the rest for non-variation products
                }
            
                $parent_product = wc_get_product($product->get_parent_id());
                $attributes = $parent_product->get_attributes();
                $variation_attributes = $product->get_variation_attributes();
            
                echo '<span>'.esc_html__('Prijs', TREFIK_TEXT_DOMAIN).': ' . $product_price . '</span>';
                echo '<span class="qty-display">'.esc_html__('Aantal', TREFIK_TEXT_DOMAIN).': ' . esc_html( $quantity ) . '</span>';
                echo '<div class="variation-switcher-form" data-cart-key="' . esc_attr($cart_item_key) . '" data-product-id="' . esc_attr($parent_product->get_id()) . '">';
            
                foreach ($attributes as $attribute_name => $attribute_obj) {
                    if (!$attribute_obj->get_variation()) continue;
            
                    $terms = $attribute_obj->get_terms();
                    $options = $attribute_obj->get_options();
                    $key = 'attribute_' . wc_sanitize_taxonomy_name($attribute_name);
                    $selected = $variation_attributes[$key] ?? '';
                    
                    echo '<div class="product-variaton-btn-group btn-group" data-attribute="' . $attribute_name . '">';
                    foreach($options as $option) {
                        echo '<button data-value="' . $option . '" class="' . ($selected == $option ? 'active' : '') . '"'.($selected == $option ? 'disabled' : '').'>' . $option . '</button>';
                    }
                    echo '</div>';
                }
            
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
    
        echo '</div>';
    
        return ob_get_clean();
    }

    // Helper function to sort cart items by product ID
    private function sort_cart_items_by_product_id() {
        // Haal de cart items op
        $cart_items = WC()->cart->get_cart();
    
        // Sorteer de items
        uasort($cart_items, function($a, $b) {
            $product_a = $a['data'];
            $product_b = $b['data'];
    
            // Gebruik de parent product ID als hoofd-ID als het een variatie is
            $id_a = $product_a->is_type('variation') ? $product_a->get_parent_id() : $product_a->get_id();
            $id_b = $product_b->is_type('variation') ? $product_b->get_parent_id() : $product_b->get_id();
    
            // Vergelijk op ID
            return $id_a <=> $id_b;
        });
    
        return $cart_items;
    }
}