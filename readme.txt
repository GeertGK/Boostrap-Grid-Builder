=== Bootstrap Grid Blocks ===
Contributors: geertklaucke, samuelstudios
Tags: bootstrap, grid, gutenberg, blocks, columns, margin, padding, spacing
Requires at least: 6.0
Tested up to: 6.4
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Gutenberg blocks voor een custom Bootstrap grid systeem met container, row en responsive kolommen. Inclusief margin en padding utilities voor alle blocks.

== Description ==

Deze plugin voegt drie Gutenberg blocks toe voor het Bootstrap grid systeem:

= Container =
* Normale container met max-width per breakpoint
* Fluid optie voor volledige breedte

= Row =
* Flex container voor kolommen
* Horizontale uitlijning (justify-content)
* Verticale uitlijning (align-items)

= Column =
* Responsive kolom breedtes (1-12) per breakpoint:
  * Mobiel (xs)
  * Small (sm) 576px+
  * Medium (md) 768px+
  * Large (lg) 992px+
  * Extra Large (xl) 1200px+
* Offset per breakpoint
* Bleed opties (links/rechts) per breakpoint

= Spacing Utilities =
* Margin en padding controls voor ALLE Gutenberg blocks
* Responsive per breakpoint (xs, sm, md, lg, xl)
* Configureerbare max waarde en stap in settings

= Settings =
Via Instellingen > Bootstrap Grid kun je configureren:
* Breakpoints
* Container max-widths
* Aantal kolommen en gutter
* Spacing utilities (max waarde, stap)
* CSS output aan/uit

== Installation ==

1. Upload de plugin map naar `/wp-content/plugins/`
2. Activeer de plugin via het 'Plugins' menu in WordPress
3. De blocks zijn nu beschikbaar onder de categorie "Bootstrap Grid"
4. Configureer de settings via Instellingen > Bootstrap Grid

== Development ==

1. `npm install` - Installeer dependencies
2. `npm run start` - Start development mode
3. `npm run build` - Bouw voor productie

== Changelog ==

= 1.0.0 =
* Eerste release
* Container block met fluid optie
* Row block met flex opties
* Column block met responsive breedtes, offsets en bleed
* Margin en padding utilities voor alle blocks
* Configureerbare settings pagina
* CSS output toggle voor frontend/editor

== Credits ==

Ontwikkeld door Geert Klaucke / Samuel Studios
https://samuelstudios.nl
