# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/lang/de/spec/v2.0.0.html).

## [0.3.0]

### Added

- JavaScript for optout

### Changed

- Using Nelmio csp listener for nonce generation for versions before contao 5.3
- Using Contao csp listener for nonce generation for Contao 5.3 and newer
- Nonce generation in Contao 5.3 only if CSP is activated

### Removed

- Optout ContentElement (FrontendModule is a better option, but not finished) 
- etrackerTLD field for Frontendmodule

## [0.2.3]

### Changed

- Read HtmlHeadBag to detect the correct page name of news, events etc.

## [0.2.2]

### Fixed

- Fixed using root pagename for areas
- Fixed error when $_SESSION is not set

## [0.2.1]

### Changed

- Re-Added CSP nonce, because CSP nonce wasn't added to the code. With this change, the plugin is currently only compatible with Contao 5.3

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
