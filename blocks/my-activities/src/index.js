import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { createElement } from '@wordpress/element';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType( 'tvs/my-activities', {
    title: __( 'My Activities', 'norway-virtual-sport' ),
    description: __( 'Display user activity summary', 'norway-virtual-sport' ),
    category: 'widgets',
    icon: 'chart-line',
    edit() {
        const blockProps = useBlockProps({
            className: 'tvs-activity-summary'
        });

        return (
            <div {...blockProps}>
                <div style={{
                    padding: '40px',
                    background: '#141414',
                    border: '2px dashed #1a1a1a',
                    borderRadius: '12px',
                    textAlign: 'center',
                    color: '#9fb0c8'
                }}>
                    <h3 style={{ margin: '0 0 12px', color: '#e6edf3' }}>
                        {__('Activity Summary Block', 'norway-virtual-sport')}
                    </h3>
                    <p style={{ margin: 0, fontSize: '14px' }}>
                        {__('Displays recent activities (requires login)', 'norway-virtual-sport')}
                    </p>
                </div>
            </div>
        );
    },
    save() { return null; }
} );
