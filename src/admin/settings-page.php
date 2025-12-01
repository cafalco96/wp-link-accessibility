<?php
/**
 * Settings page template
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php esc_html_e('WP Link Accessibility Fix', 'wp-link-accessibility'); ?></h1>
    
    <form method="post" action="options.php">
        <?php
        settings_fields(WPLAF_Settings::OPTION_NAME . '_group');
        do_settings_sections('wp-link-accessibility');
        submit_button();
        ?>
    </form>
    
    <hr>
    
    <div class="wplaf-info">
        <h2><?php esc_html_e('About This Plugin', 'wp-link-accessibility'); ?></h2>
        <p><?php esc_html_e('This plugin automatically enhances generic links (like "Learn more", "Click here") with descriptive aria-labels and screen reader text to meet WCAG 2.4.4 compliance standards.', 'wp-link-accessibility'); ?></p>
        
        <h3><?php esc_html_e('How It Works', 'wp-link-accessibility'); ?></h3>
        <ul>
            <li><?php esc_html_e('Scans content for generic link texts', 'wp-link-accessibility'); ?></li>
            <li><?php esc_html_e('Adds contextual aria-labels based on surrounding content', 'wp-link-accessibility'); ?></li>
            <li><?php esc_html_e('Includes visually hidden text for screen readers', 'wp-link-accessibility'); ?></li>
        </ul>
        
        <p><strong><?php esc_html_e('Version:', 'wp-link-accessibility'); ?></strong> <?php echo esc_html(WPLAF_VERSION); ?></p>
    </div>
</div>