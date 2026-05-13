<?php
namespace Trefik\Integrations\WooCommerce;

use Trefik\Core\Config;
use Trefik\Core\Helper;


class WooEmailHooks {

    protected static $path = 'emails/';

    public function register_hooks() {
        add_action('trefik_email_order_completed_section_hero', [$this, 'email_order_completed_section_hero'], 10, 4);
        add_action('trefik_email_order_completed_section_delivery_status', [$this, 'email_order_completed_section_delivery_status'], 10, 4);
        add_action('trefik_email_order_completed_section_contact', [$this, 'email_order_completed_section_contact'], 10, 4);
        
        add_action('trefik_email_order_completed_section_admin_order',  [$this, 'email_order_completed_section_admin_order'], 10 ,4);

        add_filter( 'woocommerce_locate_template', [ $this, 'locate_woocommerce_template' ], 10, 3 );

    }

    public function email_order_completed_section_hero($order, $sent_to_admin, $plain_text, $email) {
        $this->include_template('customer-completed-order-section-hero');
    }

    public function email_order_completed_section_delivery_status($order, $sent_to_admin, $plain_text, $email) {
        $this->include_template('customer-completed-order-section-delivery-status');
    }

    public function email_order_completed_section_contact($order, $sent_to_admin, $plain_text, $email) {
        $this->include_template('customer-completed-order-section-contact');
    }

    // public function email_locate_template($located, $template_name, $args){
    // public function email_locate_template($located, $template_name, $args, $template_path, $default_path){
    public function email_order_completed_section_admin_order($order, $sent_to_admin, $plain_text, $email) {

        // if ($template_name !== 'emails/customer-processing-order.php') {
        //     return $located;
        // }

        // if (empty($args['order']) || !is_a($args['order'], 'WC_Order')) {
        //     return $located;
        // }

        // $order = $args['order'];
        // Helper::dumpd($order->get_smeta('_wc_order_attribution_source_type'), true);
        Helper::write_log(['WooEmailHooks::email_order_completed_section_admin_order', $order->get_meta('_wc_order_attribution_source_type')]);
        if ($order->get_meta('_wc_order_attribution_source_type') === 'admin') {
            Helper::write_log("ADMIN_ORDER");

            $this->include_template('customer-completed-order-section-admin-order');

            // $template_path = Config::template_path() . self::$path .'customer-processing-order-admin' . '.php';
            // // $this->include_template('customer-processing-order-admin');
            // // customer-processing-order-admin
            // // $admin_variant = trailingslashit(get_stylesheet_directory()) . 'woocommerce/emails/customer-processing-order-admin.php';
            // if (file_exists($template_path)) {
            //     return $template_path;
            // }
        }

        // return $located;
        
    }

    private function include_template($template_path) {
        $template_path = Config::template_path() . self::$path .$template_path . '.php';
        Helper::write_log(['WooEmailHooks::include_template', $template_path]);
        if(file_exists($template_path)){
            include($template_path);
            return;
        }
        Helper::write_log(['WooEmailHooks::include_template', "template not found: ". $template_path]);

    }

    /**
     * Allow overriding WooCommerce templates from this plugin.
     *
     * We only target email templates (`emails/*`) and resolve them to:
     * - {plugin}/templates/emails/*
     *
     * @param string $template      Located template path (WooCommerce result).
     * @param string $template_name Template name (e.g. emails/email-header.php).
     * @param string $template_path Template path (unused here).
     * @return string
     */
    public function locate_woocommerce_template( $template, $template_name, $template_path ) {
        if ( 0 !== strpos( (string) $template_name, 'emails/' ) ) {
            return $template;
        }

        $plugin_candidate = Config::template_path() . $template_name;
        if ( file_exists( $plugin_candidate ) ) {
            return $plugin_candidate;
        }

        return $template;
    }
}