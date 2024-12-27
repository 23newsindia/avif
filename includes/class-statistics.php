<?php
if (!defined('ABSPATH')) {
    exit;
}

class WP_AVIF_Converter_Statistics {
    public function get_space_saved() {
        $saved = get_option('wp_avif_space_saved', 0);
        return number_format($saved, 2);
    }

    public function get_converted_count() {
        return get_option('wp_avif_converted_count', 0);
    }
}