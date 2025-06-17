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

$GLOBALS['TL_LANG']['tl_module']['etracker_legend'] = 'etracker';

// fields
$GLOBALS['TL_LANG']['tl_module']['etrackerSearchCampaignEnable'] = ['etracker aktivieren', 'Interne Suche via etracker tracken, erfordert etracker Pro oder Enterprise'];
$GLOBALS['TL_LANG']['tl_module']['etrackerSearchMedOnsite'] = ['Onsite-Medium', 'Bezeichnung für Onsite Medium wie in etracker konfiguriert'];
$GLOBALS['TL_LANG']['tl_module']['etrackerSearchCmpOnsiteResults'] = ['Onsite-Kampagne (mit Ergebnis)', 'Kampagnenname für Suche mit Ergebnis'];
$GLOBALS['TL_LANG']['tl_module']['etrackerSearchCmpOnsiteNoresults'] = ['Onsite-Kampagne (ohne Ergebnis)', 'Kampagnename für Suche ohne Ergebnis'];
$GLOBALS['TL_LANG']['tl_module']['etracker_track_login'] = ['Logins tracken', 'wenn aktiviert, werden erfolgreiche und fehlerhafte Login-Ereignisse an etracker gesendet.'];
$GLOBALS['TL_LANG']['tl_module']['etracker_track_registration'] = ['Registrierungen tracken', 'wenn aktiviert, werden Benutzer-Registrierungen an etracker gesendet.'];
