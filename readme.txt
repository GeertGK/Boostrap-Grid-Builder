=== Bootstrap Grid Blocks ===
Contributors: samuelstudios
Tags: bootstrap, grid, gutenberg, blocks, columns, margin, padding, spacing
Requires at least: 6.0
Tested up to: 6.4
Stable tag: 1.0.3
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Gutenberg blocks for a custom Bootstrap grid system with container, row and responsive columns. Includes margin and padding utilities for all blocks.

== Description ==

This plugin adds three Gutenberg blocks for the Bootstrap grid system:

= Container =
* Normal container with max-width per breakpoint
* Fluid option for full width

= Row =
* Flex container for columns
* Horizontal alignment (justify-content)
* Vertical alignment (align-items)

= Column =
* Responsive column widths (1-12) per breakpoint:
  * Mobile (xs)
  * Small (sm) 576px+
  * Medium (md) 768px+
  * Large (lg) 992px+
  * Extra Large (xl) 1200px+
* Offset per breakpoint
* Bleed options (left/right) per breakpoint

= Spacing Utilities =
* Margin and padding controls for ALL Gutenberg blocks
* Responsive per breakpoint (xs, sm, md, lg, xl)
* Configurable max value and step in settings

= Settings =
Via Settings > Bootstrap Grid you can configure:
* Breakpoints
* Container max-widths
* Number of columns and gutter
* Spacing utilities (max value, step)
* CSS output on/off

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The blocks are now available under the "Bootstrap Grid" category
4. Configure settings via Settings > Bootstrap Grid

== Development ==

1. `npm install` - Install dependencies
2. `npm run start` - Start development mode
3. `npm run build` - Build for production

== Changelog ==

= 1.0.3 =
* Added GitHub Actions release workflow for consistent zip packaging
* Added spacing preview in block editor
* Updated all documentation to English

= 1.0.1 =
* Updated author information

= 1.0.0 =
* Initial release
* Container block with fluid option
* Row block with flex options
* Column block with responsive widths, offsets and bleed
* Margin and padding utilities for all blocks
* Configurable settings page
* CSS output toggle for frontend/editor

== Credits ==

Developed by Samuel Studios
https://samuelstudios.nl
