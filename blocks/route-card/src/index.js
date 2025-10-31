import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl, ToggleControl } from '@wordpress/components';

registerBlockType( 'tvs/route-card', {
    title: __( 'Route Card', 'norway-virtual-sport' ),
    description: __( 'Display a route card with image, stats, and actions', 'norway-virtual-sport' ),
    category: 'widgets',
    icon: 'location',
    attributes: {
        routeId: { type: 'number', default: 0 },
        title: { type: 'string', default: 'Route Name' },
        description: { type: 'string', default: 'Route description' },
        distance: { type: 'string', default: '0 km' },
        elevation: { type: 'string', default: '0m' },
        difficulty: { type: 'string', default: 'moderate' },
        location: { type: 'string', default: 'Norway' },
        duration: { type: 'string', default: '0h' },
        completions: { type: 'number', default: 0 },
        imageUrl: { type: 'string', default: '' },
        isFavorited: { type: 'boolean', default: false },
        isCompleted: { type: 'boolean', default: false }
    },
    edit({ attributes, setAttributes }) {
        const blockProps = useBlockProps({
            className: `tvs-route-card ${attributes.isFavorited ? 'tvs-route-card--favorited' : ''} ${attributes.isCompleted ? 'tvs-route-card--completed' : ''}`
        });

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Route Settings', 'norway-virtual-sport')}>
                        <TextControl
                            label={__('Route ID', 'norway-virtual-sport')}
                            value={attributes.routeId}
                            onChange={(value) => setAttributes({ routeId: parseInt(value) || 0 })}
                            type="number"
                        />
                        <TextControl
                            label={__('Title', 'norway-virtual-sport')}
                            value={attributes.title}
                            onChange={(title) => setAttributes({ title })}
                        />
                        <TextControl
                            label={__('Description', 'norway-virtual-sport')}
                            value={attributes.description}
                            onChange={(description) => setAttributes({ description })}
                        />
                        <SelectControl
                            label={__('Difficulty', 'norway-virtual-sport')}
                            value={attributes.difficulty}
                            options={[
                                { label: 'Easy', value: 'easy' },
                                { label: 'Moderate', value: 'moderate' },
                                { label: 'Hard', value: 'hard' }
                            ]}
                            onChange={(difficulty) => setAttributes({ difficulty })}
                        />
                        <TextControl
                            label={__('Distance', 'norway-virtual-sport')}
                            value={attributes.distance}
                            onChange={(distance) => setAttributes({ distance })}
                        />
                        <TextControl
                            label={__('Elevation', 'norway-virtual-sport')}
                            value={attributes.elevation}
                            onChange={(elevation) => setAttributes({ elevation })}
                        />
                        <TextControl
                            label={__('Location', 'norway-virtual-sport')}
                            value={attributes.location}
                            onChange={(location) => setAttributes({ location })}
                        />
                        <TextControl
                            label={__('Duration', 'norway-virtual-sport')}
                            value={attributes.duration}
                            onChange={(duration) => setAttributes({ duration })}
                        />
                        <TextControl
                            label={__('Completions', 'norway-virtual-sport')}
                            value={attributes.completions}
                            onChange={(value) => setAttributes({ completions: parseInt(value) || 0 })}
                            type="number"
                        />
                        <ToggleControl
                            label={__('Favorited', 'norway-virtual-sport')}
                            checked={attributes.isFavorited}
                            onChange={(isFavorited) => setAttributes({ isFavorited })}
                        />
                        <ToggleControl
                            label={__('Completed', 'norway-virtual-sport')}
                            checked={attributes.isCompleted}
                            onChange={(isCompleted) => setAttributes({ isCompleted })}
                        />
                    </PanelBody>
                </InspectorControls>
                
                <article {...blockProps}>
                    <div className="tvs-route-card__media">
                        <div className="tvs-route-card__image" style={{
                            width: '100%',
                            height: '200px',
                            background: '#1a1a1a',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            color: '#666'
                        }}>
                            {attributes.imageUrl ? (
                                <img src={attributes.imageUrl} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                            ) : (
                                'Route Image Placeholder'
                            )}
                        </div>
                        <span className={`tvs-route-badge tvs-route-badge--${attributes.difficulty}`}>
                            {attributes.difficulty}
                        </span>
                        <div className="tvs-route-card__overlay">
                            <span className="tvs-route-stat">{attributes.distance}</span>
                            <span className="tvs-route-stat">{attributes.elevation}</span>
                        </div>
                    </div>
                    <div className="tvs-route-card__content">
                        <h3 className="tvs-route-card__title">{attributes.title}</h3>
                        <p className="tvs-route-card__description">{attributes.description}</p>
                        <div className="tvs-route-card__meta">
                            <span className="tvs-route-meta-item">{attributes.location}</span>
                            <span className="tvs-route-meta-item">{attributes.duration}</span>
                            <span className="tvs-route-meta-item">{attributes.completions}</span>
                        </div>
                    </div>
                </article>
            </>
        );
    },
    save() {
        // Server-side rendering
        return null;
    }
} );
