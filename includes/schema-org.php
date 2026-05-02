<?php
/**
 * Schema.org JSON-LD Structured Data
 * Generates and outputs Organization schema based on stored plugin options
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Generate Organization schema.org JSON-LD
 */
function sbo_generate_schema_org() {
	// Build schema object
	$schema = [
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
	];

	// ID (homepage-based)
	$home_url = sbo_get( 'one_home_url' );
	if ( $home_url ) {
		$schema['@id'] = trailingslashit( $home_url ) . '#organization';
	}

	// Basic info
	$business_name = sbo_get( 'one_business_name' );
	if ( $business_name ) {
		$schema['name'] = $business_name;
	}

	if ( $home_url ) {
		$schema['url'] = $home_url;
	}

	// Logo
	$logo_url = sbo_get( 'one_business_logo' );
	if ( $logo_url ) {
		$logo_width  = sbo_get( 'one_header_logo_w', '600' );
		$logo_height = sbo_get( 'one_header_logo_h', '60' );

		$schema['logo'] = [
			'@type'  => 'ImageObject',
			'url'    => $logo_url,
			'width'  => (string) $logo_width,
			'height' => (string) $logo_height,
		];
	}

	// Description
	$description = sbo_get( 'one_business_description' );
	if ( $description ) {
		$schema['description'] = $description;
	}

	// Social profiles (sameAs)
	$sameAs = [];
	$social_fields = [
		'social-facebook'        => 'https://www.facebook.com/',
		'social-instagram'       => 'https://www.instagram.com/',
		'social-linkedin'        => 'https://www.linkedin.com/',
		'social-youtube'         => 'https://www.youtube.com/',
		'social-twitter-x'       => 'https://twitter.com/',
		'social-google-business' => '',
		'social-pinterest'       => 'https://www.pinterest.com/',
		'social-bing'            => 'https://www.bing.com/',
		'social-tiktok'          => 'https://www.tiktok.com/',
		'social-snapchat'        => 'https://www.snapchat.com/',
		'social-reddit'          => 'https://www.reddit.com/',
		'social-wordpress'       => 'https://profiles.wordpress.org/',
		'social-whatsapp'        => 'https://wa.me/',
		'social-yelp'            => 'https://www.yelp.com/',
		'social-tripadvisor'     => 'https://www.tripadvisor.com/',
		'social-github'          => 'https://www.github.com/',
		'social-bbb'             => 'https://www.bbb.org/',
	];

	foreach ( $social_fields as $field => $base_url ) {
		$url = sbo_get( $field );
		if ( $url ) {
			$sameAs[] = $url;
		}
	}

	if ( ! empty( $sameAs ) ) {
		$schema['sameAs'] = $sameAs;
	}

	// Address
	$street = sbo_get( 'one_street_address' );
	$city   = sbo_get( 'one_city' );
	$state  = sbo_get( 'one_state' );
	$zip    = sbo_get( 'one_postal_code' );
	$country = sbo_get( 'one_country', 'US' );

	if ( $street || $city || $state || $zip || $country ) {
		$schema['address'] = [
			'@type' => 'PostalAddress',
		];

		if ( $street ) {
			$schema['address']['streetAddress'] = $street;
		}
		if ( $city ) {
			$schema['address']['addressLocality'] = $city;
		}
		if ( $state ) {
			$schema['address']['addressRegion'] = $state;
		}
		if ( $zip ) {
			$schema['address']['postalCode'] = $zip;
		}
		if ( $country ) {
			$schema['address']['addressCountry'] = $country;
		}
	}

	// Geo (latitude/longitude)
	$latitude  = sbo_get( 'one_latitude' );
	$longitude = sbo_get( 'one_longitude' );

	if ( $latitude && $longitude ) {
		$schema['geo'] = [
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) $latitude,
			'longitude' => (float) $longitude,
		];
	}

	// Contact Point
	$phone = sbo_get( 'one_business_phone' );
	$email = sbo_get( 'one_business_email' );

	if ( $phone || $email ) {
		$schema['contactPoint'] = [
			'@type'       => 'ContactPoint',
			'contactType' => 'customer service',
		];

		if ( $phone ) {
			// Format phone for schema (remove formatting, keep only digits and +)
			$phone_clean = preg_replace( '/[^\d+\-\(\)\s]/', '', $phone );
			$schema['contactPoint']['telephone'] = $phone_clean;
		}

		if ( $email ) {
			$schema['contactPoint']['email'] = $email;
		}
	}

	/**
	 * Filter the Organization schema before output
	 *
	 * @param array $schema The schema array
	 * @return array Modified schema
	 */
	$schema = apply_filters( 'sbo_schema_org_organization', $schema );

	return $schema;
}

/**
 * Output schema.org JSON-LD in wp_head
 */
function sbo_output_schema_org() {
	// Only output if we have enough data
	$business_name = sbo_get( 'one_business_name' );
	$home_url      = sbo_get( 'one_home_url' );

	if ( ! $business_name || ! $home_url ) {
		return; // Skip output if essential fields are missing
	}

	$schema = sbo_generate_schema_org();

	// Output as JSON-LD script tag
	?>
	<script type="application/ld+json">
	<?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES ); ?>
	</script>
	<?php
}

add_action( 'wp_head', 'sbo_output_schema_org', 5 );
