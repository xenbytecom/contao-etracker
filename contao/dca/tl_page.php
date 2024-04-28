<?php

/*
 * etracker Plugin for Contao
 *
 * (c) Xenbyte, Stefan Brauner <info@xenbyte.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

// Palettes
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'etrackerEnable';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['etrackerEnable'] = 'etrackerAccountKey,etrackerDomain,etrackerTrackingDomain,etrackerDebug,etrackerOptimiser,etrackerAreaname,etrackerDoNotTrack,etrackerNoJquery,etrackerExcludeFEUser,etrackerExcludeBEUser,etrackerCDIFEUser';

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'meta_legend')
    ->addField(['etrackerEnable'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerOptimizer'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerAccountKey'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerDebug'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerDomain'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerArea'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerDoNotTrack'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerNoJquery'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerExcludeFEUser'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerExcludeBEUser'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
//    ->addField(['etrackerCDIFEUser'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
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
    ],
    'sql' => 'varchar(16) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerOptimiser'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 cbx m12',
    ],
    'sql' => 'char(1) NOT NULL default 0',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerDomain'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerTrackingDomain'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
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
$GLOBALS['TL_DCA']['tl_page']['fields']['etrackerNoJquery'] = [
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
