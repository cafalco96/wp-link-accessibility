<?php
/**
 * Link processor class
 */

if (!defined('ABSPATH')) {
    exit;
}

class WPLAF_Link_Processor {
    
    /**
     * Settings instance
     */
    private $settings;
    
    /**
     * Constructor
     */
    public function __construct($settings = null) {
        $this->settings = $settings ?: WPLAF_Settings::get_instance();
    }
    
    /**
     * Process content
     */
    public function process_content($content) {
        if (!$this->settings->is_enabled()) {
            return $content;
        }
        
        if (empty($content)) {
            return $content;
        }
        
        $generic_texts = $this->settings->get_generic_texts_array();
        
        if (empty($generic_texts)) {
            return $content;
        }
        
        // Performance: Skip if no links
        if (stripos($content, '<a ') === false && stripos($content, '<a>') === false) {
            return $content;
        }
        
        return $this->fix_links($content, $generic_texts);
    }
    
    /**
     * Fix generic links in content
     */
    private function fix_links($content, $generic_texts) {
        libxml_use_internal_errors(true);
        
        $dom = new DOMDocument();
        $dom->encoding = 'UTF-8';
        
        $content_with_meta = '<?xml encoding="UTF-8">' . $content;
        $dom->loadHTML($content_with_meta, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        libxml_clear_errors();
        
        $links = iterator_to_array($dom->getElementsByTagName('a'));
        
        foreach ($links as $link) {
            $this->process_link($link, $generic_texts, $dom);
        }
        
        return $this->extract_body_content($dom);
    }
    
    /**
     * Process individual link
     */
    private function process_link($link, $generic_texts, $dom) {
        $text = trim(strtolower($link->textContent));
        
        if (!in_array($text, $generic_texts) || $link->hasAttribute('aria-label')) {
            return;
        }
        
        $aria_text = $this->generate_aria_label($link);
        
        if (!$aria_text) {
            return;
        }
        
        $link->setAttribute('aria-label', $aria_text);
        
        $span = $dom->createElement('span');
        $span->setAttribute('class', 'wplaf-sr-only');
        $span->setAttribute('aria-hidden', 'true');
        
        $span_text = $dom->createTextNode(' ' . $aria_text);
        $span->appendChild($span_text);
        $link->appendChild($span);
    }
    
    /**
     * Generate aria label for link
     */
    private function generate_aria_label($link) {
        // Try to get context from parent heading
        $context = $this->get_parent_heading_context($link);
        if ($context) {
            return 'about ' . $context;
        }
        
        $href = $link->getAttribute('href');
        
        // Check for internal anchor
        if ($href && strpos($href, '#') === 0) {
            return $this->generate_label_from_anchor($href);
        }
        
        // Try to get context from URL path
        if ($href) {
            $label = $this->generate_label_from_url($href);
            if ($label) {
                return $label;
            }
        }
        
        return 'about this content';
    }
    
    /**
     * Get context from parent heading
     */
    private function get_parent_heading_context($link) {
        $parent = $link->parentNode;
        $depth = 0;
        $max_depth = 5;
        
        while ($parent && $depth < $max_depth) {
            if (preg_match('/^h[1-6]$/i', $parent->nodeName)) {
                $text = trim(preg_replace('/\s+/', ' ', $parent->textContent));
                
                if (strlen($text) > 5 && strlen($text) < 120) {
                    return $text;
                }
            }
            
            $parent = $parent->parentNode;
            $depth++;
        }
        
        return false;
    }
    
    /**
     * Generate label from anchor
     */
    private function generate_label_from_anchor($href) {
        $anchor = substr($href, 1);
        $anchor = preg_replace('/[-_]/', ' ', $anchor);
        return 'about ' . ucwords($anchor);
    }
    
    /**
     * Generate label from URL
     */
    private function generate_label_from_url($href) {
        $path = wp_parse_url($href, PHP_URL_PATH);
        
        if (!$path) {
            return false;
        }
        
        $segments = array_filter(explode('/', trim($path, '/')));
        
        if (empty($segments)) {
            return false;
        }
        
        $last = end($segments);
        $last = preg_replace('/[\.\-_]/', ' ', $last);
        $last = preg_replace('/\.(html|php)$/i', '', $last);
        
        return 'about ' . ucwords(trim($last));
    }
    
    /**
     * Extract body content from DOM
     */
    private function extract_body_content($dom) {
        $new_content = $dom->saveHTML();
        $new_content = preg_replace('/^<\?xml[^>]*>/', '', $new_content);
        $new_content = preg_replace('/^<!DOCTYPE.+?>/', '', $new_content);
        $new_content = str_replace(['<html>', '</html>', '<body>', '</body>'], '', $new_content);
        
        return trim($new_content);
    }
}
