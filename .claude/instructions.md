# WP SiteBuilderOne Lite — AI Instructions

## Project Overview

**wp-sitebuilderone-lite** is a lightweight WordPress plugin for local business websites. It stores business data (branding, contact info, social media, integrations, schema fields) in `wp_options` with zero external dependencies.

### Key Features
- Single-page admin UI (Settings > SiteBuilderOne)
- Shortcode access: `[sbo_field name="one_business_name"]`
- PHP helper: `sbo_get('one_business_name')`
- CSV import/export for bulk data management
- Full Google Local Business schema support
- Copy-to-clipboard shortcode references in admin UI
- Works with LiveCanvas page builder

---

## Architecture

### File Structure
```
wp-sitebuilderone-lite/
├── wp-sitebuilderone-lite.php   # Plugin header + bootstrap loader
├── includes/
│   ├── admin.php                # Field schema, settings page, save handler
│   ├── shortcodes.php           # sbo_get() + [sbo_field] shortcode
│   └── csv.php                  # CSV export/import handlers
├── assets/
│   ├── css/admin.css            # Admin styles
│   └── js/admin.js              # Copy-to-clipboard functionality
└── .claude/
    ├── instructions.md          # This file
    └── launch.json              # Dev server configuration
```

### Data Storage
- **Single option key:** `sbo_options` in `wp_options` table
- **Format:** Serialized PHP array with field keys as array indices
- **Example:** `[ 'one_business_name' => 'Acme Corp', 'one_business_phone' => '555-1234' ]`

### Field Schema
Defined in `includes/admin.php` function `sbo_get_field_schema()`. This is the **single source of truth** used by:
- Admin form rendering
- CSV import/export validation
- Field sanitization

Current sections:
- **Branding** (5 fields)
- **Marketing** (3 fields)
- **Business Information** (4 fields)
- **Physical Address** (9 fields, including lat/long for schema)
- **Social Media** (7 fields)
- **Business Schema Details** (2 fields)
- **Integrations** (6 fields)

**Total: 36 fields**

---

## Development Workflow

### Setup
1. Clone repo and place in WordPress plugin directory
2. Activate in WP Admin > Plugins
3. Access settings at WP Admin > Settings > SiteBuilderOne
4. Dev site runs on `http://localhost:10018` (Local by Flywheel)

### Adding New Fields
1. **Edit `sbo_get_field_schema()`** in `includes/admin.php`
2. Add field to appropriate section:
   ```php
   'one_my_field' => [ 'label' => 'My Field Label', 'type' => 'text' ],
   ```
3. **Field types:** `text`, `email`, `url`, `textarea`, or add `'raw' => true` for HTML
4. Field automatically appears in:
   - Admin form
   - CSV export/import
   - Shortcode references
   - `sbo_get()` helper

### Field Types & Sanitization

| Type | Sanitization | Use Case |
|---|---|---|
| `text` | `sanitize_text_field()` | Names, simple text |
| `email` | `sanitize_email()` | Email addresses |
| `url` | `esc_url_raw()` | Links, removes non-http protocols |
| `textarea` | `sanitize_textarea_field()` | Multi-line text |
| `textarea` + `'raw' => true` | `wp_kses_post()` | HTML (iframes, meta tags) |

### Template Usage

**In shortcodes:**
```html
[sbo_field name="one_business_name"]
[sbo_field name="one_google_map_embed" raw="true"]
[sbo_field name="one_business_phone" default="Call us"]
```

**In PHP (theme/LiveCanvas):**
```php
// Simple text
echo esc_html( sbo_get( 'one_business_name' ) );

// HTML/embeds (already kses'd, safe to echo)
echo sbo_get( 'one_google_map_embed' );

// With fallback
echo esc_html( sbo_get( 'one_business_phone', 'Contact us' ) );

// As a tel: link
<a href="tel:<?= esc_attr( sbo_get( 'one_phone_web_ready' ) ) ?>">
  <?= esc_html( sbo_get( 'one_business_phone' ) ) ?>
</a>
```

---

## CSV Format

**Export/Import uses:**
```
Section,Field,Value
Branding,website_name,Acme Corp
Branding,one_business_logo,https://example.com/logo.png
Business Information,one_business_phone,555-1234
```

### Handling Complex Values
- **Multi-line text:** Quoted and escaped by `fputcsv()` automatically
- **HTML embeds:** Full iframe HTML is quoted and escaped; restored on import
- **Unknown fields:** Silently skipped during import (whitelist validation)
- **Merge behavior:** Import merges with existing; fields not in CSV are preserved

---

## Security

### Key Rules
- **Admin access only:** All settings require `manage_options` capability
- **CSRF protection:** Nonces on all forms (`wp_nonce_field()`, `check_admin_referer()`)
- **Output escaping:**
  - Shortcodes: `esc_html()` by default
  - Raw fields: `wp_kses_post()` on save, safe to echo
  - Admin forms: `esc_attr()` in inputs, `esc_textarea()` in textareas
- **URL sanitization:** `esc_url_raw()` strips non-http(s) protocols
- **CSV validation:** Field keys whitelisted against schema whitelist before import

### "Raw" Fields (HTML/Embeds)
Fields with `'raw' => true` accept HTML. On save, they are processed through `wp_kses_post()`, which:
- **Permits:** `<iframe>`, `<meta>`, common attributes (`src`, `style`, `width`, `height`, etc.)
- **Strips:** `<script>`, `javascript:` URLs, event handlers
- **Admin-only:** Only users with `manage_options` can edit these fields

---

## Testing

### Manual Tests
1. **Activate plugin** — no PHP errors in WP Admin
2. **Admin page loads** — Settings > SiteBuilderOne visible
3. **Save field** — values persist on reload
4. **Shortcode reference appears** — when field is filled
5. **Copy button works** — copies shortcode to clipboard
6. **CSV export** — downloads file matching README format
7. **CSV import** — parses file, updates options
8. **Shortcode on page** — `[sbo_field name="..."]` renders correctly
9. **PHP helper** — `sbo_get()` returns correct values
10. **Raw fields** — iframes and meta tags display without escaping

### CSV Round-Trip Test
1. Fill in a field in admin
2. Export CSV
3. Modify a value in the CSV
4. Re-import
5. Verify change appears in admin

---

## Common Tasks

### Add a New Section
In `sbo_get_field_schema()`, add a new top-level array key:
```php
'My Section' => [
    'my_field_1' => [ 'label' => 'Field 1', 'type' => 'text' ],
    'my_field_2' => [ 'label' => 'Field 2', 'type' => 'url' ],
],
```

### Change Field Label
Edit the `'label'` key in `sbo_get_field_schema()`. The field key (`one_business_name`) stays the same, so shortcodes don't break.

### Make a Field Accept HTML
Add `'raw' => true` to the field definition. The admin UI will show a `code` class textarea, and shortcodes can use `raw="true"`.

### Rename a Field Key (Breaking Change)
1. Add new field with new key in schema
2. Add admin notice about migration
3. Consider a one-time migration script to copy old → new
4. Eventually remove old field
5. Update CSV import docs

---

## Known Limitations

- **No multi-language support** — single set of fields
- **No revision history** — CSV export is for backup; no undo
- **No per-field validation rules** — all text/textarea fields are user-editable
- **Depends on Local by Flywheel** (dev) — WordPress instance must be running

---

## Related Documentation

- **Google Local Business Schema:** https://developers.google.com/search/docs/appearance/structured-data/local-business
- **WordPress Options API:** https://developer.wordpress.org/plugins/settings/options-api/
- **WordPress Shortcode API:** https://developer.wordpress.org/plugins/shortcodes/
- **wp_kses_post():** Allows safe HTML subset for admin-controlled embeds

---

## Future Enhancements

- JSON export/import alongside CSV
- Revision history / snapshots
- Field-level validation rules (regex, required, min/max length)
- Multi-language field support
- Admin UI improvements (tab-based, drag-to-reorder)
- Schema.org JSON-LD auto-generation shortcode
