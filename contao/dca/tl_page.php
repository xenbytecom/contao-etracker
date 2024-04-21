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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'meta_legend')
    ->addField(['et_active'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_optimiser'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_account_key'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_debug'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_domain'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_area'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_donottrack'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_nojquery'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_exclude_feuser'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_exclude_beuser'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_cdi_feuser'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
    ->applyToPalette('rootfallback', 'tl_page')
;

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'meta_legend')
    ->addField(['et_pagename'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_area'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_areas'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('regular', 'tl_page')
;

$GLOBALS['TL_DCA']['tl_page']['fields']['et_account_key'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_account_key'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
    ],
    'sql' => 'varchar(16) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['et_optimiser'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_optimiser'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'char(1) NOT NULL default 0',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['et_domain'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_domain'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_tracking_domain'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_tracking_domain'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_active'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_active'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_user_id'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_user_id'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_cookieless'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_cookieless'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => [
        'type' => 'boolean',
        'default' => true,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_debug'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_debug'],
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'options' => ['enabled', 'backend-user', 'disabled'],
    'reference' => &$GLOBALS['TL_LANG']['tl_page']['et_debug']['options'],
    'sql' => 'varchar(15) NOT NULL default \'disabled\'',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_pagename'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_pagename'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'varchar(255) NULL default NULL',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_area'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_area'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'varchar(50) NULL default NULL',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_areas'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_areas'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'varchar(255) NULL default NULL',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_nojquery'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_nojquery'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'char(1) NOT NULL default 0',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_donottrack'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_donottrack'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'char(1) NOT NULL default 0',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_exclude_feuser'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_exclude_feuser'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'char(1) NOT NULL default 0',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['et_exclude_beuser'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_exclude_beuser'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'char(1) NOT NULL default 0',
];
