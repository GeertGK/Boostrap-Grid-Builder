import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InnerBlocks,
    InspectorControls,
} from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
    const { isFluid } = attributes;

    const blockProps = useBlockProps( {
        className: isFluid ? 'container-fluid' : 'container',
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Container instellingen', 'bootstrap-grid-blocks' ) }>
                    <ToggleControl
                        label={ __( 'Fluid (volledige breedte)', 'bootstrap-grid-blocks' ) }
                        checked={ isFluid }
                        onChange={ ( value ) => setAttributes( { isFluid: value } ) }
                        help={ isFluid
                            ? __( 'Container neemt volledige breedte in', 'bootstrap-grid-blocks' )
                            : __( 'Container heeft max-width per breakpoint', 'bootstrap-grid-blocks' )
                        }
                    />
                </PanelBody>
            </InspectorControls>
            <div { ...blockProps }>
                <InnerBlocks />
            </div>
        </>
    );
}
