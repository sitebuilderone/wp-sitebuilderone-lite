# TODO

Short-term actionable tasks, test items, bugs, and cleanup work.

## Testing

- Browser-test **SiteBuilderOne > Client Brief** in WordPress admin.
- Test saving Client Brief fields and confirm values persist under `sbo_client_brief`.
- Test Markdown export from a filled Client Brief.
- Test Markdown import from `client-briefs/_template.md` format.
- Test Markdown import/export round trip.
- Test **Fill Missing Site Fields** and confirm existing `sbo_options` values are preserved.
- Test Client Brief admin page on mobile/narrow admin widths.

## Cleanup / Fixes

- Review CSV import/export in `includes/csv.php`; it appears to assume the older field schema shape and may not handle the current `fields` nesting.
- Add imported-field count or summary after Client Brief Markdown import.
- Add clearer import error messages for invalid file type, missing file, and unreadable file.
- Consider adding a preview step before Client Brief prefill writes to `sbo_options`.
- Review `README.md` field counts and section descriptions against the current `sbo_get_field_schema()`.

## Documentation

- Add example filled client brief in `client-briefs/example.md` with fictional data.
- Document the Client Brief Markdown format with a short example.
- Document which Client Brief fields map to live `sbo_options` fields.
