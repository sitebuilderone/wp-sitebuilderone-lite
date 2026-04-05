<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// ---------------------------------------------------------------------------
// Export — streams a CSV file download.
// ---------------------------------------------------------------------------
add_action( 'admin_post_sbo_export_csv', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
	check_admin_referer( 'sbo_export_csv' );

	$schema  = sbo_get_field_schema();
	$options = get_option( SBO_OPTION_KEY, [] );

	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="sbo-export-' . gmdate( 'Y-m-d' ) . '.csv"' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );

	$out = fopen( 'php://output', 'w' );

	// UTF-8 BOM so Excel opens the file correctly.
	fwrite( $out, "\xEF\xBB\xBF" );

	fputcsv( $out, [ 'Section', 'Field', 'Value' ] );

	foreach ( $schema as $section => $fields ) {
		foreach ( $fields as $key => $meta ) {
			fputcsv( $out, [ $section, $key, $options[ $key ] ?? '' ] );
		}
	}

	fclose( $out );
	exit;
} );

// ---------------------------------------------------------------------------
// Import — parses an uploaded CSV and merges into existing options.
// ---------------------------------------------------------------------------
add_action( 'admin_post_sbo_import_csv', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorized' );
	check_admin_referer( 'sbo_import_csv', 'sbo_import_nonce' );

	$redirect_base = add_query_arg( 'page', 'wp-sitebuilderone-lite', admin_url( 'options-general.php' ) );

	if ( empty( $_FILES['sbo_csv_file']['tmp_name'] ) ) {
		wp_safe_redirect( add_query_arg( 'sbo_error', 'no_file', $redirect_base ) );
		exit;
	}

	$file   = $_FILES['sbo_csv_file']['tmp_name'];
	$handle = fopen( $file, 'r' );

	if ( ! $handle ) {
		wp_safe_redirect( add_query_arg( 'sbo_error', 'read_error', $redirect_base ) );
		exit;
	}

	// Build a flat lookup of allowed field keys → meta.
	$schema     = sbo_get_field_schema();
	$flat       = [];
	foreach ( $schema as $fields ) {
		foreach ( $fields as $key => $meta ) {
			$flat[ $key ] = $meta;
		}
	}

	$current  = get_option( SBO_OPTION_KEY, [] );
	$row_num  = 0;
	$imported = 0;

	while ( ( $row = fgetcsv( $handle ) ) !== false ) {
		$row_num++;

		// Skip header row.
		if ( 1 === $row_num ) continue;

		// Skip malformed rows.
		if ( count( $row ) < 3 ) continue;

		[ , $field, $value ] = $row;
		$field = trim( $field );

		// Only import fields that exist in the schema — prevents garbage injection.
		if ( ! isset( $flat[ $field ] ) ) continue;

		$meta             = $flat[ $field ];
		$current[ $field ] = sbo_sanitize_field( (string) $value, $meta['type'], ! empty( $meta['raw'] ) );
		$imported++;
	}

	fclose( $handle );
	update_option( SBO_OPTION_KEY, $current );

	wp_safe_redirect( add_query_arg( 'imported', $imported, $redirect_base ) );
	exit;
} );
