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



## CSV sample file

Section,Field,Value
Branding,website_name,SiteBuilderOne
Branding,one_business_logo,https://www.sitebuilderone.com/wp-content/uploads/sitebuilderone_websites_wordpress.svg
Branding,one_business_description,"Local business website builders for trades, services and contractors"
Branding,one_business_keywords,"website design"
Branding,one_banner_image,
Marketing,one_headline,"We Build Websites for Speed & Success"
Marketing,one_headline_support,"Professional, performance based websites that help your business get found online.
From setup to on-going updates, we handle it all so you can focus on things that matter to you."
Marketing,one_marketing_image,https://www.sitebuilderone.com/wp-content/uploads/wordpress-website-design.jpg
Projects,logo,https://www.sitebuilderone.com/wp-content/uploads/sitebuilderone_websites_wordpress.svg
"Social Media",social-facebook,https://www.facebook.com/sitebuilderone/
"Social Media",social-linkedin,https://ca.linkedin.com/company/sitebuilderone
"Social Media",social-youtube,https://www.youtube.com/@sitebuilderone7398
"Social Media",socal-twitter-x,https://twitter.com/sitebuilderone
"Social Media",social-wordpress,https://profiles.wordpress.org/sitebuilderone/
"Social Media",social-yelp,https://www.yelp.com/biz/site-builder-one-abbotsford
"Social Media",social-github,https://github.com/sitebuilderone
"Business Information",one_business_name,SiteBuilderOne
"Business Information",one_business_phone,780-830-0169
"Business Information",one_phone_web_ready,7808300169
"Business Information",one_business_email,sitebuilderone@gmail.com
"Physical Address",one_city,Abbotsford
"Physical Address",one_state,BC
"Physical Address",one_google_map_url,"https://www.google.com/maps/place/SiteBuilderOne/@49.0555218,-122.2413169,14.66z/data=!4m6!3m5!1s0x54844b327b9f71b1:0x60a7bc1ddb9863a5!8m2!3d49.0485587!4d-122.2575293!16s%2Fg%2F11g0mtbz7z?entry=ttu&g_ep=EgoyMDI1MDIwNC4wIKXMDSoASAFQAw%3D%3D"
"Physical Address",one_google_map_embed,"<iframe src=""https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13194.718076306175!2d-122.24131693309847!3d49.05552180732941!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54844b327b9f71b1%3A0x60a7bc1ddb9863a5!2sSiteBuilderOne!5e0!3m2!1sen!2sca!4v1738905650539!5m2!1sen!2sca"" width=""600"" height=""450"" style=""border:0;"" allowfullscreen="""" loading=""lazy"" referrerpolicy=""no-referrer-when-downgrade""></iframe>"
"Business Schema Details",one_price_range,$$
"Business Schema Details",one_opening_hours,
Integrations,one_header_code,"<meta name=""msvalidate.01"" content=""16B2C98935400A9E8FD7AC4E298B3C05"" />"
Integrations,one_g-google_analytics,https://analytics.google.com/analytics/web/#/p251075247/reports/intelligenthome
Integrations,one_g-google_search_console,https://search.google.com/search-console?resource_id=https%3A%2F%2Fwww.sitebuilderone.com%2F
Integrations,one_google_search_console_insights,https://search.google.com/search-console/insights/?resource_id=https%3A%2F%2Fwww.sitebuilderone.com%2F&hl=en
Integrations,one_looker_studio,"<iframe width=""600"" height=""800"" src=""https://lookerstudio.google.com/embed/reporting/78c05189-5d66-4a65-a1da-ef10e891b31e/page/a01gD"" frameborder=""0"" style=""border:0"" allowfullscreen sandbox=""allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox""></iframe>"
Integrations,one_bing_webmaster,https://www.bing.com/webmasters?siteUrl=https%3A%2F%2Fwww.sitebuilderone.com%2F

