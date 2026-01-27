import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';
import save from './save';
import metadata from './block.json';

registerBlockType( metadata.name, {
    icon: {
        src: (
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 4v16h4V4H6zm8 0v16h4V4h-4z" />
            </svg>
        ),
    },
    edit: Edit,
    save,
} );
