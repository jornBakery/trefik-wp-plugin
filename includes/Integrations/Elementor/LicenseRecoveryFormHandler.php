<?php
namespace Trefik\Integrations\Elementor;

use WC;
use Automattic\WooCommerce\Utilities\OrderUtil;
use Trefik\Core\Helper;

class LicenseRecoveryFormHandler {

    public function register_hooks() {
        add_action('elementor_pro/forms/new_record', [$this, 'handle_form_submission'], 10, 2);
    }

    public function handle_form_submission($record, $handler) {
        if ('license_recovery' !== $record->get_form_settings('form_name')) {
            return;
        }
    
        $fields = $record->get('fields');
        $email = sanitize_email($fields['email']['value']);
        $order_number = sanitize_text_field($fields['order_number']['value']);
    
        if(!Helper::validate_external_order_number($order_number)) {
            $handler->add_error_message(__('Je gebruikt de verkeerde bestelnummer indeling. Deze hoort er als volgt uit te zien: TI-12345-12345.', TREFIK_TEXT_DOMAIN));
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $transient_key_ip = 'recovery_attempts_' . md5($ip);
        $transient_key_success = 'recovery_success_' . md5($email . $order_number);
    
        // ⛔ IP tijdelijk geblokkeerd?
        if (get_transient($transient_key_ip) >= 5) {
            $handler->add_error_message(__('Te veel pogingen. Probeer het over 5 minuten opnieuw.', TREFIK_TEXT_DOMAIN));
            return;
        }
        
        // ✅ Zoek order in database met WooCommerce functies
        // $order_id = wc_get_order_id_by_order_key( $order_number );
        $order = $this->get_order_by_number($order_number);
        

        if ( $order && $order->get_billing_email() === $email ) {
            // Al 2 keer verstuurd? Stop.
            $success_count = (int)get_transient($transient_key_success);
            if ($success_count >= 2) {
                $handler->add_error_message(__('Deze licentie is al 2 keer verzonden.', TREFIK_TEXT_DOMAIN));
                return;
            }

            // ✅ Verstuur e-mail
            $license_key = $order->get_meta('_license_key', true ); // Vervang '_license_key' met de juiste meta key
            if ( $license_key ) {

                wp_mail(
                    $email,
                    'Je licentiecode',
                    'Beste klant, je licentiecode is: ' . esc_html( $license_key ),
                    ['Content-Type: text/html; charset=UTF-8']
                );

                // Optioneel: Voeg een notitie toe aan de order
                $order->add_order_note( 'Licentiecode opnieuw verzonden naar klant via formulier: ' . $license_key );

                // Tel poging
                set_transient($transient_key_success, $success_count + 1, 12 * HOUR_IN_SECONDS);    
            } 
            
            // Always display success messageto avoid user enumeration
            $this->send_success_message($handler);
        } else {
            // ❌ Geen match – tel mislukte poging
            $fail_count = (int)get_transient($transient_key_ip);
            set_transient($transient_key_ip, $fail_count + 1, 5 * MINUTE_IN_SECONDS);

            // $handler->add_error_message(__('Geen match gevonden voor dit e-mailadres en bestelnummer.', TREFIK_TEXT_DOMAIN));
            $this->send_success_message($handler);
        }
    }

    private function send_success_message($handler) {
        $handler->add_success_message(__('De licentiecode is verzonden naar je e-mailadres.', TREFIK_TEXT_DOMAIN));
    }

    private function get_order_by_number($order_number) {
        // Zoek de order met de opgegeven ordernummer
        // @TODO Improve this by validate format TI-12345-12345
        // @TODO Only use the numbers and search on meta key _alg_wc_custom_order_number
        // @TODO Check if it's possible to put an INDEX on the meta key _alg_wc_custom_order_number
        $query_args = array(
            'status' => array( 'completed' ),
            'limit' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key'     => '_alg_wc_full_custom_order_number',
                    'value'   => $order_number,
                    'compare' => '=',
                ),
                
            )
        );
        
        $orders = wc_get_orders( $query_args );

        if($orders) {
            return $orders[0];
        }

        return null;
    }
}
