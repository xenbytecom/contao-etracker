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

use Contao\DataContainer;
use Contao\DC_Table;
use Xenbyte\ContaoEtracker\EventListener\DataContainer\EtrackerEventDcaHelper;
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
                EtrackerEventsModel::EVT_LOGIN_SUCCESS,
                EtrackerEventsModel::EVT_LOGIN_FAILURE,
                EtrackerEventsModel::EVT_USER_REGISTRATION,
                EtrackerEventsModel::EVT_LOGOUT,
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
            'default' => EtrackerEventsModel::OBJ_TEXTCONTENT,
            'options_callback' => [EtrackerEventDcaHelper::class, 'getObjectOptions'],
            'reference' => &$GLOBALS['TL_LANG']['tl_etracker_event']['object']['options'],
            'eval' => [
                'mandatory' => true,
                'submitOnChange' => true,
                'tl_class' => 'w50',
            ],
            'sql' => [
                'type' => 'integer',
                'notnull' => true,
                'default' => EtrackerEventsModel::OBJ_TEXTCONTENT,
            ],
        ],
        'object_text' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'maxlength' => 100,
                'tl_class' => 'w50',
                'placeholder' => 'z. B. User Login',
            ],
            'sql' => "varchar(100) NOT NULL default ''",
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
        'target_modules' => [
            'exclude' => true,
            'inputType' => 'checkbox',
            'options_callback' => [EtrackerEventDcaHelper::class, 'getModuleOptions',
            ],
            'eval' => [
                'multiple' => true,
                'mandatory' => false,
                'tl_class' => 'clr',
            ],
            'sql' => 'blob NULL',
        ],
    ],

    // Palettes
    'palettes' => [
        '__selector__' => ['event', 'object'],
        'default' => '{title_legend},title,event;object,category,action,type;',
    ],
    'subpalettes' => [
        'event_'.EtrackerEventsModel::EVT_CUSTOM => 'selector',
        // Subpaletten für modulbasierte Events
        'event_'.EtrackerEventsModel::EVT_LOGIN_SUCCESS => 'target_modules',
        'event_'.EtrackerEventsModel::EVT_LOGIN_FAILURE => 'target_modules',
        'event_'.EtrackerEventsModel::EVT_USER_REGISTRATION => 'target_modules',
        'object_'.EtrackerEventsModel::OBJ_CUSTOM_TEXT => 'object_text',
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
                'href' => 'act=copy',
                'icon' => 'copy.svg',
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
