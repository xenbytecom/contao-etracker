# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/lang/de/spec/v2.0.0.html).

## [0.5.0]

### Added

- event tracking configuration with default templates
- support for 401, 403, 404 and 503 error pages
- support for multiple forms on one page

### Changed

- renamed templates to avoid listing as analytics templates in layout configuration
- hides etracker settings if etracker is disabled at root level
- replaced mod_search template and use etracker_search_code in ParseTemplateListener instead
- ignoring invisible form fields in form tracking
- outsourced form tracking into external js file
- moved more params logic from listener into template file
- recognize only forms and fields as soon as they get visible on screen

### Fixed

- recognize overwriting et_areas

## [0.4.3]

### Fixed

- Fixed form field configuration

## [0.4.2]

### Changed

- etracker account key is now marked as mandatory

### Fixed

- umlauts in tracking code (pagetitle, areas, ...)
- missing CSP nonce for versions before contao 5.13

## [0.4.0]

### Added

- Search result campaign tracking
- Opt out module

### Changed

- Moved templates
- Replaced FrontendModule with ContentElement
- Using parseTemplate hook instead of customizeSearch for search result tracking
- fields for search result tracking are mandatory

### Fixed

- Using _etrackerOnReady for events in form tracking
- removed unnecessary config which caused problems with the content module

## [0.3.0]

### Added

- JavaScript for optout
- Contao 4.13 compatibility

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
