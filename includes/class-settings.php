<?php
if (!defined('ABSPATH')) {
    exit;
}

class WP_AVIF_Converter_Settings {
    public function register_settings() {
        register_setting('wp-avif-converter', 'wp_avif_quality');
        add_option('wp_avif_quality', '70');
    }

    public function add_admin_menu() {
        add_options_page(
            'AVIF Converter Settings',
            'AVIF Converter',
            'manage_options',
            'wp-avif-converter',
            array($this, 'render_settings_page')
        );
    }

    public function render_settings_page() {
        require_once plugin_dir_path(__FILE__) . '../templates/settings-page.php';
    }
}