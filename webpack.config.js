const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );

module.exports = {
    ...defaultConfig,
    entry: {
        index: path.resolve( __dirname, 'src/index.js' ),
        'blocks/container/index': path.resolve( __dirname, 'src/blocks/container/index.js' ),
        'blocks/row/index': path.resolve( __dirname, 'src/blocks/row/index.js' ),
        'blocks/column/index': path.resolve( __dirname, 'src/blocks/column/index.js' ),
        'extensions/spacing': path.resolve( __dirname, 'src/extensions/spacing.js' ),
        editor: path.resolve( __dirname, 'src/editor.css' ),
    },
};
