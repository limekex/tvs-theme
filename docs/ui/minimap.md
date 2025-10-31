# Minimap + Elevation Overlay

## Overview
Compact map widget with route visualization and elevation profile overlay.

## Files
- Template: `templates/minimap.html`
- Styles: `assets/minimap.css`

## Features
- Canvas-based minimap
- Current position marker with pulse animation
- Elevation profile chart
- Progress stats (current/total distance)
- Fixed positioning (bottom-right corner)
- Responsive sizing

## Components
- **Minimap Canvas**: Route path visualization
- **Position Marker**: Animated current location indicator
- **Elevation Chart**: SVG-based elevation profile
- **Stats Display**: Current progress and total elevation

## Accessibility
- `role="complementary"`
- Canvas and SVG with aria-labels
- Descriptive stats text

## Usage
```html
<div class="tvs-minimap">
  <div class="tvs-minimap-container">
    <canvas class="tvs-minimap-canvas"></canvas>
    <div class="tvs-minimap-marker"></div>
  </div>
  <div class="tvs-elevation-overlay">
    <svg class="tvs-elevation-chart">...</svg>
    <div class="tvs-elevation-stats">...</div>
  </div>
</div>
```
