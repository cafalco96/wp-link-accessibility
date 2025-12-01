<?php
/**
 * Main plugin class
 */

if (!defined('ABSPATH')) {
    exit;
}

class WPLAF_Plugin {
    
    /**
     * Single instance
     */
    private static $instance = null;
    
    /**
     * Settings instance
     */
    private $settings;
    
    /**
     * Link processor instance
     */
    private $link_processor;
    
    /**
     * Assets instance
     */
    private $assets;
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }
    
    /**
     * Load dependencies
     */
    private function load_dependencies() {
        $this->settings = WPLAF_Settings::get_instance();
        $this->link_processor = new WPLAF_Link_Processor($this->settings);
        $this->assets = new WPLAF_Assets();
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Content filters
        add_filter('the_content', [$this->link_processor, 'process_content'], 20);
        add_filter('widget_text', [$this->link_processor, 'process_content'], 20);
        add_filter('comment_text', [$this->link_processor, 'process_content'], 20);
    }
}
