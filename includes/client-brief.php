<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function sbo_get_client_brief_schema(): array {
	return [
		'business_identity' => [
			'title'       => 'Business Identity',
			'description' => 'Basic business identity used across site copy, schema, metadata, header, footer, and brand messaging.',
			'questions'   => [
				'What is the exact public-facing business name?',
				'Is there a shorter brand name customers commonly use?',
				'What is the preferred one-sentence description of the business?',
				'What year was the business founded?',
				'Is the business family-owned, independent, franchise, licensed, certified, or otherwise credentialed?',
			],
			'fields'      => [
				'business_name'         => [ 'label' => 'Business name', 'type' => 'text' ],
				'short_brand_name'      => [ 'label' => 'Short brand name', 'type' => 'text' ],
				'website_url'           => [ 'label' => 'Website URL', 'type' => 'url' ],
				'business_description'  => [ 'label' => 'Business description', 'type' => 'textarea', 'rows' => 4 ],
				'year_founded'          => [ 'label' => 'Year founded', 'type' => 'text' ],
				'ownership_credentials' => [ 'label' => 'Ownership / credentials', 'type' => 'textarea', 'rows' => 3 ],
			],
		],
		'contact_location' => [
			'title'       => 'Contact & Location',
			'description' => 'NAP, hours, map, and location details used for contact sections, footer, and LocalBusiness context.',
			'questions'   => [
				'What phone number should be displayed publicly?',
				'What email address should customers use?',
				'What is the full physical address?',
				'Do customers visit this location, or is it service-area only?',
				'What are the business hours?',
			],
			'fields'      => [
				'display_phone'    => [ 'label' => 'Display phone', 'type' => 'text' ],
				'click_phone'      => [ 'label' => 'Click-to-call phone', 'type' => 'text' ],
				'email'            => [ 'label' => 'Email', 'type' => 'email' ],
				'street_address'   => [ 'label' => 'Street address', 'type' => 'text' ],
				'city'             => [ 'label' => 'City', 'type' => 'text' ],
				'state'            => [ 'label' => 'Province / state', 'type' => 'text' ],
				'postal_code'      => [ 'label' => 'Postal / ZIP code', 'type' => 'text' ],
				'country'          => [ 'label' => 'Country', 'type' => 'text' ],
				'latitude'         => [ 'label' => 'Latitude', 'type' => 'text' ],
				'longitude'        => [ 'label' => 'Longitude', 'type' => 'text' ],
				'google_maps_url'  => [ 'label' => 'Google Maps URL', 'type' => 'url' ],
				'business_hours'   => [ 'label' => 'Business hours', 'type' => 'textarea', 'rows' => 4 ],
				'location_notes'   => [ 'label' => 'Customer-facing location notes', 'type' => 'textarea', 'rows' => 3 ],
			],
		],
		'service_areas' => [
			'title'       => 'Service Areas',
			'description' => 'Cities, towns, neighborhoods, and regions to mention in local SEO copy and service pages.',
			'questions'   => [
				'What city is the primary target?',
				'What nearby cities or regions should be included?',
				'Are some areas higher priority than others?',
				'Are there areas the business does not want to serve?',
				'Does the business serve customers at its location, travel to customers, or both?',
			],
			'fields'      => [
				'primary_city'            => [ 'label' => 'Primary city', 'type' => 'text' ],
				'secondary_service_areas' => [ 'label' => 'Secondary service areas', 'type' => 'textarea', 'rows' => 4 ],
				'priority_areas'          => [ 'label' => 'Priority areas', 'type' => 'textarea', 'rows' => 3 ],
				'excluded_areas'          => [ 'label' => 'Excluded areas', 'type' => 'textarea', 'rows' => 3 ],
				'service_model'           => [ 'label' => 'Service model', 'type' => 'textarea', 'rows' => 3 ],
			],
		],
		'services' => [
			'title'       => 'Services',
			'description' => 'Core services that may become service pages, Service CPT entries, homepage cards, and SEO targets.',
			'questions'   => [
				'What are the main services customers ask for most often?',
				'Which services are most profitable or strategically important?',
				'Which services should have dedicated pages?',
				'Are there emergency, same-day, seasonal, or specialty services?',
				'Are there services the business offers but does not want to promote?',
			],
			'fields'      => [
				'priority_services' => [ 'label' => 'Priority services', 'type' => 'textarea', 'rows' => 7 ],
				'service_notes'     => [ 'label' => 'Service notes', 'type' => 'textarea', 'rows' => 5 ],
			],
		],
		'ideal_customers' => [
			'title'       => 'Ideal Customers',
			'description' => 'Audience context for copy, offers, CTAs, examples, and conversion messaging.',
			'questions'   => [
				'Who are the best customers for this business?',
				'Who are the highest-value customers?',
				'What situations usually trigger a call or form submission?',
				'What objections or concerns do customers commonly have?',
			],
			'fields'      => [
				'primary_customer_types'    => [ 'label' => 'Primary customer types', 'type' => 'textarea', 'rows' => 4 ],
				'high_value_customer_types' => [ 'label' => 'High-value customer types', 'type' => 'textarea', 'rows' => 3 ],
				'common_needs'              => [ 'label' => 'Common needs', 'type' => 'textarea', 'rows' => 4 ],
				'common_objections'         => [ 'label' => 'Common objections', 'type' => 'textarea', 'rows' => 4 ],
				'buying_triggers'           => [ 'label' => 'Buying triggers', 'type' => 'textarea', 'rows' => 4 ],
			],
		],
		'differentiators' => [
			'title'       => 'Differentiators',
			'description' => 'Reasons customers should choose this business over competitors, with proof.',
			'questions'   => [
				'What does the business do better than competitors?',
				'What proof supports those claims?',
				'Are there unique facilities, equipment, inventory, warranties, guarantees, or processes?',
				'What do customers mention most often in reviews?',
				'What should the site avoid claiming?',
			],
			'fields'      => [
				'main_differentiator'        => [ 'label' => 'Main differentiator', 'type' => 'textarea', 'rows' => 3 ],
				'supporting_differentiators' => [ 'label' => 'Supporting differentiators', 'type' => 'textarea', 'rows' => 5 ],
				'proof_points'               => [ 'label' => 'Proof points', 'type' => 'textarea', 'rows' => 5 ],
				'claims_to_avoid'            => [ 'label' => 'Claims to avoid', 'type' => 'textarea', 'rows' => 3 ],
			],
		],
		'brand_voice' => [
			'title'       => 'Brand Voice',
			'description' => 'Tone and language guidance for homepage, service pages, FAQs, CTAs, and metadata.',
			'questions'   => [
				'Should the tone feel professional, friendly, technical, premium, plainspoken, urgent, family-owned, or casual?',
				'Are there words or phrases the client uses often?',
				'Are there words or phrases to avoid?',
				'Should the business sound local and personal, or larger and more corporate?',
			],
			'fields'      => [
				'desired_tone'       => [ 'label' => 'Desired tone', 'type' => 'textarea', 'rows' => 3 ],
				'phrases_to_use'     => [ 'label' => 'Words / phrases to use', 'type' => 'textarea', 'rows' => 3 ],
				'phrases_to_avoid'   => [ 'label' => 'Words / phrases to avoid', 'type' => 'textarea', 'rows' => 3 ],
				'sales_intensity'    => [ 'label' => 'Sales intensity', 'type' => 'text' ],
				'personality_notes'  => [ 'label' => 'Personality notes', 'type' => 'textarea', 'rows' => 4 ],
			],
		],
		'homepage_messaging' => [
			'title'       => 'Homepage Messaging',
			'description' => 'Homepage positioning, above-the-fold message, proof points, and section priorities.',
			'questions'   => [
				'What is the single most important thing visitors should understand immediately?',
				'What primary action should visitors take?',
				'What secondary action should visitors take?',
				'What are the top three reasons to choose this business?',
				'What proof should appear on the homepage?',
			],
			'fields'      => [
				'primary_headline_idea' => [ 'label' => 'Primary headline idea', 'type' => 'textarea', 'rows' => 2 ],
				'supporting_headline'   => [ 'label' => 'Supporting headline', 'type' => 'textarea', 'rows' => 3 ],
				'primary_cta'           => [ 'label' => 'Primary CTA', 'type' => 'text' ],
				'secondary_cta'         => [ 'label' => 'Secondary CTA', 'type' => 'text' ],
				'homepage_proof_points' => [ 'label' => 'Homepage proof points', 'type' => 'textarea', 'rows' => 5 ],
				'homepage_sections'     => [ 'label' => 'Homepage sections to include', 'type' => 'textarea', 'rows' => 5 ],
			],
		],
		'calls_to_action' => [
			'title'       => 'Calls To Action',
			'description' => 'Button text, contact paths, sticky footer CTAs, and repeated conversion prompts.',
			'questions'   => [
				'Should customers call, book online, request a quote, schedule a consultation, or visit the location?',
				'Which CTA is most valuable?',
				'Are there different CTAs for different services?',
				'Is there a booking URL, contact page, phone link, or form URL?',
			],
			'fields'      => [
				'primary_cta_text'    => [ 'label' => 'Primary CTA text', 'type' => 'text' ],
				'primary_cta_url'     => [ 'label' => 'Primary CTA URL', 'type' => 'url' ],
				'secondary_cta_text'  => [ 'label' => 'Secondary CTA text', 'type' => 'text' ],
				'secondary_cta_url'   => [ 'label' => 'Secondary CTA URL', 'type' => 'url' ],
				'sticky_mobile_cta'   => [ 'label' => 'Sticky mobile CTA', 'type' => 'textarea', 'rows' => 3 ],
				'service_ctas'        => [ 'label' => 'Service-specific CTAs', 'type' => 'textarea', 'rows' => 5 ],
			],
		],
		'seo_keywords' => [
			'title'       => 'SEO Keywords',
			'description' => 'Search terms to use naturally in headings, service pages, metadata, FAQs, and internal links.',
			'questions'   => [
				'What phrases do customers use when searching for this service?',
				'What city/service combinations matter most?',
				'Are there brand, model, product, or specialty keywords?',
				'Are there informational topics that could become FAQs or HowTo posts?',
			],
			'fields'      => [
				'primary_keywords'       => [ 'label' => 'Primary keywords', 'type' => 'textarea', 'rows' => 4 ],
				'secondary_keywords'     => [ 'label' => 'Secondary keywords', 'type' => 'textarea', 'rows' => 4 ],
				'local_keywords'         => [ 'label' => 'Local keywords', 'type' => 'textarea', 'rows' => 4 ],
				'specialty_keywords'     => [ 'label' => 'Specialty keywords', 'type' => 'textarea', 'rows' => 4 ],
				'informational_keywords' => [ 'label' => 'FAQ / informational keywords', 'type' => 'textarea', 'rows' => 4 ],
				'keywords_to_avoid'      => [ 'label' => 'Keywords to avoid', 'type' => 'textarea', 'rows' => 3 ],
			],
		],
		'competitors' => [
			'title'       => 'Competitors',
			'description' => 'Local search landscape, offers, positioning, and differentiation opportunities.',
			'questions'   => [
				'Who are the main local competitors?',
				'Which competitors rank well online?',
				'Which competitors does the client respect?',
				'What competitor claims or offers does the client want to respond to?',
			],
			'fields'      => [
				'competitor_urls'     => [ 'label' => 'Competitor names / URLs', 'type' => 'textarea', 'rows' => 5 ],
				'competitor_strengths' => [ 'label' => 'Competitor strengths', 'type' => 'textarea', 'rows' => 4 ],
				'competitor_weaknesses'=> [ 'label' => 'Competitor weaknesses', 'type' => 'textarea', 'rows' => 4 ],
				'opportunities'        => [ 'label' => 'Differentiation opportunities', 'type' => 'textarea', 'rows' => 4 ],
			],
		],
		'reviews_proof' => [
			'title'       => 'Reviews & Proof',
			'description' => 'Trust signals for homepage sections, service pages, testimonials, and conversion copy.',
			'questions'   => [
				'Are there Google reviews, testimonials, case studies, or before/after examples we can use?',
				'What do happy customers usually praise?',
				'Are there photos of the team, location, vehicles, equipment, projects, or inventory?',
				'Are there awards, memberships, licenses, certifications, or media mentions?',
			],
			'fields'      => [
				'testimonials'       => [ 'label' => 'Testimonials', 'type' => 'textarea', 'rows' => 5 ],
				'review_themes'      => [ 'label' => 'Review themes', 'type' => 'textarea', 'rows' => 4 ],
				'case_studies'       => [ 'label' => 'Case studies', 'type' => 'textarea', 'rows' => 5 ],
				'photos_assets'      => [ 'label' => 'Photos / assets', 'type' => 'textarea', 'rows' => 4 ],
				'certifications'     => [ 'label' => 'Certifications / memberships', 'type' => 'textarea', 'rows' => 4 ],
				'awards_media'       => [ 'label' => 'Awards / media', 'type' => 'textarea', 'rows' => 3 ],
				'sensitive_claims'   => [ 'label' => 'Sensitive claims', 'type' => 'textarea', 'rows' => 3 ],
			],
		],
		'faqs' => [
			'title'       => 'FAQs',
			'description' => 'Common questions for FAQ CPT content, objection handling, SEO support, and service pages.',
			'questions'   => [
				'What questions do customers ask before booking?',
				'What questions do customers ask about price, timing, availability, warranty, location, or process?',
				'What misunderstandings need to be corrected?',
				'What questions should be answered on specific service pages?',
			],
			'fields'      => [
				'faq_ideas' => [ 'label' => 'FAQ ideas', 'type' => 'textarea', 'rows' => 10 ],
			],
		],
		'howto_topics' => [
			'title'       => 'HowTo / Guide Topics',
			'description' => 'Educational content ideas for HowTo CPT entries, blog posts, and internal linking.',
			'questions'   => [
				'What simple tasks or decisions can customers safely handle themselves?',
				'What warning signs should customers know about?',
				'What maintenance or seasonal advice would be useful?',
				'What topics demonstrate expertise without replacing the need for service?',
			],
			'fields'      => [
				'topics' => [ 'label' => 'Topics', 'type' => 'textarea', 'rows' => 8 ],
			],
		],
		'assets' => [
			'title'       => 'Assets',
			'description' => 'Visual and technical assets needed for branding, hero sections, service pages, and trust-building content.',
			'questions'   => [
				'Is there a logo, brand guide, or preferred color palette?',
				'Are there real photos of the business, team, work, vehicles, equipment, or location?',
				'Are stock photos acceptable, or should only real photos be used?',
				'Are there videos, brochures, PDFs, menus, price sheets, or service lists?',
			],
			'fields'      => [
				'logo'            => [ 'label' => 'Logo', 'type' => 'url' ],
				'brand_colors'    => [ 'label' => 'Brand colors', 'type' => 'textarea', 'rows' => 3 ],
				'fonts'           => [ 'label' => 'Fonts', 'type' => 'textarea', 'rows' => 3 ],
				'hero_images'     => [ 'label' => 'Hero images', 'type' => 'textarea', 'rows' => 4 ],
				'service_images'  => [ 'label' => 'Service images', 'type' => 'textarea', 'rows' => 4 ],
				'team_photos'     => [ 'label' => 'Team/location photos', 'type' => 'textarea', 'rows' => 4 ],
				'video'           => [ 'label' => 'Video', 'type' => 'textarea', 'rows' => 3 ],
				'documents'       => [ 'label' => 'PDFs / documents', 'type' => 'textarea', 'rows' => 4 ],
			],
		],
		'social_directory_profiles' => [
			'title'       => 'Social & Directory Profiles',
			'description' => 'Official profiles for social icons, authority signals, sameAs schema, and footer links.',
			'questions'   => [
				'What social profiles should be linked?',
				'Which profiles are active enough to show publicly?',
				'Is there a Google Business Profile URL?',
				'Are there Yelp, BBB, TripAdvisor, industry directory, or local chamber profiles?',
			],
			'fields'      => [
				'google_business_profile' => [ 'label' => 'Google Business Profile', 'type' => 'url' ],
				'facebook'                => [ 'label' => 'Facebook', 'type' => 'url' ],
				'instagram'               => [ 'label' => 'Instagram', 'type' => 'url' ],
				'linkedin'                => [ 'label' => 'LinkedIn', 'type' => 'url' ],
				'youtube'                 => [ 'label' => 'YouTube', 'type' => 'url' ],
				'tiktok'                  => [ 'label' => 'TikTok', 'type' => 'url' ],
				'yelp'                    => [ 'label' => 'Yelp', 'type' => 'url' ],
				'bbb'                     => [ 'label' => 'BBB', 'type' => 'url' ],
				'other_directories'       => [ 'label' => 'Other directories', 'type' => 'textarea', 'rows' => 4 ],
			],
		],
		'tracking_integrations' => [
			'title'       => 'Tracking & Integrations',
			'description' => 'Scripts and verification links for analytics, search console, reporting, pixels, booking, CRM, and chat.',
			'questions'   => [
				'Is Google Analytics already set up?',
				'Is Google Search Console verified?',
				'Are there ad pixels or tracking scripts?',
				'Are there booking, CRM, chat, review, or form integrations?',
			],
			'fields'      => [
				'google_analytics'      => [ 'label' => 'Google Analytics', 'type' => 'textarea', 'rows' => 3 ],
				'google_search_console' => [ 'label' => 'Google Search Console', 'type' => 'textarea', 'rows' => 3 ],
				'google_tag_manager'    => [ 'label' => 'Google Tag Manager', 'type' => 'textarea', 'rows' => 3 ],
				'ad_pixels'             => [ 'label' => 'Ad pixels', 'type' => 'textarea', 'rows' => 4 ],
				'looker_studio'         => [ 'label' => 'Looker Studio', 'type' => 'textarea', 'rows' => 4 ],
				'booking_crm'           => [ 'label' => 'Booking / CRM', 'type' => 'textarea', 'rows' => 4 ],
				'chat'                  => [ 'label' => 'Chat', 'type' => 'textarea', 'rows' => 3 ],
				'other_scripts'         => [ 'label' => 'Other scripts', 'type' => 'textarea', 'rows' => 4 ],
			],
		],
		'required_pages' => [
			'title'       => 'Required Pages',
			'description' => 'Page plan for navigation, internal links, page selectors, service entries, and footer links.',
			'questions'   => [
				'Which pages are required at launch?',
				'Which service pages need dedicated content?',
				'Is there an About page, Contact page, Blog, Privacy Policy, Terms page, or Sitemap?',
				'Are there landing pages for cities, services, or campaigns?',
			],
			'fields'      => [
				'pages' => [ 'label' => 'Pages', 'type' => 'textarea', 'rows' => 10 ],
			],
		],
		'raw_markdown' => [
			'title'       => 'Raw Markdown / Call Notes',
			'description' => 'Flexible notes from calls, PDFs, emails, strategy docs, and future decisions.',
			'questions'   => [
				'Is there anything important that does not fit cleanly into the sections above?',
				'Are there excerpts from a call, PDF, or client email to preserve?',
			],
			'fields'      => [
				'notes' => [ 'label' => 'Notes', 'type' => 'textarea', 'rows' => 12 ],
			],
		],
	];
}

function sbo_get_client_brief( string $section = '', string $field = '', $default = '' ) {
	$brief = get_option( SBO_CLIENT_BRIEF_OPTION_KEY, [] );

	if ( '' === $section ) {
		return is_array( $brief ) ? $brief : [];
	}

	if ( ! isset( $brief[ $section ] ) || ! is_array( $brief[ $section ] ) ) {
		return $default;
	}

	if ( '' === $field ) {
		return $brief[ $section ];
	}

	return isset( $brief[ $section ][ $field ] ) && '' !== $brief[ $section ][ $field ]
		? $brief[ $section ][ $field ]
		: $default;
}

function sbo_sanitize_client_brief_data( array $posted ): array {
	$schema = sbo_get_client_brief_schema();
	$data   = [];

	foreach ( $schema as $section_key => $section ) {
		$data[ $section_key ] = [];
		$fields = $section['fields'] ?? [];

		foreach ( $fields as $field_key => $meta ) {
			$value = $posted[ $section_key ][ $field_key ] ?? '';
			$type  = $meta['type'] ?? 'text';

			if ( 'url' === $type ) {
				$data[ $section_key ][ $field_key ] = esc_url_raw( $value );
			} elseif ( 'email' === $type ) {
				$data[ $section_key ][ $field_key ] = sanitize_email( $value );
			} elseif ( 'textarea' === $type ) {
				$data[ $section_key ][ $field_key ] = sanitize_textarea_field( $value );
			} else {
				$data[ $section_key ][ $field_key ] = sanitize_text_field( $value );
			}
		}
	}

	return $data;
}

function sbo_client_brief_to_markdown( array $brief ): string {
	$schema = sbo_get_client_brief_schema();
	$lines  = [
		'# Client Brief',
		'',
		'Generated from SiteBuilderOne Client Brief.',
		'',
	];

	foreach ( $schema as $section_key => $section ) {
		$lines[] = '## ' . $section['title'];
		$lines[] = '';

		foreach ( $section['fields'] as $field_key => $meta ) {
			$value = $brief[ $section_key ][ $field_key ] ?? '';
			$value = is_scalar( $value ) ? (string) $value : '';

			if ( '' === trim( $value ) ) {
				$lines[] = '- ' . $meta['label'] . ':';
				continue;
			}

			if ( false === strpos( $value, "\n" ) ) {
				$lines[] = '- ' . $meta['label'] . ': ' . $value;
				continue;
			}

			$lines[] = '- ' . $meta['label'] . ':';
			foreach ( explode( "\n", $value ) as $value_line ) {
				$lines[] = '  ' . rtrim( $value_line );
			}
		}

		$lines[] = '';
	}

	return rtrim( implode( "\n", $lines ) ) . "\n";
}

function sbo_client_brief_markdown_lookup(): array {
	$schema  = sbo_get_client_brief_schema();
	$lookup  = [];
	$aliases = [];

	foreach ( $schema as $section_key => $section ) {
		$section_title = sbo_client_brief_normalize_label( $section['title'] );
		$lookup[ $section_title ] = $section_key;

		foreach ( $section['fields'] as $field_key => $meta ) {
			$field_title = sbo_client_brief_normalize_label( $meta['label'] );
			$aliases[ $section_key ][ $field_title ] = $field_key;
		}
	}

	return [ $lookup, $aliases ];
}

function sbo_client_brief_normalize_label( string $label ): string {
	$label = strtolower( wp_strip_all_tags( $label ) );
	$label = preg_replace( '/[^a-z0-9]+/', ' ', $label );
	return trim( preg_replace( '/\s+/', ' ', $label ) );
}

function sbo_client_brief_from_markdown( string $markdown ): array {
	[ $section_lookup, $field_lookup ] = sbo_client_brief_markdown_lookup();

	$data            = [];
	$current_section = '';
	$current_field   = '';
	$lines           = preg_split( '/\r\n|\r|\n/', $markdown );

	foreach ( $lines as $line ) {
		if ( preg_match( '/^##\s+(.+?)\s*$/', $line, $matches ) ) {
			$normalized      = sbo_client_brief_normalize_label( $matches[1] );
			$current_section = $section_lookup[ $normalized ] ?? '';
			$current_field   = '';
			continue;
		}

		if ( '' === $current_section ) {
			continue;
		}

		if ( preg_match( '/^\s*-\s+([^:]+):\s*(.*)$/', $line, $matches ) ) {
			$normalized_field = sbo_client_brief_normalize_label( $matches[1] );
			$current_field    = $field_lookup[ $current_section ][ $normalized_field ] ?? '';

			if ( '' === $current_field ) {
				continue;
			}

			$data[ $current_section ][ $current_field ] = $matches[2];
			continue;
		}

		if ( '' !== $current_field && ( preg_match( '/^\s{2,}(.+)$/', $line, $matches ) || '' === trim( $line ) ) ) {
			$append = '' === trim( $line ) ? '' : $matches[1];
			$existing = $data[ $current_section ][ $current_field ] ?? '';
			$data[ $current_section ][ $current_field ] = '' === $existing ? $append : $existing . "\n" . $append;
		}
	}

	return sbo_sanitize_client_brief_data( $data );
}

function sbo_get_client_brief_option_map(): array {
	return [
		'business_identity.business_name'        => 'one_business_name',
		'business_identity.website_url'          => 'one_home_url',
		'business_identity.business_description' => 'one_business_description',
		'contact_location.display_phone'         => 'one_business_phone',
		'contact_location.click_phone'           => 'one_phone_web_ready',
		'contact_location.email'                 => 'one_business_email',
		'contact_location.street_address'        => 'one_street_address',
		'contact_location.city'                  => 'one_city',
		'contact_location.state'                 => 'one_state',
		'contact_location.postal_code'           => 'one_postal_code',
		'contact_location.country'               => 'one_country',
		'contact_location.latitude'              => 'one_latitude',
		'contact_location.longitude'             => 'one_longitude',
		'contact_location.google_maps_url'       => 'one_google_map_url',
		'seo_keywords.primary_keywords'          => 'one_business_keywords',
		'assets.logo'                            => 'one_business_logo',
		'calls_to_action.primary_cta_text'       => 'one_cta_text',
		'calls_to_action.primary_cta_url'        => 'one_cta_url',
		'calls_to_action.secondary_cta_text'     => 'one_cta_text_02',
		'calls_to_action.secondary_cta_url'      => 'one_cta_url_02',
		'social_directory_profiles.facebook'     => 'social-facebook',
		'social_directory_profiles.instagram'    => 'social-instagram',
		'social_directory_profiles.linkedin'     => 'social-linkedin',
		'social_directory_profiles.youtube'      => 'social-youtube',
		'social_directory_profiles.tiktok'       => 'social-tiktok',
		'social_directory_profiles.yelp'         => 'social-yelp',
		'social_directory_profiles.bbb'          => 'social-bbb',
	];
}

function sbo_get_client_brief_option_status(): array {
	$brief   = sbo_get_client_brief();
	$options = get_option( SBO_OPTION_KEY, [] );
	$map     = sbo_get_client_brief_option_map();
	$status  = [];

	foreach ( $map as $brief_path => $option_key ) {
		[ $section, $field ] = explode( '.', $brief_path, 2 );
		$brief_value = $brief[ $section ][ $field ] ?? '';
		$site_value  = $options[ $option_key ] ?? '';

		$status[] = [
			'brief_path'  => $brief_path,
			'option_key'  => $option_key,
			'brief_value' => is_scalar( $brief_value ) ? (string) $brief_value : '',
			'site_value'  => is_scalar( $site_value ) ? (string) $site_value : '',
			'can_fill'    => '' !== trim( (string) $brief_value ) && '' === trim( (string) $site_value ),
			'is_filled'   => '' !== trim( (string) $site_value ),
		];
	}

	return $status;
}

function sbo_fill_missing_site_fields_from_client_brief(): int {
	$status  = sbo_get_client_brief_option_status();
	$options = get_option( SBO_OPTION_KEY, [] );
	$schema  = sbo_get_field_schema();
	$flat    = [];
	$count   = 0;

	foreach ( $schema as $section ) {
		foreach ( $section['fields'] ?? [] as $key => $meta ) {
			$flat[ $key ] = $meta;
		}
	}

	foreach ( $status as $row ) {
		if ( ! $row['can_fill'] || ! isset( $flat[ $row['option_key'] ] ) ) {
			continue;
		}

		$meta  = $flat[ $row['option_key'] ];
		$type  = $meta['type'] ?? 'text';
		$value = $row['brief_value'];

		if ( ! empty( $meta['raw'] ) ) {
			$options[ $row['option_key'] ] = wp_kses_post( $value );
		} elseif ( 'url' === $type || 'media' === $type || 'page' === $type ) {
			$options[ $row['option_key'] ] = esc_url_raw( $value );
		} elseif ( 'email' === $type ) {
			$options[ $row['option_key'] ] = sanitize_email( $value );
		} elseif ( 'textarea' === $type ) {
			$options[ $row['option_key'] ] = sanitize_textarea_field( $value );
		} else {
			$options[ $row['option_key'] ] = sanitize_text_field( $value );
		}

		$count++;
	}

	if ( $count > 0 ) {
		update_option( SBO_OPTION_KEY, $options );
	}

	return $count;
}

add_action( 'admin_menu', function () {
	add_submenu_page(
		'sitebuilderone',
		'Client Brief',
		'Client Brief',
		'manage_options',
		'sbo-client-brief',
		'sbo_render_client_brief_page'
	);
}, 60 );

add_action( 'admin_post_sbo_save_client_brief', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}

	check_admin_referer( 'sbo_save_client_brief', 'sbo_client_brief_nonce' );

	$posted = isset( $_POST['sbo_client_brief'] ) && is_array( $_POST['sbo_client_brief'] )
		? wp_unslash( $_POST['sbo_client_brief'] )
		: [];

	$data = sbo_sanitize_client_brief_data( $posted );

	update_option( SBO_CLIENT_BRIEF_OPTION_KEY, $data, false );

	wp_safe_redirect( add_query_arg( [ 'page' => 'sbo-client-brief', 'updated' => '1' ], admin_url( 'admin.php' ) ) );
	exit;
} );

add_action( 'admin_post_sbo_export_client_brief_md', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}

	check_admin_referer( 'sbo_export_client_brief_md' );

	$brief    = sbo_get_client_brief();
	$markdown = sbo_client_brief_to_markdown( $brief );

	header( 'Content-Type: text/markdown; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="sbo-client-brief-' . gmdate( 'Y-m-d' ) . '.md"' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );

	echo $markdown; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit;
} );

add_action( 'admin_post_sbo_import_client_brief_md', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}

	check_admin_referer( 'sbo_import_client_brief_md', 'sbo_client_brief_import_nonce' );

	$redirect = add_query_arg( [ 'page' => 'sbo-client-brief' ], admin_url( 'admin.php' ) );

	if ( empty( $_FILES['sbo_client_brief_md']['tmp_name'] ) ) {
		wp_safe_redirect( add_query_arg( 'sbo_error', 'no_file', $redirect ) );
		exit;
	}

	$file = $_FILES['sbo_client_brief_md'];
	$name = isset( $file['name'] ) ? sanitize_file_name( wp_unslash( $file['name'] ) ) : '';
	$ext  = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );

	if ( ! in_array( $ext, [ 'md', 'markdown', 'txt' ], true ) ) {
		wp_safe_redirect( add_query_arg( 'sbo_error', 'invalid_file', $redirect ) );
		exit;
	}

	$contents = file_get_contents( $file['tmp_name'] );
	if ( false === $contents ) {
		wp_safe_redirect( add_query_arg( 'sbo_error', 'read_error', $redirect ) );
		exit;
	}

	$data = sbo_client_brief_from_markdown( $contents );
	update_option( SBO_CLIENT_BRIEF_OPTION_KEY, $data, false );

	wp_safe_redirect( add_query_arg( [ 'imported' => '1' ], $redirect ) );
	exit;
} );

add_action( 'admin_post_sbo_fill_missing_from_client_brief', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}

	check_admin_referer( 'sbo_fill_missing_from_client_brief' );

	$filled = sbo_fill_missing_site_fields_from_client_brief();

	wp_safe_redirect( add_query_arg( [ 'page' => 'sbo-client-brief', 'prefilled' => $filled ], admin_url( 'admin.php' ) ) );
	exit;
} );

function sbo_render_client_brief_page() {
	$schema = sbo_get_client_brief_schema();
	$brief  = sbo_get_client_brief();
	?>
	<div class="wrap sbo-wrap">
		<h1>Client Brief</h1>
		<p class="description">Store client-specific strategy, SEO, content, and onboarding notes separately from live site settings. This data is saved in the <code><?php echo esc_html( SBO_CLIENT_BRIEF_OPTION_KEY ); ?></code> option.</p>

		<?php if ( isset( $_GET['updated'] ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<p>Client brief saved.</p>
			</div>
		<?php endif; ?>

		<?php if ( isset( $_GET['imported'] ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<p>Client brief imported from Markdown.</p>
			</div>
		<?php endif; ?>

		<?php if ( isset( $_GET['sbo_error'] ) ) : ?>
			<div class="notice notice-error is-dismissible">
				<p>Client brief import failed. Please upload a readable Markdown file.</p>
			</div>
		<?php endif; ?>

		<?php if ( isset( $_GET['prefilled'] ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php echo esc_html( absint( $_GET['prefilled'] ) ); ?> missing site fields filled from the Client Brief.</p>
			</div>
		<?php endif; ?>

		<div class="sbo-csv-box">
			<h2>Markdown Import / Export</h2>
			<p>Export this brief to a Markdown file, or import a Markdown brief that uses the section and field labels from the template.</p>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-bottom:1em;">
				<input type="hidden" name="action" value="sbo_export_client_brief_md">
				<?php wp_nonce_field( 'sbo_export_client_brief_md' ); ?>
				<?php submit_button( 'Export Markdown', 'secondary', 'submit', false ); ?>
			</form>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<input type="hidden" name="action" value="sbo_import_client_brief_md">
				<?php wp_nonce_field( 'sbo_import_client_brief_md', 'sbo_client_brief_import_nonce' ); ?>
				<input type="file" name="sbo_client_brief_md" accept=".md,.markdown,.txt">
				<?php submit_button( 'Import Markdown', 'secondary', 'submit', false ); ?>
			</form>
		</div>

		<?php
		$field_status = sbo_get_client_brief_option_status();
		$fillable     = array_filter( $field_status, function ( $row ) {
			return ! empty( $row['can_fill'] );
		} );
		$filled_count = count( array_filter( $field_status, function ( $row ) {
			return ! empty( $row['is_filled'] );
		} ) );
		?>
		<div class="sbo-csv-box">
			<h2>Site Field Prefill</h2>
			<p>Review values from the Client Brief that can fill missing live site fields in <code><?php echo esc_html( SBO_OPTION_KEY ); ?></code>. Existing site values are preserved.</p>
			<p><strong><?php echo esc_html( count( $fillable ) ); ?></strong> fields can be filled now. <strong><?php echo esc_html( $filled_count ); ?></strong> mapped site fields already have values.</p>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-bottom:1em;">
				<input type="hidden" name="action" value="sbo_fill_missing_from_client_brief">
				<?php wp_nonce_field( 'sbo_fill_missing_from_client_brief' ); ?>
				<?php submit_button( 'Fill Missing Site Fields', 'secondary', 'submit', false, count( $fillable ) ? [] : [ 'disabled' => 'disabled' ] ); ?>
			</form>

			<table class="widefat striped sbo-client-brief-prefill-table">
				<thead>
					<tr>
						<th>Brief Field</th>
						<th>Site Field</th>
						<th>Status</th>
						<th>Brief Value</th>
						<th>Current Site Value</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $field_status as $row ) : ?>
						<tr>
							<td><code><?php echo esc_html( $row['brief_path'] ); ?></code></td>
							<td><code><?php echo esc_html( $row['option_key'] ); ?></code></td>
							<td>
								<?php if ( $row['can_fill'] ) : ?>
									<span class="sbo-prefill-status sbo-prefill-status-missing">Can fill</span>
								<?php elseif ( $row['is_filled'] ) : ?>
									<span class="sbo-prefill-status sbo-prefill-status-filled">Already filled</span>
								<?php else : ?>
									<span class="sbo-prefill-status">No brief value</span>
								<?php endif; ?>
							</td>
							<td><?php echo esc_html( wp_trim_words( $row['brief_value'], 14, '...' ) ); ?></td>
							<td><?php echo esc_html( wp_trim_words( $row['site_value'], 14, '...' ) ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="sbo_save_client_brief">
			<?php wp_nonce_field( 'sbo_save_client_brief', 'sbo_client_brief_nonce' ); ?>

			<?php foreach ( $schema as $section_key => $section ) : ?>
				<h2 class="sbo-section-heading"><?php echo esc_html( $section['title'] ); ?></h2>
				<p class="description" style="margin-bottom:1em; font-size:15px; color:#666; font-style:italic;">
					<?php echo esc_html( $section['description'] ); ?>
				</p>

				<?php if ( ! empty( $section['questions'] ) ) : ?>
					<div class="sbo-client-brief-questions">
						<h3>Questions to ask</h3>
						<ul>
							<?php foreach ( $section['questions'] as $question ) : ?>
								<li><?php echo esc_html( $question ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<table class="form-table sbo-fields-table">
					<tbody>
						<?php foreach ( $section['fields'] as $field_key => $meta ) : ?>
							<?php
							$value   = $brief[ $section_key ][ $field_key ] ?? '';
							$type    = $meta['type'] ?? 'text';
							$rows    = isset( $meta['rows'] ) ? absint( $meta['rows'] ) : 3;
							$html_id = 'sbo-client-brief-' . sanitize_html_class( $section_key . '-' . $field_key );
							$name    = 'sbo_client_brief[' . esc_attr( $section_key ) . '][' . esc_attr( $field_key ) . ']';
							?>
							<tr>
								<th scope="row">
									<label for="<?php echo esc_attr( $html_id ); ?>"><?php echo esc_html( $meta['label'] ); ?></label>
								</th>
								<td>
									<?php if ( 'textarea' === $type ) : ?>
										<textarea id="<?php echo esc_attr( $html_id ); ?>" name="<?php echo $name; ?>" rows="<?php echo esc_attr( $rows ); ?>" class="large-text"><?php echo esc_textarea( $value ); ?></textarea>
									<?php else : ?>
										<input id="<?php echo esc_attr( $html_id ); ?>" name="<?php echo $name; ?>" type="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endforeach; ?>

			<?php submit_button( 'Save Client Brief' ); ?>
		</form>
	</div>
	<?php
}
