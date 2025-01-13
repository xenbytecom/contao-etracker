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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

PaletteManipulator::create()
    ->addLegend('etracker_legend', 'template_legend')
    ->addField(['etrackerIgnoreField'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['etrackerFormSection'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['etrackerFormFieldname'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('text', 'tl_form_field')
    ->applyToPalette('textdigit', 'tl_form_field')
    ->applyToPalette('textcustom', 'tl_form_field')
    ->applyToPalette('password', 'tl_form_field')
    ->applyToPalette('passwordcustom', 'tl_form_field')
    ->applyToPalette('textarea', 'tl_form_field')
    ->applyToPalette('textareacustom', 'tl_form_field')
    ->applyToPalette('select', 'tl_form_field')
    ->applyToPalette('radio', 'tl_form_field')
    ->applyToPalette('checkbox', 'tl_form_field')
    ->applyToPalette('upload', 'tl_form_field')
    ->applyToPalette('range', 'tl_form_field')
    ->applyToPalette('captcha', 'tl_form_field')
;

$GLOBALS['TL_DCA']['tl_form_field']['fields']['etrackerIgnoreField'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['etrackerFormFieldname'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['etrackerFormSection'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
