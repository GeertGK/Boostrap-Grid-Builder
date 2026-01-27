import { InnerBlocks } from '@wordpress/block-editor';
import { buildSpacingClasses } from '../../utils/spacing';

export default function save( { attributes } ) {
    const { justifyContent, alignItems, className } = attributes;
    const spacingClasses = buildSpacingClasses( attributes );

    const classes = [
        'row',
        justifyContent,
        alignItems,
        spacingClasses,
        className
    ].filter( Boolean ).join( ' ' );

    return (
        <div className={ classes }>
            <InnerBlocks.Content />
        </div>
    );
}
