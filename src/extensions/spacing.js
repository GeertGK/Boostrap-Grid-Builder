/**
 * Spacing Extension
 *
 * Voegt margin en padding controls toe aan ALLE Gutenberg blocks
 */

import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import {
    PanelBody,
    SelectControl,
    TabPanel,
} from '@wordpress/components';
import { Fragment } from '@wordpress/element';

// Haal settings op van PHP (wordt geladen via wp_localize_script)
const getSpacingSettings = () => {
    if ( typeof window !== 'undefined' && window.bootstrapGridSpacingSettings ) {
        return {
            marginMax: parseInt( window.bootstrapGridSpacingSettings.marginMax, 10 ) || 200,
            paddingMax: parseInt( window.bootstrapGridSpacingSettings.paddingMax, 10 ) || 200,
            step: parseInt( window.bootstrapGridSpacingSettings.step, 10 ) || 5,
        };
    }
    return {
        marginMax: 200,
        paddingMax: 200,
        step: 5,
    };
};

const spacingSettings = getSpacingSettings();

// Breakpoints
const BREAKPOINTS = [
    { name: 'xs', title: __( 'xs', 'bootstrap-grid-blocks' ), label: __( 'Mobiel', 'bootstrap-grid-blocks' ) },
    { name: 'sm', title: __( 'sm', 'bootstrap-grid-blocks' ), label: __( 'Small 576px+', 'bootstrap-grid-blocks' ) },
    { name: 'md', title: __( 'md', 'bootstrap-grid-blocks' ), label: __( 'Medium 768px+', 'bootstrap-grid-blocks' ) },
    { name: 'lg', title: __( 'lg', 'bootstrap-grid-blocks' ), label: __( 'Large 992px+', 'bootstrap-grid-blocks' ) },
    { name: 'xl', title: __( 'xl', 'bootstrap-grid-blocks' ), label: __( 'Extra Large 1200px+', 'bootstrap-grid-blocks' ) },
];

// Directions
const DIRECTIONS = [
    { key: 't', label: __( 'Top', 'bootstrap-grid-blocks' ) },
    { key: 'b', label: __( 'Bottom', 'bootstrap-grid-blocks' ) },
    { key: 's', label: __( 'Start (links)', 'bootstrap-grid-blocks' ) },
    { key: 'e', label: __( 'End (rechts)', 'bootstrap-grid-blocks' ) },
    { key: 'x', label: __( 'X (links + rechts)', 'bootstrap-grid-blocks' ) },
    { key: 'y', label: __( 'Y (boven + onder)', 'bootstrap-grid-blocks' ) },
];

/**
 * Genereer options voor SelectControl
 */
function generateOptions( maxValue, step ) {
    const options = [
        { label: __( 'Geen', 'bootstrap-grid-blocks' ), value: '' },
    ];

    // Zorg dat step minimaal 1 is om infinite loop te voorkomen
    const safeStep = Math.max( 1, step || 5 );
    const safeMax = Math.min( maxValue || 200, 500 ); // Max 500 als veiligheid

    for ( let i = 0; i <= safeMax; i += safeStep ) {
        options.push( {
            label: `${ i }px`,
            value: String( i ),
        } );
    }

    return options;
}

const marginOptions = generateOptions( spacingSettings.marginMax, spacingSettings.step );
const paddingOptions = generateOptions( spacingSettings.paddingMax, spacingSettings.step );

/**
 * Genereer attribute namen voor alle spacing opties
 */
function getSpacingAttributeNames() {
    const attrs = {};
    const types = [ 'margin', 'padding' ];
    const dirs = [ 't', 'b', 's', 'e', 'x', 'y' ];

    types.forEach( ( type ) => {
        const prefix = type === 'margin' ? 'm' : 'p';
        dirs.forEach( ( dir ) => {
            BREAKPOINTS.forEach( ( bp ) => {
                const attrName = `${ prefix }${ dir }${ bp.name.charAt( 0 ).toUpperCase() + bp.name.slice( 1 ) }`;
                attrs[ attrName ] = {
                    type: 'string',
                    default: '',
                };
            } );
        } );
    } );

    return attrs;
}

/**
 * Filter: Voeg spacing attributes toe aan alle blocks
 */
function addSpacingAttributes( settings, name ) {
    // Skip als settings of name niet bestaat
    if ( ! settings || ! name ) {
        return settings;
    }

    // Skip voor sommige core blocks waar het niet logisch is
    const skipBlocks = [
        'core/freeform',
        'core/html',
        'core/missing',
        'core/block',
    ];

    if ( skipBlocks.includes( name ) ) {
        return settings;
    }

    // Return nieuw object om immutability te behouden
    return {
        ...settings,
        attributes: {
            ...( settings.attributes || {} ),
            ...getSpacingAttributeNames(),
        },
    };
}

addFilter(
    'blocks.registerBlockType',
    'bootstrap-grid-blocks/spacing-attributes',
    addSpacingAttributes
);

/**
 * Bouw de class string op basis van de spacing attributes
 */
function buildSpacingClasses( attributes ) {
    const classes = [];
    const types = [ 'margin', 'padding' ];
    const dirs = [ 't', 'b', 's', 'e', 'x', 'y' ];

    types.forEach( ( type ) => {
        const prefix = type === 'margin' ? 'm' : 'p';
        dirs.forEach( ( dir ) => {
            BREAKPOINTS.forEach( ( bp ) => {
                const attrName = `${ prefix }${ dir }${ bp.name.charAt( 0 ).toUpperCase() + bp.name.slice( 1 ) }`;
                const value = attributes[ attrName ];

                if ( value !== undefined && value !== '' ) {
                    // Voor xs geen breakpoint suffix, voor andere wel
                    if ( bp.name === 'xs' ) {
                        classes.push( `${ prefix }${ dir }-${ value }` );
                    } else {
                        classes.push( `${ prefix }${ dir }-${ value }-${ bp.name }` );
                    }
                }
            } );
        } );
    } );

    return classes.join( ' ' );
}

/**
 * Component: Spacing controls voor een specifieke breakpoint
 */
function SpacingBreakpointControls( { type, breakpoint, attributes, setAttributes } ) {
    const prefix = type === 'margin' ? 'm' : 'p';
    const options = type === 'margin' ? marginOptions : paddingOptions;
    const bpKey = breakpoint.name.charAt( 0 ).toUpperCase() + breakpoint.name.slice( 1 );

    return (
        <div style={ { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '8px' } }>
            { DIRECTIONS.map( ( dir ) => {
                const attrName = `${ prefix }${ dir.key }${ bpKey }`;
                return (
                    <SelectControl
                        key={ dir.key }
                        label={ dir.label }
                        value={ attributes[ attrName ] || '' }
                        options={ options }
                        onChange={ ( value ) => setAttributes( { [ attrName ]: value } ) }
                        __nextHasNoMarginBottom
                    />
                );
            } ) }
        </div>
    );
}

/**
 * Component: Spacing panel (Margin of Padding)
 */
function SpacingPanel( { type, attributes, setAttributes } ) {
    const title = type === 'margin'
        ? __( 'Margin', 'bootstrap-grid-blocks' )
        : __( 'Padding', 'bootstrap-grid-blocks' );

    return (
        <PanelBody title={ title } initialOpen={ false }>
            <TabPanel
                className="bootstrap-grid-spacing-tabs"
                activeClass="is-active"
                tabs={ BREAKPOINTS.map( ( bp ) => ( {
                    name: bp.name,
                    title: bp.title,
                    className: `spacing-tab-${ bp.name }`,
                } ) ) }
            >
                { ( tab ) => {
                    const breakpoint = BREAKPOINTS.find( ( bp ) => bp.name === tab.name );
                    return (
                        <div style={ { paddingTop: '12px' } }>
                            <p style={ { fontSize: '12px', color: '#757575', marginBottom: '12px' } }>
                                { breakpoint.label }
                            </p>
                            <SpacingBreakpointControls
                                type={ type }
                                breakpoint={ breakpoint }
                                attributes={ attributes }
                                setAttributes={ setAttributes }
                            />
                        </div>
                    );
                } }
            </TabPanel>
        </PanelBody>
    );
}

/**
 * Filter: Voeg InspectorControls toe aan alle blocks
 */
const withSpacingControls = createHigherOrderComponent( ( BlockEdit ) => {
    return ( props ) => {
        // Skip als geen props of name
        if ( ! props || ! props.name ) {
            return <BlockEdit { ...props } />;
        }

        // Skip voor sommige blocks
        const skipBlocks = [
            'core/freeform',
            'core/html',
            'core/missing',
            'core/block',
        ];

        if ( skipBlocks.includes( props.name ) ) {
            return <BlockEdit { ...props } />;
        }

        const { attributes, setAttributes } = props;

        // Check of attributes en setAttributes bestaan
        if ( ! attributes || ! setAttributes ) {
            return <BlockEdit { ...props } />;
        }

        return (
            <Fragment>
                <BlockEdit { ...props } />
                <InspectorControls>
                    <SpacingPanel
                        type="margin"
                        attributes={ attributes }
                        setAttributes={ setAttributes }
                    />
                    <SpacingPanel
                        type="padding"
                        attributes={ attributes }
                        setAttributes={ setAttributes }
                    />
                </InspectorControls>
            </Fragment>
        );
    };
}, 'withSpacingControls' );

addFilter(
    'editor.BlockEdit',
    'bootstrap-grid-blocks/spacing-controls',
    withSpacingControls
);

/**
 * Filter: Voeg spacing classes toe aan de save output
 */
function addSpacingClasses( extraProps, blockType, attributes ) {
    // Skip als parameters ontbreken
    if ( ! extraProps || ! blockType || ! attributes ) {
        return extraProps;
    }

    // Skip voor sommige blocks
    const skipBlocks = [
        'core/freeform',
        'core/html',
        'core/missing',
        'core/block',
    ];

    if ( skipBlocks.includes( blockType.name ) ) {
        return extraProps;
    }

    const spacingClasses = buildSpacingClasses( attributes );

    if ( spacingClasses ) {
        return {
            ...extraProps,
            className: extraProps.className
                ? `${ extraProps.className } ${ spacingClasses }`
                : spacingClasses,
        };
    }

    return extraProps;
}

addFilter(
    'blocks.getSaveContent.extraProps',
    'bootstrap-grid-blocks/spacing-classes',
    addSpacingClasses
);
