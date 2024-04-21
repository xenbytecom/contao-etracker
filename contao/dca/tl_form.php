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

// $GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'addEtracker';

// $GLOBALS['TL_DCA']['tl_page']['palettes']['root'] =  str_replace('{global_legend:hide}', '{canonical_legend:hide},{etracker_legend},et_account_key,et_optimiser,et_nojquery,et_donottrack,et_exclude_feuser,et_exclude_beuser,et_pagename   ;{global_legend:hide}', $GLOBALS['TL_DCA']['tl_page']['palettes']['root']);

// $GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] =  str_replace('{tabnav_legend:hide}', '{tabnav_legend:hide},{etracker_legend},et_pagename,et_areas;{global_legend:hide}', $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']);

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'template_legend')
    ->addField(['et_form_tracking'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_form_name'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_form')
;

$GLOBALS['TL_DCA']['tl_form']['fields']['et_form_tracking'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form']['et_form_tracking'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_form']['fields']['et_form_name'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form']['et_form_name'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 50,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
