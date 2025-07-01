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

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchCampaignEnable'] = [
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
    ],
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchMedOnsite'] = [
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w500 clr',
        'mandatory' => true,
        'maxlength' => 50,
    ],
    'sql' => 'varchar(50) NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchCmpOnsiteResults'] = [
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'mandatory' => true,
        'maxlength' => 50,
    ],
    'sql' => 'varchar(50) NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchCmpOnsiteNoresults'] = [
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'mandatory' => true,
        'maxlength' => 50,
    ],
    'sql' => 'varchar(50) NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerTrackRegistration'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerTrackLogin'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12'],
    'sql' => "char(1) NOT NULL default ''",
];

// Palette for Login Module
PaletteManipulator::create()
    ->addLegend('etracker_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE, true)
    ->addField(['etrackerTrackLogin'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('login', 'tl_module') // Nur auf Module vom Typ 'login' anwenden
;

// Palette for Registration Module
PaletteManipulator::create()
    ->addLegend('etracker_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE, true)
    ->addField(['etrackerTrackRegistration'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('registration', 'tl_module') // Nur auf Module vom Typ 'login' anwenden
;

// Palettes for Search Module
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'etrackerSearchCampaignEnable';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['etrackerSearchCampaignEnable'] = 'etrackerSearchMedOnsite,etrackerSearchCmpOnsiteResults,etrackerSearchCmpOnsiteNoresults';

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'config_legend')
    ->addField(['etrackerSearchCampaignEnable'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('search', 'tl_module')
;
