Norway Virtual Sport — Theme & Blocks Workspace

This workspace contains a scaffold for a block-based WordPress theme and a small companion plugin used for local development.

Quick start (local WP instance):

1. Copy `themes/norway-virtual-sport` into your WordPress `wp-content/themes/` directory.
2. Copy `plugins/tvs-blocks` into `wp-content/plugins/`.
3. In the theme folder, run:

```bash
cd themes/norway-virtual-sport
npm install
npm run build
```

4. Activate the `Norway Virtual Sport` theme and the `TVS Blocks (dev)` plugin in WP admin.

Developer notes:
- Theme is a block (FSE) theme scaffold. Templates in `block-templates/` are HTML placeholders to be converted to block templates in WP.
- Companion plugin exposes development REST endpoints: `/wp-json/tvs/v1/activities/me` and `/wp-json/tvs/v1/strava-status`.
- `tvs-app.js` is a placeholder script file; replace with real app bundle for single route pages.

Next steps:
- Implement the blocks in `blocks/*` with proper render callbacks or client-side block code.
- Replace mock REST handlers in `plugins/tvs-blocks` with real data hooks.
- Add map (Leaflet) integration and Strava OAuth flow in a secure plugin flow.
# tvs-theme
