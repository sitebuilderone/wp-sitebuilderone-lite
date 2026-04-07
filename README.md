# wp-sitebuilderone-lite

Lightweight WordPress plugin for local business websites. Stores business data (branding, contact info, social media, integrations) in `wp_options` with zero external dependencies. Supports CSV import/export and full Google Local Business schema compliance.

**Lite version of:** https://github.com/sitebuilderone/wp-sitebuilderone

## Features

- ✅ **Admin Settings Page** — Single-page UI under Settings > SiteBuilderOne
- ✅ **Shortcode Support** — `[sbo_field name="one_business_name"]` for templates
- ✅ **PHP Helper** — `sbo_get('field_key')` for direct use in code
- ✅ **CSV Import/Export** — Bulk data management
- ✅ **Google Local Business Schema** — 36 fields for rich snippets
- ✅ **Copy-Friendly Shortcodes** — Reference with copy-to-clipboard in admin
- ✅ **LiveCanvas Compatible** — Works with LiveCanvas page builder
- ✅ **Zero Dependencies** — No ACF, no external plugins required

## Quick Start

1. Activate the plugin in WP Admin
2. Go to **Settings > SiteBuilderOne**
3. Fill in your business information
4. Use shortcodes in pages/posts: `[sbo_field name="one_business_name"]`
5. Or use PHP in templates: `echo sbo_get('one_business_name');`

**For detailed development instructions, see [`.claude/instructions.md`](.claude/instructions.md).**

## Field Organization

- **Branding** (5 fields) — Logo, name, description, keywords, banner
- **Marketing** (3 fields) — Headline, support copy, marketing image
- **Business Information** (4 fields) — Name, phone, email
- **Physical Address** (9 fields) — Street, city, state, ZIP, country, lat/long, Google Maps
- **Social Media** (7 fields) — Facebook, LinkedIn, YouTube, Twitter/X, WordPress, Yelp, GitHub
- **Business Schema Details** (2 fields) — Price range, opening hours
- **Integrations** (6 fields) — Meta tags, Google Analytics, Search Console, Looker Studio, Bing Webmaster

**Total: 36 fields**

## References

- [Google Local Business Schema](https://developers.google.com/search/docs/appearance/structured-data/local-business)
- [WordPress Options API](https://developer.wordpress.org/plugins/settings/options-api/)

