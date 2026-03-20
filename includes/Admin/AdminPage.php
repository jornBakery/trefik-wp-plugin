<?php
namespace Trefik\Admin;

class AdminPage {
    public function init() {
        add_action('admin_menu', [$this, 'add_menu']);
    }

    public function add_menu() {
        add_menu_page(
            'Tref-ik',
            'Tref-ik',
            'manage_options',
            'tref-ik',
            [$this, 'render_page']
        );
    }

    public function render_page() {
        echo '<h1>'.__('Admin Dashboard Tref-ik Plugin', TREFIK_TEXT_DOMAIN).'</h1>';
    }
}