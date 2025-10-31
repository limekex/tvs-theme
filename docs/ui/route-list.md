# Route List/Grid Component

## Overview
The Route List/Grid component provides a filterable, sortable, and searchable interface for browsing routes. Features a filter bar with chips, view toggles, and responsive grid/list layouts.

## Files
- **Template**: `templates/route-list.html`
- **Styles**: `assets/route-list.css`
- **Block**: `blocks/routes-grid/src/index.js`
- **Block Config**: `blocks/routes-grid/block.json`

## Features

### Search
- **Text Search**: Find routes by name or location
- **Clear Button**: Quick reset of search term
- **Live Results**: Updates as user types
- **Icon Indicator**: Visual search icon

### Filters

#### Difficulty Filter
- Multiple selection (checkbox)
- Color-coded dots (Easy, Moderate, Hard)
- Dropdown menu
- Persistent state

#### Distance Filter
- Single selection (radio)
- Ranges: Short (<20km), Medium (20-50km), Long (50+km)
- Dropdown menu

#### Sort Options
- Most Popular (default)
- Newest First
- Distance (Low to High)
- Distance (High to Low)
- Single selection (radio button style)

### View Modes
- **Grid View**: Responsive grid layout (1-4 columns)
- **List View**: Single column with horizontal cards
- Toggle buttons with icons
- Persists user preference

### Filter Chips
- Visual representation of active filters
- One chip per filter
- Search chip with search icon
- Individual remove buttons (X icon)
- "Clear all" button
- Real-time results count

### Results Display
- Responsive grid (mobile: 1 col, tablet: 2 cols, desktop: 3-4 cols)
- Loading state with busy indicator
- Empty state placeholder
- "Load More" pagination button

## Accessibility Features

### ARIA Attributes
- `role="search"` on filter bar
- `role="menu"` on dropdowns
- `role="menuitemcheckbox"` for multi-select filters
- `role="menuitemradio"` for single-select filters
- `role="radiogroup"` for view toggle
- `role="feed"` on route grid
- `aria-expanded` for dropdown states
- `aria-checked` for selections
- `aria-controls` linking buttons to menus
- `aria-haspopup` for dropdown triggers
- `aria-label` on icon-only buttons
- `aria-live="polite"` for results updates
- `aria-busy` for loading states

### Keyboard Navigation
- Tab through all interactive elements
- Enter/Space to activate buttons
- Arrow keys within dropdowns
- Escape to close dropdowns
- Focus indicators on all controls

### Screen Reader Support
- `.tvs-sr-only` class for visually hidden labels
- Descriptive labels for all controls
- Status updates announced via aria-live
- Help text for complex controls

## CSS Custom Properties

```css
/* Colors */
--tvs-filter-bg: #141414;              /* Filter bar background */
--tvs-filter-border: #1a1a1a;          /* Border color */
--tvs-filter-hover: #1f1f1f;           /* Hover state */
--tvs-filter-active: #2a3550;          /* Active state */
--tvs-filter-text: #e6edf3;            /* Primary text */
--tvs-filter-text-muted: #9fb0c8;      /* Secondary text */

--tvs-chip-bg: #253049;                /* Chip background */
--tvs-chip-hover: #2a3550;             /* Chip hover */
--tvs-chip-border: #3a4560;            /* Chip border */
--tvs-chip-text: #e6edf3;              /* Chip text */

/* Difficulty colors */
--tvs-difficulty-easy: #2a5d34;        /* Easy green */
--tvs-difficulty-moderate: #d89614;    /* Moderate orange */
--tvs-difficulty-hard: #ff4444;        /* Hard red */

/* Spacing */
--tvs-filter-gap: 12px;                /* Gap between elements */
--tvs-filter-radius: 8px;              /* Border radius */
```

## Responsive Behavior

### Mobile (< 768px)
- Single column layout
- Stacked filters (vertical)
- Full-width search
- Filter buttons wrap
- View toggle on separate line

### Tablet (768px+)
- Horizontal filter bar
- 2-column grid
- Search box max-width
- Inline filter actions

### Desktop (1024px+)
- 3-column grid (default)
- Enhanced spacing
- Smoother animations

### Large Desktop (1280px+)
- 4-column grid (optional)
- Maximum content width

## Usage Example

### HTML Template

```html
<div class="tvs-route-list-container">
  <!-- Filter Bar -->
  <div class="tvs-filter-bar" role="search">
    <div class="tvs-search-box">
      <input type="search" class="tvs-search-input" placeholder="Search routes..."/>
    </div>
    <div class="tvs-filter-actions">
      <!-- Filter dropdowns -->
    </div>
  </div>

  <!-- Active Chips -->
  <div class="tvs-filter-chips">
    <!-- Chips here -->
  </div>

  <!-- Route Grid -->
  <div class="tvs-route-grid" role="feed">
    <!-- Route cards -->
  </div>
</div>
```

### WordPress Block

```php
<!-- wp:tvs/routes-grid {
  "showFilters": true,
  "showSearch": true,
  "showSort": true,
  "defaultView": "grid",
  "columns": 3,
  "perPage": 12,
  "showPagination": true
} /-->
```

## JavaScript Integration

### Filter Management

```javascript
class RouteFilters {
  constructor(container) {
    this.container = container;
    this.filters = {
      search: '',
      difficulty: [],
      distance: null,
      sort: 'popular'
    };
    this.init();
  }

  init() {
    this.setupSearch();
    this.setupDropdowns();
    this.setupViewToggle();
    this.setupChips();
  }

  setupSearch() {
    const input = this.container.querySelector('.tvs-search-input');
    const clearBtn = this.container.querySelector('.tvs-search-clear');

    input?.addEventListener('input', (e) => {
      this.filters.search = e.target.value;
      clearBtn.hidden = !e.target.value;
      this.applyFilters();
    });

    clearBtn?.addEventListener('click', () => {
      input.value = '';
      this.filters.search = '';
      clearBtn.hidden = true;
      this.applyFilters();
    });
  }

  setupDropdowns() {
    const dropdowns = this.container.querySelectorAll('.tvs-filter-dropdown');

    dropdowns.forEach(dropdown => {
      const btn = dropdown.querySelector('.tvs-filter-btn');
      const menu = dropdown.querySelector('.tvs-filter-menu');

      btn?.addEventListener('click', () => {
        const isExpanded = btn.getAttribute('aria-expanded') === 'true';
        this.closeAllDropdowns();
        if (!isExpanded) {
          btn.setAttribute('aria-expanded', 'true');
          menu.hidden = false;
        }
      });

      // Handle filter selections
      menu?.querySelectorAll('input').forEach(input => {
        input.addEventListener('change', () => {
          this.updateFilters();
          this.applyFilters();
        });
      });
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.tvs-filter-dropdown')) {
        this.closeAllDropdowns();
      }
    });
  }

  closeAllDropdowns() {
    this.container.querySelectorAll('.tvs-filter-btn').forEach(btn => {
      btn.setAttribute('aria-expanded', 'false');
    });
    this.container.querySelectorAll('.tvs-filter-menu').forEach(menu => {
      menu.hidden = true;
    });
  }

  updateFilters() {
    // Update difficulty filters
    this.filters.difficulty = Array.from(
      this.container.querySelectorAll('input[name="difficulty"]:checked')
    ).map(input => input.value);

    // Update distance filter
    const distanceInput = this.container.querySelector('input[name="distance"]:checked');
    this.filters.distance = distanceInput?.value || null;

    this.updateChips();
  }

  updateChips() {
    const chipsList = this.container.querySelector('.tvs-chips-list');
    if (!chipsList) return;

    // Clear existing chips
    chipsList.innerHTML = '';

    // Add search chip
    if (this.filters.search) {
      chipsList.appendChild(this.createChip('search', this.filters.search));
    }

    // Add difficulty chips
    this.filters.difficulty.forEach(diff => {
      chipsList.appendChild(this.createChip('difficulty', diff));
    });

    // Add distance chip
    if (this.filters.distance) {
      chipsList.appendChild(this.createChip('distance', this.filters.distance));
    }

    // Add clear all button if there are filters
    if (this.hasActiveFilters()) {
      const clearBtn = document.createElement('button');
      clearBtn.className = 'tvs-chip-clear-all';
      clearBtn.textContent = 'Clear all';
      clearBtn.onclick = () => this.clearAllFilters();
      chipsList.appendChild(clearBtn);
    }
  }

  createChip(type, value) {
    const chip = document.createElement('button');
    chip.className = `tvs-chip ${type === 'search' ? 'tvs-chip--search' : ''}`;
    chip.innerHTML = `
      <span>${value}</span>
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
        <path d="M4 4L10 10M10 4L4 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    `;
    chip.onclick = () => this.removeFilter(type, value);
    return chip;
  }

  removeFilter(type, value) {
    if (type === 'search') {
      this.filters.search = '';
      this.container.querySelector('.tvs-search-input').value = '';
    } else if (type === 'difficulty') {
      this.filters.difficulty = this.filters.difficulty.filter(d => d !== value);
      const checkbox = this.container.querySelector(`input[name="difficulty"][value="${value}"]`);
      if (checkbox) checkbox.checked = false;
    } else if (type === 'distance') {
      this.filters.distance = null;
      const radio = this.container.querySelector(`input[name="distance"][value="${value}"]`);
      if (radio) radio.checked = false;
    }

    this.updateChips();
    this.applyFilters();
  }

  clearAllFilters() {
    this.filters = { search: '', difficulty: [], distance: null, sort: 'popular' };
    this.container.querySelector('.tvs-search-input').value = '';
    this.container.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
    this.container.querySelectorAll('input[type="radio"]').forEach(rb => rb.checked = false);
    this.updateChips();
    this.applyFilters();
  }

  hasActiveFilters() {
    return this.filters.search || 
           this.filters.difficulty.length > 0 || 
           this.filters.distance;
  }

  async applyFilters() {
    const grid = this.container.querySelector('.tvs-route-grid');
    if (!grid) return;

    grid.setAttribute('aria-busy', 'true');

    try {
      const response = await fetch('/wp-json/tvs/v1/routes?' + new URLSearchParams({
        search: this.filters.search,
        difficulty: this.filters.difficulty.join(','),
        distance: this.filters.distance || '',
        sort: this.filters.sort
      }));

      const routes = await response.json();
      this.renderRoutes(routes);
      this.updateResultsCount(routes.length);
    } catch (error) {
      console.error('Failed to fetch routes:', error);
    } finally {
      grid.setAttribute('aria-busy', 'false');
    }
  }

  renderRoutes(routes) {
    // Render route cards in grid
  }

  updateResultsCount(count) {
    const counter = this.container.querySelector('.tvs-results-count');
    if (counter) {
      counter.innerHTML = `<strong>${count} routes</strong> found`;
    }
  }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('.tvs-route-list-container');
  if (container) {
    new RouteFilters(container);
  }
});
```

### View Toggle

```javascript
function setupViewToggle() {
  const container = document.querySelector('.tvs-route-list-container');
  const viewBtns = container?.querySelectorAll('.tvs-view-btn');

  viewBtns?.forEach(btn => {
    btn.addEventListener('click', () => {
      const view = btn.getAttribute('aria-label').includes('Grid') ? 'grid' : 'list';
      
      viewBtns.forEach(b => {
        b.setAttribute('aria-checked', 'false');
        b.classList.remove('tvs-view-btn--active');
      });
      
      btn.setAttribute('aria-checked', 'true');
      btn.classList.add('tvs-view-btn--active');
      
      container.dataset.view = view;
      
      // Save preference
      localStorage.setItem('tvs-route-view', view);
    });
  });

  // Load saved preference
  const savedView = localStorage.getItem('tvs-route-view');
  if (savedView) {
    container.dataset.view = savedView;
  }
}
```

## Best Practices

1. **Performance**: Debounce search input to avoid excessive API calls
2. **State Management**: Persist filter state in URL or localStorage
3. **Loading States**: Show skeleton cards while fetching
4. **Error Handling**: Display friendly error messages
5. **Empty States**: Helpful messages when no results found
6. **Accessibility**: Test with keyboard and screen readers
7. **Progressive Enhancement**: Basic functionality without JavaScript

## Related Components
- Route Card
- Filter Dropdown
- Search Input
- Pagination

## Notes
- Filters should be synced with backend API
- Consider implementing URL-based filter state for sharing
- Add analytics tracking for popular filter combinations
- Implement infinite scroll as alternative to pagination
