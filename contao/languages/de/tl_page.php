<?php

declare(strict_types=1);

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2025 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$GLOBALS['TL_LANG']['tl_page']['etracker_legend'] = 'etracker';

// fields
$GLOBALS['TL_LANG']['tl_page']['etrackerEnable'] = ['etracker aktivieren', 'aktiviert die etracker-Einbindung'];
$GLOBALS['TL_LANG']['tl_page']['etrackerAreaname'] = ['Bereich-Name', 'Bereich, der für et_areas an Unterseiten weitergegeben werden (sonst Seitenname oder Seitentitel, falls keine Website-Startseite)'];
$GLOBALS['TL_LANG']['tl_page']['etrackerAreas'] = ['Bereiche', 'Überschreibt die generierte Bereichshierarchie; durch "/" getrennte Bereiche, max. 5 Ebenen'];
$GLOBALS['TL_LANG']['tl_page']['etrackerCDIFEUser'] = ['Cross-Device-Tracking von Frontend-Benutzern', 'erlaubt die Übergabe des md5-Hashes des Benutzernamens als et_cdi-Wert für das Cross-Device-Tracking'];
$GLOBALS['TL_LANG']['tl_page']['etrackerDebug'] = ['Debug mode', 'aktiviert den Debug-Modus, erfordert aktivierten etracker'];
$GLOBALS['TL_LANG']['tl_page']['etrackerCookieless'] = ['Cookie-less Tracking', 'Tracking ohne Cookies'];
$GLOBALS['TL_LANG']['tl_page']['etrackerTrackingDomain'] = ['Eigene Tracking-Domain', 'nur nach Einrichtung einer eigenen, abweichendenen <a href="https://www.etracker.com/docs/integration-setup/tracking-code-sdks/eigene-tracking-domain-einrichten/" target="_blank"> Tracking-Domain</a> eintragen'];
$GLOBALS['TL_LANG']['tl_page']['etrackerAccountKey'] = ['Schlüssel', 'etracker Account-Schlüssel'];
$GLOBALS['TL_LANG']['tl_page']['etrackerDomain'] = ['Haupt-Domain', 'in etracker hinterlegte Haupt-Domain, benötigt für Zählungsausschluss (OptOut)'];
$GLOBALS['TL_LANG']['tl_page']['etrackerPagename'] = ['Seitenname', 'Seitenname überschreiben, ansonsten Seitentitel'];
$GLOBALS['TL_LANG']['tl_page']['etrackerDoNotTrack'] = ['Do Not Track (DNT) berücksichtigen', 'die Beachtung ist freiwilig und nicht für den datenschutzkonformen Einsatz erforderlich'];
$GLOBALS['TL_LANG']['tl_page']['etrackerExcludeFEUser'] = ['Frontend-Benutzer ausschließen', 'bei Aktivierung wird etracker nicht bei eingeloggten Mitgliedern im Frontend verwendet (auch kein debug mode)'];
$GLOBALS['TL_LANG']['tl_page']['etrackerExcludeBEUser'] = ['Backend-Benutzer ausschließen', 'bei Aktivierung wird etracker nicht bei eingeloggten Benutzern im Backend verwendet (auch kein debug mode)'];
$GLOBALS['TL_LANG']['tl_page']['etrackerEvents'] = ['etracker Event-Tracking', 'Auswahl, welche angelegten Ereignisse getrackt werden sollen'];
$GLOBALS['TL_LANG']['tl_page']['etrackerOnlyPublished'] = ['Nur veröffentlichte Seiten', 'nur veröffentlichte Seiten werden getrackt'];

// options
$GLOBALS['TL_LANG']['tl_page']['etrackerDebug']['options']['enabled'] = 'aktiviert';
$GLOBALS['TL_LANG']['tl_page']['etrackerDebug']['options']['backend-user'] = 'nur Backend-Benutzer';
$GLOBALS['TL_LANG']['tl_page']['etrackerDebug']['options']['disabled'] = 'deaktiviert';
