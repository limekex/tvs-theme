# Player Controls

## Overview
Video player controls with transport buttons, progress bar, pace matching, and tooltips.

## Files
- Template: `templates/player-controls.html`
- Styles: `assets/player-controls.css`

## Features
- Transport controls (play, pause, previous, next)
- Progress bar with time scrubbing
- Pace matching toggle and display
- Volume control
- Settings and fullscreen buttons
- Keyboard shortcuts (Space, M, F, arrows)
- Hover tooltips

## Controls
- **Play/Pause**: Large primary button
- **Skip**: Previous/next section buttons
- **Progress**: Draggable progress bar with tooltip
- **Pace Match**: Shows current pace (e.g., 3:45/km)
- **Volume**: Mute/unmute toggle
- **Settings**: Configuration menu
- **Fullscreen**: Toggle fullscreen mode

## Accessibility
- ARIA labels on all buttons
- Keyboard shortcuts with title attributes
- Focus indicators
- Screen reader announcements

## Usage
```html
<div class="tvs-player-controls">
  <div class="tvs-player-bar">
    <div class="tvs-player-group">
      <!-- Transport buttons -->
    </div>
    <div class="tvs-player-progress-container">
      <input type="range" class="tvs-player-progress"/>
    </div>
  </div>
</div>
```
