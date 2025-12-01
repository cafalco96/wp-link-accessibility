<?php
/**
 * Uninstall script for Link Accessibility Fix
 * 
 * This file is executed when the plugin is uninstalled via WordPress admin.
 * It cleans up all plugin data from the database.
 * 
 * @package WP_Link_Accessibility_Fix
 * @since 1.0
 */

// Exit if accessed directly or not uninstalling
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Additional security check
if (!defined('ABSPATH')) {
    exit;
}

// Delete plugin options from wp_options table
$wplaf_options = array(
    'wplaf_options',
    'wplaf_enable_processing',
    'wplaf_generic_patterns',
    'wplaf_context_length',
    'wplaf_fallback_to_title',
    'wplaf_plugin_version'
);

// Delete from current site
foreach ($wplaf_options as $wplaf_option) {
    delete_option($wplaf_option);
}

// For multisite installations, delete options from all sites
if (is_multisite()) {
    // Get all site IDs (get_sites already uses internal caching)
    $wplaf_sites = get_sites(array(
        'fields'  => 'ids',
        'number'  => 0,
        'orderby' => 'id'
    ));
    
    if (!empty($wplaf_sites) && is_array($wplaf_sites)) {
        foreach ($wplaf_sites as $wplaf_site_id) {
            // Switch to each site
            switch_to_blog($wplaf_site_id);
            
            // Delete options for this site
            foreach ($wplaf_options as $wplaf_option) {
                delete_option($wplaf_option);
                // Also clear from object cache
                wp_cache_delete($wplaf_option, 'options');
            }
            
            // Restore original site
            restore_current_blog();
        }
    }
}

// Clear all cached data
wp_cache_flush();

// Delete any transients (if you use them in the future)
delete_transient('wplaf_cache');
delete_site_transient('wplaf_cache');