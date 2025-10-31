# Heatmap Overlay

## Overview
Activity heatmap visualization showing route usage patterns over time.

## Files
- Template: `templates/heatmap.html`
- Styles: `assets/heatmap.css`

## Features
- Canvas-based heatmap rendering
- Activity type filter
- Time period selector (30/90 days, all time)
- Color gradient legend (low to high intensity)
- Responsive design

## Controls
- **Activity Filter**: All, Cycling, Running
- **Period Filter**: Last 30 Days, Last 90 Days, All Time
- **Legend**: Visual intensity scale

## Colors
- Blue (#4aa6e0): Low activity
- Gold (#FFD700): Medium activity
- Red (#ff4444): High activity

## Accessibility
- `role="complementary"`
- Select elements with aria-labels
- Canvas with descriptive label

## Usage
```html
<div class="tvs-heatmap">
  <div class="tvs-heatmap-controls">
    <select class="tvs-heatmap-filter">...</select>
    <select class="tvs-heatmap-period">...</select>
  </div>
  <div class="tvs-heatmap-canvas">
    <canvas></canvas>
    <div class="tvs-heatmap-legend">...</div>
  </div>
</div>
```
