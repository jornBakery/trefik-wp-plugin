<?php
/**
 * Plugin Name: Tref-ik
 * Description: Essential plugin for Tref-ik.
 * Version: 2.0.3
 * Author: App King
 */


defined('ABSPATH') || exit;

if (!defined('TREFIK_PLUGIN_FILE')) {
    define('TREFIK_PLUGIN_FILE', __FILE__);
}

if (!defined('TREFIK_TEXT_DOMAIN')) {
    define('TREFIK_TEXT_DOMAIN', 'trefik');
}

if (!defined('TREFIK_WIXMO_API_CLIENT_ID')) {
    define('TREFIK_WIXMO_API_CLIENT_ID', 'webshop');
}
if (!defined('TREFIK_WIXMO_API_CLIENT_SECRET')) {
    define('TREFIK_WIXMO_API_CLIENT_SECRET', '3e64db68-2dd0-485d-989d-163c9de10c46');
}

if (!defined('TREFIK_WIXMO_API_GRANT_TYPE')) {
    define('TREFIK_WIXMO_API_GRANT_TYPE', 'client_credentials');
}

if (!defined('TREFIK_WIXMO_API_TOKEN_URL')) {
    define('TREFIK_WIXMO_API_TOKEN_URL', 'https://login.wixmo.eu/auth/realms/TREFIK_ELP/protocol/openid-connect/token');
}

if (!defined('TREFIK_WIXMO_API_BASE_URL')) {
    define('TREFIK_WIXMO_API_BASE_URL', 'https://tref-ik.mijntheorieonline.nl/api/');
}


// Autoloader includen en registreren
require_once plugin_dir_path(__FILE__) . 'src/Autoloader.php';

Trefik\Autoloader::register();

// Start the plugin
global $trefik_plugin;
$trefik_plugin = new Trefik\Core\Plugin();
$trefik_plugin->run();