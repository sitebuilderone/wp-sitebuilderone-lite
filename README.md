# wp-sitebuilderone-lite

Lightweight WordPress plugin for local business websites. Stores business data (branding, contact info, social media, integrations) in `wp_options` with zero external dependencies. Supports CSV import/export, full Google Local Business schema compliance, and three custom post types for Services, FAQs, and HowTos.

**Lite version of:** https://github.com/sitebuilderone/wp-sitebuilderone

## Features

- ✅ **Admin Settings Page** — Single-page UI under Settings > SiteBuilderOne
- ✅ **Shortcode Support** — `[sbo_field name="one_business_name"]` for templates
- ✅ **PHP Helper** — `sbo_get('field_key')` for direct use in code
- ✅ **CSV Import/Export** — Bulk data management
- ✅ **Google Local Business Schema** — 36 fields for rich snippets
- ✅ **Services CPT** — `service` post type with tags, custom meta fields, REST fields, Schema.org markup, and `[sb1_services]` shortcode
- ✅ **FAQ CPT** — `faq` post type with answer meta, related-service linking, FAQ schema, and `[sb1_faq]` shortcode
- ✅ **HowTo CPT** — `howto` post type with steps, supplies, total time, HowTo schema, and `[sb1_howto]` shortcode
- ✅ **Copy-Friendly Shortcodes** — Reference panel with copy-to-clipboard in admin
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

## New website setup guide

- Settings > Media: Turn 'off' Organize my uploads into month- and year-based folders

---

## Custom Post Types

### Services

Services are managed under **SiteBuilderOne > Services**.

Each service supports:
- Featured image
- **Short Description** — displayed in the grid card
- **Icon** — image URL or CSS class (e.g. `fa-solid fa-gear`)
- **CTA Button URL** — optional call-to-action link
- **Service Type** — used in Schema.org markup (e.g. `Web Design`)
- **Area Served** — used in Schema.org markup (e.g. `Nationwide`)
- **Service Tags** — taxonomy for filtering

Single service pages use `/services/{slug}`. The `/services` path remains free for a custom landing page.

#### Shortcode: `[sb1_services]`

```
[sb1_services]
```

All parameters are optional:

| Parameter | Default | Description |
|-----------|---------|-------------|
| `count` | `-1` | Number of services to show (`-1` = all) |
| `columns` | `3` | Grid column count |
| `tag` | _(all)_ | Filter by service tag slug |
| `orderby` | `menu_order` | WP_Query `orderby` value |
| `order` | `ASC` | `ASC` or `DESC` |

**Examples:**

```
[sb1_services]
[sb1_services columns="2" tag="featured"]
[sb1_services count="6" columns="3" orderby="date" order="DESC"]
```

#### PHP usage in theme templates

```php
$services = new WP_Query([
    'post_type'      => 'service',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

while ( $services->have_posts() ) : $services->the_post();
    $short_desc = get_post_meta( get_the_ID(), '_sb1_short_description', true );
    $icon       = get_post_meta( get_the_ID(), '_sb1_icon', true );
    $cta_url    = get_post_meta( get_the_ID(), '_sb1_cta_url', true );
    $type       = get_post_meta( get_the_ID(), '_sb1_service_type', true );
    $area       = get_post_meta( get_the_ID(), '_sb1_service_area', true );
endwhile;
wp_reset_postdata();
```

#### Template override

Copy the plugin template to your theme to customise the markup:

```
{theme}/sb1-services/services-grid.php
```

---

### FAQs

FAQs are managed under **SiteBuilderOne > FAQs**. Each FAQ has a **Question** (post title), a plain-text **Answer**, and an optional link to a **Related Service**. FAQPage schema is injected automatically when the shortcode is used.

The URL base can be changed under **SiteBuilderOne > FAQ & HowTo**.

#### Shortcode: `[sb1_faq]`

```
[sb1_faq]
```

All parameters are optional:

| Parameter | Default | Description |
|-----------|---------|-------------|
| `count` | `-1` | Number of FAQs to show (`-1` = all) |
| `service` | _(all)_ | Filter by service slug or post ID |
| `orderby` | `menu_order` | WP_Query `orderby` value |
| `order` | `ASC` | `ASC` or `DESC` |

**Examples:**

```
[sb1_faq]
[sb1_faq service="web-design"]
[sb1_faq service="42" count="5" orderby="date" order="DESC"]
```

#### PHP usage in theme templates

```php
$faqs = new WP_Query([
    'post_type'      => 'faq',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

while ( $faqs->have_posts() ) : $faqs->the_post();
    $answer          = get_post_meta( get_the_ID(), '_sb1_faq_answer', true );
    $related_service = get_post_meta( get_the_ID(), '_sb1_faq_related_service', true ); // post ID
endwhile;
wp_reset_postdata();
```

#### Template override

```
{theme}/sb1-faq/faq-list.php
```

---

### HowTos

HowTos are managed under **SiteBuilderOne > HowTos**. Each HowTo supports a description, total time (ISO 8601), supplies list, and up to 10 numbered steps (name, instructions, image URL, optional URL). HowTo schema is injected automatically when the shortcode is used.

The URL base can be changed under **SiteBuilderOne > FAQ & HowTo**.

#### Shortcode: `[sb1_howto]`

```
[sb1_howto]
```

All parameters are optional:

| Parameter | Default | Description |
|-----------|---------|-------------|
| `count` | `-1` | Number of HowTos to show (`-1` = all) |
| `tag` | _(all)_ | Filter by WordPress tag slug or ID (comma-separated for multiple) |
| `orderby` | `menu_order` | WP_Query `orderby` value |
| `order` | `ASC` | `ASC` or `DESC` |

**Examples:**

```
[sb1_howto]
[sb1_howto tag="smart-thermostats"]
[sb1_howto tag="hvac,installation" count="3" orderby="date" order="DESC"]
```

#### PHP usage in theme templates

```php
$howtos = new WP_Query([
    'post_type'      => 'howto',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

while ( $howtos->have_posts() ) : $howtos->the_post();
    $description = get_post_meta( get_the_ID(), '_sb1_howto_description', true );
    $total_time  = get_post_meta( get_the_ID(), '_sb1_howto_total_time', true ); // ISO 8601, e.g. PT30M
    $supplies    = get_post_meta( get_the_ID(), '_sb1_howto_supplies', true );   // newline-delimited string
    $steps       = get_post_meta( get_the_ID(), '_sb1_howto_steps', true );      // array of ['name','text','image','url']
endwhile;
wp_reset_postdata();
```

#### Template override

```
{theme}/sb1-faq/howto-list.php
```

---

## Business Data Shortcodes

### `[sbo_field]`

Output any stored business field.

```
[sbo_field name="one_business_name"]
[sbo_field name="one_business_phone" default="Call us"]
[sbo_field name="one_google_map_embed" raw="true"]
```

### `[sbo_url]`

Output a field value as an escaped URL.

```
[sbo_url name="one_home_url"]
```

### `[sbo_link]` / `[sbo_social_*]`

```
[sbo_link name="one_home_url"]Visit our website[/sbo_link]
[sbo_social_facebook]
[sbo_social_linkedin width="32" height="32"]
```

Social icon shortcodes render nothing if the corresponding URL field is empty.

---

## References

- [Google Local Business Schema](https://developers.google.com/search/docs/appearance/structured-data/local-business)
- [WordPress Options API](https://developer.wordpress.org/plugins/settings/options-api/)
- [Schema.org FAQPage](https://schema.org/FAQPage)
- [Schema.org HowTo](https://schema.org/HowTo)
- [Schema.org Service](https://schema.org/Service)
