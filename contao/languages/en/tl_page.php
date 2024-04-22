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
$GLOBALS['TL_LANG']['tl_page']['etrackerEnable'] = ['enable etracker', 'enables the etracker integration'];
$GLOBALS['TL_LANG']['tl_page']['et_rootpage_area'] = ['Bereich-Name', 'optionaler Name der obersten Ebene, z. B. Länder-Code für mehrsprachige Seite'];
$GLOBALS['TL_LANG']['tl_page']['et_areas'] = ['Bereiche', 'durch "/" getrennte Bereiche, max. 5 Ebenen'];
$GLOBALS['TL_LANG']['tl_page']['et_debug'] = ['Debug mode', 'enables debug mode'];
$GLOBALS['TL_LANG']['tl_page']['et_account_key'] = ['Schlüssel', 'etracker Account-Schlüssel'];
$GLOBALS['TL_LANG']['tl_page']['et_domain'] = ['Main Domain', 'in etracker added main domain, needed for Opt-out'];
$GLOBALS['TL_LANG']['tl_page']['et_optimiser'] = ['Optimiser', 'Usage of etracker Optimiser add-on'];
$GLOBALS['TL_LANG']['tl_page']['et_pagename'] = ['Seitenname', 'Seitenname überschreiben, ansonsten Seitentitel'];
$GLOBALS['TL_LANG']['tl_page']['et_nojquery'] = ['jQuery deaktivieren', 'nur dann sinnvoll, wenn ohnehin jQuery geladen wird, da sonst Smart Messages und A/B-Tests nicht ausgespielt werden können.'];
$GLOBALS['TL_LANG']['tl_page']['et_donottrack'] = ['Do Not Track (DNT) berücksichtigen', 'die Beachtung ist freiwilig und nicht für den datenschutzkonformen Einsatz erforderlich'];
$GLOBALS['TL_LANG']['tl_page']['et_exclude_feuser'] = ['exclude frontend users', 'bei Aktivierung wird etracker nicht bei eingeloggten Benutzern im Frontend verwendet'];
$GLOBALS['TL_LANG']['tl_page']['et_exclude_beuser'] = ['exclude backend users', 'bei Aktivierung wird etracker nicht bei eingeloggten Benutzern im Backend verwendet'];
