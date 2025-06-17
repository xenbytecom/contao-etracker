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

use Xenbyte\ContaoEtracker\Model\EtrackerEventsModel;

// Back end modules
$GLOBALS['BE_MOD']['system']['etracker_events'] = [
    'tables' => [
        'tl_etracker_event',
    ],
];

// Models
$GLOBALS['TL_MODELS']['tl_etracker_event'] = EtrackerEventsModel::class;
