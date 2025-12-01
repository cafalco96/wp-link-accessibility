# WP Link Accessibility Fix

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
    <span class="screen-reader-text"> to learn about our services</span>
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
├── accessibility-link-prefix.php    # Main plugin file
├── README.md                         # This documentation file
├── src/                             # Source code directory
│   ├── includes/                    # Core plugin classes
│   │   ├── class-autoloader.php    # PSR-4 autoloader for plugin classes
│   │   ├── class-plugin.php        # Main plugin controller & initialization
│   │   ├── class-link-processor.php # Link detection & enhancement engine
│   │   ├── class-settings.php      # Settings API handler & options management
│   │   └── class-assets.php        # CSS/JS asset management & enqueuing
│   ├── admin/                       # Admin panel functionality
│   │   └── settings-page.php       # Settings page HTML template
│   └── config/                      # Configuration files
│       └── default-texts.php       # Default generic link patterns (multilingual)
├── assets/                          # Frontend & admin assets
│   └── css/
│       ├── frontend.css            # Frontend styles (screen-reader-text)
│       └── admin.css               # Admin panel styles
└── languages/                       # Translation files (i18n)
    └── wp-link-accessibility-fix.pot # Translation template
```

### How Context Extraction Works

1. Extracts text before and after the link (up to 100 characters each)
2. Cleans and normalizes the text
3. Removes generic phrases and repetitive content
4. Generates descriptive text based on the most relevant context
5. Falls back to page title if no context is available

## Development

### Code Standards

- Follows WordPress Coding Standards
- PSR-4 autoloading
- Object-oriented architecture
- Fully commented code

### Extending the Plugin

You can add custom generic link patterns using the filter:

```php
add_filter('wplaf_generic_patterns', function($patterns) {
    $patterns['custom'] = '/your custom pattern/i';
    return $patterns;
});
```

## Browser Compatibility

Works with all modern browsers and assistive technologies including:

- JAWS
- NVDA
- VoiceOver
- TalkBack

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues.

## Author

**Carlos Falconi**

- Website: [https://cafalco96.github.io/](https://cafalco96.github.io/)

## License

This plugin is licensed under the GPL v2 or later.

## Support

For bug reports and feature requests, please open an issue on the repository.

---

**Note**: This plugin enhances accessibility but should be used alongside other accessibility best practices, not as a replacement for writing descriptive link text.
