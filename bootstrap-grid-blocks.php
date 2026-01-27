<?php
/**
 * Plugin Name:       Bootstrap Grid Blocks
 * Plugin URI:        https://samuelstudios.nl
 * Description:       Gutenberg blocks voor Bootstrap grid: Container, Row en Column met responsive breakpoints, offsets en bleed opties.
 * Version:           1.0.0
 * Author:            Geert Klaucke / Samuel Studios
 * Author URI:        https://samuelstudios.nl
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       bootstrap-grid-blocks
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Requires PHP:      7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BOOTSTRAP_GRID_BLOCKS_VERSION', '1.0.0' );
define( 'BOOTSTRAP_GRID_BLOCKS_PATH', plugin_dir_path( __FILE__ ) );
define( 'BOOTSTRAP_GRID_BLOCKS_URL', plugin_dir_url( __FILE__ ) );

/**
 * Laad settings class
 */
require_once BOOTSTRAP_GRID_BLOCKS_PATH . 'includes/class-settings.php';

/**
 * Plugin Update Checker - Automatische updates via GitHub
 */
require_once BOOTSTRAP_GRID_BLOCKS_PATH . 'includes/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$bootstrap_grid_update_checker = PucFactory::buildUpdateChecker(
    'https://github.com/GeertGK/Boostrap-Grid-Builder/',
    __FILE__,
    'bootstrap-grid-blocks'
);

// Gebruik releases als bron voor updates
$bootstrap_grid_update_checker->getVcsApi()->enableReleaseAssets();

/**
 * Registreer de blocks
 */
function bootstrap_grid_blocks_init() {
    // Container block
    register_block_type( BOOTSTRAP_GRID_BLOCKS_PATH . 'build/blocks/container' );

    // Row block
    register_block_type( BOOTSTRAP_GRID_BLOCKS_PATH . 'build/blocks/row' );

    // Column block
    register_block_type( BOOTSTRAP_GRID_BLOCKS_PATH . 'build/blocks/column' );
}
add_action( 'init', 'bootstrap_grid_blocks_init' );

/**
 * Voeg block categorie toe
 */
function bootstrap_grid_blocks_category( $categories ) {
    return array_merge(
        array(
            array(
                'slug'  => 'bootstrap-grid',
                'title' => __( 'Bootstrap Grid', 'bootstrap-grid-blocks' ),
                'icon'  => 'grid-view',
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', 'bootstrap_grid_blocks_category', 10, 1 );

/**
 * Laad editor admin styles (toolbar, sidebar, etc.)
 */
function bootstrap_grid_blocks_editor_assets() {
    wp_enqueue_style(
        'bootstrap-grid-blocks-editor',
        BOOTSTRAP_GRID_BLOCKS_URL . 'build/editor.css',
        array(),
        BOOTSTRAP_GRID_BLOCKS_VERSION
    );

    // Spacing extension - alleen laden als bestand bestaat
    $spacing_asset_file = BOOTSTRAP_GRID_BLOCKS_PATH . 'build/extensions/spacing.asset.php';

    if ( file_exists( $spacing_asset_file ) ) {
        $spacing_asset = include $spacing_asset_file;

        // Geef spacing settings door aan JavaScript VOOR het script laden
        $settings = new Bootstrap_Grid_Settings();
        $spacing_settings = $settings->get_spacing_settings();

        wp_register_script(
            'bootstrap-grid-blocks-spacing',
            BOOTSTRAP_GRID_BLOCKS_URL . 'build/extensions/spacing.js',
            array_merge( $spacing_asset['dependencies'], array( 'wp-blocks', 'wp-dom-ready' ) ),
            $spacing_asset['version'],
            false // Laden in header, niet footer
        );

        wp_localize_script(
            'bootstrap-grid-blocks-spacing',
            'bootstrapGridSpacingSettings',
            array(
                'marginMax'  => intval( $spacing_settings['margin_max'] ),
                'paddingMax' => intval( $spacing_settings['padding_max'] ),
                'step'       => intval( $spacing_settings['step'] ),
            )
        );

        wp_enqueue_script( 'bootstrap-grid-blocks-spacing' );
    }
}
add_action( 'enqueue_block_editor_assets', 'bootstrap_grid_blocks_editor_assets' );

/**
 * Laad grid CSS in zowel frontend als editor iframe
 * enqueue_block_assets laadt CSS in de editor iframe (content area)
 */
function bootstrap_grid_blocks_grid_styles() {
    $settings        = new Bootstrap_Grid_Settings();
    $output_settings = $settings->get_output_settings();

    // Check of we CSS moeten laden
    $is_admin = is_admin();
    $load_css = ( $is_admin && $output_settings['css_editor'] ) || ( ! $is_admin && $output_settings['css_frontend'] );

    if ( ! $load_css ) {
        return;
    }

    // Registreer een lege style handle
    wp_register_style( 'bootstrap-grid-blocks-grid', false );
    wp_enqueue_style( 'bootstrap-grid-blocks-grid' );

    // Voeg dynamische grid CSS toe
    $css = $settings->generate_css();

    // Voeg editor-specifieke overrides toe (alleen in admin)
    if ( $is_admin ) {
        $css .= "
/* Editor-specifieke styling */
.editor-styles-wrapper .row,
.editor-styles-wrapper .wp-block-bootstrap-grid-row {
    display: flex !important;
    flex-wrap: wrap !important;
}
.editor-styles-wrapper .wp-block-bootstrap-grid-row > .block-editor-inner-blocks,
.editor-styles-wrapper .wp-block-bootstrap-grid-row > .block-editor-inner-blocks > .block-editor-block-list__layout {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
}
";
    }

    wp_add_inline_style( 'bootstrap-grid-blocks-grid', $css );
}
add_action( 'enqueue_block_assets', 'bootstrap_grid_blocks_grid_styles' );
