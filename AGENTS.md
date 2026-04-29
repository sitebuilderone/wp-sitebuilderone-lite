# AGENTS.md

This file provides guidance to Codex (Codex.ai/code) when working with code in this repository.

## What This Plugin Does

**wp-sitebuilderone-lite** stores local business data (branding, contact info, social media, address, schema, integrations) in a single WordPress option key (`sbo_options`) and exposes it via shortcodes and a PHP helper. Zero external dependencies.

Dev site runs at `http://localhost:10018` (Local by Flywheel).

## No Build Step

There is no build process, no `package.json`, no `composer.json`. PHP files are edited directly. The plugin loads via the `plugins_loaded` hook in `wp-sitebuilderone-lite.php`.

## Testing

All testing is manual — no PHPUnit, no Jest. Test checklist lives in `.Codex/instructions.md`. Key scenarios:

1. Activate plugin → no PHP errors
2. Save a field → value persists on reload
3. Shortcode reference appears when field is filled; copy button works
4. CSV export → import round-trip preserves and updates values
5. `[sbo_field name="..."]` and `sbo_get()` return correct output
6. Raw fields (iframes) render unescaped

## Architecture

### Data Model

Everything stored in one serialized array under `wp_options` key `sbo_options`. Field keys are prefixed with `one_` (e.g. `one_business_name`, `one_business_phone`).

### Field Schema — Single Source of Truth

`sbo_get_field_schema()` in `includes/admin.php` is the **only** place field definitions live. It drives admin form rendering, CSV import/export validation, and sanitization. 36 fields across 8 sections: Branding, Key Web Pages, Marketing, Business Information, Physical Address, Social Media, Business Schema Details, Integrations.

### Adding a Field

1. Add to the correct section in `sbo_get_field_schema()`:
   ```php
   'one_my_field' => [ 'label' => 'My Field', 'type' => 'text' ],
   ```
2. That's it — it auto-appears in the admin form, CSV export, shortcode reference, and `sbo_get()`.

**Field types:** `text`, `email`, `url`, `textarea`. Add `'raw' => true` to a `textarea` to allow HTML (sanitized via `wp_kses_post()` on save).

### Accessing Field Values

```php
// PHP helper (statically cached)
echo esc_html( sbo_get( 'one_business_name' ) );
echo sbo_get( 'one_google_map_embed' );         // raw fields already kses'd
echo esc_html( sbo_get( 'one_business_phone', 'Call us' ) ); // with fallback
```

```
[sbo_field name="one_business_name"]
[sbo_field name="one_google_map_embed" raw="true"]
[sbo_url name="one_home_url"]
[sbo_link name="one_home_url"]Text[/sbo_link]
[sbo_social_facebook]   (renders icon only if URL field is set)
```

### Social Icon Shortcodes

Defined in `includes/social-shortcodes.php`. Icon registry maps 14+ platforms to inline SVGs. Each shortcode accepts `width`, `height`, `fill`, `class` attributes and silently renders nothing if the corresponding URL field is empty.

### CSV Format

```
Section,Field,Value
Branding,website_name,Acme Corp
```

Import merges with existing options — fields absent from the CSV are preserved. Unknown field keys are silently skipped (whitelist validated against schema).

## Security Model

- All settings require `manage_options` capability
- CSRF: nonces on all forms (`wp_nonce_field` / `check_admin_referer`)
- Output: `esc_html()` in shortcodes, `esc_attr()` in admin inputs, `esc_url()` for URLs
- Raw HTML fields: `wp_kses_post()` strips `<script>`, `javascript:` URLs, event handlers; permits `<iframe>`, `<meta>`

## Renaming a Field Key (Breaking Change)

Field keys must not be renamed casually — existing shortcodes and PHP calls in themes will break. When renaming: add the new key, write a one-time migration to copy old → new, deprecate the old key, then remove it later.
