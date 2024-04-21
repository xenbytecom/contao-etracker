<?php

/*
 * Contao Etracker Bundle
 *
 * (c) Xenbyte, Stefan Brauner <info@xenbyte.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

// legends
$GLOBALS['TL_LANG']['tl_page']['etracker_legend'] = 'etracker';

// fields
// $GLOBALS['TL_LANG']['tl_page']['et_rootpage_area'] = ['Bereich-Name', 'optionaler Name der obersten Ebene, z. B. Länder-Code für mehrsprachige Seite'];
$GLOBALS['TL_LANG']['tl_page']['et_area'] = ['Bereich-Name', 'Name des aktuellen Bereichs, der für et_areas an untergeordnete Seiten weitergegeben werden (sonst Seitenname oder Seitentitel)'];
$GLOBALS['TL_LANG']['tl_page']['et_areas'] = ['Bereiche', 'Überschreibt die generierte Bereichshierarchie; durch "/" getrennte Bereiche, max. 5 Ebenen'];
$GLOBALS['TL_LANG']['tl_page']['et_cdi_feuser'] = ['Cross-Device-Tracking von Frontend-Benutzern', 'erlaubt die Übergabe des md5-Hashes des Benutzernamens als et_cdi-Wert für das Cross-Device-Tracking'];
$GLOBALS['TL_LANG']['tl_page']['et_active'] = ['etracker aktivieren', 'aktiviert die etracker-Einbindung'];
$GLOBALS['TL_LANG']['tl_page']['et_debug'] = ['Debug mode', 'aktiviert den Debug-Modus, erfordert aktivierten etracker'];
$GLOBALS['TL_LANG']['tl_page']['et_cookieless'] = ['Cookie-less Tracking', 'Tracking ohne Cookies'];
$GLOBALS['TL_LANG']['tl_page']['et_tracking_domain'] = ['Eigene Tracking-Domain', 'Nutzung einer <a href="https://www.etracker.com/docs/integration-setup/tracking-code-sdks/eigene-tracking-domain-einrichten/" target="_blank">Tracking-Domain</a>'];
$GLOBALS['TL_LANG']['tl_page']['et_account_key'] = ['Schlüssel', 'etracker Account-Schlüssel'];
$GLOBALS['TL_LANG']['tl_page']['et_domain'] = ['Haupt-Domain', 'in etracker hinterlegte Haupt-Domain, benötigt für Zählungsausschluss'];
$GLOBALS['TL_LANG']['tl_page']['et_optimiser'] = ['Optimiser', 'Nutzung des Add-ons etracker Optimiser'];
$GLOBALS['TL_LANG']['tl_page']['et_pagename'] = ['Seitenname', 'Seitenname überschreiben, ansonsten Seitentitel'];
$GLOBALS['TL_LANG']['tl_page']['et_nojquery'] = ['jQuery deaktivieren', 'nur dann sinnvoll, wenn ohnehin jQuery geladen wird, da sonst Smart Messages und A/B-Tests nicht ausgespielt werden können.'];
$GLOBALS['TL_LANG']['tl_page']['et_donottrack'] = ['Do Not Track (DNT) berücksichtigen', 'die Beachtung ist freiwilig und nicht für den datenschutzkonformen Einsatz erforderlich'];
$GLOBALS['TL_LANG']['tl_page']['et_exclude_feuser'] = ['Frontend-Benutzer ausschließen', 'bei Aktivierung wird etracker nicht bei eingeloggten Benutzern im Frontend verwendet'];
$GLOBALS['TL_LANG']['tl_page']['et_exclude_beuser'] = ['Backend-Benutzer ausschließen', 'bei Aktivierung wird etracker nicht bei eingeloggten Benutzern im Backend verwendet'];

// options
$GLOBALS['TL_LANG']['tl_page']['et_debug']['options']['enabled'] = 'aktiviert';
$GLOBALS['TL_LANG']['tl_page']['et_debug']['options']['backend-user'] = 'nur Backend-Benutzer';
$GLOBALS['TL_LANG']['tl_page']['et_debug']['options']['disabled'] = 'deaktiviert';
