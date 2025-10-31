# UI States (Loading, Empty, Error)

## Overview
Reusable UI state components including loading skeletons, empty states, error messages, and toast notifications.

## Files
- Template: `templates/ui-states.html`
- Styles: `assets/ui-states.css`

## Components

### Loading Skeleton
- Animated shimmer effect
- Card structure with image and text placeholders
- Pulse animation

### Empty State
- Icon illustration
- Heading and description
- Call-to-action button
- Use when no content/results available

### Error State
- Error icon with red accent
- Error message
- Retry action button
- Use for failed data loads

### Toast Notifications
- Success and error variants
- Auto-dismiss capability
- Close button
- Fixed position (bottom-right)
- Slide-in animation

## States
1. **Loading**: Show while fetching data
2. **Empty**: Show when no results/content
3. **Error**: Show on failures
4. **Success Toast**: Confirm actions
5. **Error Toast**: Alert errors

## Accessibility
- `role="status"` on toasts
- `aria-live="polite"` for success
- `aria-live="assertive"` for errors
- Focus management
- Keyboard dismissable

## Usage

### Skeleton
```html
<div class="tvs-skeleton-card">
  <div class="tvs-skeleton-image"></div>
  <div class="tvs-skeleton-content">
    <div class="tvs-skeleton-line"></div>
  </div>
</div>
```

### Empty State
```html
<div class="tvs-empty-state">
  <svg>...</svg>
  <h3>No Routes Found</h3>
  <p>Try adjusting your filters</p>
  <button>Clear Filters</button>
</div>
```

### Toast
```html
<div class="tvs-toast tvs-toast--success">
  <svg>...</svg>
  <span>Success message</span>
  <button aria-label="Close">×</button>
</div>
```
