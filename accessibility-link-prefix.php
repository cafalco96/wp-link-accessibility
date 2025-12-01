<?php
/**
 * Plugin Name: Link Accessibility Fix
 * Description: Adds descriptive aria-labels and visually hidden text to generic links like "Learn more", "Click here", etc. 
 * Version: 1.0
 * Author: Carlos Falconi
 * Author URI: https://cafalco96.github.io/
 * Text Domain: wp-link-accessibility
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Requires PHP: 7.2
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WPLAF_VERSION', '1.0');
define('WPLAF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPLAF_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WPLAF_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Require autoloader from src directory
require_once WPLAF_PLUGIN_DIR . 'src/includes/class-autoloader.php';

// Initialize autoloader
WPLAF_Autoloader::init();

/**
 * Initialize plugin
 * Runs on 'plugins_loaded' hook to ensure translations are loaded properly
 */
function wplaf_init_plugin() {
    return WPLAF_Plugin::get_instance();
}

// Start the plugin on plugins_loaded hook (priority 10)
add_action('plugins_loaded', 'wplaf_init_plugin');
