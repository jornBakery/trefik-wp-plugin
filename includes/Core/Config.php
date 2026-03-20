<?php
namespace Trefik\Core;

class Config {

    private static $wixmo_api_base_url = 'https://tref-ik.mijntheorieonline.nl/api/';
    private static $wixmo_auth_url = 'https://login.wixmo.eu/auth/realms/TREFIK_ELP/protocol/openid-connect/token';
    private static $wixmo_api_key = '3e64db68-2dd0-485d-989d-163c9de10c46';
    private static $wixmo_client_id = 'webshop';
    private static $wixmo_grant_type = 'client_credentials';
    private static $curl;

    
    public static function version() {
        return '2.0.3';
    }

    public static function url() {
        return plugin_dir_url(TREFIK_PLUGIN_FILE);
    }

    public static function path() {
        return plugin_dir_path(TREFIK_PLUGIN_FILE);
    }

    public static function template_path() {
        return self::path() . 'templates/';
    }

    public static function translations_path() {
        return self::path() . 'languages/';
    }

    public static function get_wixmo_client_id() {
        return self::$wixmo_client_id;
    }   
    public static function get_wixmo_auth_url() {
        return self::$wixmo_auth_url;
    }
    public static function get_wixmo_api_key() {
        return self::$wixmo_api_key;
    }
    public static function get_wixmo_api_base_url() {
        return self::$wixmo_api_base_url;
    }

    /**
     * @return \Trefik\Curl\CurlInterface
     */
    public static function getCurl()
    {
        if (self::$curl === null) {
            self::$curl = curl_init();
            
        }

        return self::$curl;
    }

    /**
     * @param mixed $curl
     */
    public static function setCurl($curl)
    {
        if (is_string($curl)) {
            $curl = curl_init();
        }

        self::$curl = $curl;
    }

}