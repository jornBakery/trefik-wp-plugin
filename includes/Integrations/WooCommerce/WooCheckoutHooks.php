<?php
namespace Trefik\Integrations\WooCommerce;

class WooCheckoutHooks {
    public function register_hooks() {
        add_filter('woocommerce_checkout_fields', [$this, 'customize_checkout_fields']);
        add_action('woocommerce_checkout_process', [$this, 'validate_email_confirm']);

    }

    public function customize_checkout_fields( $fields ) {
        unset($fields['billing']['billing_address_1']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['billing_country']); 
        $fields['billing']['billing_email'] = array(
           'label' => __('E-mailadres', TREFIK_TEXT_DOMAIN),
           'placeholder' => __('Je e-mailadres', TREFIK_TEXT_DOMAIN),
           'required' => true,
           'class' => array( 'form-row-first', "wcf-column-50" ),
           'clear' => true,
           'priority' => 20,
           'enabled' => true,
           'section' => 'woocommerce-billing-fields-custom'
        );
        $fields['billing']['billing_email_confirm'] = array(
           'label' => __('Bevestig e-mailadres', TREFIK_TEXT_DOMAIN),
           'placeholder' => __('Bevestig je e-mailadres', TREFIK_TEXT_DOMAIN),
           'required' => true,
           'class' => array( 'form-row-last', "wcf-column-50" ),
           'clear' => true,
           'priority' => 21,
           'enabled' => true,
           'section' => 'woocommerce-billing-fields-custom'
        );
        return $fields;
    }

    function validate_email_confirm() { 
        $email1 = $_POST['billing_email'];
        $email2 = $_POST['billing_email_confirm'];
        if ( $email2 !== $email1 ) {
            wc_add_notice(__('E-mailadres en bevestiging komen niet overeen.', TREFIK_TEXT_DOMAIN), 'error');
        }
    }
}
