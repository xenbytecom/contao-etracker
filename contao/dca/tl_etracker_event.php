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

use Contao\DataContainer;
use Contao\DC_Table;
use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

$GLOBALS['TL_DCA']['tl_etracker_event'] = [
    // Config
    'config' => [
        'dataContainer' => DC_Table::class,
        'enableVersioning' => true,
        'markAsCopy' => 'title',
        'notEditable' => false,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],

    // Fields
    'fields' => [
        'id' => [
            'sql' => [
                'type' => 'integer',
                'unsigned' => true,
                'autoincrement' => true,
            ],
        ],
        'tstamp' => [
            'sql' => [
                'type' => 'integer',
                'unsigned' => true,
                'default' => 0,
            ],
        ],
        'title' => [
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'maxlength' => 255,
                'tl_class' => 'w50',
            ],
            'sql' => [
                'type' => 'text',
                'length' => 255,
                'default' => '',
            ],
        ],
        'event' => [
            'exclude' => true,
            'inputType' => 'select',
            'options' => [
                EtrackerEventsModel::EVT_MAIL,
                EtrackerEventsModel::EVT_PHONE,
                EtrackerEventsModel::EVT_GALLERY,
                EtrackerEventsModel::EVT_DOWNLOAD,
                EtrackerEventsModel::EVT_ACCORDION,
                EtrackerEventsModel::EVT_LANGUAGE,
                EtrackerEventsModel::EVT_CUSTOM,
            ],
            'reference' => &$GLOBALS['TL_LANG']['tl_etracker_event']['event']['options'],
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50',
                'submitOnChange' => true,
            ],
            'sql' => [
                'type' => 'integer',
                'notnull' => true,
                'default' => EtrackerEventsModel::EVT_CUSTOM,
            ],
        ],
        'selector' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50',
                'maxlength' => 255,
            ],
            'sql' => [
                'type' => 'text',
                'length' => 255,
                'notnull' => false,
            ],
        ],
        'object' => [
            'exclude' => true,
            'inputType' => 'select',
            'default' => EtrackerEventsModel::OBJ_INNERTEXT,
            'options' => [
                EtrackerEventsModel::OBJ_INNERTEXT => 'textContent',
                EtrackerEventsModel::OBJ_ALT => 'alt-Attribut',
                EtrackerEventsModel::OBJ_SRC => 'src-Attribut',
                EtrackerEventsModel::OBJ_HREF => 'href-Attribut',
                EtrackerEventsModel::OBJ_TITLE => 'title-Attribut',
            ],
            'eval' => [
                'mandatory' => true,
                'submitOnChange' => true,
                'tl_class' => 'w50',
            ],
            'sql' => [
                'type' => 'integer',
                'length' => 255,
                'notnull' => true,
                'default' => EtrackerEventsModel::OBJ_INNERTEXT,
            ],
        ],
        'category' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50',
                'maxlength' => 100,
            ],
            'sql' => [
                'type' => 'text',
                'length' => 100,
                'notnull' => true,
                'default' => '',
            ],
        ],
        'action' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'tl_class' => 'w50',
                'maxlength' => 100,
            ],
            'sql' => [
                'type' => 'text',
                'length' => 100,
                'notnull' => false,
            ],
        ],
        'type' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'tl_class' => 'w50',
                'maxlength' => 100,
            ],
            'sql' => [
                'type' => 'text',
                'length' => 100,
                'notnull' => false,
            ],
        ],
    ],

    // Palettes
    'palettes' => [
        '__selector__' => ['event', 'object'],
        'default' => '{title_legend},title,event;category,action,type;',
    ],
    'subpalettes' => [
        'event_99' => 'selector,object',
    ],

    // Listing
    'list' => [
        'sorting' => [
            'mode' => DataContainer::MODE_SORTED,
            'fields' => ['title'],
            'panelLayout' => 'sort,search,limit',
            'flag' => DataContainer::SORT_INITIAL_LETTER_ASC,
        ],
        'label' => [
            'showColumns' => true,
            'fields' => ['title', 'event', 'category', 'action'],
            'format' => '%s',
        ],
        'operations' => [
            'edit' => [
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'copy' => [
                'href'  => 'act=copy',
                'icon'  => 'copy.svg',
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.svg',
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.svg',
            ],
        ],
    ],
];
