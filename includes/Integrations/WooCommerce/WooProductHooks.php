<?php
namespace Trefik\Integrations\WooCommerce;

use Trefik\Core\Helper;

class WooProductHooks {
    public function register_hooks() {
        add_action('woocommerce_product_after_variable_attributes', [$this, 'render_custom_variation_fields'], 10, 3);
        add_action('woocommerce_save_product_variation', [$this, 'save_custom_variation_fields'], 10, 2); 
        add_filter('woocommerce_available_variation', [$this, 'add_custom_field_to_variation_data']); 
    }

    /**
     * 1. Toon het veld in de 'Edit Variation' sectie
     */
    public function render_custom_variation_fields( $loop, $variation_data, $variation ) {
        echo '<div class="variation-custom-fields">';
    
        // Custom Text Field
        woocommerce_wp_text_input( array(
            'id'            => '_extended_days[' . $loop . ']',
            'label'         => __( 'Extended Days', 'woocommerce' ),
            'placeholder'   => __( 'Aantal dagen om te verlengen', 'woocommerce' ),
            'desc_tip'      => true,
            'description'   => __( 'Voer hier het aantal dagen in, dat verlengt moet worden', 'woocommerce' ),
            'value'         => get_post_meta( $variation->ID, '_extended_days', true ),
        ) );

        echo '</div>';
    }

    /**
     * 2. Sla de waarde van het veld op wanneer het product wordt bijgewerkt
     */
    public function save_custom_variation_fields( $variation_id, $index) {
        if ( isset( $_POST['_extended_days'][$index] ) ) {
            $custom_value = sanitize_text_field( $_POST['_extended_days'][$index] );
            update_post_meta( $variation_id, '_extended_days', $custom_value );
        }
    }

    /**
     * 3. Maak het veld beschikbaar in de variatie JSON (voor frontend JS gebruik)
     */
    public function add_custom_field_to_variation_data( $variation_data ) {
        // Haal de meta data op voor de huidige variatie ID
        $variation_data['extended_days'] = get_post_meta( $variation_data['variation_id'], '_extended_days', true );
        
        return $variation_data;
    }
}
