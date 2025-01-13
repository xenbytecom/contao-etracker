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

// legends
$GLOBALS['TL_LANG']['tl_form']['etracker_legend'] = 'etracker';

// fields
$GLOBALS['TL_LANG']['tl_form']['etrackerFormTracking'] = ['Form tracking', 'if activated, events are sent for the form analysis'];
$GLOBALS['TL_LANG']['tl_form']['etrackerFormName'] = ['deviating form name', 'to identify the form in etracker, if different from the title'];
