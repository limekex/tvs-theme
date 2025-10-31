import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { createElement } from '@wordpress/element';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, SelectControl, RangeControl } from '@wordpress/components';

registerBlockType( 'tvs/routes-grid', {
    title: __( 'Routes Grid', 'norway-virtual-sport' ),
    description: __( 'Display routes in a filterable grid or list view', 'norway-virtual-sport' ),
    category: 'widgets',
    icon: 'grid-view',
    attributes: {
        showFilters: { type: 'boolean', default: true },
        showSearch: { type: 'boolean', default: true },
        showSort: { type: 'boolean', default: true },
        defaultView: { type: 'string', default: 'grid' },
        columns: { type: 'number', default: 3 },
        perPage: { type: 'number', default: 12 },
        showPagination: { type: 'boolean', default: true }
    },
    edit({ attributes, setAttributes }) {
        const blockProps = useBlockProps({
            className: 'tvs-route-list-container'
        });

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Display Settings', 'norway-virtual-sport')}>
                        <ToggleControl
                            label={__('Show Filters', 'norway-virtual-sport')}
                            checked={attributes.showFilters}
                            onChange={(showFilters) => setAttributes({ showFilters })}
                        />
                        <ToggleControl
                            label={__('Show Search', 'norway-virtual-sport')}
                            checked={attributes.showSearch}
                            onChange={(showSearch) => setAttributes({ showSearch })}
                        />
                        <ToggleControl
                            label={__('Show Sort', 'norway-virtual-sport')}
                            checked={attributes.showSort}
                            onChange={(showSort) => setAttributes({ showSort })}
                        />
                        <SelectControl
                            label={__('Default View', 'norway-virtual-sport')}
                            value={attributes.defaultView}
                            options={[
                                { label: 'Grid', value: 'grid' },
                                { label: 'List', value: 'list' }
                            ]}
                            onChange={(defaultView) => setAttributes({ defaultView })}
                        />
                        <RangeControl
                            label={__('Grid Columns (Desktop)', 'norway-virtual-sport')}
                            value={attributes.columns}
                            onChange={(columns) => setAttributes({ columns })}
                            min={2}
                            max={4}
                        />
                        <RangeControl
                            label={__('Routes Per Page', 'norway-virtual-sport')}
                            value={attributes.perPage}
                            onChange={(perPage) => setAttributes({ perPage })}
                            min={6}
                            max={24}
                            step={6}
                        />
                        <ToggleControl
                            label={__('Show Pagination', 'norway-virtual-sport')}
                            checked={attributes.showPagination}
                            onChange={(showPagination) => setAttributes({ showPagination })}
                        />
                    </PanelBody>
                </InspectorControls>
                
                <div {...blockProps}>
                    <div style={{
                        padding: '40px',
                        background: '#141414',
                        border: '2px dashed #1a1a1a',
                        borderRadius: '8px',
                        textAlign: 'center',
                        color: '#9fb0c8'
                    }}>
                        <h3 style={{ margin: '0 0 12px', color: '#e6edf3' }}>
                            {__('Routes Grid Block', 'norway-virtual-sport')}
                        </h3>
                        <p style={{ margin: 0, fontSize: '14px' }}>
                            {attributes.showFilters && __('Filters: Enabled', 'norway-virtual-sport')}<br/>
                            {__('View:', 'norway-virtual-sport')} {attributes.defaultView}<br/>
                            {__('Columns:', 'norway-virtual-sport')} {attributes.columns}<br/>
                            {__('Per Page:', 'norway-virtual-sport')} {attributes.perPage}
                        </p>
                        <p style={{ margin: '12px 0 0', fontSize: '13px', color: '#6b7280' }}>
                            {__('Server-side rendered on frontend', 'norway-virtual-sport')}
                        </p>
                    </div>
                </div>
            </>
        );
    },
    save() {
        // Server-side rendering
        return null;
    }
} );
