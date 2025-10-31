# Route Card Component

## Overview
The Route Card displays route information in a visually appealing card format with thumbnail image, quick stats, difficulty badge, and action buttons. Supports multiple states including favorited and completed.

## Files
- **Template**: `templates/route-card.html`
- **Styles**: `assets/route-card.css`
- **Block**: `blocks/route-card/src/index.js`
- **Block Config**: `blocks/route-card/block.json`

## Features

### Visual Elements
- **Thumbnail Image**: Route preview with lazy loading
- **Difficulty Badge**: Color-coded (Easy, Moderate, Hard)
- **Quick Stats Overlay**: Distance and elevation gain
- **Favorite Button**: Toggle favorite status
- **Completion Badge**: Shows when route is completed
- **Achievement Display**: Personal best times

### Content
- **Title**: Route name (linked)
- **Description**: Brief route overview (2-line clamp)
- **Meta Information**: Location, duration, completion count
- **Action Buttons**: Start Route and View Details

## States

### Default State
- Standard card appearance
- Unfavorited (outline star icon)
- Not completed

### Favorited State
- Golden star icon (filled)
- Subtle golden border accent
- `.tvs-route-card--favorited` class

### Completed State
- Green completion badge with checkmark
- Personal best achievement badge
- Subtle green border accent
- "Ride Again" CTA instead of "Start Route"
- `.tvs-route-card--completed` class

## Difficulty Levels

### Easy
- Color: `#2a5d34` (Outdoor Green)
- Icon: Circle
- `.tvs-route-badge--easy`

### Moderate
- Color: `#d89614` (Orange)
- Icon: Star
- `.tvs-route-badge--moderate`

### Hard
- Color: `#ff4444` (Red)
- Icon: Double chevron
- `.tvs-route-badge--hard`

## Accessibility Features

### ARIA Attributes
- `role="article"` on card container
- `aria-labelledby` linking to title ID
- `aria-label` on all icon-only buttons
- `aria-pressed` state for favorite toggle
- Descriptive labels for stats

### Keyboard Navigation
- All interactive elements keyboard accessible
- Focus indicators on buttons and links
- Tab order follows visual hierarchy

### Screen Reader Support
- Icon elements marked `aria-hidden="true"`
- Stats include descriptive units
- Images with empty alt (thumbnails)
- Button labels describe actions

### Image Loading
- `loading="lazy"` for performance
- Width and height attributes prevent layout shift
- Fallback background color

## CSS Custom Properties

```css
--tvs-card-bg: #141414;                    /* Card background */
--tvs-card-border: #1a1a1a;                /* Border color */
--tvs-card-hover-border: #2a2a2a;          /* Hover border */
--tvs-card-text: #e6edf3;                  /* Primary text */
--tvs-card-text-muted: #9fb0c8;            /* Secondary text */
--tvs-card-overlay-bg: rgba(11, 11, 11, 0.85);  /* Overlay background */

--tvs-difficulty-easy: #2a5d34;            /* Easy difficulty */
--tvs-difficulty-moderate: #d89614;        /* Moderate difficulty */
--tvs-difficulty-hard: #ff4444;            /* Hard difficulty */

--tvs-primary: #4aa6e0;                    /* Primary action color */
--tvs-primary-hover: #5bb6f0;              /* Primary hover */
--tvs-secondary: #253049;                  /* Secondary button bg */
--tvs-secondary-hover: #2a3550;            /* Secondary hover */
--tvs-favorite: #FFD700;                   /* Favorite/gold color */

--tvs-card-radius: 12px;                   /* Border radius */
--tvs-card-padding: 16px;                  /* Content padding */
```

## Responsive Behavior

### Mobile (< 768px)
- Stacked layout (vertical card)
- Full-width action buttons
- Smaller padding and font sizes
- All actions visible

### Tablet (768px+)
- Increased padding and spacing
- Larger typography
- Action buttons sized to content

### Desktop (1024px+)
- Actions hidden by default
- Revealed on card hover/focus
- Enhanced hover effects
- Image zoom on hover

## Usage Example

### HTML Template

```html
<article class="tvs-route-card" role="article" aria-labelledby="route-1">
  <div class="tvs-route-card__media">
    <img src="/route.jpg" alt="" class="tvs-route-card__image" loading="lazy"/>
    <span class="tvs-route-badge tvs-route-badge--moderate">Moderate</span>
    <div class="tvs-route-card__overlay">
      <span class="tvs-route-stat">42.5 km</span>
      <span class="tvs-route-stat">850m</span>
    </div>
    <button class="tvs-route-card__favorite" aria-label="Add to favorites" aria-pressed="false">
      <!-- SVG icon -->
    </button>
  </div>
  <div class="tvs-route-card__content">
    <h3 class="tvs-route-card__title" id="route-1">
      <a href="/routes/example" class="tvs-route-card__link">Route Name</a>
    </h3>
    <p class="tvs-route-card__description">Description text...</p>
    <div class="tvs-route-card__meta">
      <span class="tvs-route-meta-item">Western Norway</span>
      <span class="tvs-route-meta-item">3-4h</span>
      <span class="tvs-route-meta-item">284</span>
    </div>
    <div class="tvs-route-card__actions">
      <a href="/routes/example" class="tvs-btn tvs-btn--primary tvs-btn--sm">Start Route</a>
      <button class="tvs-btn tvs-btn--secondary tvs-btn--sm">Details</button>
    </div>
  </div>
</article>
```

### WordPress Block

```php
<!-- wp:tvs/route-card {
  "routeId": 123,
  "title": "Norway Coastal Path",
  "description": "Scenic coastal route...",
  "distance": "42.5 km",
  "elevation": "850m",
  "difficulty": "moderate",
  "location": "Western Norway",
  "duration": "3-4h",
  "completions": 284
} /-->
```

## JavaScript Integration

### Favorite Toggle

```javascript
document.querySelectorAll('.tvs-route-card__favorite').forEach(btn => {
  btn.addEventListener('click', async (e) => {
    e.preventDefault();
    const routeId = btn.dataset.routeId;
    const isFavorited = btn.getAttribute('aria-pressed') === 'true';
    
    try {
      // API call to toggle favorite
      const response = await fetch('/wp-json/tvs/v1/routes/' + routeId + '/favorite', {
        method: 'POST',
        headers: { 'X-WP-Nonce': wpApiSettings.nonce }
      });
      
      if (response.ok) {
        btn.setAttribute('aria-pressed', !isFavorited);
        btn.classList.toggle('tvs-route-card__favorite--active');
        btn.closest('.tvs-route-card').classList.toggle('tvs-route-card--favorited');
        
        // Update aria-label
        btn.setAttribute('aria-label', 
          !isFavorited ? 'Remove from favorites' : 'Add to favorites'
        );
      }
    } catch (error) {
      console.error('Failed to toggle favorite:', error);
    }
  });
});
```

### Dynamic Loading

```javascript
async function loadRouteCard(routeId, container) {
  try {
    const response = await fetch('/wp-json/tvs/v1/routes/' + routeId);
    const route = await response.json();
    
    const card = createRouteCardElement(route);
    container.appendChild(card);
  } catch (error) {
    console.error('Failed to load route:', error);
  }
}

function createRouteCardElement(route) {
  // Create card DOM structure from route data
  const article = document.createElement('article');
  article.className = 'tvs-route-card';
  article.setAttribute('role', 'article');
  // ... build card structure
  return article;
}
```

## Grid Layout

Cards work well in CSS Grid or Flexbox layouts:

```css
.tvs-route-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 24px;
  padding: 24px;
}

@media (min-width: 768px) {
  .tvs-route-grid {
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
  }
}
```

## Best Practices

1. **Performance**: Use lazy loading for images
2. **Accessibility**: Always include aria-labels for icon buttons
3. **Touch Targets**: Ensure minimum 44x44px touch areas on mobile
4. **Loading States**: Show skeleton cards while data loads
5. **Error Handling**: Gracefully handle missing images/data
6. **Animations**: Respect `prefers-reduced-motion`
7. **Contrast**: Maintain WCAG AA contrast ratios

## Related Components
- Route List/Grid
- Route Detail Page
- Activity Summary
- User Dashboard

## Notes
- Cards are designed for both server-rendered and client-rendered scenarios
- Block uses server-side rendering (`save: null`)
- Completion and favorite states should be synced with backend
- Personal best data requires user authentication
