<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Retrieve a single business field value.
 *
 * Uses a static cache so get_option() is called only once per request,
 * regardless of how many times sbo_get() or [sbo_field] is used on a page.
 *
 * @param string $field   The field key (e.g. 'one_business_name').
 * @param string $default Fallback value when the field is empty or not set.
 * @return string Raw stored value (unsanitized — caller decides escaping context).
 */

/**
 * [sbo_field] shortcode.
 *
 * Attributes:
 *   name    (required) — field key.
 *   default            — fallback string (default: '').
 *   raw                — set to "true" to output HTML embed fields without esc_html.
 *                        Values are already wp_kses_post()'d on save, so this is safe.
 *
 * Examples:
 *   [sbo_field name="one_business_name"]
 *   [sbo_field name="one_business_phone" default="Call us"]
 *   [sbo_field name="one_google_map_embed" raw="true"]
 */
add_action( 'init', function () {
	add_shortcode( 'sbo_field', function ( $atts ) {
		$atts = shortcode_atts(
			[
				'name'    => '',
				'default' => '',
				'raw'     => 'false',
			],
			$atts,
			'sbo_field'
		);

		if ( '' === $atts['name'] ) return '';

		$value = sbo_get( $atts['name'], $atts['default'] );

		if ( 'true' === strtolower( $atts['raw'] ) ) {
			return $value; // Already kses'd on save — safe to output directly.
		}

		return esc_html( $value );
	} );

	add_shortcode( 'sbo_url', function( $atts ) {
    $atts = shortcode_atts( [ 'name' => '' ], $atts, 'sbo_url' );
    if ( '' === $atts['name'] ) return '';
    return esc_url( sbo_get( $atts['name'] ) );
} );


} );




add_action( 'init', function() {
    if ( function_exists( 'tangible_template' ) ) {
        tangible_template()->set_variable( 
            'sbo_marketing_image', 
            esc_url( sbo_get( 'one_marketing_image' ) ) 
        );
    }
});


add_action( 'plugins_loaded', function() {
    add_filter( 'tangible_template_variable', function( $value, $name ) {
        // Allow any sbo_ field to be accessed as {sbo_one_marketing_image} etc.
        if ( str_starts_with( $name, 'sbo_' ) ) {
            $field = substr( $name, 4 ); // strip "sbo_" prefix
            return esc_url( sbo_get( $field ) );
        }
        return $value;
    }, 10, 2 );
} );




// In includes/shortcodes.php
add_shortcode( 'sbo_link', function( $atts, $content ) {
    $atts = shortcode_atts( ['name' => '', 'default' => '#'], $atts, 'sbo_link' );
    $url  = sbo_get( $atts['name'], $atts['default'] );
    return '<a href="' . esc_url( $url ) . '">' . esc_html( $content ) . '</a>';
}, 10, 2 );

/**
 * [sbo_custom_logo] shortcode.
 * Returns just the URL to the Customizer logo image.
 *
 * Attributes:
 *   size — image size (default: 'full')
 *
 * Examples:
 *   [sbo_custom_logo]
 *   [sbo_custom_logo size="medium"]
 */
add_shortcode( 'sbo_custom_logo', function ( $atts ) {
    $atts = shortcode_atts(
        [ 'size' => 'full' ],
        $atts,
        'sbo_custom_logo'
    );

    $logo_id = get_theme_mod( 'custom_logo' );
    if ( ! $logo_id ) return '';

    $url = wp_get_attachment_image_url( $logo_id, $atts['size'] );
    if ( ! $url ) return '';

    // Strip the scheme + host so LiveCanvas doesn't double-prefix it.
    $parsed = wp_parse_url( $url );
    if ( isset( $parsed['path'] ) ) {
        return ltrim( $parsed['path'], '/' );
    }
    return $url;
} );


/**
 * [sbo_url name="field_key"] 
 * Returns only the absolute URL of an image field.
 */
add_shortcode( 'sbo_url', function ( $atts ) {
    $a = shortcode_atts( [
        'name' => '',
    ], $atts );

    if ( empty( $a['name'] ) ) return '';

    $url = sbo_get( $a['name'] );

    // Ensure we return a valid absolute URL
    return esc_url_raw( $url );
} );

/**
 * [sbo_image_url name="field_key"]
 * Returns an escaped image/media URL from a saved SiteBuilderOne field.
 *
 * Example:
 *   [sbo_image_url name="one_marketing_image"]
 */
add_shortcode( 'sbo_image_url', function ( $atts ) {
    $atts = shortcode_atts(
        [
            'name'    => 'one_marketing_image',
            'default' => '',
        ],
        $atts,
        'sbo_image_url'
    );

    $url = sbo_get( $atts['name'], $atts['default'] );

    return $url ? esc_url( $url ) : '';
} );

/**
 * [sbo_background_image_style name="field_key"]
 * Returns CSS declarations for a background image so builders do not need
 * to parse a shortcode nested inside url('...').
 *
 * Example:
 *   style='[sbo_background_image_style name="one_marketing_image"]'
 */
add_shortcode( 'sbo_background_image_style', function ( $atts ) {
    $atts = shortcode_atts(
        [
            'name'     => 'one_marketing_image',
            'overlay'  => '0.55',
            'position' => 'center',
            'size'     => 'cover',
        ],
        $atts,
        'sbo_background_image_style'
    );

    $url = sbo_get( $atts['name'] );
    if ( ! $url ) return '';

    $overlay = max( 0, min( 1, (float) $atts['overlay'] ) );

    return sprintf(
        'background-image: linear-gradient(rgba(0,0,0,%1$s), rgba(0,0,0,%1$s)), url(%2$s); background-size: %3$s; background-position: %4$s;',
        esc_attr( $overlay ),
        esc_url( $url ),
        esc_attr( $atts['size'] ),
        esc_attr( $atts['position'] )
    );
} );


/**
 * [sbo_header_cta_url]
 * Returns the path-only URL for the Header CTA page field.
 * Strips scheme + host so LiveCanvas doesn't double-prefix it.
 */
add_shortcode( 'sbo_header_cta_url', function() {
    $url = sbo_get( 'one_header_cta_URL' );
    if ( ! $url ) return '';
    $parsed = wp_parse_url( $url );
    $path   = ltrim( $parsed['path'] ?? '/', '/' );
    return $path . ( isset( $parsed['query'] ) ? '?' . $parsed['query'] : '' );
} );

/**
 * [sbo_header_logo_dimensions]
 * Returns HTML width/height attributes from header logo fields.
 * Example output: width="60" height="24"
 */
add_shortcode( 'sbo_header_logo_dimensions', function() {
    $width  = absint( sbo_get( 'one_header_logo_w' ) );
    $height = absint( sbo_get( 'one_header_logo_h' ) );

    // Backward-compatible fallbacks for alternate field keys.
    if ( $width <= 0 ) {
        $width = absint( sbo_get( 'one_header_logo_width' ) );
    }
    if ( $height <= 0 ) {
        $height = absint( sbo_get( 'one_header_logo_height' ) );
    }

    $attrs = [];
    if ( $width > 0 ) {
        $attrs[] = sprintf( 'width="%d"', $width );
    }
    if ( $height > 0 ) {
        $attrs[] = sprintf( 'height="%d"', $height );
    }

    return implode( ' ', $attrs );
} );

/**
 * [sbo_header_logo_img]
 * Returns a complete <img> tag for the site logo to avoid shortcode-in-attribute parsing issues.
 */
add_shortcode( 'sbo_header_logo_img', function( $atts ) {
    $atts = shortcode_atts(
        [
            'size'    => 'full',
            'class'   => 'd-inline-block align-top',
            'alt'     => '',
            'loading' => 'lazy',
        ],
        $atts,
        'sbo_header_logo_img'
    );

    $logo_id = get_theme_mod( 'custom_logo' );
    if ( ! $logo_id ) return '';

    $src = wp_get_attachment_image_url( $logo_id, $atts['size'] );
    if ( ! $src ) return '';

    $width  = absint( sbo_get( 'one_header_logo_w' ) );
    $height = absint( sbo_get( 'one_header_logo_h' ) );

    if ( $width <= 0 ) {
        $width = absint( sbo_get( 'one_header_logo_width' ) );
    }
    if ( $height <= 0 ) {
        $height = absint( sbo_get( 'one_header_logo_height' ) );
    }

    $alt = '' !== trim( (string) $atts['alt'] )
        ? (string) $atts['alt']
        : sbo_get( 'website_name', get_bloginfo( 'name' ) );

    $html = sprintf(
        '<img src="%s" class="%s" alt="%s" loading="%s"',
        esc_url( $src ),
        esc_attr( $atts['class'] ),
        esc_attr( $alt ),
        esc_attr( $atts['loading'] )
    );

    if ( $width > 0 ) {
        $html .= sprintf( ' width="%d"', $width );
    }
    if ( $height > 0 ) {
        $html .= sprintf( ' height="%d"', $height );
    }

    $html .= ' />';
    return $html;
} );

/**
 * [sbo_faq]
 * Renders FAQ items from the 'faq' custom post type as HTML.
 *
 * Attributes:
 *   count — max number of FAQs (default: -1 = all)
 *   tag   — filter by tag slug, comma-separated for multiple (default: '' = all)
 *
 * Examples:
 *   [sbo_faq]
 *   [sbo_faq count="6"]
 *   [sbo_faq tag="web-design"]
 *   [sbo_faq tag="web-design,seo" count="6"]
 */
add_shortcode( 'sbo_faq', function( $atts ) {
    $atts = shortcode_atts(
        [
            'count'  => -1,
            'tag'    => '',
            'schema' => 'true',  // Set to "false" to skip injecting JSON-LD into <head>.
        ],
        $atts,
        'sbo_faq'
    );

    $args = [
        'post_type'      => 'faq',
        'posts_per_page' => intval( $atts['count'] ),
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    ];

    if ( '' !== trim( $atts['tag'] ) ) {
        $args['tax_query'] = [ [
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => array_map( 'trim', explode( ',', $atts['tag'] ) ),
        ] ];
    }

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return '';
    }

    $schema_script = '';
    // Optionally inject FAQPage schema. If wp_head has already fired, fall back to inline output.
    if ( 'true' === strtolower( $atts['schema'] ) ) {
        $json = sbo_build_faq_schema( $args );
        if ( $json ) {
            $schema_script = '<script type="application/ld+json">' . $json . '</script>';
            if ( did_action( 'wp_head' ) === 0 ) {
                add_action( 'wp_head', function() use ( $schema_script ) {
                    echo $schema_script . "\n";
                } );
                $schema_script = '';
            }
        }
    }

    $html = '';
    foreach ( $query->posts as $post ) {
        $title   = esc_html( $post->post_title );
        $content = apply_filters( 'the_content', $post->post_content );

        $html .= '<div class="lc-block mb-5">';
        $html .= '<p class="h4">' . $title . '</p>';
        $html .= '<div>' . $content . '</div>';
        $html .= '</div>';
    }

    wp_reset_postdata();

    return $schema_script . $html;
} );

/**
 * Shared helper: builds the FAQPage schema array from WP_Query args.
 * Returns the JSON string or empty string if no results.
 *
 * @param array $args WP_Query args (post_type, tax_query, etc. already set).
 * @return string JSON-encoded schema or ''.
 */
function sbo_build_faq_schema( array $args ): string {
    $query = new WP_Query( $args );
    if ( ! $query->have_posts() ) {
        return '';
    }

    $main_entity = [];
    foreach ( $query->posts as $post ) {
        $question = wp_strip_all_tags( $post->post_title );
        $answer   = wp_strip_all_tags( apply_filters( 'the_content', $post->post_content ) );
        $answer   = preg_replace( '/\s+/', ' ', trim( $answer ) );

        if ( '' === $question || '' === $answer ) {
            continue;
        }

        $main_entity[] = [
            '@type'          => 'Question',
            'name'           => $question,
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $answer,
            ],
        ];
    }

    if ( empty( $main_entity ) ) {
        return '';
    }

    return wp_json_encode(
        [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $main_entity,
        ],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
}

/**
 * Builds WP_Query args from sbo_faq shortcode atts (shared by both schema shortcodes).
 */
function sbo_faq_query_args( array $atts ): array {
    $args = [
        'post_type'      => 'faq',
        'posts_per_page' => intval( $atts['count'] ),
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    ];

    if ( '' !== trim( $atts['tag'] ) ) {
        $args['tax_query'] = [ [
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => array_map( 'trim', explode( ',', $atts['tag'] ) ),
        ] ];
    }

    return $args;
}

/**
 * [sbo_faq_schema_head]
 * Registers FAQ schema to be injected into <head> via wp_head.
 * Place this shortcode anywhere on the page — outputs nothing inline.
 *
 * Attributes:
 *   count — max number of FAQs (default: -1 = all)
 *   tag   — filter by tag slug, comma-separated (default: '' = all)
 *
 * Examples:
 *   [sbo_faq_schema_head tag="web-design"]
 *   [sbo_faq_schema_head tag="web-design,seo" count="6"]
 */
add_shortcode( 'sbo_faq_schema_head', function( $atts ) {
    $atts = shortcode_atts( [ 'count' => -1, 'tag' => '' ], $atts, 'sbo_faq_schema_head' );

    add_action( 'wp_head', function() use ( $atts ) {
        $json = sbo_build_faq_schema( sbo_faq_query_args( $atts ) );
        if ( $json ) {
            echo '<script type="application/ld+json">' . $json . '</script>' . "\n";
        }
    } );

    return ''; // No inline output.
} );

/**
 * [sbo_faq_schema]
 * Outputs a <script type="application/ld+json"> FAQPage schema block inline.
 * Use [sbo_faq_schema_head] instead to inject into <head>.
 *
 * Attributes:
 *   count — max number of FAQs to include (default: -1 = all)
 *   tag   — filter by tag slug, comma-separated (default: '' = all)
 *
 * Examples:
 *   [sbo_faq_schema]
 *   [sbo_faq_schema count="6"]
 *   [sbo_faq_schema tag="web-design"]
 *   [sbo_faq_schema tag="web-design,seo" count="6"]
 */
add_shortcode( 'sbo_faq_schema', function( $atts ) {
    $atts = shortcode_atts( [ 'count' => -1, 'tag' => '' ], $atts, 'sbo_faq_schema' );

    $json = sbo_build_faq_schema( sbo_faq_query_args( $atts ) );
    if ( ! $json ) {
        return '';
    }

    return '<script type="application/ld+json">' . $json . '</script>';
} );

add_shortcode('sbo_map_link', function() {
    // 1. Fetch the data using the logic your other shortcodes use
    // Using do_shortcode ensures we get the exact value your plugin expects
    $url     = do_shortcode('[sbo_url name="one_google_map_url"]');
    $address = do_shortcode('[sbo_field name="one_street_address"]');
    $city    = do_shortcode('[sbo_field name="one_city"]');
    $state   = do_shortcode('[sbo_field name="one_state"]');

    // 2. Build the HTML string
    $html = sprintf(
        '<a href="%s" class="sbo-map-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt me-3" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>%s, %s %s
        </a>',
        esc_url($url),
        esc_html($address),
        esc_html($city),
        esc_html($state)
    );

    return $html;
});

/**
 * [sbo_phone_link]
 * Renders a phone anchor with icon and label only when a phone href value exists.
 */
add_shortcode( 'sbo_phone_link', function( $atts ) {
    $a = shortcode_atts(
        [
            'href_field'  => 'one_phone_web_ready',
            'text_field'  => 'one_business_phone',
            'class'       => 'text-decoration-none',
            'icon_class'  => 'bi bi-telephone me-3',
            'width'       => '20',
            'height'      => '20',
        ],
        $atts,
        'sbo_phone_link'
    );

    $phone_href = trim( sbo_get( $a['href_field'] ) );
    if ( '' === $phone_href ) {
        return '';
    }

    $phone_text = trim( sbo_get( $a['text_field'] ) );
    if ( '' === $phone_text ) {
        $phone_text = $phone_href;
    }

    return sprintf(
        '<a href="tel:%s" class="%s"><svg xmlns="http://www.w3.org/2000/svg" width="%s" height="%s" fill="currentColor" class="%s" viewBox="0 0 16 16"><path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"></path></svg>%s</a>',
        esc_attr( $phone_href ),
        esc_attr( $a['class'] ),
        esc_attr( $a['width'] ),
        esc_attr( $a['height'] ),
        esc_attr( $a['icon_class'] ),
        esc_html( $phone_text )
    );
} );

/**
 * [sbo_email_link]
 * Renders an email anchor with icon and label only when an email value exists.
 */
add_shortcode( 'sbo_email_link', function( $atts ) {
    $a = shortcode_atts(
        [
            'field'      => 'one_business_email',
            'class'      => 'link-primary',
            'icon_class' => 'bi bi-envelope me-3',
            'width'      => '20',
            'height'     => '20',
        ],
        $atts,
        'sbo_email_link'
    );

    $email = trim( sbo_get( $a['field'] ) );
    if ( '' === $email ) {
        return '';
    }

    return sprintf(
        '<a href="mailto:%s" class="%s"><svg xmlns="http://www.w3.org/2000/svg" width="%s" height="%s" fill="currentColor" class="%s" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" /></svg>%s</a>',
        antispambot( sanitize_email( $email ) ),
        esc_attr( $a['class'] ),
        esc_attr( $a['width'] ),
        esc_attr( $a['height'] ),
        esc_attr( $a['icon_class'] ),
        esc_html( $email )
    );
} );
