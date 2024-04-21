# etracker Analytics for Contao CMS (inofficial extension)

Mit diesem Bundle kann etracker Analytics einfach in Contao eingebunden werden 

## Features

* twig-Template with usage of nonce for CSP, thus unsafe-inline is not needed (andere Security Header müssen gesetzt weden: https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/funktion-zweck/#integration-security-header)
* etracker account key per entrypoint
* optional disabling of etracker Optimiser
* optional disabling of loading etracker integrated jQuery
* overwrite et_pagename variable with a custom title 
* specify et_areas or determine the values by page structure
* optional disabling etracker for logged in frontend users and/or backend users
* enabling and configuring form interaction tracking

Inspiration: https://www.drupal.org/project/etracker

## Limitations

* Die Erweiterung ist (zunächst) nur auf den Einsatz ohne Cookies ausgelegt
* nur asynchroner code
* beim Formular-Tracking ist nur ein Fomular pro Seite möglich

## Geplante Funktionen

* Modul für etracker-Optout
* Tracking der internen Suche
* custom attributes
* deaktivierung Cookie-less tracking
* integriertes Reporting? Dann aber als separates Modul 
* Segmente: https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/eigene-segmente/

## eigene Notizen
* Basis: https://github.com/contao/skeleton-bundle
* daraus abgeleitet ein eigenes (internes) Bundle
* https://docs.contao.org/dev/getting-started/extension/

## Install

Download the skeleton bundle:

```bash
wget https://github.com/contao/skeleton-bundle/archive/main.zip
unzip main.zip
mv skeleton-bundle-main [package name]
cd [package name]
```

## Voraussetzzungen

* Contao 4.13 oder neuer
* PHP 8.0 (?) oder höher
* etracker Konto (kostenpflichtig)


## Installation

Entweder über den Contao Manager oder über composer




```
Header set Content-Security-Policy "script-src 'self' https://*.etracker.com https://*.etracker.de 'unsafe-inline'; connect-src https://*.etracker.de"

Bei Verwendung der Scrollmap sollte zudem noch das Einbetten in einen iframe erlaubt werden:

Header set Content-Security-Policy "frame-ancestors https://*.etracker.com; script-src 'self' https://*.etracker.com https://*.etracker.de 'unsafe-inline'; connect-src https://*.etracker.de"
```







First adjust the following files:

 * `composer.json`
 * `ecs.php`
 * `LICENSE`
 * `phpunit.xml.dist`
 * `README.md`

Then rename the following files and/or the references to `SkeletonBundle` in
the following files:

 * `src/ContaoManager/Plugin.php`
 * `src/DependencyInjection/ContaoSkeletonExtension.php`
 * `src/ContaoSkeletonBundle.php`
 * `tests/ContaoSkeletonBundleTest.php`

Finally, add your custom classes and resources. Make sure to register your services
within `src/Resources/config/services.yml`. Also make sure to
[adjust the Contao Manager Plugin][2] (and the dependencies within the `composer.json`)
accordingly, if your bundle makes adjustments to other bundles (e.g. adjustments
to a DCA of other bundles).

## Release

Run the PHP-CS-Fixer and the unit test before you release your bundle:

```bash
vendor/bin/ecs check src/ tests/ --fix
vendor/bin/phpunit
```

[1]: https://contao.org
[2]: https://docs.contao.org/dev/framework/manager-plugin/#the-bundleplugininterface
