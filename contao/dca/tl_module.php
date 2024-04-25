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
use Xenbyte\ContaoEtracker\Controller\FrontendModule\EtrackerOptoutController;

// Palette for etracker Optout Module
$GLOBALS['TL_DCA']['tl_module']['palettes'][EtrackerOptoutController::TYPE] = '{title_legend},name,headline,type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

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
        'tl_class'       => 'clr'
    ],
    'sql'       => [
        'type'    => 'boolean',
        'default' => false,
    ],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchMedOnsite'] = [
    'inputType' => 'text',
    'eval'      => [
        'tl_class'  => 'w50',
        'maxlength' => 50,
    ],
    'sql'       => 'varchar(50) NULL default NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchCmpOnsiteResults'] = [
    'inputType' => 'text',
    'eval'      => [
        'tl_class'  => 'w50',
        'maxlength' => 50,
    ],
    'sql'       => 'varchar(50) NULL default \'mit Ergebnis\'',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['etrackerSearchCmpOnsiteNoresults'] = [
    'inputType' => 'text',
    'eval'      => [
        'tl_class'  => 'w50',
        'maxlength' => 50,
    ],
    'sql'       => 'varchar(50) NULL default \'ohne Ergebnis\'',
];
