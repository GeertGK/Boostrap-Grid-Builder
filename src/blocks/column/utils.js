/**
 * Bouw de CSS classes voor een kolom op basis van de attributes
 */
export function buildColumnClasses( attributes ) {
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
        className,
    } = attributes;

    const classes = [];

    // Column widths
    if ( colDefault ) {
        classes.push( `col-${ colDefault }` );
    }
    if ( colSm ) {
        classes.push( `col-sm-${ colSm }` );
    }
    if ( colMd ) {
        classes.push( `col-md-${ colMd }` );
    }
    if ( colLg ) {
        classes.push( `col-lg-${ colLg }` );
    }
    if ( colXl ) {
        classes.push( `col-xl-${ colXl }` );
    }

    // Offsets
    if ( offsetDefault ) {
        classes.push( `offset-${ offsetDefault }` );
    }
    if ( offsetSm ) {
        classes.push( `offset-sm-${ offsetSm }` );
    }
    if ( offsetMd ) {
        classes.push( `offset-md-${ offsetMd }` );
    }
    if ( offsetLg ) {
        classes.push( `offset-lg-${ offsetLg }` );
    }
    if ( offsetXl ) {
        classes.push( `offset-xl-${ offsetXl }` );
    }

    // Bleed classes
    if ( bleedLeft ) {
        classes.push( 'col-bleed-left' );
    }
    if ( bleedRight ) {
        classes.push( 'col-bleed-right' );
    }
    if ( bleedLeftSm ) {
        classes.push( 'col-bleed-sm-left' );
    }
    if ( bleedRightSm ) {
        classes.push( 'col-bleed-sm-right' );
    }
    if ( bleedLeftMd ) {
        classes.push( 'col-bleed-md-left' );
    }
    if ( bleedRightMd ) {
        classes.push( 'col-bleed-md-right' );
    }
    if ( bleedLeftLg ) {
        classes.push( 'col-bleed-lg-left' );
    }
    if ( bleedRightLg ) {
        classes.push( 'col-bleed-lg-right' );
    }
    if ( bleedLeftXl ) {
        classes.push( 'col-bleed-xl-left' );
    }
    if ( bleedRightXl ) {
        classes.push( 'col-bleed-xl-right' );
    }

    // Flex alignment
    if ( justifyContent ) {
        classes.push( justifyContent );
    }
    if ( alignItems ) {
        classes.push( alignItems );
    }

    // Extra CSS classes
    if ( className ) {
        classes.push( className );
    }

    return classes.join( ' ' );
}
