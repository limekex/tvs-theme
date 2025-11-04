import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { createElement } from '@wordpress/element';

registerBlockType( 'tvs/my-activities', {
    title: __( 'My Activities', 'norway-virtual-sport' ),
    edit() {
        const props = useBlockProps();
        return createElement('div', props, __('My Activities (server-rendered later)', 'norway-virtual-sport'));
    },
    save() { return null; }
} );
