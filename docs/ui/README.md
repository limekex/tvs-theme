# TVS Theme UI Components Documentation

This directory contains documentation for all UI components in the Norway Virtual Sport theme.

## Overview

All components follow these principles:
- **Mobile-first**: Responsive design starting from mobile screens
- **Dark theme**: Optimized for dark backgrounds with accessible contrast
- **Accessible**: WCAG AA compliant with proper ARIA attributes
- **Performant**: Optimized CSS and minimal JavaScript
- **Customizable**: CSS custom properties for easy theming

## Component Index

### 1. Shell (Navigation)
**File**: [shell.md](./shell.md)  
**Templates**: `templates/shell-header.html`  
**Styles**: `assets/shell-header.css`

Desktop/tablet topbar with logo, primary navigation, user actions, and mobile bottom navigation bar.

**Key Features**:
- Sticky header with backdrop blur
- Responsive navigation (horizontal on desktop, bottom nav on mobile)
- User menu, notifications, search
- Safe area support for mobile devices

---

### 2. Route Card
**File**: [route-card.md](./route-card.md)  
**Templates**: `templates/route-card.html`  
**Styles**: `assets/route-card.css`  
**Block**: `blocks/route-card/`

Card component displaying route information with thumbnail, stats, and actions.

**Key Features**:
- Multiple states: default, favorited, completed
- Difficulty badges (Easy, Moderate, Hard)
- Quick stats overlay (distance, elevation)
- Favorite toggle
- Personal record badges
- Hover animations

---

### 3. Route List/Grid
**File**: [route-list.md](./route-list.md)  
**Templates**: `templates/route-list.html`  
**Styles**: `assets/route-list.css`  
**Block**: `blocks/routes-grid/`

Filterable, sortable grid/list view for browsing routes.

**Key Features**:
- Search with live results
- Multi-select difficulty filter
- Distance and sort options
- Active filter chips
- Grid/list view toggle
- Responsive columns (1-4)
- Load more pagination

---

### 4. Activity Summary
**File**: [activity-summary.md](./activity-summary.md)  
**Templates**: `templates/activity-summary.html`  
**Styles**: `assets/activity-summary.css`  
**Block**: `blocks/my-activities/`

Dashboard widget showing user's recent activity sessions.

**Key Features**:
- Activity states: completed, in-progress, abandoned, planned
- Stats display: distance, time, pace
- Progress bars for active sessions
- Personal record badges
- Empty state for new users
- Resume action for paused activities

---

### 5. Strava Connect
**File**: [strava-connect.md](./strava-connect.md)  
**Templates**: `templates/strava-connect.html`  
**Styles**: `assets/strava-connect.css`  
**Block**: `blocks/connect-strava/`

Interface for connecting/disconnecting Strava accounts.

**Key Features**:
- Disconnected state with features list
- Connected state with user stats
- Sync status and manual sync
- Loading/connecting state
- Error state with retry
- Privacy messaging

---

### 6. Player Controls
**File**: [player-controls.md](./player-controls.md)  
**Templates**: `templates/player-controls.html`  
**Styles**: `assets/player-controls.css`

Video player control bar with transport buttons and pace matching.

**Key Features**:
- Play/pause, skip controls
- Draggable progress bar
- Time display
- Pace matching indicator
- Volume control
- Settings and fullscreen
- Keyboard shortcuts
- Hover tooltips

---

### 7. Minimap + Elevation
**File**: [minimap.md](./minimap.md)  
**Templates**: `templates/minimap.html`  
**Styles**: `assets/minimap.css`

Compact route map overlay with elevation profile.

**Key Features**:
- Canvas-based route visualization
- Current position marker with pulse animation
- Elevation profile (SVG)
- Progress stats
- Fixed positioning (bottom-right)
- Responsive sizing

---

### 8. Dashboard
**File**: [dashboard.md](./dashboard.md)  
**Templates**: `templates/dashboard.html`  
**Styles**: `assets/dashboard.css`

Home dashboard with KPI tiles and widget grid.

**Key Features**:
- KPI cards (distance, time, activities, PRs)
- Change indicators (+/- percentages)
- Widget system (activities, stats, progress)
- Circular progress visualization
- Responsive grid layout

---

### 9. Heatmap
**File**: [heatmap.md](./heatmap.md)  
**Templates**: `templates/heatmap.html`  
**Styles**: `assets/heatmap.css`

Activity heatmap visualization showing usage patterns.

**Key Features**:
- Canvas-based heatmap rendering
- Activity type filter
- Time period selector
- Color gradient legend
- Responsive design

---

### 10. UI States
**File**: [ui-states.md](./ui-states.md)  
**Templates**: `templates/ui-states.html`  
**Styles**: `assets/ui-states.css`

Reusable loading, empty, error states and toast notifications.

**Key Features**:
- Loading skeletons with shimmer animation
- Empty state with CTA
- Error state with retry
- Success/error toast notifications
- Auto-dismiss capability
- Slide-in animations

---

## Common Patterns

### CSS Custom Properties

All components use CSS custom properties for theming:

```css
:root {
  /* Colors */
  --tvs-*-bg: #141414;           /* Background */
  --tvs-*-border: #1a1a1a;       /* Border */
  --tvs-*-text: #e6edf3;         /* Primary text */
  --tvs-*-text-muted: #9fb0c8;   /* Secondary text */
  
  /* Brand colors */
  --tvs-primary: #4aa6e0;         /* Sky blue */
  --tvs-success: #2a5d34;         /* Outdoor green */
  --tvs-warning: #d89614;         /* Orange */
  --tvs-danger: #ff4444;          /* Red */
  
  /* Spacing */
  --tvs-*-padding: 16px;
  --tvs-*-radius: 8px;
}
```

### Responsive Breakpoints

```css
/* Mobile-first approach */
/* Base styles: < 768px */

@media (min-width: 768px) {
  /* Tablet */
}

@media (min-width: 1024px) {
  /* Desktop */
}

@media (min-width: 1280px) {
  /* Large desktop */
}
```

### Accessibility

All components include:
- Semantic HTML5 elements
- ARIA attributes (roles, labels, states)
- Keyboard navigation support
- Focus indicators
- Screen reader text (`.tvs-sr-only`)
- Color contrast compliance (WCAG AA)
- `prefers-reduced-motion` support

### Dark Theme

Design system colors optimized for dark backgrounds:
- Background: `#0b0b0b` to `#141414`
- Borders: `#1a1a1a` to `#2a2a2a`
- Text: `#e6edf3` (primary), `#9fb0c8` (secondary)
- Accent: `#4aa6e0` (sky blue)

## Using Components

### In WordPress Templates

```php
<?php
// Include component template
get_template_part('templates/route-card');

// Or use block
?>
<!-- wp:tvs/route-card {"routeId": 123} /-->
```

### In HTML/PHP

```html
<!-- Include styles -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/route-card.css">

<!-- Include template -->
<?php include get_template_directory() . '/templates/route-card.html'; ?>
```

### With JavaScript

```javascript
// Import and initialize component
import { initRouteFilters } from './route-filters';

document.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('.tvs-route-list-container');
  if (container) {
    initRouteFilters(container);
  }
});
```

## File Structure

```
tvs-theme/
├── templates/           # HTML templates
│   ├── shell-header.html
│   ├── route-card.html
│   ├── route-list.html
│   ├── activity-summary.html
│   ├── strava-connect.html
│   ├── player-controls.html
│   ├── minimap.html
│   ├── dashboard.html
│   ├── heatmap.html
│   └── ui-states.html
│
├── assets/             # CSS files
│   ├── shell-header.css
│   ├── route-card.css
│   ├── route-list.css
│   ├── activity-summary.css
│   ├── strava-connect.css
│   ├── player-controls.css
│   ├── minimap.css
│   ├── dashboard.css
│   ├── heatmap.css
│   └── ui-states.css
│
├── blocks/             # WordPress blocks
│   ├── route-card/
│   ├── routes-grid/
│   ├── my-activities/
│   └── connect-strava/
│
└── docs/ui/            # Documentation
    ├── README.md (this file)
    ├── shell.md
    ├── route-card.md
    ├── route-list.md
    ├── activity-summary.md
    ├── strava-connect.md
    ├── player-controls.md
    ├── minimap.md
    ├── dashboard.md
    ├── heatmap.md
    └── ui-states.md
```

## Best Practices

1. **Mobile First**: Always design and code for mobile screens first
2. **Accessibility**: Test with keyboard and screen readers
3. **Performance**: Use CSS transforms for animations, lazy load images
4. **Dark Theme**: Maintain contrast ratios (WCAG AA minimum)
5. **Progressive Enhancement**: Core functionality works without JavaScript
6. **Touch Targets**: Minimum 44x44px for mobile interactions
7. **Loading States**: Always show feedback during async operations
8. **Error Handling**: Provide clear error messages and recovery options

## Browser Support

- Chrome/Edge (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- iOS Safari (latest 2 versions)
- Chrome Android (latest 2 versions)

## Contributing

When adding new components:

1. Create HTML template in `templates/`
2. Create CSS file in `assets/`
3. Create WordPress block if needed in `blocks/`
4. Document in `docs/ui/` with:
   - Overview
   - Features list
   - File locations
   - Usage examples
   - Accessibility notes
   - Code samples

## License

Part of the Norway Virtual Sport theme.
