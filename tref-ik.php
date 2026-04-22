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

// Autoloader includen en registreren
require_once plugin_dir_path(__FILE__) . 'src/Autoloader.php';

Trefik\Autoloader::register();

// Start the plugin
global $trefik_plugin;
$trefik_plugin = new Trefik\Core\Plugin();
$trefik_plugin->run();