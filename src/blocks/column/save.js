import { InnerBlocks } from '@wordpress/block-editor';
import { buildColumnClasses } from './utils';
import { buildSpacingClasses } from '../../utils/spacing';

export default function save( { attributes } ) {
    const columnClasses = buildColumnClasses( attributes );
    const spacingClasses = buildSpacingClasses( attributes );

    const classes = [ columnClasses, spacingClasses ].filter( Boolean ).join( ' ' );

    return (
        <div className={ classes }>
            <InnerBlocks.Content />
        </div>
    );
}
