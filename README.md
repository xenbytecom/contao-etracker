# etracker Analytics for Contao CMS (inofficial extension)

Mit diesem Bundle kann etracker Analytics einfach in Contao eingebunden werden

## Features

* Twig-Templates mit nonce-Tags für CSP, sodass unsafe-inline im Front-End is not needed (andere Security Header müssen gesetzt weden: https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/funktion-zweck/#integration-security-header)
* etracker-Account je Startpunkt einer Seite
* optionales Deaktivieren des etracker Optimisers
* optionales Deaktivieren des in etracker integriertem jQuery
* optionales Deaktivieren von etracker für eingeloggte Benutzer und/oder Mitglieder
* Setzen der Variable et_pagename je Seite oder automatische Erkennung
* Setzen der Variable et_areas je Seite oder automatische Ermittlung über die Seitenstruktur
* Tracking der Formular-Interaktionen (muss in den Formular-Einstellungen aktiviert und konfiguriert werden)

Inspiration: https://www.drupal.org/project/etracker

## Einschränkungen

* Die Erweiterung ist (zunächst) nur auf den Einsatz ohne Cookies ausgelegt
* nur asynchroner code
* beim Formular-Tracking ist nur ein Fomular pro Seite möglich

## Geplante Funktionen

* Modul für etracker-Optout
* Tracking der internen Suche
* custom attributes
* deaktivierung Cookie-less tracking
* Segmente: https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/eigene-segmente/

## eigene Notizen
* Basis: https://github.com/contao/skeleton-bundle
* daraus abgeleitet ein eigenes (internes) Bundle
* https://docs.contao.org/dev/getting-started/extension/

## Voraussetzzungen

* Contao 4.13 oder neuer
* PHP 8.1 oder höher
* etracker Konto (kostenpflichtig)


## Installation

Entweder über den Contao Manager oder über composer

```
Header set Content-Security-Policy "script-src 'self' https://*.etracker.com https://*.etracker.de 'unsafe-inline'; connect-src https://*.etracker.de"

Bei Verwendung der Scrollmap sollte zudem noch das Einbetten in einen iframe erlaubt werden:

Header set Content-Security-Policy "frame-ancestors https://*.etracker.com; script-src 'self' https://*.etracker.com https://*.etracker.de 'unsafe-inline'; connect-src https://*.etracker.de"
```
