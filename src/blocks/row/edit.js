import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InnerBlocks,
    InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';

const JUSTIFY_OPTIONS = [
    { label: __( 'Standaard', 'bootstrap-grid-blocks' ), value: '' },
    { label: __( 'Start', 'bootstrap-grid-blocks' ), value: 'justify-content-start' },
    { label: __( 'Center', 'bootstrap-grid-blocks' ), value: 'justify-content-center' },
    { label: __( 'End', 'bootstrap-grid-blocks' ), value: 'justify-content-end' },
    { label: __( 'Space Between', 'bootstrap-grid-blocks' ), value: 'justify-content-between' },
];

const ALIGN_OPTIONS = [
    { label: __( 'Standaard', 'bootstrap-grid-blocks' ), value: '' },
    { label: __( 'Start (boven)', 'bootstrap-grid-blocks' ), value: 'align-items-start' },
    { label: __( 'Center (midden)', 'bootstrap-grid-blocks' ), value: 'align-items-center' },
    { label: __( 'End (onder)', 'bootstrap-grid-blocks' ), value: 'align-items-end' },
];

export default function Edit( { attributes, setAttributes } ) {
    const { justifyContent, alignItems } = attributes;

    const classes = [ 'row', justifyContent, alignItems ].filter( Boolean ).join( ' ' );

    const blockProps = useBlockProps( {
        className: classes,
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Row instellingen', 'bootstrap-grid-blocks' ) }>
                    <SelectControl
                        label={ __( 'Horizontale uitlijning', 'bootstrap-grid-blocks' ) }
                        value={ justifyContent }
                        options={ JUSTIFY_OPTIONS }
                        onChange={ ( value ) => setAttributes( { justifyContent: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Verticale uitlijning', 'bootstrap-grid-blocks' ) }
                        value={ alignItems }
                        options={ ALIGN_OPTIONS }
                        onChange={ ( value ) => setAttributes( { alignItems: value } ) }
                    />
                </PanelBody>
            </InspectorControls>
            <div { ...blockProps }>
                <InnerBlocks />
            </div>
        </>
    );
}
