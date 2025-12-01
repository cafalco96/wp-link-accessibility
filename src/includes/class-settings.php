<?php
/**
 * Settings management class
 */

if (!defined('ABSPATH')) {
    exit;
}

class WPLAF_Settings {
    
    /**
     * Single instance
     */
    private static $instance = null;
    
    /**
     * Option name
     */
    const OPTION_NAME = 'wplaf_options';
    
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
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }
    
    /**
     * Add settings page to admin menu
     */
    public function add_settings_page() {
        add_options_page(
            __('Link Accessibility Settings', 'wp-link-accessibility-fix'),
            __('Link Fixer', 'wp-link-accessibility-fix'),
            'manage_options',
            'wp-link-accessibility',
            [$this, 'render_settings_page']
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting(self::OPTION_NAME . '_group', self::OPTION_NAME, [
            'sanitize_callback' => [$this, 'sanitize_settings']
        ]);
        
        add_settings_section(
            'wplaf_main_section',
            __('Plugin Settings', 'wp-link-accessibility-fix'),
            null,
            'wp-link-accessibility'
        );
        
        add_settings_field(
            'wplaf_enable',
            __('Enable Plugin', 'wp-link-accessibility-fix'),
            [$this, 'render_enable_field'],
            'wp-link-accessibility',
            'wplaf_main_section'
        );
        
        add_settings_field(
            'wplaf_generic_texts',
            __('Generic Link Texts', 'wp-link-accessibility-fix'),
            [$this, 'render_generic_texts_field'],
            'wp-link-accessibility',
            'wplaf_main_section'
        );
    }
    
    /**
     * Render settings page
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        include WPLAF_PLUGIN_DIR . 'src/admin/views/settings-page.php';
    }
    
    /**
     * Render enable checkbox field
     */
    public function render_enable_field() {
        $options = $this->get_options();
        ?>
        <label>
            <input type="checkbox" 
                   name="<?php echo esc_attr(self::OPTION_NAME); ?>[enable]" 
                   value="1" 
                   <?php checked(!empty($options['enable']), true); ?> />
            <?php _e('Fix generic links automatically', 'wp-link-accessibility-fix'); ?>
        </label>
        <?php
    }
    
    /**
     * Render generic texts field
     */
    public function render_generic_texts_field() {
        $options = $this->get_options();
        $texts = $this->get_generic_texts_array();
        ?>
        <textarea name="<?php echo esc_attr(self::OPTION_NAME); ?>[generic_texts]" 
                  rows="6" 
                  cols="50" 
                  class="large-text code"><?php echo esc_textarea(implode("\n", $texts)); ?></textarea>
        <p class="description">
            <?php _e('One text per line (case insensitive)', 'wp-link-accessibility-fix'); ?>
        </p>
        <p class="description">
            <strong><?php _e('Examples:', 'wp-link-accessibility-fix'); ?></strong>
            <br>
            <code>learn more</code> - <?php _e('Will match "Learn More", "LEARN MORE", etc.', 'wp-link-accessibility-fix'); ?>
            <br>
            <code>click here</code> - <?php _e('Will match "Click Here", "CLICK HERE", etc.', 'wp-link-accessibility-fix'); ?>
            <br>
            <code>ver más</code> - <?php _e('Works with any language', 'wp-link-accessibility-fix'); ?>
        </p>
        <?php
    }
    
    /**
     * Sanitize settings
     */
    public function sanitize_settings($input) {
        $sanitized = [];
        $sanitized['enable'] = isset($input['enable']) ? '1' : '0';
        
        if (!empty($input['generic_texts'])) {
            $texts = array_map('trim', explode("\n", $input['generic_texts']));
            $sanitized['generic_texts'] = implode("\n", array_filter($texts));
        }
        
        return $sanitized;
    }
    
    /**
     * Get plugin options
     */
    public function get_options() {
        return get_option(self::OPTION_NAME, ['enable' => '1']);
    }
    
    /**
     * Check if plugin is enabled
     */
    public function is_enabled() {
        $options = $this->get_options();
        return !empty($options['enable']) && $options['enable'] === '1';
    }
    
    /**
     * Get generic texts array
     */
    public function get_generic_texts_array() {
        $options = $this->get_options();
        
        if (!empty($options['generic_texts'])) {
            $texts = array_map('trim', array_map('strtolower', explode("\n", $options['generic_texts'])));
            return array_filter($texts);
        }
        
        return $this->get_default_texts();
    }
    
    /**
     * Get default generic texts
     */
    private function get_default_texts() {
        $default_file = WPLAF_PLUGIN_DIR . 'src/config/default-texts.php';
        
        if (file_exists($default_file)) {
            return include $default_file;
        }
        
        return [
            'learn more', 'click here', 'read more', 'more', 'see more', 
            'view more', 'here', 'details', 'info', 'continue reading', 
            'find out more'
        ];
    }
}
