import { InnerBlocks } from '@wordpress/block-editor';
import { buildSpacingClasses } from '../../utils/spacing';

export default function save( { attributes } ) {
    const { isFluid, className } = attributes;
    const spacingClasses = buildSpacingClasses( attributes );

    const classes = [
        isFluid ? 'container-fluid' : 'container',
        spacingClasses,
        className
    ].filter( Boolean ).join( ' ' );

    return (
        <div className={ classes }>
            <InnerBlocks.Content />
        </div>
    );
}
