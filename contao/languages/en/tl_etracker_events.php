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
$GLOBALS['TL_LANG']['tl_etracker_event']['title_legend'] = 'etracker event configuration';

// fields
$GLOBALS['TL_LANG']['tl_etracker_event']['title'] = ['Titel', 'Identifier for the internal assignment, only in Contao'];
$GLOBALS['TL_LANG']['tl_etracker_event']['selector'] = ['CSS selektor', 'e. g. a[href=^tel:]'];
$GLOBALS['TL_LANG']['tl_etracker_event']['object'] = ['Event objekt', 'value to be used for the object'];
$GLOBALS['TL_LANG']['tl_etracker_event']['category'] = ['Event category', 'category for classification in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_event']['action'] = ['Event action', 'action for classification in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_event']['type'] = ['Event type', 'type for classification in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_event']['event'] = ['Event', 'Event template or custom event'];
$GLOBALS['TL_LANG']['tl_etracker_event']['target_modules'] = ['Target modules', 'Modules that should be tracked with this event'];
$GLOBALS['TL_LANG']['tl_etracker_event']['event']['options'] = [
    EtrackerEventsModel::EVT_MAIL => 'Click on e-mail link (mailto:)',
    EtrackerEventsModel::EVT_PHONE => 'Click on phone number link (tel:)',
    EtrackerEventsModel::EVT_GALLERY => 'Click on gallery image to enlarge',
    EtrackerEventsModel::EVT_DOWNLOAD => 'File download',
    EtrackerEventsModel::EVT_ACCORDION => 'Expanding an accordion element',
    EtrackerEventsModel::EVT_LANGUAGE => 'Language change (contao-changelanguage)',
    EtrackerEventsModel::EVT_CUSTOM => 'custom event',
    EtrackerEventsModel::EVT_LOGIN_SUCCESS => 'Successful login',
    EtrackerEventsModel::EVT_LOGIN_FAILURE => 'Failed login',
    EtrackerEventsModel::EVT_USER_REGISTRATION => 'User registration',
    EtrackerEventsModel::EVT_LOGOUT => 'Logout',
];
$GLOBALS['TL_LANG']['tl_etracker_event']['object_text'] = ['Object description','object for classification in etracker (custom text)'];
$GLOBALS['TL_LANG']['tl_etracker_event']['object']['options'] = [
    EtrackerEventsModel::OBJ_MODULE_NAME            => 'Name of the module',
    EtrackerEventsModel::OBJ_CUSTOM_TEXT            => 'custom text',
    EtrackerEventsModel::OBJ_TEXTCONTENT            => 'textContent property',
    EtrackerEventsModel::OBJ_INNERTEXT              => 'innerText property',
    EtrackerEventsModel::OBJ_TEXT_HREF_FALLBACK     => 'textContent property with href fallback',
    EtrackerEventsModel::OBJ_TEXT_HREFLANG_FALLBACK => 'textContent property with hreflang fallback',
    EtrackerEventsModel::OBJ_TEXT_WIHOUT_CHILDS     => 'textContent property without child elements',
    EtrackerEventsModel::OBJ_ALT                    => 'alt attribute',
    EtrackerEventsModel::OBJ_SRC                    => 'src attribute',
    EtrackerEventsModel::OBJ_HREF                   => 'href attribute',
    EtrackerEventsModel::OBJ_TITLE                  => 'title attribute',
];

