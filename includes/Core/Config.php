<?php
namespace Trefik\Core;

class Config {

    private const WIXMO_DEFAULT_TOKEN_URL = 'https://login.wixmo.eu/auth/realms/TREFIK_ELP/protocol/openid-connect/token';
    private const WIXMO_DEFAULT_API_BASE_URL = 'https://tref-ik.mijntheorieonline.nl/api/';
    private const WIXMO_DEFAULT_GRANT_TYPE = 'client_credentials';

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

    /**
     * Central configuration access. Wixmo keys: wixmo.client_id, wixmo.client_secret,
     * wixmo.token_url, wixmo.api_base_url, wixmo.grant_type.
     *
     * @param string $key
     * @param mixed $default  Used for unknown $key only; Wixmo keys use built-in resolution.
     * @return mixed
     */
    public static function get($key, $default = null) {
        if (strpos($key, 'wixmo.') === 0) {
            $sub = substr($key, 6);
            switch ($sub) {
                case 'client_id':
                    return self::resolveSecret('TREFIK_WIXMO_API_CLIENT_ID', [ 'TREFIK_WIXMO_API_CLIENT_ID' ]);
                case 'client_secret':
                    return self::resolveSecret('TREFIK_WIXMO_API_CLIENT_SECRET', [ 'TREFIK_WIXMO_API_CLIENT_SECRET' ]);
                case 'token_url':
                    return self::resolveNonSecret('TREFIK_WIXMO_API_TOKEN_URL', [ 'TREFIK_WIXMO_API_TOKEN_URL' ], self::WIXMO_DEFAULT_TOKEN_URL);
                case 'api_base_url':
                    return self::resolveNonSecret('TREFIK_WIXMO_API_BASE_URL', [ 'TREFIK_WIXMO_API_BASE_URL' ], self::WIXMO_DEFAULT_API_BASE_URL);
                case 'grant_type':
                    return self::resolveNonSecret('TREFIK_WIXMO_API_GRANT_TYPE', [ 'TREFIK_WIXMO_API_GRANT_TYPE' ], self::WIXMO_DEFAULT_GRANT_TYPE);
                default:
                    return $default;
            }
        }
        return $default;
    }

    /**
     * @return string|null
     */
    public static function get_wixmo_client_id() {
        return self::get('wixmo.client_id');
    }

    /**
     * @return string|null
     */
    public static function get_wixmo_api_key() {
        return self::get('wixmo.client_secret');
    }

    public static function get_wixmo_auth_url() {
        return (string) self::get('wixmo.token_url');
    }

    public static function get_wixmo_api_base_url() {
        return (string) self::get('wixmo.api_base_url');
    }

    /**
     * @param string $constName
     * @param list<string> $envNames
     * @return string|null
     */
    private static function resolveSecret($constName, array $envNames) {
        $fromConst = self::stringFromConstant($constName);
        if ($fromConst !== null) {
            return $fromConst;
        }
        foreach ($envNames as $name) {
            $v = self::readEnv($name);
            if ($v !== null) {
                return $v;
            }
        }
        return null;
    }

    /**
     * @param string $constName
     * @param list<string> $envNames
     * @param string $default
     * @return string
     */
    private static function resolveNonSecret($constName, array $envNames, $default) {
        $fromConst = self::stringFromConstant($constName);
        if ($fromConst !== null) {
            return $fromConst;
        }
        foreach ($envNames as $name) {
            $v = self::readEnv($name);
            if ($v !== null) {
                return $v;
            }
        }
        return $default;
    }

    /**
     * @param string $name
     * @return string|null
     */
    private static function stringFromConstant($name) {
        if (! defined($name)) {
            return null;
        }
        $v = constant($name);
        if (! is_string($v) && ! is_int($v) && ! is_float($v)) {
            return null;
        }
        $s = (string) $v;
        return $s !== '' ? $s : null;
    }

    /**
     * @param string $name
     * @return string|null
     */
    private static function readEnv($name) {
        if (function_exists('getenv')) {
            $g = @getenv($name);
            if ($g !== false) {
                $s = (string) $g;
                if ($s !== '') {
                    return $s;
                }
            }
        }
        if (isset($_ENV[ $name ])) {
            $s = (string) $_ENV[ $name ];
            if ($s !== '') {
                return $s;
            }
        }
        return null;
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
