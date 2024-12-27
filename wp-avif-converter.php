<?php
/**
 * Plugin Name: WP AVIF Converter
 * Description: Automatically converts uploaded images to AVIF format while preserving originals
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit;
}

class WP_AVIF_Converter {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_filter('wp_handle_upload', array($this, 'convert_to_avif'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_admin_menu() {
        add_options_page(
            'AVIF Converter Settings',
            'AVIF Converter',
            'manage_options',
            'wp-avif-converter',
            array($this, 'settings_page')
        );
    }

    public function register_settings() {
        register_setting('wp-avif-converter', 'wp_avif_quality');
        add_option('wp_avif_quality', '70');
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>AVIF Converter Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('wp-avif-converter'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">AVIF Quality (1-100)</th>
                        <td>
                            <input type="number" name="wp_avif_quality" 
                                   value="<?php echo esc_attr(get_option('wp_avif_quality')); ?>"
                                   min="1" max="100" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            <div class="card">
                <h2>Statistics</h2>