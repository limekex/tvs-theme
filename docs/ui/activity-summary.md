# Activity Summary

## Overview
Displays user's recent activity sessions with different states (completed, in-progress, abandoned, planned).

## Files
- Template: `templates/activity-summary.html`
- Styles: `assets/activity-summary.css`
- Block: `blocks/my-activities/src/index.js`

## Features
- Recent activity list with icons
- Multiple states: completed, in-progress, abandoned, planned
- Stats: distance, time, pace
- Personal record badges
- Progress bars for active sessions
- Empty state for new users

## Accessibility
- `role="region"` and `role="list"`
- Activity icons marked `aria-hidden`
- Time elements with datetime attributes
- Descriptive aria-labels on stats

## Usage
```html
<div class="tvs-activity-summary">
  <div class="tvs-activity-header">
    <h2 class="tvs-activity-title">Recent Activities</h2>
    <a href="/my-activities" class="tvs-activity-view-all">View All</a>
  </div>
  <ul class="tvs-activity-list">
    <!-- Activity items -->
  </ul>
</div>
```
