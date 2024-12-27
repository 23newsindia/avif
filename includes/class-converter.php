<?php
if (!defined('ABSPATH')) {
    exit;
}

class WP_AVIF_Converter_Core {
    private $allowed_types = array('image/jpeg', 'image/png', 'image/webp');

    public function convert_to_avif($upload) {
        if (!in_array($upload['type'], $this->allowed_types)) {
            return $upload;
        }

        $quality = get_option('wp_avif_quality', 70);
        $file_path = $upload['file'];
        $avif_path = preg_replace('/\.(jpg|jpeg|png|webp)$/i', '.avif', $file_path);

        if ($this->perform_conversion($file_path, $avif_path, $quality)) {
            $this->update_statistics($file_path, $avif_path);
            unlink($file_path); // Remove original file
            
            // Update upload info to use AVIF version
            $upload['file'] = $avif_path;
            $upload['url'] = str_replace(basename($upload['url']), basename($avif_path), $upload['url']);
            $upload['type'] = 'image/avif';
        }

        return $upload;
    }

    private function perform_conversion($file_path, $avif_path, $quality) {
        $command = sprintf(
            'avifenc -q %d %s %s',
            escapeshellarg($quality),
            escapeshellarg($file_path),
            escapeshellarg($avif_path)
        );

        exec($command, $output, $return_var);
        return $return_var === 0;
    }

    private function update_statistics($original_file, $avif_file) {
        $original_size = filesize($original_file);
        $avif_size = filesize($avif_file);
        $saved_space = ($original_size - $avif_size) / 1024 / 1024;

        $total_saved = get_option('wp_avif_space_saved', 0);
        update_option('wp_avif_space_saved', $total_saved + $saved_space);

        $converted_count = get_option('wp_avif_converted_count', 0);
        update_option('wp_avif_converted_count', $converted_count + 1);
    }
}