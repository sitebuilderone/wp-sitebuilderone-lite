<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/** All option records owned by this plugin, including internal rewrite versions. */
function sbo_get_settings_export_data(): array {
	$options = [];
	$missing = new stdClass();

	foreach ( [
		SBO_OPTION_KEY,
		SBO_CLIENT_BRIEF_OPTION_KEY,
		SBO_FAQ_Admin_Settings::OPTION_FAQ_SLUG,
		SBO_FAQ_Admin_Settings::OPTION_HOWTO_SLUG,
		'sbo_services_rewrite_version',
		'sbo_faq_rewrite_version',
	] as $key ) {
		$value = get_option( $key, $missing );
		if ( $missing !== $value ) {
			$options[ $key ] = $value;
		}
	}

	return [
		'format'         => 'sitebuilderone-options',
		'format_version' => 1,
		'plugin_version' => SBO_VERSION,
		'exported_at'    => gmdate( 'c' ),
		'options'        => (object) $options,
	];
}

function sbo_settings_export_json( $data ) {
	return wp_json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
}

function sbo_settings_export_markdown( array $data ): string {
	$lines = [
		'# SiteBuilderOne — All Saved Settings',
		'',
		'Exported: ' . $data['exported_at'],
		'',
		'Includes saved SiteBuilderOne option records only. Missing records are omitted. Live settings and Client Brief values are kept separately.',
		'',
		'General Settings, Business Info, Marketing, Design, Pages, and Social Media share `sbo_options`. Client Brief uses `sbo_client_brief`. FAQ/HowTo URL bases and internal rewrite versions use separate records.',
		'',
		'This is a full settings reference, not a Client Brief import file. Posts, post meta, media files, and other plugins’ options are not included.',
		'',
	];

	foreach ( (array) $data['options'] as $key => $value ) {
		$json = sbo_settings_export_json( $value );
		if ( false === $json ) {
			wp_die( 'Settings could not be encoded for export.' );
		}
		// Stored HTML or notes may themselves contain Markdown code fences.
		preg_match_all( '/`+/', $json, $matches );
		$length = 3;
		foreach ( $matches[0] as $run ) {
			$length = max( $length, strlen( $run ) + 1 );
		}
		$fence = str_repeat( '`', $length );
		$lines[] = '## ' . $key;
		$lines[] = '';
		$lines[] = $fence . 'json';
		$lines[] = $json;
		$lines[] = $fence;
		$lines[] = '';
	}

	return implode( "\n", $lines );
}

add_action( 'admin_post_sbo_export_all_settings', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}
	check_admin_referer( 'sbo_export_all_settings', 'sbo_export_all_nonce' );

	$format = isset( $_POST['sbo_export_format'] ) && 'json' === $_POST['sbo_export_format'] ? 'json' : 'md';
	$data = sbo_get_settings_export_data();
	$output = 'json' === $format ? sbo_settings_export_json( $data ) : sbo_settings_export_markdown( $data );
	if ( false === $output ) {
		wp_die( 'Settings could not be encoded for export.' );
	}

	nocache_headers();
	header( 'Content-Type: ' . ( 'json' === $format ? 'application/json' : 'text/markdown' ) . '; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="sbo-all-settings-' . gmdate( 'Y-m-d' ) . '.' . $format . '"' );
	header( 'X-Content-Type-Options: nosniff' );
	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Download, not HTML.
	exit;
} );

/** Sanitize legacy fields while retaining their array/scalar structure. */
function sbo_sanitize_imported_setting( $value ) {
	if ( is_array( $value ) ) {
		return array_map( 'sbo_sanitize_imported_setting', $value );
	}
	return is_string( $value ) ? sanitize_textarea_field( $value ) : $value;
}

/** Validate the complete file before writing any option. */
function sbo_prepare_settings_import( string $json ) {
	$data = json_decode( $json, true, 64 );
	if ( JSON_ERROR_NONE !== json_last_error() || ! is_array( $data )
		|| 'sitebuilderone-options' !== ( $data['format'] ?? '' )
		|| 1 !== ( $data['format_version'] ?? null )
		|| ! isset( $data['options'] ) || ! is_array( $data['options'] ) ) {
		return new WP_Error( 'invalid_export', 'Choose a SiteBuilderOne full JSON export (format version 1).' );
	}

	$allowed = [ SBO_OPTION_KEY, SBO_CLIENT_BRIEF_OPTION_KEY,
		SBO_FAQ_Admin_Settings::OPTION_FAQ_SLUG, SBO_FAQ_Admin_Settings::OPTION_HOWTO_SLUG,
		'sbo_services_rewrite_version', 'sbo_faq_rewrite_version' ];
	$prepared = [];
	$live_fields = [];
	foreach ( sbo_get_field_schema() as $section ) {
		$live_fields += $section['fields'];
	}
	$brief_schema = sbo_get_client_brief_schema();

	foreach ( $data['options'] as $key => $value ) {
		if ( ! in_array( $key, $allowed, true ) ) {
			return new WP_Error( 'foreign_option', 'The file contains options that do not belong to SiteBuilderOne. Nothing was imported.' );
		}
		if ( in_array( $key, [ 'sbo_services_rewrite_version', 'sbo_faq_rewrite_version' ], true ) ) {
			// These are maintained by the destination plugin, never restored from another site.
			continue;
		}
		if ( SBO_OPTION_KEY === $key || SBO_CLIENT_BRIEF_OPTION_KEY === $key ) {
			if ( ! is_array( $value ) ) {
				return new WP_Error( 'invalid_values', 'Settings and Client Brief must contain field collections.' );
			}
			$prepared[ $key ] = [];
			foreach ( $value as $field => $field_value ) {
				if ( SBO_OPTION_KEY === $key ) {
					$meta = $live_fields[ $field ] ?? null;
					if ( $meta && ! is_scalar( $field_value ) ) {
						return new WP_Error( 'invalid_values', 'A live setting has an invalid value.' );
					}
					$prepared[ $key ][ $field ] = $meta
						? sbo_sanitize_import_field( (string) $field_value, $meta )
						: sbo_sanitize_imported_setting( $field_value );
				} else {
					if ( ! is_array( $field_value ) ) {
						return new WP_Error( 'invalid_values', 'A Client Brief section has an invalid value.' );
					}
					$prepared[ $key ][ $field ] = [];
					foreach ( $field_value as $brief_field => $brief_value ) {
						if ( ! is_scalar( $brief_value ) ) {
							return new WP_Error( 'invalid_values', 'A Client Brief field has an invalid value.' );
						}
						$meta = $brief_schema[ $field ]['fields'][ $brief_field ] ?? [ 'type' => 'textarea' ];
						$prepared[ $key ][ $field ][ $brief_field ] = sbo_sanitize_import_field( (string) $brief_value, $meta );
					}
				}
			}
		} else {
			if ( ! is_string( $value ) ) {
				return new WP_Error( 'invalid_values', 'A URL base has an invalid value.' );
			}
			$prepared[ $key ] = SBO_FAQ_Admin_Settings::OPTION_FAQ_SLUG === $key
				? SBO_FAQ_Admin_Settings::sanitize_faq_slug( $value )
				: SBO_FAQ_Admin_Settings::sanitize_howto_slug( $value );
		}
	}
	return $prepared ?: new WP_Error( 'empty_export', 'No importable settings were found.' );
}

function sbo_sanitize_import_field( string $value, array $meta ): string {
	if ( ! empty( $meta['raw'] ) ) {
		return wp_kses_post( $value );
	}
	return match ( $meta['type'] ?? 'text' ) {
		'url', 'media', 'page' => esc_url_raw( $value ),
		'email' => sanitize_email( $value ),
		'textarea' => sanitize_textarea_field( $value ),
		'checkbox' => $value ? '1' : '0',
		default => sanitize_text_field( $value ),
	};
}

function sbo_import_all_settings( string $json ) {
	$prepared = sbo_prepare_settings_import( $json );
	if ( is_wp_error( $prepared ) ) {
		return $prepared;
	}
	foreach ( $prepared as $key => $value ) {
		$current = get_option( $key, [] );
		if ( SBO_OPTION_KEY === $key ) {
			$value = array_replace( is_array( $current ) ? $current : [], $value );
		} elseif ( SBO_CLIENT_BRIEF_OPTION_KEY === $key ) {
			$merged = is_array( $current ) ? $current : [];
			foreach ( $value as $section => $fields ) {
				$merged[ $section ] = array_replace( is_array( $merged[ $section ] ?? null ) ? $merged[ $section ] : [], $fields );
			}
			$value = $merged;
		}
		update_option( $key, $value, false );
		if ( get_option( $key ) !== $value ) {
			return new WP_Error( 'save_failed', 'Some settings could not be saved. Earlier records may have been imported; review the settings and retry.' );
		}
	}
	// Slug update hooks refresh permalink rules and maintain destination rewrite versions.
	return count( $prepared );
}

add_action( 'admin_post_sbo_import_all_settings', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}
	check_admin_referer( 'sbo_import_all_settings', 'sbo_import_all_nonce' );
	$file = $_FILES['sbo_settings_json'] ?? [];
	if ( ! is_array( $file ) || UPLOAD_ERR_OK !== ( $file['error'] ?? UPLOAD_ERR_NO_FILE )
		|| ! is_string( $file['name'] ?? null ) || ! is_string( $file['tmp_name'] ?? null )
		|| 'json' !== strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) )
		|| ! is_uploaded_file( $file['tmp_name'] ) ) {
		wp_die( 'Please upload a readable SiteBuilderOne JSON export.' );
	}
	$contents = file_get_contents( $file['tmp_name'], false, null, 0, 5 * 1024 * 1024 + 1 );
	if ( false === $contents || strlen( $contents ) > 5 * 1024 * 1024 ) {
		wp_die( 'Please upload a readable JSON export smaller than 5 MB.' );
	}
	$result = sbo_import_all_settings( $contents );
	if ( is_wp_error( $result ) ) {
		wp_die( esc_html( $result->get_error_message() ) );
	}
	wp_safe_redirect( add_query_arg( [ 'page' => 'sitebuilderone', 'sbo_settings_imported' => $result ], admin_url( 'admin.php' ) ) );
	exit;
} );

function sbo_render_settings_export_controls() {
	?>
	<div class="sbo-csv-box">
		<h2>Import / Export All Settings</h2>
		<?php if ( isset( $_GET['sbo_settings_imported'] ) ) : ?>
			<div class="notice notice-success"><p>SiteBuilderOne settings and Client Brief import completed.</p></div>
		<?php endif; ?>
		<p>Download all saved SiteBuilderOne settings: General Settings, Business Info, Marketing, Design, Pages, Social Media, Client Brief, FAQ/HowTo URL bases, and internal rewrite versions. Includes all stored fields, including older fields. Save any edits before exporting.</p>
		<p>Markdown provides a readable reference; JSON preserves the complete option structure. These files are separate from the Client Brief import format. Posts, media files, and other plugins’ settings are not included.</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="sbo_export_all_settings">
			<?php wp_nonce_field( 'sbo_export_all_settings', 'sbo_export_all_nonce' ); ?>
			<button type="submit" name="sbo_export_format" value="md" class="button button-secondary">Export All Settings (Markdown)</button>
			<button type="submit" name="sbo_export_format" value="json" class="button button-secondary">Export All Settings (JSON)</button>
		</form>
		<h3>Import All Settings</h3>
		<p>Upload an <strong>Export All Settings (JSON)</strong> file to import SiteBuilderOne settings and Client Brief together. Imported fields overwrite matching saved values, including blanks; omitted fields stay unchanged. URL bases are imported and permalink rules refreshed by this site.</p>
		<p>Page links and image URLs retain the source site’s addresses; review them after importing to another site. This imports settings and brief notes only, not Services, FAQs, HowTos, pages, or media files.</p>
		<form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="sbo_import_all_settings">
			<?php wp_nonce_field( 'sbo_import_all_settings', 'sbo_import_all_nonce' ); ?>
			<label>SiteBuilderOne JSON export (up to 5 MB) <input type="file" name="sbo_settings_json" accept=".json,application/json" required></label>
			<?php submit_button( 'Import All Settings & Client Brief', 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}
