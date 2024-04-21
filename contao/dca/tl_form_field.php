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
    ->addLegend('etracker_legend', 'template_legend')
    ->addField(['et_form_fieldname'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['et_form_section'], 'etracker_legend', PaletteManipulator::POSITION_APPEND)
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

$GLOBALS['TL_DCA']['tl_form_field']['fields']['et_field_ignore'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['et_field_ignore'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'sql' => [
        'type' => 'boolean',
        'default' => false,
    ],
];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['et_form_fieldname'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['et_form_fieldname'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['et_form_section'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['et_form_section'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 16,
    ],
    'sql' => 'varchar(50) NOT NULL default \'\'',
];
