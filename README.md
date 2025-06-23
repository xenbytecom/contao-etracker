# etracker-Integration für Contao CMS

![etracker.svg](etracker.svg)

Mit diesem Bundle kann etracker Analytics einfach in Contao eingebunden werden. Kompatibel zu Contao 5.3 und Contao 5.4.
Die Versionen zwischen Contao 4.13 und 5.2 werden nur bis Version 0.5.x der Erweiterung unterstützt.

Es handelt sich noch um eine Vorab-Version in der aktiven Entwicklungs- und Testphase. Jedes Feedback (via Github, im
Contao-Forum oder per E-Mail) ist willkommen.

![Packagist Version](https://img.shields.io/packagist/v/xenbyte/contao-etracker)
[![Donate](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.paypal.com/donate/?hosted_button_id=J425R728CYH9N)

## Features

* etracker-Account je Startpunkt einer Seite
* optionales Deaktivieren von etracker für eingeloggte Benutzer und/oder Mitglieder
* Setzen der Variable et_pagename je Seite oder automatische Erkennung
* Setzen der Variable et_areas je Seite oder automatische Ermittlung über die Seitenstruktur
* Berücksichtung von Titeln der News, Kalender-Einträge etc.
* Tracking der Formular-Interaktionen (muss in den Formular-Einstellungen konfiguriert werden)
* Tracking der Suchergebnisse als Onsite-Kampagne (muss in den Suchmodul-Einstellungen konfiguriert werden und erfordert
  etracker Pro oder Enterprise)
* Tracking von Logins (erfolgreich und fehlgeschlagen), Logouts und Registrierungen
* Event-Tracking-Vorlagen

## Geplante Funktionen

* deaktivierung Cookie-less tracking
* eigene Dimensionen: https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/eigene-segmente/
* evtl. Anbindung and Cookiebar
* Registrierungsformular für Formular-Tracking berücksichtigen
* Einstellung, ob der intersection observer für die Feld-Sichtbarkeit verwendet werden soll

## Voraussetzzungen

* Contao 5.3 oder neuer
* PHP 8.1 oder neuer
* [etracker-Konto](https://www.xenbyte.com/go-etracker) (kostenpflichtig)[^1]

## Installation

Entweder über den Contao Manager oder mittels composer via `composer require xenbyte/contao-etracker`

## Konfiguration

### Website-Startseite (Root-Ebene)

![docs/01_rootpage_setup.png](docs/01_rootpage_setup.png)

Die etracker-Integration wird auf den jeweiligen Website-Startseiten aktiviert. Der Account-Schlüssel von etracker ist
das einzige Pflichtfeld. Weitere Felder:

* Haupt-Domain: Die im etracker hinterlegte Haupt-Domain. Diese Angabe wird nur für den Zählungsausschluss benötigt.
  Dieses Konfigurationsfeld wird voraussichtlich noch verschoben.
* Eigene Tracking-Domain: Wenn
  eine [eigene Tracking-Domain](https://www.etracker.com/docs/integration-setup/tracking-code-sdks/eigene-tracking-domain-einrichten/)
  eingerichtet wurde, ist die abweichende Tracking-Domain hier anzugeben.
* Debug mode: ermöglicht den etracker-eigenen debug mode, wahlweise komplett oder nur für Backend-Benutzer
* Bereich-Name: legt einen Bereichsnamen fest, der für et_area an die Unterseiten weitergegeben wird. Auf
  Website-Startseiten-Ebene wäre bei mehrsprachigen Seiten z. B. die Sprache als Bereich 1 empfehlenswert. Wenn es nur
  eine Website-Startseite (Root-Ebene) gibt, sollte das Feld leergelassen werden.
* Do Not Track (DNT) berücksichtigen: Standardmäßig berücksichtigt etracker die DNT-Angabe des Browsers nicht (
  siehe [etracker-Artikel](https://www.etracker.com/tipp-der-woche-do-not-track/)), die Berücksichtigung kann jedoch mit
  der Einstellung erzwungen werden.
* Frontend-Benutzer ausschließen: bindet kein Tracking Code für eingeloggte Mitglieder aus, auch nicht bei aktiviertem
  debug mode
* Backend-Bentuzer ausschließen: bindet kein Tracking Code für eingeloggte Benutzer aus, auch nicht bei aktiviertem
  debug mode
* Cross_Devide-Tracking von Frontend-Benutzern: Zum Geräteübergreifenden Tracking kann der Benutzername als md5-Hash
  übermittelt werden

### Reguläre Seite

![docs/02_page_setup.png](docs/02_page_setup.png)

Sämtliche Angaben für die Unterseiten sind optional.

* Seitenname: Wenn kein Seitenname in den etracker-Einstellungen gesetzt ist, wird der Seitentitel (welcher u. U. aber
  noch den Suffix des Website-Namens enthält) herangezogen.
* Bereich-Name: Standardmäßig identisch zum Seitenname, kann aber überschrieben werden. Dieser Wert wird als Ebenen-Name
  für die Unterseiten weitergegeben.
* Bereiche: Überschreibt die Bereiche für die aktuelle Seite anstatt diese über die Vererbungen zu generieren

### Interne Suche tracken (etracker Pro oder Enterprise)

Als Vorbereitung sind, wie in
der [etracker-Dokumentation](https://www.etracker.com/docs/integration-setup/tracking-code-sdks/tracking-code-integration/onsite-kampagnen/)
beschrieben, "in den Account-Einstellungen unter Einstellungen → Account → Automatische Erfassung → Interne Suche die
Benennung der Suche vorzunehmen". Der Wert für etcc_cmp_onsite ist bei der Contao-Konfiguration zu verwenden.

![docs/03_search_setup.png](docs/03_search_setup.png)

### Formulare tracken (zum Teil etracker Pro oder Enterprise)
Die Messung von Formular-Aufrufen und -Absendungen ist mit allen etracker-Accounts möglich.

Um die Formularanalyse zu verwenden, kann bei jedem Formular die entsprechende Option aktiviert werden. Ein abweichender
Formularname, der in etracker verwendet werden soll, kann festgelegtwerden - ansonsten wird die Titel-Angabe verwendet.

Für die detailierte Formularanalyse (etwa die Auswertung von Formularfeldern) ist etracker Pro oder Enterprise
erforderlich. Für diese lässt sich bei jedem Formularfeld eine "Sektion" festlegen, ansonsten wird der Wert "Standard" 
verwendet. Dies ist beispielsweise bei Formularen mit mehreren Bereichen möglich - eine automatische Erkennung über die 
Fieldsets ist (zumindest derzeit) nicht möglich. Für jedes Feld lässt sich auch eine für etracker abweichende Bezeichnung 
nutzen bzw. ein kompletter Ausschluss des Feldes festlegen.

*Hinweis:* Für eine möglichst genaue Messung der Formular-Felder wird für jedes Feld ein Event ausgelöst, sobald
es sichtbar wird. Bei Formularen mit vielen Feldern kann dies u. U. zu einer hohen Anzahl an "Hits" führen.

### Ereignis-Tracking

Der etracker tag manager unterstützt mittlerweile eine gute Konfiguration von Ereignissen. Da manche Ereignisse aber 
u. U. nicht via JavaScripts erkannt werden können oder einige Contao-spezifische Ereignisse über die Erweiterung
schneller konfiguriert werden können (auch Startpunkt-abhängig), bietet die Erweiterung ein Ereignis-Tracking mit
Vorlagen an. Abgedeckt werden damit:

* Klick auf E-Mail-Adressen (mailto-Links)
* Klick auf Telefonnummern (tel-Links)
* Ausklappen eines Accordion-Elements
* Klick auf Galerie-Bild zur Vergrößerung
* Datei-Download
* Sprachwechsel (bei Standard-Template von contao-changelanguage)
* erfolgreiche Logins
* fehlgeschlagene Logins
* Logouts
* Benutzer-Registrierungen

Für die schnelle Konfiguration sind jedoch Texte als Vorlage vorausgefühllt. Das Event-Objekt ist abhängig von der
gewählten Vorlage hinterlegt und eingeschränkt, kann aber auch mit einem eigenen Textwert konfiguriert werden.
Darüber hinaus sind benutzerdefinierte Ereignisse (nur click-Trigger) auch über die Contao-Oberfläche wähbar.

**Hinweis:** Das Anlegen der Ereignisse erfolgt zunächst im Menüpunkt `etracker Events`. Die einzelnen Ereignisse müssen
anschließend auf Root-Ebene (Startpunkt einer Website) explizit aktiviert werden. Dadurch ist es möglich, dasselbe Event
mit unterschiedlichen Werten je Root-Ebene zu nutzen.

## Nutzung im Contao Cookiebar
etracker bietet zwar einen [Cookie-Consent-Manager](https://www.etracker.com/consent-manager/), doch in etracker Basic
ist damit nur der etracker-Dienst abgedeckt. Bei Nutzung weiterer Dienste ist entweder etracker Pro oder Enterprise
erforderlich oder die [Cookiebar-Erweiterung von Oveleon](https://github.com/oveleon/contao-cookiebar) empfehlenswert.

Hier sollte jedoch nicht der etracker-Typ gewählt werden, da der Trackingcode damit doppelt ausgeliefert würde. 
Stattdessen sollte der Typ "benutzerdefiniertes Script" gewählt werden. Der Code für die Cookiebar kann dann wie 
folgt aussehen:

```js
var _etrackerOnReady = typeof _etrackerOnReady === 'undefined' ? [] : _etrackerOnReady;
_etrackerOnReady.push(function(){ _etracker.enableCookies() });
```

Ein besseres Zusammenspiel mit der Contao Cookiebar ist in Planung, aber noch nicht umgesetzt.

## CSP-Header für etracker

Seit Contao 5.13 können die CSP-Header direkt im Backend aktiviert werden. Dies empfiehlt sich, da Contao so auch 
die Nonce für die Skripte generiert. So kann auf die CSP-Direktive 'unsafe-inline' verzichtet werden.

```
Header set Content-Security-Policy "script-src 'self' https://*.etracker.com https://*.etracker.de; connect-src https://*.etracker.de"
```

Bei Verwendung der Scrollmap sollte zudem noch das Einbetten in einen iframe erlaubt werden:

```
Header set Content-Security-Policy "frame-ancestors https://*.etracker.com; script-src 'self' https://*.etracker.com https://*.etracker.de; connect-src https://*.etracker.de"
```

## Disclaimer
etracker und das etracker Logo sind Eigentum der etracker GmbH. Die etracker-Integration in Contao ist eine eigene,
inoffizielle Erweiterung.

[^1]: Dies ist ein Partnerlink. Wenn du über diesen Link ein etracker-Konto erstellst und etracker abonnierst, erhält
Xenbyte eine Provision. Für dich entstehen dadurch keine zusätzlichen Kosten.
