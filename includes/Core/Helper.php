<?php
namespace Trefik\Core;

class Helper {
    public static function dumpd($data, $die = false) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        if($die) wp_die(); 
    }

    public static function get_order_from_request() {
        if (!function_exists('wc_get_order')) {
            return;
        }
    
        global $wp;
    
        // Detecteer of we op een /order-pay/ pagina zijn
        if(isset($wp->query_vars['order-pay'])) {
            $order_id = absint($wp->query_vars['order-pay']);
        }
    
        // Detecteer of we op een /order-pay/ pagina zijn
        if(isset($wp->query_vars['bedankt'])) {
            $order_id = absint($wp->query_vars['bedankt']);
        }
    
        if(!isset($order_id)) {
            return;
        }
        
        $order_key = sanitize_text_field(wp_unslash($_GET['key']));
        
        $order = wc_get_order($order_id);
        
        if (!$order || $order->get_order_key() !== $order_key) {
            return; // Ongeldige order
        }
    
        return $order;
    }

    public static function validate_external_order_number($order_number)
    {
        return preg_match('/^TI-[0-9]{5}-[0-9]{5}$/', $order_number);
    }

    public static function write_log( $data ) {
        if ( true === WP_DEBUG ) {
            if ( is_array( $data ) || is_object( $data ) ) {
                error_log( print_r( $data, true ) );
            } else {
                error_log( $data );
            }
        }
    }

     /**
     * Convert a stdClass object to an array
     *
     * @param \stdClass $d
     * @return array
     */
    public static function objectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (!is_array($d)) {
            return $d;
        }
        return array_map(array(__CLASS__, __FUNCTION__), $d); // recursive
    }
}