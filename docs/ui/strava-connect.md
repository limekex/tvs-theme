# Strava Connect

## Overview
Interface for connecting/disconnecting Strava accounts with multiple states (disconnected, connected, connecting, error).

## Files
- Template: `templates/strava-connect.html`
- Styles: `assets/strava-connect.css`
- Block: `blocks/connect-strava/src/index.js`

## Features
- Disconnected state with features list
- Connected state with user info and stats
- Loading/connecting state with spinner
- Error state with retry option
- Sync status and manual sync button

## States
1. **Disconnected**: Connect CTA, features, privacy note
2. **Connected**: User avatar, stats (activities, distance, time), sync info, disconnect option
3. **Connecting**: Loading spinner, status message
4. **Error**: Error icon, message, retry button

## Accessibility
- Semantic HTML structure
- ARIA labels on all buttons
- Status updates for screen readers
- Keyboard accessible

## Usage
```html
<div class="tvs-strava-connect">
  <div class="tvs-strava-card tvs-strava-card--disconnected">
    <button class="tvs-btn tvs-btn--strava">Connect with Strava</button>
  </div>
</div>
```
