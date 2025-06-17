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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

// Palettes
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'etrackerEnable';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['etrackerEnable'] = 'etrackerAccountKey,etrackerDomain,etrackerTrackingDomain,etrackerDebug,etrackerAreaname,etrackerDoNotTrack,etrackerExcludeFEUser,etrackerExcludeBEUser,etrackerCDIFEUser,etrackerEvents';

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'meta_legend')
    ->addField(['etrackerEnable'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
    ->applyToPalette('rootfallback', 'tl_page')
;

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'meta_legend')
    ->addField(['etrackerPagename'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['etrackerAreaname'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['etrackerAreas'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('regular', 'tl_page')
;

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'meta_legend')
    ->addField(['etrackerPagename'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['etrackerAreas'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('error_401', 'tl_page')
    ->applyToPalette('error_403', 'tl_page')
    ->applyToPalette('error_404', 'tl_page')
    ->applyToPalette('error_503', 'tl_page')
;

$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerEnable'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'cbx',
        'submitOnChange' => true,
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerAccountKey'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
        'mandatory' => true,
    ],
    'sql' => 'varchar(16) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerDomain'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 50,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerTrackingDomain'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 50,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerCookieless'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 cbx m12',
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => true,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerDebug'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'options' => ['enabled', 'backend-user', 'disabled'],
    'reference' => &$GLOBALS['TL_LANG']['tl_page']['etrackerDebug']['options'],
    'sql' => 'varchar(15) NOT NULL default \'disabled\'',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerPagename'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 255,
    ],
    'sql' => 'varchar(255) NULL default NULL',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerAreaname'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 50,
    ],
    'sql' => 'varchar(50) NULL default NULL',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerAreas'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 255,
    ],
    'sql' => 'varchar(255) NULL default NULL',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerDoNotTrack'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 cbx',
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerExcludeFEUser'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 cbx',
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerExcludeBEUser'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 cbx',
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => true,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerCDIFEUser'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 cbx',
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerEvents'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 cbx',
        'multiple' => true,
    ],
    'foreignKey' => 'tl_etracker_event.title',
    'sql' => [
        'type' => 'blob',
        'notnull' => false,
    ],
    'relation' => [
        'type' => 'hasMany',
        'load' => 'lazy',
    ],
];
