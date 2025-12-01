<?php
/**
 * Assets management class
 */

if (!defined('ABSPATH')) {
    exit;
}

class WPLAF_Assets {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_styles']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
    }
    
    /**
     * Enqueue frontend styles
     */
    public function enqueue_frontend_styles() {
        wp_enqueue_style(
            'wplaf-frontend',
            WPLAF_PLUGIN_URL . 'src/assets/css/frontend.css',
            [],
            WPLAF_VERSION,
            'all'
        );
    }
    
    /**
     * Enqueue admin styles
     */
    public function enqueue_admin_styles($hook) {
        // Solo cargar en nuestra página de settings
        if ('settings_page_wp-link-accessibility' !== $hook) {
            return;
        }
        
        wp_enqueue_style(
            'wplaf-admin',
            WPLAF_PLUGIN_URL . 'src/assets/css/admin.css',
            [],
            WPLAF_VERSION,
            'all'
        );
    }
}
