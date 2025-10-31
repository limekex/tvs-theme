# Dashboard

## Overview
Home dashboard with KPI tiles, widgets, and activity feed for quick overview.

## Files
- Template: `templates/dashboard.html`
- Styles: `assets/dashboard.css`

## Features
- KPI grid with key metrics
- Stat change indicators (+/- percentages)
- Widget system (activities, stats, progress)
- Circular progress visualization
- Responsive grid layout

## Widgets
1. **KPI Cards**: Total distance, time, activities, personal records
2. **Recent Activities**: List of recent sessions
3. **Quick Stats**: Weekly summary
4. **Progress**: Monthly goal with circular chart

## KPI Metrics
- Total Distance (km)
- Total Time (hours)
- Activities Count
- Personal Records Count
- Change indicators (up/down)

## Accessibility
- Semantic heading structure
- Descriptive labels
- Color-coded changes
- Screen reader friendly

## Usage
```html
<div class="tvs-dashboard">
  <div class="tvs-dashboard-kpi">
    <div class="tvs-kpi-card">
      <div class="tvs-kpi-value">582 km</div>
      <div class="tvs-kpi-label">Total Distance</div>
      <div class="tvs-kpi-change">+12%</div>
    </div>
  </div>
  <div class="tvs-dashboard-widgets">
    <!-- Widgets -->
  </div>
</div>
```
