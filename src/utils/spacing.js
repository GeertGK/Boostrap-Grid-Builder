/**
 * Spacing utilities - gedeeld tussen editor en save
 */

// Breakpoints
const BREAKPOINTS = [ 'xs', 'sm', 'md', 'lg', 'xl' ];
const DIRECTIONS = [ 't', 'b', 's', 'e', 'x', 'y' ];

/**
 * Bouw de spacing class string op basis van attributes
 */
export function buildSpacingClasses( attributes ) {
    if ( ! attributes ) {
        return '';
    }

    const classes = [];
    const types = [ 'margin', 'padding' ];

    types.forEach( ( type ) => {
        const prefix = type === 'margin' ? 'm' : 'p';
        DIRECTIONS.forEach( ( dir ) => {
            BREAKPOINTS.forEach( ( bp ) => {
                const attrName = `${ prefix }${ dir }${ bp.charAt( 0 ).toUpperCase() + bp.slice( 1 ) }`;
                const value = attributes[ attrName ];

                if ( value !== undefined && value !== '' ) {
                    // Voor xs geen breakpoint suffix, voor andere wel
                    if ( bp === 'xs' ) {
                        classes.push( `${ prefix }${ dir }-${ value }` );
                    } else {
                        classes.push( `${ prefix }${ dir }-${ value }-${ bp }` );
                    }
                }
            } );
        } );
    } );

    return classes.join( ' ' );
}
