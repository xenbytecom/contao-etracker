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

$GLOBALS['TL_DCA']['tl_form']['palettes']['__selector__'][] = 'etrackerFormTracking';
$GLOBALS['TL_DCA']['tl_form']['subpalettes']['etrackerFormTracking'] = 'etrackerFormName';

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'template_legend')
    ->addField(['etrackerFormTracking'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_form')
;

$GLOBALS['TL_DCA']['tl_form']['fields']['etrackerFormTracking'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50', 'submitOnChange' => true],
    'toggle' => true,
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_form']['fields']['etrackerFormName'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'w50', 'maxlength' => 50],
    'sql' => [
        'type' => 'text',
        'length' => 50,
        'default' => '',
    ],
];
