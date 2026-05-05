# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

- No unreleased changes yet.

## 1.0.7 - 2026-05-05

- Added **SiteBuilderOne > Client Brief** admin page.
- Added separate `sbo_client_brief` WordPress option for client onboarding, SEO, content, strategy, services, FAQs, assets, and notes.
- Added schema-driven Client Brief fields and helper access via `sbo_get_client_brief()`.
- Added Markdown import/export for Client Brief data.
- Added reusable client onboarding questionnaire at `client-briefs/_template.md`.
- Added root `CLIENT.md` pointer for active client brief workflow.
- Added safe Client Brief prefill into existing `sbo_options` fields.
- Added status table showing mapped brief values, current site values, missing fields, and already-filled fields.
- Updated `README.md` with Client Brief workflow instructions.
- Updated `AGENTS.md` with custom post type, Client Brief, Markdown import/export, and prefill implementation notes.
- Reduced `CLAUDE.md` to point to `AGENTS.md` as the source of truth.
