# Shell: Header/Topbar + Mobile Bottom Nav

## Overview
The shell component provides consistent navigation across the application with a desktop/tablet topbar and a mobile bottom navigation bar.

## Files
- **Template**: `templates/shell-header.html`
- **Styles**: `assets/shell-header.css`
- **Related**: `parts/header.html`

## Features

### Desktop/Tablet Topbar
- **Logo**: Clickable branding with SVG icon and text
- **Primary Navigation**: Horizontal menu with icons and labels
- **User Actions**: Search, notifications, user menu
- **Connect CTA**: Prominent call-to-action for unauthenticated users

### Mobile Bottom Navigation
- **5 Primary Actions**: Routes, Activity, Map, Dashboard, Profile
- **Always Accessible**: Fixed at bottom of viewport
- **Safe Area Support**: Respects device notches/home indicators
- **Active State**: Visual indicator for current page

## Accessibility Features

### ARIA Attributes
- `role="banner"` on header
- `role="navigation"` with descriptive labels
- `role="menubar"` and `role="menuitem"` for navigation lists
- `aria-current="page"` for active links
- `aria-label` on icon-only buttons
- `aria-expanded` for toggleable elements
- `aria-controls` for related panels

### Keyboard Navigation
- All interactive elements are keyboard accessible
- Visible focus indicators with `outline`
- Tab order follows visual flow
- Skip links should be added for screen reader users

### Screen Reader Support
- Icon elements marked `aria-hidden="true"`
- Descriptive labels for all actions
- Badge notifications include accessible text
- Avatar images have empty alt text (decorative)

## CSS Custom Properties

```css
--tvs-shell-bg: #0b0b0b;              /* Background color */
--tvs-shell-border: #1a1a1a;          /* Border color */
--tvs-shell-text: #e6edf3;            /* Primary text */
--tvs-shell-text-muted: #9fb0c8;      /* Secondary text */
--tvs-shell-hover-bg: rgba(255, 255, 255, 0.08);  /* Hover state */
--tvs-shell-active-bg: rgba(74, 166, 224, 0.15);  /* Active state */
--tvs-shell-active-color: #4aa6e0;    /* Active link color */
--tvs-shell-height: 64px;             /* Desktop header height */
--tvs-mobile-nav-height: 72px;        /* Mobile nav height */
--tvs-z-header: 1000;                 /* Z-index for header */
--tvs-z-mobile-nav: 999;              /* Z-index for mobile nav */
```

## Responsive Behavior

### Mobile (< 768px)
- Hamburger menu toggle visible
- Primary navigation hidden (expandable via menu)
- Bottom navigation bar visible
- Logo text hidden
- Compact action buttons

### Tablet (768px - 1023px)
- Full topbar navigation visible
- Logo text shown
- Mobile bottom nav hidden
- Hamburger menu hidden

### Desktop (1024px+)
- Full spacing and gaps
- All navigation labels visible
- Enhanced hover states

## Usage Example

```html
<!-- Include in theme header -->
<?php get_template_part('templates/shell', 'header'); ?>

<!-- Add mobile bottom nav space to body -->
<body class="has-mobile-nav">
  <style>
    .has-mobile-nav {
      padding-bottom: var(--tvs-mobile-nav-height);
    }
    @media (min-width: 768px) {
      .has-mobile-nav {
        padding-bottom: 0;
      }
    }
  </style>
</body>
```

## JavaScript Integration

```javascript
// Toggle mobile menu
const menuToggle = document.querySelector('.tvs-mobile-menu-toggle');
const menu = document.getElementById('mobile-menu');

menuToggle?.addEventListener('click', () => {
  const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
  menuToggle.setAttribute('aria-expanded', !isExpanded);
  menu?.classList.toggle('is-open');
});

// Update active navigation state
function updateActiveNav() {
  const currentPath = window.location.pathname;
  document.querySelectorAll('.tvs-nav-link, .tvs-mobile-nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href === currentPath) {
      link.setAttribute('aria-current', 'page');
      link.classList.add('tvs-mobile-nav-link--active');
    } else {
      link.removeAttribute('aria-current');
      link.classList.remove('tvs-mobile-nav-link--active');
    }
  });
}

// Notification badge updates
function updateNotificationBadge(count) {
  const badge = document.querySelector('.tvs-badge');
  if (badge) {
    badge.textContent = count;
    badge.setAttribute('aria-label', `${count} new notifications`);
    badge.hidden = count === 0;
  }
}
```

## States

### Default
- Neutral colors for inactive items
- Subtle hover effects

### Hover
- Background highlight
- Color transition

### Active/Current
- Accent color (sky blue)
- Background highlight
- Scale animation on mobile icons

### Focus
- Visible outline in accent color
- 2px outline offset

## Best Practices

1. **Mobile First**: Always test on mobile devices first
2. **Touch Targets**: Minimum 44x44px for mobile interactions
3. **Performance**: Use CSS transforms for animations
4. **Dark Theme**: Maintain contrast ratios (WCAG AA minimum)
5. **Safe Areas**: Always respect device safe areas on mobile
6. **Loading States**: Show skeleton while user data loads
7. **Progressive Enhancement**: Core navigation works without JS

## Related Components
- User Menu Dropdown
- Search Panel
- Notifications Panel
- Mobile Slide-out Menu

## Notes
- Header uses `position: sticky` for better UX
- Backdrop blur requires browser support
- Badge notifications should be limited/throttled
- Consider prefers-reduced-motion for animations
