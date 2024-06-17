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

// legends
$GLOBALS['TL_LANG']['tl_form_field']['etracker_legend'] = 'etracker';

// fields
$GLOBALS['TL_LANG']['tl_form_field']['etrackerFormFieldname'] = ['deviating name', 'Name of the form field (otherwise field description or field name)'];
$GLOBALS['TL_LANG']['tl_form_field']['etrackerFormSection'] = ['Name of the "section"', '(Default: "Standard")'];
$GLOBALS['TL_LANG']['tl_form_field']['etrackerIgnoreField'] = ['Ignore field in etracker analysis'];
