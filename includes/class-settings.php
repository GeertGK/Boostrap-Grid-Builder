<?php
/**
 * Settings page for Bootstrap Grid Blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Bootstrap_Grid_Settings {

    /**
     * Default breakpoints
     */
    private $default_breakpoints = array(
        'sm' => array( 'value' => 576, 'unit' => 'px' ),
        'md' => array( 'value' => 768, 'unit' => 'px' ),
        'lg' => array( 'value' => 992, 'unit' => 'px' ),
        'xl' => array( 'value' => 1200, 'unit' => 'px' ),
    );

    /**
     * Default container max-widths
     */
    private $default_container_widths = array(
        'sm' => array( 'value' => 540, 'unit' => 'px' ),
        'md' => array( 'value' => 720, 'unit' => 'px' ),
        'lg' => array( 'value' => 960, 'unit' => 'px' ),
        'xl' => array( 'value' => 1140, 'unit' => 'px' ),
    );

    /**
     * Default grid settings
     */
    private $default_grid_settings = array(
        'columns'  => 12,
        'gutter_x' => array( 'value' => 1.5, 'unit' => 'rem' ),
    );

    /**
     * Default output settings
     */
    private $default_output_settings = array(
        'css_frontend' => true,
        'css_editor'   => true,
    );

    /**
     * Default spacing settings
     */
    private $default_spacing_settings = array(
        'margin_max'  => 200,
        'padding_max' => 200,
        'step'        => 5,
    );

    /**
     * Available units
     */
    private $available_units = array( 'px', 'rem', 'em', '%', 'vw', 'vh' );

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        // CSS wordt nu geladen via bootstrap-grid-blocks.php
    }

    /**
     * Add settings page to admin menu
     */
    public function add_settings_page() {
        add_options_page(
            __( 'Bootstrap Grid', 'bootstrap-grid-blocks' ),
            __( 'Bootstrap Grid', 'bootstrap-grid-blocks' ),
            'manage_options',
            'bootstrap-grid-settings',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting( 'bootstrap_grid_settings', 'bootstrap_grid_breakpoints', array(
            'type'              => 'array',
            'sanitize_callback' => array( $this, 'sanitize_breakpoints' ),
            'default'           => $this->default_breakpoints,
        ) );

        register_setting( 'bootstrap_grid_settings', 'bootstrap_grid_container_widths', array(
            'type'              => 'array',
            'sanitize_callback' => array( $this, 'sanitize_container_widths' ),
            'default'           => $this->default_container_widths,
        ) );

        register_setting( 'bootstrap_grid_settings', 'bootstrap_grid_settings', array(
            'type'              => 'array',
            'sanitize_callback' => array( $this, 'sanitize_grid_settings' ),
            'default'           => $this->default_grid_settings,
        ) );

        register_setting( 'bootstrap_grid_settings', 'bootstrap_grid_output_settings', array(
            'type'              => 'array',
            'sanitize_callback' => array( $this, 'sanitize_output_settings' ),
            'default'           => $this->default_output_settings,
        ) );

        register_setting( 'bootstrap_grid_settings', 'bootstrap_grid_spacing_settings', array(
            'type'              => 'array',
            'sanitize_callback' => array( $this, 'sanitize_spacing_settings' ),
            'default'           => $this->default_spacing_settings,
        ) );

        // Breakpoints section
        add_settings_section(
            'bootstrap_grid_breakpoints_section',
            __( 'Breakpoints', 'bootstrap-grid-blocks' ),
            array( $this, 'breakpoints_section_callback' ),
            'bootstrap-grid-settings'
        );

        // Container widths section
        add_settings_section(
            'bootstrap_grid_container_section',
            __( 'Container Max-Widths', 'bootstrap-grid-blocks' ),
            array( $this, 'container_section_callback' ),
            'bootstrap-grid-settings'
        );

        // Grid settings section
        add_settings_section(
            'bootstrap_grid_settings_section',
            __( 'Grid Instellingen', 'bootstrap-grid-blocks' ),
            array( $this, 'grid_section_callback' ),
            'bootstrap-grid-settings'
        );
    }

    /**
     * Sanitize breakpoints
     */
    public function sanitize_breakpoints( $input ) {
        $sanitized = array();
        foreach ( array( 'sm', 'md', 'lg', 'xl' ) as $bp ) {
            $sanitized[ $bp ] = array(
                'value' => isset( $input[ $bp ]['value'] ) ? floatval( $input[ $bp ]['value'] ) : $this->default_breakpoints[ $bp ]['value'],
                'unit'  => isset( $input[ $bp ]['unit'] ) && in_array( $input[ $bp ]['unit'], $this->available_units ) ? $input[ $bp ]['unit'] : 'px',
            );
        }
        return $sanitized;
    }

    /**
     * Sanitize container widths
     */
    public function sanitize_container_widths( $input ) {
        $sanitized = array();
        foreach ( array( 'sm', 'md', 'lg', 'xl' ) as $bp ) {
            $sanitized[ $bp ] = array(
                'value' => isset( $input[ $bp ]['value'] ) ? floatval( $input[ $bp ]['value'] ) : $this->default_container_widths[ $bp ]['value'],
                'unit'  => isset( $input[ $bp ]['unit'] ) && in_array( $input[ $bp ]['unit'], $this->available_units ) ? $input[ $bp ]['unit'] : 'px',
            );
        }
        return $sanitized;
    }

    /**
     * Sanitize grid settings
     */
    public function sanitize_grid_settings( $input ) {
        return array(
            'columns'  => isset( $input['columns'] ) ? absint( $input['columns'] ) : 12,
            'gutter_x' => array(
                'value' => isset( $input['gutter_x']['value'] ) ? floatval( $input['gutter_x']['value'] ) : 1.5,
                'unit'  => isset( $input['gutter_x']['unit'] ) && in_array( $input['gutter_x']['unit'], $this->available_units ) ? $input['gutter_x']['unit'] : 'rem',
            ),
        );
    }

    /**
     * Sanitize output settings
     */
    public function sanitize_output_settings( $input ) {
        return array(
            'css_frontend' => isset( $input['css_frontend'] ) ? (bool) $input['css_frontend'] : false,
            'css_editor'   => isset( $input['css_editor'] ) ? (bool) $input['css_editor'] : true,
        );
    }

    /**
     * Sanitize spacing settings
     */
    public function sanitize_spacing_settings( $input ) {
        return array(
            'margin_max'  => isset( $input['margin_max'] ) ? absint( $input['margin_max'] ) : 200,
            'padding_max' => isset( $input['padding_max'] ) ? absint( $input['padding_max'] ) : 200,
            'step'        => isset( $input['step'] ) ? absint( $input['step'] ) : 5,
        );
    }

    /**
     * Render unit select dropdown
     */
    private function render_unit_select( $name, $selected, $allowed_units = null ) {
        $units = $allowed_units ? $allowed_units : $this->available_units;
        $html = '<select name="' . esc_attr( $name ) . '" class="small-text">';
        foreach ( $units as $unit ) {
            $html .= '<option value="' . esc_attr( $unit ) . '"' . selected( $selected, $unit, false ) . '>' . esc_html( $unit ) . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    /**
     * Section callbacks
     */
    public function breakpoints_section_callback() {
        echo '<p>' . esc_html__( 'Definieer de breakpoints (in pixels) voor responsive kolommen.', 'bootstrap-grid-blocks' ) . '</p>';
    }

    public function container_section_callback() {
        echo '<p>' . esc_html__( 'Definieer de maximum breedte van de container per breakpoint (in pixels).', 'bootstrap-grid-blocks' ) . '</p>';
    }

    public function grid_section_callback() {
        echo '<p>' . esc_html__( 'Algemene grid instellingen.', 'bootstrap-grid-blocks' ) . '</p>';
    }

    /**
     * Get breakpoints (with migration for old format)
     */
    public function get_breakpoints() {
        $breakpoints = get_option( 'bootstrap_grid_breakpoints', $this->default_breakpoints );

        // Migrate old format (value only) to new format (value + unit)
        foreach ( array( 'sm', 'md', 'lg', 'xl' ) as $bp ) {
            if ( isset( $breakpoints[ $bp ] ) && ! is_array( $breakpoints[ $bp ] ) ) {
                $breakpoints[ $bp ] = array(
                    'value' => $breakpoints[ $bp ],
                    'unit'  => 'px',
                );
            }
        }

        return wp_parse_args( $breakpoints, $this->default_breakpoints );
    }

    /**
     * Get container widths (with migration for old format)
     */
    public function get_container_widths() {
        $widths = get_option( 'bootstrap_grid_container_widths', $this->default_container_widths );

        // Migrate old format (value only) to new format (value + unit)
        foreach ( array( 'sm', 'md', 'lg', 'xl' ) as $bp ) {
            if ( isset( $widths[ $bp ] ) && ! is_array( $widths[ $bp ] ) ) {
                $widths[ $bp ] = array(
                    'value' => $widths[ $bp ],
                    'unit'  => 'px',
                );
            }
        }

        return wp_parse_args( $widths, $this->default_container_widths );
    }

    /**
     * Get grid settings (with migration for old format)
     */
    public function get_grid_settings() {
        $settings = get_option( 'bootstrap_grid_settings', $this->default_grid_settings );

        // Migrate old format for gutter_x
        if ( isset( $settings['gutter_x'] ) && ! is_array( $settings['gutter_x'] ) ) {
            $settings['gutter_x'] = array(
                'value' => $settings['gutter_x'],
                'unit'  => 'rem',
            );
        }

        return wp_parse_args( $settings, $this->default_grid_settings );
    }

    /**
     * Get output settings
     */
    public function get_output_settings() {
        $settings = get_option( 'bootstrap_grid_output_settings', $this->default_output_settings );
        return wp_parse_args( $settings, $this->default_output_settings );
    }

    /**
     * Get spacing settings
     */
    public function get_spacing_settings() {
        $settings = get_option( 'bootstrap_grid_spacing_settings', $this->default_spacing_settings );
        return wp_parse_args( $settings, $this->default_spacing_settings );
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $breakpoints       = $this->get_breakpoints();
        $container_widths  = $this->get_container_widths();
        $grid_settings     = $this->get_grid_settings();
        $output_settings   = $this->get_output_settings();
        $spacing_settings  = $this->get_spacing_settings();
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

            <form action="options.php" method="post">
                <?php settings_fields( 'bootstrap_grid_settings' ); ?>

                <h2><?php esc_html_e( 'Breakpoints', 'bootstrap-grid-blocks' ); ?></h2>
                <p class="description"><?php esc_html_e( 'Minimum schermbreedte waarop elke breakpoint actief wordt.', 'bootstrap-grid-blocks' ); ?></p>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="bp_sm">Small (sm)</label></th>
                        <td>
                            <input type="number" id="bp_sm" name="bootstrap_grid_breakpoints[sm][value]" value="<?php echo esc_attr( $breakpoints['sm']['value'] ); ?>" class="small-text" step="any" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_breakpoints[sm][unit]', $breakpoints['sm']['unit'] ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bp_md">Medium (md)</label></th>
                        <td>
                            <input type="number" id="bp_md" name="bootstrap_grid_breakpoints[md][value]" value="<?php echo esc_attr( $breakpoints['md']['value'] ); ?>" class="small-text" step="any" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_breakpoints[md][unit]', $breakpoints['md']['unit'] ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bp_lg">Large (lg)</label></th>
                        <td>
                            <input type="number" id="bp_lg" name="bootstrap_grid_breakpoints[lg][value]" value="<?php echo esc_attr( $breakpoints['lg']['value'] ); ?>" class="small-text" step="any" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_breakpoints[lg][unit]', $breakpoints['lg']['unit'] ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bp_xl">Extra Large (xl)</label></th>
                        <td>
                            <input type="number" id="bp_xl" name="bootstrap_grid_breakpoints[xl][value]" value="<?php echo esc_attr( $breakpoints['xl']['value'] ); ?>" class="small-text" step="any" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_breakpoints[xl][unit]', $breakpoints['xl']['unit'] ); ?>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e( 'Container Max-Widths', 'bootstrap-grid-blocks' ); ?></h2>
                <p class="description"><?php esc_html_e( 'Maximum breedte van .container per breakpoint.', 'bootstrap-grid-blocks' ); ?></p>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="cw_sm">Small (sm)</label></th>
                        <td>
                            <input type="number" id="cw_sm" name="bootstrap_grid_container_widths[sm][value]" value="<?php echo esc_attr( $container_widths['sm']['value'] ); ?>" class="small-text" step="any" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_container_widths[sm][unit]', $container_widths['sm']['unit'] ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cw_md">Medium (md)</label></th>
                        <td>
                            <input type="number" id="cw_md" name="bootstrap_grid_container_widths[md][value]" value="<?php echo esc_attr( $container_widths['md']['value'] ); ?>" class="small-text" step="any" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_container_widths[md][unit]', $container_widths['md']['unit'] ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cw_lg">Large (lg)</label></th>
                        <td>
                            <input type="number" id="cw_lg" name="bootstrap_grid_container_widths[lg][value]" value="<?php echo esc_attr( $container_widths['lg']['value'] ); ?>" class="small-text" step="any" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_container_widths[lg][unit]', $container_widths['lg']['unit'] ); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cw_xl">Extra Large (xl)</label></th>
                        <td>
                            <input type="number" id="cw_xl" name="bootstrap_grid_container_widths[xl][value]" value="<?php echo esc_attr( $container_widths['xl']['value'] ); ?>" class="small-text" step="any" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_container_widths[xl][unit]', $container_widths['xl']['unit'] ); ?>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e( 'Grid Instellingen', 'bootstrap-grid-blocks' ); ?></h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="grid_columns">Aantal kolommen</label></th>
                        <td><input type="number" id="grid_columns" name="bootstrap_grid_settings[columns]" value="<?php echo esc_attr( $grid_settings['columns'] ); ?>" class="small-text" min="1" max="24" /></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="grid_gutter">Gutter</label></th>
                        <td>
                            <input type="number" id="grid_gutter" name="bootstrap_grid_settings[gutter_x][value]" value="<?php echo esc_attr( $grid_settings['gutter_x']['value'] ); ?>" class="small-text" step="0.125" min="0" />
                            <?php echo $this->render_unit_select( 'bootstrap_grid_settings[gutter_x][unit]', $grid_settings['gutter_x']['unit'] ); ?>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e( 'CSS Output', 'bootstrap-grid-blocks' ); ?></h2>
                <p class="description"><?php esc_html_e( 'Bepaal waar de grid CSS wordt geladen. Schakel frontend uit als je de CSS zelf in je SCSS insluit.', 'bootstrap-grid-blocks' ); ?></p>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e( 'CSS laden', 'bootstrap-grid-blocks' ); ?></th>
                        <td>
                            <fieldset>
                                <label for="css_frontend">
                                    <input type="checkbox" id="css_frontend" name="bootstrap_grid_output_settings[css_frontend]" value="1" <?php checked( $output_settings['css_frontend'], true ); ?> />
                                    <?php esc_html_e( 'CSS laden op frontend', 'bootstrap-grid-blocks' ); ?>
                                </label>
                                <p class="description"><?php esc_html_e( 'Schakel uit als je de grid CSS zelf in je thema SCSS insluit.', 'bootstrap-grid-blocks' ); ?></p>
                                <br />
                                <label for="css_editor">
                                    <input type="checkbox" id="css_editor" name="bootstrap_grid_output_settings[css_editor]" value="1" <?php checked( $output_settings['css_editor'], true ); ?> />
                                    <?php esc_html_e( 'CSS laden in editor', 'bootstrap-grid-blocks' ); ?>
                                </label>
                                <p class="description"><?php esc_html_e( 'Wordt aanbevolen voor correcte preview in de block editor.', 'bootstrap-grid-blocks' ); ?></p>
                            </fieldset>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e( 'Spacing Utilities', 'bootstrap-grid-blocks' ); ?></h2>
                <p class="description"><?php esc_html_e( 'Instellingen voor margin en padding utility classes (mt-10, pb-20, etc.).', 'bootstrap-grid-blocks' ); ?></p>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="margin_max"><?php esc_html_e( 'Max margin waarde', 'bootstrap-grid-blocks' ); ?></label></th>
                        <td>
                            <input type="number" id="margin_max" name="bootstrap_grid_spacing_settings[margin_max]" value="<?php echo esc_attr( $spacing_settings['margin_max'] ); ?>" class="small-text" min="0" max="500" /> px
                            <p class="description"><?php esc_html_e( 'Maximale waarde voor margin classes (bijv. mt-200).', 'bootstrap-grid-blocks' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="padding_max"><?php esc_html_e( 'Max padding waarde', 'bootstrap-grid-blocks' ); ?></label></th>
                        <td>
                            <input type="number" id="padding_max" name="bootstrap_grid_spacing_settings[padding_max]" value="<?php echo esc_attr( $spacing_settings['padding_max'] ); ?>" class="small-text" min="0" max="500" /> px
                            <p class="description"><?php esc_html_e( 'Maximale waarde voor padding classes (bijv. pt-200).', 'bootstrap-grid-blocks' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="spacing_step"><?php esc_html_e( 'Stap waarde', 'bootstrap-grid-blocks' ); ?></label></th>
                        <td>
                            <input type="number" id="spacing_step" name="bootstrap_grid_spacing_settings[step]" value="<?php echo esc_attr( $spacing_settings['step'] ); ?>" class="small-text" min="1" max="50" /> px
                            <p class="description"><?php esc_html_e( 'Stap tussen waardes (bijv. 5 geeft: 0, 5, 10, 15, 20...).', 'bootstrap-grid-blocks' ); ?></p>
                        </td>
                    </tr>
                </table>

                <?php submit_button( __( 'Instellingen opslaan', 'bootstrap-grid-blocks' ) ); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Generate dynamic CSS - matches bootstrap.scss logic exactly
     */
    public function generate_css() {
        $breakpoints       = $this->get_breakpoints();
        $container_widths  = $this->get_container_widths();
        $grid_settings     = $this->get_grid_settings();
        $spacing_settings  = $this->get_spacing_settings();

        $columns  = $grid_settings['columns'];
        $gutter_x = $grid_settings['gutter_x']['value'] . $grid_settings['gutter_x']['unit'];

        $css = "
/* Bootstrap Grid Blocks - Dynamic CSS */
/* Matches bootstrap.scss logic */

/* -------------------------------------
   CSS custom property: --container-width
   ------------------------------------- */
:root {
    --container-width: 100vw;
}

/* -------------------------------------
   Container
   ------------------------------------- */
.container {
    width: 100%;
    margin-right: auto;
    margin-left: auto;
    padding-right: calc({$gutter_x} * 0.5);
    padding-left: calc({$gutter_x} * 0.5);
}

.container-fluid {
    width: 100%;
    margin-right: auto;
    margin-left: auto;
    padding-right: calc({$gutter_x} * 0.5);
    padding-left: calc({$gutter_x} * 0.5);
}

/* -------------------------------------
   Rows & columns
   ------------------------------------- */
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: calc({$gutter_x} * -0.5);
    margin-left: calc({$gutter_x} * -0.5);
}

[class^=\"col-\"],
[class*=\" col-\"] {
    padding-right: calc({$gutter_x} * 0.5);
    padding-left: calc({$gutter_x} * 0.5);
}

.col {
    flex: 1 0 0;
    max-width: 100%;
}

/* -------------------------------------
   Bleed helpers base
   ------------------------------------- */
.col-bleed-left,
.col-bleed-right {
    position: relative;
}

/* -------------------------------------
   Flex utilities
   ------------------------------------- */
.d-flex { display: flex; }
.d-none { display: none; }
.d-block { display: block; }
.justify-content-start { justify-content: flex-start; }
.justify-content-end { justify-content: flex-end; }
.justify-content-center { justify-content: center; }
.justify-content-between { justify-content: space-between; }
.align-items-start { align-items: flex-start; }
.align-items-end { align-items: flex-end; }
.align-items-center { align-items: center; }
.align-content-center { align-content: center; }

/* -------------------------------------
   Mobile-first columns (xs - no breakpoint infix)
   ------------------------------------- */
";

        // Mobile-first columns (xs - no media query)
        for ( $i = 1; $i <= $columns; $i++ ) {
            $width = ( $i / $columns ) * 100;
            $css .= ".col-{$i} { flex: 0 0 {$width}%; max-width: {$width}%; }\n";
        }
        $css .= ".col-auto { flex: 0 0 auto; max-width: 100%; }\n";

        // Mobile offsets
        $css .= "\n/* Offsets (xs) */\n";
        $css .= ".offset-0 { margin-left: 0; }\n";
        for ( $i = 1; $i <= $columns; $i++ ) {
            $offset = ( $i / $columns ) * 100;
            $css .= ".offset-{$i} { margin-left: {$offset}%; }\n";
        }

        // Bleed for mobile (xs)
        $css .= "\n/* Bleed helpers (xs) */\n";
        for ( $i = 1; $i <= $columns; $i++ ) {
            $width = ( $i / $columns ) * 100;
            $css .= ".col-{$i}.col-bleed-left {
    flex: 0 0 auto;
    max-width: none;
    width: calc({$width}% + (100vw - var(--container-width)) / 2);
    margin-left: calc((var(--container-width) - 100vw) / 2);
}
.col-{$i}.col-bleed-right {
    flex: 0 0 auto;
    max-width: none;
    width: calc({$width}% + (100vw - var(--container-width)) / 2);
    margin-right: calc((var(--container-width) - 100vw) / 2);
}\n";
        }

        // Responsive breakpoints
        $bp_order = array( 'sm', 'md', 'lg', 'xl' );

        foreach ( $bp_order as $bp ) {
            $min_width_value = $breakpoints[ $bp ]['value'];
            $min_width_unit  = $breakpoints[ $bp ]['unit'];
            $max_width_value = $container_widths[ $bp ]['value'];
            $max_width_unit  = $container_widths[ $bp ]['unit'];

            $css .= "\n/* -------------------------------------\n";
            $css .= "   {$bp} breakpoint ({$min_width_value}{$min_width_unit}+)\n";
            $css .= "   ------------------------------------- */\n";
            $css .= "@media (min-width: {$min_width_value}{$min_width_unit}) {\n\n";

            // Container width CSS variable and max-width
            $css .= "    :root { --container-width: {$max_width_value}{$max_width_unit}; }\n";
            $css .= "    .container { max-width: {$max_width_value}{$max_width_unit}; }\n\n";

            // Columns
            $css .= "    /* Columns ({$bp}) */\n";
            for ( $i = 1; $i <= $columns; $i++ ) {
                $width = ( $i / $columns ) * 100;
                $css .= "    .col-{$bp}-{$i} { flex: 0 0 {$width}%; max-width: {$width}%; }\n";
            }
            $css .= "    .col-{$bp}-auto { flex: 0 0 auto; max-width: 100%; }\n\n";

            // Offsets
            $css .= "    /* Offsets ({$bp}) */\n";
            $css .= "    .offset-{$bp}-0 { margin-left: 0; }\n";
            for ( $i = 1; $i <= $columns; $i++ ) {
                $offset = ( $i / $columns ) * 100;
                $css .= "    .offset-{$bp}-{$i} { margin-left: {$offset}%; }\n";
            }

            // Bleed per breakpoint - exact match met SCSS logica
            $css .= "\n    /* Bleed helpers ({$bp}) */\n";
            for ( $i = 1; $i <= $columns; $i++ ) {
                $width = ( $i / $columns ) * 100;

                // col-{bp}-{i}.col-bleed-left
                $css .= "    .col-{$bp}-{$i}.col-bleed-left {
        flex: 0 0 auto;
        max-width: none;
        width: calc({$width}% + (100vw - var(--container-width)) / 2);
        margin-left: calc((var(--container-width) - 100vw) / 2);
    }\n";

                // col-{bp}-{i}.col-bleed-{bp}-left (breakpoint-specific bleed class)
                $css .= "    .col-{$bp}-{$i}.col-bleed-{$bp}-left {
        flex: 0 0 auto;
        max-width: none;
        width: calc({$width}% + (100vw - var(--container-width)) / 2);
        margin-left: calc((var(--container-width) - 100vw) / 2);
    }\n";

                // col-{bp}-{i}.col-bleed-right
                $css .= "    .col-{$bp}-{$i}.col-bleed-right {
        flex: 0 0 auto;
        max-width: none;
        width: calc({$width}% + (100vw - var(--container-width)) / 2);
        margin-right: calc((var(--container-width) - 100vw) / 2);
    }\n";

                // col-{bp}-{i}.col-bleed-{bp}-right (breakpoint-specific bleed class)
                $css .= "    .col-{$bp}-{$i}.col-bleed-{$bp}-right {
        flex: 0 0 auto;
        max-width: none;
        width: calc({$width}% + (100vw - var(--container-width)) / 2);
        margin-right: calc((var(--container-width) - 100vw) / 2);
    }\n";
            }

            // Display utilities per breakpoint
            $css .= "\n    /* Display utilities ({$bp}) */\n";
            $css .= "    .d-{$bp}-flex { display: flex; }\n";
            $css .= "    .d-{$bp}-none { display: none; }\n";
            $css .= "    .d-{$bp}-block { display: block; }\n";

            $css .= "}\n";
        }

        // Spacing utilities (margin & padding)
        $css .= $this->generate_spacing_css();

        return $css;
    }

    /**
     * Generate spacing utility CSS (margin & padding)
     */
    private function generate_spacing_css() {
        $spacing_settings = $this->get_spacing_settings();
        $breakpoints      = $this->get_breakpoints();

        $margin_max  = $spacing_settings['margin_max'];
        $padding_max = $spacing_settings['padding_max'];
        $step        = max( 1, $spacing_settings['step'] );

        $css = "\n/* -------------------------------------\n";
        $css .= "   Spacing Utilities (Margin & Padding)\n";
        $css .= "   ------------------------------------- */\n";

        // Margin directions: t(op), b(ottom), s(tart/left), e(nd/right), x, y
        $margin_props = array(
            't' => 'margin-top',
            'b' => 'margin-bottom',
            's' => 'margin-left',
            'e' => 'margin-right',
        );

        // Padding directions
        $padding_props = array(
            't' => 'padding-top',
            'b' => 'padding-bottom',
            's' => 'padding-left',
            'e' => 'padding-right',
        );

        // Mobile-first (no breakpoint infix)
        $css .= "\n/* Margin (xs) */\n";
        for ( $i = 0; $i <= $margin_max; $i += $step ) {
            foreach ( $margin_props as $dir => $prop ) {
                $css .= ".m{$dir}-{$i} { {$prop}: {$i}px; }\n";
            }
            // X (left + right) and Y (top + bottom)
            $css .= ".mx-{$i} { margin-left: {$i}px; margin-right: {$i}px; }\n";
            $css .= ".my-{$i} { margin-top: {$i}px; margin-bottom: {$i}px; }\n";
        }

        $css .= "\n/* Padding (xs) */\n";
        for ( $i = 0; $i <= $padding_max; $i += $step ) {
            foreach ( $padding_props as $dir => $prop ) {
                $css .= ".p{$dir}-{$i} { {$prop}: {$i}px; }\n";
            }
            // X (left + right) and Y (top + bottom)
            $css .= ".px-{$i} { padding-left: {$i}px; padding-right: {$i}px; }\n";
            $css .= ".py-{$i} { padding-top: {$i}px; padding-bottom: {$i}px; }\n";
        }

        // Responsive breakpoints
        $bp_order = array( 'sm', 'md', 'lg', 'xl' );

        foreach ( $bp_order as $bp ) {
            $min_width_value = $breakpoints[ $bp ]['value'];
            $min_width_unit  = $breakpoints[ $bp ]['unit'];

            $css .= "\n@media (min-width: {$min_width_value}{$min_width_unit}) {\n";

            // Margin for this breakpoint
            $css .= "    /* Margin ({$bp}) */\n";
            for ( $i = 0; $i <= $margin_max; $i += $step ) {
                foreach ( $margin_props as $dir => $prop ) {
                    $css .= "    .m{$dir}-{$i}-{$bp} { {$prop}: {$i}px; }\n";
                }
                $css .= "    .mx-{$i}-{$bp} { margin-left: {$i}px; margin-right: {$i}px; }\n";
                $css .= "    .my-{$i}-{$bp} { margin-top: {$i}px; margin-bottom: {$i}px; }\n";
            }

            // Padding for this breakpoint
            $css .= "\n    /* Padding ({$bp}) */\n";
            for ( $i = 0; $i <= $padding_max; $i += $step ) {
                foreach ( $padding_props as $dir => $prop ) {
                    $css .= "    .p{$dir}-{$i}-{$bp} { {$prop}: {$i}px; }\n";
                }
                $css .= "    .px-{$i}-{$bp} { padding-left: {$i}px; padding-right: {$i}px; }\n";
                $css .= "    .py-{$i}-{$bp} { padding-top: {$i}px; padding-bottom: {$i}px; }\n";
            }

            $css .= "}\n";
        }

        return $css;
    }

    /**
     * Output dynamic CSS in head
     */
    public function output_dynamic_css() {
        echo '<style id="bootstrap-grid-dynamic-css">' . $this->generate_css() . '</style>';
    }

    /**
     * Enqueue grid styles for both editor and frontend
     */
    public function enqueue_grid_styles() {
        $css = $this->generate_css();
        wp_register_style( 'bootstrap-grid-dynamic', false );
        wp_enqueue_style( 'bootstrap-grid-dynamic' );
        wp_add_inline_style( 'bootstrap-grid-dynamic', $css );
    }
}

// Initialize
new Bootstrap_Grid_Settings();
