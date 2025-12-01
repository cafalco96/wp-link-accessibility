<?php
if (!defined('ABSPATH')) {
    exit;
}

class WPLAF_Autoloader {
    
    public static function init() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }
    
    public static function autoload($class) {
        // Only autoload classes from this plugin
        if (strpos($class, 'WPLAF_') !== 0) {
            return;
        }
        
        // Convert class name to file path
        $class_file = strtolower(str_replace('_', '-', $class));
        $class_file = 'class-' . substr($class_file, 6) . '.php';
        
        // Check in includes directory (src/includes)
        $includes_path = WPLAF_PLUGIN_DIR . 'src/includes/' . $class_file;
        if (file_exists($includes_path)) {
            require_once $includes_path;
            return;
        }
        
        // Check in admin directory (src/admin)
        $admin_path = WPLAF_PLUGIN_DIR . 'src/admin/' . $class_file;
        if (file_exists($admin_path)) {
            require_once $admin_path;
            return;
        }
    }
}
