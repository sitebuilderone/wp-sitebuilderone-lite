# AGENTS.md

This file provides guidance to Codex (Codex.ai/code) when working with code in this repository.

## What This Plugin Does

**wp-sitebuilderone-lite** stores local business data (branding, contact info, social media, address, schema, integrations) in a single WordPress option key (`sbo_options`) and exposes it via shortcodes and a PHP helper. It stores client-specific onboarding, SEO, content, and strategy context separately in `sbo_client_brief`. It also registers custom post types for Services, FAQs, and HowTos with post meta, shortcodes, REST fields, templates, and schema output. Zero external dependencies.

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
7. Create/edit Service, FAQ, and HowTo posts → meta persists and admin columns render
8. `[sb1_services]`, `[sb1_faq]`, and `[sb1_howto]` render expected content and schema
9. Service/FAQ/HowTo single URLs resolve after activation or rewrite-version changes
10. Save Client Brief sections → values persist under `sbo_client_brief` without changing `sbo_options`

## Architecture

### Business Data Model

Business settings are stored in one serialized array under `wp_options` key `sbo_options`. Field keys are prefixed with `one_` (e.g. `one_business_name`, `one_business_phone`).

### Client Brief Data Model

Client-specific onboarding and strategy context is stored separately under `wp_options` key `sbo_client_brief`. Its schema lives in `includes/client-brief.php` via `sbo_get_client_brief_schema()`. It is edited in **SiteBuilderOne > Client Brief** and accessed with `sbo_get_client_brief( $section, $field, $default )`.

Do not mix client brief data into `sbo_get_field_schema()` or `sbo_options`. The brief is for content strategy, SEO, positioning, service planning, FAQs, and client memory; `sbo_options` is for live site fields used by shortcodes/templates.

Client Brief Markdown import/export is schema-driven. Markdown headings must match section titles and bullet labels must match field labels, as in `client-briefs/_template.md`. Unknown headings/fields are ignored.

Client Brief prefill into live site fields is intentionally conservative. `sbo_get_client_brief_option_map()` maps selected brief fields to existing `sbo_options` keys. The **Fill Missing Site Fields** action only writes empty `sbo_options` fields and preserves existing live values.

### Field Schema — Single Source of Truth

`sbo_get_field_schema()` in `includes/admin.php` is the **only** place business option field definitions live. It drives admin form rendering, CSV import/export validation, and sanitization. 36 fields across 8 sections: Branding, Key Web Pages, Marketing, Business Information, Physical Address, Social Media, Business Schema Details, Integrations.

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

### Custom Post Types

Custom post type functionality is loaded from `includes/services.php` and `includes/faq.php` during `plugins_loaded`. Registration also runs during activation in `wp-sitebuilderone-lite.php`, followed by `flush_rewrite_rules()`.

Post types:

- `service` — managed under SiteBuilderOne > Services, public, REST base `services`, rewrite slug `services`, no archive, supports title/editor/thumbnail/excerpt/page-attributes.
- `faq` — managed under SiteBuilderOne > FAQs, public, REST base `faqs`, configurable rewrite slug from `SBO_FAQ_Admin_Settings::get_faq_slug()`, tagged with `post_tag`.
- `howto` — managed under SiteBuilderOne > HowTos, public, REST base `howtos`, configurable rewrite slug from `SBO_FAQ_Admin_Settings::get_howto_slug()`, tagged with `post_tag`.

Services also register the `service_tag` taxonomy in `includes/services/class-taxonomy.php`.

Rewrite flushes are version-gated with `sbo_services_rewrite_version` and `sbo_faq_rewrite_version`. When changing CPT rewrite settings, activation behavior, or `SBO_VERSION`, manually verify permalink resolution.

### CPT Meta

Service meta lives in `includes/services/class-meta-boxes.php`:

- `_sb1_short_description`
- `_sb1_icon`
- `_sb1_cta_url`
- `_sb1_service_type`
- `_sb1_service_area`

FAQ meta lives in `includes/faq/class-meta-boxes.php`:

- `_sb1_faq_answer`
- `_sb1_faq_related_service` (service post ID)

HowTo meta lives in `includes/faq/class-howto-meta-boxes.php`:

- `_sb1_howto_description`
- `_sb1_howto_total_time`
- `_sb1_howto_supplies`
- `_sb1_howto_steps` (array of up to 10 steps with `name`, `text`, `url`, `image`)

Meta sanitization is handled in the corresponding meta-box classes. REST exposure is handled in `class-rest-fields.php` files.

### CPT Shortcodes and Templates

- `[sb1_services]` renders services via `includes/services/class-shortcode.php`. Supports `count`, `columns`, `tag`, `orderby`, and `order`. Default template: `templates/services/services-grid.php`; theme override: `{theme}/sb1-services/services-grid.php`.
- `[sb1_faq]` renders FAQs via `includes/faq/class-shortcode.php`. Supports `count`, `service`, `orderby`, and `order`. Default template: `templates/faq/faq-list.php`; theme override: `{theme}/sb1-faq/faq-list.php`.
- `[sb1_howto]` renders HowTos via `includes/faq/class-howto-shortcode.php`. Supports `count`, `tag`, `orderby`, and `order`. Default template: `templates/faq/howto-list.php`; theme override: `{theme}/sb1-faq/howto-list.php`.

Schema output for these post types lives in `includes/services/class-schema.php`, `includes/faq/class-schema.php`, and `includes/faq/class-howto-schema.php`.

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
- CPT meta saves require nonce verification, autosave checks, and `current_user_can( 'edit_post', $post_id )`
- Client Brief saves require `manage_options`, nonce verification, and sanitized text/url/email values

## Renaming a Field Key (Breaking Change)

Field keys must not be renamed casually — existing shortcodes and PHP calls in themes will break. When renaming: add the new key, write a one-time migration to copy old → new, deprecate the old key, then remove it later.
