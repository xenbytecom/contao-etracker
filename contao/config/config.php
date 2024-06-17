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

use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

// Back end modules
$GLOBALS['BE_MOD']['system']['etracker-Events'] = [
    'tables' => [
        'tl_etracker_events',
    ],
];

// Models
$GLOBALS['TL_MODELS']['tl_etracker_events'] = EtrackerEventsModel::class;
