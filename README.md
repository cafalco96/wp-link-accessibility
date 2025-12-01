# Link Accessibility Fix

A WordPress plugin that automatically enhances the accessibility of generic links by adding descriptive aria-labels and visually hidden text.

## Overview

This plugin improves web accessibility by identifying generic link text (such as "Learn more", "Click here", "Read more") and automatically enhancing them with contextual information. This helps screen reader users understand where links will take them without needing surrounding context.

## Problem Statement

Generic link text like "Click here" or "Learn more" creates accessibility barriers because:

- Screen reader users often navigate by jumping between links
- Without context, generic links are meaningless when read in isolation
- This violates WCAG 2.1 Success Criterion 2.4.4 (Link Purpose in Context)

## How It Works

1. **Content Scanning**: The plugin scans WordPress content during rendering
2. **Pattern Detection**: Identifies common generic link patterns in multiple languages
3. **Context Extraction**: Analyzes surrounding text to understand link context
4. **Enhancement**: Adds two accessibility improvements:
   - **aria-label**: Provides descriptive label for screen readers
   - **Visually hidden text**: Adds context visible only to assistive technologies

### Example

**Before:**

```html
<p>Want to know more about our services? <a href="/services">Click here</a></p>
```

**After:**

```html
<p>
  Want to know more about our services?
  <a href="/services" aria-label="Click here to learn about our services">
    Click here
    <span class="wplaf-sr-only"> to learn about our services</span>
  </a>
</p>
```

## Features

- ✅ Automatic detection of generic links
- ✅ Multi-language support (English, Spanish, French, German, Italian, Portuguese)
- ✅ Smart context extraction from surrounding text
- ✅ Non-intrusive (doesn't change visual appearance)
- ✅ WCAG 2.1 compliant
- ✅ Lightweight and performant
- ✅ No configuration needed (works out of the box)

## Supported Generic Link Patterns

The plugin recognizes various generic link texts including:

- Click here / Clic aquí / Cliquez ici
- Read more / Leer más / Lire la suite
- Learn more / Más información / En savoir plus
- More info / Más info / Plus d'infos
- View details / Ver detalles / Voir les détails
- And many more...

## Installation

### From WordPress.org (Recommended)

1. Log in to your WordPress admin panel
2. Navigate to **Plugins > Add New**
3. Search for "Link Accessibility Fix"
4. Click **Install Now** and then **Activate**

### Manual Installation

1. Download the plugin files
2. Upload to `/wp-content/plugins/wp-link-accessibility/`
3. Activate through the WordPress 'Plugins' menu
4. The plugin works automatically - no configuration required

## Requirements

- WordPress 5.0 or higher
- PHP 7.2 or higher

## Technical Details

### Architecture

```
wp-link-accessibility/
├── accessibility-link-prefix.php    # Main plugin file & bootstrapper
├── readme.txt                        # WordPress.org readme
├── README.md                         # GitHub documentation
├── license.txt                       # GPL v2 license (full text)
├── uninstall.php                     # Cleanup script for plugin deletion
└── src/                             # Source code directory
    ├── includes/                    # Core plugin classes
    │   ├── class-autoloader.php    # PSR-4 autoloader
    │   ├── class-plugin.php        # Main plugin controller
    │   ├── class-link-processor.php # Link detection & enhancement
    │   └── class-settings.php      # Settings API & options
    ├── admin/                       # Admin interface
    │   ├── class-assets.php        # Asset management
    │   └── settings-page.php       # Settings page template
    └── config/                      # Configuration
        └── default-texts.php       # Default generic patterns
```

### Class Structure

#### `WPLAF_Plugin`
- **Purpose**: Main plugin controller
- **Responsibilities**: 
  - Initializes all plugin components
  - Manages hooks and filters
  - Coordinates between classes
- **Singleton pattern**: Ensures single instance

#### `WPLAF_Link_Processor`
- **Purpose**: Core link processing engine
- **Responsibilities**:
  - Scans content for generic links
  - Extracts contextual information
  - Generates aria-labels
  - Adds visually hidden text
- **Methods**:
  - `process_content()` - Main processing entry point
  - `generate_aria_label()` - Creates descriptive labels
  - `get_parent_heading_context()` - Extracts context from headings

#### `WPLAF_Settings`
- **Purpose**: Settings management
- **Responsibilities**:
  - Admin menu registration
  - Settings page rendering
  - Options sanitization
  - Default patterns management
- **Singleton pattern**: Single settings instance

#### `WPLAF_Assets`
- **Purpose**: Asset management
- **Responsibilities**:
  - Enqueues CSS for screen-reader-only text
  - Manages frontend styles
  - Admin panel styling

#### `WPLAF_Autoloader`
- **Purpose**: PSR-4 compliant autoloader
- **Responsibilities**:
  - Automatic class loading
  - Namespace to file path conversion

### How Context Extraction Works

The plugin uses a multi-layered approach to extract context:

1. **Parent Heading Analysis**: Searches up to 5 levels up for `<h1>-<h6>` tags
2. **URL Path Parsing**: Extracts meaningful text from URL segments
3. **Anchor Detection**: Generates labels from internal anchors (#links)
4. **Fallback Strategy**: Uses generic but descriptive text if no context found

**Context extraction algorithm:**

```php
// 1. Check parent headings (most specific)
if (heading_found) {
    return "about [heading text]";
}

// 2. Check for anchor links
if (href starts with '#') {
    return "about [anchor name]";
}

// 3. Parse URL path
if (url_path_exists) {
    return "about [last segment]";
}

// 4. Generic fallback
return "about this content";
```

### Hooks & Filters

The plugin processes content through WordPress filters:

```php
// Content filters (priority 20)
add_filter('the_content', [$this->link_processor, 'process_content'], 20);
add_filter('widget_text', [$this->link_processor, 'process_content'], 20);
add_filter('comment_text', [$this->link_processor, 'process_content'], 20);
```

**Custom Filters Available:**

```php
// Add custom generic patterns
add_filter('wplaf_generic_patterns', function($patterns) {
    $patterns['custom'] = '/your pattern/i';
    return $patterns;
});
```

## Development

### Code Standards

- ✅ WordPress Coding Standards
- ✅ PSR-4 autoloading
- ✅ Object-oriented architecture
- ✅ Fully documented (PHPDoc)
- ✅ Security best practices (nonce, sanitization, escaping)

### Testing

Test the plugin with:

1. **Manual testing**: Create posts with generic links
2. **Screen readers**: Test with NVDA, JAWS, or VoiceOver
3. **Browser DevTools**: Inspect aria-labels in HTML
4. **WordPress Plugin Check**: Validate standards compliance

### Extending the Plugin

#### Add Custom Generic Patterns

```php
add_filter('wplaf_generic_patterns', function($patterns) {
    $patterns['custom_read'] = '/read this/i';
    $patterns['custom_view'] = '/view now/i';
    return $patterns;
});
```

#### Disable on Specific Pages

```php
add_filter('wplaf_should_process', function($should_process) {
    if (is_page('contact')) {
        return false; // Don't process on contact page
    }
    return $should_process;
});
```

## Browser Compatibility

Works with all modern browsers and assistive technologies:

- **Screen Readers**: JAWS, NVDA, VoiceOver, TalkBack, Narrator
- **Browsers**: Chrome, Firefox, Safari, Edge
- **Mobile**: iOS Safari, Chrome Mobile, Samsung Internet

## Performance

- **Minimal overhead**: Only processes content when rendered
- **Smart caching**: Uses WordPress object cache
- **No database queries**: Settings cached in memory
- **Lightweight**: < 50KB total size

## WCAG Compliance

Helps meet:

- **WCAG 2.1 Level A**: Success Criterion 2.4.4 (Link Purpose in Context)
- **Section 508**: Equivalent standards
- **EN 301 549**: European accessibility standard

## Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Setup

```bash
# Clone the repository
git clone https://github.com/cafalco96/wp-link-accessibility.git

# Install in WordPress plugins directory
cd /path/to/wordpress/wp-content/plugins/
ln -s /path/to/wp-link-accessibility wp-link-accessibility

# Activate in WordPress admin
```

## Changelog

### 1.0 (Initial Release)
- ✅ Automatic detection of generic links
- ✅ Multi-language support (EN, ES, FR, DE, IT, PT)
- ✅ Smart context extraction algorithm
- ✅ WCAG 2.1 compliance
- ✅ PSR-4 autoloading architecture
- ✅ Lightweight and performant

## Roadmap

- [ ] Add visual admin dashboard with statistics
- [ ] Support for custom post types configuration
- [ ] Pattern exclusion list (whitelist specific generic links)
- [ ] Integration with popular page builders
- [ ] Advanced context extraction using AI/ML
- [ ] Export/import settings

## Author

**Carlos Falconi**
- Website: [https://cafalco96.github.io/](https://cafalco96.github.io/)
- GitHub: [@cafalco96](https://github.com/cafalco96)

## License

This plugin is licensed under the **GPL v2 or later**.

```
Copyright (C) 2024 Carlos Falconi

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
```

See [license.txt](license.txt) for full license text.

## Support

- **Issues**: [GitHub Issues](https://github.com/cafalco96/wp-link-accessibility/issues)
- **WordPress.org**: [Support Forum](https://wordpress.org/support/plugin/wp-link-accessibility/)
- **Documentation**: [Plugin Wiki](https://github.com/cafalco96/wp-link-accessibility/wiki)

## Privacy

This plugin does **not**:
- ❌ Collect any user data
- ❌ Make external API calls
- ❌ Store cookies
- ❌ Track users

All processing happens locally on your server.

---

**Note**: This plugin enhances accessibility but should be used alongside other accessibility best practices. Writing descriptive link text from the start is always the best approach.

Made with ❤️ for a more accessible web.
