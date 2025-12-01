=== Link Accessibility Fix ===
Contributors: cafalco96
Donate link: https://cafalco96.github.io/
Tags: accessibility, wcag, aria, links, a11y
Requires at least: 5.0
Tested up to: 6.8
Stable tag: 1.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wp-link-accessibility
Domain Path: /languages

Automatically enhances accessibility of generic links by adding descriptive aria-labels and visually hidden text for screen readers.

== Description ==

Link Accessibility Fix improves web accessibility by identifying generic link text (such as "Learn more", "Click here", "Read more") and automatically enhancing them with contextual information. This helps screen reader users understand where links will take them without needing surrounding context.

**Why is this important?**

Generic link text like "Click here" or "Learn more" creates accessibility barriers because:

* Screen reader users often navigate by jumping between links
* Without context, generic links are meaningless when read in isolation
* This violates WCAG 2.1 Success Criterion 2.4.4 (Link Purpose in Context)

**Key Features:**

* Automatic detection of generic links
* Multi-language support (English, Spanish, French, German, Italian, Portuguese)
* Smart context extraction from surrounding text
* Non-intrusive - doesn't change visual appearance
* WCAG 2.1 compliant
* Lightweight and performant
* No configuration needed - works out of the box

**How it works:**

1. Content Scanning: The plugin scans WordPress content during rendering
2. Pattern Detection: Identifies common generic link patterns in multiple languages
3. Context Extraction: Analyzes surrounding text to understand link context
4. Enhancement: Adds aria-labels and visually hidden text

**Example transformation:**

Before:
`<p>Want to know more? <a href="/services">Click here</a></p>`

After:
`<p>Want to know more? <a href="/services" aria-label="Click here to learn about our services">Click here<span class="screen-reader-text"> to learn about our services</span></a></p>`

**Supported Generic Link Patterns:**

* Click here / Clic aqui / Cliquez ici
* Read more / Leer mas / Lire la suite
* Learn more / Mas informacion / En savoir plus
* More info / Mas info / Plus d'infos
* View details / Ver detalles / Voir les details
* And many more...

**Developer Friendly:**

Easily extend with custom patterns using filters:

`add_filter('wplaf_generic_patterns', function($patterns) {
    $patterns['custom'] = '/your pattern/i';
    return $patterns;
});`

== Installation ==

**Automatic installation:**

1. Log in to your WordPress admin panel
2. Navigate to Plugins > Add New
3. Search for "Link Accessibility Fix"
4. Click "Install Now" and then "Activate"

**Manual installation:**

1. Download the plugin zip file
2. Extract and upload the `wp-link-accessibility` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress

**After activation:**

The plugin works automatically - no configuration required! All generic links will be enhanced with accessibility improvements.

== Frequently Asked Questions ==

= Does this change the visual appearance of my site? =

No, the plugin only adds accessibility attributes (aria-labels) and visually hidden text that screen readers can use. Your site will look exactly the same to sighted users.

= What languages are supported? =

Currently supports English, Spanish, French, German, Italian, and Portuguese generic link patterns. More languages can be added through filters.

= Is it WCAG compliant? =

Yes, this plugin helps meet WCAG 2.1 Success Criterion 2.4.4 (Link Purpose in Context) - Level A requirement.

= Will this work with my theme and other plugins? =

Yes, the plugin uses WordPress standard filters and doesn't interfere with themes or other plugins. It processes content during the rendering phase.

= Does it affect site performance? =

The plugin is lightweight and highly optimized. It only processes content when rendered, with minimal performance impact.

= Can I customize which link patterns are detected? =

Yes, developers can use the `wplaf_generic_patterns` filter to add custom patterns. See documentation for details.

= Does it work with Gutenberg blocks? =

Yes, it works with all content types including Gutenberg blocks, Classic Editor, widgets, and custom post types.

= What assistive technologies does this support? =

Works with all major screen readers including JAWS, NVDA, VoiceOver, TalkBack, and Narrator.

= Can I disable the plugin on specific pages? =

Currently, the plugin works globally. Custom implementations can be done using WordPress conditional tags and filters.

= Is this a replacement for writing good link text? =

No, this is a helper tool. Best practice is always to write descriptive link text. This plugin helps improve existing content with generic links.

== Screenshots ==

1. Before and after comparison showing how generic links are enhanced
2. Example of aria-label added to generic link
3. Visually hidden text that screen readers can access
4. Multi-language support in action

== Changelog ==

= 1.0 =
* Initial release
* Automatic detection of generic links
* Multi-language support (EN, ES, FR, DE, IT, PT)
* Smart context extraction algorithm
* WCAG 2.1 compliance
* PSR-4 autoloading architecture
* Lightweight and performant

== Upgrade Notice ==

= 1.0 =
Initial release. Install to automatically improve link accessibility on your WordPress site.

== Privacy Policy ==

This plugin does not collect, store, or transmit any user data. It only processes content on your server during page rendering.

== Support ==

For bug reports, feature requests, or support questions:

* GitHub: Report an issue at https://github.com/cafalco96/wp-link-accessibility
* WordPress.org Support Forum

== Credits ==

Developed by Carlos Falconi
Website: https://cafalco96.github.io/

== Technical Details ==

**Architecture:**
* Object-oriented PHP with PSR-4 autoloading
* WordPress Coding Standards compliant
* Modular class structure
* Extensible via filters and actions

**Browser Compatibility:**
* All modern browsers
* Screen readers: JAWS, NVDA, VoiceOver, TalkBack, Narrator

== Contributing ==

Contributions are welcome! Visit the GitHub repository to submit pull requests or report issues.