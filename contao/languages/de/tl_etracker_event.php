<?php

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2025 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    LGPL-3.0-or-later
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

// legends
$GLOBALS['TL_LANG']['tl_etracker_event']['title_legend'] = 'etracker Ereignis-Konfiguration';

// fields
$GLOBALS['TL_LANG']['tl_etracker_event']['title'] = ['Titel', 'Bezeichner für die interne Zuordnung, nur in Contao'];
$GLOBALS['TL_LANG']['tl_etracker_event']['selector'] = ['CSS-Selektor', 'z. B. a[href=^tel:]'];
$GLOBALS['TL_LANG']['tl_etracker_event']['object'] = ['Event-Objekt', 'zu verwendener Wert für das Objekt'];
$GLOBALS['TL_LANG']['tl_etracker_event']['category'] = ['Event-Kategorie', 'Kategorie zur Klassifizierung in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_event']['action'] = ['Event-Aktion', 'Aktion für Klassifizierung in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_event']['type'] = ['Event-Typ', 'Typ für Klassifizierung in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_event']['event'] = ['Ereignis', 'Ereignis-Vorlage und benutzerdefiniertes Ereignis'];
$GLOBALS['TL_LANG']['tl_etracker_event']['target_modules'] = ['Ziel-Module', 'bestimmte Module, die dieses Ereignis auslösen können'];
$GLOBALS['TL_LANG']['tl_etracker_event']['event']['options'] = [
    EtrackerEventsModel::EVT_MAIL => 'Klick auf E-Mail-Link (mailto:)',
    EtrackerEventsModel::EVT_PHONE => 'Klick auf Rufnummer-Link (tel:)',
    EtrackerEventsModel::EVT_GALLERY => 'Klick auf Galerie-Bild zur Vergrößerung',
    EtrackerEventsModel::EVT_DOWNLOAD => 'Datei-Download',
    EtrackerEventsModel::EVT_ACCORDION => 'Ausklappen eines Accordion-Elements',
    EtrackerEventsModel::EVT_LANGUAGE => 'Sprachwechsel (contao-changelanguage)',
    EtrackerEventsModel::EVT_CUSTOM => 'benutzerdefiniertes Ereignis',
    EtrackerEventsModel::EVT_LOGIN_SUCCESS => 'Erfolgreicher Login',
    EtrackerEventsModel::EVT_LOGIN_FAILURE => 'Fehlgeschlagener Login',
    EtrackerEventsModel::EVT_USER_REGISTRATION => 'Benutzerregistrierung',
    EtrackerEventsModel::EVT_LOGOUT => 'Logout',
];
$GLOBALS['TL_LANG']['tl_etracker_event']['object_text'] = ['Objektbezeichnung','Objekt zur Klassifizierung in etracker (benutzerdefinierter Text)'];
$GLOBALS['TL_LANG']['tl_etracker_event']['object']['options'] = [
    EtrackerEventsModel::OBJ_MODULE_TITLE => 'Name des Moduls',
    EtrackerEventsModel::OBJ_CUSTOM_TEXT  => 'benutzerdefinierter Text',
    EtrackerEventsModel::OBJ_TEXTCONTENT => 'textContent-Eigenschaft',
    EtrackerEventsModel::OBJ_INNERTEXT => 'innerText-Eigenschaft',
    EtrackerEventsModel::OBJ_TEXT_HREF_FALLBACK => 'textContent-Eigenschaft mit href-Fallback',
    EtrackerEventsModel::OBJ_TEXT_HREFLANG_FALLBACK => 'textContent-Eigenschaft mit hreflang-Fallback',
    EtrackerEventsModel::OBJ_TEXT_WIHOUT_CHILDS => 'textContent-Eigenschaft ohne Child-Nodes',
    EtrackerEventsModel::OBJ_ALT         => 'alt-Attribut',
    EtrackerEventsModel::OBJ_SRC         => 'src-Attribut',
    EtrackerEventsModel::OBJ_HREF        => 'href-Attribut',
    EtrackerEventsModel::OBJ_TITLE       => 'title-Attribut',
];
