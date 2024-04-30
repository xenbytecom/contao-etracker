# etracker für Contao CMS (inoffizielles Plugin)

Mit diesem Bundle kann etracker Analytics einfach in Contao eingebunden werden. Kompatibel zu Contao 4.13 und neuer,
einschließlich Contao 5.3.

Es handelt sich noch um eine Vorab-Version in der aktiven Entwicklungs- und Testphase.

## Features
* etracker-Account je Startpunkt einer Seite
* optionales Deaktivieren des etracker Optimisers
* optionales Deaktivieren des in etracker integriertem jQuery
* optionales Deaktivieren von etracker für eingeloggte Benutzer und/oder Mitglieder
* Setzen der Variable et_pagename je Seite oder automatische Erkennung
* Setzen der Variable et_areas je Seite oder automatische Ermittlung über die Seitenstruktur
* Berücksichtung von Titeln der News, Kalender-Einträge etc.
* Tracking der Formular-Interaktionen (muss in den Formular-Einstellungen konfiguriert werden und erfordert etracker Pro oder Enterprise)
* Tracking der Suchergebnisse als Onsite-Kampagne (muss in den Suchmodul-Einstellungen konfiguriert werden und erfordert etracker Pro oder Enterprise)
* twig-Templates mit Nutzung von CSP nonce (auch unter Contao 4.13), sodass unsafe-inline nicht mehr erforderlich ist ([andere Security Header müssen gesetzt werden](https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/funktion-zweck/#integration-security-header))

## Einschränkungen
* nur asynchroner code
* beim Formular-Tracking ist nur ein Fomular pro Seite möglich

## Geplante Funktionen
* Modul für etracker-Optout
* Tracking der internen Suche
* custom attributes
* deaktivierung Cookie-less tracking
* Segmente: https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/eigene-segmente/

## Voraussetzzungen
* Contao 4.13 oder neuer
* PHP 8.1 oder höher
* [etracker-Konto](https://www.xenbyte.com/go-etracker) (kostenpflichtig)

## Installation
Entweder über den Contao Manager oder mittels composer via `composer require xenbyte/contao-etracker`

## CSP-Header für etracker

```
Header set Content-Security-Policy "script-src 'self' https://*.etracker.com https://*.etracker.de 'unsafe-inline'; connect-src https://*.etracker.de"
```

Bei Verwendung der Scrollmap sollte zudem noch das Einbetten in einen iframe erlaubt werden:

```
Header set Content-Security-Policy "frame-ancestors https://*.etracker.com; script-src 'self' https://*.etracker.com https://*.etracker.de; connect-src https://*.etracker.de"
```
