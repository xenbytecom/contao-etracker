<?php

/*
 * etracker integration for Contao CMS
 *
 * Copyright (c) 2024 Xenbyte, Stefan Brauner
 *
 * @author     Stefan Brauner <https://www.xenbyte.com>
 * @link       https://github.com/xenbytecom/contao-etracker
 * @license    LGPL-3.0-or-later
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Xenbyte\ContaoEtracker\Controller\ContentElement\EtrackerOptoutController;

// Palette for etracker Optout Module
$GLOBALS['TL_DCA']['tl_content']['palettes'][EtrackerOptoutController::TYPE] = '{type_legend},type,headline,etrackerOptOutType;{template_legend:hide},customTpl;{protected_legend:hide},protected;{invisible_legend:hide},invisible,start,stop;';

// Fields for Optout Module
$GLOBALS['TL_DCA']['tl_content']['fields']['etrackerOptOutType'] = [
    'exclude' => true,
    'inputType' => 'radio',
    'eval' => [
        'tl_class' => 'clr w50',
    ],
    'options' => ['text', 'checkbox'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['etrackerOptOutType']['options'],
    'sql' => 'varchar(10) NULL',
];
