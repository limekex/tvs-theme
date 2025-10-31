import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType( 'tvs/connect-strava', {
    title: __( 'Connect Strava', 'norway-virtual-sport' ),
    description: __( 'Strava connection interface', 'norway-virtual-sport' ),
    category: 'widgets',
    icon: 'admin-links',
    edit() {
        const blockProps = useBlockProps({
            className: 'tvs-strava-connect'
        });

        return (
            <div {...blockProps}>
                <div style={{
                    padding: '40px',
                    background: '#141414',
                    border: '2px dashed #1a1a1a',
                    borderRadius: '16px',
                    textAlign: 'center',
                    color: '#9fb0c8'
                }}>
                    <h3 style={{ margin: '0 0 12px', color: '#e6edf3' }}>
                        {__('Strava Connect Block', 'norway-virtual-sport')}
                    </h3>
                    <p style={{ margin: 0, fontSize: '14px' }}>
                        {__('Connect/disconnect Strava integration', 'norway-virtual-sport')}
                    </p>
                </div>
            </div>
        );
    },
    save() { return null; }
} );
