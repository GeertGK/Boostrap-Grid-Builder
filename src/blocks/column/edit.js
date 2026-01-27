import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InnerBlocks,
    InspectorControls,
} from '@wordpress/block-editor';
import {
    PanelBody,
    SelectControl,
    ToggleControl,
    __experimentalDivider as Divider,
} from '@wordpress/components';
import { buildColumnClasses } from './utils';

const COL_OPTIONS = [
    { label: __( 'Geen', 'bootstrap-grid-blocks' ), value: '' },
    { label: '1', value: '1' },
    { label: '2', value: '2' },
    { label: '3', value: '3' },
    { label: '4', value: '4' },
    { label: '5', value: '5' },
    { label: '6', value: '6' },
    { label: '7', value: '7' },
    { label: '8', value: '8' },
    { label: '9', value: '9' },
    { label: '10', value: '10' },
    { label: '11', value: '11' },
    { label: '12', value: '12' },
    { label: 'Auto', value: 'auto' },
];

const COL_OPTIONS_DEFAULT = [
    { label: '1', value: 1 },
    { label: '2', value: 2 },
    { label: '3', value: 3 },
    { label: '4', value: 4 },
    { label: '5', value: 5 },
    { label: '6', value: 6 },
    { label: '7', value: 7 },
    { label: '8', value: 8 },
    { label: '9', value: 9 },
    { label: '10', value: 10 },
    { label: '11', value: 11 },
    { label: '12', value: 12 },
];

const OFFSET_OPTIONS = [
    { label: __( 'Geen', 'bootstrap-grid-blocks' ), value: '' },
    { label: '0', value: '0' },
    { label: '1', value: '1' },
    { label: '2', value: '2' },
    { label: '3', value: '3' },
    { label: '4', value: '4' },
    { label: '5', value: '5' },
    { label: '6', value: '6' },
    { label: '7', value: '7' },
    { label: '8', value: '8' },
    { label: '9', value: '9' },
    { label: '10', value: '10' },
    { label: '11', value: '11' },
];

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
    const {
        colDefault,
        colSm,
        colMd,
        colLg,
        colXl,
        offsetDefault,
        offsetSm,
        offsetMd,
        offsetLg,
        offsetXl,
        bleedLeft,
        bleedRight,
        bleedLeftSm,
        bleedRightSm,
        bleedLeftMd,
        bleedRightMd,
        bleedLeftLg,
        bleedRightLg,
        bleedLeftXl,
        bleedRightXl,
        justifyContent,
        alignItems,
    } = attributes;

    const columnClasses = buildColumnClasses( attributes );

    const blockProps = useBlockProps( {
        className: columnClasses,
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Kolom breedte', 'bootstrap-grid-blocks' ) } initialOpen={ true }>
                    <SelectControl
                        label={ __( 'Mobiel (xs)', 'bootstrap-grid-blocks' ) }
                        value={ colDefault }
                        options={ COL_OPTIONS_DEFAULT }
                        onChange={ ( value ) => setAttributes( { colDefault: parseInt( value ) } ) }
                        help={ __( 'Basis kolom breedte', 'bootstrap-grid-blocks' ) }
                    />
                    <SelectControl
                        label={ __( 'Small (sm) 576px+', 'bootstrap-grid-blocks' ) }
                        value={ colSm }
                        options={ COL_OPTIONS }
                        onChange={ ( value ) => setAttributes( { colSm: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Medium (md) 768px+', 'bootstrap-grid-blocks' ) }
                        value={ colMd }
                        options={ COL_OPTIONS }
                        onChange={ ( value ) => setAttributes( { colMd: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Large (lg) 992px+', 'bootstrap-grid-blocks' ) }
                        value={ colLg }
                        options={ COL_OPTIONS }
                        onChange={ ( value ) => setAttributes( { colLg: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Extra Large (xl) 1200px+', 'bootstrap-grid-blocks' ) }
                        value={ colXl }
                        options={ COL_OPTIONS }
                        onChange={ ( value ) => setAttributes( { colXl: value } ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Offset', 'bootstrap-grid-blocks' ) } initialOpen={ false }>
                    <SelectControl
                        label={ __( 'Mobiel (xs)', 'bootstrap-grid-blocks' ) }
                        value={ offsetDefault }
                        options={ OFFSET_OPTIONS }
                        onChange={ ( value ) => setAttributes( { offsetDefault: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Small (sm) 576px+', 'bootstrap-grid-blocks' ) }
                        value={ offsetSm }
                        options={ OFFSET_OPTIONS }
                        onChange={ ( value ) => setAttributes( { offsetSm: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Medium (md) 768px+', 'bootstrap-grid-blocks' ) }
                        value={ offsetMd }
                        options={ OFFSET_OPTIONS }
                        onChange={ ( value ) => setAttributes( { offsetMd: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Large (lg) 992px+', 'bootstrap-grid-blocks' ) }
                        value={ offsetLg }
                        options={ OFFSET_OPTIONS }
                        onChange={ ( value ) => setAttributes( { offsetLg: value } ) }
                    />
                    <SelectControl
                        label={ __( 'Extra Large (xl) 1200px+', 'bootstrap-grid-blocks' ) }
                        value={ offsetXl }
                        options={ OFFSET_OPTIONS }
                        onChange={ ( value ) => setAttributes( { offsetXl: value } ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Bleed opties', 'bootstrap-grid-blocks' ) } initialOpen={ false }>
                    <p style={ { fontSize: '12px', color: '#757575', marginBottom: '1rem' } }>
                        { __( 'Bleed laat de kolom doorlopen tot de rand van het scherm.', 'bootstrap-grid-blocks' ) }
                    </p>

                    <strong>{ __( 'Mobiel (xs)', 'bootstrap-grid-blocks' ) }</strong>
                    <ToggleControl
                        label={ __( 'Bleed links', 'bootstrap-grid-blocks' ) }
                        checked={ bleedLeft }
                        onChange={ ( value ) => setAttributes( { bleedLeft: value } ) }
                    />
                    <ToggleControl
                        label={ __( 'Bleed rechts', 'bootstrap-grid-blocks' ) }
                        checked={ bleedRight }
                        onChange={ ( value ) => setAttributes( { bleedRight: value } ) }
                    />

                    <Divider />

                    <strong>{ __( 'Small (sm) 576px+', 'bootstrap-grid-blocks' ) }</strong>
                    <ToggleControl
                        label={ __( 'Bleed links', 'bootstrap-grid-blocks' ) }
                        checked={ bleedLeftSm }
                        onChange={ ( value ) => setAttributes( { bleedLeftSm: value } ) }
                    />
                    <ToggleControl
                        label={ __( 'Bleed rechts', 'bootstrap-grid-blocks' ) }
                        checked={ bleedRightSm }
                        onChange={ ( value ) => setAttributes( { bleedRightSm: value } ) }
                    />

                    <Divider />

                    <strong>{ __( 'Medium (md) 768px+', 'bootstrap-grid-blocks' ) }</strong>
                    <ToggleControl
                        label={ __( 'Bleed links', 'bootstrap-grid-blocks' ) }
                        checked={ bleedLeftMd }
                        onChange={ ( value ) => setAttributes( { bleedLeftMd: value } ) }
                    />
                    <ToggleControl
                        label={ __( 'Bleed rechts', 'bootstrap-grid-blocks' ) }
                        checked={ bleedRightMd }
                        onChange={ ( value ) => setAttributes( { bleedRightMd: value } ) }
                    />

                    <Divider />

                    <strong>{ __( 'Large (lg) 992px+', 'bootstrap-grid-blocks' ) }</strong>
                    <ToggleControl
                        label={ __( 'Bleed links', 'bootstrap-grid-blocks' ) }
                        checked={ bleedLeftLg }
                        onChange={ ( value ) => setAttributes( { bleedLeftLg: value } ) }
                    />
                    <ToggleControl
                        label={ __( 'Bleed rechts', 'bootstrap-grid-blocks' ) }
                        checked={ bleedRightLg }
                        onChange={ ( value ) => setAttributes( { bleedRightLg: value } ) }
                    />

                    <Divider />

                    <strong>{ __( 'Extra Large (xl) 1200px+', 'bootstrap-grid-blocks' ) }</strong>
                    <ToggleControl
                        label={ __( 'Bleed links', 'bootstrap-grid-blocks' ) }
                        checked={ bleedLeftXl }
                        onChange={ ( value ) => setAttributes( { bleedLeftXl: value } ) }
                    />
                    <ToggleControl
                        label={ __( 'Bleed rechts', 'bootstrap-grid-blocks' ) }
                        checked={ bleedRightXl }
                        onChange={ ( value ) => setAttributes( { bleedRightXl: value } ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Uitlijning', 'bootstrap-grid-blocks' ) } initialOpen={ false }>
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
