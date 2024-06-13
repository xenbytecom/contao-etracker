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

// Palettes for Search Module
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'etrackerSearchCampaignEnable';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['etrackerSearchCampaignEnable'] = 'etrackerSearchMedOnsite,etrackerSearchCmpOnsiteResults,etrackerSearchCmpOnsiteNoresults';

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'config_legend')
    ->addField(['etrackerSearchCampaignEnable'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('search', 'tl_module');

// Fields for Search Module
$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchCampaignEnable'] = [
    'inputType' => 'checkbox',
    'eval'      => [
        'submitOnChange' => true,
    ],
    'sql'       => [
        'type'    => 'boolean',
        'default' => false,
    ],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchMedOnsite'] = [
    'inputType' => 'text',
    'eval'      => [
        'tl_class'  => 'w500 clr',
        'mandatory' => true,
        'maxlength' => 50,
    ],
    'sql'       => 'varchar(50) NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchCmpOnsiteResults'] = [
    'inputType' => 'text',
    'eval'      => [
        'tl_class'  => 'w50',
        'mandatory' => true,
        'maxlength' => 50,
    ],
    'sql'       => 'varchar(50) NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchCmpOnsiteNoresults'] = [
    'inputType' => 'text',
    'eval'      => [
        'tl_class'  => 'w50',
        'mandatory' => true,
        'maxlength' => 50,
    ],
    'sql'       => 'varchar(50) NULL',
];
