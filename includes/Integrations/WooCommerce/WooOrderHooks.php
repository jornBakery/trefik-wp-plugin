<?php
namespace Trefik\Integrations\WooCommerce;

use Trefik\Core\Helper;
use Trefik\Integrations\Wixmo\Api\LicenseApi;
use Trefik\Integrations\Wixmo\Api\StudentApi;


class WooOrderHooks {
    public function register_hooks() {
        // Only empty the cart after successful payment
        add_action('woocommerce_payment_complete', [$this, 'handle_payment_complete']);
        add_action('woocommerce_new_order', [$this, 'mark_admin_order'], 20); 

        add_filter('woocommerce_valid_order_statuses_for_payment', [$this, 'custom_valid_statuses'], 10, 2);
        
        // Validate order statuses for payment so that customers can retry payment
        add_filter('woocommerce_valid_order_statuses_for_payment', [$this, 'valid_order_statuses_for_payment'], 10, 2);
        
        // Customize order number
        add_filter('alg_wc_custom_order_numbers', [$this, 'customize_order_numbers'], 1, 3);

        // Prevent the cart from being emptied on failed or cancelled orders
        remove_action( 'woocommerce_order_status_failed', 'wc_empty_cart' );
        remove_action( 'woocommerce_order_status_cancelled', 'wc_empty_cart' );
        remove_action( 'woocommerce_order_status_pending', 'wc_empty_cart' );
    }

    // Only empty the cart after successful payment
    public function handle_payment_complete( $order_id ) {
        if ( ! $order_id ) return;
        if ( WC()->cart) WC()->cart->empty_cart();

        $order = wc_get_order( $order_id );

        if ( ! $order ) {
            // Log een error als de order niet gevonden is
            error_log( 'Trefik: Order not found with ID: ' . $order_id );
            return;
        }
        Helper::write_log("WooOrderHooks - Line 38");

        $studentApi = new StudentApi();


        foreach($order->get_items() as $item) {
            // if(!$item->is_type('line_item')) {
            //     continue;
            // }
            $strTime = $item->get_meta('tijd');
            $licenseId = get_field( 'license_id', $item->get_product_id() );
            $studyGroupId = get_field( 'study_group_id', $item->get_product_id() );
            $extended_days = $this->get_extended_days( $item->get_variation_id() );
            Helper::write_log( [ $item->get_product_id(), $licenseId, $studyGroupId ] );
            Helper::write_log( [ 'strTime', $strTime ] );
            Helper::write_log( [ 'Extended Days', $extended_days ] );

            $userId = $studentApi->create([
                'userName'  => $order->get_billing_email(),
                'firstName' => $order->get_billing_first_name(),
                'lastName'  => $order->get_billing_last_name(),
                'email'     => $order->get_billing_email(),
                'studyGroups' => [
                    $studyGroupId
                ],
                "hasToVerifyIdentity" => false,
                "hasLanguageSupport" => true,
                "type" => "STUDENT",
            ]);
            
            if ( ! $userId ) {
                Helper::write_log( [ 'userId niet gevonden vanuit wixmo' ] );
                $order->add_order_note( 'userId niet gevonden vanuit wixmo' );
            } else {
                $order->add_meta_data( '_wixmo_user_id', $userId );
            }

            // Wixmo: verlengen via license-endpoint. Response wordt niet in WooCommerce als "licentie" verwerkt.
            if ( $userId && $extended_days > 0 && $licenseId ) {
                $licenseApi  = new LicenseApi();
                $licenseCall = $licenseApi->extend_validity_days( [
                    'firstName'     => $order->get_billing_first_name(),
                    'lastName'      => $order->get_billing_last_name(),
                    'email'         => $order->get_billing_email(),
                    'licenseId'     => $licenseId,
                    'validityDays'  => $extended_days,
                ] );
                Helper::write_log( [ 'wixmo_extend_validity', $licenseCall ] );
            }
        }

        $order->update_status( 'completed' );

    }

    private function get_extended_days( $variation_id ) {
        if ( ! $variation_id ) {
            return 0;
        }
        $variation = wc_get_product( $variation_id );
        if ( ! $variation || ! is_a( $variation, 'WC_Product_Variation' ) ) {
            return 0;
        }
        $extended_days = $variation->get_meta( '_extended_days', true );
        return is_numeric( $extended_days ) ? (int) $extended_days : 0;
    }

    // Allow payment for failed, pending, and cancelled orders
    public function custom_valid_statuses($statuses, $order) {
        if ( $order->has_status( ['failed', 'pending', 'cancelled'] ) ) {
            $statuses[] = $order->get_status();
        }
        return array_unique($statuses);
    }
    
    // Validate order statuses for payment so that customers can retry payment
    public function valid_order_statuses_for_payment($statuses, $order) {
        if ( $order->has_status( ['failed', 'pending', 'cancelled'] ) ) {
            $statuses[] = $order->get_status();
        }
        return array_unique($statuses);
    }

    // Customize order numbers to include a prefix and CRC32 hash
    public function customize_order_numbers($order_number, $order_id, $arr_order_timestamp) {        
        $prefix = preg_replace("/[^a-zA-Z]+/", '', $order_number);
        $crc32 = preg_replace('/[^0-9]/', '', $order_number);

        if(strlen($crc32) < 10) return $order_number;

        return $prefix . '-' . substr($crc32, 0, 5) . '-' . substr($crc32, -5);
    }

    // Markeer admin-aangemaakte orders (dashboard)
    public function mark_admin_order($order_id) {
        $order = wc_get_order($order_id);
        if (!$order) return;

        // WooCommerce bewaart meestal iets als created_via
        $created_via = $order->get_created_via(); // bv. 'admin' of 'checkout'
        if ($created_via === 'admin') {
            $order->update_meta_data('_created_in_admin', 'yes');
            $order->save();
        }
    }
}
