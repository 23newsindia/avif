<?php
if (!defined('ABSPATH')) {
    exit;
}

$statistics = new WP_AVIF_Converter_Statistics();
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
        <p>Total images converted: <?php echo esc_html($statistics->get_converted_count()); ?></p>
        <p>Total space saved: <?php echo esc_html($statistics->get_space_saved()); ?> MB</p>
    </div>
</div>