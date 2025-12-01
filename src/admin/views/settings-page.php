<?php
/**
 * Settings page template
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php _e('WP Link Accessibility Fix', 'wp-link-accessibility-fix'); ?></h1>
    
    <form method="post" action="options.php">
        <?php
        settings_fields(WPLAF_Settings::OPTION_NAME . '_group');
        do_settings_sections('wp-link-accessibility');
        submit_button();
        ?>
    </form>
    
    <hr>
    
    <div class="wplaf-info">
        <h2><?php _e('About This Plugin', 'wp-link-accessibility-fix'); ?></h2>
        <p><?php _e('This plugin automatically enhances generic links (like "Learn more", "Click here") with descriptive aria-labels and screen reader text to meet WCAG 2.4.4 compliance standards.', 'wp-link-accessibility-fix'); ?></p>
        
        <h3><?php _e('How It Works', 'wp-link-accessibility-fix'); ?></h3>
        <ul>
            <li><?php _e('Scans content for generic link texts', 'wp-link-accessibility-fix'); ?></li>
            <li><?php _e('Adds contextual aria-labels based on surrounding content', 'wp-link-accessibility-fix'); ?></li>
            <li><?php _e('Includes visually hidden text for screen readers', 'wp-link-accessibility-fix'); ?></li>
        </ul>
        
        <p><strong><?php _e('Version:', 'wp-link-accessibility-fix'); ?></strong> <?php echo esc_html(WPLAF_VERSION); ?></p>
    </div>
</div>
