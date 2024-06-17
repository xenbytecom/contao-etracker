<?php

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2024 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    LGPL-3.0-or-later
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

// legends
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

$GLOBALS['TL_LANG']['tl_etracker_events']['title_legend'] = 'etracker Ereignis-Konfiguration';

// fields
$GLOBALS['TL_LANG']['tl_etracker_events']['title'] = ['Titel', 'Bezeichner für die interne Zuordnung, nur in Contao'];
$GLOBALS['TL_LANG']['tl_etracker_events']['selector'] = ['CSS-Selektor', 'z. B. a[href=^tel:]'];
$GLOBALS['TL_LANG']['tl_etracker_events']['object'] = ['Event-Objekt', 'zu verwendener Wert für das Objekt'];
$GLOBALS['TL_LANG']['tl_etracker_events']['category'] = ['Event-Kategorie'];
$GLOBALS['TL_LANG']['tl_etracker_events']['action'] = ['Event-Aktion', 'nur für Klassifizierung in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_events']['type'] = ['Event-Typ', 'nur für Klassifizierung in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_events']['event'] = ['Ereignis', 'Ereignis-Vorlage und benutzerdefiniertes Ereignis'];
$GLOBALS['TL_LANG']['tl_etracker_events']['event']['options'] = [
    EtrackerEventsModel::EVT_MAIL => 'Klick auf E-Mail-Link (mailto:)',
    EtrackerEventsModel::EVT_PHONE => 'Klick auf Rufnummer-Link (tel:)',
    EtrackerEventsModel::EVT_GALLERY => 'Klick auf Galerie-Bild zur Vergrößerung',
    EtrackerEventsModel::EVT_DOWNLOAD => 'Datei-Download',
    EtrackerEventsModel::EVT_ACCORDION => 'Ausklappen eines Accordion-Elements',
    EtrackerEventsModel::EVT_LANGUAGE => 'Sprachwechsel (contao-changelanguage)',
    EtrackerEventsModel::EVT_CUSTOM => 'benutzerdefiniertes Ereignis',
];
