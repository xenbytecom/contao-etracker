# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/lang/de/spec/v2.0.0.html).

## [0.2.0]

### Changed

- Renamed database columns (not critical, as the extension is not yet in use)

### Fixed

- Fixed form tracking
- Recognize section name in form tracking

## [0.1.1]

### Fixed

- Removed CSP nonce in twig templates, because of compatibility problems with Contao 5.3. No workaround necessary, because of native CSP support in Contao 5.3

## [0.1.0]

### Added

- Initial preview release
