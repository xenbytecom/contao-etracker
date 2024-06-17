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

use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

// legends
$GLOBALS['TL_LANG']['tl_etracker_events']['title_legend'] = 'etracker event configuration';

// fields
$GLOBALS['TL_LANG']['tl_etracker_events']['title'] = ['Titel', 'Identifier for the internal assignment, only in Contao'];
$GLOBALS['TL_LANG']['tl_etracker_events']['selector'] = ['CSS selektor', 'e. g. a[href=^tel:]'];
$GLOBALS['TL_LANG']['tl_etracker_events']['object'] = ['Event objekt', 'value to be used for the object'];
$GLOBALS['TL_LANG']['tl_etracker_events']['category'] = ['Event category', 'category for classification in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_events']['action'] = ['Event action', 'action for classification in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_events']['type'] = ['Event type', 'type for classification in etracker'];
$GLOBALS['TL_LANG']['tl_etracker_events']['event'] = ['Event', 'Event template or custom event'];
$GLOBALS['TL_LANG']['tl_etracker_events']['event']['options'] = [
    EtrackerEventsModel::EVT_MAIL => 'Click on e-mail link (mailto:)',
    EtrackerEventsModel::EVT_PHONE => 'Click on phone number link (tel:)',
    EtrackerEventsModel::EVT_GALLERY => 'Click on gallery image to enlarge',
    EtrackerEventsModel::EVT_DOWNLOAD => 'File download',
    EtrackerEventsModel::EVT_ACCORDION => 'Expanding an accordion element',
    EtrackerEventsModel::EVT_LANGUAGE => 'Language change (contao-changelanguage)',
    EtrackerEventsModel::EVT_CUSTOM => 'custom event',
];
