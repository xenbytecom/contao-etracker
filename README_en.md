# etracker Analytics for Contao CMS (inofficial extension)

With this bundle, etracker Analytics can be easily integrated into Contao. It's compatible with Contao 4.13 and newer,
including Contao 5.3. Contao 5.4 is currently not supported.

This is still a pre-release version in the active development and testing phase.

## Features
* etracker account key per entrypoint
* optional disabling of etracker Optimiser
* optional disabling of loading etracker integrated jQuery
* overwrite et_pagename variable with a custom title 
* specify et_areas or determine the values by page structure
* optional disabling etracker for logged in frontend users and/or backend users
* enabling and configuring form interaction tracking
* twig-Template with usage of nonce for CSP (also in Contao 4.13), thus unsafe-inline is not needed (other Security Header have to be set: https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/funktion-zweck/#integration-security-header)

## Limitations
* only asynchronous code
* only one form per page is possible for form tracking

## Planned features
* module for etracker opt-out
* tracking of the internal search
* custom attributes
* deactivation of cookie-less tracking
* segments: https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/eigene-segmente/

## Requirements
* Contao 4.13 or newer (including Contao 5.3)
* PHP 8.0 or newer
* etracker account (chargeable)

## Install

Either via the Contao Manager or via composer `composer require xenbyte/contao-etracker`

## CSP-Header for etracker
```
Header set Content-Security-Policy "script-src 'self' https://*.etracker.com https://*.etracker.de 'unsafe-inline'; connect-src https://*.etracker.de"
```

When using the scrollmap, embedding in an iframe should also be permitted:

```
Header set Content-Security-Policy "frame-ancestors https://*.etracker.com; script-src 'self' https://*.etracker.com https://*.etracker.de; connect-src https://*.etracker.de"
```
